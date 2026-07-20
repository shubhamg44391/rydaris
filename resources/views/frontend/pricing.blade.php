@extends('frontend.layout.main')

@section('title', $seo_title ?? 'Pricing | Rydaris')

@section('content')
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/boxicons.css') }}" />
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
            @php
              $isFree = str_contains(strtolower($pkg->price), 'free') || str_contains($pkg->price, '0') || strtolower($pkg->name) === 'free';
            @endphp
            <article class="pricing-card {{ $pkg->is_featured ? 'featured' : '' }} {{ $isFree ? 'free-package' : '' }}">
              @if($pkg->eyebrow)
                <p class="eyebrow">{{ $pkg->eyebrow }}</p>
              @endif
              <h2>{{ $pkg->name }}</h2>
              <p>{{ $pkg->description }}</p>
              <div class="price">
                <strong id="pkg-price-{{ $pkg->id }}" data-raw-price="{{ $pkg->price }}">{{ $pkg->price }}</strong>
                @if(strtolower($pkg->price) !== 'custom' && strtolower($pkg->price) !== 'enterprise' && !empty($pkg->billing_period))
                  <span>{{ $pkg->billing_period }}</span>
                @endif
              </div>
              
                <ul class="list">
                  @if($pkg->booking_menu)
                    @if($pkg->no_of_bookings !== null && (int)$pkg->no_of_bookings === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Bookings Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_bookings !== null ? ($pkg->no_of_bookings . ' Bookings Included') : 'Unlimited Bookings' }}</span></li>
                    @endif
                  @endif

                  @if($pkg->vehicles_menu)
                    @if($pkg->no_of_vehicles !== null && (int)$pkg->no_of_vehicles === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Vehicles Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_vehicles !== null ? ($pkg->no_of_vehicles . ' Vehicles Included') : 'Unlimited Vehicles' }}</span></li>
                    @endif

                    @if($pkg->no_of_groups !== null && (int)$pkg->no_of_groups === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Groups Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_groups !== null ? ($pkg->no_of_groups . ' Groups Included') : 'Unlimited Groups' }}</span></li>
                    @endif
                  @endif

                  @if($pkg->locations_menu)
                    @if($pkg->no_of_locations !== null && (int)$pkg->no_of_locations === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Locations Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_locations !== null ? ($pkg->no_of_locations . ' Locations Included') : 'Unlimited Locations' }}</span></li>
                    @endif
                  @endif

                  @if($pkg->customers_menu)
                    @if($pkg->no_of_users !== null && (int)$pkg->no_of_users === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Customers Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_users !== null ? ($pkg->no_of_users . ' Customers Included') : 'Unlimited Customers' }}</span></li>
                    @endif

                    @if($pkg->no_of_invitations !== null && (int)$pkg->no_of_invitations === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Invitations Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_invitations !== null ? ($pkg->no_of_invitations . ' Invitations Included') : 'Unlimited Invitations' }}</span></li>
                    @endif
                  @endif

                  @if($pkg->fleet_management_menu)
                    <li><span class="check">✓</span><span>Fleet Management Included</span></li>
                  @endif

                  @if($pkg->extras_menu)
                    @if($pkg->no_of_extras !== null && (int)$pkg->no_of_extras === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Extras Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_extras !== null ? ($pkg->no_of_extras . ' Extras Included') : 'Unlimited Extras' }}</span></li>
                    @endif

                    @if($pkg->no_of_insurances !== null && (int)$pkg->no_of_insurances === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Insurances Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_insurances !== null ? ($pkg->no_of_insurances . ' Insurances Included') : 'Unlimited Insurances' }}</span></li>
                    @endif

                    @if($pkg->no_of_features !== null && (int)$pkg->no_of_features === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Features Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_features !== null ? ($pkg->no_of_features . ' Features Included') : 'Unlimited Features' }}</span></li>
                    @endif

                    @if($pkg->no_of_rules !== null && (int)$pkg->no_of_rules === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Rules Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_rules !== null ? ($pkg->no_of_rules . ' Rules Included') : 'Unlimited Rules' }}</span></li>
                    @endif
                  @endif

                  @if($pkg->coupons_menu)
                    @if($pkg->no_of_coupons !== null && (int)$pkg->no_of_coupons === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Coupons Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_coupons !== null ? ($pkg->no_of_coupons . ' Coupons Included') : 'Unlimited Coupons' }}</span></li>
                    @endif
                  @endif

                  @if($pkg->support_ticket_menu)
                    @if($pkg->no_of_support_tickets !== null && (int)$pkg->no_of_support_tickets === 0)
                      <li><i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold; vertical-align: middle; margin-right: 8px;"></i><span style="color: #94a3b8;">Support Tickets Not Included</span></li>
                    @else
                      <li><span class="check">✓</span><span>{{ $pkg->no_of_support_tickets !== null ? ($pkg->no_of_support_tickets . ' Support Tickets Included') : 'Unlimited Support Tickets' }}</span></li>
                    @endif
                  @endif

                  @if($pkg->settings_menu)
                    <li><span class="check">✓</span><span>System Settings Access</span></li>
                  @endif
                </ul>

              <div class="actions" style="margin-top: auto; padding-top: 24px; display: flex; justify-content: center; width: 100%;">
                @if(strtolower($pkg->price) === 'custom' || strtolower($pkg->name) === 'custom' || strtolower($pkg->name) === 'enterprise')
                  <button type="button" class="btn primary" style="width: 100%; max-width: 240px; padding: 14px 28px; font-size: 1.05rem;" onclick="document.getElementById('customPackageModal').style.display='flex'">{{ $pkg->button_text }}</button>
                @elseif(auth()->check() && auth()->user()->role === 'vendor')
                  
                  <button type="button" id="buy-btn-{{ $pkg->id }}" class="btn primary" style="width: 100%; max-width: 240px; padding: 14px 28px; font-size: 1.05rem;" onclick="openDetailsModal({{ $pkg->id }}, '{{ $pkg->name }}', '{{ $pkg->price }}', '{{ $pkg->billing_period }}')">{{ $pkg->button_text }}</button>
                @elseif(auth()->check())
                  
                  <span style="display:inline-flex; align-items:center; gap:6px; font-size:0.88rem; color:#94a3b8; font-style:italic;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Available for Vendors only
                  </span>
                @else
                  
                  <a class="btn primary" style="width: 100%; max-width: 240px; padding: 14px 28px; font-size: 1.05rem;" href="{{ route('vendor.register') }}?package_id={{ $pkg->id }}">{{ $pkg->button_text }}</a>
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

    
    <div id="customPackageModal" class="custom-modal">
      <div class="modal-content">
        <div class="modal-header">
          <h3 style="margin: 0; color: #f8fafc;">Request Custom Package</h3>
          <span class="close-btn" onclick="document.getElementById('customPackageModal').style.display='none'">&times;</span>
        </div>
        
        <form method="POST" action="{{ route('custom-package.submit') }}">
          @csrf
          <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
            <div class="form-group">
              <label>First Name <span style="color: #ff4d4d;">*</span></label>
              <input type="text" name="first_name" required placeholder="First name" class="modal-input">
            </div>
            <div class="form-group">
              <label>Middle Name <span style="color: #ff4d4d;">*</span></label>
              <input type="text" name="middle_name" required placeholder="Middle name" class="modal-input">
            </div>
            <div class="form-group">
              <label>Last Name <span style="color: #ff4d4d;">*</span></label>
              <input type="text" name="last_name" required placeholder="Last name" class="modal-input">
            </div>
          </div>
          <div class="form-group">
            <label>Company Name <span style="color: #ff4d4d;">*</span></label>
            <input type="text" name="company_name" required placeholder="Your company name" class="modal-input">
          </div>
          <div class="form-group">
            <label>Employee Size <span style="color: #ff4d4d;">*</span></label>
            <input type="text" name="employee_size" required placeholder="e.g. 10-50, 100+" class="modal-input">
          </div>
          <div class="form-group" style="grid-column: span 2;">
            <label>Company Email <span style="color: #ff4d4d;">*</span></label>
            <input type="email" name="email" required placeholder="name@company.com" class="modal-input">
          </div>
          <div class="form-group">
            <label>Contact Details <span style="color: #ff4d4d;">*</span></label>
            <input type="tel" id="custom_pkg_phone" class="modal-input" placeholder="Phone number" value="{{ old('country_code') }}{{ old('contact_details') }}" required style="width: 100%;">
            <input type="hidden" name="country_code" id="hidden_country_code" value="{{ old('country_code') }}">
            <input type="hidden" name="contact_details" id="hidden_contact_details" value="{{ old('contact_details') }}">
          </div>
          <div class="form-group">
            <label>Estimated Budget ($) <span style="color: #ff4d4d;">*</span></label>
            <input type="number" name="budget" min="0" required placeholder="e.g. 5000" class="modal-input">
          </div>
          <div class="form-group" style="grid-column: span 2;">
            <label>Description & Requirements <span style="color: #ff4d4d;">*</span></label>
            <textarea name="description" required rows="4" placeholder="Tell us about your fleet size and specific needs..." class="modal-input"></textarea>
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
        padding: 20px;
      }
      .modal-content {
        background: rgba(11, 16, 32, 0.98);
        border: 1px solid rgba(82, 234, 210, 0.25);
        border-radius: 16px;
        width: 100%;
        max-width: 850px;
        padding: 35px;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.7);
        max-height: 90vh;
        overflow-y: auto;
      }
      .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 15px;
      }
      .close-btn {
        color: #94a3b8;
        font-size: 32px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
      }
      .close-btn:hover { color: #f8fafc; }
      .modal-content form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
      }
      .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #a8b3c5;
        font-size: 0.9rem;
        font-weight: 600;
      }
      .modal-input {
        width: 100%;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.12);
        padding: 14px 16px;
        border-radius: 8px;
        color: #fff;
        font-family: inherit;
        font-size: 0.95rem;
        transition: all 0.2s ease;
      }
      .modal-input:focus {
        border-color: var(--brand);
        outline: none;
        background: rgba(255,255,255,0.08);
        box-shadow: 0 0 0 2px rgba(82, 234, 210, 0.25);
      }
      
      @media (max-width: 768px) {
        .modal-content {
          padding: 20px;
        }
        .modal-content form { 
          grid-template-columns: 1fr; 
          gap: 15px;
        }
        .form-group { grid-column: span 1 !important; }
        .form-group[style*="grid-column: span 2;"] { grid-column: span 1 !important; }
        div[style*="grid-column: span 2;"] { grid-column: span 1 !important; }
        div[style*="grid-template-columns: 1fr 1fr 1fr;"] { 
          grid-template-columns: 1fr !important;
          gap: 15px !important;
        }
        .confirm-fields-grid {
          grid-template-columns: 1fr !important;
          gap: 15px !important;
        }
      }
    </style>

    <script>
      // Close modal if clicking outside of it
      window.onclick = function(event) {
        const modal = document.getElementById('customPackageModal');
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
    </script>

    
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    
    <div id="confirmDetailsModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.85); align-items: center; justify-content: center; backdrop-filter: blur(8px); padding: 20px;">
        <div style="background: #111620; border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 16px; width: 100%; max-width: 750px; max-height: 90vh; overflow-y: auto; padding: 25px; box-shadow: 0 20px 60px rgba(0,0,0,0.6); position: relative; font-family: 'Inter', sans-serif; color: #f8fafc; text-align: left; box-sizing: border-box;">
            
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 15px;">
                <h3 style="margin: 0; font-size: 1.35rem; font-weight: 700; color: #ffffff;">Confirm Your Details</h3>
                <button onclick="closeDetailsModal()" style="background: none; border: none; color: #a0aec0; cursor: pointer; font-size: 1.8rem; display: flex; align-items: center; justify-content: center; padding: 0; line-height: 1;">&times;</button>
            </div>

            
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px dashed rgba(82, 234, 210, 0.3); border-radius: 12px; padding: 15px 20px; margin-bottom: 20px; font-size: 0.95rem; line-height: 1.6;">
                <div><span style="color: #a0aec0;">Selected Package:</span> <strong id="modalPackageName" style="color: #ffffff;">Standard</strong></div>
                <div><span style="color: #a0aec0;">Billing Cycle:</span> <strong id="modalBillingCycle" style="color: #ffffff;">Monthly</strong></div>
                <div style="margin-top: 4px; padding-top: 4px; border-top: 1px solid rgba(255,255,255,0.05);"><span style="color: #a0aec0;">Total Price (incl. {{ \App\Models\SiteSetting::first()?->tax_percentage ?? 18 }}% tax):</span> <strong id="modalTotalPrice" style="color: var(--brand);">₹74,282.82 / Monthly</strong></div>
            </div>

            
            <div class="confirm-fields-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Full Name <span style="color: #ff4d4d;">*</span></label>
                        <input type="text" id="custName" value="{{ auth()->check() ? auth()->user()->name : '' }}" readonly style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" />
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Email Address <span style="color: #ff4d4d;">*</span></label>
                        <input type="email" id="custEmail" value="{{ auth()->check() ? auth()->user()->email : '' }}" readonly style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" />
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Confirm Email Address <span style="color: #ff4d4d;">*</span></label>
                        <input type="email" id="custConfirmEmail" value="{{ auth()->check() ? auth()->user()->email : '' }}" readonly style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" />
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">WhatsApp Contact Number <span style="color: #ff4d4d;">*</span></label>
                        <div style="display: flex; gap: 10px;">
                            <select id="custCountryCode" disabled style="padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; width: 80px; cursor: not-allowed; appearance: none; border-color: rgba(255, 255, 255, 0.12);">
                                <option value="{{ auth()->check() ? auth()->user()->country_code : 'IN' }}">{{ auth()->check() ? (auth()->user()->country_code ?? 'IN') : 'IN' }}</option>
                            </select>
                            <input type="text" id="custPhone" value="{{ auth()->check() ? auth()->user()->contact_number : '' }}" readonly style="flex: 1; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" />
                        </div>
                    </div>
                </div>

                
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div style="position: relative;">
                        <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Street Address <span style="color: #ff4d4d;">*</span></label>
                        <input type="text" id="custStreetAddress" value="{{ auth()->check() ? auth()->user()->street_address : '' }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" placeholder="Start typing your street address..." autocomplete="off" />
                        <div id="addrSuggestions" style="display: none; position: absolute; left: 0; right: 0; top: 100%; background: #111620; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; margin-top: 4px; max-height: 200px; overflow-y: auto; z-index: 10000; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);"></div>
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Landmark <span style="color: #ff4d4d;">*</span></label>
                        <input type="text" id="custLandmark" value="{{ auth()->check() ? auth()->user()->landmark : '' }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" placeholder="Landmark (e.g. near metro station)" />
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Pincode <span style="color: #ff4d4d;">*</span></label>
                            <input type="text" id="custPincode" value="{{ auth()->check() ? auth()->user()->pincode : '' }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" placeholder="Pincode" />
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">City <span style="color: #ff4d4d;">*</span></label>
                            <input type="text" id="custCity" value="{{ auth()->check() ? auth()->user()->city : '' }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" placeholder="City" />
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Country <span style="color: #ff4d4d;">*</span></label>
                            <input type="text" id="custCountry" value="{{ auth()->check() ? auth()->user()->country : '' }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" placeholder="Country" />
                        </div>
                    </div>
                </div>
            </div>

            
            <button onclick="proceedToPay()" id="proceedPayBtn" style="width: 100%; margin-top: 15px; padding: 14px; background: #ff5429; color: #ffffff; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <span id="btnText">Proceed to Pay</span>
                <span id="btnLoader" style="display: none; width: 18px; height: 18px; border: 2px solid #ffffff; border-top: 2px solid transparent; border-radius: 50%; animation: spin 0.8s linear infinite;"></span>
            </button>
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
        
        const taxRate = {{ \App\Models\SiteSetting::first()?->tax_percentage ?? 18 }};
        let numericPrice = parseFloat(packagePrice.replace(/[^0-9.]/g, '')) || 0;
        
        // Base price is already in INR
        let priceInInr = numericPrice;
        let taxAmount = priceInInr * (taxRate / 100);
        let totalPrice = priceInInr + taxAmount;
        
        let formattedTotalPrice = '₹' + totalPrice.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        
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
        
        const street_address = document.getElementById('custStreetAddress').value.trim();
        const landmark = document.getElementById('custLandmark').value.trim();
        const pincode = document.getElementById('custPincode').value.trim();
        const city = document.getElementById('custCity').value.trim();
        const country = document.getElementById('custCountry').value.trim();

        if (!street_address || !landmark || !pincode || !city || !country) {
            alert('Please fill out all address fields.');
            return;
        }

        btnText.innerText = 'Processing...';
        btnLoader.style.display = 'inline-block';
        proceedBtn.disabled = true;
        
        fetch("{{ url('/subscribe/create-order') }}/" + currentPackageId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                street_address: street_address,
                landmark: landmark,
                pincode: pincode,
                city: city,
                country: country
            })
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
            package_id: currentPackageId,
            street_address: document.getElementById('custStreetAddress').value.trim(),
            landmark: document.getElementById('custLandmark').value.trim(),
            pincode: document.getElementById('custPincode').value.trim(),
            city: document.getElementById('custCity').value.trim(),
            country: document.getElementById('custCountry').value.trim()
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
    @include('partials.phone-input')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initializeIntlTelInput('custom_pkg_phone', 'hidden_country_code', 'hidden_contact_details');
            
            // Address Autocomplete Suggestions
            const addressInput = document.getElementById('custStreetAddress');
            const suggestionsBox = document.getElementById('addrSuggestions');
            
            if (addressInput && suggestionsBox) {
                let debounceTimeout;
                
                addressInput.addEventListener('input', function () {
                    clearTimeout(debounceTimeout);
                    const query = this.value.trim();
                    
                    if (query.length < 3) {
                        suggestionsBox.style.display = 'none';
                        return;
                    }
                    
                    debounceTimeout = setTimeout(() => {
                        fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=5`)
                            .then(response => response.json())
                            .then(data => {
                                suggestionsBox.innerHTML = '';
                                if (data.features && data.features.length > 0) {
                                    data.features.forEach(feature => {
                                        const props = feature.properties;
                                        
                                        // Build full display address
                                        const parts = [];
                                        if (props.name) parts.push(props.name);
                                        if (props.street) parts.push(props.street);
                                        if (props.city) parts.push(props.city);
                                        if (props.state) parts.push(props.state);
                                        if (props.country) parts.push(props.country);
                                        
                                        const fullText = parts.join(', ');
                                        
                                        const item = document.createElement('div');
                                        item.style.padding = '10px 15px';
                                        item.style.cursor = 'pointer';
                                        item.style.color = '#fff';
                                        item.style.borderBottom = '1px solid rgba(255, 255, 255, 0.05)';
                                        item.style.fontSize = '0.9rem';
                                        item.innerText = fullText;
                                        
                                        // Hover effect
                                        item.addEventListener('mouseenter', function() {
                                            this.style.background = 'rgba(82, 234, 210, 0.15)';
                                        });
                                        item.addEventListener('mouseleave', function() {
                                            this.style.background = 'transparent';
                                        });
                                        
                                        // Select suggestion click handler
                                        item.addEventListener('click', function () {
                                            addressInput.value = props.name || props.street || query;
                                            
                                            if (props.city) {
                                                document.getElementById('custCity').value = props.city;
                                            }
                                            if (props.country) {
                                                document.getElementById('custCountry').value = props.country;
                                            }
                                            if (props.postcode) {
                                                document.getElementById('custPincode').value = props.postcode;
                                            }
                                            if (props.district || props.county || props.state) {
                                                document.getElementById('custLandmark').value = props.district || props.county || props.state || '';
                                            }
                                            
                                            suggestionsBox.style.display = 'none';
                                        });
                                        
                                        suggestionsBox.appendChild(item);
                                    });
                                    suggestionsBox.style.display = 'block';
                                } else {
                                    suggestionsBox.style.display = 'none';
                                }
                            })
                            .catch(() => {
                                suggestionsBox.style.display = 'none';
                            });
                    }, 300);
                });
                
                // Close suggestions when clicking outside
                document.addEventListener('click', function (e) {
                    if (e.target !== addressInput && e.target !== suggestionsBox) {
                        suggestionsBox.style.display = 'none';
                    }
                });
            }
            
            // Auto-click package checkout if returning from register redirect
            const urlParams = new URLSearchParams(window.location.search);
            const buyPackageId = urlParams.get('buy_package_id');
            if (buyPackageId) {
                const buyBtn = document.getElementById('buy-btn-' + buyPackageId);
                if (buyBtn) {
                    // Slight delay to ensure DOM and libraries are ready
                    setTimeout(() => {
                        buyBtn.click();
                    }, 300);
                }
            }

            // Localize Pricing Logic with Caching
            async function localizePricing() {
                let userCurrency = 'INR'; // Default base currency
                let userLocale = 'en-IN';
                let userRate = 1;

                const cacheKey = 'pricing_localization_data';
                const cacheTTL = 3600 * 1000; // 1 hour

                // Smart fallback using browser timezone
                const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                const isIndiaTz = userTimezone && (userTimezone === 'Asia/Kolkata' || userTimezone === 'Asia/Calcutta');

                if (isIndiaTz) {
                    userCurrency = 'INR';
                    userLocale = 'en-IN';
                }

                try {
                    let cachedData = localStorage.getItem(cacheKey);
                    if (cachedData) {
                        cachedData = JSON.parse(cachedData);
                        if (Date.now() - cachedData.timestamp < cacheTTL) {
                            userCurrency = cachedData.currency;
                            userLocale = cachedData.locale;
                            userRate = cachedData.rate;
                            updatePricingDOM(userCurrency, userLocale, userRate);
                            return;
                        }
                    }

                    // 1. Fetch User's currency based on IP
                    const geoRes = await fetch('https://ipapi.co/json/');
                    if (geoRes.ok) {
                        const geoData = await geoRes.json();
                        if (!geoData.error && geoData.currency) {
                            userCurrency = geoData.currency;
                            userLocale = geoData.languages ? geoData.languages.split(',')[0] : (userCurrency === 'INR' ? 'en-IN' : 'en-US');
                        }
                    } else if (isIndiaTz) {
                        userCurrency = 'INR';
                        userLocale = 'en-IN';
                    } else {
                        // Fallback to USD if not in India and IP fails
                        userCurrency = 'USD';
                        userLocale = 'en-US';
                    }
                    
                    // 2. Fetch Exchange Rates with INR as base
                    const ratesRes = await fetch('https://open.er-api.com/v6/latest/INR');
                    if (ratesRes.ok) {
                        const ratesData = await ratesRes.json();
                        const rates = ratesData.rates;
                        userRate = rates[userCurrency] || 1;
                    }

                    // Save to Cache
                    localStorage.setItem(cacheKey, JSON.stringify({
                        currency: userCurrency,
                        locale: userLocale,
                        rate: userRate,
                        timestamp: Date.now()
                    }));

                } catch (error) {
                    console.error("Localization API failed, falling back to timezone defaults.", error);
                    if (!isIndiaTz) {
                        userCurrency = 'USD';
                        userLocale = 'en-US';
                    }
                }

                updatePricingDOM(userCurrency, userLocale, userRate);
            }

            function updatePricingDOM(currency, locale, rate) {
                // Formatter for user currency
                const formatter = new Intl.NumberFormat(locale, {
                    style: 'currency',
                    currency: currency,
                    maximumFractionDigits: 0
                });

                // Update Pricing DOM
                document.querySelectorAll('[id^="pkg-price-"]').forEach(el => {
                    const rawPrice = el.getAttribute('data-raw-price').toLowerCase();
                    if (rawPrice === 'free' || rawPrice === 'custom' || rawPrice === 'enterprise' || rawPrice === '0' || rawPrice === '$0') {
                        return; // Leave as is
                    }
                    
                    // The raw price from the DB is in INR
                    let numericBase = parseFloat(rawPrice.replace(/[^0-9.]/g, ''));
                    if (numericBase > 0) {
                        // Convert INR base to local currency using the exchange rate multiplier
                        let convertedPrice = numericBase * rate;
                        el.innerText = formatter.format(convertedPrice);
                    }
                });
            }
            localizePricing();
        });
    </script>
  </main>
@endsection
