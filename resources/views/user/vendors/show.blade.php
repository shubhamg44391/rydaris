@extends('user.layouts.app')

@section('main-content')
<div class="admin-panel" style="padding: 20px;">
    
    <!-- Vendor Header -->
    <div class="vendor-header mb-5 p-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(82, 234, 210, 0.15); border-radius: 12px; display: flex; align-items: center; gap: 25px;">
        <div class="vendor-avatar" style="width: 80px; height: 80px; background: rgba(82, 234, 210, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--brand); font-weight: bold; font-size: 2rem; overflow: hidden; border: 2px solid rgba(82, 234, 210, 0.3);">
            @if($vendor->company_logo)
                <img src="{{ asset('storage/' . $vendor->company_logo) }}" alt="{{ $vendor->company_name }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                {{ strtoupper(substr($vendor->company_name ?? $vendor->name, 0, 1)) }}
            @endif
        </div>
        <div>
            <h2 style="font-weight: 700; color: #f8fafc; margin-bottom: 5px;">{{ $vendor->company_name ?? $vendor->name }}</h2>
            <div class="d-flex align-items-center gap-4 text-muted">
                <span class="badge" style="background: rgba(82, 234, 210, 0.2); color: var(--brand); font-weight: normal;">Trusted Vendor</span>
                <span class="d-flex align-items-center gap-1">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    {{ $vendor->country_code }} {{ $vendor->contact_number }}
                </span>
            </div>
        </div>
    </div>

    <!-- Search Car Widget -->
    <div class="search-widget p-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(82, 234, 210, 0.15); border-radius: 16px; margin-bottom: 40px;">
        <form action="#" method="GET">
            <div class="row g-3 align-items-end">
                
                <!-- Pick-up Location -->
                <div class="col-md-4">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-weight: 500; font-size: 0.9rem;">Pick-up Location</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--brand);">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg> 
                        </span>
                        <select name="pickup_location" style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; background: rgba(255, 255, 255, 0.05); appearance: none; color: #ffffff;">
                            <option value="" style="background: #0f172a;">Select Pick-up Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" style="background: #0f172a;" {{ request('pickup_location') == $location->id ? 'selected' : '' }}>{{ $location->location }}</option>
                            @endforeach
                        </select>
                        <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--brand); pointer-events: none;">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </span>
                    </div>
                </div>

                <!-- Return Location -->
                <div class="col-md-4">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-weight: 500; font-size: 0.9rem;">Return Location</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--brand);">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </span>
                        <select name="return_location" style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; background: rgba(255, 255, 255, 0.05); appearance: none; color: #ffffff;">
                            <option value="" style="background: #0f172a;">Select Return Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" style="background: #0f172a;" {{ request('return_location') == $location->id ? 'selected' : '' }}>{{ $location->location }}</option>
                            @endforeach
                        </select>
                        <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--brand); pointer-events: none;">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </span>
                    </div>
                </div>

                <!-- Rental Type -->
                <div class="col-md-4">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-weight: 500; font-size: 0.9rem;">Rental Type</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--brand);">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        </span>
                        <select name="rental_type" style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; background: rgba(255, 255, 255, 0.05); appearance: none; color: #ffffff;">
                            <option value="default" {{ request('rental_type') == 'default' ? 'selected' : '' }} style="background: #0f172a;">Default</option>
                            <option value="weekly" {{ request('rental_type') == 'weekly' ? 'selected' : '' }} style="background: #0f172a;">Weekly</option>
                            <option value="monthly" {{ request('rental_type') == 'monthly' ? 'selected' : '' }} style="background: #0f172a;">Monthly</option>
                        </select>
                        <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--brand); pointer-events: none;">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </span>
                    </div>
                </div>

                <!-- Pick-up Date & Time -->
                <div class="col-md-4">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-weight: 500; font-size: 0.9rem;">Pick-up Date & Time</label>
                    <div class="d-flex gap-2">
                        <input type="text" name="pickup_date" class="custom-datepicker" placeholder="Select Date" style="flex: 2; padding: 12px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; color: #ffffff; background: rgba(255, 255, 255, 0.05); outline: none;">
                        <select name="pickup_time" style="flex: 1; padding: 12px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; background: rgba(255, 255, 255, 0.05); appearance: none; color: #ffffff;">
                            @for($i = 0; $i < 24; $i++)
                                @php $hr = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{$hr}}:00" {{ request('pickup_time') == $hr.':00' ? 'selected' : '' }} style="background: #0f172a;">{{$hr}}:00</option>
                                <option value="{{$hr}}:30" {{ request('pickup_time') == $hr.':30' ? 'selected' : '' }} style="background: #0f172a;">{{$hr}}:30</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Return Date & Time -->
                <div class="col-md-4">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-weight: 500; font-size: 0.9rem;">Return Date & Time</label>
                    <div class="d-flex gap-2">
                        <input type="text" name="return_date" class="custom-datepicker" placeholder="Select Date" style="flex: 2; padding: 12px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; color: #ffffff; background: rgba(255, 255, 255, 0.05); outline: none;">
                        <select name="return_time" style="flex: 1; padding: 12px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; background: rgba(255, 255, 255, 0.05); appearance: none; color: #ffffff;">
                            @for($i = 0; $i < 24; $i++)
                                @php $hr = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{$hr}}:00" style="background: #0f172a;">{{$hr}}:00</option>
                                <option value="{{$hr}}:30" style="background: #0f172a;">{{$hr}}:30</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Search Button -->
                <div class="col-md-4">
                    <button type="submit" class="btn" style="width: 100%; padding: 12px; background: var(--brand); color: #0b1020; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; transition: all 0.2s; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.3);">
                        Search Now
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- Vehicles Section -->
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto;">
    <div class="vehicles-section mt-5">
        <h2 style="font-weight: 700; color: #f8fafc; margin-bottom: 20px;">Our Vehicles</h2>
        
        <!-- Filters -->
        <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-4">
                <div>
                    <label style="display: block; font-size: 0.85rem; color: var(--muted); margin-bottom: 5px;">Transmission</label>
                    <div class="btn-group">
                        <a href="{{ request()->fullUrlWithQuery(['transmission' => 'All']) }}" class="btn btn-sm {{ request('transmission', 'All') === 'All' ? 'btn-primary' : 'btn-outline-primary' }}" style="border-radius: 20px 0 0 20px;">All</a>
                        <a href="{{ request()->fullUrlWithQuery(['transmission' => 'Automatic']) }}" class="btn btn-sm {{ request('transmission') === 'Automatic' ? 'btn-primary' : 'btn-outline-primary' }}">Automatic</a>
                        <a href="{{ request()->fullUrlWithQuery(['transmission' => 'Manual']) }}" class="btn btn-sm {{ request('transmission') === 'Manual' ? 'btn-primary' : 'btn-outline-primary' }}" style="border-radius: 0 20px 20px 0;">Manual</a>
                    </div>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; color: var(--muted); margin-bottom: 5px;">Price</label>
                    <select class="form-select form-select-sm" onchange="window.location.href=this.value" style="background: rgba(255,255,255,0.05); color: #fff; border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 4px 30px 4px 15px; cursor: pointer;">
                        <option value="{{ request()->fullUrlWithQuery(['sort_price' => 'all']) }}" {{ request('sort_price', 'all') === 'all' ? 'selected' : '' }} style="background: #0f172a;">All</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort_price' => 'highest']) }}" {{ request('sort_price') === 'highest' ? 'selected' : '' }} style="background: #0f172a;">Highest</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort_price' => 'lowest']) }}" {{ request('sort_price') === 'lowest' ? 'selected' : '' }} style="background: #0f172a;">Lowest</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Vehicle Grid -->
        @if($vehicles->count() > 0)
            @php
                $groupedVehicles = $vehicles->groupBy(function($v) {
                    return $v->group->name ?? 'Standard Cars';
                });
            @endphp

            @foreach($groupedVehicles as $groupName => $groupVehicles)
                <div class="mb-5">
                    <h3 style="font-weight: 800; color: #f8fafc; margin-bottom: 25px; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px;">
                        {{ $groupName }}
                    </h3>
                    
                    <div class="row g-4">
                        @foreach($groupVehicles as $vehicle)
                            <div class="col-12 col-md-6 col-xl-4 col-xxl-3">
                                <div class="vehicle-card position-relative" style="background: rgba(16, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; height: 100%; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                                    
                                    <!-- Corner Shape -->
                                    <div style="position: absolute; top: 0; right: 0; width: 120px; height: 120px; background: var(--brand); clip-path: polygon(100% 0, 100% 100%, 80% 100%, 80% 20%, 0 20%, 0 0); z-index: 1; opacity: 0.9;"></div>

                                    @if($loop->first)
                                        <div style="position: absolute; top: 12px; right: 12px; background: #ff9800; color: #fff; font-size: 0.6rem; font-weight: 800; padding: 2px 8px; border-radius: 10px; z-index: 2; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">POPULAR</div>
                                    @endif

                                    <!-- Image Container -->
                                    <div style="height: 180px; position: relative; z-index: 2; padding: 30px; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0) 70%);">
                                        @if($vehicle->image)
                                            <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.5));">
                                        @else
                                            <svg viewBox="0 0 24 24" width="80" height="80" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1.5"><rect x="3" y="10" width="18" height="8" rx="2" ry="2"></rect><path d="M5 10L7 4h10l2 6"></path><circle cx="7" cy="18" r="2"></circle><circle cx="17" cy="18" r="2"></circle></svg>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="p-3 pt-0" style="flex: 1; display: flex; flex-direction: column; z-index: 2;">
                                        
                                        <h4 style="font-weight: 800; color: #ffffff; margin-bottom: 2px; font-size: 1.1rem;">{{ $vehicle->name }}</h4>
                                        <p style="color: var(--brand); font-size: 0.7rem; margin-bottom: 15px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                            CDW, TP, TPL Insurance
                                        </p>
                                        
                                        <!-- Specs Grid -->
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 25px;">
                                            <div class="d-flex align-items-center gap-2" style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;">
                                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="var(--brand)" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                {{ ucfirst($vehicle->gear_system ?? 'Automatic') }}
                                            </div>
                                            <div class="d-flex align-items-center gap-2" style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;">
                                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="var(--brand)" stroke-width="2"><rect x="3" y="10" width="18" height="8" rx="2" ry="2"></rect><path d="M5 10L7 4h10l2 6"></path></svg>
                                                {{ strtoupper($vehicle->wheel_drive ?? 'FWD') }}
                                            </div>
                                            <div class="d-flex align-items-center gap-2" style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;">
                                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="var(--brand)" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                {{ $vehicle->passengers ?? 4 }} Passengers
                                            </div>
                                            <div class="d-flex align-items-center gap-2" style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;">
                                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="var(--brand)" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                                {{ $vehicle->bags ?? 2 }} Bags
                                            </div>
                                        </div>

                                        <div style="margin-top: auto;">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <span style="font-size: 0.65rem; color: #94a3b8; display: block; font-weight: 600; margin-bottom: 0px;">FROM</span>
                                                    <span style="color: var(--brand); font-weight: 800; font-size: 1.15rem;">${{ number_format($vehicle->base_price, 2) }}</span><span style="color: var(--brand); font-size: 0.8rem; font-weight: 700;">/Day</span>
                                                </div>
                                                <div style="text-align: right;">
                                                    <span style="font-size: 0.65rem; color: #94a3b8; display: block; font-weight: 600; margin-bottom: 0px;">Total for {{ $rentalDays }} Days:</span>
                                                    <span style="color: #ffffff; font-weight: 900; font-size: 1.1rem;">${{ number_format($vehicle->total_price, 2) }}</span>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <a href="#" style="font-size: 0.7rem; color: var(--brand); text-decoration: underline; font-weight: 600;">Terms and Conditions</a>
                                                <button onclick="bookNow('{{ $vehicle->id }}')" class="btn" style="background: var(--brand); color: #0b1020; font-weight: 800; padding: 8px 18px; border-radius: 8px; border: none; font-size: 0.75rem; text-transform: uppercase; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.2); transition: all 0.3s;">BOOK NOW</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); padding: 40px; text-align: center; border-radius: 12px; margin-top: 20px;">
                <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="rgba(255, 255, 255, 0.2)" stroke-width="1.5" style="margin-bottom: 15px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <h4 style="color: #f8fafc; margin-bottom: 10px;">No Vehicles Found</h4>
                <p class="text-muted mb-0">No vehicles match your current search criteria. Please try adjusting your filters or dates.</p>
            </div>
        @endif
    </div>

    </div>
