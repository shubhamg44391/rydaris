@extends('user.layouts.app')

@section('main-content')
<div class="admin-panel" style="padding: 20px;">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 style="font-weight: 700; color: #f8fafc; margin-bottom: 5px;">User Dashboard</h2>
            <p class="text-muted" style="margin: 0;">Welcome back to your dashboard!</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="kpi-card" style="padding: 30px; text-align: center; border: 1px solid rgba(82, 234, 210, 0.15); border-radius: 12px; background: rgba(11, 16, 32, 0.6);">
                <div style="margin-bottom: 20px; color: var(--brand);">
                    <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                @if(auth()->check() && auth()->user()->vendor_id)
                    <h4 style="color: #f8fafc; font-weight: 600;">Looking for a vehicle?</h4>
                    <p class="text-muted mb-4">Browse your vendor's inventory to find the perfect ride for your needs.</p>
                    <a href="{{ route('user.vendors.show', auth()->user()->vendor_id) }}" class="btn btn-primary" style="padding: 10px 24px;">View Available Cars</a>
                @else
                    <h4 style="color: #f8fafc; font-weight: 600;">Looking for a vehicle?</h4>
                    <p class="text-muted mb-4">Browse and search through our trusted vendors to find the perfect ride for your needs.</p>
                    <a href="{{ route('user.vendors.search') }}" class="btn btn-primary" style="padding: 10px 24px;">Search Vendors Now</a>
                @endif
            </div>
        </div>
    </div>

    @if(isset($bookings) && count($bookings) > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h4 style="color: #f8fafc; font-weight: 700; margin-bottom: 20px;">My Bookings & Payment History</h4>
            <div class="table-responsive" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 20px;">
                <table class="table table-borderless" style="color: #94a3b8; margin-bottom: 0;">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Reservation #</th>
                            <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Vehicle</th>
                            <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Dates</th>
                            <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Payment Method</th>
                            <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Total</th>
                            <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Paid</th>
                            <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Pending</th>
                            <th style="font-weight: 600; color: #cbd5e1; padding-bottom: 15px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 15px 10px;">{{ $booking->reservation_number }}</td>
                            <td style="padding: 15px 10px;">{{ $booking->vehicle ? $booking->vehicle->name : 'N/A' }}</td>
                            <td style="padding: 15px 10px;">{{ $booking->pickup_date }} - {{ $booking->return_date }}</td>
                            <td style="padding: 15px 10px; text-transform: capitalize;">{{ $booking->payment_method }}</td>
                            <td style="padding: 15px 10px; color: #f8fafc; font-weight: 600;">${{ number_format($booking->total_amount, 2) }}</td>
                            <td style="padding: 15px 10px; color: #52ead2;">${{ number_format($booking->paid_amount, 2) }}</td>
                            <td style="padding: 15px 10px; color: #ef4444;">${{ number_format($booking->pending_amount, 2) }}</td>
                            <td style="padding: 15px 10px;">
                                @if($booking->payment_status == 'paid')
                                    <span class="badge" style="background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3);">Paid</span>
                                @elseif($booking->payment_status == 'partial_paid')
                                    <span class="badge" style="background: rgba(234, 179, 8, 0.2); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3);">Partially Paid</span>
                                @else
                                    <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);">Unpaid</span>
                                @endif
                                
                                @if($booking->payment_reference)
                                    <div style="font-size: 0.75rem; margin-top: 5px; color: #64748b;">Ref: {{ $booking->payment_reference }}</div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
