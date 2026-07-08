<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorSmtpSetting;
use Illuminate\Support\Facades\Auth;

class SmtpSettingController extends Controller
{
    public function index()
    {
        $setting = VendorSmtpSetting::where('vendor_id', Auth::id())->first();
        return view('vendor.smtp_settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|string|max:255',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|string|in:tls,ssl',
            'from_email' => 'nullable|email|max:255',
            'from_name' => 'nullable|string|max:255',
        ]);

        $setting = VendorSmtpSetting::firstOrNew(['vendor_id' => Auth::id()]);
        
        $setting->smtp_host = $request->smtp_host;
        $setting->smtp_port = $request->smtp_port;
        $setting->smtp_username = $request->smtp_username;
        $setting->smtp_password = $request->smtp_password;
        $setting->smtp_encryption = $request->smtp_encryption;
        $setting->from_email = $request->from_email;
        $setting->from_name = $request->from_name;
        
        $setting->save();

        return redirect()->back()->with('success', 'SMTP settings updated successfully.');
    }
}
