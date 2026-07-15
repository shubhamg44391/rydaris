<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    /**
     * Display a listing of the packages.
     */
    public function index()
    {
        $packages = Package::orderBy('order', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new package.
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created package in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'string', 'max:255'],
            'billing_period' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'button_text' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer'],
            'no_of_users' => ['nullable', 'integer'],
            'no_of_invitations' => ['nullable', 'integer'],
            'no_of_coupons' => ['nullable', 'integer'],
            'no_of_vehicles' => ['nullable', 'integer'],
            'no_of_groups' => ['nullable', 'integer'],
            'no_of_branches' => ['nullable', 'integer'],
            'no_of_bookings' => ['nullable', 'integer'],
            'no_of_locations' => ['nullable', 'integer'],
            'no_of_extras' => ['nullable', 'integer'],
            'no_of_insurances' => ['nullable', 'integer'],
            'no_of_features' => ['nullable', 'integer'],
            'no_of_rules' => ['nullable', 'integer'],
            'no_of_support_tickets' => ['nullable', 'integer'],
            'booking_menu' => ['nullable', 'boolean'],
            'vehicles_menu' => ['nullable', 'boolean'],
            'locations_menu' => ['nullable', 'boolean'],
            'customers_menu' => ['nullable', 'boolean'],
            'fleet_management_menu' => ['nullable', 'boolean'],
            'extras_menu' => ['nullable', 'boolean'],
            'coupons_menu' => ['nullable', 'boolean'],
            'support_ticket_menu' => ['nullable', 'boolean'],
            'settings_menu' => ['nullable', 'boolean'],
        ]);

        Package::create([
            'name' => $request->name,
            'eyebrow' => $request->eyebrow,
            'description' => $request->description,
            'price' => $request->price,
            'billing_period' => $request->billing_period,
            'features' => [], // no longer used from input
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
            'button_text' => $request->button_text,
            'order' => $request->order,
            'no_of_users' => $request->no_of_users,
            'no_of_invitations' => $request->no_of_invitations,
            'no_of_coupons' => $request->no_of_coupons,
            'no_of_vehicles' => $request->no_of_vehicles,
            'no_of_groups' => $request->no_of_groups,
            'no_of_branches' => $request->no_of_branches,
            'no_of_bookings' => $request->no_of_bookings,
            'no_of_locations' => $request->no_of_locations,
            'no_of_extras' => $request->no_of_extras,
            'no_of_insurances' => $request->no_of_insurances,
            'no_of_features' => $request->no_of_features,
            'no_of_rules' => $request->no_of_rules,
            'no_of_support_tickets' => $request->no_of_support_tickets,
            'booking_menu' => $request->has('booking_menu'),
            'vehicles_menu' => $request->has('vehicles_menu'),
            'locations_menu' => $request->has('locations_menu'),
            'customers_menu' => $request->has('customers_menu'),
            'fleet_management_menu' => $request->has('fleet_management_menu'),
            'extras_menu' => $request->has('extras_menu'),
            'coupons_menu' => $request->has('coupons_menu'),
            'support_ticket_menu' => $request->has('support_ticket_menu'),
            'settings_menu' => $request->has('settings_menu'),
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    /**
     * Show the form for editing the specified package.
     */
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified package in database.
     */
    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'string', 'max:255'],
            'billing_period' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'button_text' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer'],
            'no_of_users' => ['nullable', 'integer'],
            'no_of_invitations' => ['nullable', 'integer'],
            'no_of_coupons' => ['nullable', 'integer'],
            'no_of_vehicles' => ['nullable', 'integer'],
            'no_of_groups' => ['nullable', 'integer'],
            'no_of_branches' => ['nullable', 'integer'],
            'no_of_bookings' => ['nullable', 'integer'],
            'no_of_locations' => ['nullable', 'integer'],
            'no_of_extras' => ['nullable', 'integer'],
            'no_of_insurances' => ['nullable', 'integer'],
            'no_of_features' => ['nullable', 'integer'],
            'no_of_rules' => ['nullable', 'integer'],
            'no_of_support_tickets' => ['nullable', 'integer'],
            'booking_menu' => ['nullable', 'boolean'],
            'vehicles_menu' => ['nullable', 'boolean'],
            'locations_menu' => ['nullable', 'boolean'],
            'customers_menu' => ['nullable', 'boolean'],
            'fleet_management_menu' => ['nullable', 'boolean'],
            'extras_menu' => ['nullable', 'boolean'],
            'coupons_menu' => ['nullable', 'boolean'],
            'support_ticket_menu' => ['nullable', 'boolean'],
            'settings_menu' => ['nullable', 'boolean'],
        ]);

        $package->update([
            'name' => $request->name,
            'eyebrow' => $request->eyebrow,
            'description' => $request->description,
            'price' => $request->price,
            'billing_period' => $request->billing_period,
            'features' => [], // no longer used from input
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
            'button_text' => $request->button_text,
            'order' => $request->order,
            'no_of_users' => $request->no_of_users,
            'no_of_invitations' => $request->no_of_invitations,
            'no_of_coupons' => $request->no_of_coupons,
            'no_of_vehicles' => $request->no_of_vehicles,
            'no_of_groups' => $request->no_of_groups,
            'no_of_branches' => $request->no_of_branches,
            'no_of_bookings' => $request->no_of_bookings,
            'no_of_locations' => $request->no_of_locations,
            'no_of_extras' => $request->no_of_extras,
            'no_of_insurances' => $request->no_of_insurances,
            'no_of_features' => $request->no_of_features,
            'no_of_rules' => $request->no_of_rules,
            'no_of_support_tickets' => $request->no_of_support_tickets,
            'booking_menu' => $request->has('booking_menu'),
            'vehicles_menu' => $request->has('vehicles_menu'),
            'locations_menu' => $request->has('locations_menu'),
            'customers_menu' => $request->has('customers_menu'),
            'fleet_management_menu' => $request->has('fleet_management_menu'),
            'extras_menu' => $request->has('extras_menu'),
            'coupons_menu' => $request->has('coupons_menu'),
            'support_ticket_menu' => $request->has('support_ticket_menu'),
            'settings_menu' => $request->has('settings_menu'),
        ]);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package from database.
     */
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
