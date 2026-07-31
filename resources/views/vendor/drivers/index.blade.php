@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 style="margin: 0; font-weight: 800; font-size: 1.5rem; color: var(--text, #f8fafc);">
                    Driver Management
                    <span id="driverStatusHeading" style="font-size: 1.1rem; color: var(--brand, #52ead2);">
                        @if(isset($status) && $status === 'active')
                            - Active
                        @elseif(isset($status) && $status === 'inactive')
                            - Inactive
                        @endif
                    </span>
                </h2>
            </div>
            <div>
                <a href="{{ route('vendor.drivers.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; background: var(--brand, #52ead2); color: #061218; border: none; padding: 10px 20px; border-radius: var(--radius, 8px);">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Add Driver
                </a>
            </div>
        </div>

        <!-- Filter & Search Controls Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <div class="panel-filter-bar" id="driverFilterBar" style="display: flex; gap: 8px;">
                <a href="{{ route('vendor.drivers.index', array_merge(request()->except('status', 'page'), [])) }}" data-filter="" class="btn btn-sm {{ !($status ?? null) ? 'active' : '' }}" style="border-radius: 6px; padding: 6px 16px; font-weight: 700; text-decoration: none;">
                    All Drivers
                </a>
                <a href="{{ route('vendor.drivers.index', array_merge(request()->except('status', 'page'), ['status' => 'active'])) }}" data-filter="active" class="btn btn-sm {{ ($status ?? null) === 'active' ? 'active' : '' }}" style="border-radius: 6px; padding: 6px 16px; font-weight: 700; text-decoration: none;">
                    Active
                </a>
                <a href="{{ route('vendor.drivers.index', array_merge(request()->except('status', 'page'), ['status' => 'inactive'])) }}" data-filter="inactive" class="btn btn-sm {{ ($status ?? null) === 'inactive' ? 'active' : '' }}" style="border-radius: 6px; padding: 6px 16px; font-weight: 700; text-decoration: none;">
                    Inactive
                </a>
            </div>

            <!-- Search Form -->
            <div style="position: relative; min-width: 280px;">
                <input type="text" id="driverSearchInput" value="{{ $search ?? '' }}" placeholder="Search by name, mobile, license..." style="width: 100%; border: 1px solid var(--line, rgba(255,255,255,0.12)); background: var(--bg-card, #121e28); color: var(--text, #f8fafc); border-radius: var(--radius, 8px); padding: 8px 36px 8px 14px; font-size: 0.88rem;" />
                <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); fill: none; stroke: #94a3b8; stroke-width: 2; pointer-events: none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
        </div>

        <div id="driverTableContainer">
            @include('vendor.drivers.partials.table')
        </div>
    </div>

    <!-- Driver Details View Modal -->
    <div id="driverDetailsModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: var(--bg-card, #1e293b); border: 1px solid var(--line, #334155); border-radius: 12px; width: 100%; max-width: 520px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); overflow: hidden;">
            <div style="padding: 16px 20px; border-bottom: 1px solid var(--line, #334155); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: var(--text, #f8fafc);">Driver Details</h3>
                <button type="button" onclick="closeDriverModal()" style="background: none; border: none; color: #94a3b8; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <div style="padding: 20px; max-height: 80vh; overflow-y: auto;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div id="modalDriverPhotoContainer" style="margin-bottom: 10px;">
                        <div id="modalDriverAvatar" style="width: 72px; height: 72px; border-radius: 50%; background: var(--brand, #52ead2); color: #061218; font-size: 1.8rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center;">D</div>
                        <img id="modalDriverImg" src="#" alt="Driver Photo" style="display: none; width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--brand, #52ead2); margin: 0 auto;" />
                    </div>
                    <h4 id="modalDriverName" style="margin: 0; font-size: 1.15rem; font-weight: 800; color: var(--text, #f8fafc);">Driver Name</h4>
                    <span id="modalDriverStatus" class="status-badge-active" style="display: inline-block; margin-top: 6px;">Active</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 0.9rem;">
                    <div>
                        <span style="color: #94a3b8; font-size: 0.78rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">Mobile Number</span>
                        <strong id="modalDriverPhone" style="color: var(--text, #f8fafc);"></strong>
                    </div>
                    <div>
                        <span style="color: #94a3b8; font-size: 0.78rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">Email</span>
                        <span id="modalDriverEmail" style="color: var(--text, #cbd5e1);"></span>
                    </div>
                    <div>
                        <span style="color: #94a3b8; font-size: 0.78rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">License Number</span>
                        <span id="modalDriverLicense" style="color: var(--brand, #52ead2); font-weight: 700;"></span>
                    </div>
                    <div>
                        <span style="color: #94a3b8; font-size: 0.78rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">License Expiry</span>
                        <span id="modalDriverExpiry" style="color: var(--text, #cbd5e1);"></span>
                    </div>
                    <div style="grid-column: span 2;">
                        <span style="color: #94a3b8; font-size: 0.78rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">Address</span>
                        <span id="modalDriverAddress" style="color: var(--text, #cbd5e1);"></span>
                    </div>
                    <div style="grid-column: span 2;">
                        <span style="color: #94a3b8; font-size: 0.78rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">Notes</span>
                        <span id="modalDriverNotes" style="color: var(--text, #cbd5e1); font-style: italic;"></span>
                    </div>
                </div>
            </div>
            <div style="padding: 14px 20px; border-top: 1px solid var(--line, #334155); text-align: right;">
                <button type="button" onclick="closeDriverModal()" class="btn btn-secondary rounded-pill px-4" style="font-weight: 700;">Close</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    function viewDriverDetails(driverId) {
        $.ajax({
            url: "{{ url('vendor/drivers') }}/" + driverId,
            type: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function (data) {
                if (data.success && data.driver) {
                    var d = data.driver;
                    $('#modalDriverName').text(d.name);
                    $('#modalDriverPhone').text(d.phone);
                    $('#modalDriverEmail').text(d.email);
                    $('#modalDriverAddress').text(d.address);
                    $('#modalDriverLicense').text(d.license_number);
                    $('#modalDriverExpiry').text(d.license_expiry);
                    $('#modalDriverNotes').text(d.notes);
                    
                    if (d.status === 'Active') {
                        $('#modalDriverStatus').attr('class', 'status-badge-active').text('Active');
                    } else {
                        $('#modalDriverStatus').attr('class', 'status-badge-inactive').text('Inactive');
                    }

                    if (d.photo_url) {
                        $('#modalDriverImg').attr('src', d.photo_url).show();
                        $('#modalDriverAvatar').hide();
                    } else {
                        $('#modalDriverImg').hide();
                        $('#modalDriverAvatar').text(d.name.charAt(0).toUpperCase()).show();
                    }

                    $('#driverDetailsModal').css('display', 'flex');
                }
            },
            error: function () {
                Swal.fire('Error!', 'Failed to fetch driver details.', 'error');
            }
        });
    }

    function closeDriverModal() {
        $('#driverDetailsModal').css('display', 'none');
    }

    $(document).ready(function () {
        var searchTimer;

        function fetchDrivers(url, pushState) {
            if (pushState === undefined) pushState = true;

            $('#driverTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.success) {
                        $('#driverTableContainer').html(data.html);

                        if (data.status === 'active') {
                            $('#driverStatusHeading').text('- Active');
                        } else if (data.status === 'inactive') {
                            $('#driverStatusHeading').text('- Inactive');
                        } else {
                            $('#driverStatusHeading').text('');
                        }

                        $('#driverFilterBar a').each(function () {
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
                    Swal.fire('Error!', 'Failed to fetch drivers data.', 'error');
                },
                complete: function () {
                    $('#driverTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        }

        // Live Search Input with Debounce
        $('#driverSearchInput').on('keyup input', function () {
            clearTimeout(searchTimer);
            var searchVal = $(this).val();
            var currentStatus = $('#driverFilterBar a.active').attr('data-filter') || '';

            searchTimer = setTimeout(function () {
                var url = "{{ route('vendor.drivers.index') }}?search=" + encodeURIComponent(searchVal);
                if (currentStatus) {
                    url += "&status=" + encodeURIComponent(currentStatus);
                }
                fetchDrivers(url);
            }, 350);
        });

        // Filter Tabs Click (AJAX)
        $(document).on('click', '#driverFilterBar a', function (e) {
            e.preventDefault();
            fetchDrivers($(this).attr('href'));
        });

        // Pagination Links Click (AJAX)
        $(document).on('click', '#driverTableContainer .pagination a', function (e) {
            e.preventDefault();
            fetchDrivers($(this).attr('href'));
        });

        // Toggle Status Click (AJAX)
        $(document).on('click', '.status-toggle-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $form = $button.closest('form');
            var $row = $button.closest('tr');
            if (!$form.length) return;

            Swal.fire({
                title: 'Change status?',
                text: "Are you sure you want to change this driver's status?",
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
                                    $button.html('<span class="status-badge-active">Active</span>');
                                } else {
                                    $button.html('<span class="status-badge-inactive">Inactive</span>');
                                }
                                Swal.fire('Success!', data.message, 'success');
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

        // Delete Driver Click (AJAX)
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $form = $button.closest('form');
            var $row = $button.closest('tr');
            if (!$form.length) return;

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the driver record!",
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
                                $row.fadeOut(300, function () {
                                    $(this).remove();
                                });
                                Swal.fire('Deleted!', data.message, 'success');
                            } else {
                                Swal.fire('Error!', data.message || 'Failed to delete driver.', 'error');
                            }
                        },
                        error: function (xhr) {
                            var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred while deleting driver.';
                            Swal.fire('Error!', msg, 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
