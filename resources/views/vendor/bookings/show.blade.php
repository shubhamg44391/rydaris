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
        
        <div class="card mb-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <div class="card-header" style="background: rgba(11, 16, 32, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding: 15px 20px;">
                <h5 class="mb-0" style="color: #f8fafc; font-weight: 600; font-size: 1rem;">Passenger Information</h5>
            </div>
            <div class="card-body p-4">
                
                <style>
                    .dark-input {
                        background: rgba(11, 16, 32, 0.8) !important;
                        border: 1px solid rgba(255, 255, 255, 0.1) !important;
                        color: #f8fafc !important;
                        border-radius: 6px;
                    }
                    .dark-input:focus {
                        border-color: #3b82f6 !important;
                        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25) !important;
                    }
                    .dark-label {
                        color: #94a3b8;
                        font-size: 0.85rem;
                        font-weight: 600;
                        margin-bottom: 8px;
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
                        <input type="tel" name="customer_phone" id="vendor_phone" class="form-control dark-input" value="{{ old('customer_phone', $booking->customer_phone) }}" required style="width: 100%;">
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

        <div class="card mb-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <div class="card-header" style="background: rgba(11, 16, 32, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding: 15px 20px;">
                <h5 class="mb-0" style="color: #f8fafc; font-weight: 600; font-size: 1rem;">Trip & Booking Details</h5>
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
                        <input type="date" name="pickup_date" class="form-control dark-input" value="{{ old('pickup_date', $booking->pickup_date ? date('Y-m-d', strtotime($booking->pickup_date)) : '') }}" required>
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
                        <input type="date" name="return_date" class="form-control dark-input" value="{{ old('return_date', $booking->return_date ? date('Y-m-d', strtotime($booking->return_date)) : '') }}" required>
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

        <!-- Customer Verification Documents Card -->
        <div class="card mb-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <div class="card-header" style="background: rgba(11, 16, 32, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding: 15px 20px;">
                <h5 class="mb-0" style="color: #f8fafc; font-weight: 600; font-size: 1rem;">Customer Verification Documents</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Driver's License -->
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

                    <!-- Passport / ID Card -->
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

        <div class="card mb-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <div class="card-footer text-end" style="background: rgba(11, 16, 32, 0.8); border-top: 1px solid rgba(255, 255, 255, 0.05); padding: 15px 20px;">
                <button type="submit" class="btn btn-primary" style="background: #3b82f6; border-color: #3b82f6; font-weight: 500; padding: 8px 24px;">Update</button>
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
    #vendor_phone { padding-left: 115px !important; }
    .iti__search-input { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: #fff; margin-bottom: 8px; padding: 8px; border-radius: 4px; width: calc(100% - 16px); display: block; margin-left: auto; margin-right: auto; }
    
    /* Hide country name - show only flag and country dial code */
    .iti__country-name { display: none !important; }
    .iti__dial-code { margin-left: 8px; font-weight: 600; color: #fff; }
    .iti__country { display: flex; align-items: center; padding: 8px 12px; gap: 4px; }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const phoneInputField = document.getElementById('vendor_phone');
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
            const form = document.getElementById('vendorBookingForm');
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
