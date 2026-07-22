@extends('user.layouts.app')

@section('title', 'Online Check-In')

@section('main-content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
<style>
    /* Custom Flatpickr Dark Teal Theme */
    .flatpickr-calendar {
        background: #0b1020 !important;
        border: 1px solid rgba(82, 234, 210, 0.25) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
    }
    .flatpickr-months {
        background: #0b1020 !important;
        padding-top: 4px !important;
        padding-bottom: 4px !important;
        align-items: center !important;
    }
    .flatpickr-months .flatpickr-month {
        background: #0b1020 !important;
        color: #f8fafc !important;
        height: 36px !important;
    }
    .flatpickr-current-month {
        padding: 0 !important;
        height: 36px !important;
        line-height: 36px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        position: relative !important;
        top: 0 !important;
    }
    .flatpickr-current-month select.flatpickr-monthDropdown-months {
        background: transparent !important;
        border: none !important;
        color: #f8fafc !important;
        font-size: 0.95rem !important;
        font-weight: 700 !important;
        height: 30px !important;
        line-height: 30px !important;
        padding: 0 4px !important;
        margin: 0 !important;
        display: inline-block !important;
        vertical-align: middle !important;
    }
    .flatpickr-current-month .numInputWrapper {
        width: 65px !important;
        height: 30px !important;
        display: inline-flex !important;
        align-items: center !important;
    }
    .flatpickr-current-month .numInputWrapper input.cur-year {
        background: transparent !important;
        border: none !important;
        color: #f8fafc !important;
        font-size: 0.95rem !important;
        font-weight: 700 !important;
        height: 30px !important;
        line-height: 30px !important;
        padding: 0 !important;
        margin: 0 !important;
        display: inline-block !important;
        vertical-align: middle !important;
    }
    .flatpickr-months .flatpickr-prev-month, .flatpickr-months .flatpickr-next-month {
        color: #52ead2 !important;
        fill: #52ead2 !important;
        height: 36px !important;
        padding: 6px !important;
    }
    .flatpickr-day {
        color: #e2e8f0 !important;
    }
    .flatpickr-day.today {
        border-color: rgba(82, 234, 210, 0.4) !important;
    }
    .flatpickr-day.selected, .flatpickr-day.selected:hover {
        background: #52ead2 !important;
        border-color: #52ead2 !important;
        color: #050711 !important;
        font-weight: 700 !important;
    }

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

    /* ═══════════════════════════════════════════════
       LIGHT MODE OVERRIDES FOR CHECKIN PAGE
    ═══════════════════════════════════════════════ */
    body.light-mode .dark-card {
        background: #ffffff !important;
        border: 1px solid rgba(15, 23, 42, 0.08) !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
    }

    body.light-mode .dark-input {
        background: #ffffff !important;
        border: 1px solid rgba(15, 23, 42, 0.15) !important;
        color: #0f172a !important;
    }

    body.light-mode .dark-input:focus {
        background: #f8fafc !important;
        border-color: #0f766e !important;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12) !important;
        color: #0f172a !important;
    }

    body.light-mode .dark-input::placeholder {
        color: #94a3b8 !important;
    }

    body.light-mode .dark-input:disabled,
    body.light-mode .dark-input[readonly] {
        background: #f1f5f9 !important;
        color: #64748b !important;
        cursor: not-allowed !important;
    }

    body.light-mode .dark-label {
        color: #475569 !important;
    }

    body.light-mode .section-heading {
        color: #0f172a !important;
        border-bottom: 1px solid rgba(15, 23, 42, 0.08) !important;
    }

    body.light-mode .section-heading svg {
        color: #0f766e !important;
    }

    body.light-mode .price-row {
        color: #475569 !important;
        border-bottom: 1px dashed rgba(15, 23, 42, 0.08) !important;
    }

    body.light-mode .price-row.total {
        color: #0f172a !important;
    }

    body.light-mode .btn-teal {
        background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
        color: #051013 !important;
        border-radius: 999px !important;
        font-weight: 800 !important;
    }

    body.light-mode .upload-box {
        border-color: rgba(15, 118, 110, 0.3) !important;
        background: rgba(15, 118, 110, 0.03) !important;
    }

    body.light-mode .upload-box:hover {
        border-color: #0f766e !important;
        background: rgba(15, 118, 110, 0.07) !important;
    }

    body.light-mode .upload-box p,
    body.light-mode .upload-box span,
    body.light-mode .upload-box small {
        color: #475569 !important;
    }

    body.light-mode .upload-box svg {
        stroke: #0f766e !important;
    }

    /* Page title and ref number in light mode */
    body.light-mode h4[style*="color: #f8fafc"],
    body.light-mode h4[style*="color:#f8fafc"] {
        color: #0f172a !important;
    }

    body.light-mode strong[style*="color: #52ead2"],
    body.light-mode strong[style*="color:#52ead2"],
    body.light-mode span[style*="color: #52ead2"],
    body.light-mode span[style*="color:#52ead2"] {
        color: #0f766e !important;
    }

    body.light-mode span[style*="color: #94a3b8"],
    body.light-mode span[style*="color:#94a3b8"],
    body.light-mode p[style*="color: #94a3b8"],
    body.light-mode p[style*="color:#94a3b8"],
    body.light-mode div[style*="color: #94a3b8"],
    body.light-mode div[style*="color:#94a3b8"],
    body.light-mode label[style*="color: #94a3b8"] {
        color: #475569 !important;
    }

    body.light-mode span[style*="color: #f8fafc"],
    body.light-mode span[style*="color:#f8fafc"],
    body.light-mode p[style*="color: #f8fafc"],
    body.light-mode div[style*="color: #f8fafc"],
    body.light-mode strong[style*="color: #f8fafc"],
    body.light-mode li[style*="color: #f8fafc"] {
        color: #0f172a !important;
    }

    body.light-mode div[style*="color: #cbd5e1"],
    body.light-mode span[style*="color: #cbd5e1"],
    body.light-mode p[style*="color: #cbd5e1"] {
        color: #475569 !important;
    }

    body.light-mode div[style*="background: rgba(11, 16, 32"],
    body.light-mode div[style*="background:rgba(11,16,32"],
    body.light-mode div[style*="background: rgba(255, 255, 255, 0.03)"],
    body.light-mode div[style*="background: rgba(255, 255, 255, 0.05)"],
    body.light-mode div[style*="background:rgba(255,255,255,0.03)"],
    body.light-mode div[style*="background:rgba(255,255,255,0.05)"] {
        background: #f8fafc !important;
        border-color: rgba(15, 23, 42, 0.08) !important;
        color: #0f172a !important;
    }

    body.light-mode div[style*="border: 1px solid rgba(255, 255, 255, 0.05)"],
    body.light-mode div[style*="border:1px solid rgba(255,255,255,0.05)"],
    body.light-mode div[style*="border: 1px solid rgba(255, 255, 255, 0.08)"] {
        border-color: rgba(15, 23, 42, 0.08) !important;
    }

    /* Flatpickr calendar light mode */
    body.light-mode .flatpickr-calendar {
        background: #ffffff !important;
        border: 1px solid rgba(15, 23, 42, 0.12) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }
    body.light-mode .flatpickr-months,
    body.light-mode .flatpickr-months .flatpickr-month {
        background: #f8fafc !important;
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-current-month select.flatpickr-monthDropdown-months,
    body.light-mode .flatpickr-current-month .numInputWrapper input.cur-year {
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-weekday {
        color: #475569 !important;
        background: #f8fafc !important;
    }
    body.light-mode .flatpickr-day {
        color: #0f172a !important;
    }
    body.light-mode .flatpickr-day:hover {
        background: rgba(15, 118, 110, 0.08) !important;
        border-color: rgba(15, 118, 110, 0.3) !important;
    }
    body.light-mode .flatpickr-day.selected,
    body.light-mode .flatpickr-day.selected:hover {
        background: #0f766e !important;
        border-color: #0f766e !important;
        color: #ffffff !important;
    }
    body.light-mode .flatpickr-day.today {
        border-color: #0f766e !important;
    }
    body.light-mode .flatpickr-months .flatpickr-prev-month,
    body.light-mode .flatpickr-months .flatpickr-next-month {
        color: #0f766e !important;
        fill: #0f766e !important;
    }
    body.light-mode .flatpickr-months .flatpickr-prev-month:hover svg,
    body.light-mode .flatpickr-months .flatpickr-next-month:hover svg {
        fill: #0f766e !important;
    }

    /* Checkbox light mode */
    body.light-mode .checkbox-custom {
        border-color: #0f766e !important;
        background: #ffffff !important;
    }
    body.light-mode .checkbox-container input[type="checkbox"]:checked + .checkbox-custom {
        background-color: #0f766e !important;
    }
    body.light-mode .checkbox-container input[type="checkbox"]:checked + .checkbox-custom::after {
        color: #ffffff !important;
    }

    /* Light mode scrollbar */
    body.light-mode .custom-scroll::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
    }
    body.light-mode .custom-scroll::-webkit-scrollbar-thumb {
        background: rgba(15, 23, 42, 0.15) !important;
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
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
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
            
            <div class="col-lg-8">
                
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="10" rx="2"></rect><circle cx="7" cy="21" r="2"></circle><circle cx="17" cy="21" r="2"></circle><path d="M14 11V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v4"></path></svg>
                        Trip Information
                    </h5>
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            @if($booking->vehicle && $booking->vehicle->image)
                                @php
                                    $vImgClean = ltrim(str_replace(['public/', 'storage/'], '', $booking->vehicle->image), '/');
                                    $vImgUrl = \Illuminate\Support\Str::startsWith($booking->vehicle->image, ['http://', 'https://']) ? $booking->vehicle->image : asset('storage/' . $vImgClean);
                                @endphp
                                <img src="{{ $vImgUrl }}" alt="{{ $booking->vehicle->name }}" style="max-height: 110px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.5));">
                            @else
                                <div style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 8px; color: #64748b;">No Vehicle Image</div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h6 style="color: #f8fafc; font-weight: 700; font-size: 1.1rem; margin-bottom: 2px;">{{ $booking->vehicle->name ?? 'Vehicle Details' }}</h6>
                            @if($booking->vendor)
                                <p style="color: #94a3b8; font-size: 0.8rem; margin-bottom: 8px;">
                                    <i class="fa fa-building me-1" style="color: #52ead2;"></i> Vendor: <strong style="color: #52ead2;">{{ $booking->vendor->company_name ?? $booking->vendor->name }}</strong>
                                </p>
                            @endif

                            @if($booking->vehicle)
                                <div class="d-flex flex-wrap gap-2 mb-3" style="gap: 8px; font-size: 0.78rem; color: #cbd5e1;">
                                    @if($booking->vehicle->gear_system)
                                        <span style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px;"><i class="fa fa-cog me-1" style="color: #52ead2;"></i> {{ $booking->vehicle->gear_system }}</span>
                                    @endif
                                    @if($booking->vehicle->passengers)
                                        <span style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px;"><i class="fa fa-user me-1" style="color: #52ead2;"></i> {{ $booking->vehicle->passengers }} Seats</span>
                                    @endif
                                    @if($booking->vehicle->doors)
                                        <span style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px;"><i class="fa fa-car-side me-1" style="color: #52ead2;"></i> {{ $booking->vehicle->doors }} Doors</span>
                                    @endif
                                </div>
                            @endif

                            <div class="row g-3">
                                <div class="col-md-6 mb-2">
                                    <span style="font-size: 0.75rem; color: #52ead2; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">PICKUP LOCATION & DATE</span>
                                    <p style="margin: 3px 0 1px; font-size: 0.9rem; color: #f8fafc; font-weight: 700;">
                                        <i class="fa fa-map-marker-alt me-1 text-danger"></i> {{ $booking->pickupLocation->location ?? $booking->pickup_location ?? 'Pickup Location' }}
                                    </p>
                                    <p style="margin: 0; font-size: 0.82rem; color: #cbd5e1; font-weight: 600;">
                                        <i class="fa fa-calendar-alt me-1 text-info"></i> {{ $booking->pickup_date_parsed ? $booking->pickup_date_parsed->format('Y/m/d') : $booking->pickup_date }}
                                        @if($booking->pickup_time)
                                            <span class="ms-1" style="color: #94a3b8;">at {{ date('h:i A', strtotime($booking->pickup_time)) }}</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span style="font-size: 0.75rem; color: #52ead2; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px;">RETURN LOCATION & DATE</span>
                                    <p style="margin: 3px 0 1px; font-size: 0.9rem; color: #f8fafc; font-weight: 700;">
                                        <i class="fa fa-map-marker-alt me-1 text-danger"></i> {{ $booking->returnLocation->location ?? $booking->return_location ?? 'Return Location' }}
                                    </p>
                                    <p style="margin: 0; font-size: 0.82rem; color: #cbd5e1; font-weight: 600;">
                                        <i class="fa fa-calendar-alt me-1 text-info"></i> {{ $booking->return_date_parsed ? $booking->return_date_parsed->format('Y/m/d') : $booking->return_date }}
                                        @if($booking->return_time)
                                            <span class="ms-1" style="color: #94a3b8;">at {{ date('h:i A', strtotime($booking->return_time)) }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Document Verification
                    </h5>

                    @if(isset($autoFilledFromRecent) && $autoFilledFromRecent)
                        <div class="mb-4 p-3 d-flex align-items-center gap-3" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 8px;">
                            <div style="width: 36px; height: 36px; background: rgba(34, 197, 94, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fa fa-shield-alt text-success" style="font-size: 1.1rem;"></i>
                            </div>
                            <div>
                                <h6 style="color: #22c55e; font-weight: 700; margin: 0 0 2px; font-size: 0.9rem;">Verified Documents Auto-Filled (Valid for 3 Months)</h6>
                                <p style="color: #cbd5e1; font-size: 0.8rem; margin: 0;">Your previously verified Driver's License and Passport documents are still valid within 3 months! All details & file previews have been automatically reused. You do not need to re-upload unless your documents changed.</p>
                            </div>
                        </div>
                    @endif

                    <div class="row g-4">
                        
                        <div class="col-md-6">
                            <h6 style="color: #cbd5e1; font-weight: 600; margin-bottom: 12px;">Driver's License Document</h6>
                            
                            @if(!$booking->checkin_status)
                                <div class="upload-box mb-3" onclick="document.getElementById('license_file').click()">
                                    <div id="license_preview_container" style="display: none; margin-bottom: 10px;">
                                        <img id="license_preview_img" src="" alt="License Preview" style="max-height: 140px; max-width: 100%; border-radius: 6px; object-fit: contain; border: 1px solid rgba(82,234,210,0.4);">
                                    </div>
                                    <div id="license_upload_prompt">
                                        <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#52ead2" stroke-width="2" style="margin: 0 auto 10px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                        <p style="font-size: 0.85rem; color: #cbd5e1; margin-bottom: 4px;">Upload License Front & Back</p>
                                        <span style="font-size: 0.75rem; color: #64748b;">JPG, PNG or PDF (max 5MB)</span>
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-secondary btn-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1;">
                                            {{ $booking->license_image ? 'Change File' : 'Select File' }}
                                        </button>
                                    </div>
                                </div>
                                <input type="file" name="license_image" id="license_file" accept=".jpg,.jpeg,.png,.pdf" class="d-none">
                            @endif

                            @if($booking->license_image)
                                @php
                                    $licPathClean = ltrim(str_replace(['public/', 'storage/'], '', $booking->license_image), '/');
                                    $licUrl = \Illuminate\Support\Str::startsWith($booking->license_image, ['http://', 'https://']) ? $booking->license_image : asset('storage/' . $licPathClean);
                                    $licExt = strtolower(pathinfo(parse_url($booking->license_image, PHP_URL_PATH), PATHINFO_EXTENSION));
                                    $isLicImg = empty($licExt) || in_array($licExt, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'svg']);
                                @endphp
                                <div class="p-3 mb-3" style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 8px;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span style="font-size: 0.78rem; color: #52ead2; font-weight: 700;">
                                            <i class="fa fa-id-card me-1"></i> Submitted License Document
                                        </span>
                                        <a href="{{ $licUrl }}" target="_blank" class="btn btn-sm btn-teal" style="padding: 3px 10px; font-size: 0.75rem;">
                                            <i class="fa fa-external-link-alt me-1"></i> View Full File
                                        </a>
                                    </div>
                                    @if($isLicImg)
                                        <div class="text-center pt-2">
                                            <a href="{{ $licUrl }}" target="_blank">
                                                <img src="{{ $licUrl }}" alt="License Document Preview" style="max-height: 200px; max-width: 100%; object-fit: contain; border-radius: 6px; border: 1px solid rgba(255,255,255,0.15); background: #0b0f19;">
                                            </a>
                                        </div>
                                    @else
                                        <div class="p-3 text-center" style="background: rgba(255,255,255,0.03); border-radius: 6px;">
                                            <i class="fa fa-file-pdf text-danger fa-2x mb-1"></i>
                                            <p style="font-size: 0.78rem; color: #cbd5e1; margin: 0;">{{ basename($booking->license_image) }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="dark-label">License Number *</label>
                                <input type="text" name="license_number" class="form-control dark-input" value="{{ old('license_number', $booking->license_number) }}" {{ $booking->checkin_status ? 'disabled readonly style=background:rgba(255,255,255,0.03);cursor:not-allowed;' : 'required' }}>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label class="dark-label">Issue Date *</label>
                                    <div class="position-relative">
                                        <input type="text" name="license_issue_date" class="form-control dark-input pe-4" value="{{ old('license_issue_date', $booking->license_issue_date) }}" {{ $booking->checkin_status ? 'disabled readonly style=background:rgba(255,255,255,0.03);cursor:not-allowed;' : 'required' }}>
                                        <i class="fa fa-calendar-alt position-absolute" style="right: 12px; top: 50%; transform: translateY(-50%); color: #52ead2; pointer-events: none; font-size: 0.85rem;"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="dark-label">Expiry Date *</label>
                                    <div class="position-relative">
                                        <input type="text" name="license_expiry_date" class="form-control dark-input pe-4" value="{{ old('license_expiry_date', $booking->license_expiry_date) }}" {{ $booking->checkin_status ? 'disabled readonly style=background:rgba(255,255,255,0.03);cursor:not-allowed;' : 'required' }}>
                                        <i class="fa fa-calendar-alt position-absolute" style="right: 12px; top: 50%; transform: translateY(-50%); color: #52ead2; pointer-events: none; font-size: 0.85rem;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <h6 style="color: #cbd5e1; font-weight: 600; margin-bottom: 12px;">Passport or ID Card</h6>

                            @if(!$booking->checkin_status)
                                <div class="upload-box mb-3" onclick="document.getElementById('passport_file').click()">
                                    <div id="passport_preview_container" style="display: none; margin-bottom: 10px;">
                                        <img id="passport_preview_img" src="" alt="Passport Preview" style="max-height: 140px; max-width: 100%; border-radius: 6px; object-fit: contain; border: 1px solid rgba(82,234,210,0.4);">
                                    </div>
                                    <div id="passport_upload_prompt">
                                        <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#52ead2" stroke-width="2" style="margin: 0 auto 10px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                        <p style="font-size: 0.85rem; color: #cbd5e1; margin-bottom: 4px;">Upload Passport photo page</p>
                                        <span style="font-size: 0.75rem; color: #64748b;">JPG, PNG or PDF (max 5MB)</span>
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-secondary btn-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1;">
                                            {{ $booking->passport_image ? 'Change File' : 'Select File' }}
                                        </button>
                                    </div>
                                </div>
                                <input type="file" name="passport_image" id="passport_file" accept=".jpg,.jpeg,.png,.pdf" class="d-none">
                            @endif

                            @if($booking->passport_image)
                                @php
                                    $passPathClean = ltrim(str_replace(['public/', 'storage/'], '', $booking->passport_image), '/');
                                    $passUrl = \Illuminate\Support\Str::startsWith($booking->passport_image, ['http://', 'https://']) ? $booking->passport_image : asset('storage/' . $passPathClean);
                                    $passExt = strtolower(pathinfo(parse_url($booking->passport_image, PHP_URL_PATH), PATHINFO_EXTENSION));
                                    $isPassImg = empty($passExt) || in_array($passExt, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'svg']);
                                @endphp
                                <div class="p-3 mb-3" style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 8px;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span style="font-size: 0.78rem; color: #52ead2; font-weight: 700;">
                                            <i class="fa fa-passport me-1"></i> Submitted Passport Document
                                        </span>
                                        <a href="{{ $passUrl }}" target="_blank" class="btn btn-sm btn-teal" style="padding: 3px 10px; font-size: 0.75rem;">
                                            <i class="fa fa-external-link-alt me-1"></i> View Full File
                                        </a>
                                    </div>
                                    @if($isPassImg)
                                        <div class="text-center pt-2">
                                            <a href="{{ $passUrl }}" target="_blank">
                                                <img src="{{ $passUrl }}" alt="Passport Document Preview" style="max-height: 200px; max-width: 100%; object-fit: contain; border-radius: 6px; border: 1px solid rgba(255,255,255,0.15); background: #0b0f19;">
                                            </a>
                                        </div>
                                    @else
                                        <div class="p-3 text-center" style="background: rgba(255,255,255,0.03); border-radius: 6px;">
                                            <i class="fa fa-file-pdf text-danger fa-2x mb-1"></i>
                                            <p style="font-size: 0.78rem; color: #cbd5e1; margin: 0;">{{ basename($booking->passport_image) }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div>
                                <label class="dark-label">Passport / ID Number *</label>
                                <input type="text" name="pass_number" class="form-control dark-input" value="{{ old('pass_number', $booking->pass_number) }}" {{ $booking->checkin_status ? 'disabled readonly style=background:rgba(255,255,255,0.03);cursor:not-allowed;' : 'required' }}>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        Flight Information
                    </h5>
                    <div class="mb-3">
                        <label class="dark-label">Arrival Flight Number (Optional)</label>
                        <input type="text" name="flight_number" class="form-control dark-input" placeholder="e.g. RJ507" value="{{ old('flight_number', $booking->flight_number) }}" {{ $booking->checkin_status ? 'disabled readonly style=background:rgba(255,255,255,0.03);cursor:not-allowed;' : '' }}>
                        <p style="font-size: 0.75rem; color: #64748b; margin-top: 6px; font-style: italic;">
                            <i class="fa fa-info-circle me-1"></i> We monitor arrivals to ensure your vehicle is ready if your flight is delayed.
                        </p>
                    </div>
                </div>

                
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Terms & Conditions
                    </h5>
                    <div class="custom-scroll mb-4 p-3" style="max-height: 200px; overflow-y: auto; background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); border-radius: 6px; font-size: 0.85rem; color: #cbd5e1; line-height: 1.6;">
                        @if($booking->vehicle && !empty($booking->vehicle->terms))
                            <div class="vendor-terms-content">
                                <h6 style="color: #52ead2; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">
                                    <i class="fa fa-file-contract me-1"></i> Vendor Rental Terms & Policies:
                                </h6>
                                {!! nl2br(e($booking->vehicle->terms)) !!}
                            </div>
                        @else
                            <p class="mb-2">By checking in online, you agree to the following rental policies:</p>
                            <ul class="ps-3 mb-0" style="list-style-type: disc;">
                                <li>You must present the original driver's license and ID card / Passport at pickup.</li>
                                <li>The driver must be at least 21 years old and hold a valid license for at least 1 year.</li>
                                <li>A refundable security deposit will be held upon delivery.</li>
                                <li>Fuel Policy: Full to Full. The vehicle is provided with a full tank and must be returned full.</li>
                                <li>Late returns may incur additional charges.</li>
                            </ul>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="checkbox-container">
                            <input type="checkbox" name="terms_agreed" value="1" {{ $booking->checkin_status ? 'checked disabled' : 'required' }}>
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
                    @else
                        <div class="mt-4 p-3 text-center" style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 8px; color: #22c55e; font-weight: 700; font-size: 0.95rem;">
                            <i class="fa fa-check-circle me-2"></i> Check-In Submitted & Verified (Read-Only)
                        </div>
                    @endif
                </div>
                </form> 

                
                @if($booking->is_completed_or_ended)
                    <div class="dark-card p-4">
                        <h5 class="section-heading" style="color: #fbbf24;">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="#fbbf24" stroke="#fbbf24" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            Rate & Review Your Experience
                        </h5>

                        @if($booking->review)
                            <div class="p-3" style="background: rgba(251, 191, 36, 0.08); border: 1px solid rgba(251, 191, 36, 0.25); border-radius: 8px;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div style="color: #fbbf24; font-size: 1.1rem; font-weight: 700;">
                                        @for($s = 1; $s <= 5; $s++)
                                            @if($s <= $booking->review->rating)
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                        <span class="ms-2" style="font-size: 0.9rem; color: #f8fafc;">{{ $booking->review->rating }}/5 Stars</span>
                                    </div>
                                    <span class="badge" style="background: rgba(34, 197, 94, 0.2); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.4); font-size: 0.75rem;">
                                        <i class="fa fa-check me-1"></i> Review Submitted
                                    </span>
                                </div>
                                @if($booking->review->comment)
                                    <p style="margin: 0; font-size: 0.88rem; color: #e2e8f0; font-style: italic;">
                                        "{{ $booking->review->comment }}"
                                    </p>
                                @endif
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 8px;">
                                    Submitted on {{ $booking->review->created_at->format('d M, Y \a\t h:i A') }}
                                </div>
                            </div>
                        @else
                            <p style="font-size: 0.88rem; color: #cbd5e1; margin-bottom: 15px;">
                                Your trip has ended! Please rate your overall rental experience for <strong>{{ $booking->vehicle->name ?? 'Vehicle' }}</strong> and <strong>{{ $booking->vendor->company_name ?? $booking->vendor->name ?? 'Vendor' }}</strong>.
                            </p>
                            <form action="{{ route('user.bookings.review.submit', $booking->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="dark-label" style="display: block; font-weight: 600;">Your Rating *</label>
                                    <div class="star-rating-selector" style="display: flex; gap: 8px; font-size: 1.6rem; cursor: pointer; color: #64748b;">
                                        @for($star = 1; $star <= 5; $star++)
                                            <span class="star-btn" data-value="{{ $star }}" onclick="setRating({{ $star }})" style="transition: color 0.2s;">★</span>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="selected_rating_input" value="5" required>
                                </div>
                                <div class="mb-3">
                                    <label class="dark-label">Your Feedback / Review Comments</label>
                                    <textarea name="comment" class="form-control dark-input" rows="3" placeholder="Tell us about the vehicle condition, vendor service, pickup/return process..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-teal">
                                    <i class="fa fa-paper-plane me-1"></i> Submit Review
                                </button>
                            </form>
                            <script>
                                function setRating(val) {
                                    document.getElementById('selected_rating_input').value = val;
                                    const stars = document.querySelectorAll('.star-btn');
                                    stars.forEach((star, idx) => {
                                        if (idx < val) {
                                            star.style.color = '#fbbf24';
                                        } else {
                                            star.style.color = '#64748b';
                                        }
                                    });
                                }
                                document.addEventListener('DOMContentLoaded', function() {
                                    setRating(5);
                                });
                            </script>
                        @endif
                    </div>
                @endif
            </div>

            
            <div class="col-lg-4">
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        Booking Summary
                    </h5>
                    
                    @php
                        $diff = $booking->pickup_date_parsed->diffInDays($booking->return_date_parsed);
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

                
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        Vendor Contact & Help
                    </h5>
                    <div class="d-flex align-items-center mb-3 gap-3">
                        <div style="width: 44px; height: 44px; background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.3); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa fa-building" style="color: #52ead2; font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <h6 style="color: #f8fafc; font-weight: 700; margin: 0; font-size: 0.95rem;">{{ $booking->vendor->company_name ?? $booking->vendor->name ?? 'Vendor Partner' }}</h6>
                            <span style="color: #64748b; font-size: 0.8rem;">Official Rental Operator</span>
                        </div>
                    </div>
                    <div style="font-size: 0.82rem; color: #cbd5e1; display: flex; flex-direction: column; gap: 8px;">
                        @if($booking->vendor && $booking->vendor->phone)
                            <div><i class="fa fa-phone me-2" style="color: #52ead2;"></i> {{ $booking->vendor->phone }}</div>
                        @endif
                        @if($booking->vendor && $booking->vendor->email)
                            <div><i class="fa fa-envelope me-2" style="color: #52ead2;"></i> {{ $booking->vendor->email }}</div>
                        @endif
                        <div><i class="fa fa-clock me-2" style="color: #52ead2;"></i> Support Hours: 08:00 AM - 09:00 PM</div>
                    </div>
                </div>

                
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                        Pickup Checklist
                    </h5>
                    <ul style="padding-left: 18px; font-size: 0.82rem; color: #cbd5e1; margin-bottom: 0; line-height: 1.8;">
                        <li>Present valid original Driver's License at counter.</li>
                        <li>Keep Passport / ID Card ready for verification.</li>
                        <li>Inspect vehicle exterior & interior before driving.</li>
                        <li>Verify fuel level matches agreement terms.</li>
                        <li>Keep Reservation #<strong>{{ $booking->reservation_number }}</strong> handy.</li>
                    </ul>
                </div>

                
                <div class="dark-card p-4">
                    <h5 class="section-heading">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        Download Documents
                    </h5>
                    <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 12px;">Need a printable copy of your booking voucher or official invoice?</p>
                    <a href="{{ route('user.bookings.invoice', $booking->id) }}" target="_blank" class="btn btn-teal w-100" style="font-size: 0.85rem; padding: 10px;">
                        <i class="fa fa-file-pdf me-1"></i> Download Invoice PDF
                    </a>
                </div>
            </div>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Flatpickr Dark Teal Theme initialization for Check-In Dates
        const issueInput = document.querySelector('input[name="license_issue_date"]');
        const expiryInput = document.querySelector('input[name="license_expiry_date"]');

        if (issueInput && !issueInput.disabled && typeof flatpickr !== 'undefined') {
            flatpickr(issueInput, {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                allowInput: true
            });
        }
        if (expiryInput && !expiryInput.disabled && typeof flatpickr !== 'undefined') {
            flatpickr(expiryInput, {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                allowInput: true
            });
        }

        // Live image file preview when selecting files
        const fileConfigs = [
            { fileId: 'license_file', previewContainerId: 'license_preview_container', previewImgId: 'license_preview_img', promptId: 'license_upload_prompt' },
            { fileId: 'passport_file', previewContainerId: 'passport_preview_container', previewImgId: 'passport_preview_img', promptId: 'passport_upload_prompt' }
        ];

        fileConfigs.forEach(cfg => {
            const input = document.getElementById(cfg.fileId);
            if (input) {
                input.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        const container = document.getElementById(cfg.previewContainerId);
                        const img = document.getElementById(cfg.previewImgId);
                        const prompt = document.getElementById(cfg.promptId);

                        if (file.type.startsWith('image/') && container && img) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                img.src = e.target.result;
                                container.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        }

                        const nameSpan = this.parentElement.querySelector('.upload-box p');
                        if (nameSpan) {
                            nameSpan.textContent = `Selected: ${file.name}`;
                            nameSpan.style.color = '#52ead2';
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
