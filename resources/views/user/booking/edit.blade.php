@extends('user.layouts.app')

@section('title', 'Modify Booking')

@section('main-content')
<style>
    /* Dark Theme Styles */
    .dark-card {
        background: rgba(11, 16, 32, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 12px !important;
        margin-bottom: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
    }
    .dark-input {
        background: rgba(255, 255, 255, 0.02) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #f8fafc !important;
        border-radius: 6px !important;
        padding: 8px 12px !important;
    }
    .dark-input option {
        background-color: #0f172a !important; /* Dark solid background for dropdown items */
        color: #f8fafc !important;
    }
    .dark-input:focus {
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: #3b82f6 !important;
        box-shadow: none !important;
        color: #ffffff !important;
    }
    .dark-input[readonly] {
        background: rgba(255, 255, 255, 0.01) !important;
        color: #94a3b8 !important;
    }
    .dark-label {
        color: #cbd5e1 !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        margin-bottom: 6px !important;
    }
    .section-heading {
        color: #f8fafc !important;
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        margin-bottom: 16px !important;
        padding-bottom: 12px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }
    .btn-blue {
        background-color: #3b82f6 !important;
        border: 1px solid #3b82f6 !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        padding: 8px 24px !important;
        border-radius: 6px !important;
        transition: all 0.2s !important;
    }
    .btn-blue:hover {
        background-color: #2563eb !important;
    }
    .info-alert {
        background-color: rgba(59, 130, 246, 0.1) !important;
        border: 1px solid rgba(59, 130, 246, 0.2) !important;
        color: #93c5fd !important;
        padding: 12px 16px !important;
        border-radius: 6px !important;
        font-size: 0.9rem !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }
    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 0.9rem;
        color: #cbd5e1;
    }
    .price-row.total {
        font-weight: 700;
        font-size: 1.05rem;
        border-bottom: none;
        margin-top: 8px;
        color: #f8fafc;
    }
    .extra-item {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 8px;
        padding: 12px 15px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .extra-item:hover {
        background: rgba(255,255,255,0.04);
    }
</style>

<div class="container-fluid p-4" style="min-width: 0; max-width: 100%; overflow-x: hidden;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: #f8fafc; font-weight: 700;">Modify Booking</h4>
            <div class="d-flex align-items-center gap-3 flex-wrap mt-1" style="gap: 10px;">
                <span style="color: #94a3b8; font-size: 0.9rem;">
                    Ref: <strong style="color: #cbd5e1;">{{ $booking->reservation_number }}</strong>
                </span>

                {{-- Booking Status --}}
                @php
                    $statusColors = [
                        'pending'   => ['bg' => 'rgba(251,191,36,0.15)', 'border' => '#fbbf24', 'text' => '#fbbf24'],
                        'confirmed' => ['bg' => 'rgba(34,197,94,0.15)',  'border' => '#22c55e', 'text' => '#22c55e'],
                        'cancelled' => ['bg' => 'rgba(239,68,68,0.15)',  'border' => '#ef4444', 'text' => '#ef4444'],
                        'completed' => ['bg' => 'rgba(59,130,246,0.15)', 'border' => '#3b82f6', 'text' => '#3b82f6'],
                        'on_trip'   => ['bg' => 'rgba(139,92,246,0.15)', 'border' => '#8b5cf6', 'text' => '#8b5cf6'],
                    ];
                    $bStatus = strtolower($booking->booking_status ?? 'pending');
                    $sc = $statusColors[$bStatus] ?? $statusColors['pending'];
                @endphp
                <span style="background: {{ $sc['bg'] }}; border: 1px solid {{ $sc['border'] }}; color: {{ $sc['text'] }}; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: capitalize; letter-spacing: 0.03em;">
                    ● {{ ucfirst(str_replace('_', ' ', $booking->booking_status ?? 'pending')) }}
                </span>

                {{-- Payment Status --}}
                @php
                    $payColors = [
                        'paid'    => ['bg' => 'rgba(34,197,94,0.12)',  'border' => '#22c55e', 'text' => '#22c55e'],
                        'unpaid'  => ['bg' => 'rgba(239,68,68,0.12)',  'border' => '#ef4444', 'text' => '#ef4444'],
                        'partial' => ['bg' => 'rgba(251,191,36,0.12)', 'border' => '#fbbf24', 'text' => '#fbbf24'],
                    ];
                    $pStatus = strtolower($booking->payment_status ?? 'unpaid');
                    $pc = $payColors[$pStatus] ?? $payColors['unpaid'];
                @endphp
                <span style="background: {{ $pc['bg'] }}; border: 1px solid {{ $pc['border'] }}; color: {{ $pc['text'] }}; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-transform: capitalize; letter-spacing: 0.03em;">
                    {{ ucfirst($booking->payment_status ?? 'unpaid') }}
                </span>
            </div>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.bookings.update', $booking->id) }}" method="POST" id="bookingForm">
        @csrf
        @method('PUT')
        
        <!-- Trip Details Row -->
        <div class="row mb-4">
            <!-- Pickup Details -->
            <div class="col-md-6">
                <div class="dark-card p-4 h-100 mb-0">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Pickup Details
                    </h5>
                    <div class="mb-3">
                        <label class="dark-label">Pickup Location</label>
                        <select name="pickup_location" class="form-select dark-input calc-trigger">
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}" {{ (int)old('pickup_location', $booking->pickup_location_id) === (int)$loc->id ? 'selected' : '' }}>{{ $loc->location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="dark-label">Pickup Date</label>
                            <input type="date" name="pickup_date" id="pickup_date" class="form-control dark-input calc-trigger" value="{{ old('pickup_date', $booking->pickup_date ? date('Y-m-d', strtotime($booking->pickup_date)) : '') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="dark-label">Pickup Time</label>
                            <input type="time" name="pickup_time" class="form-control dark-input" value="{{ old('pickup_time', $booking->pickup_time ? date('H:i', strtotime($booking->pickup_time)) : '') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Return Details -->
            <div class="col-md-6">
                <div class="dark-card p-4 h-100 mb-0">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Return Details
                    </h5>
                    <div class="mb-3">
                        <label class="dark-label">Return Location</label>
                        <select name="return_location" class="form-select dark-input calc-trigger">
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}" {{ (int)old('return_location', $booking->return_location_id) === (int)$loc->id ? 'selected' : '' }}>{{ $loc->location }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="dark-label">Return Date</label>
                            <input type="date" name="return_date" id="return_date" class="form-control dark-input calc-trigger" value="{{ old('return_date', $booking->return_date ? date('Y-m-d', strtotime($booking->return_date)) : '') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="dark-label">Return Time</label>
                            <input type="time" name="return_time" class="form-control dark-input" value="{{ old('return_time', $booking->return_time ? date('H:i', strtotime($booking->return_time)) : '') }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional Extras -->
        <div class="dark-card p-4">
            <h5 class="section-heading">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path><line x1="16" y1="8" x2="2" y2="22"></line><line x1="17.5" y1="15" x2="9" y2="6.5"></line></svg>
                Optional extras
            </h5>
            <div class="row">
                @forelse($availableExtras as $extra)
                    @php $qty = $selectedExtras[$extra->id] ?? 0; @endphp
                    <div class="col-md-12">
                        <div class="extra-item" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; background: rgba(11, 16, 32, 0.4); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; margin-bottom: 15px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="color: #00d2ff; background: rgba(0, 210, 255, 0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </div>
                                <div>
                                    <h6 style="color: #f8fafc; font-weight: 600; margin-bottom: 3px;">{{ $extra->name }}</h6>
                                    <p style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 5px;">Optional equipment for your rental</p>
                                    <span style="color: #00d2ff; font-weight: 600; font-size: 0.9rem;">${{ number_format($extra->price, 2) }} / {{ $extra->price_type == 1 ? 'Day' : 'Total' }}</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 5px 15px;">
                                <button type="button" class="qty-btn minus-btn" data-id="{{ $extra->id }}" style="background: none; border: none; color: #f8fafc; font-size: 1.2rem; cursor: pointer; padding: 0 5px;">-</button>
                                <span class="qty-display" id="qty_display_{{ $extra->id }}" style="color: #f8fafc; font-weight: 600; padding: 0 15px; min-width: 40px; text-align: center;">{{ $qty }}</span>
                                <input type="hidden" name="extras[{{ $extra->id }}]" id="extra_input_{{ $extra->id }}" value="{{ $qty }}" class="calc-trigger extra-qty-input">
                                <button type="button" class="qty-btn plus-btn" data-id="{{ $extra->id }}" style="background: none; border: none; color: #f8fafc; font-size: 1.2rem; cursor: pointer; padding: 0 5px;">+</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="color: #64748b; font-size: 0.9rem; padding: 0 15px;">
                        No extras available for this vendor.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Current Vehicle & Pricing -->
        <div class="dark-card p-4">
            <h5 class="section-heading">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="10" rx="2"></rect><circle cx="7" cy="21" r="2"></circle><circle cx="17" cy="21" r="2"></circle><path d="M14 11V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v4"></path></svg>
                Current vehicle
            </h5>
            <div class="row">
                <div class="col-md-6">
                    {{-- Hidden field to keep vehicle_id in form submission --}}
                    <input type="hidden" name="vehicle_id" value="{{ $booking->vehicle_id }}">

                    {{-- Vehicle Image --}}
                    @if($booking->vehicle && $booking->vehicle->image)
                        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 12px; text-align: center; margin-bottom: 14px;">
                            <img src="{{ asset('storage/' . $booking->vehicle->image) }}" alt="{{ $booking->vehicle->name }}" style="max-height: 130px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 8px 20px rgba(0,0,0,0.5));">
                        </div>
                    @endif

                    {{-- Vehicle Name --}}
                    <h6 style="color: #f8fafc; font-weight: 700; font-size: 1.05rem; margin-bottom: 4px;">{{ $booking->vehicle->name ?? 'N/A' }}</h6>
                    @php
                        $initialDays = 1;
                        if ($booking->pickup_date && $booking->return_date) {
                            $diff = $booking->pickup_date_parsed->diffInDays($booking->return_date_parsed);
                            $initialDays = $diff > 0 ? $diff : 1;
                        }
                    @endphp
                    <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 0;">Total Days: <span id="display_days">{{ $initialDays }}</span></p>
                </div>
                <div class="col-md-6" style="border-left: 1px solid rgba(255, 255, 255, 0.05); padding-left: 30px;">
                    <div class="price-row">
                        <span>Car Amount</span>
                        <span id="display_car_amount">${{ number_format($booking->vehicle->price_per_day ?? 0, 2) }}</span>
                    </div>
                    <div class="price-row" id="extras_row">
                        <span>Extras</span>
                        <span id="display_extras_amount">$0.00</span>
                    </div>
                    <div class="price-row">
                        <span>Paid Amount</span>
                        <span style="color: #34d399;" id="display_paid_amount">${{ number_format($booking->paid_amount ?? ($booking->payment_status == 'paid' ? $booking->total_amount : 0), 2) }}</span>
                    </div>
                    <div class="price-row">
                        <span>Pending Amount</span>
                        <span style="color: #f87171;" id="display_pending_amount">${{ number_format($booking->pending_amount ?? ($booking->payment_status == 'paid' ? 0 : $booking->total_amount), 2) }}</span>
                    </div>
                    <div class="price-row total">
                        <span>Total Amount</span>
                        <span id="display_total_amount">${{ number_format($booking->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="text-end mt-4 pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.05);">
                <button type="submit" class="btn btn-blue">Update Booking</button>
            </div>
        </div>

        <!-- Passenger Information -->
        <div class="dark-card p-4">
            <h5 class="section-heading">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                My Information
            </h5>
            
            <div class="info-alert mb-4">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                Please make sure you provide valid contact details as we will use this to confirm your booking.
            </div>

            <h6 style="color: #94a3b8; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 16px;">Personal Information</h6>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="dark-label">First Name *</label>
                    <input type="text" name="customer_fname" class="form-control dark-input" value="{{ old('customer_fname', $booking->customer_fname) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="dark-label">Last Name *</label>
                    <input type="text" name="customer_lname" class="form-control dark-input" value="{{ old('customer_lname', $booking->customer_lname) }}" required>
                </div>
                
                <div class="col-md-6">
                    <label class="dark-label">Email Address *</label>
                    <input type="email" name="customer_email" id="customer_email" class="form-control dark-input" value="{{ old('customer_email', $booking->customer_email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="dark-label">Confirm Email *</label>
                    <input type="email" name="customer_email_confirm" id="customer_email_confirm" class="form-control dark-input" value="{{ old('customer_email_confirm', $booking->customer_email) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="dark-label">Phone Number *</label>
                    <input type="tel" name="customer_phone" id="edit_phone" class="form-control dark-input" value="{{ old('customer_phone', $booking->customer_phone) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="dark-label">Date of Birth</label>
                    <input type="date" name="customer_dob" class="form-control dark-input" value="{{ old('customer_dob', $booking->customer_dob ? date('Y-m-d', strtotime($booking->customer_dob)) : '') }}">
                </div>
            </div>

            <h6 style="color: #94a3b8; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 16px; margin-top: 24px;">Additional Information (Optional)</h6>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="dark-label">Special Comments</label>
                    <textarea class="form-control dark-input" rows="4" name="special_comments">{{ old('special_comments', $booking->special_comments ?? '') }}</textarea>
                </div>
            </div>
            
            <div class="text-end mt-4 pt-3" style="border-top: 1px solid rgba(255, 255, 255, 0.05);">
                <button type="submit" class="btn btn-blue">Update Changes</button>
            </div>
        </div>
        
    </form>
</div>
@endsection

@section('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/css/intlTelInput.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/js/intlTelInput.min.js"></script>
<style>
    /* intl-tel-input dark theme overrides */
    .iti { width: 100%; display: block; }
    .iti__country-list { background: rgba(11, 16, 32, 0.98); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px; z-index: 9999; }
    .iti__country-list .iti__country:hover, .iti__country-list .iti__country.iti__highlight { background: rgba(59, 130, 246, 0.2); }
    .iti__selected-flag { background: transparent !important; padding: 0 12px; border-right: 1px solid rgba(255,255,255,0.1); display: flex !important; flex-direction: row !important; align-items: center !important; flex-wrap: nowrap !important; gap: 6px !important; }
    .iti__flag { order: 1 !important; }
    .iti__selected-dial-code { color: #fff !important; margin-left: 6px; display: inline-block !important; white-space: nowrap !important; order: 2 !important; }
    .iti__arrow { border-top-color: #fff !important; order: 3 !important; }
    .iti__arrow--up { border-bottom-color: #fff !important; }
    #edit_phone { padding-left: 115px !important; }

    .iti__search-input { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: #fff; margin-bottom: 8px; padding: 8px; border-radius: 4px; width: calc(100% - 16px); display: block; margin-left: auto; margin-right: auto; }
    
    /* Hide country name - show only flag and country dial code */
    .iti__country-name { display: none !important; }
    .iti__dial-code { margin-left: 8px; font-weight: 600; color: #fff; }
    .iti__country { display: flex; align-items: center; padding: 8px 12px; gap: 4px; }
</style>
<script>
    const vehicles = @json($vehicles);
    const extras = @json($availableExtras);
    const booking = @json($booking);
    
    let originalPaidAmount = parseFloat(booking.paid_amount) || 0;

    function calculateTotal() {
        let pDate = document.getElementById('pickup_date').value;
        let rDate = document.getElementById('return_date').value;
        
        let days = 1;
        if(pDate && rDate) {
            let start = new Date(pDate);
            let end = new Date(rDate);
            let diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            if(diff > 0) days = diff;
        }
        
        document.getElementById('display_days').innerText = days;
        
        let vehiclePrice = parseFloat((booking.vehicle && booking.vehicle.price_per_day) ? booking.vehicle.price_per_day : 50);
        
        let carTotal = vehiclePrice * days;
        document.getElementById('display_car_amount').innerText = '$' + carTotal.toFixed(2);
        
        let extrasTotal = 0;
        document.querySelectorAll('.extra-qty-input').forEach(input => {
            let qty = parseInt(input.value) || 0;
            if (qty > 0) {
                // extract id from id="extra_input_12"
                let extraId = input.id.replace('extra_input_', '');
                let ex = extras.find(e => e.id == extraId);
                if(ex) {
                    let exPrice = parseFloat(ex.price);
                    if (ex.price_type == 1) { // Per Day
                        extrasTotal += (exPrice * days * qty);
                    } else { // Total
                        extrasTotal += (exPrice * qty);
                    }
                }
            }
        });
        
        document.getElementById('display_extras_amount').innerText = '$' + extrasTotal.toFixed(2);
        
        let grandTotal = carTotal + extrasTotal;
        document.getElementById('display_total_amount').innerText = '$' + grandTotal.toFixed(2);
        
        let pending = grandTotal - originalPaidAmount;
        if (pending < 0) pending = 0;
        
        document.getElementById('display_pending_amount').innerText = '$' + pending.toFixed(2);
    }

    // Handle +/- buttons
    document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let input = document.getElementById('extra_input_' + id);
            let display = document.getElementById('qty_display_' + id);
            let val = parseInt(input.value) || 0;
            input.value = val + 1;
            display.innerText = val + 1;
            calculateTotal();
        });
    });

    document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let input = document.getElementById('extra_input_' + id);
            let display = document.getElementById('qty_display_' + id);
            let val = parseInt(input.value) || 0;
            if (val > 0) {
                input.value = val - 1;
                display.innerText = val - 1;
                calculateTotal();
            }
        });
    });

    // Listen to both 'change' and 'input' on date fields to ensure live update
    ['pickup_date', 'return_date'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('change', calculateTotal);
            el.addEventListener('input', calculateTotal);
        }
    });

    // Listen to location dropdowns
    document.querySelectorAll('select.calc-trigger').forEach(el => {
        el.addEventListener('change', calculateTotal);
    });

    // Initial calculation
    calculateTotal();

    // Init international phone input with search enabled
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInputField = document.getElementById('edit_phone');
        if (phoneInputField) {
            const storedPhone = phoneInputField.value || '';
            const options = {
                preferredCountries: ["ae", "sa", "in", "us", "gb", "au"],
                initialCountry: "ae", // Instantly show UAE (no grey box!)
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/js/utils.js",
                showSelectedDialCode: true,
                formatOnDisplay: true,
                countrySearch: true
            };
            
            // Only allow numbers to be entered
            phoneInputField.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            const iti = window.intlTelInput(phoneInputField, options);

            // Fetch IP country in the background if number has no prefix
            if (!storedPhone.startsWith('+')) {
                fetch('https://ipapi.co/json/')
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.country_code) {
                            iti.setCountry(data.country_code.toLowerCase());
                        }
                    })
                    .catch(() => console.log('IP lookup failed, using fallback UAE.'));
            }

            // On form submit, replace input value with full international number
            const form = document.getElementById('bookingForm');
            if (form) {
                form.addEventListener('submit', function() {
                    if (iti.getNumber()) {
                        phoneInputField.value = iti.getNumber();
                    }
                });
            }
        }
    });
</script>
@endsection
