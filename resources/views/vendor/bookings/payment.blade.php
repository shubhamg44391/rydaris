@extends('admin.layouts.app')

@section('title', $seo_title ?? 'Booking Payments')

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
            <h2>Booking Payments</h2>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); color: #4ade80; padding: 15px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="panel-body admin-table-wrap">
        <div class="custom-table-scrollbar" style="overflow-x: auto; max-width: 100%;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">S.No</th>
                        <th style="white-space: nowrap;">Booking Date</th>
                        <th style="white-space: nowrap;">Reservation #</th>
                        <th style="white-space: nowrap;">Customer Name</th>
                        <th style="white-space: nowrap;">Vehicle</th>
                        <th style="white-space: nowrap;">Pickup & Return Time</th>
                        <th style="white-space: nowrap;">Payment Method</th>
                        <th style="white-space: nowrap;">Total Amount</th>
                        <th style="white-space: nowrap;">Paid Amount</th>
                        <th style="white-space: nowrap;">Pending Amount</th>
                        <th style="white-space: nowrap;">Payment Status</th>
                        <th style="white-space: nowrap;">Customer Review</th>
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
                            <td style="color: #fff; font-weight: 700;">
                                {{ $booking->reservation_number }}
                            </td>
                            <td style="white-space: nowrap;">
                                {{ $booking->customer_fname }} {{ $booking->customer_lname }}
                            </td>
                            <td style="white-space: nowrap;">
                                {{ $booking->vehicle->name ?? 'N/A' }}
                            </td>
                            <td style="white-space: nowrap; font-size: 0.82rem;">
                                <div style="color: #4ade80;">
                                    <i class="fa fa-calendar-check me-1"></i> Pickup: {{ $booking->pickup_date_parsed ? $booking->pickup_date_parsed->format('Y/m/d') : $booking->pickup_date }} {{ $booking->pickup_time ? 'at ' . date('h:i A', strtotime($booking->pickup_time)) : '' }}
                                </div>
                                <div style="color: #f87171; margin-top: 2px;">
                                    <i class="fa fa-calendar-times me-1"></i> Return: {{ $booking->return_date_parsed ? $booking->return_date_parsed->format('Y/m/d') : $booking->return_date }} {{ $booking->return_time ? 'at ' . date('h:i A', strtotime($booking->return_time)) : '' }}
                                </div>
                            </td>
                            <td style="white-space: nowrap; text-transform: capitalize;">
                                {{ $booking->payment_method_label }}
                            </td>
                            <td style="white-space: nowrap; font-weight: bold; color: #52ead2;">
                                ₹{{ number_format($booking->total_amount, 2) }}
                            </td>
                            <td style="white-space: nowrap;">
                                ₹{{ number_format($booking->paid_amount, 2) }}
                            </td>
                            <td style="white-space: nowrap;">
                                ₹{{ number_format($booking->pending_amount, 2) }}
                            </td>
                            <td style="white-space: nowrap;">
                                <span class="badge" style="{{ $booking->payment_status == 'paid' ? 'background: rgba(74,222,128,0.1); color: #4ade80; border: 1px solid rgba(74,222,128,0.2);' : 'background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2);' }} padding: 5px 10px;">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </td>
                            <td style="white-space: nowrap;">
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center" style="padding: 30px; color: #94a3b8;">
                                <p>No payment records found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($bookings->hasPages())
            <div class="p-3 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
