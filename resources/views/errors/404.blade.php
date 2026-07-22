@extends('frontend.layout.main')

@section('title', '404 - Page Not Found | Rydaris')

@section('content')
  <main style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 80px 20px; background: radial-gradient(circle at 80% 0%, rgba(128, 167, 255, 0.18), transparent 30rem), radial-gradient(circle at 10% 15%, rgba(82, 234, 210, 0.18), transparent 26rem), #050711 !important; color: #f8fafc;">
    <div class="wrap" style="text-align: center; max-width: 680px; width: 100%;">
      
      <!-- 404 Large Gradient Text -->
      <div style="font-size: clamp(5rem, 15vw, 9.5rem); font-weight: 900; line-height: 1; letter-spacing: -0.05em; background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; filter: drop-shadow(0 10px 35px rgba(82, 234, 210, 0.3)); margin-bottom: 12px;">
        404
      </div>

      <!-- Eyebrow Tag -->
      <div style="margin-bottom: 20px;">
        <span style="display: inline-block; padding: 6px 18px; border-radius: 999px; background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.25); color: #52ead2; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">
          Page Not Found
        </span>
      </div>

      <!-- Main Title -->
      <h1 style="color: #ffffff !important; font-size: clamp(1.8rem, 4vw, 2.5rem); font-weight: 800; margin: 0 0 16px 0; line-height: 1.25;">
        Looks like you've taken a detour.
      </h1>

      <!-- Description -->
      <p style="color: #cbd5e1 !important; font-size: 1.05rem; line-height: 1.65; margin: 0 0 36px 0;">
        The page or route you are looking for might have been moved, renamed, or is temporarily unavailable.
      </p>

      <!-- Action Buttons -->
      <div class="actions" style="display: flex; gap: 14px; justify-content: center; align-items: center; flex-wrap: wrap;">
        <a class="btn primary" href="{{ route('home') }}" style="padding: 14px 32px; font-size: 1rem; border-radius: 999px; text-decoration: none; display: inline-flex; align-items: center;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
          </svg>
          Return Home
        </a>

        <a class="btn secondary" href="{{ route('contact') }}" style="padding: 14px 28px; font-size: 1rem; border-radius: 999px; text-decoration: none; color: #ffffff; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.18);">
          Contact Support
        </a>
      </div>

      <!-- Quick Helpful Links -->
      <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.1); display: flex; gap: 18px; justify-content: center; flex-wrap: wrap; font-size: 0.9rem; color: #64748b;">
        <span style="color: #94a3b8; font-weight: 600;">Popular destinations:</span>
        <a href="{{ route('pricing') }}" style="color: #52ead2; text-decoration: none;">Pricing Plans</a>
        <span style="color: #475569;">•</span>
        <a href="{{ route('faq') }}" style="color: #52ead2; text-decoration: none;">FAQ</a>
        <span style="color: #475569;">•</span>
        <a href="{{ route('about') }}" style="color: #52ead2; text-decoration: none;">About Us</a>
        <span style="color: #475569;">•</span>
        <a href="{{ route('login') }}" style="color: #52ead2; text-decoration: none;">Vendor Portal</a>
      </div>

    </div>
  </main>
@endsection
