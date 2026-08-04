<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    

    public function index(Request $request)
    {
        $query = Group::where('vendor_id', Auth::id());

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
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $groups = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'html' => view('vendor.groups.index', compact('groups'))->renderSections()['groups_table_section'] ?? '',
            ]);
        }

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
            $msg = 'Your package limit for vehicle groups has been reached. Please upgrade your package.';
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return redirect()->back()->withInput()->with('error', $msg);
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

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'vendor_id' => Auth::id(),
            'branch_id' => $branchId,
        ]);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Vehicle Group created successfully.',
                'group' => $group
            ]);
        }

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

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Vehicle Group updated successfully.',
                'group' => $group
            ]);
        }

        return redirect(route('vendor.groups.index'))->with('success', 'Vehicle Group updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $group = Group::where('vendor_id', Auth::id())->findOrFail($id);
        $group->delete();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Vehicle Group deleted successfully.'
            ]);
        }

        return redirect(route('vendor.groups.index'))->with('success', 'Vehicle Group deleted successfully.');
    }
}
