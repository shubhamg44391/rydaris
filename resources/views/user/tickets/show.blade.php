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
        <!-- Conversation area -->
        <div class="col-lg-8">
            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div style="padding: 24px; border-bottom: 1px solid rgba(255,255,255,0.05); background: rgba(11, 16, 32, 0.8);">
                    <h5 style="color: #f8fafc; font-weight: 600; margin: 0;">Ticket Conversation</h5>
                </div>
                
                <div style="padding: 24px; max-height: 500px; overflow-y: auto; display: flex; flex-direction: column; gap: 20px;">
                    <!-- Original Message (Created by User) -->
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

                    <!-- Replies -->
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

                <!-- Submit Reply Box -->
                <div style="padding: 24px; background: rgba(11, 16, 32, 0.8); border-top: 1px solid rgba(255,255,255,0.05);">
                    <form action="{{ route('user.support-tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
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
                                <button type="submit" class="btn btn-teal" style="font-weight: 600; padding: 10px 24px; border-radius: 6px; width: 100%;">
                                    Send Reply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ticket Details Sidebar -->
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
@endsection
