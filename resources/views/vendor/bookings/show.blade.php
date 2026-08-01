@extends('admin.layouts.app')

@section('title', 'Booking Details')

@section('main-content')
<div class="container-fluid p-4" style="min-width: 0; max-width: 100%; overflow-x: hidden;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-white" style="font-weight: 800;">Booking Details</h3>
        <a href="{{ route('vendor.bookings.index') }}" class="text-decoration-none" style="color: #94a3b8; font-size: 0.9rem;">
            Booking / <span style="color: #3b82f6;">Booking Details</span>
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

    <form action="{{ route('vendor.bookings.update', $booking->id) }}" method="POST" id="vendorBookingForm">
        @csrf
        @method('PUT')
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Passenger Information</h5>
            </div>
            <div class="card-body p-4">
                
                <style>
                    .card {
                        background: #111620 !important;
                        border: 1px solid rgba(255, 255, 255, 0.08) !important;
                        border-radius: 12px !important;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25) !important;
                        overflow: visible !important;
                        transition: none !important;
                    }
                    .card:hover {
                        transform: none !important;
                        background: #111620 !important;
                        border-color: rgba(255, 255, 255, 0.08) !important;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25) !important;
                    }
                    .card-header {
                        background: #18202c !important;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
                        border-top-left-radius: 11px !important;
                        border-top-right-radius: 11px !important;
                        padding: 15px 20px !important;
                    }
                    .card-header h5 {
                        color: #f8fafc !important;
                    }
                    .card-footer {
                        background: #18202c !important;
                        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
                        border-bottom-left-radius: 11px !important;
                        border-bottom-right-radius: 11px !important;
                        padding: 15px 20px !important;
                    }
                    .dark-input {
                        background: #0b0f17 !important;
                        border: 1px solid rgba(255, 255, 255, 0.12) !important;
                        color: #f8fafc !important;
                        border-radius: 6px;
                    }
                    .dark-input:focus {
                        border-color: #3b82f6 !important;
                        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25) !important;
                    }
                    /* Custom calendar icon — replaces native browser icon */
                    input[type="date"],
                    input[type="date"].dark-input {
                        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2352ead2' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
                        background-repeat: no-repeat !important;
                        background-position: right 12px center !important;
                        background-size: 18px 18px !important;
                        padding-right: 40px !important;
                        cursor: pointer !important;
                    }
                    input[type="date"]::-webkit-calendar-picker-indicator {
                        opacity: 0 !important;
                        position: absolute;
                        right: 0;
                        width: 40px;
                        height: 100%;
                        cursor: pointer !important;
                    }
                    body.light-mode input[type="date"],
                    body.light-mode input[type="date"].dark-input {
                        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%230f766e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
                        background-repeat: no-repeat !important;
                        background-position: right 12px center !important;
                        background-size: 18px 18px !important;
                        color: #0f172a !important;
                        -webkit-text-fill-color: #0f172a !important;
                    }
                    input[type="time"] {
                        cursor: pointer !important;
                    }
                    .dark-label {
                        color: #94a3b8;
                        font-size: 0.85rem;
                        font-weight: 600;
                        margin-bottom: 8px;
                    }

                    .assigned-driver-name {
                        color: #52ead2 !important;
                        -webkit-text-fill-color: #52ead2 !important;
                    }
                    body.light-mode .assigned-driver-name {
                        color: #0f766e !important;
                        -webkit-text-fill-color: #0f766e !important;
                    }

                    /* Light Mode Overrides */
                    body.light-mode h3.text-white {
                        color: #0f172a !important;
                    }
                    body.light-mode .card {
                        background: #ffffff !important;
                        border: 1px solid #cbd5e1 !important;
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
                    }
                    body.light-mode .card:hover {
                        transform: none !important;
                        background: #ffffff !important;
                        border-color: #cbd5e1 !important;
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
                    }
                    body.light-mode .card-header {
                        background: #f8fafc !important;
                        border-bottom: 1px solid #cbd5e1 !important;
                    }
                    body.light-mode .card-footer {
                        background: #f8fafc !important;
                        border-top: 1px solid #cbd5e1 !important;
                    }
                    body.light-mode .card-header h5 {
                        color: #0f172a !important;
                    }
                    body.light-mode .dark-input {
                        background: #ffffff !important;
                        border: 1px solid #cbd5e1 !important;
                        color: #0f172a !important;
                        -webkit-text-fill-color: #0f172a !important;
                    }
                    body.light-mode .dark-input::placeholder {
                        color: #94a3b8 !important;
                        -webkit-text-fill-color: #94a3b8 !important;
                    }
                    body.light-mode input.dark-input[readonly],
                    body.light-mode textarea.dark-input[readonly] {
                        background: #f8fafc !important;
                        color: #0f172a !important;
                        -webkit-text-fill-color: #64748b !important;
                    }
                    body.light-mode input[type="date"].dark-input,
                    body.light-mode input[type="time"].dark-input {
                        color: #0f172a !important;
                        -webkit-text-fill-color: #0f172a !important;
                        background: #ffffff !important;
                    }
                    body.light-mode input.dark-input[style*="#52ead2"] {
                        color: #0f766e !important;
                    }
                    body.light-mode .dark-label {
                        color: #475569 !important;
                    }
                    body.light-mode h6 {
                        color: #0f172a !important;
                    }
                    body.light-mode p:not([class*="iti"]),
                    body.light-mode span:not([class*="badge"]):not([class*="iti"]) {
                        color: #0f172a !important;
                    }
                    body.light-mode p[style*="#52ead2"],
                    body.light-mode span[style*="#52ead2"] {
                        color: #0f766e !important;
                    }
                    body.light-mode #assignDriverModal > div {
                        background: #ffffff !important;
                        border: 1px solid #cbd5e1 !important;
                        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1) !important;
                    }
                    body.light-mode #assignDriverModal h5 {
                        color: #0f172a !important;
                    }
                    body.light-mode #assignDriverModal select option {
                        background: #ffffff !important;
                        color: #0f172a !important;
                    }
                </style>

                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="dark-label">First Name *</label>
                        <input type="text" name="customer_fname" class="form-control dark-input" value="{{ old('customer_fname', $booking->customer_fname) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="dark-label">Last Name *</label>
                        <input type="text" name="customer_lname" class="form-control dark-input" value="{{ old('customer_lname', $booking->customer_lname) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="dark-label">Phone Number *</label>
                        @include('partials.phone-input')
                        <input type="tel" id="vendor_phone" class="form-control dark-input" value="{{ old('customer_phone', $booking->customer_phone) }}" required style="width: 100%;">
                        <input type="hidden" name="country_code" id="hidden_country_code" value="{{ old('country_code', $booking->country_code ?? '') }}">
                        <input type="hidden" name="customer_phone" id="hidden_contact_number" value="{{ old('customer_phone', $booking->customer_phone) }}">
                        <script>
                            (function setupVendorPhone() {
                                if (typeof initializeIntlTelInput === 'function') {
                                    initializeIntlTelInput('vendor_phone', 'hidden_country_code', 'hidden_contact_number');
                                } else {
                                    setTimeout(setupVendorPhone, 50);
                                }
                            })();
                        </script>
                    </div>
                    
                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Email *</label>
                        <input type="email" name="customer_email" class="form-control dark-input" value="{{ old('customer_email', $booking->customer_email) }}" required>
                    </div>
                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Date of birth *</label>
                        <input type="date" name="customer_dob" class="form-control dark-input" value="{{ old('customer_dob', $booking->customer_dob ? date('Y-m-d', strtotime($booking->customer_dob)) : '') }}">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="dark-label">Order Number *</label>
                        <input type="text" class="form-control dark-input" value="{{ $booking->reservation_number ?? $booking->id }}" readonly style="background: rgba(255,255,255,0.02) !important;">
                    </div>
                </div>

            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Trip & Booking Details</h5>
            </div>
            <div class="card-body p-4">

                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="dark-label">Vehicle *</label>
                        <input type="text" class="form-control dark-input" value="{{ $booking->vehicle->name ?? 'N/A' }}" readonly style="background: rgba(255,255,255,0.02) !important;">
                    </div>
                    <div class="col-md-3">
                        <label class="dark-label">Pickup Location *</label>
                        <input type="text" class="form-control dark-input" value="{{ $booking->pickupLocation->name ?? 'N/A' }}" readonly style="background: rgba(255,255,255,0.02) !important;">
                    </div>
                    <div class="col-md-3">
                        <label class="dark-label">Pickup Date *</label>
                        @php
                            $pTimestamp = $booking->pickup_date ? strtotime($booking->pickup_date) : false;
                            $pDate = ($pTimestamp && $pTimestamp > 0) ? date('Y-m-d', $pTimestamp) : '';
                        @endphp
                        <input type="date" name="pickup_date" class="form-control dark-input" value="{{ old('pickup_date', $pDate) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="dark-label">Pickup Time *</label>
                        <input type="time" name="pickup_time" class="form-control dark-input" value="{{ old('pickup_time', $booking->pickup_time ? date('H:i', strtotime($booking->pickup_time)) : '') }}" required>
                    </div>

                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Return Location *</label>
                        <input type="text" class="form-control dark-input" value="{{ $booking->returnLocation->name ?? 'N/A' }}" readonly style="background: rgba(255,255,255,0.02) !important;">
                    </div>
                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Return Date *</label>
                        @php
                            $rTimestamp = $booking->return_date ? strtotime($booking->return_date) : false;
                            $rDate = ($rTimestamp && $rTimestamp > 0) ? date('Y-m-d', $rTimestamp) : '';
                        @endphp
                        <input type="date" name="return_date" class="form-control dark-input" value="{{ old('return_date', $rDate) }}" required>
                    </div>
                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Return Time *</label>
                        <input type="time" name="return_time" class="form-control dark-input" value="{{ old('return_time', $booking->return_time ? date('H:i', strtotime($booking->return_time)) : '') }}" required>
                    </div>
                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Total Days *</label>
                        <input type="text" class="form-control dark-input" value="{{ $booking->total_days ?? 1 }}" readonly style="background: rgba(255,255,255,0.02) !important;">
                    </div>

                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Payment Method *</label>
                        <select name="payment_method" class="form-select dark-input" required>
                            <option value="pay_on_arrival" {{ old('payment_method', $booking->payment_method) == 'pay_on_arrival' ? 'selected' : '' }}>Pay on Arrival</option>
                            <option value="stripe" {{ old('payment_method', $booking->payment_method) == 'stripe' ? 'selected' : '' }}>Stripe</option>
                            <option value="paypal" {{ old('payment_method', $booking->payment_method) == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Payment Reference</label>
                        <input type="text" name="payment_reference" class="form-control dark-input" value="{{ old('payment_reference', $booking->payment_reference) }}">
                    </div>
                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Car Amount *</label>
                        <input type="text" class="form-control dark-input" value="{{ $booking->vehicle->price_per_day ?? 0 }}" readonly style="background: rgba(255,255,255,0.02) !important;">
                    </div>
                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Driver Fees *</label>
                        <input type="text" class="form-control dark-input" value="0" readonly style="background: rgba(255,255,255,0.02) !important;">
                    </div>

                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Total Amount ($) *</label>
                        <input type="number" step="0.01" name="total_amount" class="form-control dark-input" value="{{ old('total_amount', $booking->total_amount) }}" required>
                    </div>
                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Paid Amount ($) *</label>
                        <input type="number" step="0.01" name="paid_amount" class="form-control dark-input" value="{{ old('paid_amount', $booking->payment_status == 'paid' ? $booking->total_amount : 0) }}" required>
                    </div>
                    <div class="col-md-3 mt-4">
                        <label class="dark-label">Pending Amount ($) *</label>
                        <input type="number" step="0.01" name="pending_amount" class="form-control dark-input" value="{{ old('pending_amount', $booking->payment_status == 'paid' ? 0 : $booking->total_amount) }}" required>
                    </div>
                    
                    <div class="col-md-12 mt-4">
                        <label class="dark-label">Additional comments</label>
                        <textarea class="form-control dark-input" rows="3" readonly style="background: rgba(255,255,255,0.02) !important;">{{ $booking->special_comments ?? 'No comments' }}</textarea>
                    </div>

                </div>

            </div>
        </div>

        <!-- Assigned Driver Card Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Assigned Driver</h5>
            </div>
            <div class="card-body p-4" id="assignedDriverSection">
                @if($booking->driver)
                    <div class="row g-4 align-items-end" id="driverDetailsBlock">
                        <div class="col-md-3">
                            <label class="dark-label">Driver Name</label>
                            <input type="text" class="form-control dark-input assigned-driver-name" value="{{ $booking->driver->name }}" readonly style="font-weight: 600;">
                        </div>
                        <div class="col-md-3">
                            <label class="dark-label">Contact Number</label>
                            <input type="text" class="form-control dark-input" value="{{ $booking->driver->phone }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="dark-label">Address</label>
                            <input type="text" class="form-control dark-input" value="{{ $booking->driver->address }}" readonly>
                        </div>
                        <div class="col-md-2 text-end d-flex align-items-center justify-content-end" style="height: 38px;">
                            <div class="d-flex gap-2 justify-content-end w-100">
                                <button type="button" class="btn btn-sm" onclick="openAssignDriverModal()" style="background: rgba(82, 234, 210, 0.1); color: #52ead2; border: 1px solid rgba(82, 234, 210, 0.3); font-weight: 700; border-radius: 6px; padding: 8px 14px; flex: 1;">
                                    Change Driver
                                </button>
                                <button type="button" class="btn btn-sm" onclick="removeDriverAssignment()" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); font-weight: 700; border-radius: 6px; padding: 8px 14px; flex: 1;">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row g-4 align-items-end" id="noDriverBlock">
                        <div class="col-md-9 col-lg-10">
                            <label class="dark-label">Driver Status</label>
                            <input type="text" class="form-control dark-input" value="No Driver Assigned" readonly style="font-style: italic;">
                        </div>
                        <div class="col-md-3 col-lg-2 text-end d-flex align-items-center justify-content-end" style="height: 38px;">
                            <button type="button" class="btn" onclick="openAssignDriverModal()" style="background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%); color: #051013; font-weight: 700; border: none; border-radius: 999px; padding: 8px 24px; white-space: nowrap; width: 100%;">
                                Assign Driver
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Customer Verification Documents</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    
                    <div class="col-md-6">
                        <h6 style="color: #cbd5e1; font-weight: 700; margin-bottom: 15px; border-bottom: 1px dashed rgba(255,255,255,0.05); padding-bottom: 8px;">Driver's License Details</h6>
                        @if($booking->license_number)
                            <div class="mb-3">
                                <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">License Number</span>
                                <p style="color: #f8fafc; font-weight: 600; margin: 2px 0 0;">{{ $booking->license_number }}</p>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Issue Date</span>
                                    <p style="color: #f8fafc; font-weight: 600; margin: 2px 0 0;">{{ date('d M Y', strtotime($booking->license_issue_date)) }}</p>
                                </div>
                                <div class="col-6">
                                    <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Expiry Date</span>
                                    <p style="color: #f8fafc; font-weight: 600; margin: 2px 0 0;">{{ date('d M Y', strtotime($booking->license_expiry_date)) }}</p>
                                </div>
                            </div>
                            @if($booking->license_image)
                                <div class="mt-3">
                                    <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">License Image Preview</span>
                                    @php
                                        $licenseExt = pathinfo($booking->license_image, PATHINFO_EXTENSION);
                                    @endphp
                                    @if(strtolower($licenseExt) === 'pdf')
                                        <a href="{{ asset('storage/' . $booking->license_image) }}" target="_blank" class="btn btn-sm btn-outline-info" style="display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(255,255,255,0.15); color: #cbd5e1; padding: 6px 12px; border-radius: 4px; text-decoration: none; background: rgba(255,255,255,0.02);">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line></svg>
                                            View License PDF
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $booking->license_image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $booking->license_image) }}" alt="Driver's License" style="max-width: 100%; max-height: 250px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; object-fit: contain; background: rgba(0,0,0,0.2);">
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @else
                            <p style="color: #64748b; font-style: italic; font-size: 0.9rem;">No Driver's License details uploaded yet.</p>
                        @endif
                    </div>

                    
                    <div class="col-md-6">
                        <h6 style="color: #cbd5e1; font-weight: 700; margin-bottom: 15px; border-bottom: 1px dashed rgba(255,255,255,0.05); padding-bottom: 8px;">Passport / ID Details</h6>
                        @if($booking->pass_number)
                            <div class="mb-3">
                                <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Passport / ID Number</span>
                                <p style="color: #f8fafc; font-weight: 600; margin: 2px 0 0;">{{ $booking->pass_number }}</p>
                            </div>
                            @if($booking->flight_number)
                                <div class="mb-3">
                                    <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Flight Number</span>
                                    <p style="color: #52ead2; font-weight: 600; margin: 2px 0 0;">{{ $booking->flight_number }}</p>
                                </div>
                            @endif
                            @if($booking->passport_image)
                                <div class="mt-3">
                                    <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">Passport Image Preview</span>
                                    @php
                                        $passportExt = pathinfo($booking->passport_image, PATHINFO_EXTENSION);
                                    @endphp
                                    @if(strtolower($passportExt) === 'pdf')
                                        <a href="{{ asset('storage/' . $booking->passport_image) }}" target="_blank" class="btn btn-sm btn-outline-info" style="display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(255,255,255,0.15); color: #cbd5e1; padding: 6px 12px; border-radius: 4px; text-decoration: none; background: rgba(255,255,255,0.02);">
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line></svg>
                                            View Passport PDF
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $booking->passport_image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $booking->passport_image) }}" alt="Passport or ID" style="max-width: 100%; max-height: 250px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; object-fit: contain; background: rgba(0,0,0,0.2);">
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @else
                            <p style="color: #64748b; font-style: italic; font-size: 0.9rem;">No Passport or ID details uploaded yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%); border: none; color: #051013; font-weight: 700; padding: 8px 24px; border-radius: 999px;">Update</button>
            </div>
        </div>
        
    </form>
