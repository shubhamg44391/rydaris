<div class="panel-body admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 70px;">Driver ID</th>
                <th>Driver Name</th>
                <th>Mobile Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>License Number</th>
                <th>License Expiry</th>
                <th>Status</th>
                <th>Created Date</th>
                <th style="width: 110px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($drivers as $driver)
                <tr>
                    <td>
                        <strong style="color: #94a3b8; font-size: 0.85rem;">#DRV-{{ $driver->id }}</strong>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            @if($driver->photo)
                                <img src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->name }}" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 1px solid var(--line, #cbd5e1);" />
                            @else
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--brand, #52ead2); color: #061218; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem;">
                                    {{ strtoupper(substr($driver->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <strong style="color: var(--text, #f8fafc); font-size: 0.92rem;">{{ $driver->name }}</strong>
                            </div>
                        </div>
                    </td>
                    <td>
                        <strong style="color: var(--text, #f8fafc);">{{ $driver->phone }}</strong>
                    </td>
                    <td>
                        <span style="font-size: 0.85rem; color: #94a3b8;">{{ $driver->email ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <span style="font-size: 0.85rem; color: #cbd5e1; max-width: 180px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $driver->address }}">
                            {{ $driver->address }}
                        </span>
                    </td>
                    <td>
                        @if($driver->license_number)
                            <span class="badge" style="background: rgba(82, 234, 210, 0.1); color: var(--brand, #52ead2); border: 1px solid rgba(82, 234, 210, 0.2); padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 0.8rem;">
                                {{ $driver->license_number }}
                            </span>
                        @else
                            <span style="color: #64748b; font-size: 0.85rem;">N/A</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-size: 0.85rem; color: #94a3b8;">
                            {{ $driver->license_expiry ? \Carbon\Carbon::parse($driver->license_expiry)->format('Y-m-d') : 'N/A' }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('vendor.drivers.toggle-status', $driver->id) }}" method="POST" style="display:inline;" class="status-toggle-form">
                            @csrf
                            <button type="button" class="status-toggle-btn" style="background:none; border:none; padding:0; cursor:pointer;" title="Click to toggle status">
                                @if($driver->status === 'active')
                                    <span class="status-badge-active">Active</span>
                                @else
                                    <span class="status-badge-inactive">Inactive</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td>
                        <span style="font-size: 0.82rem; color: #94a3b8;">{{ $driver->created_at->format('Y-m-d') }}</span>
                    </td>
                    <td>
                        <div class="table-actions" style="display: flex; gap: 6px; align-items: center;">
                            <a href="{{ route('vendor.drivers.show', $driver->id) }}" class="icon-button view-btn" title="View Details & History" style="color: #38bdf8; background: rgba(56, 189, 248, 0.1); border: 1px solid rgba(56, 189, 248, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                <svg viewBox="0 0 24 24" style="width: 15px; height: 15px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>

                            <a href="{{ route('vendor.drivers.edit', $driver->id) }}" class="icon-button edit-btn" title="Edit Driver" style="color: var(--brand, #52ead2); background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                <svg viewBox="0 0 24 24" style="width: 15px; height: 15px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>

                            <form action="{{ route('vendor.drivers.destroy', $driver->id) }}" method="POST" class="delete-form" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="icon-button delete-btn" title="Delete Driver" style="color: #ef4444; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <svg viewBox="0 0 24 24" style="width: 15px; height: 15px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center py-4" style="color: #94a3b8; font-style: italic;">No drivers found matching your search.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($drivers->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line, rgba(255,255,255,0.08));">
        <div class="text-muted small">
            Showing {{ $drivers->firstItem() ?? 0 }} to {{ $drivers->lastItem() ?? 0 }} of {{ $drivers->total() }} drivers
        </div>
        <div>
            {{ $drivers->links('vendor.pagination.custom') }}
        </div>
    </div>
@endif
