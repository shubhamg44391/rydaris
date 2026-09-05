<div class="panel-card">
    <div class="table-responsive">
        <table class="table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr>
                    <th>ROLE NAME</th>
                    <th>PERMISSIONS</th>
                    <th>CREATED AT</th>
                    <th class="text-right">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td style="font-weight: 600; color: #f8fafc;">{{ $role->name }}</td>
                        <td>
                            @php
                                $permsCount = 0;
                                if (is_array($role->permissions)) {
                                    foreach ($role->permissions as $module => $actions) {
                                        if (is_array($actions)) {
                                            $permsCount += count(array_filter($actions));
                                        }
                                    }
                                }
                            @endphp
                            <span style="background: rgba(82, 234, 210, 0.1); color: #52ead2; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                {{ $permsCount }} Assigned
                            </span>
                        </td>
                        <td>{{ $role->created_at->format('M d, Y') }}</td>
                        <td class="text-right" style="white-space: nowrap;">
                            <div class="action-btn-group" style="display: flex; gap: 8px; justify-content: flex-end;">
                                @if(auth()->user()->hasAdminPermission('role_management', 'edit'))
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-action" title="Edit">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </a>
                                @endif
                                
                                @if(auth()->user()->hasAdminPermission('role_management', 'delete'))
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-action delete-role-btn" title="Delete">
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
                        <td colspan="4" class="text-center" style="padding: 40px 0; color: #94a3b8;">
                            <div style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;">📋</div>
                            <h4 style="font-size: 1.1rem; color: #f8fafc; font-weight: 600;">No Roles Found</h4>
                            <p style="font-size: 0.9rem; margin-bottom: 0;">Click "Add Role" to create the first one.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($roles->hasPages())
        <div class="panel-footer" style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: center;">
            {{ $roles->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
