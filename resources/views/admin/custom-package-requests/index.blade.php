@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>Custom Package Requests</h2>
            </div>
        </div>

        
        <div class="panel-filter-bar">
            <a href="{{ route('admin.custom-package-requests.index') }}" class="btn btn-sm {{ !request('status') ? 'active' : '' }}">
                All Requests
            </a>
            <a href="{{ route('admin.custom-package-requests.index', ['status' => 'unread']) }}" class="btn btn-sm {{ request('status') === 'unread' ? 'active' : '' }}">
                Unread
            </a>
            <a href="{{ route('admin.custom-package-requests.index', ['status' => 'read']) }}" class="btn btn-sm {{ request('status') === 'read' ? 'active' : '' }}">
                Read
            </a>
        </div>

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
                                <form action="{{ route('admin.custom-package-requests.toggle-status', $request->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                     @if($request->status === 'unread')
                                        <button type="submit" title="Mark as Read" class="status-badge-active">Unread</button>
                                    @else
                                        <button type="submit" title="Mark as Unread" class="status-badge-inactive">Read</button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    
                                    <button type="button" class="icon-button view-btn" title="View Details" data-request="{{ json_encode($request) }}" onclick="openViewModal(this)">
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
                    {{ $requests->links() }}
                </div>
            </div>
        @endif

    </div>

    
    <div id="viewModal" class="custom-modal">
        <div class="modal-content" style="max-width: 600px; padding: 25px; border-radius: 12px; background: rgba(11, 16, 32, 0.95); border: 1px solid rgba(82, 234, 210, 0.2); box-shadow: 0 24px 80px rgba(0,0,0,0.6);">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px;">
                <h3 style="margin: 0; color: #f8fafc;">Request Details</h3>
                <span onclick="closeViewModal()" style="color: #94a3b8; font-size: 24px; cursor: pointer;">&times;</span>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; color: #cbd5e1; font-size: 0.95rem;">
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Name</strong>
                    <span id="modalName"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Company</strong>
                    <span id="modalCompany"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Email</strong>
                    <span id="modalEmail"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Contact</strong>
                    <span id="modalContact"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Budget</strong>
                    <span id="modalBudget"></span>
                </div>
                <div>
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Date Submitted</strong>
                    <span id="modalDate"></span>
                </div>
                <div style="grid-column: span 2;">
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Description</strong>
                    <div id="modalDescription" style="background: rgba(255,255,255,0.05); padding: 12px; border-radius: 8px; white-space: pre-wrap;"></div>
                </div>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn btn-sm" onclick="closeViewModal()" style="background: rgba(255,255,255,0.1); color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Close</button>
            </div>
        </div>
    </div>
    
    <style>
        .custom-modal {
            display: none;
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(5, 7, 17, 0.85);
            z-index: 9999;
            align-items: center; justify-content: center;
            backdrop-filter: blur(8px);
        }
    </style>
@endsection

@section('js')
<script>
    function openViewModal(button) {
        const data = JSON.parse(button.getAttribute('data-request'));
        
        document.getElementById('modalName').textContent = data.name;
        document.getElementById('modalCompany').textContent = data.company_name;
        document.getElementById('modalEmail').textContent = data.email;
        document.getElementById('modalContact').textContent = (data.country_code ? data.country_code + ' ' : '') + data.contact_details;
        document.getElementById('modalBudget').textContent = data.budget ? '$' + data.budget : 'Not specified';
        document.getElementById('modalDate').textContent = new Date(data.created_at).toLocaleDateString();
        document.getElementById('modalDescription').textContent = data.description || 'No description provided.';
        
        document.getElementById('viewModal').style.display = 'flex';
    }

    function closeViewModal() {
        document.getElementById('viewModal').style.display = 'none';
    }

    // Close on outside click
    window.onclick = function(event) {
        const modal = document.getElementById('viewModal');
        if (event.target == modal) {
            closeViewModal();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the request permanently.",
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
