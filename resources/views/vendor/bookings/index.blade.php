@extends('admin.layouts.app')

@section('title', $seo_title ?? 'Bookings List')

@section('main-content')
<div class="admin-panel">
    <style>
        .custom-table-scrollbar::-webkit-scrollbar {
            height: 7px;
            width: 7px;
        }
        .custom-table-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
        }
        .custom-table-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(82, 234, 210, 0.2);
            border-radius: 10px;
            transition: background 0.2s ease;
        }
        .custom-table-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(82, 234, 210, 0.4);
        }

        /* Force light mode styles for bookings listing table */
        body.light-mode .admin-panel {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
            color: #0f172a !important;
            overflow: hidden !important;
        }

        body.light-mode .admin-panel .panel-head {
            border-bottom: none !important;
        }

        body.light-mode .admin-table-wrap {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }

        body.light-mode .admin-table {
            background-color: #ffffff !important;
        }

        body.light-mode .admin-table th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            border-bottom: 1.5px solid #cbd5e1 !important;
        }

        body.light-mode .admin-table td,
        body.light-mode .admin-table tr {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border-bottom: 1px solid #cbd5e1 !important;
        }

        body.light-mode .admin-table tbody tr:last-child td,
        body.light-mode .admin-table tbody tr:last-child {
            border-bottom: none !important;
        }

        body.light-mode .admin-table td p,
        body.light-mode .admin-table td span:not([class*="badge"]):not([class*="status"]):not([style*="#52ead2"]):not([style*="var(--brand)"]),
        body.light-mode .admin-table td div:not([class*="badge"]):not([class*="status"]):not([style*="#52ead2"]):not([style*="var(--brand)"]),
        body.light-mode .admin-table td strong:not([style*="#52ead2"]):not([style*="var(--brand)"]) {
            color: #0f172a !important;
        }

        /* Map light turquoise brand color to highly readable dark teal in light mode */
        body.light-mode .admin-table td[style*="#52ead2"],
        body.light-mode .admin-table td[style*="var(--brand)"],
        body.light-mode .admin-table td span[style*="#52ead2"],
        body.light-mode .admin-table td span[style*="var(--brand)"],
        body.light-mode .admin-table td strong[style*="#52ead2"],
        body.light-mode .admin-table td strong[style*="var(--brand)"],
        body.light-mode .admin-table td a[style*="#52ead2"],
        body.light-mode .admin-table td a[style*="var(--brand)"] {
            color: #0f766e !important;
        }

        body.light-mode .admin-table td a[style*="rgba(82,234,210,"],
        body.light-mode .admin-table td a[style*="rgba(82, 234, 210,"] {
            border-color: rgba(15, 118, 110, 0.3) !important;
            background: rgba(15, 118, 110, 0.06) !important;
            color: #0f766e !important;
        }
        body.light-mode .admin-table td a[style*="rgba(82,234,210,"]:hover,
        body.light-mode .admin-table td a[style*="rgba(82, 234, 210,"]:hover {
            background: rgba(15, 118, 110, 0.12) !important;
            border-color: rgba(15, 118, 110, 0.5) !important;
        }

        body.light-mode .admin-table td svg {
            stroke: #475569 !important;
        }

        body.light-mode .admin-table tbody tr:hover td {
            background-color: #f8fafc !important;
        }

        /* Light Mode scrollbars overrides */
        body.light-mode .custom-table-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9 !important;
        }
        body.light-mode .custom-table-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(15, 23, 42, 0.15) !important;
            border-color: #f1f5f9 !important;
        }
        body.light-mode .custom-table-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(15, 23, 42, 0.3) !important;
        }

        /* Light Mode: status dropdown */
        body.light-mode .admin-table td select.status-dropdown,
        body.light-mode select.status-dropdown {
            background: #ffffff !important;
            color: #0f172a !important;
            border: 1px solid rgba(15, 23, 42, 0.15) !important;
        }
        body.light-mode select.status-dropdown option {
            background: #ffffff !important;
            color: #0f172a !important;
        }

        /* Light Mode: action icon edit button in table */
        body.light-mode .admin-table td a.btn.btn-sm[style*="rgba(255,255,255,0.05)"],
        body.light-mode .admin-table td a.btn.btn-sm {
            background: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid rgba(15, 23, 42, 0.12) !important;
        }
        body.light-mode .admin-table td a.btn.btn-sm:hover {
            background: rgba(15, 118, 110, 0.08) !important;
            color: #0f766e !important;
            border-color: rgba(15, 118, 110, 0.25) !important;
        }

        /* Light Mode: Trip Ended / In Progress status spans */
        body.light-mode .admin-table td span.badge[style*="rgba(255, 255, 255, 0.05)"] {
            background: #f1f5f9 !important;
            color: #475569 !important;
            border-color: rgba(15, 23, 42, 0.12) !important;
        }

        /* Export button hover fix */
        #btn-export-bookings {
            transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s !important;
        }
        #btn-export-bookings:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }
        body.light-mode #btn-export-bookings:hover {
            opacity: 1 !important;
            box-shadow: 0 6px 20px rgba(15, 118, 110, 0.35) !important;
            transform: translateY(-1px) !important;
        }
    </style>
    <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="margin: 0; font-size: 1.35rem; font-weight: 800;">Bookings</h2>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: nowrap;">
            <!-- Search Box -->
            <div style="position: relative; width: 220px; flex-shrink: 0;">
                <input type="text" id="bookingSearchInput" value="{{ $search ?? '' }}" placeholder="Search customer, res #..." style="width: 100%; padding: 8px 12px 8px 34px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; color: #ffffff; font-size: 0.85rem; outline: none; transition: all 0.2s;">
                <svg viewBox="0 0 24 24" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; fill: none; stroke: #64748b; stroke-width: 2.5;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>

            <!-- Status Filter Dropdown -->
            <select id="bookingStatusSelect" class="form-select" style="width: 140px !important; min-width: 130px; display: inline-block !important; flex-shrink: 0; padding: 8px 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; color: #ffffff; font-size: 0.85rem; font-weight: 600; outline: none; cursor: pointer;">
                <option value="" style="background: #1e293b; color: #ffffff;" {{ !($status ?? null) ? 'selected' : '' }}>All Status</option>
                <option value="pending" style="background: #1e293b; color: #ffffff;" {{ ($status ?? null) === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" style="background: #1e293b; color: #ffffff;" {{ ($status ?? null) === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" style="background: #1e293b; color: #ffffff;" {{ ($status ?? null) === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" style="background: #1e293b; color: #ffffff;" {{ ($status ?? null) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <a href="{{ route('vendor.bookings.export') }}" id="btn-export-bookings"
               style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: linear-gradient(135deg, #52ead2, #2bc2a8); color: #051013; border-radius: 8px; font-weight: 700; font-size: 0.85rem; text-decoration: none; box-shadow: 0 2px 12px rgba(82,234,210,0.25); white-space: nowrap; flex-shrink: 0;">
                <svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); color: #4ade80; padding: 15px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; padding: 15px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('error') }}
        </div>
    @endif

    <div id="bookingsTableContainer">
        @section('booking_table_section')
        <div class="panel-body admin-table-wrap" id="bookingsTableWrap">
            <div class="custom-table-scrollbar" style="overflow-x: auto; max-width: 100%;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap;">S.No</th>
                            <th style="white-space: nowrap;">Date & time of booking</th>
                            <th style="white-space: nowrap;">Reservation #</th>
                            <th style="white-space: nowrap;">Customer's name</th>
                            <th style="white-space: nowrap;">Vehicle type</th>
                            <th style="white-space: nowrap;">Assigned Driver</th>
                            <th style="white-space: nowrap;">Pickup location</th>
                            <th style="white-space: nowrap;">Date & time of pickup</th>
                            <th style="white-space: nowrap;">Return location</th>
                            <th style="white-space: nowrap;">Date & time of return</th>
                            <th style="white-space: nowrap;">Paid amount</th>
                            <th style="white-space: nowrap;">Pending amount</th>
                            <th style="white-space: nowrap;">Total amount</th>
                            <th style="white-space: nowrap;">Payment Reference</th>
                            <th style="white-space: nowrap;">Booking Status</th>
                            <th style="white-space: nowrap;">Payment Status</th>
                            <th style="white-space: nowrap;">Customer Review</th>
                            <th style="white-space: nowrap;">Terms & Conditions</th>
                            <th style="white-space: nowrap;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr id="booking-row-{{ $booking->id }}">
                                <td>
                                    {{ ($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $booking->created_at->format('M d, Y h:i A') }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $booking->reservation_number }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $booking->customer_fname }} {{ $booking->customer_lname }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $booking->vehicle->name ?? 'N/A' }}
                                </td>
                                <td style="white-space: nowrap;" id="driver-cell-{{ $booking->id }}">
                                    @if($booking->driver)
                                        <span class="badge" style="background: rgba(82, 234, 210, 0.1); color: var(--brand, #52ead2); border: 1px solid rgba(82, 234, 210, 0.2); font-weight: 700; padding: 5px 10px; border-radius: 6px;">
                                            <i class="fa fa-user me-1"></i>{{ $booking->driver->name }}
                                        </span>
                                    @else
                                        <span style="color: #64748b; font-style: italic; font-size: 0.85rem;">Not Assigned</span>
                                    @endif
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $booking->pickupLocation->name ?? 'N/A' }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $booking->pickup_date_parsed ? $booking->pickup_date_parsed->format('Y/m/d') : $booking->pickup_date }}
                                    @if($booking->pickup_time)
                                        <br><span style="font-size: 0.78rem; color: #52ead2;"><i class="fa fa-clock me-1"></i>{{ date('h:i A', strtotime($booking->pickup_time)) }}</span>
                                    @endif
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $booking->returnLocation->name ?? 'N/A' }}
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ $booking->return_date_parsed ? $booking->return_date_parsed->format('Y/m/d') : $booking->return_date }}
                                    @if($booking->return_time)
                                        <br><span style="font-size: 0.78rem; color: #52ead2;"><i class="fa fa-clock me-1"></i>{{ date('h:i A', strtotime($booking->return_time)) }}</span>
                                    @endif
                                </td>
                                <td style="white-space: nowrap;">
                                    ₹{{ number_format($booking->paid_amount, 2) }}
                                </td>
                                <td style="white-space: nowrap;">
                                    ₹{{ number_format($booking->pending_amount, 2) }}
                                </td>
                                <td style="white-space: nowrap; font-weight: bold; color: #52ead2;">
                                    ₹{{ number_format($booking->total_amount, 2) }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    {{ $booking->payment_reference ?? 'N/A' }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    <select class="form-select status-dropdown" data-id="{{ $booking->id }}" style="background: rgba(255, 255, 255, 0.05); color: #f8fafc; border: 1px solid rgba(255, 255, 255, 0.2); padding: 5px 10px; border-radius: 4px; width: 140px; {{ $booking->booking_status == 'confirmed' ? 'color: #4ade80;' : ($booking->booking_status == 'pending' ? 'color: #facc15;' : '') }}">
                                        <option value="pending" style="background: #1e293b; color: #f8fafc;" {{ $booking->booking_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" style="background: #1e293b; color: #f8fafc;" {{ $booking->booking_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="completed" style="background: #1e293b; color: #4ade80;" {{ $booking->booking_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" style="background: #1e293b; color: #f8fafc;" {{ $booking->booking_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="confirm_request" style="background: #1e293b; color: #f8fafc;" {{ $booking->booking_status == 'confirm_request' ? 'selected' : '' }}>Confirm Request</option>
                                    </select>
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    <span class="badge" style="{{ $booking->payment_status == 'paid' ? 'background: rgba(74,222,128,0.1); color: #4ade80; border: 1px solid rgba(74,222,128,0.2);' : 'background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2);' }} padding: 5px 10px;">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    @if($booking->review)
                                        <a href="{{ route('vendor.reviews.index') }}" class="badge" style="background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.4); text-decoration: none; padding: 5px 10px; font-size: 0.8rem;" title="View Customer Review">
                                            <i class="fa fa-star me-1"></i> {{ $booking->review->rating }}★ Review
                                        </a>
                                    @elseif($booking->is_completed_or_ended)
                                        <span class="badge status-badge-ended" style="background: rgba(148, 163, 184, 0.12); color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.25); padding: 5px 12px; font-size: 0.78rem; border-radius: 999px; display: inline-flex; align-items: center; gap: 5px; font-weight: 700;" title="Trip Ended - Awaiting Customer Review">
                                            <i class="fa fa-flag-checkered" style="font-size: 0.72rem; color: #fbbf24;"></i> TRIP ENDED
                                        </span>
                                    @else
                                        <span class="badge status-badge-progress" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); padding: 5px 12px; font-size: 0.78rem; border-radius: 999px; display: inline-flex; align-items: center; gap: 5px; font-weight: 700;" title="Trip Currently In Progress">
                                            <i class="fa fa-spinner fa-spin" style="font-size: 0.72rem; color: #60a5fa;"></i> IN PROGRESS
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    <a href="{{ route('vendor.terms.public', auth()->id()) }}" target="_blank"
                                       title="View Terms & Conditions"
                                       class="btn-view-tc"
                                       style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background: rgba(82,234,210,0.1); color: #52ead2; border: none !important; outline: none !important; border-radius: 999px; font-size: 0.8rem; font-weight: 700; text-decoration: none; transition: all 0.25s ease;"
                                       onmouseover="this.style.background='rgba(82,234,210,0.2)';this.style.transform='translateY(-1px)';"
                                       onmouseout="this.style.background='rgba(82,234,210,0.1)';this.style.transform='translateY(0)';"
                                    >
                                        <svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                            <line x1="16" y1="13" x2="8" y2="13"/>
                                            <line x1="16" y1="17" x2="8" y2="17"/>
                                        </svg>
                                        View T&C
                                    </a>
                                </td>
                                <td style="padding: 15px 20px; text-align: right; white-space: nowrap;">
                                    <div style="display: inline-flex; align-items: center; gap: 8px;">
                                        <a href="{{ route('vendor.bookings.invoice', $booking->id) }}" target="_blank"
                                           title="View Booking Invoice"
                                           style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; padding: 0; background: rgba(82,234,210,0.1); color: #52ead2; border: 1px solid rgba(82,234,210,0.3); border-radius: 4px; transition: all 0.2s;"
                                           onmouseover="this.style.background='rgba(82,234,210,0.2)';"
                                           onmouseout="this.style.background='rgba(82,234,210,0.1)';"
                                        >
                                            <svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                <polyline points="14 2 14 8 20 8"/>
                                                <line x1="16" y1="13" x2="8" y2="13"/>
                                                <line x1="16" y1="17" x2="8" y2="17"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('vendor.bookings.show', $booking->id) }}" class="btn btn-sm" title="Edit" style="background: rgba(255,255,255,0.05); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1); text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; padding: 0; border-radius: 4px;">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;">
                                                <path d="M12 20h9"/>
                                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="19" class="text-center" style="padding: 30px; color: #94a3b8;">
                                    <div class="mb-3">
                                        <svg viewBox="0 0 24 24" style="width:48px;height:48px;fill:none;stroke:currentColor;stroke-width:1;stroke-linecap:round;stroke-linejoin:round;">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </div>
                                    <p>No bookings found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($bookings->hasPages())
                <div class="p-3 border-top d-flex justify-content-between align-items-center" style="border-color: rgba(255,255,255,0.05) !important;">
                    <div class="text-muted small">
                        Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }} results
                    </div>
                    <div>
                        {{ $bookings->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @endif
        </div>
        @endsection
        @yield('booking_table_section')
    </div>
</div>
@endsection

@section('js')
<script>
    var currentBookingStatusFilter = '{{ $status ?? "" }}';
    var currentBookingSearchQuery = '{{ $search ?? "" }}';
    var searchTimer = null;

    function fetchBookings(url) {
        url = url || '{{ route("vendor.bookings.index") }}';
        $('#bookingsTableContainer').css('opacity', '0.5');

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                status: currentBookingStatusFilter,
                search: currentBookingSearchQuery
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.success && response.html) {
                    $('#bookingsTableContainer').html(response.html).css('opacity', '1');
                    bindStatusDropdownEvents();
                }
            },
            error: function() {
                $('#bookingsTableContainer').css('opacity', '1');
            }
        });
    }

    function bindStatusDropdownEvents() {
        $('.status-dropdown').off('change').on('change', function() {
            var bookingId = $(this).data('id');
            var newStatus = $(this).val();
            var selectElement = $(this);
            var prevStatus = selectElement.attr('data-current-status') || 'pending';

            Swal.fire({
                title: 'Change Booking Status?',
                text: 'Are you sure you want to change status to ' + newStatus + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4ade80',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (newStatus === 'confirmed' || newStatus === 'completed') {
                        selectElement.css('color', '#4ade80');
                    } else if (newStatus === 'pending') {
                        selectElement.css('color', '#facc15');
                    } else if (newStatus === 'cancelled') {
                        selectElement.css('color', '#ef4444');
                    }

                    $.ajax({
                        url: '{{ route("vendor.bookings.update_status") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            booking_id: bookingId,
                            status: newStatus
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.success) {
                                selectElement.attr('data-current-status', newStatus);
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Status updated successfully',
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            } else {
                                selectElement.val(prevStatus);
                                Swal.fire('Error', 'Failed to update status', 'error');
                            }
                        },
                        error: function() {
                            selectElement.val(prevStatus);
                            Swal.fire('Error', 'An error occurred while updating status', 'error');
                        }
                    });
                } else {
                    selectElement.val(prevStatus);
                }
            });
        });

        // Save original status value for rollback
        $('.status-dropdown').each(function() {
            $(this).attr('data-current-status', $(this).val());
        });
    }

    $(document).ready(function() {
        bindStatusDropdownEvents();

        // Status Filter Dropdown Change
        $(document).on('change', '#bookingStatusSelect', function() {
            currentBookingStatusFilter = $(this).val() || '';
            fetchBookings();
        });

        // Search input keyup debounced
        $(document).on('keyup', '#bookingSearchInput', function() {
            clearTimeout(searchTimer);
            currentBookingSearchQuery = $(this).val();
            searchTimer = setTimeout(function() {
                fetchBookings();
            }, 350);
        });

        // AJAX Pagination click
        $(document).on('click', '#bookingsTableContainer .pagination a', function(e) {
            e.preventDefault();
            var pageUrl = $(this).attr('href');
            if (pageUrl) {
                fetchBookings(pageUrl);
            }
        });
    });

    function openTableAssignDriverModal(bookingId, currentDriverId) {
        $('#table_booking_id').val(bookingId);
        $('#table_driver_id').val(currentDriverId || '');
        $('#tableAssignDriverModalTitle').text(currentDriverId ? 'Change Driver' : 'Assign Driver');
        $('#tableAssignDriverModal').css('display', 'flex');
    }

    function closeTableAssignDriverModal() {
        $('#tableAssignDriverModal').css('display', 'none');
    }

    $('#tableAssignDriverForm').on('submit', function(e) {
        e.preventDefault();
        var bookingId = $('#table_booking_id').val();
        var driverId = $('#table_driver_id').val();
        if (!driverId) {
            Swal.fire('Error!', 'Please select a driver.', 'error');
            return;
        }
        $('#btnTableAssignDriverSubmit').prop('disabled', true);

        $.ajax({
            url: "/vendor/bookings/" + bookingId + "/assign-driver",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                driver_id: driverId
            },
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(data) {
                if (data.success) {
                    closeTableAssignDriverModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Update driver badge in table without reloading page
                    if (data.driver && data.driver.name) {
                        $('#driver-cell-' + bookingId).html(
                            '<span class="badge" style="background: rgba(82, 234, 210, 0.1); color: var(--brand, #52ead2); border: 1px solid rgba(82, 234, 210, 0.2); font-weight: 700; padding: 5px 10px; border-radius: 6px;">' +
                                '<i class="fa fa-user me-1"></i>' + data.driver.name +
                            '</span>'
                        );
                    } else {
                        fetchBookings();
                    }
                } else {
                    Swal.fire('Error!', data.message || 'Failed to assign driver.', 'error');
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred while assigning driver.';
                Swal.fire('Error!', msg, 'error');
            },
            complete: function() {
                $('#btnTableAssignDriverSubmit').prop('disabled', false);
            }
        });
    });
