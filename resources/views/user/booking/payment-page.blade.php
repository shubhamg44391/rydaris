@extends('user.layouts.app')

@section('title', 'Booking Payment')

@section('main-content')
<style>
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
        padding: 12px 24px;
        border-radius: 6px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }
    .btn-teal:hover {
        box-shadow: 0 8px 25px rgba(82, 234, 210, 0.4) !important;
        transform: translateY(-1px);
    }
    .payment-option-card {
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        background: rgba(255, 255, 255, 0.01);
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .payment-option-card:hover {
        border-color: rgba(82, 234, 210, 0.3);
        background: rgba(82, 234, 210, 0.02);
    }
    .payment-option-card.selected {
        border-color: #52ead2;
        background: rgba(82, 234, 210, 0.05);
    }
    .radio-circle {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .payment-option-card.selected .radio-circle {
        border-color: #52ead2;
    }
    .radio-circle::after {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #52ead2;
        display: none;
    }
    .payment-option-card.selected .radio-circle::after {
        display: block;
    }
</style>

<div class="container-fluid p-4" style="min-width: 0; max-width: 100%; overflow-x: hidden;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: #f8fafc; font-weight: 700;">Payment & Order Summary</h4>
            <span style="color: #94a3b8; font-size: 0.9rem;">
                Booking ID: <strong style="color: #52ead2;">{{ $booking->reservation_number }}</strong>
            </span>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary" style="background: rgba(255,255,255,0.1); border: none; color: #f8fafc;">
            <i class="fa fa-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.2); color: #4ade80; border-radius: 8px; margin-bottom: 20px;">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Left Column: Terms & Conditions -->
        <div class="col-lg-6">
            <div class="dark-card p-4">
                <h5 class="section-heading">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    Terms & Conditions
                </h5>
                <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.6;">By proceeding with the payment, you agree to:</p>
                
                <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="background: rgba(82, 234, 210, 0.1); padding: 4px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <div>
                            <span style="color: #f8fafc; font-weight: 600; font-size: 0.9rem; display: block;">The basic terms and conditions</span>
                            <span style="color: #64748b; font-size: 0.8rem;">Standard terms of vehicle usage and return.</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="background: rgba(82, 234, 210, 0.1); padding: 4px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <div>
                            <span style="color: #f8fafc; font-weight: 600; font-size: 0.9rem; display: block;">The security deposit policy</span>
                            <span style="color: #64748b; font-size: 0.8rem;">Holds placed on credit card upon vehicle pickup.</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="background: rgba(82, 234, 210, 0.1); padding: 4px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <div>
                            <span style="color: #f8fafc; font-weight: 600; font-size: 0.9rem; display: block;">The cancellation and refund policy</span>
                            <span style="color: #64748b; font-size: 0.8rem;">Full refund up to 48 hours prior to reservation time.</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <span style="background: rgba(82, 234, 210, 0.1); padding: 4px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <div>
                            <span style="color: #f8fafc; font-weight: 600; font-size: 0.9rem; display: block;">The insurance coverage terms</span>
                            <span style="color: #64748b; font-size: 0.8rem;">Deductibles and collision damage waivers specifications.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Order Summary & Interactive Payment -->
        <div class="col-lg-6">
            <div class="dark-card p-4">
                <h5 class="section-heading">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    Order Summary
                </h5>

                <div class="d-flex align-items-center mb-4 gap-3">
                    @if($booking->vehicle && $booking->vehicle->image)
                        <img src="{{ asset('storage/' . $booking->vehicle->image) }}" alt="{{ $booking->vehicle->name }}" style="max-height: 70px; max-width: 100px; object-fit: contain; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));">
                    @endif
                    <div>
                        <h6 style="color: #f8fafc; font-weight: 700; margin: 0;">{{ $booking->vehicle->name ?? 'N/A' }}</h6>
                        <span style="color: #64748b; font-size: 0.8rem;">
                            {{ date('d M Y', strtotime($booking->pickup_date)) }} - {{ date('d M Y', strtotime($booking->return_date)) }}
                        </span>
                    </div>
                </div>

                @php
                    $diff = \Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->return_date));
                    $rentalDays = $diff > 0 ? $diff : 1;
                    $carAmount = ($booking->vehicle->price_per_day ?? 0) * $rentalDays;
                    
                    $depositPercent = $paymentSettings ? (float)($paymentSettings->deposit_percentage ?? 5) : 5;
                    $discountPercent = $paymentSettings ? (float)($paymentSettings->full_payment_discount ?? 5) : 5;

                    $depositVal = $booking->total_amount * ($depositPercent / 100);
                    $fullVal = $booking->total_amount;
                    if ($booking->payment_status === 'unpaid' || $booking->payment_status === 'pending') {
                        $fullVal = $booking->total_amount * ((100 - $discountPercent) / 100);
                    }
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
                    <span>Initial Method</span>
                    <span style="text-transform: capitalize;">{{ str_replace('_', ' ', $booking->payment_method) }}</span>
                </div>

                <div class="price-row">
                    <span>Paid Amount</span>
                    <span style="color: #52ead2; font-weight: 600;">${{ number_format($booking->paid_amount, 2) }}</span>
                </div>

                <div class="price-row">
                    <span>Pending Amount</span>
                    <span style="color: #f87171; font-weight: 600;">${{ number_format($booking->pending_amount, 2) }}</span>
                </div>

                <div class="price-row total" style="border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 20px;">
                    <span>Total Amount</span>
                    <span>${{ number_format($booking->total_amount, 2) }}</span>
                </div>

                <!-- Payment Status Logic Block -->
                @if($booking->pending_amount <= 0 || $booking->payment_status === 'paid')
                    <!-- 1. FULLY PAID -->
                    <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 8px; padding: 20px; text-align: center;">
                        <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="#22c55e" stroke-width="2" style="margin-bottom: 10px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <h6 style="color: #22c55e; font-weight: 700; margin: 0 0 4px;">Payment Completed</h6>
                        <p style="color: #94a3b8; font-size: 0.8rem; margin: 0;">This booking is fully paid. No further payments are required.</p>
                    </div>
                @else
                    <!-- 2. NOT FULLY PAID -->
                    <form action="{{ route('user.bookings.payment-page.submit', $booking->id) }}" method="POST" id="paymentForm">
                        @csrf
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block; margin-bottom: 12px; font-weight: 600; text-transform: uppercase;">Select Payment Option</span>

                        <!-- OPTION A: 5% Deposit -->
                        @if($booking->payment_status === 'unpaid' || $booking->payment_status === 'pending')
                            <div class="payment-option-card selected" onclick="selectPaymentOption(this, 'deposit')">
                                <div class="radio-circle"></div>
                                <div style="flex-grow: 1;">
                                    <span style="color: #f8fafc; font-weight: 700; font-size: 0.95rem; display: flex; justify-content: space-between;">
                                        <span>Pay {{ $depositPercent }}% Deposit Now</span>
                                        <span style="color: #52ead2;">${{ number_format($depositVal, 2) }}</span>
                                    </span>
                                    <span style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 2px;">Pay ${{ number_format($depositVal, 2) }} deposit now, pay rest on arrival.</span>
                                </div>
                            </div>
                        @endif

                        <!-- OPTION B: Full Payment -->
                        <div class="payment-option-card {{ ($booking->payment_status === 'partial_paid') ? 'selected' : '' }}" onclick="selectPaymentOption(this, 'full')">
                            <div class="radio-circle"></div>
                            <div style="flex-grow: 1;">
                                <span style="color: #f8fafc; font-weight: 700; font-size: 0.95rem; display: flex; justify-content: space-between;">
                                    <span>Pay Full Amount Now</span>
                                    <span style="color: #52ead2;">${{ number_format($booking->pending_amount, 2) }}</span>
                                </span>
                                @if($booking->payment_status === 'unpaid' || $booking->payment_status === 'pending')
                                    <span style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 2px;">Pay full amount now and get {{ $discountPercent }}% discount.</span>
                                @else
                                    <span style="color: #64748b; font-size: 0.8rem; display: block; margin-top: 2px;">Pay remaining balance of ${{ number_format($booking->pending_amount, 2) }} now.</span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="payment_choice" id="payment_choice" value="{{ ($booking->payment_status === 'partial_paid') ? 'full' : 'deposit' }}">
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="">

                        <div style="margin-top: 24px;">
                            <button type="submit" class="btn btn-teal">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                Pay Now
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@if(isset($paymentSettings) && !empty($paymentSettings->razorpay_key))
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endif

