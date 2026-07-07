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
            <!-- Step 3 (Active) -->
            <div class="step text-center">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: #ef4444; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);">
                    3
                </div>
                <span style="font-size: 0.75rem; color: #ef4444; font-weight: 800;">Coverage</span>
            </div>
            <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); margin: -20px 15px 0;"></div>
            <!-- Step 4 -->
            <div class="step text-center">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: transparent; border: 1px solid rgba(255, 255, 255, 0.2); color: #94a3b8; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 700;">
                    4
                </div>
                <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Payment</span>
            </div>
            <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); margin: -20px 15px 0;"></div>
            <!-- Step 5 -->
            <div class="step text-center">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: transparent; border: 1px solid rgba(255, 255, 255, 0.2); color: #94a3b8; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 700;">
                    5
                </div>
                <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Confirmed</span>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- Left Column: Coverage & Extras -->
            <div class="col-lg-8">
                
                <!-- Coverage Packages -->
                <div class="card mb-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden;">
                    <div class="card-header border-0 p-4 pb-0" style="background: transparent;">
                        <h4 style="color: #f8fafc; font-weight: 800; font-size: 1.25rem;">Coverage</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table text-light" style="border-collapse: separate; border-spacing: 0;">
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 15px; font-weight: 600; color: #94a3b8; font-size: 0.85rem; width: 40%;">Coverage</th>
                                        @foreach($insurances as $pkg)
                                            <th class="text-center" style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 15px;">
                                                <div style="font-weight: 800; color: #f8fafc; font-size: 0.95rem;">{{ $pkg->name }}</div>
                                                <div style="font-weight: 600; color: var(--brand); font-size: 0.8rem; margin-top: 5px;">
                                                    {{ $pkg->price > 0 ? '$' . number_format($pkg->price, 2) . ' / Day' : 'Included' }}
                                                </div>
                                            </th>
                                        @endforeach
                                        @if($insurances->count() == 0)
                                            <th class="text-center text-muted">Standard Package</th>
                                            <th class="text-center text-muted">Premium Package</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic rows from Vendor Extra Features -->
                                    @php
                                        // If there are no custom features from DB, fallback to dummy data for mockup look
                                        $hasCustomFeatures = $vendorFeatures->count() > 0;
                                        $featuresList = $hasCustomFeatures ? $vendorFeatures : [
                                            (object)['title' => 'Unlimited Kilometers'], (object)['title' => 'Second Additional Driver'], 
                                            (object)['title' => 'Airport Surcharge'], (object)['title' => 'Roadside Assistance'], 
                                            (object)['title' => 'Collision Damage Waiver (CDW)'], (object)['title' => 'Third Party Insurance (TPI)']
                                        ];
                                    @endphp
                                    @foreach($featuresList as $feature)
                                        <tr>
                                            <td style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 15px; color: #cbd5e1; font-size: 0.85rem;">{{ $feature->title }}</td>
                                            @foreach($insurances as $pkg)
                                                @php
                                                    $hasFeature = $hasCustomFeatures ? 
                                                        $featureMappings->where('vendor_extra_id', $pkg->id)->where('vendor_feature_id', $feature->id)->isNotEmpty() : 
                                                        true;
                                                @endphp
                                                <td class="text-center" style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 15px;">
                                                    @if($hasFeature)
                                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--brand)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    @else
                                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#ef4444" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    @endif
                                                </td>
                                            @endforeach
                                            @if($insurances->count() == 0)
                                                <td class="text-center" style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 15px;"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--brand)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                                                <td class="text-center" style="border-bottom: 1px solid rgba(255,255,255,0.05); padding: 15px;"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--brand)" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="padding: 20px 15px;"></td>
                                        @foreach($insurances as $pkg)
                                            <td class="text-center" style="padding: 20px 15px;">
                                                <button class="btn w-100 insurance-btn {{ $loop->first ? 'btn-primary' : 'btn-outline-light' }}" 
                                                    data-id="{{ $pkg->id }}"
                                                    data-price="{{ $pkg->price }}" 
                                                    onclick="selectInsurance(this)"
                                                    style="{{ $loop->first ? 'background: var(--brand); color: #0b1020; border: none;' : 'border-color: rgba(255,255,255,0.2); background: transparent; color: #fff;' }} font-weight: 700; border-radius: 8px; transition: all 0.3s;">
                                                    {{ $loop->first ? 'Selected' : 'Select' }}
                                                </button>
                                            </td>
                                        @endforeach
                                        @if($insurances->count() == 0)
                                            <td class="text-center" style="padding: 20px 15px;"><button class="btn btn-outline-light w-100">Select</button></td>
                                            <td class="text-center" style="padding: 20px 15px;"><button class="btn btn-outline-light w-100">Select</button></td>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Rental Car Equipment -->
                <div class="card" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden;">
                    <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                        <h4 style="color: #f8fafc; font-weight: 800; font-size: 1.25rem;">Rental Car Equipment</h4>
                    </div>
                    <div class="card-body p-0">
                        
                        @forelse($extras as $extra)
                            <div class="equipment-item d-flex align-items-center justify-content-between p-4" style="border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="color: var(--brand);">
                                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    </div>
                                    <div>
                                        <h6 style="color: #f8fafc; font-weight: 700; margin-bottom: 4px; font-size: 0.95rem;">{{ $extra->name }}</h6>
                                        <div style="color: #94a3b8; font-size: 0.75rem;">{{ $extra->description ?? 'Optional equipment for your rental' }}</div>
                                        <div style="color: var(--brand); font-weight: 600; font-size: 0.8rem; margin-top: 4px;">${{ number_format($extra->price, 2) }} / Day</div>
                                    </div>
                                </div>
                                
                                <!-- Quantity Toggle -->
                                <div class="d-flex align-items-center gap-3" style="background: rgba(255,255,255,0.05); padding: 5px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);">
                                    <button type="button" onclick="updateExtraQty('{{ $extra->id }}', -1, {{ $extra->price }})" class="btn btn-sm" style="color: #f8fafc; padding: 2px 10px; font-weight: bold; border-radius: 50%; hover: background: rgba(255,255,255,0.1);">-</button>
                                    <span id="extra-qty-{{ $extra->id }}" style="color: #fff; font-weight: 700; font-size: 0.9rem; min-width: 15px; text-align: center;">0</span>
                                    <button type="button" onclick="updateExtraQty('{{ $extra->id }}', 1, {{ $extra->price }})" class="btn btn-sm" style="color: #f8fafc; padding: 2px 10px; font-weight: bold; border-radius: 50%;">+</button>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-muted">No additional equipment available from this vendor.</div>
                        @endforelse

                    </div>
                </div>
                
                <!-- Bottom Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-5 mb-5">
                    <a href="javascript:history.back()" class="btn btn-outline-light px-5 py-3" style="border-radius: 8px; font-weight: 700; border-color: rgba(255,255,255,0.2);">Back</a>
                    <button onclick="continueToPayment()" class="btn px-5 py-3" style="background: var(--brand); color: #0b1020; border-radius: 8px; font-weight: 800; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.3); border: none;">Continue</button>
                </div>

            </div>

            <!-- Right Column: Summary Sidebar -->
            <div class="col-lg-4">
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
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #94a3b8; font-size: 0.8rem;">Rental Price ({{ $rentalDays }} Days)</span>
                                    <span style="color: #f8fafc; font-weight: 600; font-size: 0.85rem;">${{ number_format($vehicle->total_price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #94a3b8; font-size: 0.8rem; max-width: 75%;">Pickup Location Fee</span>
                                    <span style="color: #f8fafc; font-weight: 600; font-size: 0.85rem;">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #94a3b8; font-size: 0.8rem; max-width: 75%;">Return Location Fee</span>
                                    <span style="color: #f8fafc; font-weight: 600; font-size: 0.85rem;">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #94a3b8; font-size: 0.8rem;">Insurance</span>
                                    <span style="color: #f8fafc; font-weight: 600; font-size: 0.85rem;" id="insurance-cost">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-4">
                                    <span style="color: #94a3b8; font-size: 0.8rem;">Extras</span>
                                    <span style="color: #f8fafc; font-weight: 600; font-size: 0.85rem;" id="extras-cost">$0.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Grand Total -->
                        <div class="p-4" style="background: rgba(82, 234, 210, 0.05); border-top: 1px solid rgba(82, 234, 210, 0.15); display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #f8fafc; font-weight: 800; font-size: 1.1rem;">Total</span>
                            <span style="color: var(--brand); font-weight: 900; font-size: 1.6rem;" id="grand-total">${{ number_format($vehicle->total_price, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Initial values
    const rentalDays = {{ $rentalDays }};
    const baseRentalPrice = {{ $vehicle->total_price }};
    let currentInsurancePrice = 0;
    let currentExtrasPrice = 0;

    function updateTotal() {
        const total = baseRentalPrice + (currentInsurancePrice * rentalDays) + currentExtrasPrice;
        
        // Update DOM
        document.getElementById('insurance-cost').innerText = '$' + (currentInsurancePrice * rentalDays).toFixed(2);
        document.getElementById('extras-cost').innerText = '$' + currentExtrasPrice.toFixed(2);
        document.getElementById('grand-total').innerText = '$' + total.toFixed(2);
    }

    let selectedInsuranceId = null;

    function selectInsurance(btn) {
        // Reset all buttons
        document.querySelectorAll('.insurance-btn').forEach(b => {
            b.classList.remove('btn-primary');
            b.classList.add('btn-outline-light');
            b.style.background = 'transparent';
            b.style.color = '#fff';
            b.style.border = '1px solid rgba(255,255,255,0.2)';
            b.innerText = 'Select';
        });

        // Set active button
        btn.classList.remove('btn-outline-light');
        btn.classList.add('btn-primary');
        btn.style.background = 'var(--brand)';
        btn.style.color = '#0b1020';
        btn.style.border = 'none';
        btn.innerText = 'Selected';

        // Update price and tracking
        currentInsurancePrice = parseFloat(btn.getAttribute('data-price')) || 0;
        selectedInsuranceId = btn.getAttribute('data-id');
        updateTotal();
    }

    // Extras logic
    let extraData = {};
    
    function updateExtraQty(id, change, price) {
        if (!extraData[id]) {
            extraData[id] = { qty: 0, price: price };
        }
        
        let newQty = extraData[id].qty + change;
        if (newQty < 0) newQty = 0;
        
        extraData[id].qty = newQty;
        document.getElementById('extra-qty-' + id).innerText = newQty;
        
        // Recalculate extras total (price * quantity * rentalDays)
        currentExtrasPrice = 0;
        for (const key in extraData) {
            currentExtrasPrice += extraData[key].qty * extraData[key].price * rentalDays;
        }
        updateTotal();
    }

    function continueToPayment() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Add selected insurance
        if (selectedInsuranceId) {
            urlParams.set('insurance_id', selectedInsuranceId);
        }
        
        // Add extras (only those with qty > 0)
        let selectedExtras = [];
        for (const key in extraData) {
            if (extraData[key].qty > 0) {
                selectedExtras.push(key + ':' + extraData[key].qty);
            }
        }
        if (selectedExtras.length > 0) {
            urlParams.set('extras', selectedExtras.join(','));
        }

        window.location.href = `{{ url('/user/book') }}/{{ $vehicle->id }}/information?` + urlParams.toString();
    }

    // Initialize first package on load
    document.addEventListener('DOMContentLoaded', () => {
        const firstBtn = document.querySelector('.insurance-btn');
        if (firstBtn) {
            currentInsurancePrice = parseFloat(firstBtn.getAttribute('data-price')) || 0;
            selectedInsuranceId = firstBtn.getAttribute('data-id');
            updateTotal();
        }
    });
</script>
@endsection
