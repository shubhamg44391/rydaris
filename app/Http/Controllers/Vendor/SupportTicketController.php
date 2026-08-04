<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = SupportTicket::with('user')
            ->where('vendor_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        if ($request->ajax()) {
            $html = view('vendor.tickets.partials.ticket_table', compact('tickets'))->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }

        return view('vendor.tickets.index', compact('tickets'));
    }

    public function show(Request $request, $id)
    {
        $ticket = SupportTicket::with(['replies.user', 'user'])
            ->where('vendor_id', auth()->id())
            ->findOrFail($id);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'ticket' => $ticket,
                'html' => view('vendor.tickets.partials.modal_content', compact('ticket'))->render()
            ]);
        }

        return view('vendor.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $ticket = SupportTicket::where('vendor_id', auth()->id())->findOrFail($id);

        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('tickets', 'public');
        }

        $reply = SupportTicketReply::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $request->input('message'),
            'attachment' => $attachmentPath
        ]);

        if ($ticket->status === 'closed') {
            $ticket->update(['status' => 'open']);
        }

        if ($request->ajax()) {
            $reply->load('user');
            $attachmentUrl = $reply->attachment ? asset('storage/' . $reply->attachment) : null;
            return response()->json([
                'status' => 'success',
                'message' => 'Reply submitted successfully!',
                'reply' => [
                    'id' => $reply->id,
                    'user_name' => 'You (Vendor)',
                    'message' => e($reply->message),
                    'created_at' => $reply->created_at->diffForHumans(),
                    'attachment_url' => $attachmentUrl,
                    'is_vendor' => true
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Reply submitted successfully!');
    }

    public function close(Request $request, $id)
    {
        $ticket = SupportTicket::where('vendor_id', auth()->id())->findOrFail($id);
        $ticket->update(['status' => 'closed']);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Ticket closed successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Ticket closed successfully!');
    }
}
