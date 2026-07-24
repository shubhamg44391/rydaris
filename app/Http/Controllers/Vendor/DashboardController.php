<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    

    public function index(Request $request)
    {
        if (!auth()->user()->activeSubscription) {
            if ($request->session()->has('login_success_preloader')) {
                $request->session()->keep('login_success_preloader');
            }
            return redirect()->route('vendor.pricing')->with('error', 'Please subscribe to a package to access the dashboard.');
        }

        $vendorId = auth()->id();

        
        $range = $request->query('range', '12');
        $startMonthStr = $request->query('start_month');
        $endMonthStr = $request->query('end_month');

        $startDate = null;
        $endDate = null;

        if ($range === 'custom' && $startMonthStr && $endMonthStr) {
            $startDate = \Carbon\Carbon::parse($startMonthStr . '-01')->startOfMonth();
            $endDate = \Carbon\Carbon::parse($endMonthStr . '-01')->endOfMonth();
            
            
            $diffInMonths = $startDate->diffInMonths($endDate);
            if ($diffInMonths > 12) {
                $startDate = (clone $endDate)->subMonths(11)->startOfMonth();
            }
        } else {
            $monthsLimit = in_array($range, ['3', '6', '12']) ? (int)$range : 12;
            $startDate = now()->subMonths($monthsLimit - 1)->startOfMonth();
            $endDate = now()->endOfDay();
        }

        
        $totalVehicles = \App\Models\Vehicle::where('vendor_id', $vendorId)->count();
        
        $bookingsQuery = \App\Models\Booking::where('vendor_id', $vendorId);
        if ($startDate && $endDate) {
            $bookingsQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        $totalBookings = $bookingsQuery->count();
        $totalEarnings = (float)$bookingsQuery->sum('paid_amount');
        
        $monthlyEarnings = \App\Models\Booking::where('vendor_id', $vendorId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('paid_amount');

        
        $monthlyRevenue = [];
        if ($startDate && $endDate) {
            $tempDate = (clone $startDate)->startOfMonth();
            while ($tempDate->lte($endDate)) {
                $revenue = \App\Models\Booking::where('vendor_id', $vendorId)
                    ->whereMonth('created_at', $tempDate->month)
                    ->whereYear('created_at', $tempDate->year)
                    ->sum('paid_amount');
                $count = \App\Models\Booking::where('vendor_id', $vendorId)
                    ->whereMonth('created_at', $tempDate->month)
                    ->whereYear('created_at', $tempDate->year)
                    ->count();
                
                $monthlyRevenue[] = [
                    'month' => $tempDate->format('M'),
                    'revenue' => (float)$revenue,
                    'count' => $count
                ];
                
                $tempDate->addMonth();
            }
        }

        $maxRevenue = collect($monthlyRevenue)->max('revenue') ?: 1;

        
        $recentBookings = \App\Models\Booking::with('vehicle')
            ->where('vendor_id', $vendorId)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        
        $automaticCount = \App\Models\Vehicle::where('vendor_id', $vendorId)->where('gear_system', 'Automatic')->count();
        $manualCount = \App\Models\Vehicle::where('vendor_id', $vendorId)->where('gear_system', 'Manual')->count();
        $totalGear = $automaticCount + $manualCount;
        
        $autoPercent = $totalGear > 0 ? round(($automaticCount / $totalGear) * 100) : 50;
        $manualPercent = $totalGear > 0 ? round(($manualCount / $totalGear) * 100) : 50;

        
        $totalReviewsCount = \App\Models\Review::where('vendor_id', $vendorId)->count();
        $avgRating = $totalReviewsCount > 0 ? (float)\App\Models\Review::where('vendor_id', $vendorId)->avg('rating') : 0.0;
        $recentReviews = \App\Models\Review::with(['user', 'vehicle', 'booking'])
            ->where('vendor_id', $vendorId)
            ->latest()
            ->take(5)
            ->get();

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
            'manualPercent',
            'avgRating',
            'totalReviewsCount',
            'recentReviews'
        ));
    }

    public function pricing()
    {
        $packages = \App\Models\Package::where('is_active', true)->get()->sortBy(function ($package) {
            $priceStr = strtolower($package->price);
            if ($priceStr === 'free' || $priceStr === '0' || $priceStr === '$0') {
                return 0;
            }
            if ($priceStr === 'custom' || $priceStr === 'enterprise') {
                return 999999;
            }
            preg_match_all('!\d+!', $package->price, $matches);
            if (!empty($matches[0])) {
                return (float) implode('', $matches[0]);
            }
            return 999999;
        })->values();
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

    public function subscriptionInvoice($id)
    {
        $subscription = \App\Models\VendorSubscription::where('vendor_id', auth()->id())
            ->with(['vendor', 'package'])
            ->findOrFail($id);

        return view('partials.subscription-invoice', compact('subscription'));
    }

    public function subscribe(Request $request, $packageId)
    {
        $package = \App\Models\Package::findOrFail($packageId);
        $user = auth()->user();

        
        \App\Models\VendorSubscription::where('vendor_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        $billingPeriod = strtolower(trim($package->billing_period));
        if ($billingPeriod === '/ year') {
            $endsAt = now()->addYear();
        } elseif ($billingPeriod === '/ quarter') {
            $endsAt = now()->addMonths(3);
        } else {
            $endsAt = now()->addMonth();
        }

        
        \App\Models\VendorSubscription::create([
            'vendor_id' => $user->id,
            'package_id' => $package->id,
            'starts_at' => now(),
            'ends_at' => $endsAt,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Successfully subscribed to ' . $package->name . ' package.');
    }

    

    public function createOrder(Request $request, $packageId)
    {
        $request->validate([
            'street_address' => 'required|string|max:255',
            'landmark' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $package = \App\Models\Package::findOrFail($packageId);
        
        
        $priceStr = $package->price;
        $price = (float) filter_var($priceStr, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        
        
        $priceInInr = $price;
        
        
        $siteSettings = \App\Models\SiteSetting::first();
        $taxRate = $siteSettings ? (float) $siteSettings->tax_percentage : 18.0;
        $totalPrice = $priceInInr * (1 + $taxRate / 100);

        
        if ($price <= 0) {
            return response()->json([
                'status'           => 'success',
                'mode'             => 'free',
                'amount_formatted' => '0.00',
                'package_name'     => $package->name,
                'package_id'       => $package->id,
            ]);
        }
        
        
        $settings = \App\Models\SiteSetting::first();
        
        $isRazorpayActive = $settings && $settings->razorpay_active && !empty($settings->razorpay_key_id) && !empty($settings->razorpay_key_secret);
        
        if ($isRazorpayActive) {
            try {
                
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
            
            return response()->json([
                'status'           => 'success',
                'mode'             => 'mock',
                'amount_formatted' => number_format($totalPrice, 2),
                'package_name'     => $package->name,
                'package_id'       => $package->id,
            ]);
        }
    }

    

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'street_address' => 'required|string|max:255',
            'landmark' => 'required|string|max:255',
            'pincode' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $mode = $request->input('mode');
        $packageId = $request->input('package_id');
        $package = \App\Models\Package::findOrFail($packageId);
        $user = auth()->user();
        
        
        $priceStr = $package->price;
        $price = (float) filter_var($priceStr, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        
        $priceInInr = $price;

        
        $siteSettings = \App\Models\SiteSetting::first();
        $taxRate = $siteSettings ? (float) $siteSettings->tax_percentage : 18.0;
        $totalPrice = $priceInInr * (1 + $taxRate / 100);

        $billingPeriod = strtolower(trim($package->billing_period));
        if ($billingPeriod === '/ year') {
            $endsAt = now()->addYear();
        } elseif ($billingPeriod === '/ quarter') {
            $endsAt = now()->addMonths(3);
        } else {
            $endsAt = now()->addMonth();
        }

        if ($mode === 'razorpay') {
            $razorpayOrderId = $request->input('razorpay_order_id');
            $razorpayPaymentId = $request->input('razorpay_payment_id');
            $razorpaySignature = $request->input('razorpay_signature');
            
            $settings = \App\Models\SiteSetting::first();
            $keySecret = $settings ? $settings->razorpay_key_secret : '';
            
            
            $expectedSignature = hash_hmac('sha256', $razorpayOrderId . '|' . $razorpayPaymentId, $keySecret);
            
            if ($expectedSignature !== $razorpaySignature) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment signature verification failed. Please contact support.',
                ], 400);
            }
            
            
            $paymentMethod = null;
            try {
                $paymentResponse = \Illuminate\Support\Facades\Http::withBasicAuth($settings ? $settings->razorpay_key_id : '', $keySecret)
                    ->get("https://api.razorpay.com/v1/payments/{$razorpayPaymentId}");
                
                if ($paymentResponse->successful()) {
                    $paymentData = $paymentResponse->json();
                    $paymentMethod = $paymentData['method'] ?? null;
                }
            } catch (\Exception $e) {
                
            }

            
            \App\Models\VendorSubscription::where('vendor_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'expired']);
                
            
            \App\Models\VendorSubscription::create([
                'vendor_id' => $user->id,
                'package_id' => $package->id,
                'starts_at' => now(),
                'ends_at' => $endsAt,
                'status' => 'active',
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_payment_id' => $razorpayPaymentId,
                'razorpay_signature' => $razorpaySignature,
                'payment_method' => $paymentMethod,
                'amount_paid' => $totalPrice,
                'street_address' => $request->input('street_address'),
                'landmark' => $request->input('landmark'),
                'pincode' => $request->input('pincode'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
            ]);
            
            session()->flash('success', 'Payment successful! Successfully subscribed to ' . $package->name . ' package.');
            
            return response()->json([
                'status' => 'success',
                'message' => 'Subscription activated successfully.',
                'redirect_url' => route('vendor.dashboard'),
            ]);
        } elseif ($mode === 'free') {
            
            \App\Models\VendorSubscription::where('vendor_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'expired']);

            \App\Models\VendorSubscription::create([
                'vendor_id'  => $user->id,
                'package_id' => $package->id,
                'starts_at'  => now(),
                'ends_at'    => $endsAt,
                'status'     => 'active',
                'amount_paid' => 0,
                'street_address' => $request->input('street_address'),
                'landmark' => $request->input('landmark'),
                'pincode' => $request->input('pincode'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
            ]);

            session()->flash('success', 'Successfully subscribed to ' . $package->name . ' (Free Plan).');

            return response()->json([
                'status'       => 'success',
                'message'      => 'Free subscription activated successfully.',
                'redirect_url' => route('vendor.dashboard'),
            ]);
        } else {
            
            
            \App\Models\VendorSubscription::where('vendor_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'expired']);
                
            
            \App\Models\VendorSubscription::create([
                'vendor_id' => $user->id,
                'package_id' => $package->id,
                'starts_at' => now(),
                'ends_at' => $endsAt,
                'status' => 'active',
                'amount_paid' => $totalPrice,
                'street_address' => $request->input('street_address'),
                'landmark' => $request->input('landmark'),
                'pincode' => $request->input('pincode'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
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
