<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * Display a paginated listing of the groups belonging to the logged-in vendor.
     */
    public function index()
    {
        $groups = Group::where('vendor_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('vendor.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new group.
     */
    public function create()
    {
        return view('vendor.groups.create');
    }

    /**
     * Store a newly created group in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('groups', 'name')->where(function ($query) {
                    return $query->where('vendor_id', Auth::id());
                }),
            ],
            'description' => ['nullable', 'string'],
        ], [
            'name.unique' => 'You already have a vehicle group with this name. Please use a different name.',
            'name.required' => 'Group name is required.',
            'name.max' => 'Group name must not exceed 255 characters.',
        ]);

        Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'vendor_id' => Auth::id(),
        ]);

        return redirect(route('vendor.groups.index'))->with('success', 'Vehicle Group created successfully.');
    }

    /**
     * Show the form for editing the specified group.
     */
    public function edit($id)
    {
        $group = Group::where('vendor_id', Auth::id())->findOrFail($id);
        return view('vendor.groups.edit', compact('group'));
    }

    /**
     * Update the specified group in database.
     */
    public function update(Request $request, $id)
    {
        $group = Group::where('vendor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('groups', 'name')->ignore($id)->where(function ($query) {
                    return $query->where('vendor_id', Auth::id());
                }),
            ],
            'description' => ['nullable', 'string'],
        ], [
            'name.unique' => 'You already have a vehicle group with this name. Please use a different name.',
            'name.required' => 'Group name is required.',
            'name.max' => 'Group name must not exceed 255 characters.',
        ]);

        $group->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect(route('vendor.groups.index'))->with('success', 'Vehicle Group updated successfully.');
    }

    /**
     * Remove the specified group from database.
     */
    public function destroy($id)
    {
        $group = Group::where('vendor_id', Auth::id())->findOrFail($id);
        $group->delete();

        return redirect(route('vendor.groups.index'))->with('success', 'Vehicle Group deleted successfully.');
    }
}
