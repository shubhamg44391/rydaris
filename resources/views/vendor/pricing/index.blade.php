@extends('admin.layouts.app')

@section('main-content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4" style="color: #f8fafc;">
        <span style="color: #aab7cb; font-weight: 300;">Pricing /</span> Current Packages
    </h4>

    <div class="row mb-5">
        @forelse ($packages as $pkg)
        @if(strtolower($pkg->price) === 'custom' || strtolower($pkg->name) === 'custom' || strtolower($pkg->name) === 'enterprise')
            @continue
        @endif
        <div class="col-md-4 mb-4">
            <div class="card h-100" style="background: {{ $pkg->is_featured ? 'rgba(82, 234, 210, 0.05)' : 'rgba(255, 255, 255, 0.02)' }}; border: 1px solid {{ $pkg->is_featured ? 'var(--brand, #52ead2)' : 'rgba(255, 255, 255, 0.05)' }}; border-radius: var(--radius); box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
                <div class="card-body d-flex flex-column" style="padding: 30px;">
                    @if($pkg->eyebrow)
                        <div class="text-uppercase mb-2 small fw-semibold" style="color: var(--brand, #52ead2); letter-spacing: 1px;">{{ $pkg->eyebrow }}</div>
                    @endif
                    
                    <h3 class="card-title mb-3" style="color: #f8fafc; font-weight: 700;">{{ $pkg->name }}</h3>
                    <p class="card-text" style="color: #aab7cb; min-height: 48px; font-size: 0.95rem;">{{ $pkg->description }}</p>
                    
                    <div class="my-4">
                        <span class="display-5 fw-bold" style="color: #f8fafc; font-size: 2.5rem;">{{ $pkg->price }}</span>
                        @if(strtolower($pkg->price) !== 'custom')
                            <span style="color: #aab7cb;">/{{ $pkg->billing_period }}</span>
                        @endif
                    </div>
                    
                    @if((int)$pkg->no_of_users > 0 || (int)$pkg->no_of_coupons > 0 || (int)$pkg->no_of_vehicles > 0 || (int)$pkg->no_of_groups > 0)
                    <ul class="list-unstyled mb-4" style="color: #e2e8f0;">
                        @if((int)$pkg->no_of_users > 0)
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                                {{ $pkg->no_of_users }} Users Included
                            </li>
                        @endif
                        @if((int)$pkg->no_of_groups > 0)
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                                {{ $pkg->no_of_groups }} Groups Included
                            </li>
                        @endif
                        @if((int)$pkg->no_of_vehicles > 0)
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                                {{ $pkg->no_of_vehicles }} Vehicles Included
                            </li>
                        @endif
                        @if((int)$pkg->no_of_coupons > 0)
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                                {{ $pkg->no_of_coupons }} Coupons Included
                            </li>
                        @endif
                    </ul>
                    @endif

                    <div class="mt-auto pt-3">
                        @if(strtolower($pkg->price) === 'custom')
                            <button type="button" onclick="document.getElementById('customPackageModal').style.display='flex'" class="btn w-100" style="padding: 12px; font-weight: 600; border-radius: var(--radius); {{ $pkg->is_featured ? 'background: linear-gradient(135deg, var(--brand, #52ead2), #2bc2a8); color: #050711; border: none;' : 'background: transparent; color: var(--brand, #52ead2); border: 1px solid var(--brand, #52ead2);' }}">
                                {{ $pkg->button_text ?? 'Request Custom Package' }}
                            </button>
                        @else
                            @php
                                $activeSub = auth()->user()->activeSubscription;
                                $isActive = $activeSub && $activeSub->package_id === $pkg->id;
                            @endphp
                            @if($isActive)
                                <button type="button" class="btn w-100" disabled style="padding: 12px; font-weight: 600; border-radius: var(--radius); background: rgba(255,255,255,0.1); color: #aab7cb; border: 1px solid rgba(255,255,255,0.2);">
                                    Current Package
                                </button>
                            @else
                                <button type="button" onclick="openDetailsModal({{ $pkg->id }}, '{{ $pkg->name }}', '{{ $pkg->price }}', '{{ $pkg->billing_period }}')" class="btn w-100" style="padding: 12px; font-weight: 600; border-radius: var(--radius); {{ $pkg->is_featured ? 'background: linear-gradient(135deg, var(--brand, #52ead2), #2bc2a8); color: #050711; border: none;' : 'background: transparent; color: var(--brand, #52ead2); border: 1px solid var(--brand, #52ead2);' }}">
                                    {{ $pkg->button_text ?? 'Subscribe' }}
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center" style="color: #aab7cb; padding: 40px; background: rgba(255,255,255,0.02); border-radius: var(--radius);">
            <p class="mb-0">No pricing plans available at the moment.</p>
        </div>
        @endforelse
    </div>

    {{-- Custom Package Request Modal --}}
    <div id="customPackageModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.85); align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: #111620; border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; width: 100%; max-width: 560px; padding: 28px; box-shadow: 0 20px 60px rgba(0,0,0,0.6); position: relative; font-family: 'Inter', sans-serif; color: #f8fafc;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 15px;">
                <h3 style="margin: 0; font-size: 1.2rem; font-weight: 700; color: #fff;">Request Custom Package</h3>
                <button onclick="document.getElementById('customPackageModal').style.display='none'" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 1.5rem;">&times;</button>
            </div>
            <form method="POST" action="{{ route('custom-package.submit') }}" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                @csrf
                <div>
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->first_name ?? auth()->user()->name }}" required style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Company Name</label>
                    <input type="text" name="company_name" value="{{ auth()->user()->company_name ?? '' }}" required style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" required style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Contact Details</label>
                    <div style="display:flex; gap:8px;">
                        <select name="country_code" required style="width:38%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 8px; border-radius:8px; color:#fff; font-family:inherit;">
                            @include('partials.country-options')
                        </select>
                        <input type="text" name="contact_details" value="{{ auth()->user()->contact_number ?? '' }}" required placeholder="Phone number" style="width:62%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                    </div>
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Estimated Budget (&#8377;)</label>
                    <input type="number" name="budget" placeholder="e.g. 5000" style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Description &amp; Requirements</label>
                    <textarea name="description" rows="4" placeholder="Tell us about your fleet size and specific needs..." style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit; resize:vertical;"></textarea>
                </div>
                <div style="grid-column: span 2; text-align: right; margin-top: 5px;">
                    <button type="button" onclick="document.getElementById('customPackageModal').style.display='none'" style="padding:10px 20px; border-radius:8px; background:transparent; border:1px solid rgba(255,255,255,0.15); color:#94a3b8; font-weight:600; cursor:pointer; margin-right:10px;">Cancel</button>
                    <button type="submit" style="padding:10px 24px; border-radius:8px; background:linear-gradient(135deg, var(--brand,#52ead2), #2bc2a8); color:#050711; border:none; font-weight:700; cursor:pointer;">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Razorpay Checkout SDK -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <!-- Confirm Details Modal (Styled after Razorpay Mockup) -->
    <div id="confirmDetailsModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.85); align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: #111620; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; width: 100%; max-width: 500px; padding: 25px; box-shadow: 0 20px 60px rgba(0,0,0,0.6); position: relative; font-family: 'Inter', sans-serif; color: #f8fafc; text-align: left; box-sizing: border-box;">
            
            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 1.35rem; font-weight: 700; color: #ffffff;">Confirm Your Details</h3>
                <button onclick="closeDetailsModal()" style="background: none; border: none; color: #a0aec0; cursor: pointer; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; padding: 0;">&times;</button>
            </div>

            <!-- Package Details Box -->
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px dashed rgba(255, 255, 255, 0.12); border-radius: 12px; padding: 15px 20px; margin-bottom: 20px; font-size: 0.95rem; line-height: 1.6;">
                <div><span style="color: #a0aec0;">Selected Package:</span> <strong id="modalPackageName" style="color: #ffffff;">Standard</strong></div>
                <div><span style="color: #a0aec0;">Billing Cycle:</span> <strong id="modalBillingCycle" style="color: #ffffff;">Monthly</strong></div>
                <div style="margin-top: 4px; padding-top: 4px; border-top: 1px solid rgba(255,255,255,0.05);"><span style="color: #a0aec0;">Total Price (incl. 18% tax):</span> <strong id="modalTotalPrice" style="color: #ff5429;">₹74,282.82 / Monthly</strong></div>
            </div>

            <!-- Form fields -->
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Full Name *</label>
                    <input type="text" id="custName" value="{{ auth()->check() ? (auth()->user()->first_name . ' ' . auth()->user()->name) : '' }}" readonly style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" />
                </div>

                <div>
                    <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Email Address *</label>
                    <input type="email" id="custEmail" value="{{ auth()->check() ? auth()->user()->email : '' }}" readonly style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" />
                </div>

                <div>
                    <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Confirm Email Address *</label>
                    <input type="email" id="custConfirmEmail" value="{{ auth()->check() ? auth()->user()->email : '' }}" readonly style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" />
                </div>

                <div>
                    <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">WhatsApp Contact Number *</label>
                    <div style="display: flex; gap: 10px;">
                        <select id="custCountryCode" disabled style="padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; width: 110px; cursor: not-allowed; appearance: none; border-color: rgba(255, 255, 255, 0.12);">
                            <option value="{{ auth()->check() ? auth()->user()->country_code : 'IN' }}">{{ auth()->check() ? (auth()->user()->country_code ?? 'IN') : 'IN' }}</option>
                        </select>
                        <input type="text" id="custPhone" value="{{ auth()->check() ? auth()->user()->contact_number : '' }}" readonly style="flex: 1; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" />
                    </div>
                </div>

                <button onclick="proceedToPay()" id="proceedPayBtn" style="width: 100%; margin-top: 10px; padding: 14px; background: #ff5429; color: #ffffff; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <span id="btnText">Proceed to Pay</span>
                    <span id="btnLoader" style="display: none; width: 18px; height: 18px; border: 2px solid #ffffff; border-top: 2px solid transparent; border-radius: 50%; animation: spin 0.8s linear infinite;"></span>
                </button>
            </div>
        </div>
    </div>

    <style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    #proceedPayBtn:hover {
        background: #e0441d;
    }
    </style>

    <script>
    let currentPackageId = null;

    function openDetailsModal(packageId, packageName, packagePrice, billingPeriod) {
        currentPackageId = packageId;
        
        let numericPrice = parseFloat(packagePrice.replace(/[^0-9.]/g, '')) || 0;
        let taxAmount = numericPrice * 0.18;
        let totalPrice = numericPrice + taxAmount;
        
        let currencySymbol = packagePrice.match(/[^0-9.]/)?.[0] || '₹';
        let formattedTotalPrice = currencySymbol + totalPrice.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        
        document.getElementById('modalPackageName').innerText = packageName;
        document.getElementById('modalBillingCycle').innerText = billingPeriod || 'Monthly';
        document.getElementById('modalTotalPrice').innerText = formattedTotalPrice + ' / ' + (billingPeriod || 'Monthly');
        
        document.getElementById('confirmDetailsModal').style.display = 'flex';
    }

    function closeDetailsModal() {
        document.getElementById('confirmDetailsModal').style.display = 'none';
    }

    function proceedToPay() {
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');
        const proceedBtn = document.getElementById('proceedPayBtn');
        
        btnText.innerText = 'Processing...';
        btnLoader.style.display = 'inline-block';
        proceedBtn.disabled = true;
        
        fetch("{{ url('/subscribe/create-order') }}/" + currentPackageId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                if (data.mode === 'razorpay') {
                    var options = {
                        "key": data.key,
                        "amount": data.order.amount,
                        "currency": data.order.currency,
                        "name": "Rydaris",
                        "description": "Package Subscription",
                        "order_id": data.order.id,
                        "handler": function (response){
                            submitPaymentVerification(response, 'razorpay');
                        },
                        "prefill": {
                            "name": document.getElementById('custName').value,
                            "email": document.getElementById('custEmail').value,
                            "contact": document.getElementById('custPhone').value
                        },
                        "theme": {
                            "color": "#ff5429"
                        },
                        "modal": {
                            "ondismiss": function() {
                                resetProceedBtn();
                            }
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                } else if (data.mode === 'free') {
                    // Free plan — no payment needed, activate directly
                    submitPaymentVerification({ package_id: data.package_id }, 'free');
                } else {
                    // Mock/test mode
                    submitPaymentVerification({ package_id: data.package_id }, 'mock');
                }
            } else {
                alert(data.message || 'An error occurred while creating order.');
                resetProceedBtn();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Could not initiate payment. Please try again.');
            resetProceedBtn();
        });
    }

    function submitPaymentVerification(paymentData, mode) {
        let payload = {
            mode: mode,
            package_id: currentPackageId
        };
        
        if (mode === 'razorpay') {
            payload.razorpay_order_id = paymentData.razorpay_order_id;
            payload.razorpay_payment_id = paymentData.razorpay_payment_id;
            payload.razorpay_signature = paymentData.razorpay_signature;
        }
        
        fetch("{{ route('vendor.subscribe.verify') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.href = data.redirect_url;
            } else {
                alert(data.message || 'Verification failed.');
                resetProceedBtn();
            }
        })
        .catch(error => {
            console.error('Verification Error:', error);
            alert('Could not verify payment. Please check your account.');
            resetProceedBtn();
        });
    }

    function resetProceedBtn() {
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');
        const proceedBtn = document.getElementById('proceedPayBtn');
        
        btnText.innerText = 'Proceed to Pay';
        btnLoader.style.display = 'none';
        proceedBtn.disabled = false;
    }

    // Close modal if clicking outside of it
    window.onclick = function(event) {
        const confirmModal = document.getElementById('confirmDetailsModal');
        if (event.target == confirmModal) {
            confirmModal.style.display = "none";
        }
    }
    </script>
</div>
@endsection
