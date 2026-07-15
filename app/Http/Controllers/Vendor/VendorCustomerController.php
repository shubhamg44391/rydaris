<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorCustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index()
    {
        $customers = User::where('role', 'user')
            ->where('vendor_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('vendor.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        $vendor = auth()->user();
        $vendor->load(['subscription' => function($q) {
            $q->where('status', 'active')
              ->where('starts_at', '<=', now())
              ->where('ends_at', '>=', now());
        }, 'subscription.package']);

        if ($vendor->subscription && $vendor->subscription->package) {
            $maxUsers = $vendor->subscription->package->no_of_users;
            if (!empty($maxUsers) && $maxUsers != 'Unlimited') {
                $maxUsers = (int) $maxUsers;
                $currentUsers = User::where('vendor_id', $vendor->id)->where('role', 'user')->count();
                
                if ($currentUsers >= $maxUsers) {
                    return redirect()->route('vendor.customers.index')->with('error', 'You have reached your maximum customer capacity based on your current plan. Upgrade your plan to add more customers.');
                }
            }
        }

        return view('vendor.customers.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'name'           => 'required|string|max:255', // Last Name
            'email'          => 'required|string|email|max:255|unique:users,email',
            'country_code'   => 'required|string|max:10',
            'contact_number' => 'required|string|max:20',
            'password'       => 'required|string|min:8|confirmed',
        ]);

        // Check if vendor has reached user capacity
        $vendor = auth()->user();
        $vendor->load(['subscription' => function($q) {
            $q->where('status', 'active')
              ->where('starts_at', '<=', now())
              ->where('ends_at', '>=', now());
        }, 'subscription.package']);

        if ($vendor->subscription && $vendor->subscription->package) {
            $maxUsers = $vendor->subscription->package->no_of_users;
            if (!empty($maxUsers) && $maxUsers != 'Unlimited') {
                $maxUsers = (int) $maxUsers;
                $currentUsers = User::where('vendor_id', $vendor->id)->where('role', 'user')->count();
                
                if ($currentUsers >= $maxUsers) {
                    return back()->withInput()->withErrors(['email' => 'You have reached your maximum customer capacity based on your current plan. Upgrade your plan to add more customers.']);
                }
            }
        }

        // Generate username
        $baseName = $request->first_name;
        $baseUsername = Str::slug($baseName, '');
        $username = $baseUsername;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . random_int(100, 9999);
        }

        User::create([
            'first_name'     => $request->first_name,
            'name'           => $request->name,
            'username'       => $username,
            'email'          => $request->email,
            'contact_number' => $request->contact_number,
            'country_code'   => $request->country_code,
            'password'       => Hash::make($request->password),
            'role'           => 'user',
            'status'         => 1,
            'vendor_id'      => $vendor->id,
        ]);

        return redirect()->route('vendor.customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit($id)
    {
        $customer = User::where('role', 'user')
            ->where('vendor_id', auth()->id())
            ->findOrFail($id);

        return view('vendor.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = User::where('role', 'user')
            ->where('vendor_id', auth()->id())
            ->findOrFail($id);

        $request->validate([
            'first_name'     => 'required|string|max:255',
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users,email,' . $id,
            'country_code'   => 'required|string|max:10',
            'contact_number' => 'required|string|max:20',
            'password'       => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'first_name'     => $request->first_name,
            'name'           => $request->name,
            'email'          => $request->email,
            'country_code'   => $request->country_code,
            'contact_number' => $request->contact_number,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);

        return redirect()->route('vendor.customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy($id)
    {
        $customer = User::where('role', 'user')
            ->where('vendor_id', auth()->id())
            ->findOrFail($id);

        $customer->delete();

        return redirect()->route('vendor.customers.index')->with('success', 'Customer deleted successfully.');
    }
}
