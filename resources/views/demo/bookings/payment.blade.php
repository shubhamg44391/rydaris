@extends('demo.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700;">Booking Payments</h1>
        <p style="margin: 6px 0 0; color: var(--text-muted); font-size: 0.9rem;">Your booking payment records.</p>
    </div>
</div>

<div class="glass-card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto; max-width: 100%;">
        <table class="demo-table">
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
                @foreach($items as $i => $b)
                    @php
                        $ps = strtolower($b['payment_status']);
                        $psColor = match($ps) {
                            'paid' => 'background: rgba(74,222,128,0.1); color: #4ade80; border: 1px solid rgba(74,222,128,0.2);',
                            'partial' => 'background: rgba(245,184,92,0.1); color: #f5b85c; border: 1px solid rgba(245,184,92,0.2);',
                            default => 'background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2);',
                        };
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td style="white-space: nowrap;">{{ $b['booked_at'] }}</td>
                        <td style="color: #fff; font-weight: 700; white-space: nowrap;">{{ $b['reservation'] }}</td>
                        <td style="white-space: nowrap;">{{ $b['customer'] }}</td>
                        <td style="white-space: nowrap;">{{ $b['vehicle'] }}</td>
                        <td style="white-space: nowrap;">{{ $b['payment_method'] }}</td>
                        <td style="white-space: nowrap; font-weight: bold; color: #52ead2;">₹{{ number_format($b['total'], 2) }}</td>
                        <td style="white-space: nowrap;">₹{{ number_format($b['paid'], 2) }}</td>
                        <td style="white-space: nowrap;">₹{{ number_format($b['pending'], 2) }}</td>
                        <td style="white-space: nowrap;">
                            <span style="{{ $psColor }} padding: 5px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; text-transform: capitalize;">{{ $b['payment_status'] }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
