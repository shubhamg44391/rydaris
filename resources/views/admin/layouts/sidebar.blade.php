<ul class="py-1 menu-inner">
    <!-- Dashboard -->
    <li class="menu-item {{ Request::is('dashboard*') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>


    <li class="menu-item {{ Request::is('admin/vendor*') ? 'active' : '' }}">
        <a href="{{ route('admin.vendors.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Basic">Vendors</div>
        </a>
    </li>


    <!-- Components -->
</ul>