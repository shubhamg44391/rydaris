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
                
                <div class="col-lg-8">
                    
                    
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

                
                <div class="col-lg-4">
                    
                    
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
        <div id="hidden-invoice-template" style="position: absolute; left: -9999px; top: -9999px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: #ffffff; color: #1e293b; padding: 12px 20px; box-sizing: border-box; width: 750px; opacity: 1; visibility: visible;">
            
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 8px; border-collapse: collapse; width: 100%;">
                <tr>
                    <td valign="middle" style="width: 55%;">
                        @if($logoBase64)
                            <img src="{{ $logoBase64 }}" alt="{{ $vendor->company_name ?? $vendor->name }}" style="max-height: 38px; max-width: 170px; object-fit: contain;">
                        @elseif($vendor && $vendor->company_logo)
                            <img src="{{ asset('storage/' . $vendor->company_logo) }}" alt="{{ $vendor->company_name ?? $vendor->name }}" style="max-height: 38px; max-width: 170px; object-fit: contain;">
                        @else
                            <span style="font-size: 1.25rem; font-weight: 800; color: #00a4e4; letter-spacing: -0.5px;">{{ $vendor->company_name ?? $vendor->name ?? 'Car Rental' }}</span>
                        @endif
                    </td>
                    <td valign="middle" align="right" style="width: 45%;">
                        <div style="font-size: 1.1rem; font-weight: 800; color: #0f172a; letter-spacing: 0.5px; white-space: nowrap;">BOOKING CONFIRMATION</div>
                        <div style="font-size: 0.78rem; color: #64748b; font-weight: 600; margin-top: 1px;">Order #<span id="invoice-order-num">{{ request()->input('reservation_number', 'DCR' . rand(10000, 99999)) }}</span></div>
                    </td>
                </tr>
            </table>

            
            <div style="height: 2px; background: #00a4e4; margin-bottom: 8px; width: 100%;"></div>

            
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 8px; border-collapse: collapse; width: 100%;">
                <tr>
                    
                    <td valign="top" style="width: 48%;">
                        <div style="font-size: 0.75rem; font-weight: 800; color: #0f172a; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; padding-bottom: 2px; margin-bottom: 4px;">BOOKING DETAILS</div>
                        <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 0.75rem; color: #334155; border-collapse: collapse;">
                            <tr>
                                <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Order Number:</td>
                                <td style="font-weight: 600; color: #0f172a; padding-top: 1px; padding-bottom: 1px;">{{ request()->input('reservation_number', 'DCR' . rand(10000, 99999)) }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Booking Date:</td>
                                <td style="font-weight: 600; color: #0f172a; padding-top: 1px; padding-bottom: 1px;">{{ date('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Payment Status:</td>
                                <td style="font-weight: 800; color: #00a4e4; padding-top: 1px; padding-bottom: 1px;">Pending</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Payment Method:</td>
                                <td style="font-weight: 600; color: #0f172a; text-transform: capitalize; padding-top: 1px; padding-bottom: 1px;">{{ str_replace('_', ' ', request()->input('payment_method', 'Pay On Arrival')) }}</td>
                            </tr>
                        </table>
                    </td>
                    
                    <td style="width: 4%;"></td>

                    
                    <td valign="top" style="width: 48%;">
                        <div style="font-size: 0.75rem; font-weight: 800; color: #0f172a; text-transform: uppercase; border-bottom: 1.5px solid #e2e8f0; padding-bottom: 2px; margin-bottom: 4px;">CUSTOMER DETAILS</div>
                        <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 0.75rem; color: #334155; border-collapse: collapse;">
                            <tr>
                                <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Name:</td>
                                <td style="font-weight: 600; color: #0f172a; padding-top: 1px; padding-bottom: 1px;">{{ request()->input('fname') }} {{ request()->input('lname') }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Email:</td>
                                <td style="font-weight: 600; color: #0f172a; word-break: break-all; padding-top: 1px; padding-bottom: 1px;">{{ request()->input('email') }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Phone:</td>
                                <td style="font-weight: 600; color: #0f172a; padding-top: 1px; padding-bottom: 1px;">{{ request()->input('phone') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 8px; border: 1px solid #e2e8f0; border-radius: 4px; border-collapse: separate; overflow: hidden; width: 100%;">
                <tr>
                    <td style="background: #f8fafc; padding: 4px 8px; border-bottom: 1px solid #e2e8f0; font-weight: 800; font-size: 0.75rem; color: #0f172a;">
                        Rental Period & Locations
                    </td>
                </tr>
                <tr>
                    <td style="padding: 6px 8px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tr>
                                <td valign="top" style="width: 48%;">
                                    <div style="color: #00a4e4; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1px;">PICKUP</div>
                                    <div style="font-size: 0.75rem; color: #334155; line-height: 1.3;">
                                        <div><strong>Date/Time:</strong> {{ $pickupDate ?? 'Today' }} @ {{ $pickupTime }}</div>
                                        <div><strong>Location:</strong> {{ $pickupLocation ? $pickupLocation->location : 'Selected Location' }}</div>
                                    </div>
                                </td>
                                <td style="width: 4%; text-align: center;">
                                    <div style="width: 1px; height: 30px; background: #e2e8f0; margin: 0 auto;"></div>
                                </td>
                                <td valign="top" style="width: 48%;">
                                    <div style="color: #00a4e4; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1px;">RETURN</div>
                                    <div style="font-size: 0.75rem; color: #334155; line-height: 1.3;">
                                        <div><strong>Date/Time:</strong> {{ $returnDate ?? '+2 Days' }} @ {{ $returnTime }}</div>
                                        <div><strong>Location:</strong> {{ $returnLocation ? $returnLocation->location : 'Selected Location' }}</div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 8px; border: 1px solid #e2e8f0; border-radius: 4px; border-collapse: separate; overflow: hidden; width: 100%;">
                <tr>
                    <td style="background: #f8fafc; padding: 4px 8px; border-bottom: 1px solid #e2e8f0; font-weight: 800; font-size: 0.75rem; color: #0f172a;">
                        Vehicle & Trip Information
                    </td>
                </tr>
                <tr>
                    <td style="padding: 6px 8px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tr>
                                <td valign="middle" style="width: 44%;">
                                    <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 0.75rem; color: #334155; border-collapse: collapse;">
                                        <tr>
                                            <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Vehicle:</td>
                                            <td style="font-weight: 600; color: #0f172a; padding-top: 1px; padding-bottom: 1px;">{{ $vehicle->name }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Type:</td>
                                            <td style="font-weight: 600; color: #0f172a; padding-top: 1px; padding-bottom: 1px;">{{ $vehicle->type ?? 'Standard' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Rental Duration:</td>
                                            <td style="font-weight: 600; color: #0f172a; padding-top: 1px; padding-bottom: 1px;">{{ $rentalDays }} Days</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 4%; text-align: center;">
                                    <div style="width: 1px; height: 35px; background: #e2e8f0; margin: 0 auto;"></div>
                                </td>
                                <td valign="middle" style="width: 34%;">
                                    <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 0.75rem; color: #334155; border-collapse: collapse;">
                                        <tr>
                                            <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Flight Number:</td>
                                            <td style="font-weight: 600; color: #0f172a; padding-top: 1px; padding-bottom: 1px;">{{ request()->input('flight_number', 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: 700; color: #475569; width: 1%; white-space: nowrap; padding-right: 12px; padding-top: 1px; padding-bottom: 1px;">Passengers:</td>
                                            <td style="font-weight: 600; color: #0f172a; padding-top: 1px; padding-bottom: 1px;">{{ $vehicle->passengers ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </td>
                                @if($imageBase64)
                                <td valign="middle" align="right" style="width: 18%;">
                                    <img src="{{ $imageBase64 }}" alt="{{ $vehicle->name }}" style="max-width: 80px; max-height: 40px; object-fit: contain;">
                                </td>
                                @endif
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 0px; border: 1px solid #e2e8f0; border-radius: 4px; border-collapse: separate; overflow: hidden; width: 100%;">
                <tr>
                    <td style="background: #f8fafc; padding: 4px 8px; border-bottom: 1px solid #e2e8f0; font-weight: 800; font-size: 0.75rem; color: #0f172a;" colspan="2">
                        Price Summary
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 0;">
                        <table width="100%" cellpadding="4" cellspacing="0" style="font-size: 0.75rem; border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr style="border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                                    <th align="left" style="padding: 4px 8px; font-weight: 700; color: #475569;">Description</th>
                                    <th align="right" style="padding: 4px 8px; font-weight: 700; color: #475569; width: 100px;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 4px 8px; color: #334155;">Rental Price ({{ $rentalDays }} Days @ ${{ number_format($vehicle->base_price, 2) }}/day)</td>
                                    <td align="right" style="padding: 4px 8px; font-weight: 600; color: #0f172a;">${{ number_format($vehicle->total_price, 2) }}</td>
                                </tr>

                                @if($selectedInsurance)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 4px 8px; color: #334155;">Insurance ({{ $selectedInsurance->name }})</td>
                                    <td align="right" style="padding: 4px 8px; font-weight: 600; color: #0f172a;">${{ number_format($insuranceTotal, 2) }}</td>
                                </tr>
                                @endif

                                @if($selectedExtras->count() > 0)
                                    @foreach($selectedExtras as $extra)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 4px 8px; color: #334155;">{{ $extra->name }} (x{{ $extra->qty }} @ ${{ number_format($extra->price, 2) }}/day)</td>
                                        <td align="right" style="padding: 4px 8px; font-weight: 600; color: #0f172a;">${{ number_format($extra->price * $extra->qty * $rentalDays, 2) }}</td>
                                    </tr>
                                    @endforeach
                                @endif

                                <tr style="background: rgba(0, 164, 228, 0.05); border-top: 1.5px solid #e2e8f0; font-weight: 700;">
                                    <td style="padding: 4px 8px; color: #0f172a; font-weight: 800; font-size: 0.78rem;">Total Amount</td>
                                    <td align="right" style="padding: 4px 8px; color: #00a4e4; font-size: 0.9rem; font-weight: 800;">${{ number_format($grandTotal, 2) }}</td>
                                </tr>
                                @if(request()->input('payment_method') === 'deposit')
                                <tr style="border-top: 1px solid #e2e8f0;">
                                    <td style="padding: 3px 8px; color: #475569; font-weight: 700;">Paid Now (5% Deposit)</td>
                                    <td align="right" style="padding: 3px 8px; color: #16a34a; font-weight: 700;">${{ number_format($grandTotal * 0.05, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 8px; color: #475569; font-weight: 700;">Pending on Arrival</td>
                                    <td align="right" style="padding: 3px 8px; color: #dc2626; font-weight: 700;">${{ number_format($grandTotal * 0.95, 2) }}</td>
                                </tr>
                                @elseif(request()->input('payment_method') === 'full')
                                <tr style="border-top: 1px solid #e2e8f0;">
                                    <td style="padding: 3px 8px; color: #475569; font-weight: 700;">Paid Now (Full Payment with 5% Discount)</td>
                                    <td align="right" style="padding: 3px 8px; color: #16a34a; font-weight: 700;">${{ number_format($grandTotal * 0.95, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 8px; color: #475569; font-weight: 700;">Pending on Arrival</td>
                                    <td align="right" style="padding: 3px 8px; color: #0f172a; font-weight: 700;">$0.00</td>
                                </tr>
                                @else
                                <tr style="border-top: 1px solid #e2e8f0;">
                                    <td style="padding: 3px 8px; color: #475569; font-weight: 700;">Paid Now</td>
                                    <td align="right" style="padding: 3px 8px; color: #16a34a; font-weight: 700;">$0.00</td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 8px; color: #475569; font-weight: 700;">Pending on Arrival</td>
                                    <td align="right" style="padding: 3px 8px; color: #00a4e4; font-weight: 700;">${{ number_format($grandTotal, 2) }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</div>
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function downloadPDF() {
        const orderNumEl = document.getElementById('order-number-val') || document.getElementById('invoice-order-num');
        const orderNum = orderNumEl ? orderNumEl.innerText.trim() : 'Confirmation';
        const element = document.getElementById('hidden-invoice-template');

        if (!element) {
            window.print();
            return;
        }

        const pdfLib = window.html2pdf || (typeof html2pdf !== 'undefined' ? html2pdf : null);
        if (!pdfLib) {
            window.print();
            return;
        }

        // Create an isolated hidden iframe to eliminate parent layout, flexbox offsets, and theme CSS interference
        const iframe = document.createElement('iframe');
        iframe.style.position = 'fixed';
        iframe.style.left = '-9999px';
        iframe.style.top = '-9999px';
        iframe.style.width = '750px';
        iframe.style.height = '1000px';
        iframe.style.border = 'none';
        document.body.appendChild(iframe);

        const doc = iframe.contentWindow.document;
        doc.open();
        doc.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>Booking Confirmation</title>
                <style>
                    * {
                        box-sizing: border-box !important;
                        -webkit-print-color-adjust: exact !important;
                        print-color-adjust: exact !important;
                    }
                    html, body {
                        margin: 0 !important;
                        padding: 0 !important;
                        background: #ffffff !important;
                        color: #1e293b !important;
                        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
                        width: 750px !important;
                    }
                    .pdf-container {
                        width: 750px !important;
                        padding: 12px 20px !important;
                        background: #ffffff !important;
                        margin: 0 auto !important;
                        box-sizing: border-box !important;
                    }
                </style>
            </head>
            <body>
                <div class="pdf-container">
                    ${element.innerHTML}
                </div>
            </body>
            </html>
        `);
        doc.close();

        setTimeout(function() {
            const target = iframe.contentWindow.document.querySelector('.pdf-container');
            if (!target) {
                if (document.body.contains(iframe)) document.body.removeChild(iframe);
                window.print();
                return;
            }

            const opt = {
                margin:       [3, 3, 3, 3],
                filename:     'Booking_Confirmation_' + orderNum + '.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { 
                    scale: 2, 
                    useCORS: true, 
                    backgroundColor: '#ffffff', 
                    scrollX: 0, 
                    scrollY: 0 
                },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            pdfLib().set(opt).from(target).save().then(function() {
                if (document.body.contains(iframe)) {
                    document.body.removeChild(iframe);
                }
            }).catch(function(err) {
                console.error('PDF generation error:', err);
                if (document.body.contains(iframe)) {
                    document.body.removeChild(iframe);
                }
                window.print();
            });
        }, 200);
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