<script>
    function selectPaymentOption(element, value) {
        // Deselect all options
        document.querySelectorAll('.payment-option-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        // Select the clicked option
        element.classList.add('selected');
        
        // Update the hidden input value
        document.getElementById('payment_choice').value = value;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const paymentForm = document.getElementById('paymentForm');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(e) {
                @if(isset($paymentSettings) && !empty($paymentSettings->razorpay_key))
                    e.preventDefault();
                    
                    const choice = document.getElementById('payment_choice').value;
                    let amountToPay = 0;
                    
                    if (choice === 'deposit') {
                        amountToPay = {{ $depositVal }};
                    } else {
                        amountToPay = {{ $booking->payment_status === 'partial_paid' ? $booking->pending_amount : $fullVal }};
                    }
                    
                    const options = {
                        "key": "{{ $paymentSettings->razorpay_key }}",
                        "amount": Math.round(amountToPay * 100), // in paise
                        "currency": "USD",
                        "name": "{{ $booking->vendor->name ?? 'Vendor' }}",
                        "description": "Booking Payment #{{ $booking->reservation_number }}",
                        "image": "{{ $booking->vehicle && $booking->vehicle->image ? asset('storage/' . $booking->vehicle->image) : '' }}",
                        "handler": function (response){
                            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                            paymentForm.submit();
                        },
                        "prefill": {
                            "name": "{{ $booking->customer_fname }} {{ $booking->customer_lname }}",
                            "email": "{{ $booking->customer_email }}",
                            "contact": "{{ $booking->customer_phone }}"
                        },
                        "theme": {
                            "color": "#52ead2"
                        }
                    };
                    const rzp = new Razorpay(options);
                    rzp.open();
                @endif
            });
        }
    });
</script>
@endsection
