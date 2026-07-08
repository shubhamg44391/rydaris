@extends('user.layouts.app')

@section('title', 'Online Check-In')

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
    .dark-input:focus {
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: #52ead2 !important;
        box-shadow: 0 0 0 2px rgba(82, 234, 210, 0.2) !important;
        color: #ffffff !important;
    }
    .dark-label {
        color: #94a3b8 !important;
        font-weight: 500;
        margin-bottom: 6px;
        font-size: 0.9rem;
    }
    .section-heading {
        color: #f8fafc;
        font-weight: 700;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding-bottom: 12px;
        margin-bottom: 20px;
        font-size: 1.15rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-heading svg {
        color: #52ead2;
    }
    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed rgba(255, 255, 255, 0.05);
        font-size: 0.9rem;
        color: #94a3b8;
    }
    .price-row.total {
        border-bottom: none;
        font-size: 1.1rem;
        font-weight: 700;
        color: #f8fafc;
        padding-top: 15px;
    }
    .btn-teal {
        background: linear-gradient(135deg, #52ead2, #2bc2a8) !important;
        color: #050711 !important;
        font-weight: 600 !important;
        border: none !important;
        box-shadow: 0 8px 20px rgba(82, 234, 210, 0.2) !important;
        transition: all 0.3s ease !important;
        padding: 10px 24px;
        border-radius: 6px;
    }
    .btn-teal:hover {
        box-shadow: 0 8px 25px rgba(82, 234, 210, 0.4) !important;
        transform: translateY(-1px);
    }
    .checkbox-container {
        display: flex;
        align-items: center;
        cursor: pointer;
        position: relative;
    }
    .checkbox-container input[type="checkbox"] {
        opacity: 0;
        position: absolute;
        width: 0;
        height: 0;
    }
    .checkbox-custom {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 2px solid #52ead2;
        border-radius: 3px;
        position: relative;
        margin-right: 10px;
        transition: all 0.2s ease;
    }
    .checkbox-container input[type="checkbox"]:checked + .checkbox-custom {
        background-color: #52ead2;
    }
    .checkbox-container input[type="checkbox"]:checked + .checkbox-custom::after {
        content: "\f00c";
        font-family: "Font Awesome 6 Free", "Font Awesome 5 Free";
        font-weight: 900;
        color: #050711;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 10px;
    }
    /* Dashed upload boxes */
    .upload-box {
        border: 2px dashed rgba(82, 234, 210, 0.3);
        border-radius: 8px;
        padding: 24px;
        text-align: center;
        background: rgba(82, 234, 210, 0.02);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .upload-box:hover {
        border-color: #52ead2;
        background: rgba(82, 234, 210, 0.05);
    }
    /* Scrollbar style */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scroll::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.01);
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.1);
        border-radius: 3px;
    }
</style>

