<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VendorRegisterController extends Controller
{
    /**
     * Show the vendor registration form.
     */
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

    /**
     * Handle vendor registration request.
     */
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
            
            // Force values from invitation
            $request->merge([
                'role' => 'user',
                'vendor_id' => $invitation->vendor_id,
                'email' => $invitation->email,
            ]);
        }

        $request->validate([
            'role' => ['required', 'string', 'in:user,vendor'],
            'first_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required_if:role,vendor', 'nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number' => ['required', 'string', 'max:20'],
            'country_code' => ['required', 'string', 'max:10'],
            'vendor_id' => ['required_if:role,user', 'nullable', 'exists:users,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($request->role === 'user' && $request->vendor_id) {
            $vendorId = $request->vendor_id;
            
            // Get the vendor's active subscription
            $vendor = User::with(['subscription' => function($q) {
                $q->where('status', 'active')
                  ->where('starts_at', '<=', now())
                  ->where('ends_at', '>=', now());
            }, 'subscription.package'])->find($vendorId);

            if ($vendor && $vendor->subscription && $vendor->subscription->package) {
                $maxUsers = $vendor->subscription->package->no_of_users;
                
                // If maxUsers is not null/empty, check the limit
                if (!empty($maxUsers) && $maxUsers != 'Unlimited') {
                    $maxUsers = (int) $maxUsers;
                    $currentUsers = User::where('vendor_id', $vendorId)->where('role', 'user')->count();
                    
                    if ($currentUsers >= $maxUsers) {
                        return back()->withInput()->withErrors(['vendor_id' => 'This vendor has reached their maximum user capacity based on their current plan.']);
                    }
                }
            }
        }

        $baseName = $request->role === 'vendor' ? $request->company_name : $request->first_name;
        $baseUsername = Str::slug($baseName, '');
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . random_int(100, 9999);
        }

        $user = User::create([
            'name' => $request->first_name,
            'first_name' => $request->first_name,
            'company_name' => $request->role === 'vendor' ? $request->company_name : null,
            'username' => $username,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'country_code' => $request->country_code,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'vendor_id' => $request->role === 'user' ? $request->vendor_id : null,
        ]);

        if (isset($invitation)) {
            $invitation->update(['status' => 'accepted']);
        }

        Auth::login($user);

        if ($request->role === 'vendor') {
            return redirect(route('vendor.dashboard'));
        } else {
            return redirect(route('user.dashboard'));
        }
    }
}
