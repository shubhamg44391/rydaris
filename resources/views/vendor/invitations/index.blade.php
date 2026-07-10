@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <div>
                <h2>User Invitations</h2>
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 4px; margin-bottom: 0;">Invite your customers to register and track their status.</p>
            </div>
            <div>
                <a href="{{ route('vendor.invitations.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 4px;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Send Invitation
                </a>
            </div>
        </div>

        <!-- Invitation Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <!-- Total Sent Card -->
            <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px;">
                <div style="background: rgba(82, 234, 210, 0.1); color: var(--brand, #52ead2); padding: 12px; border-radius: 10px;">
                    <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </div>
                <div>
                    <span style="display: block; color: #94a3b8; font-size: 0.85rem; font-weight: 500;">Total Invitations Sent</span>
                    <strong style="font-size: 1.6rem; color: #f8fafc;">{{ $totalCount }}</strong>
                </div>
            </div>
            
            <!-- Pending Card -->
            <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px;">
                <div style="background: rgba(251, 191, 36, 0.1); color: #fbbf24; padding: 12px; border-radius: 10px;">
                    <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div>
                    <span style="display: block; color: #94a3b8; font-size: 0.85rem; font-weight: 500;">Pending Registration</span>
                    <strong style="font-size: 1.6rem; color: #fbbf24;">{{ $pendingCount }}</strong>
                </div>
            </div>

            <!-- Accepted Card -->
            <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px;">
                <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 12px; border-radius: 10px;">
                    <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>
                <div>
                    <span style="display: block; color: #94a3b8; font-size: 0.85rem; font-weight: 500;">Accepted & Registered</span>
                    <strong style="font-size: 1.6rem; color: #10b981;">{{ $acceptedCount }}</strong>
                </div>
            </div>
        </div>

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
                                        <!-- Resend Button -->
                                        <form action="{{ route('vendor.invitations.resend', $invitation->id) }}" method="POST" class="resend-form" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="icon-button resend-btn" title="Resend Invitation Email" style="color: #60a5fa; background: rgba(96, 165, 250, 0.1); border: 1px solid rgba(96, 165, 250, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                                <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                            </button>
                                        </form>

                                        <!-- Edit Button -->
                                        <a href="{{ route('vendor.invitations.edit', $invitation->id) }}" class="icon-button edit-btn" title="Edit Invitation" style="color: var(--brand, #52ead2); background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>
                                    @endif

                                    <!-- Delete Button -->
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
                            <td colspan="6" class="text-center py-4" style="color: #94a3b8;">No invitations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Controls -->
        @if($invitations->hasPages())
            <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line, rgba(255, 255, 255, 0.08));">
                <div class="text-muted small">
                    Showing {{ $invitations->firstItem() ?? 0 }} to {{ $invitations->lastItem() ?? 0 }} of {{ $invitations->total() }} entries
                </div>
                <div>
                    {{ $invitations->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Resend confirmation
        document.querySelectorAll('.resend-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
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
                        this.submit();
                    }
                });
            });
        });

        // Delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.submitBtn = form.querySelector('.delete-btn');
            form.addEventListener('submit', function (e) {
                e.preventDefault();
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
                        this.submit();
                    }
                });
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
