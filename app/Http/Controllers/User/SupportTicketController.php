<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\User;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        return view('user.tickets.index', compact('tickets'));
    }

    public function create()
    {
        
        $vendors = User::where('role', 'vendor')
            ->where('status', 'active')
            ->get();

        return view('user.tickets.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        $vendor = User::find($request->input('vendor_id'));
        if ($vendor && !$vendor->canAcceptSupportTickets()) {
            return back()->withInput()->withErrors(['subject' => 'This vendor cannot receive new support tickets at this time due to package limits.']);
        }

        $ticketNumber = 'STK-' . date('Ymd') . '-' . mt_rand(100, 999) . '-' . mt_rand(100, 999);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('tickets', 'public');
        }

        SupportTicket::create([
            'user_id' => auth()->id(),
            'vendor_id' => $request->input('vendor_id'),
            'ticket_number' => $ticketNumber,
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'category' => $request->input('category'),
            'priority' => $request->input('priority'),
            'status' => 'open',
            'attachment' => $attachmentPath
        ]);

        return redirect()->route('user.support-tickets.index')->with('success', 'Support ticket created successfully!');
    }

    public function show($id)
    {
        $ticket = SupportTicket::with(['replies.user', 'vendor'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('user.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $ticket = SupportTicket::where('user_id', auth()->id())->findOrFail($id);

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

        
        if ($ticket->status === 'closed') {
            $ticket->update(['status' => 'open']);
        }

        return redirect()->back()->with('success', 'Reply submitted successfully!');
    }
}
