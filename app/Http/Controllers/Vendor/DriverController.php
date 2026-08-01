<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Driver::where('vendor_id', Auth::id())->orderBy('created_at', 'desc');

        if ($status && in_array($status, ['active', 'inactive'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('license_number', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $drivers = $query->paginate(10)->appends([
            'status' => $status,
            'search' => $search,
        ]);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'html' => view('vendor.drivers.partials.table', compact('drivers', 'status', 'search'))->render(),
                'status' => $status,
                'search' => $search,
            ]);
        }

        return view('vendor.drivers.index', compact('drivers', 'status', 'search'));
    }

    public function create()
    {
        return view('vendor.drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max:50',
                Rule::unique('drivers', 'phone')->where(function ($query) {
                    return $query->where('vendor_id', Auth::id());
                }),
            ],
            'address' => 'required|string',
            'email' => 'nullable|email|max:255',
            'license_number' => 'nullable|string|max:100',
            'license_expiry' => 'nullable|date',
            'license_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:5120',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Driver Name is mandatory.',
            'phone.required' => 'Mobile Number is mandatory.',
            'phone.unique' => 'You already have a driver registered with this Mobile Number.',
            'address.required' => 'Address is mandatory.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('drivers', 'public');
        }

        $licenseImagePath = null;
        if ($request->hasFile('license_image')) {
            $licenseImagePath = $request->file('license_image')->store('drivers/licenses', 'public');
        }

        $driver = Driver::create([
            'vendor_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'license_number' => $request->license_number,
            'license_expiry' => $request->license_expiry,
            'license_image' => $licenseImagePath,
            'photo' => $photoPath,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Driver added successfully.',
                'redirect' => route('vendor.drivers.index')
            ]);
        }

        return redirect()->route('vendor.drivers.index')->with('success', 'Driver added successfully.');
    }

    public function show($id)
    {
        $driver = Driver::with(['bookings' => function($q) {
            $q->with(['vehicle', 'pickupLocation', 'returnLocation', 'user'])->orderBy('created_at', 'desc');
        }])->where('vendor_id', Auth::id())->findOrFail($id);

        $bookings = $driver->bookings;
        
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'driver' => [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'phone' => $driver->phone,
                    'email' => $driver->email ?? 'N/A',
                    'address' => $driver->address,
                    'license_number' => $driver->license_number ?? 'N/A',
                    'license_expiry' => $driver->license_expiry ? \Carbon\Carbon::parse($driver->license_expiry)->format('Y-m-d') : 'N/A',
                    'license_image_url' => $driver->license_image ? asset('storage/' . $driver->license_image) : null,
                    'notes' => $driver->notes ?? 'N/A',
                    'status' => ucfirst($driver->status),
                    'photo_url' => $driver->photo ? asset('storage/' . $driver->photo) : null,
                    'created_at' => $driver->created_at->format('Y-m-d H:i')
                ]
            ]);
        }

        return view('vendor.drivers.show', compact('driver', 'bookings'));
    }

    public function edit($id)
    {
        $driver = Driver::where('vendor_id', Auth::id())->findOrFail($id);
        return view('vendor.drivers.edit', compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::where('vendor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max:50',
                Rule::unique('drivers', 'phone')->where(function ($query) {
                    return $query->where('vendor_id', Auth::id());
                })->ignore($driver->id),
            ],
            'address' => 'required|string',
            'email' => 'nullable|email|max:255',
            'license_number' => 'nullable|string|max:100',
            'license_expiry' => 'nullable|date',
            'license_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:5120',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Driver Name is mandatory.',
            'phone.required' => 'Mobile Number is mandatory.',
            'phone.unique' => 'You already have a driver registered with this Mobile Number.',
            'address.required' => 'Address is mandatory.',
        ]);

        $photoPath = $driver->photo;
        if ($request->hasFile('photo')) {
            if ($driver->photo && Storage::disk('public')->exists($driver->photo)) {
                Storage::disk('public')->delete($driver->photo);
            }
            $photoPath = $request->file('photo')->store('drivers', 'public');
        }

        $licenseImagePath = $driver->license_image;
        if ($request->hasFile('license_image')) {
            if ($driver->license_image && Storage::disk('public')->exists($driver->license_image)) {
                Storage::disk('public')->delete($driver->license_image);
            }
            $licenseImagePath = $request->file('license_image')->store('drivers/licenses', 'public');
        }

        $driver->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'license_number' => $request->license_number,
            'license_expiry' => $request->license_expiry,
            'license_image' => $licenseImagePath,
            'photo' => $photoPath,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Driver updated successfully.',
                'redirect' => route('vendor.drivers.index')
            ]);
        }

        return redirect()->route('vendor.drivers.index')->with('success', 'Driver updated successfully.');
    }

    public function destroy($id)
    {
        $driver = Driver::where('vendor_id', Auth::id())->findOrFail($id);
        
        $hasActiveBooking = \App\Models\Booking::where('driver_id', $driver->id)
            ->whereNotIn('booking_status', ['completed', 'cancelled'])
            ->exists();

        if ($hasActiveBooking) {
            $errorMessage = 'This driver is assigned to an active booking. Please remove the assignment before deleting.';
            if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ]);
            }
            return redirect()->route('vendor.drivers.index')->with('error', $errorMessage);
        }

        if ($driver->photo && Storage::disk('public')->exists($driver->photo)) {
            Storage::disk('public')->delete($driver->photo);
        }

        if ($driver->license_image && Storage::disk('public')->exists($driver->license_image)) {
            Storage::disk('public')->delete($driver->license_image);
        }

        $driver->delete();

        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Driver deleted successfully.'
            ]);
        }

        return redirect()->route('vendor.drivers.index')->with('success', 'Driver deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $driver = Driver::where('vendor_id', Auth::id())->findOrFail($id);
        $driver->status = ($driver->status === 'active') ? 'inactive' : 'active';
        $driver->save();

        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Driver status updated successfully.',
                'status' => $driver->status
            ]);
        }

        return redirect()->back()->with('success', 'Driver status updated successfully.');
    }
}
