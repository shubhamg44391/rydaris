<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with('user')
            ->where('vendor_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('vendor.tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = SupportTicket::with(['replies.user', 'user'])
            ->where('vendor_id', auth()->id())
            ->findOrFail($id);

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

        SupportTicketReply::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $request->input('message'),
            'attachment' => $attachmentPath
        ]);

        // Keep it open or updated
        if ($ticket->status === 'closed') {
            $ticket->update(['status' => 'open']);
        }

        return redirect()->back()->with('success', 'Reply submitted successfully!');
    }

    public function close($id)
    {
        $ticket = SupportTicket::where('vendor_id', auth()->id())->findOrFail($id);
        $ticket->update(['status' => 'closed']);

        return redirect()->back()->with('success', 'Ticket closed successfully!');
    }
}
