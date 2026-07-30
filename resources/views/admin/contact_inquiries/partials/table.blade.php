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
                        <button type="button"
                            class="toggle-status-btn {{ $inquiry->status === 'unread' ? 'status-badge-active' : 'status-badge-inactive' }}"
                            data-id="{{ $inquiry->id }}"
                            data-url="{{ route('admin.contact-inquiries.toggle-status', $inquiry->id) }}"
                            data-status="{{ $inquiry->status }}"
                            title="{{ $inquiry->status === 'unread' ? 'Mark as Read' : 'Mark as Unread' }}">
                            {{ ucfirst($inquiry->status) }}
                        </button>
                    </td>
                    <td>
                        <div class="table-actions" style="display: flex; gap: 8px;">
                            <button type="button" class="icon-button" title="View Inquiry Details"
                                style="cursor: pointer; background: transparent; border: none;"
                                onclick="openInquiryModal({{ json_encode([
                                    'id'          => $inquiry->id,
                                    'title'       => 'Contact Inquiry Details',
                                    'name'        => $inquiry->name,
                                    'company'     => $inquiry->company ?? 'N/A',
                                    'email'       => $inquiry->email,
                                    'phone'       => $inquiry->phone ?? 'N/A',
                                    'date'        => $inquiry->created_at->format('n/j/Y'),
                                    'description' => $inquiry->message ?? 'No description provided.',
                                    'status'      => $inquiry->status,
                                    'toggle_url'  => route('admin.contact-inquiries.toggle-status', $inquiry->id)
                                ]) }})">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>

                            <a href="mailto:{{ $inquiry->email }}?subject=Re: Rydaris Inquiry" title="Reply via Email" class="icon-button">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 0 0-4-4H4"/></svg>
                            </a>

                            <form action="{{ route('admin.contact-inquiries.destroy', $inquiry->id) }}" method="POST" style="display: inline;">
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
                    <td colspan="8" class="text-center py-4" style="color: #64748b; font-style: italic;">No inquiries found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($inquiries->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line);">
        <div class="text-muted small">
            Showing {{ $inquiries->firstItem() ?? 0 }} to {{ $inquiries->lastItem() ?? 0 }} of {{ $inquiries->total() }} results
        </div>
        <div>
            {{ $inquiries->links('vendor.pagination.custom') }}
        </div>
    </div>
@endif
