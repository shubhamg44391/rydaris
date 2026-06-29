<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number' => ['required', 'string', 'max:20'],
            'country_code' => ['required', 'string', 'max:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->first_name,
            'first_name' => $request->first_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'country_code' => $request->country_code,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
        ]);

        Auth::login($user);

        return redirect(route('vendor.dashboard'));
    }
}
