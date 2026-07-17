    <footer class="footer">
      <div class="wrap footer-main">
        <div>
          <a class="brand" href="{{ route('home') }}" aria-label="Rydaris home" style="opacity: 0.9; transition: opacity 0.2s ease;">
            <img src="{{ asset('assets/logo/rydaris-logo.png') }}" alt="Rydaris Logo" style="height: 32px; width: auto; display: block;">
          </a>
          <p>Rydaris is an all-in-one car rental management platform built for modern fleet operators. Streamline reservations, manage vehicles, automate billing, and grow your rental business — all from one powerful dashboard.</p>
        </div>
        <div><h3>Product</h3><ul class="footer-links"><li><a href="{{ route('home') }}">Overview</a></li><li><a href="{{ route('pricing') }}">Pricing</a></li><li><a href="{{ route('faq') }}">FAQ</a></li></ul></div>
        <div><h3>Company</h3><ul class="footer-links"><li><a href="{{ route('about') }}">About us</a></li><li><a href="{{ route('contact') }}">Contact</a></li><li><a href="{{ route('contact') }}">Partners</a></li><li><a href="{{ route('contact') }}">Careers</a></li></ul></div>
        @php
            $helpCenterPage = \App\Models\Page::where('slug', 'help-center')->first();
            $roiGuidePage = \App\Models\Page::where('slug', 'roi-guide')->first();
            $fleetPlaybookPage = \App\Models\Page::where('slug', 'fleet-playbook')->first();
            $supportDeskPage = \App\Models\Page::where('slug', 'support-desk')->first();
            $sitemapPage = \App\Models\Page::where('slug', 'sitemap')->first();
            $securityPage = \App\Models\Page::where('slug', 'security')->first();
            $privacyPolicyPage = \App\Models\Page::where('slug', 'privacy-policy')->first();
        @endphp
        <div><h3>Resources</h3><ul class="footer-links"><li><a href="{{ $helpCenterPage ? route('frontend.page', 'help-center') : route('faq') }}">Help center</a></li><li><a href="{{ $roiGuidePage ? route('frontend.page', 'roi-guide') : route('pricing') }}">ROI guide</a></li><li><a href="{{ $fleetPlaybookPage ? route('frontend.page', 'fleet-playbook') : route('about') }}">Fleet playbook</a></li><li><a href="{{ $supportDeskPage ? route('frontend.page', 'support-desk') : route('contact') }}">Support desk</a></li><li><a href="{{ $sitemapPage ? route('frontend.page', 'sitemap') : route('sitemap.html') }}">Sitemap</a></li></ul></div>
        <div><h3>Legal</h3><ul class="footer-links"><li><a href="{{ $securityPage ? route('frontend.page', 'security') : route('faq') }}">Security</a></li><li><a href="{{ $privacyPolicyPage ? route('frontend.page', 'privacy-policy') : route('faq') }}">Privacy policy</a></li><li><a href="{{ route('terms') }}">Terms of service</a></li><li><a href="mailto:sales@rydaris.com">sales@rydaris.com</a></li></ul></div>
      </div>
      <div class="wrap footer-bottom">
        <span>Copyright © 2026 Rydaris. All rights reserved.</span>
        <div class="socials" aria-label="Social links"><a href="{{ route('contact') }}">X</a><a href="{{ route('contact') }}">in</a><a href="{{ route('contact') }}">yt</a><a href="{{ route('contact') }}">gh</a></div>
      </div>
    </footer>
  </div>

@include('partials.demo-inquiry-modal')
@include('partials.phone-input')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    initializeIntlTelInput('demo_inquiry_phone', 'demo_hidden_country_code', 'demo_hidden_contact_details');

    const demoForm = document.getElementById('demoInquiryForm');
    if (demoForm) {
      demoForm.addEventListener('submit', function () {
        const btn = this.querySelector('button[type="submit"]');
        if (!btn || btn.disabled) return;
        btn.disabled = true;
        btn.textContent = 'Submitting...';
      });
    }

    @if(session('demo_inquiry_success'))
      closeDemoInquiryModal();
      Swal.fire({
        title: 'Request Submitted!',
        text: @json(session('demo_inquiry_success')),
        icon: 'success',
        confirmButtonText: 'Great!',
        timer: 4500,
        timerProgressBar: true
      });
    @endif

    @if($errors->any() && old('first_name'))
      openDemoInquiryModal();
    @endif
  });
</script>
</body>
</html>
