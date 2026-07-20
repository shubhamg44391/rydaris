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
    </style>
    <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2>Bookings</h2>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('vendor.bookings.export') }}" id="btn-export-bookings"
               style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #52ead2, #2bc2a8); color: #051013; border-radius: 8px; font-weight: 700; font-size: 0.875rem; text-decoration: none; box-shadow: 0 2px 12px rgba(82,234,210,0.25); transition: opacity 0.2s;"
               onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Export Bookings (CSV)
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

    <div class="panel-body admin-table-wrap">
        <div class="custom-table-scrollbar" style="overflow-x: auto; max-width: 100%;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">S.No</th>
                        <th style="white-space: nowrap;">Date & time of booking</th>
                        <th style="white-space: nowrap;">Reservation #</th>
                        <th style="white-space: nowrap;">Customer's name</th>
                        <th style="white-space: nowrap;">Vehicle type</th>
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
                        <tr>
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
                                        <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.1); padding: 5px 10px; font-size: 0.78rem;" title="Trip Ended - Awaiting Customer Review">
                                            <i class="fa fa-star-half-alt me-1" style="color: #fbbf24;"></i> Trip Ended
                                        </span>
                                    @else
                                        <span style="font-size: 0.78rem; color: #64748b;">In Progress</span>
                                    @endif
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    <a href="{{ route('vendor.terms.public', auth()->id()) }}" target="_blank"
                                       title="View Terms & Conditions"
                                       style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: rgba(82,234,210,0.08); color: #52ead2; border: 1px solid rgba(82,234,210,0.25); border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                                       onmouseover="this.style.background='rgba(82,234,210,0.18)';this.style.borderColor='rgba(82,234,210,0.5)'"
                                       onmouseout="this.style.background='rgba(82,234,210,0.08)';this.style.borderColor='rgba(82,234,210,0.25)'">
                                        <svg viewBox="0 0 24 24" style="width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                            <line x1="16" y1="13" x2="8" y2="13"/>
                                            <line x1="16" y1="17" x2="8" y2="17"/>
                                        </svg>
                                        View T&C
                                    </a>
                                </td>
                                <td style="padding: 15px 20px; text-align: right;">
                                    <a href="{{ route('vendor.bookings.show', $booking->id) }}" class="btn btn-sm" title="Edit" style="background: rgba(255,255,255,0.05); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1); text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; padding: 0; border-radius: 4px;">
                                        <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;">
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="text-center" style="padding: 30px; color: #94a3b8;">
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
                <div class="p-3 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
                    {{ $bookings->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusDropdowns = document.querySelectorAll('.status-dropdown');
        statusDropdowns.forEach(dropdown => {
            dropdown.addEventListener('change', function() {
                const bookingId = this.getAttribute('data-id');
                const newStatus = this.value;
                const selectElement = this;

                // Ask for confirmation
                Swal.fire({
                    title: 'Change Booking Status?',
                    text: `Are you sure you want to change the status to ${newStatus}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4ade80',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Yes, change it!',
                    background: 'rgba(11, 16, 32, 0.95)',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Update styling immediately
                        if(newStatus === 'confirmed') {
                            selectElement.style.color = '#4ade80';
                        } else if(newStatus === 'pending') {
                            selectElement.style.color = '#facc15';
                        } else if(newStatus === 'cancelled') {
                            selectElement.style.color = '#ef4444';
                        } else {
                            selectElement.style.color = '#fff';
                        }

                        // Make AJAX request
                        fetch('{{ route("vendor.bookings.update_status") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                booking_id: bookingId,
                                status: newStatus
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Status updated successfully',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    background: 'rgba(11, 16, 32, 0.95)'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to update status',
                                    background: 'rgba(11, 16, 32, 0.95)'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while updating status',
                                background: 'rgba(11, 16, 32, 0.95)'
                            });
                        });
                    } else {
                        // Revert selection
                        selectElement.value = selectElement.getAttribute('data-current-status') || 'pending';
                    }
                });
            });

            // Store original value
            dropdown.setAttribute('data-current-status', dropdown.value);
        });
    });
</script>
@endsection
