<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoInquiry;
use Illuminate\Http\Request;

class AdminDemoInquiryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = DemoInquiry::orderBy('created_at', 'desc');

        if ($status === 'unread') {
            $query->where('status', 'unread');
        } elseif ($status === 'read') {
            $query->where('status', 'read');
        }

        $inquiries = $query->paginate(20)->appends(['status' => $status]);

        $totalCount  = DemoInquiry::count();
        $unreadCount = DemoInquiry::where('status', 'unread')->count();
        $readCount   = DemoInquiry::where('status', 'read')->count();

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('admin.demo-inquiries.partials.table', compact('inquiries', 'status'))->render();
            return response()->json([
                'success'     => true,
                'html'        => $html,
                'totalCount'  => $totalCount,
                'unreadCount' => $unreadCount,
                'readCount'   => $readCount,
            ]);
        }

        return view('admin.demo-inquiries.index', compact('inquiries', 'status', 'totalCount', 'unreadCount', 'readCount'));
    }

    public function destroy($id)
    {
        DemoInquiry::findOrFail($id)->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Demo inquiry deleted successfully.'
            ]);
        }

        return back()->with('success', 'Demo inquiry deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $inquiry = DemoInquiry::findOrFail($id);
        $newStatus = $inquiry->status === 'unread' ? 'read' : 'unread';
        $inquiry->update(['status' => $newStatus]);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Demo inquiry status updated successfully.',
                'status' => $inquiry->status
            ]);
        }

        return back()->with('success', 'Demo inquiry status updated successfully.');
    }
}
