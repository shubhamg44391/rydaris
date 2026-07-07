@extends('admin.layouts.app')

@section('title', 'Bookings List')

@section('main-content')
<div class="container-fluid p-4" style="min-width: 0; max-width: 100%; overflow-x: hidden;">
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 10px;
            width: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-white" style="font-weight: 800;">Bookings</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); color: #4ade80;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171;">
            {{ session('error') }}
        </div>
    @endif

    <div class="card" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive custom-scrollbar" style="overflow-x: auto; overflow-y: auto; max-height: 65vh;">
                <table class="table table-borderless mb-0" style="color: #94a3b8;">
                    <thead style="background: rgba(11, 16, 32, 0.95); border-bottom: 1px solid rgba(255, 255, 255, 0.05); position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">S.No</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Date & time of booking</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Reservation #</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Customer's name</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Vehicle type</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Pickup location</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Date & time of pickup</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Return location</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Date & time of return</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Paid amount</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Pending amount</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Total amount</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Payment Reference</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Booking Status</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Payment Status</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.02);">
                                <td style="padding: 15px 20px;">
                                    {{ ($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    {{ $booking->created_at->format('M d, Y h:i A') }}
                                </td>
                                <td style="padding: 15px 20px; color: #fff; font-weight: 700;">
                                    {{ $booking->reservation_number }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    {{ $booking->customer_fname }} {{ $booking->customer_lname }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    {{ $booking->vehicle->name ?? 'N/A' }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    {{ $booking->pickupLocation->name ?? 'N/A' }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    {{ $booking->pickup_date }} {{ $booking->pickup_time }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    {{ $booking->returnLocation->name ?? 'N/A' }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    {{ $booking->return_date }} {{ $booking->return_time }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    ${{ number_format($booking->paid_amount, 2) }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    ${{ number_format($booking->pending_amount, 2) }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap; font-weight: bold; color: #52ead2;">
                                    ${{ number_format($booking->total_amount, 2) }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    {{ $booking->payment_reference ?? 'N/A' }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    <span class="badge" style="{{ $booking->booking_status == 'confirmed' ? 'background: rgba(74,222,128,0.1); color: #4ade80; border: 1px solid rgba(74,222,128,0.2);' : 'background: rgba(250,204,21,0.1); color: #facc15; border: 1px solid rgba(250,204,21,0.2);' }} padding: 5px 10px;">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    <span class="badge" style="{{ $booking->payment_status == 'paid' ? 'background: rgba(74,222,128,0.1); color: #4ade80; border: 1px solid rgba(74,222,128,0.2);' : 'background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2);' }} padding: 5px 10px;">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                                <td style="padding: 15px 20px; text-align: right;">
                                    <button class="btn btn-sm" style="background: rgba(255,255,255,0.05); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1);">
                                        View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="text-center" style="padding: 30px; color: #94a3b8;">
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
