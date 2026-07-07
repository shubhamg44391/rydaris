<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorPaymentSetting;

class PaymentSettingController extends Controller
{
    public function index()
    {
        $settings = auth()->user()->paymentSetting()->firstOrCreate([
            'vendor_id' => auth()->id()
        ]);
        
        return view('vendor.settings.payment', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'pay_on_arrival' => 'boolean',
            'pay_deposit' => 'boolean',
            'deposit_percentage' => 'nullable|numeric|min:0|max:100',
            'pay_full' => 'boolean',
            'full_payment_discount' => 'nullable|numeric|min:0|max:100',
            'razorpay_key' => 'nullable|string|max:255',
            'razorpay_secret' => 'nullable|string|max:255',
        ]);

        $payOnArrival = $request->has('pay_on_arrival');
        $payDeposit = $request->has('pay_deposit');
        $payFull = $request->has('pay_full');

        if ($payFull && empty($request->input('full_payment_discount'))) {
            return back()->with('error', 'Full Payment Discount (%) is required when Pay Full Amount is enabled.');
        }

        if (!$payFull && $request->filled('full_payment_discount') && $request->input('full_payment_discount') > 0) {
            return back()->with('error', 'Pay Full Amount must be enabled if a Full Payment Discount is provided.');
        }

        if (!$payOnArrival && !$payDeposit && !$payFull) {
            return back()->with('error', 'At least one payment method must be enabled.');
        }

        $settings = auth()->user()->paymentSetting()->firstOrCreate([
            'vendor_id' => auth()->id()
        ]);

        $settings->update([
            'pay_on_arrival' => $payOnArrival,
            'pay_deposit' => $payDeposit,
            'deposit_percentage' => $request->filled('deposit_percentage') ? $request->input('deposit_percentage') : 5.00,
            'pay_full' => $payFull,
            'full_payment_discount' => $request->filled('full_payment_discount') ? $request->input('full_payment_discount') : 0.00,
            'razorpay_key' => $request->input('razorpay_key'),
            'razorpay_secret' => $request->input('razorpay_secret'),
        ]);

        return back()->with('success', 'Payment gateway settings updated successfully.');
    }
}
