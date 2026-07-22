<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Mail\AdminNewVendorMail;
use App\Mail\VendorWelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VendorRegisterController extends Controller
{
    

    public function showRegisterForm()
    {
        $vendors = User::where('role', 'vendor')->where('status', 'active')->get();
        $invitation = null;

        if (request()->has('invite_token')) {
            $invitation = \App\Models\UserInvitation::where('token', request('invite_token'))
                ->where('status', 'pending')
                ->first();
                
            if (!$invitation) {
                return redirect()->route('vendor.register')->withErrors(['invite_token' => 'The invitation token is invalid or has already been used.']);
            }
        }

        return view('frontend.vendor-register', compact('vendors', 'invitation'));
    }

    

    public function register(Request $request)
    {
        $invitation = null;
        if ($request->filled('invite_token')) {
            $invitation = \App\Models\UserInvitation::where('token', $request->invite_token)
                ->where('status', 'pending')
                ->first();
                
            if (!$invitation) {
                return back()->withInput()->withErrors(['invite_token' => 'The invitation token is invalid or has already been used.']);
            }
            
            
            $request->merge([
                'role' => 'user',
                'vendor_id' => $invitation->vendor_id,
                'email' => $invitation->email,
            ]);
        }

        $request->validate([
            'role' => ['required', 'string', 'in:user,vendor'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required_if:role,vendor', 'nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number' => ['required', 'string', 'max:20'],
            'country_code' => ['required', 'string', 'max:10'],
            'vendor_id' => ['required_if:role,user', 'nullable', 'exists:users,id'],
            'street_address' => ['required_if:role,vendor', 'nullable', 'string', 'max:255'],
            'landmark' => ['nullable', 'string', 'max:255'],
            'pincode' => ['required_if:role,vendor', 'nullable', 'string', 'max:20'],
            'city' => ['required_if:role,vendor', 'nullable', 'string', 'max:255'],
            'country' => ['required_if:role,vendor', 'nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'package_id' => ['nullable', 'integer', 'exists:packages,id'],
        ]);

        if ($request->role === 'user' && $request->vendor_id) {
            $vendorId = $request->vendor_id;
            
            
            $vendor = User::with(['subscription' => function($q) {
                $q->where('status', 'active')
                  ->where('starts_at', '<=', now())
                  ->where('ends_at', '>=', now());
            }, 'subscription.package'])->find($vendorId);

            if ($vendor && $vendor->subscription && $vendor->subscription->package) {
                $maxUsers = $vendor->subscription->package->no_of_users;
                
                
                if (!empty($maxUsers) && $maxUsers != 'Unlimited') {
                    $maxUsers = (int) $maxUsers;
                    $currentUsers = User::where('vendor_id', $vendorId)->where('role', 'user')->count();
                    
                    if ($currentUsers >= $maxUsers) {
                        return back()->withInput()->withErrors(['vendor_id' => 'This vendor has reached their maximum user capacity based on their current plan.']);
                    }
                }
            }
        }

        if ($request->role === 'vendor' && $request->company_name) {
            $baseName = $request->company_name;
        } else {
            $baseName = $request->first_name . $request->last_name;
        }
        $baseUsername = Str::slug($baseName, '');
        if (empty($baseUsername)) {
            $baseUsername = $request->role === 'vendor' ? 'vendor' : 'user';
        }
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . random_int(100, 9999);
        }

        $fullName = $request->first_name . ($request->middle_name ? ' ' . $request->middle_name : '') . ' ' . $request->last_name;

        try {
            $user = DB::transaction(function () use ($request, $fullName, $username) {
                $user = User::create([
                    'name' => $fullName,
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'last_name' => $request->last_name,
                    'company_name' => $request->role === 'vendor' ? $request->company_name : null,
                    'username' => $username,
                    'email' => $request->email,
                    'contact_number' => $request->contact_number,
                    'country_code' => $request->country_code,
                    'street_address' => $request->street_address,
                    'landmark' => $request->landmark,
                    'pincode' => $request->pincode,
                    'city' => $request->city,
                    'country' => $request->country,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'vendor_id' => $request->role === 'user' ? $request->vendor_id : null,
                ]);

                if ($user->role === 'vendor') {
                    $this->sendVendorRegistrationEmails($user);
                }

                return $user;
            });
        } catch (\Throwable $e) {
            Log::error('Vendor registration failed: ' . $e->getMessage(), [
                'email' => $request->email,
                'role' => $request->role,
            ]);

            $message = $request->role === 'vendor'
                ? 'Registration could not be completed because the confirmation email could not be sent. Please check your email address and try again, or contact support.'
                : 'Registration could not be completed. Please try again later.';

            return back()->withInput()->withErrors(['email' => $message]);
        }

        if (isset($invitation)) {
            $invitation->update(['status' => 'accepted']);
        }

        Auth::login($user);
        $request->session()->flash('login_success_preloader', true);

        if ($request->role === 'vendor') {
            if ($request->filled('package_id')) {
                return redirect()->route('pricing', ['buy_package_id' => $request->package_id]);
            }
            return redirect(route('vendor.dashboard'));
        } else {
            return redirect(route('user.dashboard'));
        }
    }

    

    private function sendVendorRegistrationEmails(User $user): void
    {
        try {
            try {
                \App\Models\SiteSetting::setMailConfig();
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to load SMTP settings for registration emails: " . $e->getMessage());
            }

            Mail::to($user->email)->send(new VendorWelcomeMail($user));

            $admins = User::whereIn('role', ['admin', 'super_admin'])->get();
            if ($admins->isEmpty()) {
                Mail::to('admin@rydaris.com')->send(new AdminNewVendorMail($user));
                return;
            }

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new AdminNewVendorMail($user));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send vendor registration emails: " . $e->getMessage());
        }
    }
}
