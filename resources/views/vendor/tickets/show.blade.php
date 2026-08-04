@extends('admin.layouts.app')

@section('main-content')
<div class="container-fluid p-4" style="min-width: 0; max-width: 100%; overflow-x: hidden;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0 text-white" style="font-weight: 800;">Ticket: {{ $ticket->ticket_number }}</h3>
            <p class="text-muted" style="margin: 5px 0 0;">Subject: {{ $ticket->subject }}</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <div id="ticket-action-close">
                @if($ticket->status === 'open')
                    <button type="button" onclick="closePageTicket({{ $ticket->id }})" class="btn btn-danger" style="background: #ef4444; border-color: #ef4444; font-weight: 600; padding: 10px 20px; border-radius: 6px; cursor: pointer;">
                        Close Ticket
                    </button>
                @endif
            </div>
            <a href="{{ route('vendor.support-tickets.index') }}" class="btn btn-outline" style="border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600; padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.02);">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Back to List
            </a>
        </div>
    </div>

    <div class="row">
        
        <div class="col-lg-8">
            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div style="padding: 24px; border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(11, 16, 32, 0.8);">
                    <h5 style="color: #f8fafc; font-weight: 600; margin: 0;">Ticket Conversation</h5>
                </div>
                
                <div id="page-conversation-log" style="padding: 24px; max-height: 500px; overflow-y: auto; display: flex; flex-direction: column; gap: 20px;">
                    
                    {{-- Customer Ticket Message --}}
                    <div style="display: flex; flex-direction: column; align-items: flex-start; width: 100%;">
                        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px 12px 12px 0; padding: 16px; max-width: 85%;">
                            <span style="font-weight: 700; color: #94a3b8; font-size: 0.8rem; display: block; margin-bottom: 6px;">{{ $ticket->user->first_name ?? $ticket->user->name }} (Customer)</span>
                            <p style="color: #cbd5e1; margin: 0; white-space: pre-line; line-height: 1.5;">{{ $ticket->message }}</p>
                            @if($ticket->attachment)
                                <div style="margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                    <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" style="color: var(--brand, #52ead2); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem;">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                        View Attachment
                                    </a>
                                </div>
                            @endif
                        </div>
                        <small style="color: #64748b; margin-top: 4px; padding-left: 4px;">{{ $ticket->created_at->diffForHumans() }}</small>
                    </div>

                    {{-- Replies --}}
                    @foreach($ticket->replies as $reply)
                        @php
                            $isVendor = ($reply->user_id === auth()->id());
                        @endphp
                        <div style="display: flex; flex-direction: column; align-items: {{ $isVendor ? 'flex-end' : 'flex-start' }}; width: 100%;">
                            <div style="background: {{ $isVendor ? 'rgba(82, 234, 210, 0.08)' : 'rgba(255,255,255,0.03)' }}; border: 1px solid {{ $isVendor ? 'rgba(82, 234, 210, 0.25)' : 'rgba(255,255,255,0.05)' }}; border-radius: {{ $isVendor ? '12px 12px 0 12px' : '12px 12px 12px 0' }}; padding: 16px; max-width: 85%;">
                                <span style="font-weight: 700; color: {{ $isVendor ? 'var(--brand, #52ead2)' : '#94a3b8' }}; font-size: 0.8rem; display: block; margin-bottom: 6px;">
                                    {{ $isVendor ? 'You (Vendor)' : ($reply->user->first_name ?? $reply->user->name) . ' (Customer)' }}
                                </span>
                                <p style="color: #cbd5e1; margin: 0; white-space: pre-line; line-height: 1.5;">{{ $reply->message }}</p>
                                @if($reply->attachment)
                                    <div style="margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                        <a href="{{ asset('storage/' . $reply->attachment) }}" target="_blank" style="color: var(--brand, #52ead2); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem;">
                                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                            View Attachment
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <small style="color: #64748b; margin-top: 4px; padding: 0 4px;">{{ $reply->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>

                {{-- Reply Form --}}
                <div style="padding: 24px; background: rgba(11, 16, 32, 0.8); border-top: 1px solid rgba(255,255,255,0.05);">
                    <form id="pageReplyForm" action="{{ route('vendor.support-tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" onsubmit="submitPageReply(event)">
                        @csrf
                        <div class="mb-3">
                            <textarea name="message" class="form-control" rows="4" placeholder="Write your reply here..." style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255,255,255,0.1); color: #f8fafc; border-radius: 6px; padding: 12px; width: 100%;" required></textarea>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-7 mb-3 mb-md-0">
                                <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 4px;">Attach file (optional)</label>
                                <input type="file" name="attachment" class="form-control" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; border-radius: 4px; padding: 6px;">
                            </div>
                            <div class="col-md-5 text-end">
                                <button type="submit" id="page-reply-btn" class="btn btn-primary" style="background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%); border: none; color: #051013; font-weight: 700; padding: 10px 24px; border-radius: 999px; width: 100%;">
                                    Send Reply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Details Side Card --}}
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <h5 style="color: #f8fafc; font-weight: 700; margin-bottom: 20px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 10px;">Ticket Details</h5>
                
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Status</span>
                        <div style="margin-top: 4px;" id="page-status-badge">
                            @if($ticket->status === 'open')
                                <span class="badge" style="background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); font-size: 0.8rem; padding: 4px 12px; border-radius: 4px;">Open</span>
                            @else
                                <span class="badge" style="background: rgba(100, 116, 139, 0.2); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.3); font-size: 0.8rem; padding: 4px 12px; border-radius: 4px;">Closed</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Priority</span>
                        <div style="margin-top: 4px;">
                            @if($ticket->priority === 'high')
                                <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); font-size: 0.8rem; padding: 4px 12px; border-radius: 4px;">High</span>
                            @elseif($ticket->priority === 'medium')
                                <span class="badge" style="background: rgba(234, 179, 8, 0.2); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3); font-size: 0.8rem; padding: 4px 12px; border-radius: 4px;">Medium</span>
                            @else
                                <span class="badge" style="background: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3); font-size: 0.8rem; padding: 4px 12px; border-radius: 4px;">Low</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Department</span>
                        <p style="color: #f8fafc; font-weight: 600; margin: 4px 0 0; font-size: 0.95rem;">{{ $ticket->category }}</p>
                    </div>

                    <div>
                        <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Customer Name</span>
                        <p style="color: #f8fafc; font-weight: 600; margin: 4px 0 0; font-size: 0.95rem;">{{ $ticket->user->first_name ?? $ticket->user->name }}</p>
                    </div>

                    <div>
                        <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Customer Email</span>
                        <p style="color: #f8fafc; font-weight: 600; margin: 4px 0 0; font-size: 0.95rem;">{{ $ticket->user->email }}</p>
                    </div>

                    <div>
                        <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Opened Time</span>
                        <p style="color: #f8fafc; font-weight: 600; margin: 4px 0 0; font-size: 0.95rem;">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function submitPageReply(e) {
    if (e && e.preventDefault) e.preventDefault();
    
    var form = document.getElementById('pageReplyForm');
    var formData = new FormData(form);
    var btn = $('#page-reply-btn');
    
    btn.prop('disabled', true).css('opacity', '0.7');
    
    $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            btn.prop('disabled', false).css('opacity', '1');
            if (response.status === 'success') {
                form.reset();
                var reply = response.reply;
                var attachmentHtml = reply.attachment_url ? 
                    '<div style="margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;"><a href="' + reply.attachment_url + '" target="_blank" style="color: var(--brand, #52ead2); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem;"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>View Attachment</a></div>' : '';

                var newReplyHtml = '<div style="display: flex; flex-direction: column; align-items: flex-end; width: 100%;"><div style="background: rgba(82, 234, 210, 0.08); border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 12px 12px 0 12px; padding: 16px; max-width: 85%;"><span style="font-weight: 700; color: var(--brand, #52ead2); font-size: 0.8rem; display: block; margin-bottom: 6px;">You (Vendor)</span><p style="color: #cbd5e1; margin: 0; white-space: pre-line; line-height: 1.5;">' + reply.message + '</p>' + attachmentHtml + '</div><small style="color: #64748b; margin-top: 4px; padding: 0 4px;">' + reply.created_at + '</small></div>';

                $('#page-conversation-log').append(newReplyHtml);
                $('#page-conversation-log').scrollTop($('#page-conversation-log')[0].scrollHeight);
                $('#page-status-badge').html('<span class="badge" style="background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); font-size: 0.8rem; padding: 4px 12px; border-radius: 4px;">Open</span>');

                Swal.fire({
                    icon: 'success',
                    title: 'Reply Sent!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Error', response.message || 'Failed to submit reply.', 'error');
            }
        },
        error: function(xhr) {
            btn.prop('disabled', false).css('opacity', '1');
            var msg = 'Failed to submit reply.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            Swal.fire('Validation Error', msg, 'error');
        }
    });
}

function closePageTicket(ticketId) {
    Swal.fire({
        title: 'Close Ticket?',
        text: "Are you sure you want to mark this ticket as closed?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#475569',
        confirmButtonText: 'Yes, Close Ticket'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ url("vendor/support-tickets") }}/' + ticketId + '/close',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(response) {
                    if(response.status === 'success') {
                        Swal.fire('Closed!', response.message, 'success');
                        $('#page-status-badge').html('<span class="badge" style="background: rgba(100, 116, 139, 0.2); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.3); font-size: 0.8rem; padding: 4px 12px; border-radius: 4px;">Closed</span>');
                        $('#ticket-action-close').empty();
                    } else {
                        Swal.fire('Error', response.message || 'Failed to close ticket.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to close ticket.', 'error');
                }
            });
        }
    });
}
</script>
@endsection
