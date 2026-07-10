@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2>Support Tickets</h2>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); color: #4ade80; padding: 15px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="panel-body admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Attachment</th>
                    <th>Ticket</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>Customer</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <!-- Attachment -->
                        <td>
                            @if($ticket->attachment)
                                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" style="color: var(--brand, #52ead2); text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                    View File
                                </a>
                            @else
                                <span style="color: #64748b;">No Attachment</span>
                            @endif
                        </td>
                        
                        <!-- Ticket -->
                        <td>
                            <strong style="color: #f8fafc; display: block; font-size: 0.95rem;">{{ $ticket->ticket_number }}</strong>
                            <span style="font-size: 0.8rem; color: #64748b;">{{ $ticket->subject }}</span>
                        </td>
                        
                        <!-- Priority -->
                        <td>
                            @if($ticket->priority === 'high')
                                <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">High</span>
                            @elseif($ticket->priority === 'medium')
                                <span class="badge" style="background: rgba(234, 179, 8, 0.2); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Medium</span>
                            @else
                                <span class="badge" style="background: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Low</span>
                            @endif
                        </td>
                        
                        <!-- Status -->
                        <td>
                            @if($ticket->status === 'open')
                                <span class="badge" style="background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Open</span>
                            @else
                                <span class="badge" style="background: rgba(100, 116, 139, 0.2); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Closed</span>
                            @endif
                        </td>
                        
                        <!-- Category -->
                        <td style="font-weight: 500; color: #cbd5e1;">
                            {{ $ticket->category }}
                        </td>
 
                        <!-- Customer -->
                        <td>
                            <strong style="color: #cbd5e1; display: block; font-size: 0.9rem;">{{ $ticket->user->first_name ?? $ticket->user->name }}</strong>
                            <span style="font-size: 0.8rem; color: #64748b;">{{ $ticket->user->email }}</span>
                        </td>
                        
                        <!-- Time -->
                        <td style="font-size: 0.85rem;">
                            {{ $ticket->created_at->format('M d, Y') }}<br>
                            <small style="color: #64748b;">{{ $ticket->created_at->format('h:i A') }}</small>
                        </td>
                        
                        <!-- Actions -->
                        <td>
                            <a href="{{ route('vendor.support-tickets.show', $ticket->id) }}" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none; padding: 6px 16px;">
                                Reply
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #64748b; font-style: italic;">
                            No support tickets assigned to you yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
