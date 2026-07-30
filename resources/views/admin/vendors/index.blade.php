@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head">
            <div>
                <h2>
                    Vendor Management
                    <span id="vendorStatusHeading">
                        @if(isset($status) && $status === 'active')
                            - Active
                        @elseif(isset($status) && $status === 'inactive')
                            - Inactive
                        @endif
                    </span>
                </h2>
            </div>
        </div>

        
        <div class="panel-filter-bar">
            <a href="{{ route('admin.vendors.index') }}" data-filter="" class="btn btn-sm {{ !($status ?? null) ? 'active' : '' }}">
                All Vendors
            </a>
            <a href="{{ route('admin.vendors.index', ['status' => 'active']) }}" data-filter="active" class="btn btn-sm {{ ($status ?? null) === 'active' ? 'active' : '' }}">
                Active
            </a>
            <a href="{{ route('admin.vendors.index', ['status' => 'inactive']) }}" data-filter="inactive" class="btn btn-sm {{ ($status ?? null) === 'inactive' ? 'active' : '' }}">
                Inactive
            </a>
        </div>

        <div id="vendorTableContainer">
            @include('admin.vendors.partials.table')
        </div>
    </div>

    
    
    <!-- Vendor Details Off-Canvas Slide-Over Panel Overlay -->
    <div id="vendorPanelOverlay" class="vendor-panel-overlay" onclick="closeVendorPanel()"></div>

    <!-- Vendor Details Slide-Over Drawer -->
    <div id="vendorDetailPanel" class="vendor-detail-panel">

        <!-- Panel Header -->
        <div class="vendor-panel-header">
            <div style="display:flex; align-items:center; gap:10px;">
                <div class="vendor-panel-avatar" id="panelAvatar">V</div>
                <div>
                    <div id="panelName" class="vendor-panel-name">Vendor Name</div>
                    <div id="panelHeaderUsername" class="vendor-panel-username"></div>
                    <div id="panelStatus" style="font-size:0.75rem; margin-top:4px;"></div>
                </div>
            </div>
            <button onclick="closeVendorPanel()" class="vendor-panel-close">&times;</button>
        </div>

        <!-- Vendor Details Section -->
        <div class="vendor-panel-section">
            <p class="vendor-panel-section-title">Vendor Details</p>
            <div class="vendor-panel-grid">
                <div class="vendor-panel-row">
                    <span class="vendor-panel-label">Email</span>
                    <span id="panelEmail" class="vendor-panel-val"></span>
                </div>
                <div class="vendor-panel-row">
                    <span class="vendor-panel-label">Phone</span>
                    <span id="panelPhone" class="vendor-panel-val"></span>
                </div>
                <div class="vendor-panel-row">
                    <span class="vendor-panel-label">Company</span>
                    <span id="panelCompany" class="vendor-panel-val"></span>
                </div>
                <div class="vendor-panel-row">
                    <span class="vendor-panel-label">Username</span>
                    <span id="panelUsername" class="vendor-panel-val"></span>
                </div>
                <div class="vendor-panel-row">
                    <span class="vendor-panel-label">Joined</span>
                    <span id="panelJoined" class="vendor-panel-val"></span>
                </div>
            </div>
        </div>

        <div class="vendor-panel-divider"></div>

        <!-- Address Details Section -->
        <div class="vendor-panel-section">
            <p class="vendor-panel-section-title">Address Details</p>
            <div class="vendor-panel-grid">
                <div class="vendor-panel-row">
                    <span class="vendor-panel-label">Street Address</span>
                    <span id="panelAddress" class="vendor-panel-val"></span>
                </div>
                <div class="vendor-panel-row">
                    <span class="vendor-panel-label">Landmark</span>
                    <span id="panelLandmark" class="vendor-panel-val"></span>
                </div>
                <div class="vendor-panel-row">
                    <span class="vendor-panel-label">City</span>
                    <span id="panelCity" class="vendor-panel-val"></span>
                </div>
                <div class="vendor-panel-row">
                    <span class="vendor-panel-label">Pincode</span>
                    <span id="panelPincode" class="vendor-panel-val"></span>
                </div>
                <div class="vendor-panel-row">
                    <span class="vendor-panel-label">Country</span>
                    <span id="panelCountry" class="vendor-panel-val"></span>
                </div>
            </div>
        </div>

        <div class="vendor-panel-divider"></div>

        <!-- Package History Section -->
        <div class="vendor-panel-section">
            <p class="vendor-panel-section-title">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                Package History
            </p>
            <div id="panelPackages" class="vendor-panel-grid">
                
            </div>
        </div>
    </div>

@endsection

