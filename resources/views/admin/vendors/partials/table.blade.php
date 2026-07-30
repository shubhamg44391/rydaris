<div class="panel-body admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Registered Date</th>
                <th>Status</th>
                <th>
                    <span style="display:inline-flex; align-items:center; gap:5px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                        Package
                    </span>
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $startingNumber = ($vendors->currentPage() - 1) * $vendors->perPage() + 1;
            @endphp
            @forelse ($vendors as $vendor)
                <tr>
                    <td>{{ $startingNumber++ }}</td>
                    <td>
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-weight: 600; color: #ffffff;">{{ $vendor->name }}</span>
                            <span style="font-size: 0.78rem; color: #64748b; margin-top: 2px;">{{ '@' . ($vendor->username ?? 'N/A') }}</span>
                        </div>
                    </td>
                    <td>{{ $vendor->email }}</td>
                    <td>
                        <strong>{{ trim(($vendor->country_code ?? '') . ' ' . ($vendor->contact_number ?? 'N/A')) }}</strong>
                    </td>
                    <td>{{ $vendor->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <form action="{{ route('admin.vendors.toggle-status', $vendor->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @if($vendor->status === 'active')
                                <button type="button" class="btn btn-xs border-0 bg-transparent p-0 status-toggle-btn" title="Click to Deactivate" style="border: none; background: transparent; padding: 0;">
                                    <span class="status-badge-active">Active</span>
                                </button>
                            @else
                                <button type="button" class="btn btn-xs border-0 bg-transparent p-0 status-toggle-btn" title="Click to Activate" style="border: none; background: transparent; padding: 0;">
                                    <span class="status-badge-inactive">Inactive</span>
                                </button>
                            @endif
                        </form>
                    </td>
                    <td>
                        @php $sub = $vendor->activeSubscription; @endphp
                        @if($sub && $sub->package)
                            <div style="display:flex; flex-direction:column; gap:3px;">
                                <span style="display:inline-flex; align-items:center; gap:5px; background: rgba(82,234,210,0.12); color: var(--brand,#52ead2); border: 1px solid rgba(82,234,210,0.3); border-radius: 20px; padding: 3px 10px; font-size:0.78rem; font-weight:700; width:fit-content; white-space: nowrap;">
                                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                    {{ $sub->package->name }}
                                </span>
                                <span style="font-size:0.72rem; color:#64748b; white-space: nowrap;">Expires: {{ $sub->ends_at->format('d M Y') }}</span>
                            </div>
                        @else
                            <span style="background: rgba(100,116,139,0.15); color: #64748b; border: 1px solid rgba(100,116,139,0.25); border-radius: 20px; padding: 3px 10px; font-size:0.78rem; font-weight:600; white-space: nowrap;">No Active Plan</span>
                        @endif
                    </td>
                    <td>
                        <div class="table-actions" style="display: flex; gap: 8px;">
                            @php
                                $vendorSubsData = $vendor->subscriptions->map(function($s) {
                                    return [
                                        'pkg'    => optional($s->package)->name ?? 'Unknown',
                                        'status' => $s->status,
                                        'amount' => $s->amount_paid,
                                        'starts' => optional($s->starts_at)->format('d M Y'),
                                        'ends'   => optional($s->ends_at)->format('d M Y'),
                                    ];
                                })->values()->toArray();
                            @endphp
                            <button type="button" class="icon-button view-vendor-btn" title="View Details"
                                data-id="{{ $vendor->id }}"
                                data-name="{{ $vendor->name }}"
                                data-username="{{ $vendor->username ?? 'N/A' }}"
                                data-email="{{ $vendor->email }}"
                                data-phone="{{ ($vendor->country_code ?? '') . ' ' . ($vendor->contact_number ?? 'N/A') }}"
                                data-status="{{ $vendor->status }}"
                                data-company="{{ $vendor->company_name ?? 'N/A' }}"
                                data-joined="{{ $vendor->created_at->format('d M Y') }}"
                                data-address="{{ $vendor->street_address ?? 'N/A' }}"
                                data-landmark="{{ $vendor->landmark ?? 'N/A' }}"
                                data-city="{{ $vendor->city ?? 'N/A' }}"
                                data-pincode="{{ $vendor->pincode ?? 'N/A' }}"
                                data-country="{{ $vendor->country ?? 'N/A' }}"
                                data-subs='{{ json_encode($vendorSubsData) }}'>
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            
                            <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="icon-button" title="Edit">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                            </a>
                            
                            <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="POST" style="display: inline;">
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
                    <td colspan="9" class="text-center py-4">No vendors found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line);">
    <div class="text-muted small">
        Showing {{ $vendors->firstItem() ?? 0 }} to {{ $vendors->lastItem() ?? 0 }} of {{ $vendors->total() }} results
    </div>
    <div>
        {{ $vendors->appends(['status' => $status])->links() }}
    </div>
</div>
