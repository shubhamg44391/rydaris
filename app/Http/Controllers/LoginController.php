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

    public function showAdminLoginForm()
    {
        return view('frontend.admin-login');
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if ($request->filled('redirect_to')) {
                return redirect($request->input('redirect_to'));
            }

            if (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') {
                return redirect(route('dashboard'));
            } elseif (Auth::user()->role === 'user') {
                return redirect(route('user.dashboard'));
            }
            return redirect(route('vendor.dashboard'));
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
