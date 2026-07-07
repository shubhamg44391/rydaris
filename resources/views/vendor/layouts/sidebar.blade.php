<nav class="admin-nav">
    <a class="{{ Request::is('vendor/dashboard*') ? 'active' : '' }}" href="{{ route('vendor.dashboard') }}">
        <svg viewBox="0 0 24 24"><path d="M3 3h7v7H3Z"/><path d="M14 3h7v7h-7Z"/><path d="M14 14h7v7h-7Z"/><path d="M3 14h7v7H3Z"/></svg> Dashboard
    </a>
    
    {{-- Subscription / Pricing Menu --}}
    <div class="admin-nav-group">
        <a href="javascript:void(0);" class="nav-toggle" onclick="toggleSubmenu(this)" style="justify-content: space-between; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); {{ (Request::is('vendor/pricing*') || Request::is('vendor/subscription*')) ? 'color: #f8fafc; background: rgba(255, 255, 255, 0.04);' : 'color: #aab7cb;' }} font-size: 0.92rem; font-weight: 780; transition: background 0.2s;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;">
                    <rect x="2" y="6" width="20" height="12" rx="2"/><path d="M12 12h.01"/><path d="M17 12h.01"/><path d="M7 12h.01"/>
                </svg>Subscription
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; transition: transform 0.2s ease; {{ (Request::is('vendor/pricing*') || Request::is('vendor/subscription*')) ? 'transform: rotate(180deg);' : '' }}"><path d="m6 9 6 6 6-6"/></svg>
        </a>
        <div class="admin-submenu" style="{{ (Request::is('vendor/pricing*') || Request::is('vendor/subscription*')) ? 'display: flex;' : 'display: none;' }} padding-left: 20px; margin-top: 4px; flex-direction: column; gap: 4px;">
            <a href="{{ route('vendor.pricing') }}" class="submenu-item {{ Request::is('vendor/pricing*') ? 'active' : '' }}" style="{{ Request::is('vendor/pricing*') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/pricing*') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Plans
            </a>
            <a href="{{ route('vendor.subscription.history') }}" class="submenu-item {{ Request::is('vendor/subscription*') ? 'active' : '' }}" style="{{ Request::is('vendor/subscription*') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/subscription*') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                History
            </a>
        </div>
    </div>

    <!-- Settings Menu -->
    <div class="admin-nav-group">
        <a href="javascript:void(0);" class="nav-toggle" onclick="toggleSubmenu(this)" style="justify-content: space-between; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); {{ (Request::is('vendor/profile*') || Request::is('vendor/payment-settings*')) ? 'color: #f8fafc; background: rgba(255, 255, 255, 0.04);' : 'color: #aab7cb;' }} font-size: 0.92rem; font-weight: 780; transition: background 0.2s;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>Settings
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; transition: transform 0.2s ease; {{ (Request::is('vendor/profile*') || Request::is('vendor/payment-settings*')) ? 'transform: rotate(180deg);' : '' }}"><path d="m6 9 6 6 6-6"/></svg>
        </a>
        <div class="admin-submenu" style="{{ (Request::is('vendor/profile*') || Request::is('vendor/payment-settings*')) ? 'display: flex;' : 'display: none;' }} padding-left: 20px; margin-top: 4px; flex-direction: column; gap: 4px;">
            <a href="{{ route('vendor.profile.index') }}" class="submenu-item {{ Request::is('vendor/profile*') ? 'active' : '' }}" style="{{ Request::is('vendor/profile*') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/profile*') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Profile Management
            </a>
            <a href="{{ route('vendor.payment_settings.index') }}" class="submenu-item {{ Request::is('vendor/payment-settings*') ? 'active' : '' }}" style="{{ Request::is('vendor/payment-settings*') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/payment-settings*') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Payment Gateway Setting
            </a>
        </div>
    </div>

      <!-- Bookings Menu -->
    <div class="admin-nav-group">
        <button type="button" class="nav-toggle {{ Request::is('vendor/bookings*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: space-between; display: flex; align-items: center; width: 100%; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); background: transparent; border: none; cursor: pointer; {{ Request::is('vendor/bookings*') ? 'color: #f8fafc; font-weight: bold;' : 'color: #aab7cb; font-weight: 780;' }} font-size: 0.92rem; transition: background 0.2s;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Booking
                @php
                    $pendingBookingsCount = \App\Models\Booking::where('vendor_id', auth()->id())->where('booking_status', 'pending')->count();
                @endphp
                @if($pendingBookingsCount > 0)
                    <span style="background: #ef4444; color: white; border-radius: 12px; padding: 1px 6px; font-size: 0.75rem; font-weight: bold; margin-left: 5px; box-shadow: 0 0 5px rgba(239, 68, 68, 0.5);">{{ $pendingBookingsCount }}</span>
                @endif
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2; transition: transform 0.2s; {{ Request::is('vendor/bookings*') ? 'transform: rotate(180deg);' : '' }}">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
        <div class="admin-submenu" style="{{ Request::is('vendor/bookings*') ? 'display: flex;' : 'display: none;' }} flex-direction: column; gap: 4px; padding: 8px 12px; padding-left: 36px;">
            <a href="{{ route('vendor.bookings.index') }}"
               class="submenu-item {{ Request::is('vendor/bookings') ? 'active' : '' }}"
               style="{{ Request::is('vendor/bookings') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/bookings') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Booking List
            </a>
            <a href="{{ route('vendor.bookings.payment') }}"
               class="submenu-item {{ Request::is('vendor/bookings/payment') ? 'active' : '' }}"
               style="{{ Request::is('vendor/bookings/payment') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/bookings/payment') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Booking Payment
            </a>
        </div>
    </div>

    @if(auth()->user()->activeSubscription)
    <!-- Customers Link -->
    <a class="{{ Request::is('vendor/customers*') ? 'active' : '' }}" href="{{ route('vendor.customers.index') }}" style="text-decoration: none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
        </svg>Customers
    </a>

    <!-- Vehicles Parent Menu with Custom JavaScript Toggle -->
    <div class="admin-nav-group">
        <a href="javascript:void(0);" class="nav-toggle" onclick="toggleSubmenu(this)" style="justify-content: space-between; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); {{ (Request::is('vendor/groups*') || Request::is('vendor/vehicles*')) ? 'color: #f8fafc; background: rgba(255, 255, 255, 0.04);' : 'color: #aab7cb;' }} font-size: 0.92rem; font-weight: 780; transition: background 0.2s;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                    <circle cx="7" cy="17" r="2" />
                    <path d="M9 17h6" />
                    <circle cx="17" cy="17" r="2" />
                </svg>Vehicles
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; transition: transform 0.2s ease; {{ (Request::is('vendor/groups*') || Request::is('vendor/vehicles*')) ? 'transform: rotate(180deg);' : '' }}"><path d="m6 9 6 6 6-6"/></svg>
        </a>
        <div class="admin-submenu" style="{{ (Request::is('vendor/groups*') || Request::is('vendor/vehicles*')) ? 'display: flex;' : 'display: none;' }} padding-left: 20px; margin-top: 4px; flex-direction: column; gap: 4px;">
            <a href="{{ route('vendor.groups.index') }}" class="submenu-item {{ Request::is('vendor/groups*') ? 'active' : '' }}" style="{{ Request::is('vendor/groups*') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/groups*') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Vehicle Group
            </a>
            <a href="{{ route('vendor.vehicles.index') }}" class="submenu-item {{ (Request::is('vendor/vehicles*') && !Request::is('vendor/vehicles/create')) ? 'active' : '' }}" style="{{ (Request::is('vendor/vehicles*') && !Request::is('vendor/vehicles/create')) ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ (Request::is('vendor/vehicles*') && !Request::is('vendor/vehicles/create')) ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Vehicle List
            </a>
            <a href="{{ route('vendor.vehicles.create') }}" class="submenu-item {{ Request::is('vendor/vehicles/create') ? 'active' : '' }}" style="{{ Request::is('vendor/vehicles/create') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/vehicles/create') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Add Vehicle
            </a>
        </div>
    </div>

    <!-- Locations Menu -->
    <div class="admin-nav-group">
        <a href="javascript:void(0);" class="nav-toggle" onclick="toggleSubmenu(this)"
           style="justify-content: space-between; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); {{ Request::is('vendor/locations*') ? 'color: #f8fafc; background: rgba(255, 255, 255, 0.04);' : 'color: #aab7cb;' }} font-size: 0.92rem; font-weight: 780; transition: background 0.2s;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>Locations
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; transition: transform 0.2s ease; {{ Request::is('vendor/locations*') ? 'transform: rotate(180deg);' : '' }}"><path d="m6 9 6 6 6-6"/></svg>
        </a>
        <div class="admin-submenu"
             style="{{ Request::is('vendor/locations*') ? 'display: flex;' : 'display: none;' }} padding-left: 20px; margin-top: 4px; flex-direction: column; gap: 4px;">
            <a href="{{ route('vendor.locations.index') }}"
               class="submenu-item {{ (Request::is('vendor/locations*') && !Request::is('vendor/locations/create')) ? 'active' : '' }}"
               style="{{ (Request::is('vendor/locations*') && !Request::is('vendor/locations/create')) ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ (Request::is('vendor/locations*') && !Request::is('vendor/locations/create')) ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Location List
            </a>
            <a href="{{ route('vendor.locations.create') }}"
               class="submenu-item {{ Request::is('vendor/locations/create') ? 'active' : '' }}"
               style="{{ Request::is('vendor/locations/create') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/locations/create') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Add Location
            </a>
        </div>
    </div>

    <!-- Fleet Management Menu -->
    <div class="admin-nav-group">
        <a href="{{ route('vendor.availability.index') }}" class="nav-toggle {{ Request::is('vendor/availability*') ? 'active' : '' }}"
           style="justify-content: flex-start; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); {{ Request::is('vendor/availability*') ? 'color: var(--brand, #52ead2); font-weight: bold; background: rgba(255, 255, 255, 0.04);' : 'color: #aab7cb; font-weight: 780;' }} font-size: 0.92rem; transition: background 0.2s;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;">
                    <path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"></path>
                    <circle cx="7.5" cy="7.5" r=".5" fill="currentColor"></circle>
                </svg>
                Fleet Management
            </span>
        </a>
    </div>
    <!-- Extras Menu -->
    <div class="admin-nav-group">
        <a href="javascript:void(0);" class="nav-toggle" onclick="toggleSubmenu(this)"
           style="justify-content: space-between; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); {{ (Request::is('vendor/extras*') || Request::is('vendor/insurance*') || Request::is('vendor/features*') || Request::is('vendor/rules*')) ? 'color: #f8fafc; background: rgba(255, 255, 255, 0.04);' : 'color: #aab7cb;' }} font-size: 0.92rem; font-weight: 780; transition: background 0.2s;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>Extras
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; transition: transform 0.2s ease; {{ (Request::is('vendor/extras*') || Request::is('vendor/insurance*') || Request::is('vendor/features*') || Request::is('vendor/rules*')) ? 'transform: rotate(180deg);' : '' }}"><path d="m6 9 6 6 6-6"/></svg>
        </a>
        <div class="admin-submenu"
             style="{{ (Request::is('vendor/extras*') || Request::is('vendor/insurance*') || Request::is('vendor/features*') || Request::is('vendor/rules*')) ? 'display: flex;' : 'display: none;' }} padding-left: 20px; margin-top: 4px; flex-direction: column; gap: 4px;">
            <a href="{{ route('vendor.extras.index') }}"
               class="submenu-item {{ (Request::is('vendor/extras*') && !Request::is('vendor/extras/create')) ? 'active' : '' }}"
               style="{{ (Request::is('vendor/extras*') && !Request::is('vendor/extras/create')) ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ (Request::is('vendor/extras*') && !Request::is('vendor/extras/create')) ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Extras
            </a>
          
            <a href="{{ route('vendor.insurance.index') }}"
               class="submenu-item {{ (Request::is('vendor/insurance*') && !Request::is('vendor/insurance/create')) ? 'active' : '' }}"
               style="{{ (Request::is('vendor/insurance*') && !Request::is('vendor/insurance/create')) ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ (Request::is('vendor/insurance*') && !Request::is('vendor/insurance/create')) ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Insurance
            </a>

            <a href="{{ route('vendor.features.index') }}"
               class="submenu-item {{ Request::is('vendor/features*') ? 'active' : '' }}"
               style="{{ Request::is('vendor/features*') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/features*') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Features
            </a>

            <a href="{{ route('vendor.rules.index') }}"
               class="submenu-item {{ Request::is('vendor/rules*') ? 'active' : '' }}"
               style="{{ Request::is('vendor/rules*') ? 'color: var(--brand, #52ead2) !important; font-weight: bold; background: rgba(255, 255, 255, 0.04) !important;' : '' }}">
                <span class="dot" style="{{ Request::is('vendor/rules*') ? 'background: var(--brand, #52ead2) !important;' : '' }}"></span>
                Our Rules
            </a>
            
        </div>
    </div>
    @endif

    @if(Auth::user()->hasCouponFeature())
    <!-- Coupons Menu -->
    <div class="admin-nav-group">
        <a href="{{ route('vendor.coupons.index') }}" class="nav-toggle {{ Request::is('vendor/coupons*') ? 'active' : '' }}"
           style="justify-content: flex-start; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); {{ Request::is('vendor/coupons*') ? 'color: var(--brand, #52ead2); font-weight: bold; background: rgba(255, 255, 255, 0.04);' : 'color: #aab7cb; font-weight: 780;' }} font-size: 0.92rem; transition: background 0.2s;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                </svg>
                Coupons
            </span>
        </a>
    </div>
    @endif

  

