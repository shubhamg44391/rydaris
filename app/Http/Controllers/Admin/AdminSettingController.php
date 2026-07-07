<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class AdminSettingController extends Controller
{
    /**
     * Show the Razorpay configuration form.
     */
    public function paymentSettings()
    {
        $settings = SiteSetting::firstOrCreate();
        return view('admin.settings.payment', compact('settings'));
    }

    /**
     * Update the Razorpay configuration.
     */
    public function updatePaymentSettings(Request $request)
    {
        $request->validate([
            'razorpay_key_id' => $request->has('razorpay_active') ? 'required|string|max:255' : 'nullable|string|max:255',
            'razorpay_key_secret' => $request->has('razorpay_active') ? 'required|string|max:255' : 'nullable|string|max:255',
        ]);

        $settings = SiteSetting::firstOrCreate();
        $settings->update([
            'razorpay_key_id' => $request->input('razorpay_key_id'),
            'razorpay_key_secret' => $request->input('razorpay_key_secret'),
            'razorpay_active' => $request->has('razorpay_active'),
        ]);

        return back()->with('success', 'Razorpay settings updated successfully.');
    }
}
