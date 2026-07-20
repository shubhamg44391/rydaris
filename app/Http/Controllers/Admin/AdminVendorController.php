<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminVendorController extends Controller
{
    

    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = User::where('role', 'vendor');

        if ($status && in_array($status, ['active', 'inactive'])) {
            $query->where('status', $status);
        }

        $vendors = $query->with(['activeSubscription.package', 'subscriptions.package'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.vendors.index', compact('vendors', 'status'));
    }

    

    public function toggleStatus($id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);
        $vendor->status = ($vendor->status === 'active') ? 'inactive' : 'active';
        $vendor->save();

        return redirect()->back()->with('success', 'Vendor status updated successfully.');
    }

    

    public function edit($id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    

    public function update(Request $request, $id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'contact_number' => ['required', 'string', 'max:20'],
            'country_code' => ['required', 'string', 'max:10'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'street_address' => ['required', 'string', 'max:255'],
            'landmark' => ['nullable', 'string', 'max:255'],
            'pincode' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
        ]);

        $baseUsername = \Illuminate\Support\Str::slug($request->username, '');
        $username = $baseUsername;
        
        while (User::where('username', $username)->where('id', '!=', $vendor->id)->exists()) {
            $username = $baseUsername . random_int(100, 9999);
        }

        $fullName = $request->first_name . ($request->middle_name ? ' ' . $request->middle_name : '') . ' ' . $request->last_name;

        $vendor->update([
            'name' => $fullName,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'country_code' => $request->country_code,
            'status' => $request->status,
            'username' => $username,
            'street_address' => $request->street_address,
            'landmark' => $request->landmark,
            'pincode' => $request->pincode,
            'city' => $request->city,
            'country' => $request->country,
        ]);

        return redirect(route('admin.vendors.index'))->with('success', 'Vendor updated successfully.');
    }

    

    public function destroy($id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);
        $vendor->delete();

        return redirect(route('admin.vendors.index'))->with('success', 'Vendor deleted successfully.');
    }
}
