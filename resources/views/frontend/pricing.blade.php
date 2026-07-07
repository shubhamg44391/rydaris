@extends('frontend.layout.main')

@section('title', 'Pricing | Rydaris')

@section('content')
  <main>
    <section class="page-hero">
      <div class="wrap">
        <p class="eyebrow">Pricing</p>
        <h1 class="page-title">Plans for every stage of fleet growth.</h1>
        <p class="lead">Choose the operating depth you need today, then expand into advanced reporting, branch controls, integrations, and guided onboarding as your rental business scales.</p>
      </div>
    </section>

    <section class="section light">
      <div class="wrap">
        <div class="grid cols-3">
          @forelse ($packages as $pkg)
            <article class="card pricing-card {{ $pkg->is_featured ? 'featured' : '' }}">
              @if($pkg->eyebrow)
                <p class="eyebrow">{{ $pkg->eyebrow }}</p>
              @endif
              <h2>{{ $pkg->name }}</h2>
              <p>{{ $pkg->description }}</p>
              <div class="price"><strong>{{ $pkg->price }}</strong><span>{{ $pkg->billing_period }}</span></div>
              
              @if((int)$pkg->no_of_users > 0 || (int)$pkg->no_of_coupons > 0 || (int)$pkg->no_of_vehicles > 0 || (int)$pkg->no_of_groups > 0)
                <ul class="list">
                  @if((int)$pkg->no_of_users > 0)
                    <li><span class="check">✓</span><span>{{ $pkg->no_of_users }} Users Included</span></li>
                  @endif
                  @if((int)$pkg->no_of_groups > 0)
                    <li><span class="check">✓</span><span>{{ $pkg->no_of_groups }} Groups Included</span></li>
                  @endif
                  @if((int)$pkg->no_of_vehicles > 0)
                    <li><span class="check">✓</span><span>{{ $pkg->no_of_vehicles }} Vehicles Included</span></li>
                  @endif
                  @if((int)$pkg->no_of_coupons > 0)
                    <li><span class="check">✓</span><span>{{ $pkg->no_of_coupons }} Coupons Included</span></li>
                  @endif
                </ul>
              @endif

              <div class="actions left">
                @if(strtolower($pkg->price) === 'custom' || strtolower($pkg->name) === 'custom' || strtolower($pkg->name) === 'enterprise')
                  <button type="button" class="btn {{ $pkg->is_featured ? 'primary' : 'secondary' }}" onclick="document.getElementById('customPackageModal').style.display='flex'">{{ $pkg->button_text }}</button>
                @elseif(auth()->check() && auth()->user()->role === 'vendor')
                  {{-- Vendor: can buy --}}
                  <button type="button" class="btn {{ $pkg->is_featured ? 'primary' : 'secondary' }}" onclick="openDetailsModal({{ $pkg->id }}, '{{ $pkg->name }}', '{{ $pkg->price }}', '{{ $pkg->billing_period }}')">{{ $pkg->button_text }}</button>
                @elseif(auth()->check())
                  {{-- Logged-in non-vendor: show info --}}
                  <span style="display:inline-flex; align-items:center; gap:6px; font-size:0.82rem; color:#94a3b8; font-style:italic;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Available for Vendors only
                  </span>
                @else
                  {{-- Guest: redirect to login --}}
                  <a class="btn {{ $pkg->is_featured ? 'primary' : 'secondary' }}" href="{{ route('login') }}?redirect_to={{ urlencode(request()->getRequestUri()) }}">{{ $pkg->button_text }}</a>
                @endif
              </div>
            </article>
          @empty
            <p style="grid-column: span 3; text-align: center; color: var(--muted-2);">No pricing plans available.</p>
          @endforelse
        </div>
      </div>
    </section>

    <section class="section soft">
      <div class="wrap">
        <p class="eyebrow">Compare plans</p>
        <h2>Pick the right operational layer.</h2>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Feature</th><th>Launch</th><th>Growth</th><th>Enterprise</th></tr></thead>
            <tbody>
              <tr><td>Fleet dashboard</td><td>Single branch</td><td>Multi-branch</td><td>Advanced regions</td></tr>
              <tr><td>Digital rental agreements</td><td>Included</td><td>Included</td><td>Custom templates</td></tr>
              <tr><td>Inspection records</td><td>Basic</td><td>Photo and damage logs</td><td>Approval workflows</td></tr>
              <tr><td>Reports</td><td>Daily summaries</td><td>Utilization and revenue</td><td>Custom dashboards</td></tr>
              <tr><td>Support</td><td>Email</td><td>Priority</td><td>Dedicated success</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <section class="section dark">
      <div class="wrap">
        <p class="eyebrow">Available add-ons</p>
        <h2>Extend Rydaris when your workflow needs more.</h2>
        <div class="grid cols-3">
          <article class="card feature-card"><h3>Online reservation portal</h3><p>Accept customer inquiries and booking requests from your website with staff approval rules.</p></article>
          <article class="card feature-card"><h3>Accounting connector</h3><p>Sync invoice, payment, tax, and customer balance data into compatible finance systems.</p></article>
          <article class="card feature-card"><h3>Advanced onboarding</h3><p>Data cleanup, workflow mapping, branch setup, staff training, and launch-week support.</p></article>
        </div>
      </div>
    </section>

    <!-- Custom Package Modal -->
    <div id="customPackageModal" class="custom-modal">
      <div class="modal-content">
        <div class="modal-header">
          <h3 style="margin: 0; color: #f8fafc;">Request Custom Package</h3>
          <span class="close-btn" onclick="document.getElementById('customPackageModal').style.display='none'">&times;</span>
        </div>
        
        <form method="POST" action="{{ route('custom-package.submit') }}">
          @csrf
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" required placeholder="Your full name" class="modal-input">
          </div>
          <div class="form-group">
            <label>Company Name</label>
            <input type="text" name="company_name" required placeholder="Your company name" class="modal-input">
          </div>
          <div class="form-group">
            <label>Company Email</label>
            <input type="email" name="email" required placeholder="name@company.com" class="modal-input">
          </div>
          <div class="form-group">
            <label>Contact Details</label>
            <div style="display: flex; gap: 10px;">
              <select name="country_code" class="modal-input" style="width: 35%;" required>
                @include('partials.country-options')
              </select>
              <input type="text" name="contact_details" required placeholder="Phone number" class="modal-input" style="width: 65%;">
            </div>
          </div>
          <div class="form-group">
            <label>Estimated Budget ($)</label>
            <input type="number" name="budget" placeholder="e.g. 5000" class="modal-input">
          </div>
          <div class="form-group" style="grid-column: span 2;">
            <label>Description & Requirements</label>
            <textarea name="description" rows="4" placeholder="Tell us about your fleet size and specific needs..." class="modal-input"></textarea>
          </div>
          <div style="grid-column: span 2; text-align: right; margin-top: 15px;">
            <button type="submit" class="btn primary">Submit Request</button>
          </div>
        </form>
      </div>
    </div>

    <style>
      .custom-modal {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(5, 7, 17, 0.85);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(8px);
      }
      .modal-content {
        background: rgba(11, 16, 32, 0.95);
        border: 1px solid rgba(82, 234, 210, 0.2);
        border-radius: 12px;
        width: 100%;
        max-width: 600px;
        padding: 25px;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.6);
      }
      .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 15px;
      }
      .close-btn {
        color: #94a3b8;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
      }
      .close-btn:hover { color: #f8fafc; }
      .modal-content form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
      }
      .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #a8b3c5;
        font-size: 0.9rem;
      }
      .modal-input {
        width: 100%;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        padding: 12px;
        border-radius: 8px;
        color: #fff;
        font-family: inherit;
      }
      .modal-input:focus {
        border-color: var(--brand);
        outline: none;
        background: rgba(255,255,255,0.08);
      }
      
      @media (max-width: 600px) {
        .modal-content form { grid-template-columns: 1fr; }
        .form-group { grid-column: span 1 !important; }
        .form-group[style*="grid-column: span 2;"] { grid-column: span 1 !important; }
        div[style*="grid-column: span 2;"] { grid-column: span 1 !important; }
      }
    </style>

    <script>
      // Close modal if clicking outside of it
      window.onclick = function(event) {
        const modal = document.getElementById('customPackageModal');
        if (event.target == modal) {
          modal.style.display = "none";
        }
        const confirmModal = document.getElementById('confirmDetailsModal');
        if (event.target == confirmModal) {
          confirmModal.style.display = "none";
        }
      }
    </script>

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
    </script>
  </main>
@endsection
