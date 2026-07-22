@extends('user.layouts.app')

@section('main-content')
<div class="booking-coverage-page" style="padding: 30px; min-height: 100vh;">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto;">
        
        
        <div class="stepper-wrapper mb-5" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 25px; display: flex; justify-content: space-between; align-items: center; max-width: 800px; margin: 0 auto 40px;">
            
            <div class="step text-center">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: rgba(82, 234, 210, 0.1); border: 1px solid var(--brand); color: var(--brand); display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 700;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <span style="font-size: 0.75rem; color: var(--brand); font-weight: 600;">Search</span>
            </div>
            <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); margin: -20px 15px 0;"></div>
            
            <div class="step text-center">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: rgba(82, 234, 210, 0.1); border: 1px solid var(--brand); color: var(--brand); display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 700;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <span style="font-size: 0.75rem; color: var(--brand); font-weight: 600;">Car Listing</span>
            </div>
            <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); margin: -20px 15px 0;"></div>
            
            <div class="step text-center">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: rgba(82, 234, 210, 0.1); border: 1px solid var(--brand); color: var(--brand); display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 700;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <span style="font-size: 0.75rem; color: var(--brand); font-weight: 600;">Coverage</span>
            </div>
            <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); margin: -20px 15px 0;"></div>
            
            <div class="step text-center" id="stepper-step-4">
                <div style="width: 35px; height: 35px; border-radius: 50%; background: rgba(82, 234, 210, 0.1); border: 1px solid var(--brand); color: var(--brand); display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 700;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <span style="font-size: 0.75rem; color: var(--brand); font-weight: 600;">Information</span>
            </div>
            <div style="flex: 1; height: 1px; background: rgba(255, 255, 255, 0.1); margin: -20px 15px 0;"></div>
            
            <div class="step text-center" id="stepper-step-5">
                <div class="stepper-circle" style="width: 35px; height: 35px; border-radius: 50%; background: var(--brand); color: #0b1020; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: 800; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.3);">
                    5
                </div>
                <span class="stepper-text" style="font-size: 0.75rem; color: var(--brand); font-weight: 800;">Payment</span>
            </div>
        </div>

        <div class="row g-4">
            
            
            <div class="col-lg-8">
                
                
                
                <div id="step-5-content" style="animation: fadeIn 0.4s ease forwards;">
                    <div class="card mb-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px; overflow: hidden;">
                        <div class="card-header border-0 p-4 pb-2" style="background: transparent;">
                            <h4 style="color: #f8fafc; font-weight: 800; font-size: 1.4rem;">Payment Information</h4>
                            <p style="color: #94a3b8; font-weight: 600; font-size: 1rem; margin-top: 15px; margin-bottom: 0;">Select Payment Method</p>
                        </div>
                        <div class="card-body p-4 pt-2">
                            @php
                                $showArrival = true;
                                $showDeposit = true;
                                $depositPercent = 5;
                                $showFull = true;
                                $fullDiscountPercent = 5;
                                $razorpayConfigured = false;

                                if (isset($paymentSettings)) {
                                    $showArrival = (bool)$paymentSettings->pay_on_arrival;
                                    $showDeposit = (bool)$paymentSettings->pay_deposit;
                                    $depositPercent = (float)($paymentSettings->deposit_percentage ?? 5);
                                    $showFull = (bool)$paymentSettings->pay_full;
                                    $fullDiscountPercent = (float)($paymentSettings->full_payment_discount ?? 5);
                                    
                                    if (!empty($paymentSettings->razorpay_key) && !empty($paymentSettings->razorpay_secret)) {
                                        $razorpayConfigured = true;
                                    }
                                }

                                $checkedMethod = '';
                                if ($showArrival) {
                                    $checkedMethod = 'arrival';
                                } elseif ($showDeposit && $razorpayConfigured) {
                                    $checkedMethod = 'deposit';
                                } elseif ($showFull && $razorpayConfigured) {
                                    $checkedMethod = 'full';
                                }
                            @endphp
                            
                            @if(!$razorpayConfigured && ($showDeposit || $showFull))
                            <div class="alert alert-warning mb-4" style="background: rgba(245, 184, 92, 0.1); border: 1px solid rgba(245, 184, 92, 0.3); color: #f5b85c; border-radius: 8px;">
                                <strong>Notice:</strong> Online payment is currently not configured for this vehicle. Please contact the client/vendor to proceed with online payments, or choose "Pay on Arrival" if available.
                            </div>
                            @endif
                            
                            
                            @if($showArrival)
                            <label class="payment-method-card mb-3" style="display: block; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 20px; cursor: pointer; transition: all 0.2s;">
                                <div class="d-flex align-items-start">
                                    <div style="margin-right: 15px; margin-top: 2px;">
                                        <input type="radio" name="payment_method" value="arrival" {{ $checkedMethod === 'arrival' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--brand);">
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h5 style="color: #f8fafc; font-weight: 700; margin: 0; font-size: 1rem;">Pay on Arrival</h5>
                                            <span style="color: #52ead2; font-weight: 800; font-size: 1.1rem;">${{ number_format($grandTotal, 2) }}</span>
                                        </div>
                                        <p style="color: #94a3b8; margin: 0; font-size: 0.85rem;">Pay when you pick up the vehicle</p>
                                    </div>
                                </div>
                            </label>
                            @endif

                            
                            @if($showDeposit)
                            @php
                                $depositAmount = $grandTotal * ($depositPercent / 100);
                            @endphp
                            <label class="payment-method-card mb-3" style="display: block; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 20px; cursor: pointer; transition: all 0.2s;">
                                <div class="d-flex align-items-start">
                                    <div style="margin-right: 15px; margin-top: 2px;">
                                        <input type="radio" name="payment_method" value="deposit" {{ $checkedMethod === 'deposit' ? 'checked' : '' }} {{ !$razorpayConfigured ? 'disabled' : '' }} style="width: 18px; height: 18px; accent-color: var(--brand);">
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h5 style="color: #f8fafc; font-weight: 700; margin: 0; font-size: 1rem;">Pay {{ $depositPercent }}% Deposit Now</h5>
                                            <span style="color: #52ead2; font-weight: 800; font-size: 1.1rem;">${{ number_format($depositAmount, 2) }} ({{ $depositPercent }}%)</span>
                                        </div>
                                        <p style="color: #94a3b8; margin: 0; font-size: 0.85rem;">Pay {{ $depositPercent }}% deposit now (${{ number_format($depositAmount, 2) }}), pay rest on arrival.</p>
                                    </div>
                                </div>
                            </label>
                            @endif

                            
                            @if($showFull)
                            @php
                                $discountMultiplier = (100 - $fullDiscountPercent) / 100;
                                $discountedAmount = $grandTotal * $discountMultiplier;
                            @endphp
                            <label class="payment-method-card mb-4" style="display: block; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 20px; cursor: pointer; transition: all 0.2s;">
                                <div class="d-flex align-items-start">
                                    <div style="margin-right: 15px; margin-top: 2px;">
                                        <input type="radio" name="payment_method" value="full" {{ $checkedMethod === 'full' ? 'checked' : '' }} {{ !$razorpayConfigured ? 'disabled' : '' }} style="width: 18px; height: 18px; accent-color: var(--brand);">
                                    </div>
                                    <div style="flex: 1;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h5 style="color: #f8fafc; font-weight: 700; margin: 0; font-size: 1rem;">Pay Full Amount Now</h5>
                                            <span style="color: #52ead2; font-weight: 800; font-size: 1.1rem;">${{ number_format($discountedAmount, 2) }} ({{ $fullDiscountPercent }}% Off)</span>
                                        </div>
                                        <p style="color: #94a3b8; margin: 0; font-size: 0.85rem;">Pay full amount now (${{ number_format($discountedAmount, 2) }}) and get {{ $fullDiscountPercent }}% discount, pay nothing on arrival. Security deposit will be required at the rental desk.</p>
                                    </div>
                                </div>
                            </label>
                            @endif

                            
                            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; margin-bottom: 18px; user-select: none;">
                                <input type="checkbox" id="termsCheckbox" style="width: 18px; height: 18px; flex-shrink: 0; accent-color: var(--brand); cursor: pointer;">
                                <span style="color: #f8fafc; font-size: 0.9rem; font-weight: 600; white-space: nowrap;">I agree to the <a href="{{ route('vendor.terms.public', $vehicle->vendor_id) }}" target="_blank" style="color: var(--brand); text-decoration: underline;">Terms &amp; Conditions</a></span>
                            </label>

                            
                            <div style="background: rgba(245, 184, 92, 0.1); border: 1px solid rgba(245, 184, 92, 0.3); border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                                <p style="color: #f5b85c; margin: 0; font-size: 0.85rem; font-weight: 700;">Local Test Mode: Google reCAPTCHA validation is bypassed on localhost.</p>
                            </div>

                            <div style="background: rgba(255, 255, 255, 0.03); border-left: 4px solid var(--brand-2); border-radius: 8px; padding: 15px; margin-bottom: 30px;">
                                <div class="d-flex gap-3">
                                    <div style="color: var(--brand-2);">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                    </div>
                                    <div>
                                        <h6 style="color: #f8fafc; font-size: 0.9rem; font-weight: 700; margin-bottom: 5px;">Pay on Arrival Instructions:</h6>
                                        <p style="color: #94a3b8; font-size: 0.85rem; margin: 0;">You'll pay the total amount of <strong style="color: #fff;">${{ number_format($grandTotal, 2) }}</strong> when you pick up your vehicle at <strong style="color: #fff;">{{ $pickupLocation ? $pickupLocation->location : 'Selected Location' }}</strong>. Please bring your driving license and the credit card used for booking.</p>
                                    </div>
                                </div>
                            </div>

                            
                            <button type="button" onclick="confirmBooking()" class="btn w-100 py-3" style="background: linear-gradient(135deg, #52ead2 0%, #00a4e4 100%); color: #0b1020; font-weight: 800; font-size: 1.1rem; border-radius: 8px; border: none; box-shadow: 0 8px 25px rgba(82, 234, 210, 0.3); text-transform: uppercase; letter-spacing: 1px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 10px 30px rgba(82, 234, 210, 0.45)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 25px rgba(82, 234, 210, 0.3)'">
                                Confirm Booking
                            </button>
                            
                            
                            <div class="d-flex justify-content-center align-items-center gap-3 mt-4">
                                <span style="color: #94a3b8; font-size: 0.85rem; font-weight: 600;">We accept:</span>
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <img src="{{ asset('assets/logo/VISA-logo.png') }}" alt="Visa" style="height: 24px; width: auto; display: block;">
                                    <img src="{{ asset('assets/logo/Mastercard-logo.png') }}" alt="Mastercard" style="height: 24px; width: auto; display: block;">
                                    <img src="{{ asset('assets/logo/American_Express_logo.svg') }}" alt="Amex" style="height: 24px; width: auto; display: block;">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            
            <div class="col-lg-4" id="sidebar-summary-box">
                <div class="summary-sidebar sticky-top" style="top: 20px;">
                    <div class="card" style="background: rgba(16, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                        
                        
                        <div style="background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 70%); height: 160px; display: flex; align-items: center; justify-content: center; padding: 20px;">
                            @if($vehicle->image)
                                <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.5));">
                            @endif
                        </div>
                        
                        
                        <div class="p-4 pb-0">
                            <h3 style="font-weight: 800; color: #ffffff; font-size: 1.4rem;">{{ $vehicle->name }}</h3>
                        </div>

                        
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

                        
                        <div class="p-4" style="background: rgba(82, 234, 210, 0.05); border-top: 1px solid rgba(82, 234, 210, 0.15); display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #f8fafc; font-weight: 800; font-size: 1.1rem;">Total Amount</span>
                            <span style="color: #52ead2; font-weight: 900; font-size: 1.4rem;">${{ number_format($grandTotal, 2) }}</span>
                        </div>
                        
                        
                        <div id="step-5-summary-additions" style="background: rgba(82, 234, 210, 0.02); padding: 15px 24px; border-top: 1px dashed rgba(255,255,255,0.1);">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span style="color: #94a3b8; font-size: 0.9rem; font-weight: 600;">Paid Now (5%)</span>
                                <span style="color: #52ead2; font-weight: 800; font-size: 1rem;">${{ number_format($grandTotal * 0.05, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #94a3b8; font-size: 0.9rem; font-weight: 600;">Pending on Arrival</span>
                                <span style="color: #52ead2; font-weight: 800; font-size: 1rem;">${{ number_format($grandTotal * 0.95, 2) }}</span>
                            </div>
                        </div>

                        @php
                            $activeCoupons = [];
                            if($vehicle->vendor && $vehicle->vendor->hasCouponFeature()) {
                                $activeCoupons = App\Models\Coupon::where('vendor_id', $vehicle->vendor_id)
                                    ->whereDate('valid_from', '<=', now())
                                    ->whereDate('valid_to', '>=', now())
                                    ->get();
                            }
                        @endphp

                        @if(count($activeCoupons) > 0)
                            
                            <div id="coupon-box" class="p-4 border-top" style="display: none; border-color: rgba(255,255,255,0.05) !important;">
                                <label style="color: #f8fafc; font-size: 0.85rem; font-weight: 700; margin-bottom: 8px; display: block;">Apply Coupon</label>
                                <div class="d-flex gap-2">
                                    <select class="form-select form-select-sm" id="coupon_code_select" style="max-width: 200px;">
                                        <option value="">Select a coupon</option>
                                        @foreach($activeCoupons as $coupon)
                                            <option value="{{ $coupon->code }}" data-discount="{{ $coupon->discount }}" data-type="{{ $coupon->type }}">
                                                {{ $coupon->code }} - {{ $coupon->type == 'percentage' ? $coupon->discount.'%' : '$'.$coupon->discount }} off
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-outline-light" onclick="applyCoupon()" style="font-size: 0.8rem;">Apply</button>
                                </div>
                                <div id="coupon-message" class="mt-2 small" style="display:none;"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Radio Card Selection Highlight Logic
        document.querySelectorAll('.payment-method-card input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Reset all borders
                document.querySelectorAll('.payment-method-card').forEach(card => {
                    card.style.borderColor = 'rgba(255,255,255,0.1)';
                    card.style.background = 'rgba(255,255,255,0.03)';
                });
                // Highlight selected
                if(this.checked) {
                    this.closest('.payment-method-card').style.borderColor = 'var(--brand)';
                    this.closest('.payment-method-card').style.background = 'rgba(82, 234, 210, 0.05)';
                }
            });
        });
        
        // Trigger initial state
        const activeRadio = document.querySelector('.payment-method-card input[type="radio"]:checked');
        if (activeRadio) {
            activeRadio.dispatchEvent(new Event('change'));
        }
    });

    function confirmBooking() {
        const termsCheckbox = document.getElementById('termsCheckbox');
        if (!termsCheckbox.checked) {
            Swal.fire({
                icon: 'error',
                title: 'Terms Required',
                text: 'Please agree to the terms and conditions to proceed with the booking.',
                background: 'rgba(11, 16, 32, 0.95)'
            });
            return;
        }

        const methodEl = document.querySelector('.payment-method-card input[type="radio"]:checked');
        const paymentMethod = methodEl ? methodEl.value : '';
        
        if (!paymentMethod) {
            Swal.fire({
                icon: 'error',
                title: 'Payment Method Required',
                text: 'Please select a payment method.',
                background: 'rgba(11, 16, 32, 0.95)'
            });
            return;
        }

        // Determine the amount to pay online if applicable
        let amountToPay = 0;
        let isOnlinePayment = false;

        if (paymentMethod === 'deposit') {
            amountToPay = {{ isset($depositAmount) ? $depositAmount : 0 }};
            isOnlinePayment = true;
        } else if (paymentMethod === 'full') {
            amountToPay = {{ isset($discountedAmount) ? $discountedAmount : 0 }};
            isOnlinePayment = true;
        }

        if (isOnlinePayment) {
            @if(isset($paymentSettings) && !empty($paymentSettings->razorpay_key))
            const options = {
                "key": "{{ $paymentSettings->razorpay_key }}",
                "amount": Math.round(amountToPay * 100), // Amount in paise
                "currency": "USD",
                "name": "{{ $vehicle->vendor->name ?? 'Vendor' }}",
                "description": "Booking Payment - {{ $vehicle->name }}",
                "image": "{{ asset('storage/' . $vehicle->image) }}",
                "handler": function (response){
                    // Append Razorpay Payment ID to form and submit
                    submitBookingForm(paymentMethod, response.razorpay_payment_id);
                },
                "prefill": {
                    "name": "{{ request('fname') }} {{ request('lname') }}",
                    "email": "{{ request('email') }}",
                    "contact": "{{ request('phone') }}"
                },
                "theme": {
                    "color": "#52ead2"
                }
            };
            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response){
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Failed',
                    text: response.error.description,
                    background: 'rgba(11, 16, 32, 0.95)'
                });
            });
            rzp.open();
            @else
            Swal.fire({
                icon: 'error',
                title: 'Gateway Error',
                text: 'Vendor payment gateway is not properly configured.',
                background: 'rgba(11, 16, 32, 0.95)'
            });
            @endif
        } else {
            submitBookingForm(paymentMethod, null);
        }
    }

    function submitBookingForm(paymentMethod, razorpayPaymentId = null) {
        // Create a form dynamically to POST all data
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('/user/book') }}/{{ $vehicle->id }}/store`;

        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Add all URL parameters to the form
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('payment_method', paymentMethod);
        
        for (const [key, value] of urlParams.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }

        // Add total price
        const totalInput = document.createElement('input');
        totalInput.type = 'hidden';
        totalInput.name = 'total_price';
        totalInput.value = '{{ $grandTotal }}';
        form.appendChild(totalInput);

        if (razorpayPaymentId) {
            const rzpInput = document.createElement('input');
            rzpInput.type = 'hidden';
            rzpInput.name = 'razorpay_payment_id';
            rzpInput.value = razorpayPaymentId;
            form.appendChild(rzpInput);
        }

        document.body.appendChild(form);
        form.submit();
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