</nav>

<style>
    .admin-submenu .submenu-item {
        min-height: 36px;
        padding: 6px 12px;
        font-size: 0.85rem;
        color: #aab7cb;
        display: flex;
        align-items: center;
        gap: 8px;
        border-radius: var(--radius);
        transition: all 0.2s;
    }
    .admin-submenu .submenu-item:hover {
        color: var(--brand, #52ead2) !important;
        background: rgba(255, 255, 255, 0.04) !important;
    }
    .admin-submenu .submenu-item .dot {
        width: 6px;
        height: 6px;
        background: rgba(255,255,255,0.3);
        border-radius: 50%;
        transition: background 0.2s;
    }
    .admin-submenu .submenu-item:hover .dot {
        background: var(--brand, #52ead2);
    }
    .admin-nav-group .nav-toggle:hover {
        background: rgba(255, 255, 255, 0.04);
        color: #f8fafc;
    }
</style>

<script>
function toggleSubmenu(el) {
    const submenu = el.nextElementSibling;
    const chevron = el.querySelector('.chevron');
    if (submenu.style.display === 'none' || submenu.style.display === '') {
        submenu.style.display = 'flex';
        chevron.style.transform = 'rotate(180deg)';
        el.style.color = '#f8fafc';
    } else {
        submenu.style.display = 'none';
        chevron.style.transform = 'rotate(0deg)';
        el.style.color = '#aab7cb';
    }
}
</script>
