<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index()
    {
        $subscription = auth()->user()->activeSubscription;
        $limit = $subscription ? $subscription->package->no_of_branches : 0;
        return view('vendor.branches.index', compact('limit'));
    }

    

    public function list()
    {
        $branches = Branch::where('vendor_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $subscription = auth()->user()->activeSubscription;
        $limit = $subscription ? $subscription->package->no_of_branches : 0;

        return response()->json([
            'status' => 'success',
            'branches' => $branches,
            'limit_text' => is_null($limit) || $limit === -1 ? 'Unlimited' : $limit,
            'used' => $branches->count(),
            'can_add' => auth()->user()->canAddBranch(),
        ]);
    }

    

    public function store(Request $request)
    {
        if (!auth()->user()->canAddBranch()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your package limit for branches has been reached. Please upgrade your package.'
            ], 422);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $branch = Branch::create([
            'vendor_id' => Auth::id(),
            'name' => $request->name,
            'status' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Branch created successfully.',
            'branch' => $branch
        ]);
    }

    

    public function edit($id)
    {
        $branch = Branch::where('vendor_id', Auth::id())->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'branch' => $branch
        ]);
    }

    

    public function update(Request $request, $id)
    {
        $branch = Branch::where('vendor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
        ]);

        $branch->update([
            'name' => $request->name,
            'status' => (bool)$request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Branch updated successfully.',
            'branch' => $branch
        ]);
    }

    

    public function destroy($id)
    {
        $branch = Branch::where('vendor_id', Auth::id())->findOrFail($id);
        $branch->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Branch deleted successfully.'
        ]);
    }

    

    public function selectBranch(Request $request)
    {
        $request->validate([
            'branch_id' => ['nullable', 'exists:branches,id'],
        ]);

        $user = auth()->user();

        if (empty($request->branch_id)) {
            $user->update(['current_branch_id' => null]);
            return response()->json([
                'status' => 'success',
                'message' => 'Switched to all branches view.',
            ]);
        }

        
        $branch = Branch::where('vendor_id', $user->id)
                        ->where('status', true)
                        ->findOrFail($request->branch_id);
        
        $user->update(['current_branch_id' => $branch->id]);

        return response()->json([
            'status' => 'success',
            'message' => "Switched to branch: {$branch->name}.",
        ]);
    }
}