</div>

<!-- Assign Driver Popup Modal -->
<div id="assignDriverModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: var(--bg-card, #1e293b); border: 1px solid var(--line, #334155); border-radius: 12px; width: 100%; max-width: 480px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--line, #334155); display: flex; justify-content: space-between; align-items: center;">
            <h5 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: var(--text, #f8fafc);" id="assignDriverModalTitle">
                {{ $booking->driver ? 'Change Driver' : 'Assign Driver' }}
            </h5>
            <button type="button" onclick="closeAssignDriverModal()" style="background: none; border: none; color: #94a3b8; font-size: 1.4rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        <form id="assignDriverForm" onsubmit="event.preventDefault(); submitAssignDriverForm();">
            @csrf
            <div style="padding: 20px;">
                <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 8px;">Select Driver *</label>
                <select name="driver_id" id="assign_driver_id" class="form-select dark-input" style="width: 100%; font-weight: 600;" required>
                    <option value="">-- Select Driver --</option>
                    @if(isset($activeDrivers))
                        @foreach($activeDrivers as $drv)
                            <option value="{{ $drv->id }}" {{ $booking->driver_id == $drv->id ? 'selected' : '' }}>
                                {{ $drv->name }} | {{ $drv->phone }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @if(isset($activeDrivers) && $activeDrivers->isEmpty())
                    <p style="color: #f87171; font-size: 0.82rem; margin-top: 8px; margin-bottom: 0;">No available unassigned drivers. All active drivers are currently assigned to active trips.</p>
                @endif
            </div>
            <div style="padding: 14px 20px; border-top: 1px solid var(--line, #334155); display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeAssignDriverModal()" class="btn btn-secondary rounded-pill px-4" style="font-weight: 700;">Cancel</button>
                <button type="button" id="btnAssignDriverSubmit" onclick="submitAssignDriverForm()" class="btn rounded-pill px-4" style="background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%); color: #051013; border: none; font-weight: 700;" {{ (isset($activeDrivers) && $activeDrivers->isEmpty()) ? 'disabled' : '' }}>Assign</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/css/intlTelInput.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.16/js/intlTelInput.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
    /* Calendar Icon inside Date Input */
    input[type="date"],
    input.flatpickr-input {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2352ead2' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 14px center !important;
        background-size: 18px 18px !important;
        padding-right: 40px !important;
        cursor: pointer !important;
    }

    body.light-mode input[type="date"],
    body.light-mode input.flatpickr-input {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%230f766e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'%3E%3C/rect%3E%3Cline x1='16' y1='2' x2='16' y2='6'%3E%3C/line%3E%3Cline x1='8' y1='2' x2='8' y2='6'%3E%3C/line%3E%3Cline x1='3' y1='10' x2='21' y2='10'%3E%3C/line%3E%3C/svg%3E") !important;
    }

    /* Flatpickr Calendar Styling Fixes */
    .flatpickr-calendar {
        background: #111620 !important;
        border: 1px solid rgba(82, 234, 210, 0.3) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6) !important;
        border-radius: 12px !important;
        z-index: 999999 !important;
        padding: 6px !important;
    }
    .flatpickr-months {
        align-items: center !important;
        padding: 6px 0 !important;
    }
    .flatpickr-months .flatpickr-month {
        background: #111620 !important;
        color: #f8fafc !important;
        height: 42px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .flatpickr-current-month {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        height: auto !important;
        font-size: 1.05rem !important;
        line-height: 1.4 !important;
        position: static !important;
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months {
        color: #f8fafc !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
        background: transparent !important;
        padding: 2px 6px !important;
        height: auto !important;
        line-height: 1.4 !important;
        display: inline-block !important;
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months option {
        background: #111620 !important;
        color: #f8fafc !important;
    }
    .flatpickr-current-month .numInputWrapper input.cur-year {
        color: #f8fafc !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
        line-height: 1.4 !important;
    }
    .flatpickr-day {
        color: #e2e8f0 !important;
        border-radius: 6px !important;
    }
    span.flatpickr-weekday {
        color: #cbd5e1 !important;
        font-weight: 700 !important;
    }
    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange {
        background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
        color: #051013 !important;
        font-weight: 800 !important;
        border-color: transparent !important;
    }
    .flatpickr-day:hover {
        background: rgba(82, 234, 210, 0.2) !important;
    }
    .flatpickr-months .flatpickr-prev-month svg,
    .flatpickr-months .flatpickr-next-month svg {
        fill: #52ead2 !important;
    }

    /* Light Mode Flatpickr Overrides */
    body.light-mode .flatpickr-calendar {
        background: #ffffff !important;
        border: 1px solid rgba(15, 23, 42, 0.15) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }
    body.light-mode .flatpickr-months .flatpickr-month {
        background: #ffffff !important;
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-current-month .flatpickr-monthDropdown-months,
    body.light-mode .flatpickr-current-month .numInputWrapper input.cur-year {
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-current-month .flatpickr-monthDropdown-months option {
        background: #ffffff !important;
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-weekdays,
    body.light-mode .flatpickr-weekdaycontainer,
    body.light-mode span.flatpickr-weekday {
        background: #f1f5f9 !important;
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-day {
        color: #0f172a !important;
        font-weight: 600 !important;
    }
    body.light-mode .flatpickr-day.prevMonthDay,
    body.light-mode .flatpickr-day.nextMonthDay {
        color: #94a3b8 !important;
    }
    body.light-mode .flatpickr-day.today {
        border-color: #0f766e !important;
    }
    body.light-mode .flatpickr-day.selected {
        background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
        color: #051013 !important;
    }
    body.light-mode .flatpickr-day:hover {
        background: rgba(15, 23, 42, 0.08) !important;
    }
    body.light-mode .flatpickr-months .flatpickr-prev-month svg,
    body.light-mode .flatpickr-months .flatpickr-next-month svg {
        fill: #0f766e !important;
    }
<style>
    /* intl-tel-input Dark Mode & Light Mode Styles */
    .iti { width: 100%; display: block; }
    
    .iti__selected-flag,
    .iti__selected-country {
        background: transparent !important;
        padding: 0 12px !important;
        border-right: 1px solid rgba(255, 255, 255, 0.12) !important;
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 6px !important;
    }
    .iti__flag { order: 1 !important; }
    .iti__selected-dial-code {
        color: #f8fafc !important;
        -webkit-text-fill-color: #f8fafc !important;
        margin-left: 6px;
        order: 2 !important;
        font-weight: 600;
        display: inline-block !important;
    }
    .iti__arrow { border-top-color: #94a3b8 !important; order: 3 !important; }
    .iti__arrow--up { border-bottom-color: #94a3b8 !important; }
    #vendor_phone { padding-left: 115px !important; }

    .iti__dropdown-content,
    .iti__country-list {
        background: #111620 !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        border-radius: 8px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
        color: #f8fafc !important;
        z-index: 99999 !important;
    }

    .iti__country {
        display: flex !important;
        align-items: center !important;
        padding: 8px 12px !important;
        gap: 8px !important;
        color: #f8fafc !important;
    }
    .iti__country:hover,
    .iti__country.iti__highlight {
        background: rgba(59, 130, 246, 0.2) !important;
    }
    .iti__country-name { display: none !important; }
    .iti__dial-code { font-weight: 600 !important; color: #52ead2 !important; }

    .iti__search-input {
        background: #0b0f17 !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #f8fafc !important;
        margin: 8px !important;
        padding: 8px 12px !important;
        border-radius: 6px !important;
        width: calc(100% - 16px) !important;
        outline: none !important;
    }
    .iti__search-input::placeholder { color: #64748b !important; }
    .iti__search-input:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25) !important;
    }

    /* ===== Light Mode Overrides ===== */
    body.light-mode .iti__selected-flag,
    body.light-mode .iti__selected-country { border-right: 1px solid #cbd5e1 !important; }
    body.light-mode .iti__selected-dial-code {
        color: #0f172a !important;
        -webkit-text-fill-color: #0f172a !important;
    }
    body.light-mode .iti__arrow { border-top-color: #475569 !important; }
    body.light-mode .iti__arrow--up { border-bottom-color: #475569 !important; }
    body.light-mode .iti__dropdown-content,
    body.light-mode .iti__country-list {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12) !important;
        color: #0f172a !important;
    }
    body.light-mode .iti__country { color: #0f172a !important; }
    body.light-mode .iti__country:hover,
    body.light-mode .iti__country.iti__highlight { background: rgba(15, 118, 110, 0.08) !important; }
    body.light-mode .iti__dial-code { color: #0f766e !important; }
    body.light-mode .iti__search-input {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #0f172a !important;
    }
    body.light-mode .iti__search-input::placeholder { color: #94a3b8 !important; }
    body.light-mode .iti__search-input:focus {
        border-color: #0f766e !important;
        box-shadow: 0 0 0 2px rgba(15, 118, 110, 0.2) !important;
    }
</style>
<script>
    $(document).ready(function() {
        if (typeof flatpickr !== 'undefined') {
            flatpickr("input[type='date']", {
                dateFormat: "Y-m-d",
                allowInput: true,
                disableMobile: "true"
            });
        }
    });

    function openAssignDriverModal() {
        $('#assignDriverModal').css('display', 'flex');
    }

    function closeAssignDriverModal() {
        $('#assignDriverModal').css('display', 'none');
    }

    function removeDriverAssignment() {
        Swal.fire({
            title: 'Remove Driver?',
            text: 'Are you sure you want to remove the driver assignment from this booking?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Yes, remove driver!'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('vendor.bookings.remove-driver', $booking->id) }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Removed!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(function() {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to remove driver.', 'error');
                        }
                    },
                    error: function(xhr) {
                        var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred while removing driver.';
                        Swal.fire('Error!', msg, 'error');
                    }
                });
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        if (typeof initializeIntlTelInput === 'function') {
            initializeIntlTelInput('vendor_phone', 'hidden_country_code', 'hidden_contact_number');
        }
    });

    // Assign Driver Form Submit Handler
    function submitAssignDriverForm() {
        var driverId = $('#assign_driver_id').val();
        if (!driverId) {
            Swal.fire('Error!', 'Please select a driver.', 'error');
            return;
        }
        $('#btnAssignDriverSubmit').prop('disabled', true);

        $.ajax({
            url: "{{ route('vendor.bookings.assign-driver', $booking->id) }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                driver_id: driverId
            },
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(data) {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message || 'Driver assigned successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message || 'Failed to assign driver.', 'error');
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred while assigning driver.';
                Swal.fire('Error!', msg, 'error');
            },
            complete: function() {
                $('#btnAssignDriverSubmit').prop('disabled', false);
            }
        });
    }

    $(document).on('submit', '#assignDriverForm', function(e) {
        e.preventDefault();
        submitAssignDriverForm();
    });
</script>
