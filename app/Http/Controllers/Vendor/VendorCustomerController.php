<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorCustomerController extends Controller
{
    

    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->where('vendor_id', auth()->id());

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(15);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'html' => view('vendor.customers.index', compact('customers'))->renderSections()['customers_table_section'] ?? '',
            ]);
        }

        return view('vendor.customers.index', compact('customers'));
    }

    

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

    

    public function store(Request $request)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

        try {
            $request->validate([
                'first_name'     => 'required|string|max:255',
                'name'           => 'required|string|max:255', 
                'email'          => 'required|string|email|max:255|unique:users,email',
                'country_code'   => 'required|string|max:10',
                'contact_number' => 'required|string|max:20',
                'password'       => 'required|string|min:8|confirmed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => collect($e->errors())->first()[0] ?? 'Validation failed.'
                ], 422);
            }
            throw $e;
        }

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
                    $msg = 'You have reached your maximum customer capacity based on your current plan. Upgrade your plan to add more customers.';
                    if ($isAjax) {
                        return response()->json(['success' => false, 'message' => $msg], 422);
                    }
                    return back()->withInput()->withErrors(['email' => $msg]);
                }
            }
        }

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

        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'Customer created successfully.'
            ]);
        }

        return redirect()->route('vendor.customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit(Request $request, $id)
    {
        $customer = User::where('role', 'user')
            ->where('vendor_id', auth()->id())
            ->findOrFail($id);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'customer' => $customer
            ]);
        }

        return view('vendor.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

        $customer = User::where('role', 'user')
            ->where('vendor_id', auth()->id())
            ->findOrFail($id);

        try {
            $request->validate([
                'first_name'     => 'required|string|max:255',
                'name'           => 'required|string|max:255',
                'email'          => 'required|string|email|max:255|unique:users,email,' . $id,
                'country_code'   => 'required|string|max:10',
                'contact_number' => 'required|string|max:20',
                'password'       => 'nullable|string|min:8|confirmed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => collect($e->errors())->first()[0] ?? 'Validation failed.'
                ], 422);
            }
            throw $e;
        }

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

        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully.'
            ]);
        }

        return redirect()->route('vendor.customers.index')->with('success', 'Customer updated successfully.');
    }

    

    public function show($id)
    {
        $customer = User::where('role', 'user')
            ->where('vendor_id', auth()->id())
            ->findOrFail($id);

        $bookings = Booking::where('vendor_id', auth()->id())
            ->where(function($q) use ($customer) {
                $q->where('user_id', $customer->id)
                  ->orWhere('customer_email', $customer->email);
            })
            ->with(['vehicle', 'pickupLocation', 'returnLocation'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalSpent = $bookings->sum('paid_amount');
        $totalBookings = $bookings->count();

        $latestDocBooking = $bookings->first(function($b) {
            return !empty($b->license_number) || !empty($b->license_image) || !empty($b->passport_image) || !empty($b->pass_number) || !empty($b->flight_number);
        });

        return view('vendor.customers.show', compact('customer', 'bookings', 'totalSpent', 'totalBookings', 'latestDocBooking'));
    }

    public function destroy(Request $request, $id)
    {
        $customer = User::where('role', 'user')
            ->where('vendor_id', auth()->id())
            ->findOrFail($id);

        $customer->delete();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully.'
            ]);
        }

        return redirect()->route('vendor.customers.index')->with('success', 'Customer deleted successfully.');
    }
}
