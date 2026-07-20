@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>
                    Vendor Management
                    @if(isset($status) && $status === 'active')
                        - Active
                    @elseif(isset($status) && $status === 'inactive')
                        - Inactive
                    @endif
                </h2>
            </div>
        </div>

        
        <div class="panel-filter-bar">
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-sm {{ !($status ?? null) ? 'active' : '' }}">
                All Vendors
            </a>
            <a href="{{ route('admin.vendors.index', ['status' => 'active']) }}" class="btn btn-sm {{ ($status ?? null) === 'active' ? 'active' : '' }}">
                Active
            </a>
            <a href="{{ route('admin.vendors.index', ['status' => 'inactive']) }}" class="btn btn-sm {{ ($status ?? null) === 'inactive' ? 'active' : '' }}">
                Inactive
            </a>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Country Codes</th>
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
                                {{ $vendor->country_code ?? 'N/A' }}
                            </td>
                            <td>{{ $vendor->contact_number ?? 'N/A' }}</td>
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
    </div>

    
    
    <div id="vendorPanelOverlay" onclick="closeVendorPanel()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:1040; backdrop-filter:blur(4px);"></div>

    
    <div id="vendorDetailPanel" style="display:none; position:fixed; top:0; right:0; height:100vh; width:420px; max-width:100vw; background:#0d1526; border-left:1px solid rgba(255,255,255,0.08); z-index:1050; overflow-y:auto; padding:0; box-shadow:-20px 0 60px rgba(0,0,0,0.5); transition:transform 0.3s ease; font-family:'Inter',sans-serif;">

        
        <div style="padding:20px 24px; border-bottom:1px solid rgba(255,255,255,0.07); display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.02);">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg, var(--brand,#52ead2), #2bc2a8); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:1rem; color:#050711;" id="panelAvatar">V</div>
                <div>
                    <div id="panelName" style="font-weight:700; font-size:1rem; color:#f8fafc;">Vendor Name</div>
                    <div id="panelHeaderUsername" style="font-size:0.78rem; color:#64748b; margin-top:2px;"></div>
                    <div id="panelStatus" style="font-size:0.75rem; margin-top:4px;"></div>
                </div>
            </div>
            <button onclick="closeVendorPanel()" style="background:none; border:none; color:#94a3b8; font-size:1.4rem; cursor:pointer; line-height:1;">&times;</button>
        </div>

        
        <div style="padding:20px 24px;">
            <p style="font-size:0.7rem; font-weight:700; color:#52ead2; text-transform:uppercase; letter-spacing:1px; margin-bottom:12px;">Vendor Details</p>
            <div style="display:flex; flex-direction:column; gap:10px;">
                <div style="display:flex; justify-content:space-between; padding:10px 14px; background:rgba(255,255,255,0.03); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
                    <span style="color:#94a3b8; font-size:0.83rem;">Email</span>
                    <span id="panelEmail" style="color:#f1f5f9; font-size:0.83rem; font-weight:600;"></span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:10px 14px; background:rgba(255,255,255,0.03); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
                    <span style="color:#94a3b8; font-size:0.83rem;">Phone</span>
                    <span id="panelPhone" style="color:#f1f5f9; font-size:0.83rem; font-weight:600;"></span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:10px 14px; background:rgba(255,255,255,0.03); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
                    <span style="color:#94a3b8; font-size:0.83rem;">Company</span>
                    <span id="panelCompany" style="color:#f1f5f9; font-size:0.83rem; font-weight:600;"></span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:10px 14px; background:rgba(255,255,255,0.03); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
                    <span style="color:#94a3b8; font-size:0.83rem;">Username</span>
                    <span id="panelUsername" style="color:#f1f5f9; font-size:0.83rem; font-weight:600;"></span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:10px 14px; background:rgba(255,255,255,0.03); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
                    <span style="color:#94a3b8; font-size:0.83rem;">Joined</span>
                    <span id="panelJoined" style="color:#f1f5f9; font-size:0.83rem; font-weight:600;"></span>
                </div>
            </div>
        </div>

        
        <div style="margin:0 24px; height:1px; background:rgba(255,255,255,0.07);"></div>

        
        <div style="padding:20px 24px;">
            <p style="font-size:0.7rem; font-weight:700; color:#52ead2; text-transform:uppercase; letter-spacing:1px; margin-bottom:12px;">Address Details</p>
            <div style="display:flex; flex-direction:column; gap:10px;">
                <div style="display:flex; justify-content:space-between; padding:10px 14px; background:rgba(255,255,255,0.03); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
                    <span style="color:#94a3b8; font-size:0.83rem;">Street Address</span>
                    <span id="panelAddress" style="color:#f1f5f9; font-size:0.83rem; font-weight:600;"></span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:10px 14px; background:rgba(255,255,255,0.03); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
                    <span style="color:#94a3b8; font-size:0.83rem;">Landmark</span>
                    <span id="panelLandmark" style="color:#f1f5f9; font-size:0.83rem; font-weight:600;"></span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:10px 14px; background:rgba(255,255,255,0.03); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
                    <span style="color:#94a3b8; font-size:0.83rem;">City</span>
                    <span id="panelCity" style="color:#f1f5f9; font-size:0.83rem; font-weight:600;"></span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:10px 14px; background:rgba(255,255,255,0.03); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
                    <span style="color:#94a3b8; font-size:0.83rem;">Pincode</span>
                    <span id="panelPincode" style="color:#f1f5f9; font-size:0.83rem; font-weight:600;"></span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:10px 14px; background:rgba(255,255,255,0.03); border-radius:8px; border:1px solid rgba(255,255,255,0.05);">
                    <span style="color:#94a3b8; font-size:0.83rem;">Country</span>
                    <span id="panelCountry" style="color:#f1f5f9; font-size:0.83rem; font-weight:600;"></span>
                </div>
            </div>
        </div>

        
        <div style="margin:0 24px; height:1px; background:rgba(255,255,255,0.07);"></div>

        
        <div style="padding:20px 24px;">
            <p style="font-size:0.7rem; font-weight:700; color:#52ead2; text-transform:uppercase; letter-spacing:1px; margin-bottom:12px; display:flex; align-items:center; gap:6px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                Package History
            </p>
            <div id="panelPackages" style="display:flex; flex-direction:column; gap:10px;">
                
            </div>
        </div>
    </div>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Status toggle confirmation
        document.querySelectorAll('.status-toggle-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                const badge = this.querySelector('.badge').textContent.trim();
                const nextStatus = (badge === 'Active') ? 'Inactive' : 'Active';

                Swal.fire({
                    title: 'Change status?',
                    text: `Are you sure you want to set this vendor's status to ${nextStatus}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#696cff',
                    cancelButtonColor: '#8592a3',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the vendor account. You won't be able to revert this!",
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

        // View Panel - open vendor detail slide-in
        document.querySelectorAll('.view-vendor-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const d = this.dataset;
                const subs = JSON.parse(d.subs || '[]');

                // Populate header
                document.getElementById('panelAvatar').innerText = (d.name || 'V').charAt(0).toUpperCase();
                document.getElementById('panelName').innerText = d.name;
                document.getElementById('panelHeaderUsername').innerText = d.username ? '@' + d.username : '';
                const statusEl = document.getElementById('panelStatus');
                if (d.status === 'active') {
                    statusEl.innerHTML = '<span style="color:#22c55e; font-weight:600;">● Active</span>';
                } else {
                    statusEl.innerHTML = '<span style="color:#94a3b8; font-weight:600;">● Inactive</span>';
                }

                // Populate details
                document.getElementById('panelEmail').innerText   = d.email   || 'N/A';
                document.getElementById('panelPhone').innerText   = d.phone   || 'N/A';
                document.getElementById('panelCompany').innerText = d.company || 'N/A';
                document.getElementById('panelUsername').innerText= d.username ? '@' + d.username : 'N/A';
                document.getElementById('panelJoined').innerText  = d.joined  || 'N/A';
                document.getElementById('panelAddress').innerText = d.address || 'N/A';
                document.getElementById('panelLandmark').innerText= d.landmark|| 'N/A';
                document.getElementById('panelCity').innerText    = d.city    || 'N/A';
                document.getElementById('panelPincode').innerText = d.pincode || 'N/A';
                document.getElementById('panelCountry').innerText = d.country || 'N/A';

                // Populate package history
                const pkgContainer = document.getElementById('panelPackages');
                pkgContainer.innerHTML = '';
                if (subs.length === 0) {
                    pkgContainer.innerHTML = '<div style="color:#64748b; font-size:0.85rem; text-align:center; padding:20px 0;">No package history found.</div>';
                } else {
                    subs.forEach(s => {
                        const isActive = s.status === 'active';
                        const card = document.createElement('div');
                        card.style.cssText = `padding:12px 16px; border-radius:10px; border:1px solid ${isActive ? 'rgba(82,234,210,0.3)' : 'rgba(255,255,255,0.06)'}; background:${isActive ? 'rgba(82,234,210,0.06)' : 'rgba(255,255,255,0.02)'};`;
                        card.innerHTML = `
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                <span style="font-weight:700; color:${isActive ? '#52ead2' : '#94a3b8'}; font-size:0.9rem; display:flex; align-items:center; gap:6px;">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                    ${s.pkg}
                                </span>
                                <span style="font-size:0.72rem; font-weight:700; padding:3px 9px; border-radius:20px; ${isActive ? 'background:#dcfce7; color:#067647;' : 'background:#f1f5f9; color:#64748b;'}">${isActive ? 'Active' : s.status.charAt(0).toUpperCase() + s.status.slice(1)}</span>
                            </div>
                            <div style="font-size:0.75rem; color:#64748b; display:flex; gap:12px; flex-wrap:wrap;">
                                <span>📅 ${s.starts} → ${s.ends}</span>
                                ${s.amount > 0 ? `<span>💰 $${(parseFloat(s.amount) / 83).toFixed(2)}</span>` : '<span style="color:#52ead2;">Free</span>'}
                            </div>`;
                        pkgContainer.appendChild(card);
                    });
                }

                // Show overlay and panel
                document.getElementById('vendorPanelOverlay').style.display = 'block';
                document.getElementById('vendorDetailPanel').style.display  = 'block';
                document.body.style.overflow = 'hidden';
            });
        });
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

    function closeVendorPanel() {
        document.getElementById('vendorPanelOverlay').style.display = 'none';
        document.getElementById('vendorDetailPanel').style.display  = 'none';
        document.body.style.overflow = '';
    }
</script>
@endsection
