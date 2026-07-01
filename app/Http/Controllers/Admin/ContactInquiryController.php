<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactInquiry;

class ContactInquiryController extends Controller
{
    /**
     * Display a listing of the contact inquiries.
     */
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

        // Counts for badges
        $totalCount  = ContactInquiry::count();
        $unreadCount = ContactInquiry::where('status', 'unread')->count();
        $readCount   = ContactInquiry::where('status', 'read')->count();

        return view('admin.contact_inquiries.index', compact('inquiries', 'status', 'totalCount', 'unreadCount', 'readCount'));
    }

    /**
     * Toggle the status of the contact inquiry between read and unread.
     */
    public function toggleStatus($id)
    {
        $inquiry = ContactInquiry::findOrFail($id);
        $newStatus = $inquiry->status === 'unread' ? 'read' : 'unread';
        $inquiry->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Inquiry status updated successfully.');
    }

    /**
     * Remove the specified contact inquiry from database.
     */
    public function destroy($id)
    {
        $inquiry = ContactInquiry::findOrFail($id);
        $inquiry->delete();

        return redirect()->route('admin.contact-inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}
