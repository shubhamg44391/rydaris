@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>Demo Inquiries</h2>
            </div>
        </div>

        <div class="panel-filter-bar" id="demoFilterBar">
            <a href="{{ route('admin.demo-inquiries.index') }}" data-status="" class="btn btn-sm {{ !$status ? 'active' : '' }}">
                All <span id="countAll">{{ $totalCount }}</span>
            </a>
            <a href="{{ route('admin.demo-inquiries.index', ['status' => 'unread']) }}" data-status="unread" class="btn btn-sm {{ $status === 'unread' ? 'active' : '' }}">
                Unread <span id="countUnread">{{ $unreadCount }}</span>
            </a>
            <a href="{{ route('admin.demo-inquiries.index', ['status' => 'read']) }}" data-status="read" class="btn btn-sm {{ $status === 'read' ? 'active' : '' }}">
                Read <span id="countRead">{{ $readCount }}</span>
            </a>
        </div>

        <div id="demoTableContainer">
        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $startingNumber = ($inquiries->currentPage() - 1) * $inquiries->perPage() + 1; @endphp
                    @forelse ($inquiries as $inquiry)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>
                                {{ $inquiry->name }}
                                <span style="font-size: 0.8rem; color: #64748b; display: block;">{{ $inquiry->company_name }}</span>
                            </td>
                            <td>
                                <a href="mailto:{{ $inquiry->email }}" style="color: #0f766e; text-decoration: none;">{{ $inquiry->email }}</a>
                            </td>
                            <td>
                                <span style="font-size: 0.9rem; color: #475569;">{{ $inquiry->country_code }} {{ $inquiry->contact_details }}</span>
                            </td>
                            <td>
                                <span style="font-size: 0.8rem; color: #64748b; display: inline-block; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $inquiry->description }}">
                                    {{ Str::limit($inquiry->description, 30) }}
                                </span>
                            </td>
                            <td>
                                <span style="font-size: 0.85rem; color: #64748b;">{{ $inquiry->created_at->format('M d, Y') }}</span>
                            </td>
                            <td>
                                @if(auth()->user()->hasAdminPermission('inquiries', 'edit'))
                                <button type="button"
                                    class="status-toggle-btn {{ $inquiry->status === 'unread' ? 'status-badge-active' : 'status-badge-inactive' }}"
                                    data-id="{{ $inquiry->id }}"
                                    data-url="{{ route('admin.demo-inquiries.toggle-status', $inquiry->id) }}"
                                    data-status="{{ $inquiry->status }}"
                                    title="{{ $inquiry->status === 'unread' ? 'Mark as Read' : 'Mark as Unread' }}">
                                    {{ ucfirst($inquiry->status) }}
                                </button>
                                @else
                                <span class="{{ $inquiry->status === 'unread' ? 'status-badge-active' : 'status-badge-inactive' }}">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <button type="button" class="icon-button view-btn" title="View Details" data-inquiry="{{ json_encode($inquiry) }}" onclick="openDemoViewModal(this)">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </button>
                                    <a href="mailto:{{ $inquiry->email }}?subject=Re: Rydaris Site Demo" title="Reply via Email" class="icon-button">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><polyline points="9 17 4 12 9 7"/><path d="M20 18v-2a4 4 0 0 0-4-4H4"/></svg>
                                    </a>
                                    @if(auth()->user()->hasAdminPermission('inquiries', 'delete'))
                                    <form action="{{ route('admin.demo-inquiries.destroy', $inquiry->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-button delete-btn" title="Delete">
                                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 2-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4" style="color: #64748b; font-style: italic;">No demo inquiries found.</td>
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
                <div>{{ $inquiries->links('vendor.pagination.custom') }}</div>
            </div>
        @endif
        </div>{{-- close #demoTableContainer --}}
    </div>

    <div id="demoViewModal" class="custom-modal">
        <div class="modal-content" style="max-width: 650px; padding: 25px; border-radius: 12px; background: rgba(11, 16, 32, 0.95); border: 1px solid rgba(82, 234, 210, 0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px;">
                <h3 style="margin: 0; color: #f8fafc;">Demo Inquiry Details</h3>
                <span onclick="closeDemoViewModal()" style="color: #94a3b8; font-size: 24px; cursor: pointer;">&times;</span>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; color: #cbd5e1; font-size: 0.95rem;">
                <div><strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Name</strong><span id="demoModalName"></span></div>
                <div><strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Company</strong><span id="demoModalCompany"></span></div>
                <div><strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Email</strong><span id="demoModalEmail"></span></div>
                <div><strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Contact</strong><span id="demoModalContact"></span></div>
                <div><strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Date Submitted</strong><span id="demoModalDate"></span></div>
                <div style="grid-column: span 2;">
                    <strong style="color: #94a3b8; display: block; font-size: 0.85rem; margin-bottom: 4px;">Description</strong>
                    <div id="demoModalDescription" style="background: rgba(255,255,255,0.05); padding: 12px; border-radius: 8px; white-space: pre-wrap;"></div>
                </div>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn btn-sm" onclick="closeDemoViewModal()" style="background: rgba(255,255,255,0.1); color: #fff; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Close</button>
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
    function openDemoViewModal(button) {
        var data = JSON.parse(button.getAttribute('data-inquiry'));
        $('#demoModalName').text(data.name);
        $('#demoModalCompany').text(data.company_name);
        $('#demoModalEmail').text(data.email);
        $('#demoModalContact').text((data.country_code ? data.country_code + ' ' : '') + data.contact_details);
        $('#demoModalDate').text(new Date(data.created_at).toLocaleDateString());
        $('#demoModalDescription').text(data.description || 'No description provided.');
        $('#demoViewModal').css('display', 'flex');
    }

    function closeDemoViewModal() {
        $('#demoViewModal').css('display', 'none');
    }

    $(document).ready(function () {

        // Backdrop close modal
        $('#demoViewModal').on('click', function (e) {
            if (e.target === this) closeDemoViewModal();
        });

        // ── Filter Tabs (AJAX - no page refresh) ──
        $(document).on('click', '#demoFilterBar a', function (e) {
            e.preventDefault();
            var $tab = $(this);
            var url = $tab.attr('href');

            $('#demoFilterBar a').removeClass('active');
            $tab.addClass('active');
            $('#demoTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.html) $('#demoTableContainer').html(data.html);
                    if (data.totalCount !== undefined) {
                        $('#countAll').text(data.totalCount);
                        $('#countUnread').text(data.unreadCount);
                        $('#countRead').text(data.readCount);
                    }
                    history.pushState({ url: url }, '', url);
                },
                error: function () { window.location.href = url; },
                complete: function () {
                    $('#demoTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        });

        // ── Pagination (AJAX) ──
        $(document).on('click', '#demoTableContainer .pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#demoTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.html) $('#demoTableContainer').html(data.html);
                    history.pushState({ url: url }, '', url);
                },
                complete: function () {
                    $('#demoTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
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
                        var newStatus = data.status;
                        $btn.attr('data-status', newStatus);
                        if (newStatus === 'unread') {
                            $btn.removeClass('status-badge-inactive').addClass('status-badge-active')
                                .text('Unread').attr('title', 'Mark as Read');
                        } else {
                            $btn.removeClass('status-badge-active').addClass('status-badge-inactive')
                                .text('Read').attr('title', 'Mark as Unread');
                        }
                        // Refresh counts
                        $.get('{{ route("admin.demo-inquiries.index") }}', {}, function (resp) {
                            if (resp.totalCount !== undefined) {
                                $('#countAll').text(resp.totalCount);
                                $('#countUnread').text(resp.unreadCount);
                                $('#countRead').text(resp.readCount);
                            }
                        }, 'json').fail(function () {});
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
                text: 'This will delete the demo inquiry permanently.',
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
                            } else {
                                Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to delete inquiry.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
