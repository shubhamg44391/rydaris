<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserDashboardController extends Controller
{
    public function index()
    {
        $bookings = [];
        if (auth()->check()) {
            $bookings = \App\Models\Booking::with('vehicle')
                ->where('user_id', auth()->id())
                ->orderBy('id', 'desc')
                ->get();
        }
        return view('user.dashboard', compact('bookings'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        
        $vendorsQuery = User::where('role', 'vendor')
            ->where('status', 'active');

        
        if (auth()->check() && auth()->user()->vendor_id) {
            $vendorsQuery->where('id', auth()->user()->vendor_id);
        }

        $vendorsQuery->whereHas('subscription', function($query) {
                $query->where('status', 'active')
                      ->where('starts_at', '<=', now())
                      ->where('ends_at', '>=', now());
            })
            ->with(['vehicles' => function($query) {
                $query->where('status', 'active');
            }]);

        if ($search) {
            $vendorsQuery->where(function($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $vendors = $vendorsQuery->get();

        return view('user.search', compact('vendors', 'search'));
    }

    public function showVendor(Request $request, $id)
    {
        $vendor = User::where('role', 'vendor')
            ->where('status', 'active')
            ->whereHas('subscription', function($query) {
                $query->where('status', 'active')
                      ->where('starts_at', '<=', now())
                      ->where('ends_at', '>=', now());
            })
            ->findOrFail($id);

        
        if (auth()->check() && auth()->user()->vendor_id && auth()->user()->vendor_id != $vendor->id) {
            abort(403, 'You are not authorized to view other vendors.');
        }

        
        $branches = \App\Models\Branch::where('vendor_id', $id)->where('status', true)->orderBy('name')->get();
        $selectedBranchId = $request->input('branch_id');

        $locationsQuery = \App\Models\PickupLocation::where('vendor_id', $id);
        if ($selectedBranchId) {
            $locationsQuery->where('branch_id', $selectedBranchId);
        }
        $locations = $locationsQuery->get();

        
        $pickupDate = $request->input('pickup_date'); 
        $returnDate = $request->input('return_date'); 
        $rentalDays = 2; 

        if ($pickupDate && $returnDate) {
            try {
                $pDate = \Carbon\Carbon::createFromFormat('d/m/Y', $pickupDate);
                $rDate = \Carbon\Carbon::createFromFormat('d/m/Y', $returnDate);
                $diff = $pDate->diffInDays($rDate);
                $rentalDays = $diff > 0 ? $diff : 1;
            } catch (\Exception $e) {
                $rentalDays = 2;
            }
        }

        
        $vehiclesQuery = \App\Models\Vehicle::where('vendor_id', $id)->where('status', 'active');
        
        if ($selectedBranchId) {
            $vehiclesQuery->where('branch_id', $selectedBranchId);
        }
        
        if ($request->input('transmission') && $request->input('transmission') !== 'All') {
            $vehiclesQuery->where('gear_system', $request->input('transmission'));
        }

        $vehicles = $vehiclesQuery->get();

        
        
        foreach ($vehicles as $vehicle) {
            $availability = \App\Models\VehicleAvailability::where('vehicle_id', $vehicle->id)
                ->where('status', 1)
                ->orderBy('price', 'asc')
                ->first();
            
            $vehicle->base_price = $availability ? $availability->price : 50.00; 
            $vehicle->total_price = $vehicle->base_price * $rentalDays;
        }

        
        $sortPrice = $request->input('sort_price');
        if ($sortPrice === 'highest') {
            $vehicles = $vehicles->sortByDesc('total_price')->values();
        } elseif ($sortPrice === 'lowest') {
            $vehicles = $vehicles->sortBy('total_price')->values();
        }

        return view('user.vendors.show', compact('vendor', 'locations', 'vehicles', 'rentalDays', 'branches', 'selectedBranchId'));
    }
}
