@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2>Group Management</h2>
            </div>
            <div>
                <a href="{{ route('vendor.groups.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 4px;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Group
                </a>
            </div>
        </div>
        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingNumber = ($groups->currentPage() - 1) * $groups->perPage() + 1;
                    @endphp
                    @forelse ($groups as $group)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>
                                {{ $group->name }}
                            </td>
                            <td>{{ Str::limit($group->description ?? 'N/A', 100) }}</td>
                            <td>{{ $group->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <a href="{{ route('vendor.groups.edit', $group->id) }}" class="icon-button" title="Edit" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #0f766e; background: #ffffff;">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <form action="{{ route('vendor.groups.destroy', $group->id) }}" method="POST" style="display: inline;">
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
                            <td colspan="5" class="text-center py-4" style="text-align: center; padding: 20px;">No groups found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        
        <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid #d7e0e8; display: flex; justify-content: space-between; align-items: center; padding: 16px 24px;">
            <div class="text-muted small">
                Showing {{ $groups->firstItem() ?? 0 }} to {{ $groups->lastItem() ?? 0 }} of {{ $groups->total() }} results
            </div>
            <div>
                {{ $groups->links() }}
            </div>
        </div>
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
                    text: "This will delete the group. You won't be able to revert this!",
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
    });
</script>
@endsection
