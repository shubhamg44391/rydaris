@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>Inquiries Management</h2>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div style="display: flex; gap: 8px; padding: 14px 20px; border-bottom: 1px solid #d7e0e8; background: #f8fafc; flex-wrap: wrap;">
            <a href="{{ route('admin.contact-inquiries.index') }}"
               style="min-height: 34px; display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 9999px; font-size: 0.85rem; font-weight: 800; text-decoration: none; border: 1px solid {{ !$status ? '#0f766e' : '#d7e0e8' }}; background: {{ !$status ? '#e2fbf6' : '#ffffff' }}; color: {{ !$status ? '#0f766e' : '#475569' }};">
                All
                <span style="background: #e2e8f0; color: #475569; padding: 1px 7px; border-radius: 99px; font-size: 0.75rem;">{{ $totalCount }}</span>
            </a>
            <a href="{{ route('admin.contact-inquiries.index', ['status' => 'unread']) }}"
               style="min-height: 34px; display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 9999px; font-size: 0.85rem; font-weight: 800; text-decoration: none; border: 1px solid {{ $status === 'unread' ? '#0f766e' : '#d7e0e8' }}; background: {{ $status === 'unread' ? '#e2fbf6' : '#ffffff' }}; color: {{ $status === 'unread' ? '#0f766e' : '#475569' }};">
                Unread
                <span style="background: #e2fbf6; color: #0f766e; padding: 1px 7px; border-radius: 99px; font-size: 0.75rem;">{{ $unreadCount }}</span>
            </a>
            <a href="{{ route('admin.contact-inquiries.index', ['status' => 'read']) }}"
               style="min-height: 34px; display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 9999px; font-size: 0.85rem; font-weight: 800; text-decoration: none; border: 1px solid {{ $status === 'read' ? '#0f766e' : '#d7e0e8' }}; background: {{ $status === 'read' ? '#e2fbf6' : '#ffffff' }}; color: {{ $status === 'read' ? '#0f766e' : '#475569' }};">
                Read
                <span style="background: #f1f5f9; color: #64748b; padding: 1px 7px; border-radius: 99px; font-size: 0.75rem;">{{ $readCount }}</span>
            </a>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Fleet Size</th>
                        <th>Primary Need</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingNumber = ($inquiries->currentPage() - 1) * $inquiries->perPage() + 1;
                    @endphp
                    @forelse ($inquiries as $inquiry)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>
                                {{ $inquiry->name }}
                                <span style="font-size: 0.8rem; color: #64748b; display: block;">{{ $inquiry->company }}</span>
                            </td>
                            <td>
                                <a href="mailto:{{ $inquiry->email }}" style="color: #0f766e; text-decoration: none;">{{ $inquiry->email }}</a>
                            </td>
                            <td>
                                <span style="font-size: 0.9rem; color: #475569;">{{ $inquiry->fleet_size }}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.9rem; color: #475569;">{{ $inquiry->need }}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.85rem; color: #64748b;">{{ $inquiry->created_at->format('M d, Y H:i') }}</span>
                            </td>
                            <td>
                                {{-- Clickable status badge toggles read/unread --}}
                                <form action="{{ route('admin.contact-inquiries.toggle-status', $inquiry->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @if($inquiry->status === 'unread')
                                        <button type="submit" title="Mark as Read" style="background: #e2fbf6; color: #0f766e; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 0.75rem; border: none; cursor: pointer;">Unread</button>
                                    @else
                                        <button type="submit" title="Mark as Unread" style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 0.75rem; border: none; cursor: pointer;">Read</button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    {{-- Reply button --}}
                                    <a href="mailto:{{ $inquiry->email }}?subject=Re: Rydaris Inquiry" title="Reply via Email" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #0f766e; background: #ffffff;">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 0 0-4-4H4"/></svg>
                                    </a>
                                    {{-- Delete button --}}
                                    <form action="{{ route('admin.contact-inquiries.destroy', $inquiry->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-button delete-btn" title="Delete" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #fee2e2; border-radius: var(--radius); color: #ef4444; background: #ffffff; cursor: pointer; padding: 0;">
                                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4" style="color: #64748b; font-style: italic;">No inquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
            <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid #d7e0e8; background: #ffffff;">
                <div class="text-muted small">
                    Showing {{ $inquiries->firstItem() ?? 0 }} to {{ $inquiries->lastItem() ?? 0 }} of {{ $inquiries->total() }} results
                </div>
                <div>
                    {{ $inquiries->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the contact inquiry permanently.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff3e1d',
                    cancelButtonColor: '#8592a3',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Success session alert
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endsection
