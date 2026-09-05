@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <div>
                <h2>Admin Users (Staff)</h2>
            </div>
            <div>
                @if(auth()->user()->hasAdminPermission('role_management', 'add'))
                <a href="{{ route('admin.admin-users.create') }}" class="btn btn-primary rounded-pill px-4" style="font-weight: 800 !important; display: inline-flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Admin
                </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background: rgba(82, 234, 210, 0.1); color: #52ead2; border: 1px solid #52ead2; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="panel-card">
            <div class="table-responsive">
                <table class="table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>ASSIGNED ROLE</th>
                            <th>CREATED AT</th>
                            <th class="text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($adminUsers as $admin)
                            <tr>
                                <td style="font-weight: 600; color: #f8fafc;">{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <span style="background: rgba(82, 234, 210, 0.1); color: #52ead2; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                        {{ $admin->roleData ? $admin->roleData->name : 'No Role Assigned' }}
                                    </span>
                                </td>
                                <td>{{ $admin->created_at->format('M d, Y') }}</td>
                                <td class="text-right" style="white-space: nowrap;">
                                    <div class="action-btn-group" style="display: flex; gap: 8px; justify-content: flex-end;">
                                        @if(auth()->user()->hasAdminPermission('role_management', 'edit'))
                                        <a href="{{ route('admin.admin-users.edit', $admin->id) }}" class="btn btn-sm btn-action" title="Edit">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                            </svg>
                                        </a>
                                        @endif
                                        @if(auth()->user()->hasAdminPermission('role_management', 'delete'))
                                        <form action="{{ route('admin.admin-users.destroy', $admin->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-action delete-btn" title="Delete">
                                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#fb7185" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center" style="padding: 20px; color: #94a3b8;">No admin users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div style="padding: 15px;">
                {{ $adminUsers->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        var $form = $(this).closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will remove the admin access permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fb7185',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $form.submit();
            }
        });
    });
</script>
@endsection
