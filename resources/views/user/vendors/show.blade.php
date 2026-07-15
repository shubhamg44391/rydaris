@extends('user.layouts.app')

@section('main-content')
@php
    $vendorTC = \App\Models\VendorPage::where('vendor_id', $vendor->id)->first();
@endphp
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
            <!-- Branch Filter -->
            @if(isset($branches) && $branches->isNotEmpty())
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-weight: 600; font-size: 0.9rem;">Select Branch</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--brand);">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--brand);"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" /><polyline points="9 22 9 12 15 12 15 22" /></svg>
                        </span>
                        <select name="branch_id" onchange="this.form.submit()"style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; background: rgba(255, 255, 255, 0.05); appearance: none; color: #ffffff;">
                            <option value="" style="background: #0f172a;">All Branches</option>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}" style="background: #0f172a;" {{ (isset($selectedBranchId) && $selectedBranchId == $b->id) ? 'selected' : '' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>
                        
                        <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--brand); pointer-events: none;">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <div class="row g-3 align-items-end">
                
                <!-- Pick-up Location -->
                <div class="col-md-6">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-weight: 500; font-size: 0.9rem;">Pick-up Location</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--brand);">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </span>
                        <select name="pickup_location" id="pickup_location" style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; background: rgba(255, 255, 255, 0.05); appearance: none; color: #ffffff;">
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
            <!-- Pick-up Date & Time -->
                <div class="col-md-4">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-weight: 500; font-size: 0.9rem;">Pick-up Date & Time</label>
                    <div class="d-flex gap-2">
                        <input type="text" name="pickup_date" class="custom-datepicker" placeholder="Select Date" style="flex: 2; padding: 12px; border: 1px solid rgba(255, 255, 255, 0.1) !important; border-radius: 8px; color: #ffffff !important; background: rgba(255, 255, 255, 0.05) !important; outline: none;">
                        <select name="pickup_time" style="flex: 1; min-width: 90px; padding: 12px 8px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; background: #0b1020; color: #ffffff;">
                            @for($i = 0; $i < 24; $i++)
                                @php $hr = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{$hr}}:00" {{ (request('pickup_time') == $hr.':00' || (!request('pickup_time') && $hr == '00')) ? 'selected' : '' }} style="background: #0f172a;">{{$hr}}:00</option>
                                <option value="{{$hr}}:30" {{ request('pickup_time') == $hr.':30' ? 'selected' : '' }} style="background: #0f172a;">{{$hr}}:30</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <!-- Return Location -->
                <div class="col-md-6">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-weight: 500; font-size: 0.9rem;">Return Location</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--brand);">
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </span>
                        <select name="return_location" id="return_location" style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; background: rgba(255, 255, 255, 0.05); appearance: none; color: #ffffff;">
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

                <!-- Rental Type (Hidden) -->
                <input type="hidden" name="rental_type" value="default">

              

                <!-- Return Date & Time -->
                <div class="col-md-4">
                    <label style="display: block; margin-bottom: 8px; color: #f8fafc; font-weight: 500; font-size: 0.9rem;">Return Date & Time</label>
                    <div class="d-flex gap-2">
                        <input type="text" name="return_date" class="custom-datepicker" placeholder="Select Date" style="flex: 2; padding: 12px; border: 1px solid rgba(255, 255, 255, 0.1) !important; border-radius: 8px; color: #ffffff !important; background: rgba(255, 255, 255, 0.05) !important; outline: none;">
                        <select name="return_time" style="flex: 1; min-width: 90px; padding: 12px 8px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; background: #0b1020; color: #ffffff;">
                            @for($i = 0; $i < 24; $i++)
                                @php $hr = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{$hr}}:00" {{ (request('return_time') == $hr.':00' || (!request('return_time') && $hr == '00')) ? 'selected' : '' }} style="background: #0f172a;">{{$hr}}:00</option>
                                <option value="{{$hr}}:30" {{ request('return_time') == $hr.':30' ? 'selected' : '' }} style="background: #0f172a;">{{$hr}}:30</option>
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
                    <label style="display: block; font-size: 0.85rem; color: var(--muted); margin-bottom: 8px;">Transmission</label>
                    <div style="display: flex; gap: 8px;">
                        @php $trans = request('transmission', 'All'); @endphp
                        <a href="{{ request()->fullUrlWithQuery(['transmission' => 'All']) }}" 
                           style="display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s;
                                  {{ $trans === 'All' ? 'background: #52ead2; color: #0b1020;' : 'background: rgba(255,255,255,0.05); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1);' }}"
                           onmouseover="if(this.style.background!=='rgb(82, 234, 210)'){this.style.borderColor='#52ead2'; this.style.color='#52ead2';}"
                           onmouseout="if(this.style.background!=='rgb(82, 234, 210)'){this.style.borderColor='rgba(255,255,255,0.1)'; this.style.color='#cbd5e1';}">
                           All
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['transmission' => 'Automatic']) }}" 
                           style="display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s;
                                  {{ $trans === 'Automatic' ? 'background: #52ead2; color: #0b1020;' : 'background: rgba(255,255,255,0.05); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1);' }}"
                           onmouseover="if(this.style.background!=='rgb(82, 234, 210)'){this.style.borderColor='#52ead2'; this.style.color='#52ead2';}"
                           onmouseout="if(this.style.background!=='rgb(82, 234, 210)'){this.style.borderColor='rgba(255,255,255,0.1)'; this.style.color='#cbd5e1';}">
                           Automatic
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['transmission' => 'Manual']) }}" 
                           style="display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s;
                                  {{ $trans === 'Manual' ? 'background: #52ead2; color: #0b1020;' : 'background: rgba(255,255,255,0.05); color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1);' }}"
                           onmouseover="if(this.style.background!=='rgb(82, 234, 210)'){this.style.borderColor='#52ead2'; this.style.color='#52ead2';}"
                           onmouseout="if(this.style.background!=='rgb(82, 234, 210)'){this.style.borderColor='rgba(255,255,255,0.1)'; this.style.color='#cbd5e1';}">
                           Manual
                        </a>
                    </div>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; color: var(--muted); margin-bottom: 8px;">Price</label>
                    <select class="form-select form-select-sm" onchange="window.location.href=this.value" 
                            style="background: #0d1b2e; color: #cbd5e1; border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 6px 36px 6px 16px; font-size: 0.8rem; font-weight: 600; cursor: pointer; outline: none; transition: border-color 0.2s; appearance: none; background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2352ead2' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e&quot;); background-repeat: no-repeat; background-position: right 12px center; background-size: 10px 10px;">
                        <option value="{{ request()->fullUrlWithQuery(['sort_price' => 'all']) }}" {{ request('sort_price', 'all') === 'all' ? 'selected' : '' }} style="background: #0d1b2e; color: #fff;">All Prices</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort_price' => 'highest']) }}" {{ request('sort_price') === 'highest' ? 'selected' : '' }} style="background: #0d1b2e; color: #fff;">Price: High to Low</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort_price' => 'lowest']) }}" {{ request('sort_price') === 'lowest' ? 'selected' : '' }} style="background: #0d1b2e; color: #fff;">Price: Low to High</option>
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
                                <div class="vehicle-card position-relative" 
                                     style="background: #0d1b2e; border: 1px solid rgba(255, 255, 255, 0.07); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; height: 100%; transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.25s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.3);"
                                     onmouseover="this.style.transform='translateY(-8px) scale(1.03)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.55)';"
                                     onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.3)';"
                                     >

                                    @if($loop->first)
                                        <div style="position: absolute; top: 10px; right: 10px; background: #ff9800; color: #fff; font-size: 0.52rem; font-weight: 800; padding: 2px 6px; border-radius: 6px; z-index: 2; box-shadow: 0 2px 5px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 3px;">
                                            <svg viewBox="0 0 24 24" width="8" height="8" fill="currentColor" stroke="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                            POPULAR
                                        </div>
                                    @endif


                                    <!-- Details Content (Top) -->
                                    <div style="padding: 18px 18px 0px; position: relative; z-index: 2;">
                                        <h4 style="font-weight: 800; color: #ffffff; margin-bottom: 2px; font-size: 1.15rem; text-transform: uppercase; padding-right: 65px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $vehicle->name }}">
                                            {{ $vehicle->name }} 
                                        </h4>


                                        <p style="color: var(--brand); font-size: 0.7rem; margin-bottom: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                            CDW, TP, TPL Insurance
                                        </p>
                                        
                                        <!-- Specs Grid -->
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 15px;">
                                            <div class="d-flex align-items-center gap-2" style="font-size: 0.72rem; color: #cbd5e1; font-weight: 500;">
                                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="var(--brand)" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                {{ ucfirst($vehicle->gear_system ?? 'Automatic') }}
                                            </div>
                                            <div class="d-flex align-items-center gap-2" style="font-size: 0.72rem; color: #cbd5e1; font-weight: 500;">
                                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="var(--brand)" stroke-width="2"><rect x="3" y="10" width="18" height="8" rx="2" ry="2"></rect><path d="M5 10L7 4h10l2 6"></path></svg>
                                                {{ strtoupper($vehicle->wheel_drive ?? 'FWD') }}
                                            </div>
                                            <div class="d-flex align-items-center gap-2" style="font-size: 0.72rem; color: #cbd5e1; font-weight: 500;">
                                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="var(--brand)" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                {{ $vehicle->passengers ?? 4 }} Passengers
                                            </div>
                                            <div class="d-flex align-items-center gap-2" style="font-size: 0.72rem; color: #cbd5e1; font-weight: 500;">
                                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="var(--brand)" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                                {{ $vehicle->bags ?? 2 }} Bags
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Image Container (Center) -->
                                    <div style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 10px 24px; min-height: 160px; background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0) 70%); position: relative; z-index: 2;">
                                        @if($vehicle->image)
                                            <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" style="max-width: 100%; max-height: 150px; object-fit: contain; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.5));">
                                        @else
                                            <svg viewBox="0 0 24 24" width="80" height="80" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1.5"><rect x="3" y="10" width="18" height="8" rx="2" ry="2"></rect><path d="M5 10L7 4h10l2 6"></path><circle cx="7" cy="18" r="2"></circle><circle cx="17" cy="18" r="2"></circle></svg>
                                        @endif
                                    </div>

                                    <!-- Footer & Price (Bottom) -->
                                    <div style="padding: 18px; border-top: 1px solid rgba(255,255,255,0.06); margin-top: auto; z-index: 2;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <span style="font-size: 0.65rem; color: #94a3b8; display: block; font-weight: 600; margin-bottom: 0px;">FROM</span>
                                                <span style="color: #ffffff; font-weight: 800; font-size: 1.25rem;">${{ number_format($vehicle->base_price, 2) }}</span><span style="color: #94a3b8; font-size: 0.85rem; font-weight: 600;">/day</span>
                                            </div>
                                            <div style="text-align: right;">
                                                <span style="font-size: 0.65rem; color: #94a3b8; display: block; font-weight: 600; margin-bottom: 0px;">Total for {{ $rentalDays }} Days:</span>
                                                <span style="color: #ffffff; font-weight: 900; font-size: 1.15rem;">${{ number_format($vehicle->total_price, 2) }}</span>
                                            </div>
                                        </div>

                                        <!-- Centered Book Now Button -->
                                        <div style="display: flex; justify-content: center; width: 100%; margin-top: 18px;">
                                            <button onclick="bookNow('{{ $vehicle->id }}')" class="btn" 
                                                    style="background: linear-gradient(135deg, #52ead2 0%, #00a4e4 100%); color: #0b1020; font-weight: 800; padding: 10px 28px; border-radius: 8px; border: none; font-size: 0.8rem; text-transform: uppercase; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.2); transition: all 0.2s; width: 100%; max-width: 240px; text-align: center;"
                                                    onmouseover="this.style.background='linear-gradient(135deg, #00a4e4 0%, #52ead2 100%)'; this.style.transform='scale(1.02)';"
                                                    onmouseout="this.style.background='linear-gradient(135deg, #52ead2 0%, #00a4e4 100%)'; this.style.transform='scale(1)';">
                                                BOOK NOW
                                            </button>
                                        </div>

                                        <!-- Centered T&C Link -->
                                        <div style="display: flex; justify-content: center; width: 100%; margin-top: 10px;">
                                            @if(!empty($vehicle->terms))
                                                <a href="{{ route('vehicle.terms.public', $vehicle->id) }}" target="_blank" style="font-size: 0.7rem; color: var(--brand); text-decoration: underline; font-weight: 600;">Terms and Conditions</a>
                                            @elseif($vendorTC && !empty($vendorTC->description))
                                                <a href="{{ route('vendor.terms.public', $vehicle->vendor_id) }}" target="_blank" style="font-size: 0.7rem; color: var(--brand); text-decoration: underline; font-weight: 600;">Terms and Conditions</a>
                                            @endif
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
<style>
    /* Custom Flatpickr Teal Highlight styling */
    .flatpickr-calendar {
        background: #0b1020 !important;
        border: 1px solid rgba(82, 234, 210, 0.25) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
    }
    .flatpickr-months .flatpickr-month {
        background: #0b1020 !important;
        color: #f8fafc !important;
    }
    .flatpickr-current-month .numInputWrapper span.arrowUp:after {
        border-bottom-color: var(--brand, #52ead2) !important;
    }
    .flatpickr-current-month .numInputWrapper span.arrowDown:after {
        border-top-color: var(--brand, #52ead2) !important;
    }
    .flatpickr-months .flatpickr-prev-month, .flatpickr-months .flatpickr-next-month {
        color: var(--brand, #52ead2) !important;
        fill: var(--brand, #52ead2) !important;
    }
    .flatpickr-months .flatpickr-prev-month:hover, .flatpickr-months .flatpickr-next-month:hover {
        color: #ffffff !important;
    }
    .flatpickr-day {
        color: #e2e8f0 !important;
    }
    .flatpickr-day.today {
        border-color: rgba(82, 234, 210, 0.4) !important;
    }
    .flatpickr-day.today:hover {
        background: rgba(82, 234, 210, 0.15) !important;
    }
    .flatpickr-day.selected, 
    .flatpickr-day.startRange, 
    .flatpickr-day.endRange, 
    .flatpickr-day.selected.inRange, 
    .flatpickr-day.startRange.inRange, 
    .flatpickr-day.endRange.inRange, 
    .flatpickr-day.selected:focus, 
    .flatpickr-day.startRange:focus, 
    .flatpickr-day.endRange:focus, 
    .flatpickr-day.selected:hover, 
    .flatpickr-day.startRange:hover, 
    .flatpickr-day.endRange:hover, 
    .flatpickr-day.prevMonthDay.selected, 
    .flatpickr-day.nextMonthDay.selected {
        background: var(--brand, #52ead2) !important;
        border-color: var(--brand, #52ead2) !important;
        color: #050711 !important;
        font-weight: 700 !important;
    }
    .flatpickr-day:hover {
        background: rgba(255, 255, 255, 0.08) !important;
    }
    /* Reset styles for flatpickr select dropdown and year inputs */
    .flatpickr-calendar select.flatpickr-monthDropdown-months {
        background: transparent !important;
        border: none !important;
        padding: 2px 6px !important;
        height: auto !important;
        line-height: normal !important;
        color: #f8fafc !important;
        font-size: 1.05rem !important;
        font-weight: 600 !important;
        display: inline-block !important;
        width: auto !important;
        appearance: auto !important;
        -webkit-appearance: auto !important;
        -moz-appearance: auto !important;
        box-shadow: none !important;
    }
    .flatpickr-calendar .numInputWrapper input.cur-year {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        height: auto !important;
        line-height: normal !important;
        color: #f8fafc !important;
        font-size: 1.05rem !important;
        font-weight: 600 !important;
        display: inline-block !important;
        width: auto !important;
        box-shadow: none !important;
    }
    .flatpickr-calendar .flatpickr-current-month {
        font-size: 1.05rem !important;
        font-weight: 600 !important;
        color: #f8fafc !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 5px !important;
        padding: 0 !important;
    }
</style>
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

        // Automatically sync return location selector to match pickup location
        const pickupLocSelect = document.getElementById('pickup_location');
        const returnLocSelect = document.getElementById('return_location');
        if (pickupLocSelect && returnLocSelect) {
            pickupLocSelect.addEventListener('change', function() {
                returnLocSelect.value = this.value;
            });
        }
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
