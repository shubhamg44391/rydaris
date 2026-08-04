<div class="row g-3">
    {{-- Left: Conversation log --}}
    <div class="col-lg-8">
        <div style="background: rgba(11, 16, 32, 0.9); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; overflow: hidden;">
            <div style="padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.02); display: flex; justify-content: space-between; align-items: center;">
                <h6 style="color: #f8fafc; font-weight: 700; margin: 0;">Ticket Conversation</h6>
                <span id="modal-status-badge">
                    @if($ticket->status === 'open')
                        <span class="badge" style="background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Open</span>
                    @else
                        <span class="badge" style="background: rgba(100, 116, 139, 0.2); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Closed</span>
                    @endif
                </span>
            </div>
            
            <div id="modal-conversation-log" style="padding: 20px; max-height: 400px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px;">
                {{-- Original Customer Ticket --}}
                <div style="display: flex; flex-direction: column; align-items: flex-start; width: 100%;">
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px 12px 12px 0; padding: 14px; max-width: 88%;">
                        <span style="font-weight: 700; color: #94a3b8; font-size: 0.78rem; display: block; margin-bottom: 4px;">{{ $ticket->user->first_name ?? $ticket->user->name }} (Customer)</span>
                        <p style="color: #cbd5e1; margin: 0; white-space: pre-line; font-size: 0.9rem; line-height: 1.4;">{{ $ticket->message }}</p>
                        @if($ticket->attachment)
                            <div style="margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 6px;">
                                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" style="color: var(--brand, #52ead2); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-size: 0.78rem;">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                    View Attachment
                                </a>
                            </div>
                        @endif
                    </div>
                    <small style="color: #64748b; margin-top: 3px; font-size: 0.75rem;">{{ $ticket->created_at->diffForHumans() }}</small>
                </div>

                {{-- Replies --}}
                @foreach($ticket->replies as $reply)
                    @php $isVendor = ($reply->user_id === auth()->id()); @endphp
                    <div style="display: flex; flex-direction: column; align-items: {{ $isVendor ? 'flex-end' : 'flex-start' }}; width: 100%;">
                        <div style="background: {{ $isVendor ? 'rgba(82, 234, 210, 0.08)' : 'rgba(255,255,255,0.03)' }}; border: 1px solid {{ $isVendor ? 'rgba(82, 234, 210, 0.25)' : 'rgba(255,255,255,0.08)' }}; border-radius: {{ $isVendor ? '12px 12px 0 12px' : '12px 12px 12px 0' }}; padding: 14px; max-width: 88%;">
                            <span style="font-weight: 700; color: {{ $isVendor ? 'var(--brand, #52ead2)' : '#94a3b8' }}; font-size: 0.78rem; display: block; margin-bottom: 4px;">
                                {{ $isVendor ? 'You (Vendor)' : ($reply->user->first_name ?? $reply->user->name) . ' (Customer)' }}
                            </span>
                            <p style="color: #cbd5e1; margin: 0; white-space: pre-line; font-size: 0.9rem; line-height: 1.4;">{{ $reply->message }}</p>
                            @if($reply->attachment)
                                <div style="margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 6px;">
                                    <a href="{{ asset('storage/' . $reply->attachment) }}" target="_blank" style="color: var(--brand, #52ead2); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-size: 0.78rem;">
                                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>
                                        View Attachment
                                    </a>
                                </div>
                            @endif
                        </div>
                        <small style="color: #64748b; margin-top: 3px; font-size: 0.75rem;">{{ $reply->created_at->diffForHumans() }}</small>
                    </div>
                @endforeach
            </div>

            {{-- Reply Form --}}
            <div style="padding: 16px 20px; background: rgba(0, 0, 0, 0.2); border-top: 1px solid rgba(255,255,255,0.08);">
                <form id="modalReplyForm" onsubmit="submitModalReply(event, {{ $ticket->id }})" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <textarea name="message" class="form-control" rows="3" placeholder="Write your reply..." required style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #fff; border-radius: 8px; padding: 10px 12px; font-size: 0.88rem; outline: none;"></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <input type="file" name="attachment" class="form-control form-control-sm" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #cbd5e1; border-radius: 6px; width: auto; max-width: 250px; font-size: 0.8rem;">
                        <button type="submit" id="modal-reply-btn" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); border: none; color: #051013; font-weight: 700; padding: 8px 22px; border-radius: 999px; font-size: 0.88rem;">
                            Send Reply
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right: Ticket Details --}}
    <div class="col-lg-4">
        <div style="background: rgba(11, 16, 32, 0.9); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; padding: 18px;">
            <h6 style="color: #f8fafc; font-weight: 700; margin-bottom: 14px; border-bottom: 1px dashed rgba(255,255,255,0.1); padding-bottom: 8px;">Ticket Meta</h6>
            
            <div class="d-flex flex-column gap-3" style="font-size: 0.85rem;">
                <div>
                    <span style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Subject</span>
                    <p style="color: #f8fafc; font-weight: 600; margin: 2px 0 0;">{{ $ticket->subject }}</p>
                </div>

                <div>
                    <span style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Category</span>
                    <p style="color: #f8fafc; font-weight: 600; margin: 2px 0 0;">{{ $ticket->category }}</p>
                </div>

                <div>
                    <span style="color: #64748b; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Customer</span>
                    <p style="color: #f8fafc; font-weight: 600; margin: 2px 0 0;">{{ $ticket->user->first_name ?? $ticket->user->name }}</p>
                    <small style="color: #94a3b8;">{{ $ticket->user->email }}</small>
                </div>

                @if($ticket->status === 'open')
                    <div style="margin-top: 10px;">
                        <button type="button" onclick="closeTicketAjax({{ $ticket->id }})" class="btn btn-sm btn-danger w-100" style="background: #ef4444; border: none; font-weight: 700; border-radius: 6px; padding: 8px;">
                            Close Ticket
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
