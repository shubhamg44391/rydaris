<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class AdminSettingController extends Controller
{
    

    public function paymentSettings()
    {
        $settings = SiteSetting::firstOrCreate();
        return view('admin.settings.payment', compact('settings'));
    }

    

    public function updatePaymentSettings(Request $request)
    {
        $request->validate([
            'razorpay_key_id' => $request->has('razorpay_active') ? 'required|string|max:255' : 'nullable|string|max:255',
            'razorpay_key_secret' => $request->has('razorpay_active') ? 'required|string|max:255' : 'nullable|string|max:255',
            'tax_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $settings = SiteSetting::firstOrCreate();
        $settings->update([
            'razorpay_key_id' => $request->input('razorpay_key_id'),
            'razorpay_key_secret' => $request->input('razorpay_key_secret'),
            'razorpay_active' => $request->has('razorpay_active'),
            'tax_percentage' => $request->input('tax_percentage', 18),
        ]);

        return back()->with('success', 'Razorpay settings updated successfully.');
    }

    

    public function mailSettings()
    {
        $settings = SiteSetting::firstOrCreate();
        return view('admin.settings.mail', compact('settings'));
    }

    

    public function updateMailSettings(Request $request)
    {
        $request->validate([
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|string|max:255',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|string|in:tls,ssl,none',
            'from_email' => 'nullable|email|max:255',
            'from_name' => 'nullable|string|max:255',
        ]);

        $settings = SiteSetting::firstOrCreate();
        $settings->update([
            'smtp_host' => $request->input('smtp_host'),
            'smtp_port' => $request->input('smtp_port'),
            'smtp_username' => $request->input('smtp_username'),
            'smtp_password' => $request->input('smtp_password'),
            'smtp_encryption' => $request->input('smtp_encryption') === 'none' ? null : $request->input('smtp_encryption'),
            'from_email' => $request->input('from_email'),
            'from_name' => $request->input('from_name'),
        ]);

        return back()->with('success', 'Mail / SMTP settings updated successfully.');
    }

    

    public function sendTestMail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email|max:255',
        ]);

        try {
            
            SiteSetting::setMailConfig();
            
            \Illuminate\Support\Facades\Mail::raw('This is a test email from Rydaris to verify your SMTP settings. If you receive this, your settings are correct!', function($message) use ($request) {
                $message->to($request->input('test_email'))
                        ->subject('Test Email - Rydaris SMTP Verification');
            });
            
            return back()->with('success', 'Test email sent successfully! Please check your inbox.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
