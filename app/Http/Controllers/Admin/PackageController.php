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
            'button_text' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer'],
            'no_of_users' => ['nullable', 'integer'],
            'no_of_coupons' => ['nullable', 'integer'],
            'no_of_vehicles' => ['nullable', 'integer'],
            'no_of_groups' => ['nullable', 'integer'],
        ]);

        Package::create([
            'name' => $request->name,
            'eyebrow' => $request->eyebrow,
            'description' => $request->description,
            'price' => $request->price,
            'billing_period' => $request->billing_period,
            'features' => [], // no longer used from input
            'is_featured' => $request->has('is_featured'),
            'button_text' => $request->button_text,
            'order' => $request->order,
            'no_of_users' => $request->no_of_users,
            'no_of_coupons' => $request->no_of_coupons,
            'no_of_vehicles' => $request->no_of_vehicles,
            'no_of_groups' => $request->no_of_groups,
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
            'button_text' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer'],
            'no_of_users' => ['nullable', 'integer'],
            'no_of_coupons' => ['nullable', 'integer'],
            'no_of_vehicles' => ['nullable', 'integer'],
            'no_of_groups' => ['nullable', 'integer'],
        ]);

        $package->update([
            'name' => $request->name,
            'eyebrow' => $request->eyebrow,
            'description' => $request->description,
            'price' => $request->price,
            'billing_period' => $request->billing_period,
            'features' => [], // no longer used from input
            'is_featured' => $request->has('is_featured'),
            'button_text' => $request->button_text,
            'order' => $request->order,
            'no_of_users' => $request->no_of_users,
            'no_of_coupons' => $request->no_of_coupons,
            'no_of_vehicles' => $request->no_of_vehicles,
            'no_of_groups' => $request->no_of_groups,
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
