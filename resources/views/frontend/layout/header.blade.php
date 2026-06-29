<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Rydaris | Car Rental Management System')</title>
  <link rel="stylesheet" href="{{ asset('assets/styles.css') }}">
</head>
<body>
  <div class="site-shell">
    <header class="site-header">
      <nav class="nav" aria-label="Main navigation">
        <a class="brand" href="{{ route('home') }}" aria-label="Rydaris home">
          <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 13h18l-2-5H5l-2 5Z"/><path d="M5 13v5"/><path d="M19 13v5"/><path d="M7 18h.01"/><path d="M17 18h.01"/></svg></span>
          Rydaris
        </a>
        <div class="nav-links">
          <a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
          <a class="{{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
          <a class="{{ request()->is('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}">Pricing</a>
          <a class="{{ request()->is('faq') ? 'active' : '' }}" href="{{ route('faq') }}">FAQ</a>
          <a class="{{ request()->is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
        </div>
        <div class="nav-actions">
          @auth
            <span class="user-greeting" style="margin-right: 15px; font-weight: 500;">Hello, {{ Auth::user()->name }}</span>
            <a class="btn primary" href="{{ (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') ? route('dashboard') : route('vendor.dashboard') }}" style="margin-right: 10px; text-decoration: none;">Dashboard</a>
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
    </header>
