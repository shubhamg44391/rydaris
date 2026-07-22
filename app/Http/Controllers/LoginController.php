<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    

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

    

    public function customerLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            
            if ($user->role !== 'user') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'This account is not authorized to log in via Customer Login.',
                ]);
            }

            $request->session()->regenerate();
            $request->session()->flash('login_success_preloader', true);

            if ($request->filled('redirect_to')) {
                return redirect($request->input('redirect_to'));
            }

            return redirect(route('user.vendors.show', $user->vendor_id));
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    

    public function vendorLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            
            if ($user->role !== 'vendor') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'This account is not authorized to log in via Vendor Login.',
                ]);
            }

            $request->session()->regenerate();
            $request->session()->flash('login_success_preloader', true);

            if ($request->filled('redirect_to')) {
                return redirect($request->input('redirect_to'));
            }

            return redirect(route('vendor.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            
            if ($user->role !== 'admin' && $user->role !== 'super_admin') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'This account is not authorized to log in via Admin Login.',
                ]);
            }

            $request->session()->regenerate();
            $request->session()->flash('login_success_preloader', true);

            if ($request->filled('redirect_to')) {
                return redirect($request->input('redirect_to'));
            }

            return redirect(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }
}
