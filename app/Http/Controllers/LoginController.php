<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('frontend.login');
    }

    public function showVendorLoginForm()
    {
        return view('frontend.vendor-login');
    }

    public function showAdminLoginForm()
    {
        return view('frontend.admin-login');
    }

    /**
     * Handle Customer authentication attempt.
     */
    public function customerLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Strictly check if the user is a customer/user
            if ($user->role !== 'user') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'This account is not authorized to log in via Customer Login.',
                ]);
            }

            $request->session()->regenerate();

            if ($request->filled('redirect_to')) {
                return redirect($request->input('redirect_to'));
            }

            return redirect(route('user.vendors.show', $user->vendor_id));
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Handle Vendor authentication attempt.
     */
    public function vendorLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Strictly check if the user is a vendor
            if ($user->role !== 'vendor') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'This account is not authorized to log in via Vendor Login.',
                ]);
            }

            $request->session()->regenerate();

            if ($request->filled('redirect_to')) {
                return redirect($request->input('redirect_to'));
            }

            return redirect(route('vendor.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Handle Admin authentication attempt.
     */
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Strictly check if the user is an admin or super_admin
            if ($user->role !== 'admin' && $user->role !== 'super_admin') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'This account is not authorized to log in via Admin Login.',
                ]);
            }

            $request->session()->regenerate();

            if ($request->filled('redirect_to')) {
                return redirect($request->input('redirect_to'));
            }

            return redirect(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Log user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }
}
