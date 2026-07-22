@extends('user.layouts.app')

@section('main-content')
<style>
    /* ── btn-teal matches frontend gradient ── */
    .btn-teal {
        background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%);
        color: #051013;
        border: none;
        box-shadow: 0 4px 15px rgba(82, 234, 210, 0.25);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 999px !important;
        font-weight: 800;
    }
    .btn-teal:hover {
        opacity: 0.92;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(82, 234, 210, 0.45);
        color: #051013;
    }

    /* ═══════════════════════════════════════════════
       LIGHT MODE — SUPPORT TICKETS TABLE
    ═══════════════════════════════════════════════ */
    body.light-mode h2[style*="color: #f8fafc"] {
        color: #0f172a !important;
    }

    /* Table container */
    body.light-mode .table-responsive[style*="background: rgba(11, 16, 32"] {
        background: #ffffff !important;
        border: 1px solid rgba(15, 23, 42, 0.08) !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
    }

    /* Table base text */
    body.light-mode .table.table-borderless {
        color: #475569 !important;
    }

    /* Thead border */
    body.light-mode tr[style*="border-bottom: 1px solid rgba(255,255,255,0.1)"] {
        border-bottom: 1px solid rgba(15, 23, 42, 0.1) !important;
    }

    /* Thead cells */
    body.light-mode th[style*="color: #cbd5e1"] {
        color: #64748b !important;
        font-size: 0.78rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.07em !important;
        font-weight: 700 !important;
        background: #f8fafc !important;
    }

    /* Tbody row borders */
    body.light-mode tr[style*="border-bottom: 1px solid rgba(255,255,255,0.05)"],
    body.light-mode table tbody tr {
        border-bottom: 1px solid #cbd5e1 !important;
    }

    /* Ticket number (white → dark) */
    body.light-mode strong[style*="color: #f8fafc"] {
        color: #0f172a !important;
    }

    /* Subject / muted text */
    body.light-mode span[style*="color: #64748b"],
    body.light-mode small[style*="color: #64748b"],
    body.light-mode td[style*="color: #64748b"] {
        color: #94a3b8 !important;
    }

    /* Category text */
    body.light-mode td[style*="color: #cbd5e1"] {
        color: #475569 !important;
    }

    /* Attachment link (teal) */
    body.light-mode a[style*="color: #52ead2"] {
        color: #0f766e !important;
    }

    /* No Attachment span */
    body.light-mode span[style*="color: #64748b"] {
        color: #94a3b8 !important;
    }

    /* Empty state */
    body.light-mode td[style*="color: #64748b; font-style: italic"] {
        color: #94a3b8 !important;
    }

    /* Priority badges */
    body.light-mode .badge[style*="color: #f87171"] {
        background: rgba(220, 38, 38, 0.08) !important;
        color: #dc2626 !important;
        border-color: rgba(220, 38, 38, 0.18) !important;
    }
    body.light-mode .badge[style*="color: #facc15"] {
        background: rgba(161, 98, 7, 0.08) !important;
        color: #a16207 !important;
        border-color: rgba(161, 98, 7, 0.18) !important;
    }
    body.light-mode .badge[style*="color: #93c5fd"] {
        background: rgba(37, 99, 235, 0.08) !important;
        color: #2563eb !important;
        border-color: rgba(37, 99, 235, 0.18) !important;
    }

    /* Status badges */
    body.light-mode .badge[style*="color: #4ade80"] {
        background: rgba(21, 128, 61, 0.08) !important;
        color: #15803d !important;
        border-color: rgba(21, 128, 61, 0.18) !important;
    }
    body.light-mode .badge[style*="color: #94a3b8"] {
        background: rgba(71, 85, 105, 0.08) !important;
        color: #475569 !important;
        border-color: rgba(71, 85, 105, 0.18) !important;
    }

    /* Action "Reply" button */
    body.light-mode a.btn.btn-sm[style*="rgba(82, 234, 210, 0.1)"] {
        background: rgba(15, 118, 110, 0.08) !important;
        color: #0f766e !important;
        border-color: rgba(15, 118, 110, 0.2) !important;
    }
    body.light-mode a.btn.btn-sm[style*="rgba(82, 234, 210, 0.1)"]:hover {
        background: rgba(15, 118, 110, 0.15) !important;
        color: #0f766e !important;
        border-color: rgba(15, 118, 110, 0.35) !important;
    }

    /* Success alert */
    body.light-mode .alert[style*="color: #4ade80"] {
        background: rgba(21, 128, 61, 0.06) !important;
        border-color: rgba(21, 128, 61, 0.2) !important;
        color: #15803d !important;
    }
</style>
<div class="admin-panel" style="padding: 20px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="font-weight: 700; color: #f8fafc; margin-bottom: 5px;">Support Tickets</h2>
            <p class="text-muted" style="margin: 0;">Raise and manage your support inquiries here.</p>
        </div>
        <a href="{{ route('user.support-tickets.create') }}" class="btn btn-teal" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 10px 20px; border-radius: 6px; text-decoration: none;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add New
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); color: #4ade80; padding: 15px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 20px;">
        <table class="table table-borderless" style="color: #94a3b8; margin-bottom: 0; vertical-align: middle;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Attachment</th>
                    <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Ticket</th>
                    <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Priority</th>
                    <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Status</th>
                    <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Category</th>
                    <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Time</th>
                    <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        
                        <td style="padding: 15px 10px;">
                            @if($ticket->attachment)
                                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" style="color: #52ead2; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                    View File
                                </a>
                            @else
                                <span style="color: #64748b;">No Attachment</span>
                            @endif
                        </td>
                        
                        
                        <td style="padding: 15px 10px;">
                            <strong style="color: #f8fafc; display: block; font-size: 0.95rem;">{{ $ticket->ticket_number }}</strong>
                            <span style="font-size: 0.8rem; color: #64748b;">{{ $ticket->subject }}</span>
                        </td>
                        
                        
                        <td style="padding: 15px 10px;">
                            @if($ticket->priority === 'high')
                                <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">High</span>
                            @elseif($ticket->priority === 'medium')
                                <span class="badge" style="background: rgba(234, 179, 8, 0.2); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Medium</span>
                            @else
                                <span class="badge" style="background: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Low</span>
                            @endif
                        </td>
                        
                        
                        <td style="padding: 15px 10px;">
                            @if($ticket->status === 'open')
                                <span class="badge" style="background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Open</span>
                            @else
                                <span class="badge" style="background: rgba(100, 116, 139, 0.2); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Closed</span>
                            @endif
                        </td>
                        
                        
                        <td style="padding: 15px 10px; font-weight: 500; color: #cbd5e1;">
                            {{ $ticket->category }}
                        </td>
                        
                        
                        <td style="padding: 15px 10px; font-size: 0.85rem;">
                            {{ $ticket->created_at->format('M d, Y') }}<br>
                            <small style="color: #64748b;">{{ $ticket->created_at->format('h:i A') }}</small>
                        </td>
                        
                        
                        <td style="padding: 15px 10px; text-align: right;">
                            <a href="{{ route('user.support-tickets.show', $ticket->id) }}" class="btn btn-sm" style="background: rgba(82, 234, 210, 0.1); color: #52ead2; border: 1px solid rgba(82, 234, 210, 0.2); font-weight: 600; padding: 6px 12px; border-radius: 4px; text-decoration: none;">
                                Reply
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #64748b; font-style: italic;">
                            No support tickets raised yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
