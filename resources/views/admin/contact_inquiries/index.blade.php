@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>Inquiries Management</h2>
            </div>
        </div>

        
        <div class="panel-filter-bar" id="inquiryFilterBar">
            <a href="{{ route('admin.contact-inquiries.index') }}" data-status="" class="btn btn-sm {{ !$status ? 'active' : '' }}">
                All
                <span id="countAll">{{ $totalCount }}</span>
            </a>
            <a href="{{ route('admin.contact-inquiries.index', ['status' => 'unread']) }}" data-status="unread" class="btn btn-sm {{ $status === 'unread' ? 'active' : '' }}">
                Unread
                <span id="countUnread">{{ $unreadCount }}</span>
            </a>
            <a href="{{ route('admin.contact-inquiries.index', ['status' => 'read']) }}" data-status="read" class="btn btn-sm {{ $status === 'read' ? 'active' : '' }}">
                Read
                <span id="countRead">{{ $readCount }}</span>
            </a>
        </div>

        <div id="inquiryTableContainer">
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
                                    
                                    <button type="button" class="icon-button" title="View Inquiry Details" style="cursor: pointer; background: transparent; border: none;" onclick="openInquiryModal({{ json_encode([
                                        'id' => $inquiry->id,
                                        'title' => 'Contact Inquiry Details',
                                        'name' => $inquiry->name,
                                        'company' => $inquiry->company ?? 'N/A',
                                        'email' => $inquiry->email,
                                        'phone' => $inquiry->phone ?? 'N/A',
                                        'date' => $inquiry->created_at->format('n/j/Y'),
                                        'description' => $inquiry->message ?? 'No description provided.',
                                        'status' => $inquiry->status,
                                        'toggle_url' => route('admin.contact-inquiries.toggle-status', $inquiry->id)
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
                    {{ $inquiries->links() }}
                </div>
            </div>
        @endif
        </div>{{-- close #inquiryTableContainer --}}
    </div>

    <!-- Contact Inquiry Details Modal -->
    <div id="inquiryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(5, 7, 17, 0.75); backdrop-filter: blur(6px); z-index: 99999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
        <div class="inquiry-modal-card" style="width: 100%; max-width: 560px; background: #0b1020; border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 14px; box-shadow: 0 20px 50px rgba(0,0,0,0.6); overflow: hidden; display: flex; flex-direction: column;">
            
            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                <h3 id="modalTitle" style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #f8fafc;">Contact Inquiry Details</h3>
                <button onclick="closeInquiryModal()" style="background: none; border: none; color: #94a3b8; font-size: 1.2rem; cursor: pointer; padding: 4px 8px; line-height: 1; border-radius: 6px;">&times;</button>
            </div>

            <!-- Body -->
            <div style="padding: 24px; display: flex; flex-direction: column; gap: 18px;">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Name</span>
                        <strong id="modalName" style="font-size: 0.95rem; color: #ffffff; font-weight: 700;">-</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Company</span>
                        <span id="modalCompany" style="font-size: 0.92rem; color: #e2e8f0; font-weight: 600;">-</span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Email</span>
                        <a id="modalEmail" href="#" style="font-size: 0.92rem; color: #f8fafc; background: transparent !important; padding: 0 !important; border: none !important; box-shadow: none !important; text-decoration: none; font-weight: 700; word-break: break-all; display: inline-block;">-</a>
                    </div>
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Contact</span>
                        <span id="modalPhone" style="font-size: 0.92rem; color: #ffffff; font-weight: 700;">-</span>
                    </div>
                </div>

                <div>
                    <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Date Submitted</span>
                    <span id="modalDate" style="font-size: 0.92rem; color: #e2e8f0; font-weight: 600;">-</span>
                </div>

                <div>
                    <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Description</span>
                    <div id="modalDescription" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; padding: 14px 16px; font-size: 0.9rem; color: #e2e8f0; line-height: 1.6; min-height: 80px; white-space: pre-wrap;">-</div>
                </div>

            </div>

            <!-- Footer -->
            <div style="display: flex; justify-content: flex-end; padding: 16px 24px; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                <button onclick="closeInquiryModal()" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; padding: 8px 24px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">Close</button>
            </div>

        </div>
    </div>

    <style>
    /* Light mode modal overrides */
    body.light-mode .inquiry-modal-card {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15) !important;
    }
    body.light-mode #modalTitle,
    body.light-mode #modalName,
    body.light-mode #modalPhone {
        color: #0f172a !important;
    }
    body.light-mode #modalCompany,
    body.light-mode #modalDate {
        color: #334155 !important;
    }
    body.light-mode #modalEmail {
        color: #0d9488 !important;
    }
    body.light-mode #modalDescription {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        color: #1e293b !important;
    }
    body.light-mode .inquiry-modal-card button {
        background: #f1f5f9 !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
    }
    </style>
