<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PickupLocation;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Display a paginated listing of this vendor's locations.
     */
    public function index()
    {
        $locations = PickupLocation::where('vendor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('vendor.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new location.
     */
    public function create()
    {
        $types = PickupLocation::types();
        return view('vendor.locations.create', compact('types'));
    }

    /**
     * Store a newly created location in database.
     */
    public function store(Request $request)
    {
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

    /**
     * Show the form for editing the specified location.
     */
    public function edit($id)
    {
        $location = PickupLocation::where('vendor_id', Auth::id())->findOrFail($id);
        $types    = PickupLocation::types();

        return view('vendor.locations.edit', compact('location', 'types'));
    }

    /**
     * Update the specified location in database.
     */
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

    /**
     * Remove the specified location from database.
     */
    public function destroy($id)
    {
        $location = PickupLocation::where('vendor_id', Auth::id())->findOrFail($id);
        $location->delete();

        return redirect(route('vendor.locations.index'))
            ->with('success', 'Location deleted successfully.');
    }
}
