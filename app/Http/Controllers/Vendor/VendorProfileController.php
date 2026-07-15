<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class VendorProfileController extends Controller
{
    /**
     * Display the profile page.
     */
    public function index()
    {
        $user = Auth::user();
        $branches = \App\Models\Branch::where('vendor_id', $user->id)
            ->where('status', true)
            ->orderBy('name')
            ->get();
        return view('vendor.profile.index', compact('user', 'branches'));
    }

    /**
     * Update profile details.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:20'],
            'country_code' => ['required', 'string', 'max:10'],
            'username' => ['required', 'string', 'max:255'],
            'company_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'street_address' => ['required', 'string', 'max:255'],
            'landmark' => ['nullable', 'string', 'max:255'],
            'pincode' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'current_branch_id' => ['nullable', 'exists:branches,id'],
        ]);

        if ($request->filled('current_branch_id')) {
            $branchExists = \App\Models\Branch::where('vendor_id', $user->id)
                ->where('id', $request->current_branch_id)
                ->where('status', true)
                ->exists();
            if (!$branchExists) {
                return back()->withInput()->withErrors(['current_branch_id' => 'Invalid branch selected.']);
            }
        }

        $baseUsername = \Illuminate\Support\Str::slug($request->username, '');
        $username = $baseUsername;
        
        while (\App\Models\User::where('username', $username)->where('id', '!=', $user->id)->exists()) {
            $username = $baseUsername . random_int(100, 9999);
        }

        $fullName = $request->first_name . ($request->middle_name ? ' ' . $request->middle_name : '') . ' ' . $request->last_name;

        $data = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'name' => $fullName,
            'company_name' => $request->company_name,
            'contact_number' => $request->contact_number,
            'country_code' => $request->country_code,
            'username' => $username,
            'street_address' => $request->street_address,
            'landmark' => $request->landmark,
            'pincode' => $request->pincode,
            'city' => $request->city,
            'country' => $request->country,
            'current_branch_id' => $request->current_branch_id,
        ];

        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('company_logos', 'public');
            $data['company_logo'] = $logoPath;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}

