<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    

    public function index()
    {
        $packages = Package::orderBy('order', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    

    public function create()
    {
        return view('admin.packages.create');
    }

    

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
            'no_of_maintenance_schedules' => ['nullable', 'integer'],
            'features' => ['nullable', 'array'],
            'features.*' => ['nullable', 'string'],
            'booking_menu' => ['nullable', 'boolean'],
            'vehicles_menu' => ['nullable', 'boolean'],
            'locations_menu' => ['nullable', 'boolean'],
            'customers_menu' => ['nullable', 'boolean'],
            'fleet_management_menu' => ['nullable', 'boolean'],
            'maintenance_schedule_menu' => ['nullable', 'boolean'],
            'extras_menu' => ['nullable', 'boolean'],
            'coupons_menu' => ['nullable', 'boolean'],
            'support_ticket_menu' => ['nullable', 'boolean'],
            'settings_menu' => ['nullable', 'boolean'],
            'community_menu' => ['nullable', 'boolean'],
        ]);

        $features = $request->input('features', []);
        if (is_array($features)) {
            $features = array_values(array_filter(array_map('trim', $features)));
        } else {
            $features = [];
        }

        Package::create([
            'name' => $request->name,
            'eyebrow' => $request->eyebrow,
            'description' => $request->description,
            'price' => $request->price,
            'billing_period' => $request->billing_period,
            'features' => $features,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
            'button_text' => $request->button_text,
            'order' => $request->order,
            'no_of_users' => $this->getLimitValue($request, 'no_of_users'),
            'no_of_invitations' => $this->getLimitValue($request, 'no_of_invitations'),
            'no_of_coupons' => $this->getLimitValue($request, 'no_of_coupons'),
            'no_of_vehicles' => $this->getLimitValue($request, 'no_of_vehicles'),
            'no_of_groups' => $this->getLimitValue($request, 'no_of_groups'),
            'no_of_branches' => $this->getLimitValue($request, 'no_of_branches'),
            'no_of_bookings' => $this->getLimitValue($request, 'no_of_bookings'),
            'no_of_locations' => $this->getLimitValue($request, 'no_of_locations'),
            'no_of_extras' => $this->getLimitValue($request, 'no_of_extras'),
            'no_of_insurances' => $this->getLimitValue($request, 'no_of_insurances'),
            'no_of_features' => $this->getLimitValue($request, 'no_of_features'),
            'no_of_rules' => $this->getLimitValue($request, 'no_of_rules'),
            'no_of_support_tickets' => $this->getLimitValue($request, 'no_of_support_tickets'),
            'no_of_maintenance_schedules' => $this->getLimitValue($request, 'no_of_maintenance_schedules'),
            'booking_menu' => $request->has('booking_menu'),
            'vehicles_menu' => $request->has('vehicles_menu'),
            'locations_menu' => $request->has('locations_menu'),
            'customers_menu' => $request->has('customers_menu'),
            'fleet_management_menu' => $request->has('fleet_management_menu'),
            'maintenance_schedule_menu' => $request->has('maintenance_schedule_menu'),
            'extras_menu' => $request->has('extras_menu'),
            'coupons_menu' => $request->has('coupons_menu'),
            'support_ticket_menu' => $request->has('support_ticket_menu'),
            'settings_menu' => $request->has('settings_menu'),
            'community_menu' => $request->has('community_menu'),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Package created successfully.',
                'redirect' => route('admin.packages.index')
            ]);
        }

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        
        return view('admin.packages.edit', compact('package'));
    }

    
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
            'no_of_maintenance_schedules' => ['nullable', 'integer'],
            'features' => ['nullable', 'array'],
            'features.*' => ['nullable', 'string'],
            'booking_menu' => ['nullable', 'boolean'],
            'vehicles_menu' => ['nullable', 'boolean'],
            'locations_menu' => ['nullable', 'boolean'],
            'customers_menu' => ['nullable', 'boolean'],
            'fleet_management_menu' => ['nullable', 'boolean'],
            'maintenance_schedule_menu' => ['nullable', 'boolean'],
            'extras_menu' => ['nullable', 'boolean'],
            'coupons_menu' => ['nullable', 'boolean'],
            'support_ticket_menu' => ['nullable', 'boolean'],
            'settings_menu' => ['nullable', 'boolean'],
            'community_menu' => ['nullable', 'boolean'],
        ]);

        $features = $request->input('features', []);
        if (is_array($features)) {
            $features = array_values(array_filter(array_map('trim', $features)));
        } else {
            $features = [];
        }

        $package->update([
            'name' => $request->name,
            'eyebrow' => $request->eyebrow,
            'description' => $request->description,
            'price' => $request->price,
            'billing_period' => $request->billing_period,
            'features' => $features,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
            'button_text' => $request->button_text,
            'order' => $request->order,
            'no_of_users' => $this->getLimitValue($request, 'no_of_users'),
            'no_of_invitations' => $this->getLimitValue($request, 'no_of_invitations'),
            'no_of_coupons' => $this->getLimitValue($request, 'no_of_coupons'),
            'no_of_vehicles' => $this->getLimitValue($request, 'no_of_vehicles'),
            'no_of_groups' => $this->getLimitValue($request, 'no_of_groups'),
            'no_of_branches' => $this->getLimitValue($request, 'no_of_branches'),
            'no_of_bookings' => $this->getLimitValue($request, 'no_of_bookings'),
            'no_of_locations' => $this->getLimitValue($request, 'no_of_locations'),
            'no_of_extras' => $this->getLimitValue($request, 'no_of_extras'),
            'no_of_insurances' => $this->getLimitValue($request, 'no_of_insurances'),
            'no_of_features' => $this->getLimitValue($request, 'no_of_features'),
            'no_of_rules' => $this->getLimitValue($request, 'no_of_rules'),
            'no_of_support_tickets' => $this->getLimitValue($request, 'no_of_support_tickets'),
            'no_of_maintenance_schedules' => $this->getLimitValue($request, 'no_of_maintenance_schedules'),
            'booking_menu' => $request->has('booking_menu'),
            'vehicles_menu' => $request->has('vehicles_menu'),
            'locations_menu' => $request->has('locations_menu'),
            'customers_menu' => $request->has('customers_menu'),
            'fleet_management_menu' => $request->has('fleet_management_menu'),
            'maintenance_schedule_menu' => $request->has('maintenance_schedule_menu'),
            'extras_menu' => $request->has('extras_menu'),
            'coupons_menu' => $request->has('coupons_menu'),
            'support_ticket_menu' => $request->has('support_ticket_menu'),
            'settings_menu' => $request->has('settings_menu'),
            'community_menu' => $request->has('community_menu'),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Package updated successfully.',
                'redirect' => route('admin.packages.index')
            ]);
        }

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    private function getLimitValue(Request $request, string $field): ?int
    {
        $limitType = $request->input('limit_type_' . $field);
        if ($limitType === 'unlimited') {
            return null;
        }
        if ($limitType === 'limited') {
            return $request->filled($field) ? (int)$request->input($field) : 0;
        }
        return $request->filled($field) ? (int)$request->input($field) : null;
    }

    
    public function destroy(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Package deleted successfully.'
            ]);
        }

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
