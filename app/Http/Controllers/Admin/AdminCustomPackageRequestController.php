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
        
        $requests = $query->paginate(20)->appends(['status' => $status]);

        $totalCount  = CustomPackageRequest::count();
        $unreadCount = CustomPackageRequest::where('status', 'unread')->count();
        $readCount   = CustomPackageRequest::where('status', 'read')->count();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            $html = view('admin.custom-package-requests.partials.table', compact('requests', 'status'))->render();
            return response()->json([
                'success'     => true,
                'html'        => $html,
                'totalCount'  => $totalCount,
                'unreadCount' => $unreadCount,
                'readCount'   => $readCount,
            ]);
        }

        return view('admin.custom-package-requests.index', compact('requests', 'status', 'totalCount', 'unreadCount', 'readCount'));
    }

    public function destroy($id)
    {
        $req = CustomPackageRequest::findOrFail($id);
        $req->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Custom package request deleted successfully.'
            ]);
        }

        return back()->with('success', 'Custom package request deleted successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $inquiry = CustomPackageRequest::findOrFail($id);
        
        $inquiry->status = $inquiry->status === 'unread' ? 'read' : 'unread';
        $inquiry->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'    => true,
                'message'    => "Status updated to {$inquiry->status}.",
                'status'     => $inquiry->status,
                'new_status' => $inquiry->status
            ]);
        }

        return back()->with('success', "Status updated to {$inquiry->status}.");
    }
}
