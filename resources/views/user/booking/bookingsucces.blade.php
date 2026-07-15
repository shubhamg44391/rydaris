@extends('user.layouts.app')

@section('main-content')
<div class="booking-coverage-page" style="padding: 30px; min-height: 100vh;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto;">
        
        <div id="step-confirmed-content" class="print-container" style="animation: fadeIn 0.4s ease forwards; width: 100%;">
            <div class="mb-5 d-flex flex-column align-items-center text-center" style="width: 100%;">
                <div class="success-animation" style="margin-bottom: 20px;">
                    <div class="checkmark-pulse-bg">
                        <svg class="checkmark-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                            <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                        </svg>
                    </div>
                </div>
                <h2 class="print-text-dark animate-fade-in-up delay-1" style="color: #f8fafc; font-weight: 800; font-size: 2.2rem; margin-bottom: 15px; width: 100%; text-align: center;">Booking Confirmed!</h2>
                <p class="print-text-dark animate-fade-in-up delay-2" style="color: #94a3b8; font-size: 1.1rem; max-width: 600px; width: 100%; text-align: center;">
                    Hi <span style="color: #fff; font-weight: 600;">{{ request()->input('fname', 'Customer') }}</span>, we've received your booking <strong class="text-brand" style="color: var(--brand);">#<span id="order-number-val">{{ request()->input('reservation_number', 'DCR' . rand(10000, 99999)) }}</span></strong> and have sent a confirmation email to <span style="color: #fff; font-weight: 600;">{{ request()->input('email', '') }}</span>.
                </p>
            </div>

            <div class="row g-4 animate-fade-in-up delay-3">
                <!-- Left Details Column -->
                <div class="col-lg-8">
                    
                    <!-- Rental Period -->
                    <div class="card mb-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden;">
                        <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                            <h4 style="color: #f8fafc; font-weight: 700; font-size: 1.1rem;">Rental Period</h4>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="d-flex gap-3">
                                        <div class="pickup-icon-box" style="color: var(--brand); background: rgba(82,234,210,0.1); padding: 10px; border-radius: 8px; height: fit-content;">
                                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        </div>
                                        <div>
                                            <h6 style="color: #f8fafc; font-weight: 700; font-size: 0.95rem; margin-bottom: 5px;">Pickup</h6>
                                            <div style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 3px;">{{ $pickupDate ?? 'Today' }} at {{ $pickupTime }} Hrs</div>
                                            <div style="color: #cbd5e1; font-size: 0.85rem;">{{ $pickupLocation ? $pickupLocation->location : 'Selected Location' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex gap-3">
                                        <div class="return-icon-box" style="color: #00a4e4; background: rgba(0,164,228,0.1); padding: 10px; border-radius: 8px; height: fit-content;">
                                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        </div>
                                        <div>
                                            <h6 style="color: #f8fafc; font-weight: 700; font-size: 0.95rem; margin-bottom: 5px;">Return</h6>
                                            <div style="color: #94a3b8; font-size: 0.85rem; margin-bottom: 3px;">{{ $returnDate ?? '+2 Days' }} at {{ $returnTime }} Hrs</div>
                                            <div style="color: #cbd5e1; font-size: 0.85rem;">{{ $returnLocation ? $returnLocation->location : 'Selected Location' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle & Extras -->
                    <div class="row mb-4 g-4">
                        <div class="col-md-12">
                            @php
                                $imageBase64 = null;
                                if ($vehicle->image) {
                                    $imagePath = storage_path('app/public/' . $vehicle->image);
                                    if (file_exists($imagePath)) {
                                        $imageData = base64_encode(file_get_contents($imagePath));
                                        $mimeType = mime_content_type($imagePath);
                                        $imageBase64 = 'data:' . $mimeType . ';base64,' . $imageData;
                                    }
                                }
                            @endphp
                            <div class="card h-100" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden;">
                                <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                                    <h4 style="color: #f8fafc; font-weight: 700; font-size: 1.1rem;">Vehicle Information</h4>
                                </div>
                                <div class="card-body p-4 pt-2 d-flex align-items-center gap-4">
                                    @if($imageBase64)
                                        <img src="{{ $imageBase64 }}" alt="{{ $vehicle->name }}" style="width: 120px; height: auto; object-fit: contain; display: block;">
                                    @elseif($vehicle->image)
                                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" style="width: 120px; height: auto; object-fit: contain; display: block;">
                                    @endif
                                    <div>
                                        <h5 style="color: #fff; font-weight: 800; margin-bottom: 5px;">{{ $vehicle->name }}</h5>
                                        <div style="color: #94a3b8; font-size: 0.85rem;">{{ $rentalDays }} Days rental</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Info -->
                    <div class="card mb-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden;">
                        <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                            <h4 style="color: #f8fafc; font-weight: 700; font-size: 1.1rem;">Personal Information</h4>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="row g-3">
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">First Name:</span>
                                    <strong style="color: #fff; font-size: 0.9rem;">{{ request()->input('fname', '') }}</strong>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">Phone:</span>
                                    <strong style="color: #fff; font-size: 0.9rem;">{{ request()->input('phone', '') }}</strong>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">Last Name:</span>
                                    <strong style="color: #fff; font-size: 0.9rem;">{{ request()->input('lname', '') }}</strong>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">DOB:</span>
                                    <strong style="color: #fff; font-size: 0.9rem;">{{ request()->input('dob', '') }}</strong>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">Email:</span>
                                    <strong style="color: #fff; font-size: 0.9rem;">{{ request()->input('email', '') }}</strong>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-between">
                                    <span style="color: #94a3b8; font-size: 0.9rem;">Payment Method:</span>
                                    <strong style="color: var(--brand); font-size: 0.9rem; text-transform: capitalize;">{{ str_replace('_', ' ', request()->input('payment_method', '')) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Actions Column -->
                <div class="col-lg-4">
                    
                    <!-- Actions -->
                    <div class="card mb-4 no-print" style="background: rgba(16, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; overflow: hidden;">
                        <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                            <h4 style="color: #f8fafc; font-weight: 700; font-size: 1.1rem;">Booking Actions</h4>
                        </div>
                        <div class="card-body p-4 pt-2 d-flex flex-column gap-3">
                            <button onclick="window.print()" class="btn btn-teal w-100 d-flex align-items-center justify-content-center gap-2" style="padding: 12px; border-radius: 8px;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                Print Confirmation
                            </button>
                            <button onclick="downloadPDF()" class="btn w-100 d-flex align-items-center justify-content-center gap-2" style="background: rgba(255,255,255,0.05); color: #fff; font-weight: 700; padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                Download PDF
                            </button>
                            <a href="{{ url('/') }}" class="btn btn-blue w-100 d-flex align-items-center justify-content-center gap-2" style="padding: 12px; border-radius: 8px; text-decoration: none;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                Return Home
                            </a>
                        </div>
                    </div>
                    
                    <!-- Needs Help? -->
                    <div class="card no-print" style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.15); border-radius: 12px; overflow: hidden;">
                        <div class="card-body p-4">
                            <h4 style="color: #60a5fa; font-weight: 700; font-size: 1.1rem; margin-bottom: 15px;">Need Help?</h4>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#ef4444" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                <span style="color: #94a3b8; font-size: 0.85rem;">Call: {{ $vehicle->vendor->country_code ?  $vehicle->vendor->country_code . ' ' : '' }}{{ $vehicle->vendor->contact_number ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#60a5fa" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <span style="color: #94a3b8; font-size: 0.85rem;">Email: {{ $vehicle->vendor->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Hidden invoice template for PDF downloads and native printing -->
        @php
            $logoBase64 = null;
            $vendor = $vehicle->vendor;
            if ($vendor && $vendor->company_logo) {
                $logoPath = storage_path('app/public/' . $vendor->company_logo);
                if (file_exists($logoPath)) {
                    $logoData = base64_encode(file_get_contents($logoPath));
                    $mimeType = mime_content_type($logoPath);
                    $logoBase64 = 'data:' . $mimeType . ';base64,' . $logoData;
                }
            }
        @endphp
        <div id="hidden-invoice-template" style="position: absolute; left: -9999px; top: -9999px; font-family: 'Arial', sans-serif; background: #ffffff; color: #1e293b; padding: 50px 60px; box-sizing: border-box; width: 800px; opacity: 1; visibility: visible;">
            <!-- Logo & Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; width: 100%;">
                <div>
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="{{ $vendor->company_name ?? $vendor->name }}" style="max-height: 55px; max-width: 180px; object-fit: contain;">
                    @elseif($vendor && $vendor->company_logo)
                        <img src="{{ asset('storage/' . $vendor->company_logo) }}" alt="{{ $vendor->company_name ?? $vendor->name }}" style="max-height: 55px; max-width: 180px; object-fit: contain;">
                    @else
                        <span style="font-size: 1.5rem; font-weight: 800; color: #00a4e4; letter-spacing: -0.5px;">{{ $vendor->company_name ?? $vendor->name ?? 'Car Rental' }}</span>
                    @endif
                </div>
                <div style="text-align: right;">
                    <h1 style="margin: 0; font-size: 1.8rem; font-weight: 800; color: #0f172a; letter-spacing: 0.5px;">BOOKING CONFIRMATION</h1>
                    <p style="margin: 5px 0 0 0; font-size: 0.95rem; color: #64748b; font-weight: 600;">Order #<span id="invoice-order-num">{{ request()->input('reservation_number', 'DCR' . rand(10000, 99999)) }}</span></p>
                </div>
            </div>

            <!-- Theme Line Separator -->
            <div style="height: 3px; background: #00a4e4; margin-bottom: 30px; width: 100%;"></div>

            <!-- Details Row -->
            <div style="display: flex; gap: 40px; margin-bottom: 30px; width: 100%;">
                <!-- Booking Details -->
                <div style="flex: 1;">
                    <h4 style="margin: 0 0 15px 0; font-size: 0.9rem; font-weight: 800; color: #0f172a; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">BOOKING DETAILS</h4>
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; color: #334155;">
                        <div><span style="font-weight: 700; color: #475569; width: 120px; display: inline-block;">Order Number:</span> <span style="font-weight: 600; color: #0f172a;">{{ request()->input('reservation_number', 'DCR' . rand(10000, 99999)) }}</span></div>
                        <div><span style="font-weight: 700; color: #475569; width: 120px; display: inline-block;">Booking Date:</span> <span style="font-weight: 600; color: #0f172a;">{{ date('M d, Y H:i') }}</span></div>
                        <div><span style="font-weight: 700; color: #475569; width: 120px; display: inline-block;">Payment Status:</span> <span style="font-weight: 800; color: #00a4e4;">Pending</span></div>
                        <div><span style="font-weight: 700; color: #475569; width: 120px; display: inline-block;">Payment Method:</span> <span style="font-weight: 600; color: #0f172a; text-transform: capitalize;">{{ str_replace('_', ' ', request()->input('payment_method', 'Pay On Arrival')) }}</span></div>
                    </div>
                </div>

                <!-- Customer Details -->
                <div style="flex: 1;">
                    <h4 style="margin: 0 0 15px 0; font-size: 0.9rem; font-weight: 800; color: #0f172a; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px;">CUSTOMER DETAILS</h4>
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; color: #334155;">
                        <div><span style="font-weight: 700; color: #475569; width: 80px; display: inline-block;">Name:</span> <span style="font-weight: 600; color: #0f172a;">{{ request()->input('fname') }} {{ request()->input('lname') }}</span></div>
                        <div><span style="font-weight: 700; color: #475569; width: 80px; display: inline-block;">Email:</span> <span style="font-weight: 600; color: #0f172a;">{{ request()->input('email') }}</span></div>
                        <div><span style="font-weight: 700; color: #475569; width: 80px; display: inline-block;">Phone:</span> <span style="font-weight: 600; color: #0f172a;">{{ request()->input('phone') }}</span></div>
                    </div>
                </div>
            </div>

            <!-- Section 1: Rental Period & Locations -->
            <div style="border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; margin-bottom: 25px; width: 100%;">
                <div style="background: #f8fafc; padding: 10px 15px; border-bottom: 1px solid #e2e8f0; font-weight: 800; font-size: 0.9rem; color: #0f172a; width: 100%; box-sizing: border-box;">
                    Rental Period & Locations
                </div>
                <div style="display: flex; padding: 15px; gap: 20px; width: 100%; box-sizing: border-box;">
                    <!-- Pickup -->
                    <div style="flex: 1;">
                        <h5 style="margin: 0 0 8px 0; color: #00a4e4; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">PICKUP</h5>
                        <div style="font-size: 0.85rem; color: #334155; display: flex; flex-direction: column; gap: 4px;">
                            <div><strong>Date/Time:</strong> {{ $pickupDate ?? 'Today' }} @ {{ $pickupTime }}</div>
                            <div><strong>Location:</strong> {{ $pickupLocation ? $pickupLocation->location : 'Selected Location' }}</div>
                        </div>
                    </div>
                    <!-- Divider line -->
                    <div style="width: 1px; background: #e2e8f0;"></div>
                    <!-- Return -->
                    <div style="flex: 1;">
                        <h5 style="margin: 0 0 8px 0; color: #00a4e4; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">RETURN</h5>
                        <div style="font-size: 0.85rem; color: #334155; display: flex; flex-direction: column; gap: 4px;">
                            <div><strong>Date/Time:</strong> {{ $returnDate ?? '+2 Days' }} @ {{ $returnTime }}</div>
                            <div><strong>Location:</strong> {{ $returnLocation ? $returnLocation->location : 'Selected Location' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Vehicle & Trip Information -->
            <div style="border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; margin-bottom: 25px; width: 100%;">
                <div style="background: #f8fafc; padding: 10px 15px; border-bottom: 1px solid #e2e8f0; font-weight: 800; font-size: 0.9rem; color: #0f172a; width: 100%; box-sizing: border-box;">
                    Vehicle & Trip Information
                </div>
                <div style="display: flex; padding: 15px; gap: 40px; align-items: center; width: 100%; box-sizing: border-box;">
                    <div style="flex: 2; display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; color: #334155;">
                        <div><span style="font-weight: 700; color: #475569; width: 120px; display: inline-block;">Vehicle:</span> <span style="font-weight: 600; color: #0f172a;">{{ $vehicle->name }}</span></div>
                        <div><span style="font-weight: 700; color: #475569; width: 120px; display: inline-block;">Type:</span> <span style="font-weight: 600; color: #0f172a;">{{ $vehicle->type ?? 'Standard' }}</span></div>
                        <div><span style="font-weight: 700; color: #475569; width: 120px; display: inline-block;">Rental Duration:</span> <span style="font-weight: 600; color: #0f172a;">{{ $rentalDays }} Days</span></div>
                    </div>
                    <!-- Divider -->
                    <div style="width: 1px; height: 60px; background: #e2e8f0;"></div>
                    <div style="flex: 2; display: flex; flex-direction: column; gap: 8px; font-size: 0.85rem; color: #334155;">
                        <div><span style="font-weight: 700; color: #475569; width: 120px; display: inline-block;">Flight Number:</span> <span style="font-weight: 600; color: #0f172a;">{{ request()->input('flight_number', 'N/A') }}</span></div>
                        <div><span style="font-weight: 700; color: #475569; width: 120px; display: inline-block;">Passengers:</span> <span style="font-weight: 600; color: #0f172a;">{{ $vehicle->passengers ?? 'N/A' }}</span></div>
                    </div>
                    <!-- Vehicle Image on the right if base64 encoded -->
                    @if($imageBase64)
                    <div style="flex: 1.5; text-align: right;">
                        <img src="{{ $imageBase64 }}" alt="{{ $vehicle->name }}" style="max-width: 110px; max-height: 70px; object-fit: contain;">
                    </div>
                    @endif
                </div>
            </div>

            <!-- Section 3: Price Summary -->
            <div style="border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; margin-bottom: 20px; width: 100%;">
                <div style="background: #f8fafc; padding: 10px 15px; border-bottom: 1px solid #e2e8f0; font-weight: 800; font-size: 0.9rem; color: #0f172a; width: 100%; box-sizing: border-box;">
                    Price Summary
                </div>
                <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 0.85rem; border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                            <th align="left" style="padding: 10px 15px; font-weight: 700; color: #475569;">Description</th>
                            <th align="right" style="padding: 10px 15px; font-weight: 700; color: #475569; width: 120px;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rental Price -->
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px 15px; color: #334155;">Rental Price ({{ $rentalDays }} Days @ ${{ number_format($vehicle->base_price, 2) }}/day)</td>
                            <td align="right" style="padding: 12px 15px; font-weight: 600; color: #0f172a;">${{ number_format($vehicle->total_price, 2) }}</td>
                        </tr>

                        <!-- Insurance -->
                        @if($selectedInsurance)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px 15px; color: #334155;">Insurance ({{ $selectedInsurance->name }})</td>
                            <td align="right" style="padding: 12px 15px; font-weight: 600; color: #0f172a;">${{ number_format($insuranceTotal, 2) }}</td>
                        </tr>
                        @endif

                        <!-- Extras -->
                        @if($selectedExtras->count() > 0)
                            @foreach($selectedExtras as $extra)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px 15px; color: #334155;">{{ $extra->name }} (x{{ $extra->qty }} @ ${{ number_format($extra->price, 2) }}/day)</td>
                                <td align="right" style="padding: 12px 15px; font-weight: 600; color: #0f172a;">${{ number_format($extra->price * $extra->qty * $rentalDays, 2) }}</td>
                            </tr>
                            @endforeach
                        @endif

                        <!-- Totals -->
                        <tr style="background: rgba(82, 234, 210, 0.05); border-top: 2px solid #e2e8f0; font-weight: 700;">
                            <td style="padding: 12px 15px; color: #0f172a; font-weight: 800;">Total Amount</td>
                            <td align="right" style="padding: 12px 15px; color: #00a4e4; font-size: 1rem; font-weight: 800;">${{ number_format($grandTotal, 2) }}</td>
                        </tr>
                        @if(request()->input('payment_method') === 'deposit')
                        <tr style="border-top: 1px solid #e2e8f0;">
                            <td style="padding: 10px 15px; color: #475569; font-weight: 700;">Paid Now (5% Deposit)</td>
                            <td align="right" style="padding: 10px 15px; color: #16a34a; font-weight: 700;">${{ number_format($grandTotal * 0.05, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 15px; color: #475569; font-weight: 700;">Pending on Arrival</td>
                            <td align="right" style="padding: 10px 15px; color: #dc2626; font-weight: 700;">${{ number_format($grandTotal * 0.95, 2) }}</td>
                        </tr>
                        @elseif(request()->input('payment_method') === 'full')
                        <tr style="border-top: 1px solid #e2e8f0;">
                            <td style="padding: 10px 15px; color: #475569; font-weight: 700;">Paid Now (Full Payment with 5% Discount)</td>
                            <td align="right" style="padding: 10px 15px; color: #16a34a; font-weight: 700;">${{ number_format($grandTotal * 0.95, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 15px; color: #475569; font-weight: 700;">Pending on Arrival</td>
                            <td align="right" style="padding: 10px 15px; color: #0f172a; font-weight: 700;">$0.00</td>
                        </tr>
                        @else
                        <tr style="border-top: 1px solid #e2e8f0;">
                            <td style="padding: 10px 15px; color: #475569; font-weight: 700;">Paid Now</td>
                            <td align="right" style="padding: 10px 15px; color: #16a34a; font-weight: 700;">$0.00</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 15px; color: #475569; font-weight: 700;">Pending on Arrival</td>
                            <td align="right" style="padding: 10px 15px; color: #00a4e4; font-weight: 700;">${{ number_format($grandTotal, 2) }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<!-- html2pdf -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function downloadPDF() {
        const orderNum = document.getElementById('order-number-val').innerText.trim();
        const element = document.getElementById('hidden-invoice-template');
        
        const opt = {
            margin:       0.4,
            filename:     'Order_' + orderNum + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2.5, useCORS: true, backgroundColor: '#ffffff' },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(element).save();
    }
</script>

<style>
    /* Checkmark drawing animations */
    .success-animation {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .checkmark-pulse-bg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse-glow 2s infinite 1.2s;
    }
    .checkmark-svg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: block;
        stroke-width: 3.5;
        stroke: #22c55e;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #22c55e;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s forwards;
    }
    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 3.5;
        stroke-miterlimit: 10;
        stroke: #22c55e;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke: #ffffff;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
    }

    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }
    @keyframes scale {
        0%, 100% {
            transform: none;
        }
        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }
    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 40px #22c55e;
        }
    }
    @keyframes pulse-glow {
        0% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5);
        }
        70% {
            box-shadow: 0 0 30px 20px rgba(34, 197, 94, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
        }
    }

    /* Sequential content load animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }
    .delay-1 {
        animation-delay: 0.8s;
    }
    .delay-2 {
        animation-delay: 1.0s;
    }
    .delay-3 {
        animation-delay: 1.2s;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media print {
        @page {
            margin: 0;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
            color: #0f172a !important;
        }
        body * { visibility: hidden !important; }
        #hidden-invoice-template, #hidden-invoice-template * { visibility: visible !important; }
        #hidden-invoice-template {
            display: block !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            box-sizing: border-box !important;
            padding: 50px 60px !important;
            margin: 0 !important;
        }
    }
</style>
@endsection
