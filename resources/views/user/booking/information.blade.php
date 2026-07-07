@extends('user.layouts.app')

@section('main-content')
<div class="booking-coverage-page" style="padding: 30px; min-height: 100vh;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto;">
        
        <!-- Top Stepper -->
        <div class="stepper-wrapper mb-5" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 25px; display: flex; justify-content: space-between; align-items: center; max-width: 800px; margin: 0 auto 40px;">
            <!-- Step 1 -->
            <div class="step text-center">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: rgba(82, 234, 210, 0.1); border: 1px solid var(--brand); color: var(--brand); display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 700;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <span style="font-size: 0.75rem; color: var(--brand); font-weight: 600;">Search</span>
            </div>
            <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); margin: -20px 15px 0;"></div>
            <!-- Step 2 -->
            <div class="step text-center">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: rgba(82, 234, 210, 0.1); border: 1px solid var(--brand); color: var(--brand); display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 700;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <span style="font-size: 0.75rem; color: var(--brand); font-weight: 600;">Car Listing</span>
            </div>
            <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); margin: -20px 15px 0;"></div>
            <!-- Step 3 -->
            <div class="step text-center">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: rgba(82, 234, 210, 0.1); border: 1px solid var(--brand); color: var(--brand); display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 700;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <span style="font-size: 0.75rem; color: var(--brand); font-weight: 600;">Coverage</span>
            </div>
            <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); margin: -20px 15px 0;"></div>
            <!-- Step 4 (Active) -->
            <div class="step text-center" id="stepper-step-4">
                <div class="stepper-circle" style="width: 35px; height: 35px; border-radius: 50%; background: var(--brand); color: #0b1020; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.3);">
                    4
                </div>
                <span class="stepper-text" style="font-size: 0.75rem; color: var(--brand); font-weight: 800;">Information</span>
            </div>
            <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); margin: -20px 15px 0;"></div>
            <!-- Step 5 (Upcoming) -->
            <div class="step text-center" id="stepper-step-5">
                <div class="stepper-circle" style="width: 35px; height: 35px; border-radius: 50%; background: transparent; border: 1px solid rgba(255, 255, 255, 0.2); color: #94a3b8; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 700; transition: all 0.3s;">
                    5
                </div>
                <span class="stepper-text" style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; transition: all 0.3s;">Payment</span>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- Left Column: Coverage & Extras -->
            <div class="col-lg-8">
                
                <!-- Coverage Packages -->
                <!-- STEP 4 CONTENT (Personal Info) -->
                <div id="step-4-content">
                    <!-- Personal Information Form -->
                    <div class="card mb-5" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px;">
                        <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                            <h4 style="color: #f8fafc; font-weight: 800; font-size: 1.25rem;">Personal Information</h4>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label style="display: block; margin-bottom: 8px; color: #94a3b8; font-size: 0.85rem; font-weight: 600;">First Name *</label>
                                    <input type="text" id="first_name" class="form-control" placeholder="John" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff; padding: 12px 15px; border-radius: 8px;" required>
                                </div>
                                <div class="col-md-6">
                                    <label style="display: block; margin-bottom: 8px; color: #94a3b8; font-size: 0.85rem; font-weight: 600;">Last Name *</label>
                                    <input type="text" id="last_name" class="form-control" placeholder="Doe" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff; padding: 12px 15px; border-radius: 8px;" required>
                                </div>
                                <div class="col-md-6">
                                    <label style="display: block; margin-bottom: 8px; color: #94a3b8; font-size: 0.85rem; font-weight: 600;">Email *</label>
                                    <input type="email" id="email" class="form-control" placeholder="john.doe@example.com" oncopy="return false" onpaste="return false" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff; padding: 12px 15px; border-radius: 8px;" required>
                                </div>
                                <div class="col-md-6">
                                    <label style="display: block; margin-bottom: 8px; color: #94a3b8; font-size: 0.85rem; font-weight: 600;">Confirm Email *</label>
                                    <input type="email" id="confirm_email" class="form-control" placeholder="john.doe@example.com" oncopy="return false" onpaste="return false" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff; padding: 12px 15px; border-radius: 8px;" required>
                                </div>
                                <div class="col-md-6">
                                    <label style="display: block; margin-bottom: 8px; color: #94a3b8; font-size: 0.85rem; font-weight: 600;">Phone Number *</label>
                                    <input type="tel" id="phone" name="phone" class="form-control w-100" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff; padding: 12px 15px 12px 50px; border-radius: 8px;" required>
                                </div>
                                <div class="col-md-6">
                                    <label style="display: block; margin-bottom: 8px; color: #94a3b8; font-size: 0.85rem; font-weight: 600;">Date of Birth *</label>
                                    <input type="text" id="dob" class="form-control" placeholder="Select Date" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #94a3b8; padding: 12px 15px; border-radius: 8px;" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Flight Information Form -->
                    <div class="card" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden;">
                        <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                            <h4 style="color: #f8fafc; font-weight: 800; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 0.5px;">Flight Information (Optional)</h4>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="mb-4">
                                <label style="display: block; margin-bottom: 8px; color: #94a3b8; font-size: 0.85rem; font-weight: 600;">Flight Number</label>
                                <input type="text" id="flight_number" class="form-control" placeholder="e.g., AA123" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff; padding: 12px 15px; border-radius: 8px;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 8px; color: #94a3b8; font-size: 0.85rem; font-weight: 600;">Special Comments</label>
                                <textarea id="special_comments" class="form-control" rows="4" placeholder="Any special requests or instructions..." style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff; padding: 12px 15px; border-radius: 8px;"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bottom Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-5 mb-5">
                        <a href="javascript:history.back()" class="btn btn-outline-light px-5 py-3" style="border-radius: 8px; font-weight: 700; border-color: rgba(255,255,255,0.2);">Back</a>
                        <button type="button" onclick="validateAndSubmit()" class="btn px-5 py-3" style="background: var(--brand); color: #0b1020; border-radius: 8px; font-weight: 800; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.3);">Continue to Checkout</button>
                    </div>
                </div>

            </div>

            <!-- Right Column: Summary Sidebar -->
            <div class="col-lg-4" id="sidebar-summary-box">
                <div class="summary-sidebar sticky-top" style="top: 20px;">
                    <div class="card" style="background: rgba(16, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                        
                        <!-- Image -->
                        <div style="background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 70%); height: 160px; display: flex; align-items: center; justify-content: center; padding: 20px;">
                            @if($vehicle->image)
                                <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.5));">
                            @endif
                        </div>
                        
                        <!-- Vehicle Name -->
                        <div class="p-4 pb-0">
                            <h3 style="font-weight: 800; color: #ffffff; font-size: 1.4rem;">{{ $vehicle->name }}</h3>
                        </div>

                        <!-- Pick-up / Return Details -->
                        <div class="p-4">
                            <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 8px; padding: 15px; margin-bottom: 25px;">
                                <div class="mb-3">
                                    <h6 style="color: #f8fafc; font-size: 0.8rem; font-weight: 700; margin-bottom: 5px;">Pick up</h6>
                                    <div class="d-flex justify-content-between align-items-start">
                                        <span style="color: #94a3b8; font-size: 0.75rem; max-width: 65%;">{{ $pickupLocation ? $pickupLocation->location : 'Selected Location' }}</span>
                                        <span style="color: #cbd5e1; font-size: 0.75rem; text-align: right; font-weight: 600;">{{ $pickupDate ?? 'Today' }}<br>{{ $pickupTime }} Hrs</span>
                                    </div>
                                </div>
                                <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 10px 0;"></div>
                                <div>
                                    <h6 style="color: #f8fafc; font-size: 0.8rem; font-weight: 700; margin-bottom: 5px;">Return</h6>
                                    <div class="d-flex justify-content-between align-items-start">
                                        <span style="color: #94a3b8; font-size: 0.75rem; max-width: 65%;">{{ $returnLocation ? $returnLocation->location : 'Selected Location' }}</span>
                                        <span style="color: #cbd5e1; font-size: 0.75rem; text-align: right; font-weight: 600;">{{ $returnDate ?? '+2 Days' }}<br>{{ $returnTime }} Hrs</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Cost Breakdown -->
                            <div class="cost-breakdown">
                                <h6 style="color: #f8fafc; font-size: 0.9rem; font-weight: 700; margin-bottom: 15px; margin-top: 10px;">Selected Options</h6>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #94a3b8; font-size: 0.8rem;">Insurance ({{ $selectedInsurance ? $selectedInsurance->name : 'None' }})</span>
                                    <span style="color: #f8fafc; font-weight: 600; font-size: 0.85rem;">${{ number_format($insuranceTotal, 2) }}</span>
                                </div>
                                
                                @if($selectedExtras->count() > 0)
                                    @foreach($selectedExtras as $extra)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span style="color: #94a3b8; font-size: 0.8rem;">{{ $extra->name }} (x{{ $extra->qty }})</span>
                                            <span style="color: #f8fafc; font-weight: 600; font-size: 0.85rem;">${{ number_format($extra->price * $extra->qty * $rentalDays, 2) }}</span>
                                        </div>
                                    @endforeach
                                @endif
                                
                                <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 15px 0;"></div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #94a3b8; font-size: 0.8rem;">Rental Price ({{ $rentalDays }} Days)</span>
                                    <span style="color: #f8fafc; font-weight: 600; font-size: 0.85rem;">${{ number_format($vehicle->total_price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #94a3b8; font-size: 0.8rem; max-width: 75%;">Pickup Location Fee</span>
                                    <span style="color: #f8fafc; font-weight: 600; font-size: 0.85rem;">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-4">
                                    <span style="color: #94a3b8; font-size: 0.8rem; max-width: 75%;">Return Location Fee</span>
                                    <span style="color: #f8fafc; font-weight: 600; font-size: 0.85rem;">$0.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Grand Total -->
                        <div class="p-4" style="background: rgba(82, 234, 210, 0.05); border-top: 1px solid rgba(82, 234, 210, 0.15); display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #f8fafc; font-weight: 800; font-size: 1.1rem;">Total Amount</span>
                            <span style="color: #ef4444; font-weight: 900; font-size: 1.4rem;">${{ number_format($grandTotal, 2) }}</span>
                        </div>
                        
                        <!-- Breakdown Additions (Visible Only in Step 5) -->
                        <div id="step-5-summary-additions" style="display: none; background: rgba(82, 234, 210, 0.02); padding: 15px 24px; border-top: 1px dashed rgba(255,255,255,0.1);">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="color: #94a3b8; font-size: 0.9rem; font-weight: 600;">Paid Now (5%)</span>
                                <span style="color: #52ead2; font-weight: 800; font-size: 1rem;">${{ number_format($grandTotal * 0.05, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #94a3b8; font-size: 0.9rem; font-weight: 600;">Pending on Arrival</span>
                                <span style="color: #ef4444; font-weight: 800; font-size: 1rem;">${{ number_format($grandTotal * 0.95, 2) }}</span>
                            </div>
                        </div>

                        <!-- Apply Coupon (Hidden in Step 5) -->
                        <div id="coupon-box" class="p-4 border-top" style="border-color: rgba(255,255,255,0.05) !important;">
                            <label style="color: #f8fafc; font-size: 0.85rem; font-weight: 700; margin-bottom: 8px; display: block;">Apply Coupon</label>
                            <select class="form-select border-0" style="background: rgba(255,255,255,0.05); color: #fff; padding: 10px 15px;">
                                <option value="" style="background: #0f172a;">Select a coupon</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<!-- Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- html2pdf -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    .iti { width: 100%; display: block; }
    .iti__country-list { background: rgba(11, 16, 32, 0.95); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 8px; }
    .iti__country-list .iti__country:hover, .iti__country-list .iti__country.iti__highlight { background: rgba(82, 234, 210, 0.2); }
    .iti__selected-flag { background: transparent !important; padding: 0 12px; border-right: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; }
    .iti__arrow { border-top-color: #fff !important; }
    .iti__arrow--up { border-bottom-color: #fff !important; }
    .iti__selected-dial-code { color: #fff !important; margin-left: 6px; }
    #phone { padding-left: 90px !important; }
    
    /* Flatpickr override for our exact colors */
    .flatpickr-calendar { background: rgba(11, 16, 32, 0.95) !important; border: 1px solid rgba(255,255,255,0.1) !important; box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important; color: #fff !important; padding-top: 10px !important; }
    .flatpickr-calendar.arrowTop:before { border-bottom-color: rgba(255,255,255,0.1) !important; }
    .flatpickr-calendar.arrowTop:after { border-bottom-color: rgba(11, 16, 32, 0.95) !important; }
    .flatpickr-day { color: #e2e8f0 !important; }
    .flatpickr-day:hover { background: rgba(82, 234, 210, 0.2) !important; border-color: transparent !important; }
    .flatpickr-day.selected { background: var(--brand) !important; border-color: var(--brand) !important; color: #0b1020 !important; font-weight: bold; }
    .flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover { color: rgba(255,255,255,0.2) !important; background: transparent !important; }
    .flatpickr-months { height: 45px !important; overflow: visible !important; display: flex !important; align-items: center !important; }
    .flatpickr-month, .flatpickr-current-month { color: #fff !important; fill: #fff !important; height: 100% !important; padding-top: 0 !important; display: flex !important; align-items: center !important; justify-content: center !important; }
    .flatpickr-current-month input.cur-year { font-weight: 700 !important; color: #fff !important; line-height: 1 !important; height: auto !important; padding: 0 !important; margin: 0 !important; }
    .flatpickr-current-month .flatpickr-monthDropdown-months { appearance: menulist !important; background: rgba(11, 16, 32, 0.95) !important; color: #fff !important; padding: 0 !important; height: auto !important; line-height: 1 !important; margin: 0 !important; border: none !important; }
    .flatpickr-weekday { color: var(--brand) !important; font-weight: 700 !important; }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Init Phone Input
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            preferredCountries: ["us", "gb", "in", "ae", "sa", "au"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
            separateDialCode: true,
            formatOnDisplay: true
        });

        // Init Flatpickr for DOB
        const date21YearsAgo = "{{ date('Y-m-d', strtotime('-21 years')) }}";
        const fp = flatpickr("#dob", {
            maxDate: date21YearsAgo,
            defaultDate: date21YearsAgo,
            dateFormat: "Y-m-d",
            disableMobile: "true",
            onChange: function(selectedDates, dateStr, instance) {
                sessionStorage.setItem('paymentInfo_dob', dateStr);
            }
        });

        // Restore fields from sessionStorage
        const fields = ['first_name', 'last_name', 'email', 'confirm_email', 'phone', 'dob', 'flight_number', 'special_comments'];
        fields.forEach(field => {
            const el = document.getElementById(field);
            if(el) {
                const storedVal = sessionStorage.getItem('paymentInfo_' + field);
                if(storedVal) {
                    el.value = storedVal;
                    if(field === 'dob') {
                        fp.setDate(storedVal);
                    }
                }
                
                // Save on change
                el.addEventListener('input', function() {
                    sessionStorage.setItem('paymentInfo_' + field, this.value);
                });
            }
        });
    });

    function validateAndSubmit() {
        const email = document.getElementById('email').value;
        const confirmEmail = document.getElementById('confirm_email').value;
        const phone = document.getElementById('phone').value;
        const dob = document.getElementById('dob').value;

        if (!email || !confirmEmail || !phone || !dob) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Fields',
                text: 'Please fill out all required Personal Information fields.',
                background: 'rgba(11, 16, 32, 0.95)'
            });
            return;
        }

        if (email !== confirmEmail) {
            Swal.fire({
                icon: 'error',
                title: 'Email Mismatch',
                text: 'Email and Confirm Email do not match!',
                background: 'rgba(11, 16, 32, 0.95)'
            });
            return;
        }

        const fname = document.getElementById('first_name').value || '';
        const lname = document.getElementById('last_name').value || '';
        const flight_number = document.getElementById('flight_number') ? document.getElementById('flight_number').value : '';
        const special_comments = document.getElementById('special_comments') ? document.getElementById('special_comments').value : '';

        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('fname', fname);
        urlParams.set('lname', lname);
        urlParams.set('email', email);
        urlParams.set('phone', phone);
        urlParams.set('dob', dob);
        urlParams.set('flight_number', flight_number);
        urlParams.set('special_comments', special_comments);
        
        window.location.href = `{{ url('/user/book') }}/{{ $vehicle->id }}/payment?` + urlParams.toString();
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media print {
        body * { visibility: hidden; }
        .print-container, .print-container * { visibility: visible; }
        .print-container { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 20px; }
        .no-print { display: none !important; }
        .stepper-wrapper { display: none !important; }
        /* Make sure dark theme colors print accurately */
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
</style>
@endsection
