@extends('admin.layouts.app')

@section('title', 'Booking Payments')

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
                        <th style="white-space: nowrap;">Date & time</th>
                        <th style="white-space: nowrap;">Reservation #</th>
                        <th style="white-space: nowrap;">Customer Name</th>
                        <th style="white-space: nowrap;">Vehicle</th>
                        <th style="white-space: nowrap;">Payment Method</th>
                        <th style="white-space: nowrap;">Total Amount</th>
                        <th style="white-space: nowrap;">Paid Amount</th>
                        <th style="white-space: nowrap;">Pending Amount</th>
                        <th style="white-space: nowrap;">Payment Status</th>
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
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
