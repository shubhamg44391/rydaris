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
    

    public function index(Request $request)
    {
        $query = Vehicle::where('vendor_id', Auth::id())->with('group');
        
        $branchId = auth()->user()->current_branch_id;
        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id');
            });
        }

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $vehicles = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'html' => view('vendor.vehicles.index', compact('vehicles'))->renderSections()['vehicles_table_section'] ?? '',
            ]);
        }

        return view('vendor.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        if (!auth()->user()->canAddVehicle()) {
            return redirect()->route('vendor.vehicles.index')->with('error', 'Your package limit for vehicles has been reached. Please upgrade your package.');
        }
        $branchId = auth()->user()->current_branch_id;
        $groupsQuery = Group::where('vendor_id', Auth::id());
        if ($branchId) {
            $groupsQuery->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id');
            });
        }
        $groups = $groupsQuery->orderBy('name')->get();
        return view('vendor.vehicles.create', compact('groups'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canAddVehicle()) {
            $msg = 'Your package limit for vehicles has been reached. Please upgrade your package.';
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return redirect()->back()->withInput()->with('error', $msg);
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

        $vehicle = Vehicle::create([
            'vendor_id' => Auth::id(),
            'branch_id' => auth()->user()->current_branch_id,
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

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Vehicle created successfully.',
                'redirect_url' => route('vendor.vehicles.index')
            ]);
        }

        return redirect(route('vendor.vehicles.index'))->with('success', 'Vehicle created successfully.');
    }

    public function edit($id)
    {
        $vehicle = Vehicle::where('vendor_id', Auth::id())->findOrFail($id);
        $branchId = auth()->user()->current_branch_id;
        $groupsQuery = Group::where('vendor_id', Auth::id());
        if ($branchId) {
            $groupsQuery->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id');
            });
        }
        $groups = $groupsQuery->orderBy('name')->get();

        return view('vendor.vehicles.edit', compact('vehicle', 'groups'));
    }

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

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Vehicle updated successfully.',
                'redirect_url' => route('vendor.vehicles.index')
            ]);
        }

        return redirect(route('vendor.vehicles.index'))->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $vehicle = Vehicle::where('vendor_id', Auth::id())->findOrFail($id);

        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }
        $vehicle->delete();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Vehicle deleted successfully.'
            ]);
        }

        return redirect(route('vendor.vehicles.index'))->with('success', 'Vehicle deleted successfully.');
    }
}