<div class="container-fluid p-4" style="min-width: 0; max-width: 100%; overflow-x: hidden;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: #f8fafc; font-weight: 700;">Online Check-In</h4>
            <div class="d-flex align-items-center gap-3 flex-wrap mt-1" style="gap: 10px;">
                <span style="color: #94a3b8; font-size: 0.9rem;">
                    Ref: <strong style="color: #52ead2;">{{ $booking->reservation_number }}</strong>
                </span>
                
                @if($booking->checkin_status)
                    <span style="background: rgba(34,197,94,0.15); border: 1px solid #22c55e; color: #22c55e; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                        ● Check-In Completed
                    </span>
                @else
                    <span style="background: rgba(251,191,36,0.15); border: 1px solid #fbbf24; color: #fbbf24; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                        ● Check-In Pending
                    </span>
                @endif
            </div>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary" style="background: rgba(255,255,255,0.1); border: none; color: #f8fafc;">
            <i class="fa fa-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.2); color: #4ade80; border-radius: 8px; margin-bottom: 20px;">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; border-radius: 8px; margin-bottom: 20px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($booking->checkin_status)
        <!-- Check-in Completed Success Splash -->
        <div class="dark-card p-5 text-center" style="border-color: rgba(34, 197, 94, 0.3) !important;">
            <div style="background: rgba(34, 197, 94, 0.1); width: 64px; height: 64px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#22c55e" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <h5 style="color: #f8fafc; font-weight: 700; font-size: 1.25rem;">Check-In Successful!</h5>
            <p style="color: #94a3b8; font-size: 0.95rem; margin-top: 8px; max-width: 500px; margin-left: auto; margin-right: auto;">Your online check-in is complete. We have verified your driver's license and travel details. Your car will be ready for pickup when you arrive.</p>
        </div>
    @endif

    <form action="{{ route('user.bookings.checkin.submit', $booking->id) }}" method="POST" enctype="multipart/form-data" id="checkinForm">
        @csrf

        <div class="row">
            <!-- Left Column: Form Details -->
            <div class="col-lg-8">
                <!-- Vehicle Details Summary -->
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="10" rx="2"></rect><circle cx="7" cy="21" r="2"></circle><circle cx="17" cy="21" r="2"></circle><path d="M14 11V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v4"></path></svg>
                        Trip Information
                    </h5>
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            @if($booking->vehicle && $booking->vehicle->image)
                                <img src="{{ asset('storage/' . $booking->vehicle->image) }}" alt="{{ $booking->vehicle->name }}" style="max-height: 110px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.5));">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h6 style="color: #f8fafc; font-weight: 700; font-size: 1.1rem; margin-bottom: 8px;">{{ $booking->vehicle->name ?? 'N/A' }}</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Pick Up</span>
                                    <p style="margin: 0; font-size: 0.85rem; color: #cbd5e1; font-weight: 600;">{{ $booking->pickupLocation->location ?? 'N/A' }}</p>
                                    <p style="margin: 0; font-size: 0.8rem; color: #94a3b8;">{{ date('d/m/Y', strtotime($booking->pickup_date)) }} at {{ date('H:i', strtotime($booking->pickup_time)) }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span style="font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 700;">Drop Off</span>
                                    <p style="margin: 0; font-size: 0.85rem; color: #cbd5e1; font-weight: 600;">{{ $booking->returnLocation->location ?? 'N/A' }}</p>
                                    <p style="margin: 0; font-size: 0.8rem; color: #94a3b8;">{{ date('d/m/Y', strtotime($booking->return_date)) }} at {{ date('H:i', strtotime($booking->return_time)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Verification Card -->
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Document Verification
                    </h5>

                    <div class="row g-4">
                        <!-- Driver's License Upload -->
                        <div class="col-md-6">
                            <h6 style="color: #cbd5e1; font-weight: 600; margin-bottom: 12px;">Driver's License</h6>
                            
                            <div class="upload-box mb-3" onclick="document.getElementById('license_file').click()">
                                <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#52ead2" stroke-width="2" style="margin: 0 auto 10px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <p style="font-size: 0.85rem; color: #cbd5e1; margin-bottom: 4px;">Upload License Front & Back</p>
                                <span style="font-size: 0.75rem; color: #64748b;">JPG, PNG or PDF (max 5MB)</span>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-secondary btn-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1;">
                                        {{ $booking->license_image ? 'Change File' : 'Select File' }}
                                    </button>
                                </div>
                            </div>
                            <input type="file" name="license_image" id="license_file" accept=".jpg,.jpeg,.png,.pdf" class="d-none">

                            @if($booking->license_image)
                                <div class="p-3 bg-green-950/20 border border-green-500/20 rounded-lg mb-3 d-flex justify-content-between align-items-center">
                                    <div class="truncate me-2">
                                        <span class="d-block" style="font-size: 0.75rem; color: #22c55e; font-weight: 600;">Uploaded License</span>
                                        <span style="font-size: 0.7rem; color: #94a3b8;" class="truncate d-block">{{ basename($booking->license_image) }}</span>
                                    </div>
                                    <a href="{{ asset('storage/' . $booking->license_image) }}" target="_blank" class="btn btn-sm btn-teal" style="padding: 4px 10px; font-size: 0.75rem;">
                                        View
                                    </a>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="dark-label">License Number *</label>
                                <input type="text" name="license_number" class="form-control dark-input" value="{{ old('license_number', $booking->license_number) }}" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label class="dark-label">Issue Date *</label>
                                    <input type="date" name="license_issue_date" class="form-control dark-input" value="{{ old('license_issue_date', $booking->license_issue_date) }}" required>
                                </div>
                                <div class="col-6">
                                    <label class="dark-label">Expiry Date *</label>
                                    <input type="date" name="license_expiry_date" class="form-control dark-input" value="{{ old('license_expiry_date', $booking->license_expiry_date) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Passport/ID Upload -->
                        <div class="col-md-6">
                            <h6 style="color: #cbd5e1; font-weight: 600; margin-bottom: 12px;">Passport or ID Card</h6>

                            <div class="upload-box mb-3" onclick="document.getElementById('passport_file').click()">
                                <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#52ead2" stroke-width="2" style="margin: 0 auto 10px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <p style="font-size: 0.85rem; color: #cbd5e1; margin-bottom: 4px;">Upload Passport photo page</p>
                                <span style="font-size: 0.75rem; color: #64748b;">JPG, PNG or PDF (max 5MB)</span>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-secondary btn-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1;">
                                        {{ $booking->passport_image ? 'Change File' : 'Select File' }}
                                    </button>
                                </div>
                            </div>
                            <input type="file" name="passport_image" id="passport_file" accept=".jpg,.jpeg,.png,.pdf" class="d-none">

                            @if($booking->passport_image)
                                <div class="p-3 bg-green-950/20 border border-green-500/20 rounded-lg mb-3 d-flex justify-content-between align-items-center">
                                    <div class="truncate me-2">
                                        <span class="d-block" style="font-size: 0.75rem; color: #22c55e; font-weight: 600;">Uploaded Passport</span>
                                        <span style="font-size: 0.7rem; color: #94a3b8;" class="truncate d-block">{{ basename($booking->passport_image) }}</span>
                                    </div>
                                    <a href="{{ asset('storage/' . $booking->passport_image) }}" target="_blank" class="btn btn-sm btn-teal" style="padding: 4px 10px; font-size: 0.75rem;">
                                        View
                                    </a>
                                </div>
                            @endif

                            <div>
                                <label class="dark-label">Passport / ID Number *</label>
                                <input type="text" name="pass_number" class="form-control dark-input" value="{{ old('pass_number', $booking->pass_number) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flight Information -->
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        Flight Information
                    </h5>
                    <div class="mb-3">
                        <label class="dark-label">Arrival Flight Number (Optional)</label>
                        <input type="text" name="flight_number" class="form-control dark-input" placeholder="e.g. RJ507" value="{{ old('flight_number', $booking->flight_number) }}">
                        <p style="font-size: 0.75rem; color: #64748b; margin-top: 6px; font-style: italic;">
                            <i class="fa fa-info-circle me-1"></i> We monitor arrivals to ensure your vehicle is ready if your flight is delayed.
                        </p>
                    </div>
                </div>

                <!-- Terms and conditions -->
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Terms & Conditions
                    </h5>
                    <div class="custom-scroll mb-4 p-3" style="max-height: 150px; overflow-y: auto; background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); border-radius: 6px; font-size: 0.85rem; color: #cbd5e1; line-height: 1.6;">
                        <p class="mb-2">By checking in online, you agree to the following terms:</p>
                        <ul class="ps-3 mb-0" style="list-style-type: disc;">
                            <li>You must present the original driver's license and ID card / Passport at pickup.</li>
                            <li>The driver must be at least 21 years old and hold a valid license for at least 1 year.</li>
                            <li>A refundable security deposit will be held upon delivery.</li>
                            <li>Fuel Policy: Full to Full. The vehicle is provided with a full tank and must be returned full.</li>
                            <li>Late returns may incur additional charges.</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <label class="checkbox-container">
                            <input type="checkbox" name="terms_agreed" value="1" required>
                            <span class="checkbox-custom"></span>
                            <span style="font-size: 0.9rem; color: #cbd5e1;">I have read and agree to the terms and conditions</span>
                        </label>
                    </div>

                    @if(!$booking->checkin_status)
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-teal">
                                Submit Check-In <i class="fa fa-check ms-1"></i>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Booking Summary -->
            <div class="col-lg-4">
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        Booking Summary
                    </h5>
                    
                    @php
                        $diff = \Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->return_date));
                        $rentalDays = $diff > 0 ? $diff : 1;
                        $carAmount = ($booking->vehicle->price_per_day ?? 0) * $rentalDays;
                    @endphp

                    <div class="price-row">
                        <span>Vehicle Rental ({{ $rentalDays }} Days)</span>
                        <span>${{ number_format($carAmount, 2) }}</span>
                    </div>

                    @if($booking->extras && count($booking->extras) > 0)
                        @foreach($booking->extras as $bExtra)
                            @if($bExtra->vendorExtra)
                                <div class="price-row">
                                    <span>{{ $bExtra->vendorExtra->name }} (Qty: {{ $bExtra->qty }})</span>
                                    @php
                                        $ePrice = $bExtra->price * $bExtra->qty;
                                        if($bExtra->vendorExtra->price_type == 1) {
                                            $ePrice *= $rentalDays;
                                        }
                                    @endphp
                                    <span>${{ number_format($ePrice, 2) }}</span>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    <div class="price-row">
                        <span>Payment Method</span>
                        <span style="text-transform: capitalize;">{{ str_replace('_', ' ', $booking->payment_method) }}</span>
                    </div>

                    <div class="price-row">
                        <span>Paid Amount</span>
                        <span style="color: #52ead2;">${{ number_format($booking->paid_amount, 2) }}</span>
                    </div>

                    <div class="price-row">
                        <span>Pending Amount</span>
                        <span style="color: #f87171;">${{ number_format($booking->pending_amount, 2) }}</span>
                    </div>

                    <div class="price-row total">
                        <span>Total Amount</span>
                        <span>${{ number_format($booking->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Automatically trigger file select when upload triggers are clicked
        const fileInputs = ['license_file', 'passport_file'];
        fileInputs.forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        // Change parent box content or alert
                        const nameSpan = this.parentElement.querySelector('.upload-box p');
                        if (nameSpan) {
                            nameSpan.textContent = `Selected: ${this.files[0].name}`;
                            nameSpan.style.color = '#52ead2';
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
