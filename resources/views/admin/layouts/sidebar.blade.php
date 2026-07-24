<nav class="admin-nav">
    <a class="{{ Request::is('admin/dashboard*') || Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <svg viewBox="0 0 24 24"><path d="M3 3h7v7H3Z"/><path d="M14 3h7v7h-7Z"/><path d="M14 14h7v7h-7Z"/><path d="M3 14h7v7H3Z"/></svg>Dashboard
    </a>

    <a class="{{ Request::is('admin/vendor*') ? 'active' : '' }}" href="{{ route('admin.vendors.index') }}">
        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>Vendors
    </a>

    
    <a class="{{ Request::is('admin/subscriptions*') ? 'active' : '' }}" href="{{ route('admin.subscriptions.index') }}" style="text-decoration: none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="5" width="20" height="14" rx="2" ry="2"/>
            <line x1="2" y1="10" x2="22" y2="10"/>
        </svg>Subscriptions
    </a>

    
    <div class="admin-nav-group">
        <a href="javascript:void(0);" class="nav-toggle" onclick="toggleSubmenu(this)" style="justify-content: space-between; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); {{ Request::is('admin/faqs*') ? 'color: #f8fafc; background: rgba(255, 255, 255, 0.04);' : 'color: #aab7cb;' }} font-size: 0.92rem; font-weight: 780; transition: background 0.2s; text-decoration: none;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>FAQ
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; transition: transform 0.2s ease; {{ Request::is('admin/faqs*') ? 'transform: rotate(180deg);' : '' }}"><path d="m6 9 6 6 6-6"/></svg>
        </a>
        <div class="admin-submenu" style="{{ Request::is('admin/faqs*') ? 'display: flex;' : 'display: none;' }} padding-left: 20px; margin-top: 4px; flex-direction: column; gap: 4px;">
            <a href="{{ route('admin.faqs.index', ['category' => 'product_basics']) }}" class="submenu-item {{ (Request::is('admin/faqs*') && request('category') === 'product_basics') ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                Product Basics
            </a>
            <a href="{{ route('admin.faqs.index', ['category' => 'onboarding']) }}" class="submenu-item {{ (Request::is('admin/faqs*') && request('category') === 'onboarding') ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                Onboarding
            </a>
            <a href="{{ route('admin.faqs.index', ['category' => 'reporting']) }}" class="submenu-item {{ (Request::is('admin/faqs*') && request('category') === 'reporting') ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                Reporting
            </a>
        </div>
    </div>

    
    <a class="{{ Request::is('admin/packages*') ? 'active' : '' }}" href="{{ route('admin.packages.index') }}" style="text-decoration: none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="1" x2="12" y2="23"/>
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
        </svg>Packages
    </a>

    
    <a class="{{ Request::is('admin/terms-conditions*') ? 'active' : '' }}" href="{{ route('admin.terms.index') }}" style="text-decoration: none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
        </svg>Terms & Conditions
    </a>

    
    <div class="admin-nav-group">
        <a href="javascript:void(0);" class="nav-toggle {{ Request::is('admin/contact-inquiries*') || Request::is('admin/demo-inquiries*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: space-between; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); font-size: 0.92rem; font-weight: 780; transition: background 0.2s; text-decoration: none;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>Inquiries
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; transition: transform 0.2s ease; {{ Request::is('admin/contact-inquiries*') || Request::is('admin/demo-inquiries*') ? 'transform: rotate(180deg);' : '' }}"><path d="m6 9 6 6 6-6"/></svg>
        </a>
        <div class="admin-submenu" style="{{ Request::is('admin/contact-inquiries*') || Request::is('admin/demo-inquiries*') ? 'display: flex;' : 'display: none;' }} padding-left: 20px; margin-top: 4px; flex-direction: column; gap: 4px;">
            <a href="{{ route('admin.contact-inquiries.index') }}" class="submenu-item {{ Request::is('admin/contact-inquiries*') ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
              General Inquiry
            </a>
            <a href="{{ route('admin.demo-inquiries.index') }}" class="submenu-item {{ Request::is('admin/demo-inquiries*') ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                Demo Inquiry
            </a>
        </div>
    </div>

    
    <a class="{{ Request::is('admin/custom-package-requests*') ? 'active' : '' }}" href="{{ route('admin.custom-package-requests.index') }}" style="text-decoration: none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
        </svg>Custom Packages
    </a>

    
    <div class="admin-nav-group">
        <a href="javascript:void(0);" class="nav-toggle {{ Request::is('admin/pages*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: space-between; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); font-size: 0.92rem; font-weight: 780; transition: background 0.2s; text-decoration: none;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>Pages
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; transition: transform 0.2s ease; {{ Request::is('admin/pages*') ? 'transform: rotate(180deg);' : '' }}"><path d="m6 9 6 6 6-6"/></svg>
        </a>
        <div class="admin-submenu" style="{{ Request::is('admin/pages*') ? 'display: flex;' : 'display: none;' }} padding-left: 20px; margin-top: 4px; flex-direction: column; gap: 4px;">
            <a href="{{ route('admin.pages.index') }}" class="submenu-item {{ Request::is('admin/pages') && !Request::is('admin/pages/create') && !Request::is('admin/pages/*/edit') ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                All Pages
            </a>
            @php
                $createdPages = \App\Models\Page::orderBy('title', 'asc')->get();
            @endphp
            @foreach($createdPages as $dbPage)
                @php
                    $pageUrl = route('admin.pages.edit', $dbPage->id);
                    $isActiveSub = Request::is('admin/pages/' . $dbPage->id . '/edit') || (isset($page) && $page->id == $dbPage->id);
                @endphp
                <a href="{{ $pageUrl }}" class="submenu-item {{ $isActiveSub ? 'active' : '' }}" style="text-decoration: none;">
                    <span class="dot"></span>
                    {{ $dbPage->title }}
                </a>
            @endforeach
        </div>
    </div>

    
    <div class="admin-nav-group">
        <a href="javascript:void(0);" class="nav-toggle {{ Request::is('admin/seo-settings*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: space-between; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); font-size: 0.92rem; font-weight: 780; transition: background 0.2s; text-decoration: none;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                </svg>SEO Page Metadata
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; transition: transform 0.2s ease; {{ Request::is('admin/seo-settings*') ? 'transform: rotate(180deg);' : '' }}"><path d="m6 9 6 6 6-6"/></svg>
        </a>
        <div class="admin-submenu" style="{{ Request::is('admin/seo-settings*') ? 'display: flex;' : 'display: none;' }} padding-left: 20px; margin-top: 4px; flex-direction: column; gap: 4px;">
            @php
                $isFrontendActive = (Request::is('admin/seo-settings') && request('type', 'frontend') === 'frontend') || (Request::is('admin/seo-settings/*/edit') && isset($seoMetadata) && $seoMetadata->portal_type === 'frontend');
                $isUserActive = (Request::is('admin/seo-settings') && request('type') === 'user') || (Request::is('admin/seo-settings/*/edit') && isset($seoMetadata) && $seoMetadata->portal_type === 'user');
                $isVendorActive = (Request::is('admin/seo-settings') && request('type') === 'vendor') || (Request::is('admin/seo-settings/*/edit') && isset($seoMetadata) && $seoMetadata->portal_type === 'vendor');
            @endphp
            <a href="{{ route('admin.seo-settings.index', ['type' => 'frontend']) }}" class="submenu-item {{ $isFrontendActive ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                Frontend Pages
            </a>
            <a href="{{ route('admin.seo-settings.index', ['type' => 'user']) }}" class="submenu-item {{ $isUserActive ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                User Pages
            </a>
            <a href="{{ route('admin.seo-settings.index', ['type' => 'vendor']) }}" class="submenu-item {{ $isVendorActive ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                Vendor Pages
            </a>
        </div>
    </div>

    
    <div class="admin-nav-group">
        <a href="javascript:void(0);" class="nav-toggle {{ Request::is('admin/settings*') ? 'active' : '' }}" onclick="toggleSubmenu(this)" style="justify-content: space-between; display: flex; align-items: center; gap: 10px; min-height: 42px; padding: 10px 12px; border-radius: var(--radius); font-size: 0.92rem; font-weight: 780; transition: background 0.2s; text-decoration: none;">
            <span style="display: flex; align-items: center; gap: 10px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>Settings
            </span>
            <svg class="chevron" viewBox="0 0 24 24" style="width: 14px; height: 14px; transition: transform 0.2s ease; {{ Request::is('admin/settings*') ? 'transform: rotate(180deg);' : '' }}"><path d="m6 9 6 6 6-6"/></svg>
        </a>
        <div class="admin-submenu" style="{{ Request::is('admin/settings*') ? 'display: flex;' : 'display: none;' }} padding-left: 20px; margin-top: 4px; flex-direction: column; gap: 4px;">
            <a href="{{ route('admin.settings.general') }}" class="submenu-item {{ Request::is('admin/settings/general*') ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                General Contact
            </a>
            <a href="{{ route('admin.settings.payment') }}" class="submenu-item {{ Request::is('admin/settings/payment*') ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                Payment Gateway
            </a>
            <a href="{{ route('admin.settings.mail') }}" class="submenu-item {{ Request::is('admin/settings/mail*') ? 'active' : '' }}" style="text-decoration: none;">
                <span class="dot"></span>
                Mail Settings
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