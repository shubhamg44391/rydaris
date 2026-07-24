@extends('demo.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700;">Bookings</h1>
        <p style="margin: 6px 0 0; color: var(--text-muted); font-size: 0.9rem;">All your rental bookings.</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <button type="button" onclick="demoExportBookings()" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #52ead2, #2bc2a8); color: #051013; border: none; border-radius: 8px; font-weight: 700; font-size: 0.875rem; cursor: pointer; box-shadow: 0 2px 12px rgba(82,234,210,0.25);">
            <i class="fa-solid fa-download"></i> Export Bookings (CSV)
        </button>
    </div>
</div>

<div class="glass-card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto; max-width: 100%;">
        <table class="demo-table">
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
                    <th style="white-space: nowrap;">Terms & Conditions</th>
                    <th style="white-space: nowrap;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $i => $b)
                    @php
                        $bs = strtolower($b['booking_status']);
                        $ps = strtolower($b['payment_status']);
                        $bsColor = match($bs) {
                            'confirmed', 'ongoing', 'completed' => 'background: rgba(74,222,128,0.1); color: #4ade80; border: 1px solid rgba(74,222,128,0.2);',
                            'pending' => 'background: rgba(245,184,92,0.1); color: #f5b85c; border: 1px solid rgba(245,184,92,0.2);',
                            default => 'background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2);',
                        };
                        $psColor = match($ps) {
                            'paid' => 'background: rgba(74,222,128,0.1); color: #4ade80; border: 1px solid rgba(74,222,128,0.2);',
                            'partial' => 'background: rgba(245,184,92,0.1); color: #f5b85c; border: 1px solid rgba(245,184,92,0.2);',
                            default => 'background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2);',
                        };
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td style="white-space: nowrap;">{{ $b['booked_at'] }}</td>
                        <td style="color: #f8fafc; font-weight: 700; white-space: nowrap;">{{ $b['reservation'] }}</td>
                        <td style="white-space: nowrap;">{{ $b['customer'] }}</td>
                        <td style="white-space: nowrap;">{{ $b['vehicle'] }}</td>
                        <td style="white-space: nowrap;">{{ $b['pickup'] }}</td>
                        <td style="white-space: nowrap;">{{ $b['pickup_at'] }}</td>
                        <td style="white-space: nowrap;">{{ $b['return'] }}</td>
                        <td style="white-space: nowrap;">{{ $b['return_at'] }}</td>
                        <td style="white-space: nowrap;">₹{{ number_format($b['paid'], 2) }}</td>
                        <td style="white-space: nowrap;">₹{{ number_format($b['pending'], 2) }}</td>
                        <td style="white-space: nowrap; font-weight: bold; color: #52ead2;">₹{{ number_format($b['total'], 2) }}</td>
                        <td style="white-space: nowrap;">{{ $b['payment_ref'] }}</td>
                        <td style="white-space: nowrap;">
                            <span style="{{ $bsColor }} padding: 5px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; text-transform: capitalize;">{{ $b['booking_status'] }}</span>
                        </td>
                        <td style="white-space: nowrap;">
                            <span style="{{ $psColor }} padding: 5px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 700; text-transform: capitalize;">{{ $b['payment_status'] }}</span>
                        </td>
                        @php
                            $bookingView = [
                                'Reservation #' => $b['reservation'],
                                'Booked At' => $b['booked_at'],
                                'Customer' => $b['customer'],
                                'Vehicle Type' => $b['vehicle'],
                                'Pickup Location' => $b['pickup'],
                                'Pickup At' => $b['pickup_at'],
                                'Return Location' => $b['return'],
                                'Return At' => $b['return_at'],
                                'Paid Amount' => '₹' . number_format($b['paid'], 2),
                                'Pending Amount' => '₹' . number_format($b['pending'], 2),
                                'Total Amount' => '₹' . number_format($b['total'], 2),
                                'Payment Reference' => $b['payment_ref'],
                                'Booking Status' => $b['booking_status'],
                                'Payment Status' => $b['payment_status'],
                            ];
                        @endphp
                        <td style="white-space: nowrap;">
                            <div style="display: inline-flex; align-items: center; gap: 8px;">
                                <button type="button"
                                    data-view='@json($bookingView)'
                                    onclick="demoOpenBooking(this)"
                                    title="Edit / View Details"
                                    class="btn-action-edit"
                                    style="width: 32px; height: 32px; border-radius: 8px; background: rgba(128, 167, 255, 0.08); border: 1px solid rgba(128, 167, 255, 0.25); color: #80a7ff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; outline: none;"
                                    onmouseover="this.style.background='rgba(128, 167, 255, 0.22)';this.style.transform='translateY(-1px)';"
                                    onmouseout="this.style.background='rgba(128, 167, 255, 0.08)';this.style.transform='translateY(0)';"
                                >
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>

                                <button type="button"
                                    onclick="if(confirm('Are you sure you want to delete this booking?')) Swal.fire({title:'Deleted!', text:'Booking removed successfully.', icon:'success', timer:2000, showConfirmButton:false});"
                                    title="Delete"
                                    class="btn-action-delete"
                                    style="width: 32px; height: 32px; border-radius: 8px; background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25); color: #ef4444; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; outline: none;"
                                    onmouseover="this.style.background='rgba(239, 68, 68, 0.22)';this.style.transform='translateY(-1px)';"
                                    onmouseout="this.style.background='rgba(239, 68, 68, 0.08)';this.style.transform='translateY(0)';"
                                >
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="demoBookingModal" class="xp-overlay">
    <div class="xp-modal" style="width: 560px;">
        <div class="xp-modal-head">
            <span class="xp-modal-title">Booking Details</span>
            <button class="xp-modal-x" onclick="xpClose('demoBookingModal')">&times;</button>
        </div>
        <div class="xp-modal-body" id="demoBookingBody"></div>
        <div class="xp-modal-foot">
            <button type="button" class="xp-btn-cancel" onclick="xpClose('demoBookingModal')">Close</button>
        </div>
    </div>
</div>

<script>
function demoOpenBooking(btn) {
    const data = JSON.parse(btn.getAttribute('data-view') || '{}');
    let html = '<div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">';
    Object.keys(data).forEach(k => {
        html += `<div class="xp-fg" style="margin-bottom:0;">
            <label>${k}</label>
            <div style="padding:10px 12px; border:1px solid rgba(255,255,255,0.12); border-radius:8px; background:rgba(255,255,255,0.03); font-size:.85rem; color:#f8fafc; word-break:break-word;">${data[k] !== '' && data[k] !== null ? data[k] : '—'}</div>
        </div>`;
    });
    html += '</div>';
    document.getElementById('demoBookingBody').innerHTML = html;
    xpOpen('demoBookingModal');
}

function demoExportBookings() {
    Swal.fire({
        icon: 'success',
        title: 'Export ready',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1800
    });
}
</script>
@endsection
