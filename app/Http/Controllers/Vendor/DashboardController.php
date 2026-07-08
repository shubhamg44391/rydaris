<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Vendor Dashboard.
     */
    public function index()
    {
        $vendorId = auth()->id();

        // 1. KPI Metrics
        $totalVehicles = \App\Models\Vehicle::where('vendor_id', $vendorId)->count();
        $totalBookings = \App\Models\Booking::where('vendor_id', $vendorId)->count();
        
        $monthlyEarnings = \App\Models\Booking::where('vendor_id', $vendorId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('paid_amount');

        $totalEarnings = \App\Models\Booking::where('vendor_id', $vendorId)->sum('paid_amount');

        // 2. Monthly Revenue Chart (Last 12 Months)
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = \App\Models\Booking::where('vendor_id', $vendorId)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('paid_amount');
            $count = \App\Models\Booking::where('vendor_id', $vendorId)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $monthlyRevenue[] = [
                'month' => $month->format('M'),
                'revenue' => (float)$revenue,
                'count' => $count
            ];
        }

        $maxRevenue = collect($monthlyRevenue)->max('revenue') ?: 1;

        // 3. Recent Bookings / Activities
        $recentBookings = \App\Models\Booking::with('vehicle')
            ->where('vendor_id', $vendorId)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // 4. Fleet transmission distribution
        $automaticCount = \App\Models\Vehicle::where('vendor_id', $vendorId)->where('gear_system', 'Automatic')->count();
        $manualCount = \App\Models\Vehicle::where('vendor_id', $vendorId)->where('gear_system', 'Manual')->count();
        $totalGear = $automaticCount + $manualCount;
        
        $autoPercent = $totalGear > 0 ? round(($automaticCount / $totalGear) * 100) : 50;
        $manualPercent = $totalGear > 0 ? round(($manualCount / $totalGear) * 100) : 50;

        return view('vendor.dashboard', compact(
            'totalVehicles',
            'totalBookings',
            'monthlyEarnings',
            'totalEarnings',
            'monthlyRevenue',
            'maxRevenue',
            'recentBookings',
            'automaticCount',
            'manualCount',
            'autoPercent',
            'manualPercent'
        ));
    }

    public function pricing()
    {
        $packages = \App\Models\Package::orderBy('order', 'asc')->get();
        return view('vendor.pricing.index', compact('packages'));
    }

    public function subscriptionHistory()
    {
        $subscriptions = \App\Models\VendorSubscription::where('vendor_id', auth()->id())
            ->with('package')
            ->latest()
            ->get();
        return view('vendor.pricing.history', compact('subscriptions'));
    }

    public function subscribe(Request $request, $packageId)
    {
        $package = \App\Models\Package::findOrFail($packageId);
        $user = auth()->user();

        // Expire any existing active subscriptions
        \App\Models\VendorSubscription::where('vendor_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        // Create new subscription for 1 month
        \App\Models\VendorSubscription::create([
            'vendor_id' => $user->id,
            'package_id' => $package->id,
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Successfully subscribed to ' . $package->name . ' package.');
    }

    /**
     * Create order for Razorpay subscription checkout.
     */
    public function createOrder(Request $request, $packageId)
    {
        $package = \App\Models\Package::findOrFail($packageId);
        
        // Extract numeric price
        $priceStr = $package->price;
        $price = (float) filter_var($priceStr, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        
        // Add 18% tax
        $totalPrice = $price * 1.18;

        // ── FREE PACKAGE ── Skip Razorpay entirely
        if ($price <= 0) {
            return response()->json([
                'status'           => 'success',
                'mode'             => 'free',
                'amount_formatted' => '0.00',
                'package_name'     => $package->name,
                'package_id'       => $package->id,
            ]);
        }
        
        // Get settings
        $settings = \App\Models\SiteSetting::first();
        
        $isRazorpayActive = $settings && $settings->razorpay_active && !empty($settings->razorpay_key_id) && !empty($settings->razorpay_key_secret);
        
        if ($isRazorpayActive) {
            try {
                // Convert price to paise (cents)
                $amountInPaise = round($totalPrice * 100);
                
                $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                    ->withBasicAuth($settings->razorpay_key_id, $settings->razorpay_key_secret)
                    ->post('https://api.razorpay.com/v1/orders', [
                        'amount'   => $amountInPaise,
                        'currency' => 'INR',
                        'receipt'  => 'rcpt_' . uniqid(),
                    ]);
                
                if ($response->successful()) {
                    $order = $response->json();
                    return response()->json([
                        'status'           => 'success',
                        'mode'             => 'razorpay',
                        'key'              => $settings->razorpay_key_id,
                        'order'            => $order,
                        'amount_formatted' => number_format($totalPrice, 2),
                    ]);
                } else {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Failed to create order on Razorpay: ' . $response->body(),
                    ], 400);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Exception when contacting Razorpay: ' . $e->getMessage(),
                ], 500);
            }
        } else {
            // Mock/Test payment mode
            return response()->json([
                'status'           => 'success',
                'mode'             => 'mock',
                'amount_formatted' => number_format($totalPrice, 2),
                'package_name'     => $package->name,
                'package_id'       => $package->id,
            ]);
        }
    }

    /**
     * Verify payment signature and activate subscription.
     */
    public function verifyPayment(Request $request)
    {
        $mode = $request->input('mode');
        $packageId = $request->input('package_id');
        $package = \App\Models\Package::findOrFail($packageId);
        $user = auth()->user();
        
        // Extract numeric price
        $priceStr = $package->price;
        $price = (float) filter_var($priceStr, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $totalPrice = $price * 1.18;

        if ($mode === 'razorpay') {
            $razorpayOrderId = $request->input('razorpay_order_id');
            $razorpayPaymentId = $request->input('razorpay_payment_id');
            $razorpaySignature = $request->input('razorpay_signature');
            
            $settings = \App\Models\SiteSetting::first();
            $keySecret = $settings ? $settings->razorpay_key_secret : '';
            
            // Signature verification
            $expectedSignature = hash_hmac('sha256', $razorpayOrderId . '|' . $razorpayPaymentId, $keySecret);
            
            if ($expectedSignature !== $razorpaySignature) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment signature verification failed. Please contact support.',
                ], 400);
            }
            
            // Expire any existing active subscriptions for this user/vendor
            \App\Models\VendorSubscription::where('vendor_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'expired']);
                
            // Create subscription
            \App\Models\VendorSubscription::create([
                'vendor_id' => $user->id,
                'package_id' => $package->id,
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
                'status' => 'active',
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId,
                'razorpay_signature' => $razorpaySignature,
                'amount_paid' => $totalPrice,
            ]);
            
            session()->flash('success', 'Payment successful! Successfully subscribed to ' . $package->name . ' package.');
            
            return response()->json([
                'status' => 'success',
                'message' => 'Subscription activated successfully.',
                'redirect_url' => route('vendor.dashboard'),
            ]);
        } elseif ($mode === 'free') {
            // ── FREE PLAN ── No payment needed, record subscription directly
            \App\Models\VendorSubscription::where('vendor_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'expired']);

            \App\Models\VendorSubscription::create([
                'vendor_id'  => $user->id,
                'package_id' => $package->id,
                'starts_at'  => now(),
                'ends_at'    => now()->addMonth(),
                'status'     => 'active',
                'amount_paid' => 0,
            ]);

            session()->flash('success', 'Successfully subscribed to ' . $package->name . ' (Free Plan).');

            return response()->json([
                'status'       => 'success',
                'message'      => 'Free subscription activated successfully.',
                'redirect_url' => route('vendor.dashboard'),
            ]);
        } else {
            // Mock/Test mode
            // Expire any existing active subscriptions for this user/vendor
            \App\Models\VendorSubscription::where('vendor_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'expired']);
                
            // Create subscription
            \App\Models\VendorSubscription::create([
                'vendor_id' => $user->id,
                'package_id' => $package->id,
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
                'status' => 'active',
                'amount_paid' => $totalPrice,
            ]);
            
            session()->flash('success', 'Successfully subscribed to ' . $package->name . ' package in test mode.');
            
            return response()->json([
                'status' => 'success',
                'message' => 'Subscription activated successfully (test mode).',
                'redirect_url' => route('vendor.dashboard'),
            ]);
        }
    }
}
