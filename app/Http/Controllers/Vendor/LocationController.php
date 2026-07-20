<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PickupLocation;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    

    public function index()
    {
        $query = PickupLocation::where('vendor_id', Auth::id());
        
        $branchId = auth()->user()->current_branch_id;
        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id');
            });
        }

        $locations = $query->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('vendor.locations.index', compact('locations'));
    }

    

    public function create()
    {
        if (!Auth::user()->canAddLocation()) {
            return redirect()->route('vendor.locations.index')->with('error', 'You have reached your maximum location capacity based on your current plan. Upgrade your plan to add more locations.');
        }
        $types = PickupLocation::types();
        return view('vendor.locations.create', compact('types'));
    }

    

    public function store(Request $request)
    {
        if (!Auth::user()->canAddLocation()) {
            return back()->withInput()->withErrors(['location' => 'You have reached your maximum location capacity based on your current plan. Upgrade your plan to add more locations.']);
        }

        $request->validate([
            'type'      => ['required', 'string', 'in:' . implode(',', PickupLocation::types())],
            'location'  => ['required', 'string', 'max:255'],
            'price'     => ['required', 'numeric', 'min:0'],
            'map_type'  => ['required', 'in:coordinates,embedded'],
            'latitude'  => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'map_embed' => ['nullable', 'string'],
        ]);

        PickupLocation::create([
            'vendor_id' => Auth::id(),
            'branch_id' => auth()->user()->current_branch_id,
            'type'      => $request->type,
            'location'  => $request->location,
            'price'     => $request->price,
            'map_type'  => $request->map_type,
            'latitude'  => $request->map_type === 'coordinates' ? $request->latitude  : null,
            'longitude' => $request->map_type === 'coordinates' ? $request->longitude : null,
            'map_embed' => $request->map_type === 'embedded'    ? $request->map_embed  : null,
        ]);

        return redirect(route('vendor.locations.index'))
            ->with('success', 'Location added successfully.');
    }

    

    public function edit($id)
    {
        $location = PickupLocation::where('vendor_id', Auth::id())->findOrFail($id);
        $types    = PickupLocation::types();

        return view('vendor.locations.edit', compact('location', 'types'));
    }

    

    public function update(Request $request, $id)
    {
        $location = PickupLocation::where('vendor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'type'      => ['required', 'string', 'in:' . implode(',', PickupLocation::types())],
            'location'  => ['required', 'string', 'max:255'],
            'price'     => ['required', 'numeric', 'min:0'],
            'map_type'  => ['required', 'in:coordinates,embedded'],
            'latitude'  => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'map_embed' => ['nullable', 'string'],
        ]);

        $location->update([
            'type'      => $request->type,
            'location'  => $request->location,
            'price'     => $request->price,
            'map_type'  => $request->map_type,
            'latitude'  => $request->map_type === 'coordinates' ? $request->latitude  : null,
            'longitude' => $request->map_type === 'coordinates' ? $request->longitude : null,
            'map_embed' => $request->map_type === 'embedded'    ? $request->map_embed  : null,
        ]);

        return redirect(route('vendor.locations.index'))
            ->with('success', 'Location updated successfully.');
    }

    

    public function destroy($id)
    {
        $location = PickupLocation::where('vendor_id', Auth::id())->findOrFail($id);
        $location->delete();

        return redirect(route('vendor.locations.index'))
            ->with('success', 'Location deleted successfully.');
    }
}