@section('js')
<script>
    function closeVendorPanel() {
        $('#vendorPanelOverlay').hide();
        $('#vendorDetailPanel').hide();
        $('body').css('overflow', '');
    }

    $(document).ready(function () {
        // Function to fetch vendors via jQuery AJAX
        function fetchVendors(url, pushState) {
            if (pushState === undefined) pushState = true;

            $('#vendorTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.success) {
                        $('#vendorTableContainer').html(data.html);
                        if (data.heading_status) {
                            $('#vendorStatusHeading').text(' ' + data.heading_status);
                        } else {
                            $('#vendorStatusHeading').text('');
                        }

                        // Update active filter button
                        $('.panel-filter-bar a').each(function () {
                            var btnFilter = $(this).attr('data-filter');
                            if ((!data.status && !btnFilter) || (data.status === btnFilter)) {
                                $(this).addClass('active');
                            } else {
                                $(this).removeClass('active');
                            }
                        });

                        if (pushState) {
                            history.pushState({ url: url }, '', url);
                        }
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to fetch vendor data.', 'error');
                },
                complete: function () {
                    $('#vendorTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        }

        // 1. Filter Buttons Click via jQuery AJAX
        $(document).on('click', '.panel-filter-bar a', function (e) {
            e.preventDefault();
            fetchVendors($(this).attr('href'));
        });

        // 2. Pagination Links Click via jQuery AJAX
        $(document).on('click', '#vendorTableContainer .pagination a', function (e) {
            e.preventDefault();
            fetchVendors($(this).attr('href'));
        });

        // 3. Browser Back/Forward navigation
        window.addEventListener('popstate', function (e) {
            if (e.state && e.state.url) {
                fetchVendors(e.state.url, false);
            } else {
                fetchVendors(window.location.href, false);
            }
        });

        // 4. Status Toggle Button Click via jQuery AJAX
        $(document).on('click', '.status-toggle-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $form = $button.closest('form');
            var $row = $button.closest('tr');
            if (!$form.length) return;

            var currentStatus = $.trim($button.find('span').text()).toLowerCase() || 'active';
            var nextStatus = (currentStatus === 'active') ? 'Inactive' : 'Active';

            Swal.fire({
                title: 'Change status?',
                text: "Are you sure you want to set this vendor's status to " + nextStatus + "?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, change it!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function (data) {
                            if (data.success) {
                                if (data.status === 'active') {
                                    $button.attr('title', 'Click to Deactivate')
                                           .html('<span class="status-badge-active">Active</span>');
                                } else {
                                    $button.attr('title', 'Click to Activate')
                                           .html('<span class="status-badge-inactive">Inactive</span>');
                                }
                                $row.find('.view-vendor-btn').attr('data-status', data.status);
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'An unexpected error occurred.', 'error');
                        }
                    });
                }
            });
        });

        // 5. Delete Button Click via jQuery AJAX
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $form = $button.closest('form');
            var $row = $button.closest('tr');
            if (!$form.length) return;

            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the vendor account. You won't be able to revert this!",
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
                                $row.css({
                                    'transition': 'opacity 0.3s ease, transform 0.3s ease',
                                    'opacity': '0',
                                    'transform': 'translateX(20px)'
                                });
                                setTimeout(function () { $row.remove(); }, 300);

                                Swal.fire({
                                    title: 'Deleted!',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire('Error!', data.message || 'Something went wrong.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to delete vendor.', 'error');
                        }
                    });
                }
            });
        });

        // 6. View Details Button Click via jQuery
        $(document).on('click', '.view-vendor-btn', function () {
            var d = $(this).data();
            var subs = d.subs || [];

            $('#panelAvatar').text((d.name || 'V').charAt(0).toUpperCase());
            $('#panelName').text(d.name || '');
            $('#panelHeaderUsername').text(d.username ? '@' + d.username : '');
            
            if (d.status === 'active') {
                $('#panelStatus').html('<span style="color:#22c55e; font-weight:600;">● Active</span>');
            } else {
                $('#panelStatus').html('<span style="color:#94a3b8; font-weight:600;">● Inactive</span>');
            }

            $('#panelEmail').text(d.email || 'N/A');
            $('#panelPhone').text(d.phone || 'N/A');
            $('#panelCompany').text(d.company || 'N/A');
            $('#panelUsername').text(d.username ? '@' + d.username : 'N/A');
            $('#panelJoined').text(d.joined || 'N/A');
            $('#panelAddress').text(d.address || 'N/A');
            $('#panelLandmark').text(d.landmark || 'N/A');
            $('#panelCity').text(d.city || 'N/A');
            $('#panelPincode').text(d.pincode || 'N/A');
            $('#panelCountry').text(d.country || 'N/A');

            var $pkgContainer = $('#panelPackages').empty();
            if (!subs || subs.length === 0) {
                $pkgContainer.html('<div style="color:#64748b; font-size:0.85rem; text-align:center; padding:20px 0;">No package history found.</div>');
            } else {
                $.each(subs, function (i, s) {
                    var isActive = s.status === 'active';
                    var cardHtml = `
                        <div class="vendor-pkg-card ${isActive ? 'active' : 'inactive'}">
                            <div class="vendor-pkg-head">
                                <span class="vendor-pkg-title">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                    ${s.pkg}
                                </span>
                                <span class="vendor-pkg-badge">${isActive ? 'Active' : s.status.charAt(0).toUpperCase() + s.status.slice(1)}</span>
                            </div>
                            <div class="vendor-pkg-meta">
                                <span>📅 ${s.starts} → ${s.ends}</span>
                                ${s.amount > 0 ? `<span>💰 $${(parseFloat(s.amount) / 83).toFixed(2)}</span>` : '<span class="vendor-pkg-free">Free</span>'}
                            </div>
                        </div>`;
                    $pkgContainer.append(cardHtml);
                });
            }

            $('#vendorPanelOverlay').show();
            $('#vendorDetailPanel').show();
            $('body').css('overflow', 'hidden');
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
</script>
@endsection
