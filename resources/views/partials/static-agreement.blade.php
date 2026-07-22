{{-- Reusable Master Static Rental Agreement Component --}}
<div class="master-agreement-box" style="margin-top: 20px; padding: 24px; border-radius: 12px; font-size: 0.88rem; line-height: 1.6; text-align: left;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--agr-border, rgba(255, 255, 255, 0.1)); padding-bottom: 14px; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h3 class="agr-title" style="margin: 0; font-size: 1.1rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Master Vehicle Rental Agreement
            </h3>
            <span class="agr-ref" style="font-size: 0.75rem;">Ref #AGR-{{ date('Y') }}-{{ isset($booking) ? $booking->reservation_number : rand(1000, 9999) }}</span>
        </div>
        <div class="agr-badge" style="padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
            Legally Binding Policy
        </div>
    </div>

    <!-- PARTIES DETAILS SECTION -->
    <div class="agr-parties-card" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; border-radius: 8px; padding: 16px;">
        
        <!-- User / Renter Details -->
        <div>
            <h4 class="agr-party-head" style="margin: 0 0 8px 0; font-size: 0.88rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; display: flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Renter (Customer) Details
            </h4>
            <div class="agr-details-list" style="font-size: 0.82rem; display: flex; flex-direction: column; gap: 3px;">
                <div><strong class="agr-strong">Full Name:</strong> <span class="agr-val">{{ isset($booking) ? ($booking->customer_fname . ' ' . $booking->customer_lname) : (auth()->user()->name ?? 'Guest Customer') }}</span></div>
                <div><strong class="agr-strong">Contact Number:</strong> <span class="agr-val">{{ isset($booking) ? $booking->customer_phone : (auth()->user()->phone ?? '+918882688646') }}</span></div>
                <div><strong class="agr-strong">Email ID:</strong> <span class="agr-val">{{ isset($booking) ? $booking->customer_email : (auth()->user()->email ?? ($site_setting->contact_email ?? 'support@rydaris.com')) }}</span></div>
            </div>
        </div>

        <!-- Lender / Vendor Details -->
        <div>
            <h4 class="agr-party-head" style="margin: 0 0 8px 0; font-size: 0.88rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; display: flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                Lender (Vehicle Provider) Details
            </h4>
            @php
                $v = isset($booking) ? ($booking->vehicle->vendor ?? null) : null;
                $vName = $v->company_name ?? $v->name ?? 'Rydaris Fleet Operations';
                $vEmail = $v->email ?? ($site_setting->contact_email ?? 'support@rydaris.com');
                $vPhone = $v->phone ?? ($site_setting->contact_phone ?? '+918882688646');
            @endphp
            <div class="agr-details-list" style="font-size: 0.82rem; display: flex; flex-direction: column; gap: 3px;">
                <div><strong class="agr-strong">Provider:</strong> <span class="agr-val">{{ $vName }}</span></div>
                <div><strong class="agr-strong">Contact Number:</strong> <span class="agr-val">{{ $vPhone }}</span></div>
                <div><strong class="agr-strong">Email ID:</strong> <span class="agr-val">{{ $vEmail }}</span></div>
            </div>
        </div>

    </div>

    <!-- TERMS AND CONDITIONS ARTICLES -->
    <div style="margin-bottom: 20px;">
        <h4 class="agr-section-head" style="margin: 0 0 12px 0; font-size: 0.9rem; font-weight: 700;">Terms & Conditions of Vehicle Rental</h4>
        
        <div class="agr-terms-list" style="display: flex; flex-direction: column; gap: 10px; font-size: 0.8rem;">
            <div>
                <strong class="agr-term-num">1. Vehicle Operation & Driver Qualification:</strong> 
                The Renter warrants holding a valid government-issued Driver's License and promises that the vehicle will only be operated by authorized drivers listed in the reservation. Sub-leasing or transferring the vehicle to third parties is strictly prohibited.
            </div>

            <div>
                <strong class="agr-term-num">2. Vehicle Inspection & Fuel Policy:</strong> 
                The Renter acknowledges inspecting the vehicle prior to departure. The vehicle must be returned with the same fuel level as provided at pickup and in a clean condition. Fuel shortages will be charged as per vendor branch rate.
            </div>

            <div>
                <strong class="agr-term-num">3. Security Deposit & Damage Liability:</strong> 
                Any traffic violations, toll charges, towing fees, or accidental physical damages incurred during the rental period are the sole liability of the Renter and will be deducted from the security deposit or billed directly.
            </div>

            <div>
                <strong class="agr-term-num">4. Return Schedule & Late Penalty:</strong> 
                The vehicle must be returned at the agreed return location and time. Overstaying beyond the scheduled return time without prior vendor authorization will incur hourly/daily penalty charges.
            </div>

            <div>
                <strong class="agr-term-num">5. Prohibited Use & Safety Compliance:</strong> 
                Vehicle shall not be used for illegal activities, speed contests, off-road driving, or transporting hazardous materials. Renter agrees to adhere to all municipal and national highway traffic laws.
            </div>
        </div>
    </div>

    <!-- DIGITAL SIGNATURE FOOTER -->
    <div class="agr-footer" style="border-top: 1px dashed var(--agr-border, rgba(255, 255, 255, 0.15)); padding-top: 12px; margin-top: 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; font-size: 0.78rem;">
        <div class="agr-sig" style="display: flex; align-items: center; gap: 8px; font-weight: 700; letter-spacing: 0.03em;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
            Digitally Signed via Rydaris Platform
        </div>
        <div class="agr-hash" style="font-size: 0.72rem;">
            Authentication Hash: <span style="font-family: monospace;">{{ md5(($booking->reservation_number ?? 'static') . (auth()->id() ?? 'guest')) }}</span> | Date: {{ date('M d, Y') }}
        </div>
    </div>

</div>
