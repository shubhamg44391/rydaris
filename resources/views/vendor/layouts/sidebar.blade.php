<ul class="py-1 menu-inner">
    <!-- Dashboard -->
    <li class="menu-item {{ Request::is('vendor/dashboard*') ? 'active' : '' }}">
        <a href="{{ route('vendor.dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Vendor Dashboard</div>
        </a>
    </li>
</ul>
