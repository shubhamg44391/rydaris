<nav class="admin-nav">
    <a class="{{ Request::is('vendor/dashboard*') ? 'active' : '' }}" href="{{ route('vendor.dashboard') }}">
        <svg viewBox="0 0 24 24"><path d="M3 3h7v7H3Z"/><path d="M14 3h7v7h-7Z"/><path d="M14 14h7v7h-7Z"/><path d="M3 14h7v7H3Z"/></svg>Vendor Dashboard
    </a>
    
    <a class="{{ Request::is('vendor/pricing*') ? 'active' : '' }}" href="{{ route('vendor.pricing') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="6" width="20" height="12" rx="2"/><path d="M12 12h.01"/><path d="M17 12h.01"/><path d="M7 12h.01"/>
        </svg>Pricing
    </a>

    @if(auth()->user()->activeSubscription)
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