</script>

<!-- Table Assign Driver Popup Modal -->
<div id="tableAssignDriverModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: var(--bg-card, #1e293b); border: 1px solid var(--line, #334155); border-radius: 12px; width: 100%; max-width: 480px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--line, #334155); display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: var(--text, #f8fafc);" id="tableAssignDriverModalTitle">
                Assign Driver
            </h5>
            <button type="button" onclick="closeTableAssignDriverModal()" style="background: none; border: none; color: #94a3b8; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        <form id="tableAssignDriverForm">
            @csrf
            <input type="hidden" id="table_booking_id" value="">
            <div style="padding: 20px;">
                <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 8px;">Select Driver *</label>
                <select name="driver_id" id="table_driver_id" class="form-select dark-input" style="width: 100%; font-weight: 600;" required>
                    <option value="">-- Select Driver --</option>
                    @if(isset($activeDrivers))
                        @foreach($activeDrivers as $drv)
                            <option value="{{ $drv->id }}">
                                {{ $drv->name }} | {{ $drv->phone }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @if(isset($activeDrivers) && $activeDrivers->isEmpty())
                    <p style="color: #f87171; font-size: 0.82rem; margin-top: 8px; margin-bottom: 0;">No active drivers available. Please add or activate a driver first.</p>
                @endif
            </div>
            <div style="padding: 14px 20px; border-top: 1px solid var(--line, #334155); display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeTableAssignDriverModal()" class="btn btn-secondary rounded-pill px-4" style="font-weight: 700;">Cancel</button>
                <button type="submit" id="btnTableAssignDriverSubmit" class="btn btn-primary rounded-pill px-4" style="background: var(--brand, #52ead2); color: #061218; border: none; font-weight: 700;" {{ (isset($activeDrivers) && $activeDrivers->isEmpty()) ? 'disabled' : '' }}>Assign</button>
            </div>
        </form>
    </div>
</div>
@endsection
