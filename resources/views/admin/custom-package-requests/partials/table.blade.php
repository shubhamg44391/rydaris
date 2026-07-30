<div class="panel-body admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 80px;">S.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Budget ($)</th>
                <th>Description</th>
                <th>Date</th>
                <th>Status</th>
                <th style="width: 120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $startingNumber = ($requests->currentPage() - 1) * $requests->perPage() + 1;
            @endphp
            @forelse ($requests as $request)
                <tr>
                    <td>{{ $startingNumber++ }}</td>
                    <td>
                        {{ $request->name }}
                        <span style="font-size: 0.8rem; color: #64748b; display: block;">{{ $request->company_name }}</span>
                    </td>
                    <td>
                        <a href="mailto:{{ $request->email }}" style="color: #0f766e; text-decoration: none;">{{ $request->email }}</a>
                    </td>
                    <td>
                        <span style="font-size: 0.9rem; color: #475569;">{{ $request->country_code }} {{ $request->contact_details }}</span>
                    </td>
                    <td>
                        <span style="font-size: 0.9rem; color: #475569;">{{ $request->budget }}</span>
                    </td>
                    <td>
                        <span style="font-size: 0.8rem; color: #64748b; display: inline-block; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $request->description }}">
                            {{ Str::limit($request->description, 30) }}
                        </span>
                    </td>
                    <td>
                        <span style="font-size: 0.85rem; color: #64748b;">{{ $request->created_at->format('M d, Y') }}</span>
                    </td>
                    <td>
                        <button type="button"
                            class="status-toggle-btn {{ $request->status === 'unread' ? 'status-badge-active' : 'status-badge-inactive' }}"
                            data-id="{{ $request->id }}"
                            data-url="{{ route('admin.custom-package-requests.toggle-status', $request->id) }}"
                            data-status="{{ $request->status }}"
                            title="{{ $request->status === 'unread' ? 'Mark as Read' : 'Mark as Unread' }}">
                            {{ ucfirst($request->status) }}
                        </button>
                    </td>
                    <td>
                        <div class="table-actions" style="display: flex; gap: 8px;">
                            <button type="button" class="icon-button view-btn" title="View Details"
                                data-request="{{ json_encode($request) }}"
                                onclick="openViewModal(this)">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <a href="mailto:{{ $request->email }}?subject=Re: Rydaris Custom Package" title="Reply via Email" class="icon-button">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 0 0-4-4H4"/></svg>
                            </a>
                            <form action="{{ route('admin.custom-package-requests.destroy', $request->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="icon-button delete-btn" title="Delete">
                                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-4" style="color: #64748b; font-style: italic;">No requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($requests->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line);">
        <div class="text-muted small">
            Showing {{ $requests->firstItem() ?? 0 }} to {{ $requests->lastItem() ?? 0 }} of {{ $requests->total() }} results
        </div>
        <div>
            {{ $requests->links('vendor.pagination.custom') }}
        </div>
    </div>
@endif
