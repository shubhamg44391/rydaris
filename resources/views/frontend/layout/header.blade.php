<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Rydaris | Car Rental Management System')</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/logo/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/styles.css') }}">
</head>
<body>
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
          @auth
            <span class="user-greeting" style="margin-right: 15px; font-weight: 500;">Hello, {{ Auth::user()->name }}</span>
            <a class="btn primary" href="{{ (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') ? route('dashboard') : (Auth::user()->role === 'user' ? route('user.dashboard') : route('vendor.dashboard')) }}" style="margin-right: 10px; text-decoration: none;">Dashboard</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="btn secondary" style="cursor: pointer; border: none; font-family: inherit; font-size: inherit;">Logout</button>
            </form>
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
          @auth
            <span class="user-greeting" style="font-weight: 500; color: var(--muted);">Hello, {{ Auth::user()->name }}</span>
            <a class="btn primary" href="{{ (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') ? route('dashboard') : (Auth::user()->role === 'user' ? route('user.dashboard') : route('vendor.dashboard')) }}" style="text-decoration: none; width: 100%; text-align: center;">Dashboard</a>
            <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
              @csrf
              <button type="submit" class="btn secondary" style="cursor: pointer; border: none; font-family: inherit; font-size: inherit; width: 100%;">Logout</button>
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