@endsection

@section('js')
<script>
    var currentStatus = '{{ $status ?? "" }}';

    function openInquiryModal(data) {
        $('#modalTitle').text(data.title || 'Inquiry Details');
        $('#modalName').text(data.name || '-');
        $('#modalCompany').text(data.company || 'N/A');
        $('#modalEmail').text(data.email || '-').attr('href', 'mailto:' + data.email);
        $('#modalPhone').text(data.phone || 'N/A');
        $('#modalDate').text(data.date || '-');
        $('#modalDescription').text(data.description || '-');
        $('#inquiryModal').css('display', 'flex');

        // Auto mark as read when modal opens
        if (data.status === 'unread' && data.toggle_url) {
            $.ajax({
                url: data.toggle_url,
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (resp) {
                    if (resp.success) {
                        // Update badge on the row
                        var $btn = $('[data-id="' + data.id + '"].toggle-status-btn');
                        $btn.removeClass('status-badge-active').addClass('status-badge-inactive')
                            .text('Read').attr('data-status', 'read')
                            .attr('title', 'Mark as Unread');
                        updateCounts();
                    }
                }
            });
        }
    }

    function closeInquiryModal() {
        $('#inquiryModal').css('display', 'none');
    }

    // Fetch updated counts via AJAX
    function updateCounts() {
        $.ajax({
            url: '{{ route("admin.contact-inquiries.index") }}',
            type: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function (data) {
                if (data.totalCount !== undefined) {
                    $('#countAll').text(data.totalCount);
                    $('#countUnread').text(data.unreadCount);
                    $('#countRead').text(data.readCount);
                }
            }
        });
    }

    $(document).ready(function () {

        // Close modal on backdrop click
        $('#inquiryModal').on('click', function (e) {
            if (e.target === this) closeInquiryModal();
        });

        // ── Filter Tabs via jQuery AJAX (no page refresh) ──
        $(document).on('click', '#inquiryFilterBar a', function (e) {
            e.preventDefault();
            var $tab = $(this);
            var status = $tab.attr('data-status');
            var url = $tab.attr('href');
            currentStatus = status;

            $('#inquiryFilterBar a').removeClass('active');
            $tab.addClass('active');
            $('#inquiryTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.html) {
                        $('#inquiryTableContainer').html(data.html);
                    }
                    if (data.totalCount !== undefined) {
                        $('#countAll').text(data.totalCount);
                        $('#countUnread').text(data.unreadCount);
                        $('#countRead').text(data.readCount);
                    }
                    history.pushState({ url: url }, '', url);
                },
                error: function () {
                    // Fallback: full page load
                    window.location.href = url;
                },
                complete: function () {
                    $('#inquiryTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        });

        // ── Pagination via jQuery AJAX ──
        $(document).on('click', '#inquiryTableContainer .pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#inquiryTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.html) $('#inquiryTableContainer').html(data.html);
                    history.pushState({ url: url }, '', url);
                },
                complete: function () {
                    $('#inquiryTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        });

        // ── Status Toggle via jQuery AJAX (no page refresh) ──
        $(document).on('click', '.toggle-status-btn', function () {
            var $btn = $(this);
            var url = $btn.attr('data-url');
            var currentSt = $btn.attr('data-status');

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
                        // Update tab counts
                        $.ajax({
                            url: '{{ route("admin.contact-inquiries.index") }}',
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

        // ── Delete via jQuery AJAX ──
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $form = $button.closest('form');
            var $row = $button.closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the contact inquiry permanently.',
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
                                Swal.fire({ title: 'Deleted!', text: data.message, icon: 'success', timer: 2000, showConfirmButton: false });
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to delete inquiry.', 'error');
                        }
                    });
                }
            });
        });

        @if(session('success'))
            Swal.fire({ title: 'Success!', text: "{{ session('success') }}", icon: 'success', timer: 3000, showConfirmButton: false });
        @endif
    });
</script>
@endsection
