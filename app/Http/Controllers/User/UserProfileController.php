<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'first_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'country_code' => 'required|string|max:10',
            'contact_number' => 'required|string|max:255',
        ];

        if ($user->role === 'vendor') {
            $rules['company_name'] = 'required|string|max:255';
        }

        $request->validate($rules);

        $user->first_name = $request->first_name;
        $user->name = $request->name;
        $user->country_code = $request->country_code;
        $user->contact_number = $request->contact_number;

        if ($user->role === 'vendor') {
            $user->company_name = $request->company_name;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match!']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