</div>
@endsection

@section('js')
<!-- Flatpickr CSS & JS for modern date picker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('input[name="pickup_date"]', {
            dateFormat: "d/m/Y",
            minDate: "today",
            defaultDate: "{{ request('pickup_date', 'today') }}"
        });
        
        let defaultReturn = "{{ request('return_date') }}";
        if (!defaultReturn) {
            defaultReturn = new Date().fp_incr(2);
        }

        flatpickr('input[name="return_date"]', {
            dateFormat: "d/m/Y",
            minDate: "today",
            defaultDate: defaultReturn
        });
    });
    function bookNow(vehicleId) {
        const pDate = document.querySelector('input[name="pickup_date"]');
        const rDate = document.querySelector('input[name="return_date"]');
        const pTime = document.querySelector('select[name="pickup_time"]');
        const rTime = document.querySelector('select[name="return_time"]');
        const pLoc = document.querySelector('select[name="pickup_location"]');
        const rLoc = document.querySelector('select[name="return_location"]');

        const pickupDate = pDate ? pDate.value : '';
        const returnDate = rDate ? rDate.value : '';
        const pickupTime = pTime ? pTime.value : '';
        const returnTime = rTime ? rTime.value : '';
        const pickupLocation = pLoc ? pLoc.value : '';
        const returnLocation = rLoc && rLoc.value !== '' ? rLoc.value : pickupLocation; 

        if (!pickupLocation) {
            alert("Please select a Pick-up Location before booking.");
            return;
        }

        const params = new URLSearchParams({
            pickup_date: pickupDate,
            return_date: returnDate,
            pickup_time: pickupTime,
            return_time: returnTime,
            pickup_location: pickupLocation,
            return_location: returnLocation
        });

        window.location.href = `{{ url('/user/book') }}/${vehicleId}/coverage?` + params.toString();
    }
</script>
@endsection
