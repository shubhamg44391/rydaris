<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed" dir="ltr"
  data-theme="theme-default" data-assets-path="{{ asset('assets/admin/')}}"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', $seo_title ?? 'Rydaris Admin Dashboard')</title>
  <meta name="description" content="{{ $seo_description ?? 'Rydaris is the ultimate car rental management software designed for fleet operations, reservation booking, and real-time damage tracking.' }}" />
  @if(isset($seo_keyword) && $seo_keyword)
    <meta name="keywords" content="{{ $seo_keyword }}" />
  @else
    @yield('meta_keywords')
  @endif

  
  <link class="favicon" rel="icon" type="image/png" href="{{ !empty($site_setting->favicon) ? asset('storage/' . $site_setting->favicon) : asset('assets/logo/favicon.png') }}" />

  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/boxicons.css')}}">

  
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/core.css')}}"
    class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/theme-default.css')}}"
    class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('assets/admin/css/demo.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
  <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/apex-charts/apex-charts.css')}}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="{{ asset('assets/styles.css') }}?v={{ time() }}" />

  <style>
    /* Force Premium Glassmorphism SweetAlert2 Redesign */
    body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) { background-color: rgba(5, 7, 17, 0.4) !important; backdrop-filter: blur(8px) !important; }
    div.swal2-container.swal2-backdrop-show { background: transparent !important; }
    div.swal2-popup { background: rgba(11, 16, 32, 0.95) !important; backdrop-filter: blur(16px) !important; border: 1px solid rgba(82, 234, 210, 0.25) !important; border-radius: 16px !important; color: #f8fafc !important; box-shadow: 0 0 40px rgba(82, 234, 210, 0.1), 0 24px 80px rgba(0, 0, 0, 0.5) !important; padding: 2.5em 2em !important; }
    div.swal2-title { color: #f8fafc !important; font-size: 1.5rem !important; font-weight: 700 !important; letter-spacing: -0.02em !important; margin-bottom: 0.5em !important; }
    div.swal2-html-container { color: #a8b3c5 !important; font-size: 1.05rem !important; line-height: 1.6 !important; }
    .swal2-icon.swal2-success { border-color: rgba(82, 234, 210, 0.5) !important; color: #52ead2 !important; box-shadow: 0 0 20px rgba(82, 234, 210, 0.1) !important; }
    .swal2-icon.swal2-success .swal2-success-ring { border-color: rgba(82, 234, 210, 0.4) !important; }
    .swal2-icon.swal2-success [class^=swal2-success-line] { background-color: #52ead2 !important; }
    .swal2-actions { margin-top: 2em !important; gap: 12px !important; }
    .swal2-confirm, .swal2-styled.swal2-confirm { background: linear-gradient(135deg, #52ead2, #2bc2a8) !important; color: #050711 !important; font-weight: 600 !important; border-radius: 8px !important; padding: 12px 28px !important; border: none !important; box-shadow: 0 8px 16px rgba(82, 234, 210, 0.2) !important; transition: all 0.3s ease !important; }
    
    /* Premium Global Scrollbar Customization */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }
    ::-webkit-scrollbar-track {
        background: #0b1020 !important;
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(82, 234, 210, 0.15) !important;
        border-radius: 10px !important;
        border: 2px solid #0b1020 !important;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(82, 234, 210, 0.35) !important;
    }

    /* Premium Global Scrollbar Customization in Light Mode */
    body.light-mode ::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
    }
    body.light-mode ::-webkit-scrollbar-thumb {
        background: rgba(15, 23, 42, 0.15) !important;
        border: 2px solid #f1f5f9 !important;
        border-radius: 10px !important;
    }
    body.light-mode ::-webkit-scrollbar-thumb:hover {
        background: rgba(15, 23, 42, 0.3) !important;
    }
    body.light-mode * {
        scrollbar-color: rgba(15, 23, 42, 0.15) #f1f5f9 !important;
    }
    
    /* Make Sidebar Scrollable & Elegant */
    .admin-sidebar {
        overflow-y: auto !important;
    }
    .admin-sidebar::-webkit-scrollbar {
        width: 4px;
    }
    .admin-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    .admin-sidebar::-webkit-scrollbar-thumb {
        background: rgba(82, 234, 210, 0.2) !important;
        border-radius: 10px;
    }
    .admin-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(82, 234, 210, 0.4) !important;
    }
    
    select#headerBranchSelect option {
        background-color: var(--bg-2) !important;
        color: var(--text) !important;
    }
  </style>

  
  <script src="{{ asset('assets/admin/vendor/js/helpers.js')}}"></script>

  
  
  <script src="{{ asset('assets/admin/js/config.js')}}"></script>
  <style>
    canvas {
      border: 1px dotted red;
    }

    .chart-container {
      position: relative;
      margin: auto;
      height: 80vh;
      width: 80vw;
    }
    
    /* Enforce Dark Theme on Sneat Layout elements */
    body, html, .layout-wrapper, .layout-container, .layout-page, .content-wrapper {
      background-color: var(--bg) !important;
      color: var(--text) !important;
    }
  </style>
  <script>
    (function() {
      const savedTheme = localStorage.getItem('rydaris_theme') || 'dark';
      if (savedTheme === 'light') {
        document.documentElement.classList.add('light-mode');
      }
    })();
  </script>
</head>

<body class="admin-body">
  <script>
    (function() {
      const savedTheme = localStorage.getItem('rydaris_theme') || 'dark';
      if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
      }
    })();
  </script>
  @include('partials.preloader')
  
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
  <div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Admin navigation">
      <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; padding-bottom: 10px;">
        <a class="brand" href="{{ Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') ? route('dashboard') : (Auth::user()->role === 'user' ? route('user.dashboard') : route('vendor.dashboard')) }}" aria-label="Rydaris home" style="opacity: 0.9; transition: opacity 0.2s ease; display: flex; align-items: center; justify-content: center;">
          <img class="brand-full" src="{{ !empty($site_setting->site_logo) ? asset('storage/' . $site_setting->site_logo) : asset('assets/logo/rydaris-logo.png') }}" data-dark-logo="{{ !empty($site_setting->site_logo) ? asset('storage/' . $site_setting->site_logo) : asset('assets/logo/rydaris-logo.png') }}" data-light-logo="{{ !empty($site_setting->site_logo_light) ? asset('storage/' . $site_setting->site_logo_light) : asset('assets/logo/rydaris-logo-light.png') }}" alt="Rydaris Logo" style="height: 32px; width: auto; display: block;">
          <img class="brand-mini" src="{{ !empty($site_setting->favicon) ? asset('storage/' . $site_setting->favicon) : asset('assets/logo/favicon.svg') }}" alt="Rydaris Logo" style="height: 32px; width: auto; display: none;">
        </a>
        <button class="sidebar-close-btn" onclick="closeSidebar()" aria-label="Close menu">
          <svg viewBox="0 0 24 24" style="width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:2;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>

      @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin'))
          @include('admin.layouts.sidebar')
      @else
          @include('vendor.layouts.sidebar')
      @endif
    </aside>

    <main class="admin-main" style="display: flex; flex-direction: column; min-height: 100vh;">
      <header class="admin-topbar">
        <div style="display: flex; align-items: center; gap: 15px;">
          <button class="hamburger-btn" id="hamburgerBtn" onclick="openSidebar()" aria-label="Open menu">
            <svg viewBox="0 0 24 24" style="width:22px;height:22px;fill:none;stroke:currentColor;stroke-width:2;"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </button>
          <button class="desktop-collapse-btn" onclick="toggleSidebarCollapse()" aria-label="Collapse sidebar">
            <svg class="chevron-left-icon" viewBox="0 0 24 24" style="width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:2;"><polyline points="15 18 9 12 15 6"/></svg>
            <svg class="chevron-right-icon" viewBox="0 0 24 24" style="width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:2;display:none;"><polyline points="9 18 15 12 9 6"/></svg>
          </button>

          
          <a href="{{ route('home') }}" target="_blank" class="visit-website-btn"
             style="display: inline-flex; align-items: center; gap: 7px; padding: 7px 14px; background: rgba(82,234,210,0.08); border: 1px solid rgba(82,234,210,0.2); border-radius: 8px; color: #52ead2; font-size: 0.82rem; font-weight: 600; text-decoration: none; transition: all 0.2s ease; white-space: nowrap;"
             onmouseover="this.style.background='rgba(82,234,210,0.15)'; this.style.borderColor='rgba(82,234,210,0.4)';"
             onmouseout="this.style.background='rgba(82,234,210,0.08)'; this.style.borderColor='rgba(82,234,210,0.2)';">
            <svg viewBox="0 0 24 24" style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;flex-shrink:0;">
              <circle cx="12" cy="12" r="10"/>
              <line x1="2" y1="12" x2="22" y2="12"/>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </svg>
            <span class="btn-text">Visit Website</span>
          </a>
        </div>
        <div class="admin-toolbar" style="display: flex; align-items: center; gap: 15px;">
          @if(Auth::check() && Auth::user()->role === 'vendor')
              @php
                  $vendorBranches = Auth::user()->branches()->where('status', true)->get();
                  $currentBranchId = Auth::user()->current_branch_id;
              @endphp
              <div class="branch-selector-wrap" style="position: relative; display: inline-flex; align-items: center; gap: 6px;">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="branch-icon" style="width: 15px; height: 15px; color: #52ead2; flex-shrink: 0;">
                      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                      <polyline points="9 22 9 12 15 12 15 22" />
                  </svg>
                  <span class="branch-label" style="font-size: 0.82rem; font-weight: 700; color: #94a3b8;">Branch:</span>
                  <select id="headerBranchSelect" class="header-branch-select" onchange="switchVendorBranch(this.value)" style="background: rgba(82, 234, 210, 0.08); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 8px; padding: 5px 28px 5px 10px; font-size: 0.83rem; font-weight: 700; cursor: pointer; outline: none; appearance: none; -webkit-appearance: none; -moz-appearance: none; transition: all 0.2s;">
                      <option value="" {{ is_null($currentBranchId) ? 'selected' : '' }}>All Branches</option>
                      @foreach($vendorBranches as $b)
                          <option value="{{ $b->id }}" {{ $currentBranchId == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                      @endforeach
                  </select>
                  <svg class="branch-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px; position: absolute; right: 10px; pointer-events: none; color: #52ead2;">
                      <polyline points="6 9 12 15 18 9"/>
                  </svg>
              </div>
          @endif

          <!-- Theme Toggle Button -->
          <button type="button" class="theme-toggle-btn" onclick="toggleThemeMode()" title="Toggle Light/Dark Theme" aria-label="Toggle Light/Dark Theme">
            <svg class="themeSunIcon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
              <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
            </svg>
            <svg class="themeMoonIcon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
          </button>

          <!-- Profile Dropdown Component -->
          <div class="profile-dropdown-container" style="position: relative; display: inline-block; line-height: 1;">
              <button type="button" class="profile-trigger-btn" id="profileDropdownTrigger" style="background: rgba(82, 234, 210, 0.08); border: 1px solid rgba(82, 234, 210, 0.25); padding: 4px 12px 4px 6px; border-radius: 999px; cursor: pointer; display: flex; align-items: center; gap: 8px; color: var(--text, #f8fafc); transition: all 0.2s; outline: none;">
                  <span class="user-avatar-circle" style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #52ead2, #80a7ff); color: #051013; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.82rem; flex-shrink: 0;">
                      {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                  </span>
                  <span class="header-user-name" style="font-size: 0.85rem; font-weight: 700; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                      {{ explode(' ', Auth::user()->name ?? '')[0] }}
                  </span>
                  <svg viewBox="0 0 24 24" class="profile-arrow-icon" style="width:12px; height:12px; fill:none; stroke:currentColor; stroke-width:2.5; flex-shrink: 0; color: #52ead2;"><polyline points="6 9 12 15 18 9"/></svg>
              </button>
              <div class="profile-dropdown-menu" id="profileDropdownMenu" style="display: none; position: absolute; right: 0; top: 45px; width: 220px; background: #0b1020; border: 1px solid var(--line, rgba(255,255,255,0.1)); border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); z-index: 1000; padding: 6px 0; overflow: hidden;">
                  <!-- User Info Header -->
                  <div style="padding: 12px 16px; border-bottom: 1px solid var(--line, rgba(255,255,255,0.05));">
                      <div style="font-weight: 600; color: var(--text, #f8fafc); font-size: 0.9rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; text-align: left;">{{ Auth::user()->name }}</div>
                      <div style="font-size: 0.78rem; color: var(--muted, #aab7cb); margin-top: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; text-align: left;">{{ Auth::user()->email }}</div>
                  </div>
                  <!-- Menu Links -->
                  @if(Auth::check() && Auth::user()->role === 'vendor')
                  <a href="{{ route('vendor.profile.index') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; color: var(--text, #f8fafc); text-decoration: none; font-size: 0.85rem; transition: background 0.15s; text-align: left;" onmouseover="this.style.background='rgba(82, 234, 210, 0.08)';" onmouseout="this.style.background='transparent';">
                      <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--brand, #52ead2); flex-shrink: 0;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                      My Profile
                  </a>
                  @endif

                  <div style="border-top: 1px solid var(--line, rgba(255,255,255,0.05)); margin-top: 5px; padding-top: 5px;">
                      <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                          @csrf
                          <button type="submit" style="width: 100%; border: none; background: transparent; display: flex; align-items: center; gap: 10px; padding: 10px 16px; color: #f43f5e; text-decoration: none; font-size: 0.85rem; text-align: left; cursor: pointer; transition: background 0.15s; font-family: inherit; outline: none;" onmouseover="this.style.background='rgba(244, 63, 94, 0.08)';" onmouseout="this.style.background='transparent';">
                              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="transform: rotate(180deg); flex-shrink: 0;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                              Logout
                          </button>
                      </form>
                  </div>
              </div>
          </div>
        </div>
      </header>

      <div class="admin-content" style="flex: 1; padding: 24px;">
        @yield('main-content')
      </div>
      
      
      
    </main>
  </div>

  
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.min.js"></script>
  <script src="{{ asset('assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
  <script src="{{ asset('assets/admin/vendor/libs/popper/popper.js')}}"></script>
  <script src="{{ asset('assets/admin/vendor/js/bootstrap.js')}}"></script>
  <script src="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

  <script src="{{ asset('assets/admin/vendor/js/menu.js')}}"></script>
  

  
  <script src="{{ asset('assets/admin/vendor/libs/apex-charts/apexcharts.js')}}"></script>

  
  <script src="{{ asset('assets/admin/js/main.js')}}"></script>

  
  <script src="{{ asset('assets/admin/js/dashboards-analytics.js')}}"></script>

  
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  @yield('js')

  @if(session('success'))
  <script>
      Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: '{{ session('success') }}',
          confirmButtonText: 'OK'
      });
  </script>
  @endif

  @if(session('error'))
  <script>
      Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: '{{ session('error') }}',
          confirmButtonText: 'OK'
      });
  </script>
  @endif

  <script>
    // Theme Switcher Functions
    function syncThemeIcons() {
      const isLight = document.body ? document.body.classList.contains('light-mode') : document.documentElement.classList.contains('light-mode');
      document.querySelectorAll('.themeSunIcon').forEach(function(el) {
        el.style.display = isLight ? 'none' : 'block';
      });
      document.querySelectorAll('.themeMoonIcon').forEach(function(el) {
        el.style.display = isLight ? 'block' : 'none';
      });
      
      // Update logo dynamically
      document.querySelectorAll('.brand-full').forEach(function(img) {
        const darkLogo = img.getAttribute('data-dark-logo');
        const lightLogo = img.getAttribute('data-light-logo');
        if (isLight && lightLogo) {
          img.src = lightLogo;
        } else if (!isLight && darkLogo) {
          img.src = darkLogo;
        }
      });
    }

    function toggleThemeMode() {
      if (document.body) document.body.classList.toggle('light-mode');
      document.documentElement.classList.toggle('light-mode');
      const isLight = document.body ? document.body.classList.contains('light-mode') : document.documentElement.classList.contains('light-mode');
      localStorage.setItem('rydaris_theme', isLight ? 'light' : 'dark');
      syncThemeIcons();

      // Dynamically update active CKEditor instances background & text color
      if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances) {
        for (let name in CKEDITOR.instances) {
          const inst = CKEDITOR.instances[name];
          if (inst && inst.document && inst.document.getBody()) {
            const body = inst.document.getBody();
            if (isLight) {
              body.setStyle('background-color', '#ffffff');
              body.setStyle('color', '#0f172a');
            } else {
              body.setStyle('background-color', '#050711');
              body.setStyle('color', '#f8fafc');
            }
          }
        }
      }
    }

    document.addEventListener('DOMContentLoaded', syncThemeIcons);
    if (document.body) syncThemeIcons();

    function openSidebar() {
      const sidebar = document.getElementById('adminSidebar');
      const overlay = document.getElementById('sidebarOverlay');
      if (sidebar) sidebar.classList.add('open');
      if (overlay) { overlay.style.display = 'block'; setTimeout(() => overlay.classList.add('visible'), 10); }
    }
    function closeSidebar() {
      const sidebar = document.getElementById('adminSidebar');
      const overlay = document.getElementById('sidebarOverlay');
      if (sidebar) sidebar.classList.remove('open');
      if (overlay) { overlay.classList.remove('visible'); setTimeout(() => overlay.style.display = 'none', 300); }
    }
    function toggleSidebarCollapse() {
      const body = document.body;
      body.classList.toggle('sidebar-collapsed');
      const isCollapsed = body.classList.contains('sidebar-collapsed');
      localStorage.setItem('sidebar-collapsed', isCollapsed);
    }
    // Close sidebar on nav link click (mobile)
    document.querySelectorAll('#adminSidebar .admin-nav a').forEach(function(link) {
      link.addEventListener('click', function() { if (window.innerWidth <= 1180) closeSidebar(); });
    });
    // Restore collapse state on load
    if (localStorage.getItem('sidebar-collapsed') === 'true') {
      document.body.classList.add('sidebar-collapsed');
    }

    // Profile Dropdown Toggle Logic
    document.addEventListener('DOMContentLoaded', function() {
      const trigger = document.getElementById('profileDropdownTrigger');
      const menu = document.getElementById('profileDropdownMenu');
      
      if (trigger && menu) {
        trigger.addEventListener('click', function(e) {
          e.stopPropagation();
          const isOpen = menu.style.display === 'block';
          menu.style.display = isOpen ? 'none' : 'block';
          trigger.classList.toggle('active', !isOpen);
        });
        
        document.addEventListener('click', function(e) {
          if (!trigger.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = 'none';
            trigger.classList.remove('active');
          }
        });
      }
    });

    function switchVendorBranch(branchId) {
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      fetch("{{ route('vendor.branches.select') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ branch_id: branchId })
      })
      .then(res => res.json())
      .then(data => {
        if(data.status === 'success') {
          window.location.reload();
        } else {
          alert(data.message || 'Error switching branch.');
        }
      })
      .catch(err => {
        console.error('Error switching branch:', err);
        window.location.reload();
      });
    }
  </script>
</body>

</html>
