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
            <div class="card h-100" style="background: rgba(82, 234, 210, 0.05); border: 1px solid var(--brand, #52ead2); border-radius: var(--radius); box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
                <div class="card-body d-flex flex-column" style="padding: 30px;">
                    @if($pkg->eyebrow)
                        <div class="text-uppercase mb-2 small fw-semibold" style="color: var(--brand, #52ead2); letter-spacing: 1px;">{{ $pkg->eyebrow }}</div>
                    @endif
                    
                    <h3 class="card-title mb-3" style="color: #f8fafc; font-weight: 700;">{{ $pkg->name }}</h3>
                    <p class="card-text" style="color: #aab7cb; min-height: 48px; font-size: 0.95rem;">{{ $pkg->description }}</p>
                    
                    <div class="my-4">
                        <span id="pkg-price-{{ $pkg->id }}" data-raw-price="{{ $pkg->price }}" class="display-5 fw-bold" style="color: #f8fafc; font-size: 2.5rem;">{{ $pkg->price }}</span>
                        @if(strtolower($pkg->price) !== 'custom')
                            <span style="color: #aab7cb;">/{{ $pkg->billing_period }}</span>
                        @endif
                    </div>
                    
                    <ul class="list-unstyled mb-4" style="color: #e2e8f0;">
                      @if($pkg->booking_menu)
                        @if($pkg->no_of_bookings !== null && (int)$pkg->no_of_bookings === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Bookings Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_bookings !== null ? ($pkg->no_of_bookings . ' Bookings Included') : 'Unlimited Bookings' }}
                          </li>
                        @endif
                      @endif

                      @if($pkg->vehicles_menu)
                        @if($pkg->no_of_vehicles !== null && (int)$pkg->no_of_vehicles === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Vehicles Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_vehicles !== null ? ($pkg->no_of_vehicles . ' Vehicles Included') : 'Unlimited Vehicles' }}
                          </li>
                        @endif

                        @if($pkg->no_of_groups !== null && (int)$pkg->no_of_groups === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Groups Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_groups !== null ? ($pkg->no_of_groups . ' Groups Included') : 'Unlimited Groups' }}
                          </li>
                        @endif
                      @endif

                      @if($pkg->locations_menu)
                        @if($pkg->no_of_locations !== null && (int)$pkg->no_of_locations === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Locations Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_locations !== null ? ($pkg->no_of_locations . ' Locations Included') : 'Unlimited Locations' }}
                          </li>
                        @endif
                      @endif

                      @if($pkg->customers_menu)
                        @if($pkg->no_of_users !== null && (int)$pkg->no_of_users === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Customers Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_users !== null ? ($pkg->no_of_users . ' Customers Included') : 'Unlimited Customers' }}
                          </li>
                        @endif

                        @if($pkg->no_of_invitations !== null && (int)$pkg->no_of_invitations === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Invitations Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_invitations !== null ? ($pkg->no_of_invitations . ' Invitations Included') : 'Unlimited Invitations' }}
                          </li>
                        @endif
                      @endif

                      @if($pkg->fleet_management_menu)
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                            Fleet Management Included
                        </li>
                      @endif

                      @if($pkg->extras_menu)
                        @if($pkg->no_of_extras !== null && (int)$pkg->no_of_extras === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Extras Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_extras !== null ? ($pkg->no_of_extras . ' Extras Included') : 'Unlimited Extras' }}
                          </li>
                        @endif

                        @if($pkg->no_of_insurances !== null && (int)$pkg->no_of_insurances === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Insurances Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_insurances !== null ? ($pkg->no_of_insurances . ' Insurances Included') : 'Unlimited Insurances' }}
                          </li>
                        @endif

                        @if($pkg->no_of_features !== null && (int)$pkg->no_of_features === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Features Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_features !== null ? ($pkg->no_of_features . ' Features Included') : 'Unlimited Features' }}
                          </li>
                        @endif

                        @if($pkg->no_of_rules !== null && (int)$pkg->no_of_rules === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Rules Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_rules !== null ? ($pkg->no_of_rules . ' Rules Included') : 'Unlimited Rules' }}
                          </li>
                        @endif
                      @endif

                      @if($pkg->coupons_menu)
                        @if($pkg->no_of_coupons !== null && (int)$pkg->no_of_coupons === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Coupons Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_coupons !== null ? ($pkg->no_of_coupons . ' Coupons Included') : 'Unlimited Coupons' }}
                          </li>
                        @endif
                      @endif

                      @if($pkg->support_ticket_menu)
                        @if($pkg->no_of_support_tickets !== null && (int)$pkg->no_of_support_tickets === 0)
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-x-circle me-2" style="color: #ff4d4d; font-size: 1.2rem; font-weight: bold;"></i>
                              <span style="color: #aab7cb;">Support Tickets Not Included</span>
                          </li>
                        @else
                          <li class="mb-2 d-flex align-items-center">
                              <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                              {{ $pkg->no_of_support_tickets !== null ? ($pkg->no_of_support_tickets . ' Support Tickets Included') : 'Unlimited Support Tickets' }}
                          </li>
                        @endif
                      @endif

                      @if($pkg->settings_menu)
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bx bx-check me-2" style="color: var(--brand, #52ead2); font-size: 1.2rem;"></i>
                            System Settings Access
                        </li>
                      @endif
                    </ul>

                    <div class="mt-auto pt-3">
                        @if(strtolower($pkg->price) === 'custom')
                            <button type="button" onclick="document.getElementById('customPackageModal').style.display='flex'" class="btn w-100" style="padding: 12px; font-weight: 600; border-radius: var(--radius); background: linear-gradient(135deg, var(--brand, #52ead2), #2bc2a8); color: #050711; border: none;">
                                {{ $pkg->button_text ?? 'Request Custom Package' }}
                            </button>
                        @else
                            @php
                                $activeSub = auth()->user()->activeSubscription;
                                $isActive = $activeSub && $activeSub->package_id === $pkg->id;
                                
                                $isUpgrade = false;
                                if ($activeSub && $activeSub->package) {
                                    $getPrice = function($p) {
                                        $priceStr = strtolower($p->price);
                                        if ($priceStr === 'free' || $priceStr === '0' || $priceStr === '$0') {
                                            return 0.0;
                                        }
                                        if ($priceStr === 'custom' || $priceStr === 'enterprise') {
                                            return 999999.0;
                                        }
                                        preg_match_all('!\d+!', $p->price, $matches);
                                        if (!empty($matches[0])) {
                                            return (float) implode('', $matches[0]);
                                        }
                                        return 999999.0;
                                    };
                                    
                                    $currentPrice = $getPrice($activeSub->package);
                                    $thisPrice = $getPrice($pkg);
                                    if ($thisPrice > $currentPrice) {
                                        $isUpgrade = true;
                                    }
                                }
                            @endphp
                            @if($isActive)
                                <button type="button" class="btn w-100" disabled style="padding: 12px; font-weight: 600; border-radius: var(--radius); background: rgba(255,255,255,0.1); color: #aab7cb; border: 1px solid rgba(255,255,255,0.2);">
                                    Current Package
                                </button>
                            @else
                                <button type="button" onclick="openDetailsModal({{ $pkg->id }}, '{{ $pkg->name }}', '{{ $pkg->price }}', '{{ $pkg->billing_period }}')" class="btn w-100" style="padding: 12px; font-weight: 600; border-radius: var(--radius); background: linear-gradient(135deg, var(--brand, #52ead2), #2bc2a8); color: #050711; border: none;">
                                    {{ $isUpgrade ? 'Upgrade' : ($pkg->button_text ?? 'Subscribe') }}
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

    
    <div id="customPackageModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.85); align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: #111620; border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; width: 100%; max-width: 560px; padding: 28px; box-shadow: 0 20px 60px rgba(0,0,0,0.6); position: relative; font-family: 'Inter', sans-serif; color: #f8fafc;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 15px;">
                <h3 style="margin: 0; font-size: 1.2rem; font-weight: 700; color: #fff;">Request Custom Package</h3>
                <button onclick="document.getElementById('customPackageModal').style.display='none'" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 1.5rem;">&times;</button>
            </div>
            <form method="POST" action="{{ route('custom-package.submit') }}" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                @csrf
                <div style="grid-column: span 2; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">First Name <span style="color: #ff4d4d;">*</span></label>
                        <input type="text" name="first_name" value="{{ auth()->user()->first_name ?? '' }}" required style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Middle Name <span style="color: #ff4d4d;">*</span></label>
                        <input type="text" name="middle_name" value="" required placeholder="Middle name" style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Last Name <span style="color: #ff4d4d;">*</span></label>
                        <input type="text" name="last_name" value="{{ auth()->user()->name ?? '' }}" required style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                    </div>
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Company Name <span style="color: #ff4d4d;">*</span></label>
                    <input type="text" name="company_name" value="{{ auth()->user()->company_name ?? '' }}" required style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Employee Size <span style="color: #ff4d4d;">*</span></label>
                    <input type="text" name="employee_size" required placeholder="e.g. 10-50, 100+" style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Company Email <span style="color: #ff4d4d;">*</span></label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" required style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Contact Details <span style="color: #ff4d4d;">*</span></label>
                    <input type="tel" id="custom_pkg_phone" placeholder="Phone number" value="{{ auth()->user()->country_code ?? '' }}{{ auth()->user()->contact_number ?? '' }}" required style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                    <input type="hidden" name="country_code" id="hidden_country_code" value="{{ auth()->user()->country_code ?? '' }}">
                    <input type="hidden" name="contact_details" id="hidden_contact_details" value="{{ auth()->user()->contact_number ?? '' }}">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Estimated Budget (&#8377;) <span style="color: #ff4d4d;">*</span></label>
                    <input type="number" name="budget" min="0" required placeholder="e.g. 5000" style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit;">
                </div>
                <div style="grid-column: span 2;">
                    <label style="display:block; margin-bottom:5px; color:#a8b3c5; font-size:0.85rem;">Description &amp; Requirements <span style="color: #ff4d4d;">*</span></label>
                    <textarea name="description" required rows="4" placeholder="Tell us about your fleet size and specific needs..." style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); padding:11px 14px; border-radius:8px; color:#fff; font-family:inherit; resize:vertical;"></textarea>
                </div>
                <div style="grid-column: span 2; text-align: right; margin-top: 5px;">
                    <button type="button" onclick="document.getElementById('customPackageModal').style.display='none'" style="padding:10px 20px; border-radius:8px; background:transparent; border:1px solid rgba(255,255,255,0.15); color:#94a3b8; font-weight:600; cursor:pointer; margin-right:10px;">Cancel</button>
                    <button type="submit" style="padding:10px 24px; border-radius:8px; background:linear-gradient(135deg, var(--brand,#52ead2), #2bc2a8); color:#050711; border:none; font-weight:700; cursor:pointer;">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    
    <div id="confirmDetailsModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.85); align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: #111620; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto; padding: 25px; box-shadow: 0 20px 60px rgba(0,0,0,0.6); position: relative; font-family: 'Inter', sans-serif; color: #f8fafc; text-align: left; box-sizing: border-box;">
            
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 1.35rem; font-weight: 700; color: #ffffff;">Confirm Your Details</h3>
                <button onclick="closeDetailsModal()" style="background: none; border: none; color: #a0aec0; cursor: pointer; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; padding: 0;">&times;</button>
            </div>

            
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px dashed rgba(255, 255, 255, 0.12); border-radius: 12px; padding: 15px 20px; margin-bottom: 20px; font-size: 0.95rem; line-height: 1.6;">
                <div><span style="color: #a0aec0;">Selected Package:</span> <strong id="modalPackageName" style="color: #ffffff;">Standard</strong></div>
                <div><span style="color: #a0aec0;">Billing Cycle:</span> <strong id="modalBillingCycle" style="color: #ffffff;">Monthly</strong></div>
                <div style="margin-top: 4px; padding-top: 4px; border-top: 1px solid rgba(255,255,255,0.05);"><span style="color: #a0aec0;">Total Price (incl. {{ \App\Models\SiteSetting::first()?->tax_percentage ?? 18 }}% tax):</span> <strong id="modalTotalPrice" style="color: #ff5429;">₹74,282.82 / Monthly</strong></div>
            </div>

            
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div>
                    <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Full Name <span style="color: #ff4d4d;">*</span></label>
                    <input type="text" id="custName" value="{{ auth()->check() ? (auth()->user()->first_name . ' ' . auth()->user()->name) : '' }}" readonly style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" />
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
                        <select id="custCountryCode" disabled style="padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; width: 110px; cursor: not-allowed; appearance: none; border-color: rgba(255, 255, 255, 0.12);">
                            <option value="{{ auth()->check() ? auth()->user()->country_code : 'IN' }}">{{ auth()->check() ? (auth()->user()->country_code ?? 'IN') : 'IN' }}</option>
                        </select>
                        <input type="text" id="custPhone" value="{{ auth()->check() ? auth()->user()->contact_number : '' }}" readonly style="flex: 1; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" />
                    </div>
                </div>

                <div style="position: relative;">
                    <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Street Address <span style="color: #ff4d4d;">*</span></label>
                    <input type="text" id="custStreetAddress" value="{{ auth()->check() && auth()->user()->subscription ? auth()->user()->subscription->street_address : '' }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" placeholder="Start typing your street address..." autocomplete="off" />
                    <div id="addrSuggestions" style="display: none; position: absolute; left: 0; right: 0; top: 100%; background: #111620; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; margin-top: 4px; max-height: 200px; overflow-y: auto; z-index: 10000; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);"></div>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Landmark <span style="color: #ff4d4d;">*</span></label>
                    <input type="text" id="custLandmark" value="{{ auth()->check() && auth()->user()->subscription ? auth()->user()->subscription->landmark : '' }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" placeholder="Landmark (e.g. near metro station)" />
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                    <div>
                        <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Pincode <span style="color: #ff4d4d;">*</span></label>
                        <input type="text" id="custPincode" value="{{ auth()->check() && auth()->user()->subscription ? auth()->user()->subscription->pincode : '' }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" placeholder="Pincode" />
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">City <span style="color: #ff4d4d;">*</span></label>
                        <input type="text" id="custCity" value="{{ auth()->check() && auth()->user()->subscription ? auth()->user()->subscription->city : '' }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" placeholder="City" />
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 6px; color: #a0aec0; font-size: 0.85rem; font-weight: 500;">Country <span style="color: #ff4d4d;">*</span></label>
                        <input type="text" id="custCountry" value="{{ auth()->check() && auth()->user()->subscription ? auth()->user()->subscription->country : '' }}" required style="width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 8px; color: #ffffff; font-size: 0.95rem; outline: none; border-color: rgba(255, 255, 255, 0.12);" placeholder="Country" />
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

    // Close modal if clicking outside of it
    window.onclick = function(event) {
        const confirmModal = document.getElementById('confirmDetailsModal');
        if (event.target == confirmModal) {
            confirmModal.style.display = "none";
        }
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
</div>
@endsection
