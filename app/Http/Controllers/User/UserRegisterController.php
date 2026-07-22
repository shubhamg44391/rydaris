<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        
        $vendors = User::where('role', 'vendor')
            ->where('status', 1)
            ->get();
            
        return view('frontend.register', compact('vendors'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'name'       => 'required|string|max:255', 
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
            'vendor_id'  => 'required|exists:users,id',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'user',
            'status'     => 1,
            'vendor_id'  => $request->vendor_id,
        ]);

        Auth::login($user);
        $request->session()->flash('login_success_preloader', true);

        return redirect()->route('user.dashboard')->with('success', 'Registration successful!');
    }
}
