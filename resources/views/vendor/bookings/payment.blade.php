@extends('admin.layouts.app')

@section('title', 'Booking Payments')

@section('main-content')
<div class="container-fluid p-4">
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 10px;
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
        <h3 class="mb-0 text-white" style="font-weight: 800;">Booking Payments</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.2); color: #4ade80;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive custom-scrollbar" style="overflow-x: auto;">
                <table class="table table-borderless mb-0" style="color: #94a3b8;">
                    <thead style="background: rgba(255, 255, 255, 0.02); border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                        <tr>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">S.No</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Date & time</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Reservation #</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Customer Name</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Vehicle</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Payment Method</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Total Amount</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Paid Amount</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Pending Amount</th>
                            <th style="color: #f8fafc; font-weight: 600; padding: 15px 20px; white-space: nowrap;">Payment Status</th>
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
                                    {{ $booking->payment_method ?? 'N/A' }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap; font-weight: bold; color: #52ead2;">
                                    ${{ number_format($booking->total_amount, 2) }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    ${{ number_format($booking->paid_amount, 2) }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    ${{ number_format($booking->pending_amount, 2) }}
                                </td>
                                <td style="padding: 15px 20px; white-space: nowrap;">
                                    <span class="badge" style="{{ $booking->payment_status == 'paid' ? 'background: rgba(74,222,128,0.1); color: #4ade80; border: 1px solid rgba(74,222,128,0.2);' : 'background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2);' }} padding: 5px 10px;">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center" style="padding: 30px; color: #94a3b8;">
                                    <p>No payment records found.</p>
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
