@extends('user.layouts.app')

@section('main-content')
<div class="admin-panel" style="padding: 20px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 style="font-weight: 700; color: #f8fafc; margin-bottom: 5px;">Ticket: {{ $ticket->ticket_number }}</h2>
            <p class="text-muted" style="margin: 0;">Subject: {{ $ticket->subject }}</p>
        </div>
        <a href="{{ route('user.support-tickets.index') }}" class="btn btn-outline" style="border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; font-weight: 600; padding: 10px 20px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); color: #4ade80; padding: 15px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        
        <div class="col-lg-8">
            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div style="padding: 24px; border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(11, 16, 32, 0.8);">
                    <h5 style="color: #f8fafc; font-weight: 600; margin: 0;">Ticket Conversation</h5>
                </div>
                
                <div id="conversationContainer" style="padding: 24px; max-height: 500px; overflow-y: auto; display: flex; flex-direction: column; gap: 20px;">
                    
                    <div style="display: flex; flex-direction: column; align-items: flex-end; width: 100%;">
                        <div style="background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.2); border-radius: 12px 12px 0 12px; padding: 16px; max-width: 85%;">
                            <span style="font-weight: 700; color: #52ead2; font-size: 0.8rem; display: block; margin-bottom: 6px;">You (Customer)</span>
                            <p style="color: #cbd5e1; margin: 0; white-space: pre-line; line-height: 1.5;">{{ $ticket->message }}</p>
                            @if($ticket->attachment)
                                <div style="margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                    <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" style="color: #52ead2; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem;">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                        View Attachment
                                    </a>
                                </div>
                            @endif
                        </div>
                        <small style="color: #64748b; margin-top: 4px; padding-right: 4px;">{{ $ticket->created_at->diffForHumans() }}</small>
                    </div>

                    
                    @foreach($ticket->replies as $reply)
                        @php
                            $isMe = ($reply->user_id === auth()->id());
                        @endphp
                        <div style="display: flex; flex-direction: column; align-items: {{ $isMe ? 'flex-end' : 'flex-start' }}; width: 100%;">
                            <div style="background: {{ $isMe ? 'rgba(82, 234, 210, 0.1)' : 'rgba(255,255,255,0.03)' }}; border: 1px solid {{ $isMe ? 'rgba(82, 234, 210, 0.2)' : 'rgba(255,255,255,0.05)' }}; border-radius: {{ $isMe ? '12px 12px 0 12px' : '12px 12px 12px 0' }}; padding: 16px; max-width: 85%;">
                                <span style="font-weight: 700; color: {{ $isMe ? '#52ead2' : '#94a3b8' }}; font-size: 0.8rem; display: block; margin-bottom: 6px;">
                                    {{ $isMe ? 'You (Customer)' : ($reply->user->company_name ?: $reply->user->name) . ' (Vendor)' }}
                                </span>
                                <p style="color: #cbd5e1; margin: 0; white-space: pre-line; line-height: 1.5;">{{ $reply->message }}</p>
                                @if($reply->attachment)
                                    <div style="margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                        <a href="{{ asset('storage/' . $reply->attachment) }}" target="_blank" style="color: #52ead2; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem;">
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

                
                    <style>
                        .custom-file-box {
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            background: rgba(11, 16, 32, 0.8);
                            border: 1px solid rgba(255, 255, 255, 0.12);
                            border-radius: 8px;
                            padding: 4px 12px;
                            height: 44px;
                            box-sizing: border-box;
                            transition: all 0.2s ease;
                        }
                        .custom-file-btn {
                            background: rgba(82, 234, 210, 0.15) !important;
                            color: #52ead2 !important;
                            border: 1px solid rgba(82, 234, 210, 0.3) !important;
                            font-weight: 700 !important;
                            font-size: 0.8rem !important;
                            border-radius: 6px !important;
                            padding: 6px 14px !important;
                            margin: 0 !important;
                            cursor: pointer !important;
                            white-space: nowrap !important;
                            display: inline-flex !important;
                            align-items: center !important;
                            gap: 6px !important;
                            transition: all 0.2s ease !important;
                        }
                        .custom-file-btn:hover {
                            background: var(--brand, #52ead2) !important;
                            color: #0b1020 !important;
                        }
                        .custom-file-name {
                            color: #94a3b8;
                            font-size: 0.82rem;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            white-space: nowrap;
                            flex: 1;
                        }
                        body.light-mode .custom-file-box {
                            background: #ffffff !important;
                            border-color: #cbd5e1 !important;
                        }
                        body.light-mode .custom-file-btn {
                            background: rgba(13, 148, 136, 0.1) !important;
                            color: #0d9488 !important;
                            border-color: rgba(13, 148, 136, 0.3) !important;
                        }
                        body.light-mode .custom-file-btn:hover {
                            background: #0d9488 !important;
                            color: #ffffff !important;
                        }
                        body.light-mode .custom-file-name {
                            color: #64748b !important;
                        }
                    </style>
                    <form id="ticketReplyForm" action="{{ route('user.support-tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <textarea name="message" id="replyMessage" class="form-control" rows="4" placeholder="Write your reply here..." style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255,255,255,0.1); color: #f8fafc; border-radius: 6px; padding: 12px; width: 100%;" required></textarea>
                        </div>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-7">
                                <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 6px;">Attach file (optional)</label>
                                <div class="custom-file-box">
                                    <label for="replyAttachment" class="custom-file-btn">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                        Choose File
                                    </label>
                                    <span id="replyAttachmentName" class="custom-file-name">No file chosen</span>
                                    <input type="file" name="attachment" id="replyAttachment" style="display: none;" onchange="document.getElementById('replyAttachmentName').textContent = this.files[0] ? this.files[0].name : 'No file chosen'">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <button type="submit" id="replySubmitBtn" class="btn btn-teal" style="font-weight: 800; height: 44px; padding: 0 24px; border-radius: 8px; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                    <span>Send Reply</span>
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>

        
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <h5 style="color: #f8fafc; font-weight: 700; margin-bottom: 20px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 10px;">Ticket Details</h5>
                
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Status</span>
                        <div style="margin-top: 4px;">
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
                        <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Vendor</span>
                        <p style="color: #f8fafc; font-weight: 600; margin: 4px 0 0; font-size: 0.95rem;">{{ $ticket->vendor->company_name ?: $ticket->vendor->name }}</p>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#ticketReplyForm').on('submit', function (e) {
            e.preventDefault();

            const messageInput = $('#replyMessage');
            const msgVal = messageInput.val() ? messageInput.val().trim() : '';

            $('.input-error-msg').remove();
            messageInput.css('border-color', 'rgba(255, 255, 255, 0.1)');

            if (!msgVal) {
                messageInput.css('border-color', '#ef4444');
                messageInput.after('<div class="input-error-msg" style="color: #ef4444; font-size: 0.78rem; font-weight: 600; margin-top: 4px;">Please write a reply message.</div>');
                messageInput.focus();
                return;
            }

            const btn = $('#replySubmitBtn');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Sending...');

            const formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (res) {
                    btn.prop('disabled', false).html('<span>Send Reply</span>');
                    if (res.success) {
                        messageInput.val('');
                        $('#replyAttachment').val('');
                        if (document.getElementById('replyAttachmentName')) {
                            document.getElementById('replyAttachmentName').textContent = 'No file chosen';
                        }

                        let attachmentHtml = '';
                        if (res.reply && res.reply.attachment_url) {
                            attachmentHtml = `
                                <div style="margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                    <a href="${res.reply.attachment_url}" target="_blank" style="color: #52ead2; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem;">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                        View Attachment
                                    </a>
                                </div>
                            `;
                        }

                        const newReplyHtml = `
                            <div style="display: flex; flex-direction: column; align-items: flex-end; width: 100%;">
                                <div style="background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.2); border-radius: 12px 12px 0 12px; padding: 16px; max-width: 85%;">
                                    <span style="font-weight: 700; color: #52ead2; font-size: 0.8rem; display: block; margin-bottom: 6px;">You (Customer)</span>
                                    <p style="color: #cbd5e1; margin: 0; white-space: pre-line; line-height: 1.5;">${res.reply ? res.reply.message : msgVal}</p>
                                    ${attachmentHtml}
                                </div>
                                <small style="color: #64748b; margin-top: 4px; padding: 0 4px;">Just now</small>
                            </div>
                        `;

                        $('#conversationContainer').append(newReplyHtml);
                        const container = document.getElementById('conversationContainer');
                        container.scrollTop = container.scrollHeight;

                        Swal.fire({
                            icon: 'success',
                            title: 'Reply Sent!',
                            text: 'Your reply was added to the ticket.',
                            background: 'rgba(11, 16, 32, 0.95)',
                            confirmButtonColor: '#52ead2',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (xhr) {
                    btn.prop('disabled', false).html('<span>Send Reply</span>');
                    let errMsg = 'Could not send reply. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errMsg,
                        background: 'rgba(11, 16, 32, 0.95)',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        });
    });
</script>
@endsection
