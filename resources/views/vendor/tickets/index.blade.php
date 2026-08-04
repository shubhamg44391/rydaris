@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2>Support Tickets</h2>
        </div>
    </div>

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
            <tbody id="tickets-table-body">
                @include('vendor.tickets.partials.ticket_table')
            </tbody>
        </table>
    </div>
</div>

{{-- Quick View/Reply AJAX Modal --}}
<div class="modal fade" id="ticketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="background: #0b1020; border: 1px solid rgba(255,255,255,0.12); color: #fff; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.08); padding: 18px 24px;">
                <h5 class="modal-title" id="ticketModalTitle" style="font-weight: 700; color: #f8fafc;">Support Ticket</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="ticketModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border text-info" role="status">
                        <span class="visually-hidden">Loading...</span>
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
function openTicketModal(ticketId) {
    var modal = new bootstrap.Modal(document.getElementById('ticketModal'));
    $('#ticketModalTitle').text('Loading Ticket #' + ticketId + '...');
    $('#ticketModalBody').html('<div class="text-center py-5"><div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div></div>');
    modal.show();

    $.ajax({
        url: '{{ url("vendor/support-tickets") }}/' + ticketId,
        type: 'GET',
        dataType: 'json',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            if(response.status === 'success') {
                $('#ticketModalTitle').text('Ticket: ' + response.ticket.ticket_number);
                $('#ticketModalBody').html(response.html);
            } else {
                $('#ticketModalBody').html('<div class="alert alert-danger">Failed to load ticket content.</div>');
            }
        },
        error: function() {
            $('#ticketModalBody').html('<div class="alert alert-danger">Error fetching ticket details.</div>');
        }
    });
}

function submitModalReply(e, ticketId) {
    if (e && e.preventDefault) e.preventDefault();
    
    var form = document.getElementById('modalReplyForm');
    var formData = new FormData(form);
    var btn = $('#modal-reply-btn');
    
    btn.prop('disabled', true).css('opacity', '0.7');
    
    $.ajax({
        url: '{{ url("vendor/support-tickets") }}/' + ticketId + '/reply',
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
                    '<div style="margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 6px;"><a href="' + reply.attachment_url + '" target="_blank" style="color: var(--brand, #52ead2); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-size: 0.78rem;"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg>View Attachment</a></div>' : '';

                var newReplyHtml = '<div style="display: flex; flex-direction: column; align-items: flex-end; width: 100%;"><div style="background: rgba(82, 234, 210, 0.08); border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 12px 12px 0 12px; padding: 14px; max-width: 88%;"><span style="font-weight: 700; color: var(--brand, #52ead2); font-size: 0.78rem; display: block; margin-bottom: 4px;">You (Vendor)</span><p style="color: #cbd5e1; margin: 0; white-space: pre-line; font-size: 0.9rem; line-height: 1.4;">' + reply.message + '</p>' + attachmentHtml + '</div><small style="color: #64748b; margin-top: 3px; font-size: 0.75rem;">' + reply.created_at + '</small></div>';

                $('#modal-conversation-log').append(newReplyHtml);
                $('#modal-conversation-log').scrollTop($('#modal-conversation-log')[0].scrollHeight);
                $('#modal-status-badge').html('<span class="badge" style="background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Open</span>');

                Swal.fire({
                    icon: 'success',
                    title: 'Reply Sent!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                loadTicketsTable();
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

function closeTicketAjax(ticketId) {
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
                        $('#modal-status-badge').html('<span class="badge" style="background: rgba(100, 116, 139, 0.2); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.3); font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;">Closed</span>');
                        loadTicketsTable();
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

function loadTicketsTable() {
    $.ajax({
        url: '{{ route("vendor.support-tickets.index") }}',
        type: 'GET',
        dataType: 'json',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            if(response.status === 'success') {
                $('#tickets-table-body').html(response.html);
            }
        }
    });
}
</script>
@endsection
