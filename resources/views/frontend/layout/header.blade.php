<!DOCTYPE html>
<html lang="en">
<head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-HMW649RZV1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-HMW649RZV1');
</script>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', $seo_title ?? 'Rydaris | Car Rental Management System')</title>
  @if(isset($seo_description))
    <meta name="description" content="{{ $seo_description }}">
  @else
    @yield('meta_description')
  @endif
  @if(isset($seo_keyword) && $seo_keyword)
    <meta name="keywords" content="{{ $seo_keyword }}">
  @else
    @yield('meta_keywords')
  @endif
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/logo/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/styles.css') }}?v={{ time() }}">
</head>
<body>


  @include('partials.preloader')
  <div class="site-shell">
    <header class="site-header">
      <nav class="nav" aria-label="Main navigation">

        <!-- nav-row: logo left, hamburger right (always one line) -->
        <div class="nav-row">
          <a class="brand" href="{{ route('home') }}" aria-label="Rydaris home">
            <img src="{{ asset('assets/logo/rydaris-logo.png') }}" alt="Rydaris Logo" style="height: 32px; width: auto; display: block;">
          </a>

          <!-- Hamburger Button (mobile only) -->
          <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobileMenu">
            <svg class="ham-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" y1="6"  x2="21" y2="6"  class="ham-line top"/>
              <line x1="3" y1="12" x2="21" y2="12" class="ham-line mid"/>
              <line x1="3" y1="18" x2="21" y2="18" class="ham-line bot"/>
            </svg>
          </button>
        </div>

        <!-- Desktop Nav Links -->
        <div class="nav-links desktop-nav">
          <a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
          <a class="{{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
          <a class="{{ request()->is('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}">Pricing</a>
          <a class="{{ request()->is('faq') ? 'active' : '' }}" href="{{ route('faq') }}">FAQ</a>
          <a class="{{ request()->is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
        </div>

        <div class="nav-actions desktop-nav">
          <button type="button" class="btn primary" onclick="openDemoInquiryModal()" style="margin-right: 10px; border: none; cursor: pointer; font-family: inherit;">Site Demo</button>
          @auth
            {{-- User Avatar Dropdown --}}
            <div class="user-avatar-wrap" id="userAvatarWrap" style="position: relative; display: flex; align-items: center; cursor: pointer; user-select: none;" onclick="toggleUserDropdown()">
              <div class="user-avatar-circle" style="width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #52ead2, #3bb8a0); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.95rem; color: #0b1020; letter-spacing: 0.5px; box-shadow: 0 0 0 2px rgba(82,234,210,0.25); flex-shrink: 0;">
                {{ strtoupper(substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1)) }}
              </div>
              <span style="margin-left: 9px; font-weight: 500; font-size: 0.92rem; color: #f0f4f8;">{{ Auth::user()->first_name ?? Auth::user()->name }}</span>
              <svg style="margin-left: 6px; width: 14px; height: 14px; color: #a0aec0; transition: transform 0.2s;" id="userChevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>

              {{-- Dropdown Menu --}}
              <div id="userDropdownMenu" style="display: none; position: absolute; top: calc(100% + 12px); right: 0; background: #111620; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; min-width: 200px; box-shadow: 0 20px 60px rgba(0,0,0,0.5); z-index: 9999; overflow: hidden; padding: 6px 0;">
                <div style="padding: 12px 16px 10px; border-bottom: 1px solid rgba(255,255,255,0.06);">
                  <div style="font-weight: 600; color: #ffffff; font-size: 0.9rem;">{{ Auth::user()->first_name ?? Auth::user()->name }}</div>
                  <div style="color: #7a8a9a; font-size: 0.78rem; margin-top: 2px;">{{ Auth::user()->email }}</div>
                </div>
                <a href="{{ (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') ? route('dashboard') : (Auth::user()->role === 'user' ? route('user.dashboard') : route('vendor.dashboard')) }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; color: #c4cdd8; font-size: 0.88rem; text-decoration: none; transition: background 0.15s;" onmouseover="this.style.background='rgba(82,234,210,0.08)';this.style.color='#52ead2';" onmouseout="this.style.background='transparent';this.style.color='#c4cdd8';">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                  Dashboard
                </a>
                @if(Auth::user()->role === 'vendor')
                <a href="{{ route('vendor.profile.index') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; color: #c4cdd8; font-size: 0.88rem; text-decoration: none; transition: background 0.15s;" onmouseover="this.style.background='rgba(82,234,210,0.08)';this.style.color='#52ead2';" onmouseout="this.style.background='transparent';this.style.color='#c4cdd8';">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  My Profile
                </a>
                @endif
                <div style="border-top: 1px solid rgba(255,255,255,0.06); margin: 4px 0;"></div>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" style="display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 16px; background: none; border: none; cursor: pointer; color: #fc8181; font-size: 0.88rem; font-family: inherit; text-align: left; transition: background 0.15s;" onmouseover="this.style.background='rgba(252,129,129,0.08)';" onmouseout="this.style.background='transparent';">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                  </button>
                </form>
              </div>
            </div>
            <script>
              function toggleUserDropdown() {
                const menu = document.getElementById('userDropdownMenu');
                const chevron = document.getElementById('userChevron');
                const isOpen = menu.style.display === 'block';
                menu.style.display = isOpen ? 'none' : 'block';
                chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
              }
              document.addEventListener('click', function(e) {
                const wrap = document.getElementById('userAvatarWrap');
                const menu = document.getElementById('userDropdownMenu');
                const chevron = document.getElementById('userChevron');
                if (wrap && !wrap.contains(e.target)) {
                  menu.style.display = 'none';
                  chevron.style.transform = 'rotate(0deg)';
                }
              });
            </script>
          @else
            <a class="btn secondary" href="{{ route('login') }}" style="margin-right: 10px;">Login</a>
            <a class="btn primary" href="{{ route('vendor.register') }}">Register</a>
          @endauth
        </div>
      </nav>


      <!-- Mobile Drawer Menu -->
      <div class="mobile-menu" id="mobileMenu" aria-hidden="true">
        <div class="mobile-nav-links">
          <a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
          <a class="{{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
          <a class="{{ request()->is('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}">Pricing</a>
          <a class="{{ request()->is('faq') ? 'active' : '' }}" href="{{ route('faq') }}">FAQ</a>
          <a class="{{ request()->is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
        </div>
        <div class="mobile-nav-actions">
          <button type="button" class="btn primary" onclick="openDemoInquiryModal()" style="width: 100%; text-align: center; margin-bottom: 10px; border: none; cursor: pointer; font-family: inherit;">Site Demo</button>
          @auth
            <div style="display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 10px;">
              <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #52ead2, #3bb8a0); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; color: #0b1020; flex-shrink: 0;">
                {{ strtoupper(substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1)) }}
              </div>
              <div>
                <div style="font-weight: 600; color: #ffffff; font-size: 0.88rem;">{{ Auth::user()->first_name ?? Auth::user()->name }}</div>
                <div style="color: #7a8a9a; font-size: 0.75rem;">{{ Auth::user()->email }}</div>
              </div>
            </div>
            <a class="btn primary" href="{{ (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') ? route('dashboard') : (Auth::user()->role === 'user' ? route('user.dashboard') : route('vendor.dashboard')) }}" style="text-decoration: none; width: 100%; text-align: center;">Dashboard</a>
            @if(Auth::user()->role === 'vendor')
            <a class="btn secondary" href="{{ route('vendor.profile.index') }}" style="text-decoration: none; width: 100%; text-align: center; margin-top: 8px;">My Profile</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="width: 100%; margin-top: 8px;">
              @csrf
              <button type="submit" class="btn secondary" style="cursor: pointer; border: none; font-family: inherit; font-size: inherit; width: 100%; color: #fc8181;">Logout</button>
            </form>
          @else
            <a class="btn secondary" href="{{ route('login') }}" style="width: 100%; text-align: center;">Login</a>
            <a class="btn primary" href="{{ route('vendor.register') }}" style="width: 100%; text-align: center;">Register</a>
          @endauth
        </div>
      </div>

      <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        hamburgerBtn.addEventListener('click', function () {
          const isOpen = mobileMenu.classList.toggle('open');
          hamburgerBtn.classList.toggle('active', isOpen);
          hamburgerBtn.setAttribute('aria-expanded', isOpen);
          mobileMenu.setAttribute('aria-hidden', !isOpen);
        });

        // Close menu when a link is clicked
        mobileMenu.querySelectorAll('a').forEach(function(link) {
          link.addEventListener('click', function() {
            mobileMenu.classList.remove('open');
            hamburgerBtn.classList.remove('active');
            hamburgerBtn.setAttribute('aria-expanded', 'false');
            mobileMenu.setAttribute('aria-hidden', 'true');
          });
        });
      </script>
    </header>
