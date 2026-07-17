@extends('frontend.layout.main')

@section('title', $seo_title ?? 'Sitemap | Rydaris')

@section('content')
  <main style="background: #050711; color: #f8fafc; min-height: 100vh; padding-bottom: 80px;">

    {{-- Page Hero --}}
    <section class="page-hero" style="padding: 80px 0 40px; text-align: center; background: radial-gradient(circle at top, rgba(82, 234, 210, 0.08) 0%, transparent 60%);">
      <div class="wrap" style="text-align: center;">
        <p class="eyebrow" style="justify-content: center;">Sitemap</p>
        <h1 class="page-title" style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; color: #ffffff; margin: 0 auto 16px; text-align: center;">Visual Site Navigation</h1>
        <p class="lead" style="color: #94a3b8; font-size: 1.05rem; max-width: 580px; margin: 0 auto; line-height: 1.7; text-align: center;">Find every page and feature across the Rydaris platform, organized by section.</p>
      </div>
    </section>

    {{-- Cards Grid --}}
    <section class="section" style="padding: 40px 0 60px;">
      <div class="wrap">
        <div class="grid cols-3">

          {{-- Main Website --}}
          <article class="feature-card">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
              <span class="icon" style="flex-shrink: 0;">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
              </span>
              <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #ffffff;">Main Website</h3>
            </div>
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 13px;">
              <li><a href="{{ url('/') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Overview / Home
              </a></li>
              <li><a href="{{ url('/about') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                About Rydaris
              </a></li>
              <li><a href="{{ url('/pricing') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Pricing Plans
              </a></li>
              <li><a href="{{ url('/faq') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Frequently Asked Questions
              </a></li>
              <li><a href="{{ url('/contact') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Contact &amp; Support
              </a></li>
              <li><a href="{{ url('/terms-of-service') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Terms of Service
              </a></li>
            </ul>
          </article>

          {{-- Customer Panel --}}
          <article class="feature-card">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
              <span class="icon" style="flex-shrink: 0;">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
              </span>
              <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #ffffff;">Customer Panel</h3>
            </div>
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 13px;">
              <li><a href="{{ url('/user/login') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Customer Login
              </a></li>
              <li><a href="{{ url('/register') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Customer Register
              </a></li>
              <li><a href="{{ url('/user/dashboard') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                User Dashboard
              </a></li>
              <li><a href="{{ url('/user/bookings') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                My Bookings
              </a></li>
              <li><a href="{{ url('/user/support-tickets') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Support Ticket Center
              </a></li>
              <li><a href="{{ url('/user/support-tickets/create') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Create Support Ticket
              </a></li>
            </ul>
          </article>

          {{-- Vendor Panel --}}
          <article class="feature-card">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
              <span class="icon" style="flex-shrink: 0;">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
              </span>
              <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #ffffff;">Vendor Panel</h3>
            </div>
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 13px;">
              <li><a href="{{ url('/vendor/register') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Become a Vendor
              </a></li>
              <li><a href="{{ url('/vendor/login') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Vendor Login
              </a></li>
              <li><a href="{{ url('/vendor/dashboard') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Vendor Dashboard
              </a></li>
              <li><a href="{{ url('/vendor/vehicles') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Fleet Management
              </a></li>
              <li><a href="{{ url('/vendor/groups') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Vehicle Groups
              </a></li>
              <li><a href="{{ url('/vendor/locations') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Pickup &amp; Return Locations
              </a></li>
              <li><a href="{{ url('/vendor/availability') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Availability &amp; Rates Settings
              </a></li>
              <li><a href="{{ url('/vendor/coupons') }}" style="color: #cbd5e1; text-decoration: none; font-size: 0.92rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='#52ead2'" onmouseout="this.style.color='#cbd5e1'">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#52ead2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                Vendor Coupons &amp; Offers
              </a></li>
            </ul>
          </article>

        </div>
      </div>
    </section>

  </main>
@endsection
