<nav class="admin-nav">
    <a class="{{ Request::is('vendor/dashboard*') ? 'active' : '' }}" href="{{ route('vendor.dashboard') }}">
        <svg viewBox="0 0 24 24"><path d="M3 3h7v7H3Z"/><path d="M14 3h7v7h-7Z"/><path d="M14 14h7v7h-7Z"/><path d="M3 14h7v7H3Z"/></svg>Vendor Dashboard
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
