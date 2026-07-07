<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomPackageRequest;

class AdminCustomPackageRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $query = CustomPackageRequest::orderBy('created_at', 'desc');
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $requests = $query->paginate(20);
        return view('admin.custom-package-requests.index', compact('requests'));
    }

    public function destroy($id)
    {
        $request = CustomPackageRequest::findOrFail($id);
        $request->delete();

        return back()->with('success', 'Custom package request deleted successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $inquiry = CustomPackageRequest::findOrFail($id);
        
        $inquiry->status = $inquiry->status === 'unread' ? 'read' : 'unread';
        $inquiry->save();

        return back()->with('success', "Status updated to {$inquiry->status}.");
    }
}
