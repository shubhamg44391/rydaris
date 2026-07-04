<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Display a paginated listing of the vehicles.
     */
    public function index()
    {
        $vehicles = Vehicle::where('vendor_id', Auth::id())
            ->with('group')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('vendor.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        $groups = Group::where('vendor_id', Auth::id())->orderBy('name')->get();
        return view('vendor.vehicles.create', compact('groups'));
    }

    /**
     * Store a newly created vehicle in database.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->canAddVehicle()) {
            return redirect()->back()->withInput()->with('error', 'Your package limit for vehicles has been reached. Please upgrade your package.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'seats' => ['required', 'integer', 'min:1'],
            'doors' => ['required', 'integer', 'min:1'],
            'bags' => ['required', 'integer', 'min:0'],
            'group_id' => ['nullable', 'exists:groups,id'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:2048'],
            'gear_system' => ['required', 'string', 'in:manual,automatic'],
            'passengers' => ['required', 'integer', 'min:1'],
            'wheel_drive' => ['required', 'string', 'in:FWD,RWD,AWD'],
            'code' => [
                'required',
                'string',
                Rule::unique('vehicles', 'code')->where(function ($query) {
                    return $query->where('vendor_id', Auth::id());
                }),
            ],
            'stock' => ['required', 'integer', 'min:0'],
            'features' => ['nullable', 'array'],
            'terms' => ['nullable', 'string'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vehicles', 'public');
        }

        Vehicle::create([
            'vendor_id' => Auth::id(),
            'group_id' => $request->group_id,
            'name' => $request->name,
            'model' => $request->model,
            'seats' => $request->seats,
            'doors' => $request->doors,
            'bags' => $request->bags,
            'status' => $request->status,
            'image' => $imagePath,
            'gear_system' => $request->gear_system,
            'passengers' => $request->passengers,
            'wheel_drive' => $request->wheel_drive,
            'code' => $request->code,
            'stock' => $request->stock,
            'features' => $request->features ?? [],
            'terms' => $request->terms,
        ]);

        return redirect(route('vendor.vehicles.index'))->with('success', 'Vehicle created successfully.');
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit($id)
    {
        $vehicle = Vehicle::where('vendor_id', Auth::id())->findOrFail($id);
        $groups = Group::where('vendor_id', Auth::id())->orderBy('name')->get();

        return view('vendor.vehicles.edit', compact('vehicle', 'groups'));
    }

    /**
     * Update the specified vehicle in database.
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::where('vendor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'seats' => ['required', 'integer', 'min:1'],
            'doors' => ['required', 'integer', 'min:1'],
            'bags' => ['required', 'integer', 'min:0'],
            'group_id' => ['nullable', 'exists:groups,id'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:2048'],
            'gear_system' => ['required', 'string', 'in:manual,automatic'],
            'passengers' => ['required', 'integer', 'min:1'],
            'wheel_drive' => ['required', 'string', 'in:FWD,RWD,AWD'],
            'code' => [
                'required',
                'string',
                Rule::unique('vehicles', 'code')->ignore($id)->where(function ($query) {
                    return $query->where('vendor_id', Auth::id());
                }),
            ],
            'stock' => ['required', 'integer', 'min:0'],
            'features' => ['nullable', 'array'],
            'terms' => ['nullable', 'string'],
        ]);

        $data = [
            'group_id' => $request->group_id,
            'name' => $request->name,
            'model' => $request->model,
            'seats' => $request->seats,
            'doors' => $request->doors,
            'bags' => $request->bags,
            'status' => $request->status,
            'gear_system' => $request->gear_system,
            'passengers' => $request->passengers,
            'wheel_drive' => $request->wheel_drive,
            'code' => $request->code,
            'stock' => $request->stock,
            'features' => $request->features ?? [],
            'terms' => $request->terms,
        ];

        if ($request->hasFile('image')) {
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect(route('vendor.vehicles.index'))->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified vehicle from database.
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::where('vendor_id', Auth::id())->findOrFail($id);

        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }
        $vehicle->delete();

        return redirect(route('vendor.vehicles.index'))->with('success', 'Vehicle deleted successfully.');
    }
}
