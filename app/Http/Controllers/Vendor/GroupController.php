<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    

    public function index()
    {
        $query = Group::where('vendor_id', Auth::id());

        $branchId = auth()->user()->current_branch_id;
        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id');
            });
        }

        $groups = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('vendor.groups.index', compact('groups'));
    }

    

    public function create()
    {
        if (!auth()->user()->canAddGroup()) {
            return redirect()->route('vendor.groups.index')->with('error', 'Your package limit for vehicle groups has been reached. Please upgrade your package.');
        }
        return view('vendor.groups.create');
    }

    

    public function store(Request $request)
    {
        if (!auth()->user()->canAddGroup()) {
            return redirect()->back()->withInput()->with('error', 'Your package limit for vehicle groups has been reached. Please upgrade your package.');
        }

        $branchId = auth()->user()->current_branch_id;

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('groups', 'name')->where(function ($query) use ($branchId) {
                    return $query->where('vendor_id', Auth::id())
                                 ->where('branch_id', $branchId);
                }),
            ],
            'description' => ['nullable', 'string'],
        ], [
            'name.unique' => 'You already have a vehicle group with this name in this branch. Please use a different name.',
            'name.required' => 'Group name is required.',
            'name.max' => 'Group name must not exceed 255 characters.',
        ]);

        Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'vendor_id' => Auth::id(),
            'branch_id' => $branchId,
        ]);

        return redirect(route('vendor.groups.index'))->with('success', 'Vehicle Group created successfully.');
    }

    

    public function edit($id)
    {
        $group = Group::where('vendor_id', Auth::id())->findOrFail($id);
        return view('vendor.groups.edit', compact('group'));
    }

    

    public function update(Request $request, $id)
    {
        $group = Group::where('vendor_id', Auth::id())->findOrFail($id);
        $branchId = auth()->user()->current_branch_id;

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('groups', 'name')->ignore($id)->where(function ($query) use ($branchId) {
                    return $query->where('vendor_id', Auth::id())
                                 ->where('branch_id', $branchId);
                }),
            ],
            'description' => ['nullable', 'string'],
        ], [
            'name.unique' => 'You already have a vehicle group with this name in this branch. Please use a different name.',
            'name.required' => 'Group name is required.',
            'name.max' => 'Group name must not exceed 255 characters.',
        ]);

        $group->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect(route('vendor.groups.index'))->with('success', 'Vehicle Group updated successfully.');
    }

    

    public function destroy($id)
    {
        $group = Group::where('vendor_id', Auth::id())->findOrFail($id);
        $group->delete();

        return redirect(route('vendor.groups.index'))->with('success', 'Vehicle Group deleted successfully.');
    }
}
