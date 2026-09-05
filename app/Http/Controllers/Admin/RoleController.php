<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    private function getModules()
    {
        return [
            'dashboard' => 'Dashboard',
            'role_management' => 'Role Management',
            'vendors' => 'Vendors',
            'community' => 'Community',
            'subscriptions' => 'Subscriptions',
            'reviews' => 'Customer Reviews',
            'faqs' => 'FAQ',
            'blog' => 'Blog',
            'packages' => 'Packages',
            'terms' => 'Terms & Conditions',
            'inquiries' => 'Inquiries',
            'custom_packages' => 'Custom Packages',
            'pages' => 'Pages',
            'seo' => 'SEO Settings',
            'settings' => 'Settings',
        ];
    }

    public function index(Request $request)
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'html' => view('admin.roles.partials.table', compact('roles'))->render(),
            ]);
        }

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $modules = $this->getModules();
        return view('admin.roles.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
        ]);

        Role::create([
            'name' => $request->name,
            'permissions' => $request->permissions,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $modules = $this->getModules();
        return view('admin.roles.edit', compact('role', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
            'permissions' => ['nullable', 'array'],
        ]);

        $role->update([
            'name' => $request->name,
            'permissions' => $request->permissions,
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully.'
            ]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
