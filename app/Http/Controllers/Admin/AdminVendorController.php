<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminVendorController extends Controller
{
    /**
     * Display a paginated listing of the vendors.
     */
    public function index()
    {
        $vendors = User::where('role', 'vendor')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }

    /**
     * Toggle the status of a vendor between active and inactive.
     */
    public function toggleStatus($id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);
        $vendor->status = ($vendor->status === 'active') ? 'inactive' : 'active';
        $vendor->save();

        return redirect()->back()->with('success', 'Vendor status updated successfully.');
    }

    /**
     * Show the form for editing the specified vendor.
     */
    public function edit($id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified vendor details in database.
     */
    public function update(Request $request, $id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'contact_number' => ['required', 'string', 'max:20'],
            'country_code' => ['required', 'string', 'max:10'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        $vendor->update([
            'name' => $request->first_name,
            'first_name' => $request->first_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'country_code' => $request->country_code,
            'status' => $request->status,
        ]);

        return redirect(route('admin.vendors.index'))->with('success', 'Vendor updated successfully.');
    }

    /**
     * Remove the specified vendor from database.
     */
    public function destroy($id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);
        $vendor->delete();

        return redirect(route('admin.vendors.index'))->with('success', 'Vendor deleted successfully.');
    }
}
