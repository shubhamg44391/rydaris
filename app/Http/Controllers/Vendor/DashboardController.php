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
        return view('vendor.dashboard');
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
