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
        return view('frontend.vendor-register');
    }

    /**
     * Handle vendor registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'role' => ['required', 'string', 'in:user,vendor'],
            'first_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required_if:role,vendor', 'nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number' => ['required', 'string', 'max:20'],
            'country_code' => ['required', 'string', 'max:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

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
        ]);

        Auth::login($user);

        if ($request->role === 'vendor') {
            return redirect(route('vendor.dashboard'));
        } else {
            return redirect('/');
        }
    }
}
