@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>Custom Package Requests</h2>
            </div>
        </div>

        
        <div class="panel-filter-bar" id="pkgFilterBar">
            <a href="{{ route('admin.custom-package-requests.index') }}" data-status="" class="btn btn-sm {{ !request('status') ? 'active' : '' }}">
                All Requests <span id="countAll">{{ $totalCount }}</span>
            </a>
            <a href="{{ route('admin.custom-package-requests.index', ['status' => 'unread']) }}" data-status="unread" class="btn btn-sm {{ request('status') === 'unread' ? 'active' : '' }}">
                Unread <span id="countUnread">{{ $unreadCount }}</span>
            </a>
            <a href="{{ route('admin.custom-package-requests.index', ['status' => 'read']) }}" data-status="read" class="btn btn-sm {{ request('status') === 'read' ? 'active' : '' }}">
                Read <span id="countRead">{{ $readCount }}</span>
            </a>
        </div>

        <div id="pkgTableContainer">
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
                    {{ $requests->links('vendor.pagination.custom') }}
                </div>
            </div>
        @endif
        </div>{{-- close #pkgTableContainer --}}

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
        var data = JSON.parse(button.getAttribute('data-request'));
        $('#modalName').text(data.name);
        $('#modalCompany').text(data.company_name);
        $('#modalEmail').text(data.email);
        $('#modalContact').text((data.country_code ? data.country_code + ' ' : '') + data.contact_details);
        $('#modalBudget').text(data.budget ? '$' + data.budget : 'Not specified');
        $('#modalDate').text(new Date(data.created_at).toLocaleDateString());
        $('#modalDescription').text(data.description || 'No description provided.');
        $('#viewModal').css('display', 'flex');
    }

    function closeViewModal() {
        $('#viewModal').css('display', 'none');
    }

    $(document).ready(function () {

        // Backdrop close
        $('#viewModal').on('click', function (e) {
            if (e.target === this) closeViewModal();
        });

        // ── Filter Tabs (AJAX - no page refresh) ──
        $(document).on('click', '#pkgFilterBar a', function (e) {
            e.preventDefault();
            var $tab = $(this);
            var url = $tab.attr('href');

            $('#pkgFilterBar a').removeClass('active');
            $tab.addClass('active');
            $('#pkgTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.html) $('#pkgTableContainer').html(data.html);
                    if (data.totalCount !== undefined) {
                        $('#countAll').text(data.totalCount);
                        $('#countUnread').text(data.unreadCount);
                        $('#countRead').text(data.readCount);
                    }
                    history.pushState({ url: url }, '', url);
                },
                error: function () { window.location.href = url; },
                complete: function () {
                    $('#pkgTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        });

        // ── Pagination (AJAX) ──
        $(document).on('click', '#pkgTableContainer .pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#pkgTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.html) $('#pkgTableContainer').html(data.html);
                    history.pushState({ url: url }, '', url);
                },
                complete: function () {
                    $('#pkgTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        });

        // ── Status Toggle (AJAX - no page refresh) ──
        $(document).on('click', '.status-toggle-btn', function () {
            var $btn = $(this);
            var url = $btn.attr('data-url');

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (data) {
                    if (data.success) {
                        var newStatus = data.status || data.new_status;
                        $btn.attr('data-status', newStatus);
                        if (newStatus === 'unread') {
                            $btn.removeClass('status-badge-inactive').addClass('status-badge-active')
                                .text('Unread').attr('title', 'Mark as Read');
                        } else {
                            $btn.removeClass('status-badge-active').addClass('status-badge-inactive')
                                .text('Read').attr('title', 'Mark as Unread');
                        }
                        // Refresh counts
                        $.ajax({
                            url: '{{ route("admin.custom-package-requests.index") }}',
                            type: 'GET',
                            dataType: 'json',
                            headers: { 'X-Requested-With': 'XMLHttpRequest' },
                            success: function (resp) {
                                if (resp.totalCount !== undefined) {
                                    $('#countAll').text(resp.totalCount);
                                    $('#countUnread').text(resp.unreadCount);
                                    $('#countRead').text(resp.readCount);
                                }
                            }
                        });
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to update status.', 'error');
                }
            });
        });

        // ── Delete (AJAX) ──
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var $form = $(this).closest('form');
            var $row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the request permanently.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    var formData = new FormData($form[0]);
                    formData.append('_method', 'DELETE');
                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function (data) {
                            if (data.success) {
                                $row.css({ 'transition': 'opacity 0.3s ease, transform 0.3s ease', 'opacity': '0', 'transform': 'translateX(20px)' });
                                setTimeout(function () { $row.remove(); }, 300);
                                Swal.fire({ title: 'Deleted!', text: data.message, icon: 'success', confirmButtonText: 'OK' });
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to delete request.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
