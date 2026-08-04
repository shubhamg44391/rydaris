@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2>User Invitations</h2>
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 4px; margin-bottom: 0;">Invite your customers to register and track their status.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                <div style="position: relative; min-width: 220px;">
                    <input type="text" id="invitationSearchInput" placeholder="Search name or email..." value="{{ request('search') }}" class="form-control" style="padding: 9px 16px 9px 38px; border-radius: 999px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.1)); color: var(--text, #f8fafc); font-size: 0.88rem; width: 100%;">
                    <svg viewBox="0 0 24 24" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; fill: none; stroke: #94a3b8; stroke-width: 2;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
                <div>
                    <select id="invitationStatusFilter" class="form-select" style="padding: 9px 16px; border-radius: 999px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.1)); color: var(--text, #f8fafc); font-size: 0.88rem; cursor: pointer;">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }} style="background: #0f172a; color: #fff;">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} style="background: #0f172a; color: #fff;">Pending</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }} style="background: #0f172a; color: #fff;">Accepted</option>
                    </select>
                </div>
                <button type="button" onclick="openAddInvitationModal()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 20px; background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border-radius: 999px; font-weight: 800 !important; font-size: 0.85rem; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35); white-space: nowrap; flex-shrink: 0; transition: all 0.2s;">
                    <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 3;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Send Invitation
                </button>
            </div>
        </div>

        {{-- Statistics --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            {{-- Total Sent --}}
            <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px;">
                <div style="background: rgba(82, 234, 210, 0.1); color: var(--brand, #52ead2); padding: 12px; border-radius: 10px;">
                    <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </div>
                <div>
                    <span style="display: block; color: #94a3b8; font-size: 0.85rem; font-weight: 500;">Total Invitations Sent</span>
                    <strong id="totalCountDisplay" style="font-size: 1.6rem; color: #f8fafc;">{{ $totalCount }}</strong>
                </div>
            </div>
            
            {{-- Pending --}}
            <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px;">
                <div style="background: rgba(251, 191, 36, 0.1); color: #fbbf24; padding: 12px; border-radius: 10px;">
                    <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div>
                    <span style="display: block; color: #94a3b8; font-size: 0.85rem; font-weight: 500;">Pending Registration</span>
                    <strong id="pendingCountDisplay" style="font-size: 1.6rem; color: #fbbf24;">{{ $pendingCount }}</strong>
                </div>
            </div>

            {{-- Accepted --}}
            <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px;">
                <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 12px; border-radius: 10px;">
                    <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <div>
                    <span style="display: block; color: #94a3b8; font-size: 0.85rem; font-weight: 500;">Accepted & Registered</span>
                    <strong id="acceptedCountDisplay" style="font-size: 1.6rem; color: #10b981;">{{ $acceptedCount }}</strong>
                </div>
            </div>
        </div>

        <div id="invitationsTableContainer">
        @section('invitations_table_section')
            <div class="panel-body admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">S.No</th>
                            <th>Invited Name</th>
                            <th>Email Address</th>
                            <th>Status</th>
                            <th>Sent Date</th>
                            <th style="width: 180px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startingNumber = ($invitations->currentPage() - 1) * $invitations->perPage() + 1;
                        @endphp
                        @forelse ($invitations as $invitation)
                            <tr>
                                <td>{{ $startingNumber++ }}</td>
                                <td>{{ $invitation->name ?? 'N/A' }}</td>
                                <td>{{ $invitation->email }}</td>
                                <td>
                                    @if($invitation->status === 'pending')
                                        <span class="badge" style="background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.25); padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">
                                            Pending
                                        </span>
                                    @else
                                        <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25); padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">
                                            Accepted
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $invitation->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="table-actions" style="display: flex; gap: 8px; justify-content: center;">
                                        @if($invitation->status === 'pending')
                                            <form action="{{ route('vendor.invitations.resend', $invitation->id) }}" method="POST" class="resend-form" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="icon-button resend-btn" title="Resend Invitation Email" style="color: #60a5fa; background: rgba(96, 165, 250, 0.1); border: 1px solid rgba(96, 165, 250, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                                    <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                                </button>
                                            </form>

                                            <button type="button" onclick="openEditInvitationModal({{ $invitation->id }})" class="icon-button edit-btn" title="Edit Invitation" style="color: var(--brand, #52ead2); background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                                <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </button>
                                        @endif

                                        <form action="{{ route('vendor.invitations.destroy', $invitation->id) }}" method="POST" class="delete-form" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-button delete-btn" title="Delete Invitation" style="color: #ef4444; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                                <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4" style="color: #94a3b8; text-align: center;">No invitations found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line, rgba(255, 255, 255, 0.08)); display: flex; justify-content: space-between; align-items: center; padding: 12px 24px;">
                <div class="text-muted small">
                    Showing {{ $invitations->firstItem() ?? 0 }} to {{ $invitations->lastItem() ?? 0 }} of {{ $invitations->total() }} entries
                </div>
                <div>
                    {{ $invitations->links('vendor.pagination.custom') }}
                </div>
            </div>
        @show
        </div>
    {{-- Add/Edit Invitation Modal --}}
    <div id="invitationModal" class="custom-modal">
        <div class="modal-content" style="max-width: 550px; padding: 25px; border-radius: 12px; background: rgba(11, 16, 32, 0.95); border: 1px solid rgba(82, 234, 210, 0.2); box-shadow: 0 24px 80px rgba(0,0,0,0.6); width: 100%;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px;">
                <h3 id="invitationModalTitle" style="margin: 0; color: #f8fafc;">Send New Invitation</h3>
                <span onclick="closeInvitationModal()" style="color: #94a3b8; font-size: 24px; cursor: pointer;">&times;</span>
            </div>
            
            <form id="invitationForm" onsubmit="submitInvitationModalForm(event)">
                <input type="hidden" id="modal_invitation_id" name="invitation_id" value="">
                
                <div style="margin-bottom: 15px;">
                    <label class="form-label-custom" style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 6px; display: block;">Invited Person's Name (Optional)</label>
                    <input type="text" id="modal_inv_name" class="form-control" placeholder="Enter full name (e.g. John Doe)" style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.15)); color: var(--text, #f8fafc);">
                </div>

                <div style="margin-bottom: 15px;">
                    <label class="form-label-custom" style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 6px; display: block;">Email Address <span style="color: #ef4444;">*</span></label>
                    <input type="email" id="modal_inv_email" required class="form-control" placeholder="Enter email address (e.g. john@example.com)" style="width: 100%; padding: 10px 14px; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid var(--line, rgba(255,255,255,0.15)); color: var(--text, #f8fafc);">
                </div>

                <div id="invitationEditNote" style="display: none; background: rgba(251, 191, 36, 0.05); border: 1px solid rgba(251, 191, 36, 0.15); border-radius: 8px; padding: 12px; margin-bottom: 20px;">
                    <span style="color: #cbd5e1; font-size: 0.8rem; line-height: 1.4; display: block;">
                        <strong>Note:</strong> Modifying the email address will invalidate the previous invitation link and automatically send a new registration link to the updated email address.
                    </span>
                </div>

                <div style="text-align: right; display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                    <button type="button" onclick="closeInvitationModal()" class="btn btn-secondary rounded-pill px-4" style="font-weight: 700;">Cancel</button>
                    <button type="submit" id="btnInvitationSubmit" class="btn rounded-pill px-4" style="background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border: none; font-weight: 800 !important; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35);">Send Invitation Link</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-modal {
            display: none;
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(5, 7, 17, 0.85);
            z-index: 9999;
            align-items: center; justify-content: center;
            backdrop-filter: blur(8px);
        }
    </style>
@endsection

@section('js')
<script>
    function openAddInvitationModal() {
        $('#modal_invitation_id').val('');
        $('#modal_inv_name').val('');
        $('#modal_inv_email').val('');
        $('#invitationEditNote').hide();
        $('#invitationModalTitle').text('Send New Invitation');
        $('#btnInvitationSubmit').text('Send Invitation Link');
        $('#invitationModal').css('display', 'flex');
    }

    function openEditInvitationModal(id) {
        $.ajax({
            url: '{{ url("vendor/invitations") }}/' + id + '/edit',
            type: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success && response.invitation) {
                    var inv = response.invitation;
                    $('#modal_invitation_id').val(inv.id);
                    $('#modal_inv_name').val(inv.name || '');
                    $('#modal_inv_email').val(inv.email || '');
                    $('#invitationEditNote').show();
                    $('#invitationModalTitle').text('Edit User Invitation');
                    $('#btnInvitationSubmit').text('Update & Resend Link');
                    $('#invitationModal').css('display', 'flex');
                } else {
                    Swal.fire('Error', 'Failed to load invitation details.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Failed to load invitation details.', 'error');
            }
        });
    }

    function closeInvitationModal() {
        $('#invitationModal').css('display', 'none');
    }

    function submitInvitationModalForm(e) {
        if (e && e.preventDefault) e.preventDefault();
        var invId = $('#modal_invitation_id').val();
        var isEdit = !!invId;
        var url = isEdit ? '{{ url("vendor/invitations") }}/' + invId : '{{ route("vendor.invitations.store") }}';
        var method = isEdit ? 'PUT' : 'POST';

        var nameVal = $('#modal_inv_name').val();
        var emailVal = $('#modal_inv_email').val();

        if (!emailVal) {
            Swal.fire('Error', 'Please enter a valid email address.', 'error');
            return false;
        }

        $('#btnInvitationSubmit').prop('disabled', true).text(isEdit ? 'Updating...' : 'Sending...');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: method,
                name: nameVal,
                email: emailVal
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                $('#btnInvitationSubmit').prop('disabled', false).text(isEdit ? 'Update & Resend Link' : 'Send Invitation Link');
                if (response.success) {
                    closeInvitationModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Invitation saved successfully.',
                        timer: 2500,
                        showConfirmButton: false
                    });
                    fetchInvitations();
                } else {
                    Swal.fire('Error!', response.message || 'Failed to save invitation.', 'error');
                }
            },
            error: function(xhr) {
                $('#btnInvitationSubmit').prop('disabled', false).text(isEdit ? 'Update & Resend Link' : 'Send Invitation Link');
                var errorMsg = 'An error occurred while saving invitation.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Error!', errorMsg, 'error');
            }
        });
    }

    var currentInvitationSearchQuery = '{{ request("search") }}';
    var currentInvitationStatusFilter = '{{ request("status") ?? "all" }}';
    var invitationSearchTimer = null;

    function fetchInvitations(url) {
        url = url || '{{ route("vendor.invitations.index") }}';
        $('#invitationsTableContainer').css('opacity', '0.5');

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                search: currentInvitationSearchQuery,
                status: currentInvitationStatusFilter
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success) {
                    if (response.html) {
                        $('#invitationsTableContainer').html(response.html).css('opacity', '1');
                    }
                    if (response.totalCount !== undefined) {
                        $('#totalCountDisplay').text(response.totalCount);
                    }
                    if (response.pendingCount !== undefined) {
                        $('#pendingCountDisplay').text(response.pendingCount);
                    }
                    if (response.acceptedCount !== undefined) {
                        $('#acceptedCountDisplay').text(response.acceptedCount);
                    }
                }
            },
            error: function() {
                $('#invitationsTableContainer').css('opacity', '1');
            }
        });
    }

    // Close modal on outside click
    window.onclick = function(event) {
        const invModal = document.getElementById('invitationModal');
        if (event.target == invModal) {
            closeInvitationModal();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Search input keyup
        $(document).on('keyup', '#invitationSearchInput', function() {
            clearTimeout(invitationSearchTimer);
            currentInvitationSearchQuery = $(this).val();
            invitationSearchTimer = setTimeout(function() {
                fetchInvitations();
            }, 350);
        });

        // Status filter change
        $(document).on('change', '#invitationStatusFilter', function() {
            currentInvitationStatusFilter = $(this).val();
            fetchInvitations();
        });

        // AJAX Pagination click
        $(document).on('click', '#invitationsTableContainer .pagination a', function(e) {
            e.preventDefault();
            var pageUrl = $(this).attr('href');
            if (pageUrl) {
                fetchInvitations(pageUrl);
            }
        });

        // Resend confirmation with AJAX
        $(document).on('submit', '.resend-form', function (e) {
            e.preventDefault();
            const form = $(this);
            const actionUrl = form.attr('action');

            Swal.fire({
                title: 'Resend Invitation?',
                text: "Are you sure you want to resend the invitation email?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#60a5fa',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, resend it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const btn = form.find('.resend-btn');
                    btn.prop('disabled', true).css('opacity', '0.6');

                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        success: function(response) {
                            btn.prop('disabled', false).css('opacity', '1');
                            if (response.success) {
                                Swal.fire({
                                    title: 'Sent!',
                                    text: response.message || 'Invitation email resent successfully.',
                                    icon: 'success',
                                    timer: 2500,
                                    showConfirmButton: false
                                });
                                fetchInvitations();
                            } else {
                                Swal.fire('Error', response.message || 'Failed to resend email.', 'error');
                            }
                        },
                        error: function(xhr) {
                            btn.prop('disabled', false).css('opacity', '1');
                            var errorMsg = 'Failed to resend invitation email.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire('Error', errorMsg, 'error');
                        }
                    });
                }
            });
        });

        // Delete confirmation with AJAX
        $(document).on('submit', '.delete-form', function (e) {
            e.preventDefault();
            const form = $(this);
            const actionUrl = form.attr('action');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will revoke and delete the invitation. You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message || 'Invitation deleted successfully.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                fetchInvitations();
                            } else {
                                Swal.fire('Error!', response.message || 'Failed to delete invitation.', 'error');
                            }
                        },
                        error: function() {
                            form[0].submit();
                        }
                    });
                }
            });
        });

        // Success session alert using SweetAlert
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                title: 'Warning',
                text: "{{ session('warning') }}",
                icon: 'warning',
                showConfirmButton: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error',
                text: "{{ session('error') }}",
                icon: 'error',
                showConfirmButton: true
            });
        @endif
    });
</script>
@endsection
