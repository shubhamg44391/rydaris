<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubAdminCreatedMail;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $adminUsers = User::where('role', 'admin')->whereNotNull('role_id')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.admin-users.index', compact('adminUsers'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.admin-users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $password = $request->password;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'role_id' => $request->role_id,
            'status' => 'active',
        ]);

        try {
            Mail::to($user->email)->send(new SubAdminCreatedMail($user, $password));
        } catch (\Exception $e) {
            // Log mail error but continue
        }

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user created and email sent successfully.');
    }

    public function edit($id)
    {
        $adminUser = User::where('role', 'admin')->findOrFail($id);
        $roles = Role::all();
        return view('admin.admin-users.edit', compact('adminUser', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $adminUser = User::where('role', 'admin')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $adminUser->id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $adminUser->update($data);

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user updated successfully.');
    }

    public function destroy($id)
    {
        $adminUser = User::where('role', 'admin')->findOrFail($id);
        $adminUser->delete();

        return redirect()->route('admin.admin-users.index')->with('success', 'Admin user deleted successfully.');
    }
}
