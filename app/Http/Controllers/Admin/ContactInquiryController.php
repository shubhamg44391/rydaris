<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactInquiry;

class ContactInquiryController extends Controller
{
    

    public function index(\Illuminate\Http\Request $request)
    {
        $status = $request->query('status');

        $query = ContactInquiry::orderBy('created_at', 'desc');

        if ($status === 'unread') {
            $query->where('status', 'unread');
        } elseif ($status === 'read') {
            $query->where('status', 'read');
        }

        $inquiries = $query->paginate(10)->appends(['status' => $status]);

        
        $totalCount  = ContactInquiry::count();
        $unreadCount = ContactInquiry::where('status', 'unread')->count();
        $readCount   = ContactInquiry::where('status', 'read')->count();

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('admin.contact_inquiries.partials.table', compact('inquiries', 'status'))->render();
            return response()->json([
                'success'     => true,
                'html'        => $html,
                'totalCount'  => $totalCount,
                'unreadCount' => $unreadCount,
                'readCount'   => $readCount,
            ]);
        }

        return view('admin.contact_inquiries.index', compact('inquiries', 'status', 'totalCount', 'unreadCount', 'readCount'));
    }

    

    public function show($id)
    {
        $inquiry = ContactInquiry::findOrFail($id);
        if ($inquiry->status === 'unread') {
            $inquiry->update(['status' => 'read']);
        }

        return view('admin.contact_inquiries.show', compact('inquiry'));
    }

    public function toggleStatus($id)
    {
        $inquiry = ContactInquiry::findOrFail($id);
        $newStatus = $inquiry->status === 'unread' ? 'read' : 'unread';
        $inquiry->update(['status' => $newStatus]);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Inquiry status updated successfully.',
                'status' => $inquiry->status
            ]);
        }

        return redirect()->back()->with('success', 'Inquiry status updated successfully.');
    }

    

    public function destroy($id)
    {
        $inquiry = ContactInquiry::findOrFail($id);
        $inquiry->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Inquiry deleted successfully.'
            ]);
        }

        return redirect()->route('admin.contact-inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}
