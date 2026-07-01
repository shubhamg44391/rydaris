@extends('frontend.layout.main')

@section('title', 'Contact Us | Rydaris')

@section('content')
  <main>
    <section class="page-hero">
      <div class="wrap">
        <p class="eyebrow">Contact us</p>
        <h1 class="page-title">Bring your rental workflow into one connected workspace.</h1>
        <p class="lead">Share your fleet size, branches, current tools, and operational goals. A Rydaris product specialist can recommend a plan and demo path.</p>
      </div>
    </section>

    <section class="section light">
      <div class="wrap contact-layout">
        <aside class="card contact-panel">
          <p class="eyebrow">Sales and onboarding</p>
          <h2>Talk to the Rydaris team.</h2>
          <p>Use this form for demos, pricing, onboarding, partnerships, support routing, or migration questions.</p>
          <ul class="list">
            <li><span class="check">✓</span><span>Plan recommendation for your fleet size</span></li>
            <li><span class="check">✓</span><span>Workflow review for reservations and returns</span></li>
            <li><span class="check">✓</span><span>Migration discussion for existing data</span></li>
            <li><span class="check">✓</span><span>Response within one business day</span></li>
          </ul>
          <div class="grid cols-2 contact-details">
            <div><h3>Email</h3><p>sales@rydaris.com<br>support@rydaris.com</p></div>
            <div><h3>Hours</h3><p>Monday to Friday<br>9:00 AM to 6:00 PM</p></div>
          </div>
        </aside>

        <form class="card contact-panel contact-form" action="{{ route('contact.submit') }}" method="post">
          @csrf
          <div class="field-grid">
            <label>Full name
              <input type="text" name="name" class="@error('name') is-invalid @enderror" placeholder="Your name" value="{{ old('name') }}">
              @error('name')
                <span class="backend-error" style="color: #ef4444; font-size: 0.8rem; display: block; margin-top: 4px;">{{ $message }}</span>
              @enderror
            </label>
            <label>Work email
              <input type="email" name="email" class="@error('email') is-invalid @enderror" placeholder="name@company.com" value="{{ old('email') }}">
              @error('email')
                <span class="backend-error" style="color: #ef4444; font-size: 0.8rem; display: block; margin-top: 4px;">{{ $message }}</span>
              @enderror
            </label>
          </div>
          <div class="field-grid">
            <label>Company
              <input type="text" name="company" class="@error('company') is-invalid @enderror" placeholder="Rental company name" value="{{ old('company') }}">
              @error('company')
                <span class="backend-error" style="color: #ef4444; font-size: 0.8rem; display: block; margin-top: 4px;">{{ $message }}</span>
              @enderror
            </label>
            <label>Phone
              <input type="tel" name="phone" class="@error('phone') is-invalid @enderror" placeholder="+1 555 012 3456" value="{{ old('phone') }}">
              @error('phone')
                <span class="backend-error" style="color: #ef4444; font-size: 0.8rem; display: block; margin-top: 4px;">{{ $message }}</span>
              @enderror
            </label>
          </div>
          <div class="field-grid">
            <label>Fleet size
              <select name="fleet_size" class="@error('fleet_size') is-invalid @enderror">
                <option value="1-25 vehicles" {{ old('fleet_size') === '1-25 vehicles' ? 'selected' : '' }}>1-25 vehicles</option>
                <option value="26-100 vehicles" {{ old('fleet_size') === '26-100 vehicles' ? 'selected' : '' }}>26-100 vehicles</option>
                <option value="101-300 vehicles" {{ old('fleet_size') === '101-300 vehicles' ? 'selected' : '' }}>101-300 vehicles</option>
                <option value="300+ vehicles" {{ old('fleet_size') === '300+ vehicles' ? 'selected' : '' }}>300+ vehicles</option>
              </select>
              @error('fleet_size')
                <span class="backend-error" style="color: #ef4444; font-size: 0.8rem; display: block; margin-top: 4px;">{{ $message }}</span>
              @enderror
            </label>
            <label>Primary need
              <select name="need" class="@error('need') is-invalid @enderror">
                <option value="Book a product demo" {{ old('need') === 'Book a product demo' ? 'selected' : '' }}>Book a product demo</option>
                <option value="Compare pricing plans" {{ old('need') === 'Compare pricing plans' ? 'selected' : '' }}>Compare pricing plans</option>
                <option value="Migrate from spreadsheets" {{ old('need') === 'Migrate from spreadsheets' ? 'selected' : '' }}>Migrate from spreadsheets</option>
                <option value="Discuss enterprise setup" {{ old('need') === 'Discuss enterprise setup' ? 'selected' : '' }}>Discuss enterprise setup</option>
              </select>
              @error('need')
                <span class="backend-error" style="color: #ef4444; font-size: 0.8rem; display: block; margin-top: 4px;">{{ $message }}</span>
              @enderror
            </label>
          </div>
          <label>What should we help with?
            <textarea name="message" class="@error('message') is-invalid @enderror" placeholder="Tell us about your branches, fleet, current tools, booking process, and biggest operational bottleneck.">{{ old('message') }}</textarea>
            @error('message')
              <span class="backend-error" style="color: #ef4444; font-size: 0.8rem; display: block; margin-top: 4px;">{{ $message }}</span>
            @enderror
          </label>
          <button class="btn primary" type="submit"><svg viewBox="0 0 24 24"><path d="M22 2 11 13"/><path d="m22 2-7 20-4-9-9-4 20-7Z"/></svg>Send Message</button>
        </form>
      </div>
    </section>

    <section class="section dark">
      <div class="wrap">
        <p class="eyebrow">Before the demo</p>
        <h2>Helpful details to prepare.</h2>
        <div class="grid cols-4">
          <article class="card feature-card"><h3>Fleet count</h3><p>Number of vehicles, vehicle classes, and branches currently operating.</p></article>
          <article class="card feature-card"><h3>Booking channels</h3><p>Walk-ins, website inquiries, phone bookings, travel desks, corporate accounts, or partners.</p></article>
          <article class="card feature-card"><h3>Billing process</h3><p>How deposits, invoices, taxes, add-ons, refunds, and unpaid balances are handled now.</p></article>
          <article class="card feature-card"><h3>Launch timing</h3><p>Whether you need a quick rollout, phased setup, migration, or enterprise implementation.</p></article>
        </div>
      </div>
    </section>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      // Show SweetAlert success notification if success session is present
      @if(session('success'))
        Swal.fire({
          title: 'Success!',
          text: "{{ session('success') }}",
          icon: 'success',
          confirmButtonColor: '#0e766f',
          confirmButtonText: 'OK'
        });
      @endif

      $(".contact-form").validate({
        rules: {
          name: {
            required: true,
            minlength: 2
          },
          email: {
            required: true,
            email: true
          },
          company: {
            required: true
          },
          phone: {
            required: true
          },
          fleet_size: {
            required: true
          },
          need: {
            required: true
          },
          message: {
            required: true,
            minlength: 10
          }
        },
        messages: {
          name: {
            required: "Please enter your name.",
            minlength: "Name must be at least 2 characters."
          },
          email: {
            required: "Please enter your email.",
            email: "Please enter a valid email address."
          },
          company: {
            required: "Please enter your company name."
          },
          phone: {
            required: "Please enter your phone number."
          },
          fleet_size: {
            required: "Please select your fleet size."
          },
          need: {
            required: "Please select your primary need."
          },
          message: {
            required: "Please enter your message.",
            minlength: "Message must be at least 10 characters."
          }
        },
        errorElement: "span",
        errorPlacement: function(error, element) {
          // Remove existing backend error span if any to avoid duplicate error messages
          element.parent().find('.backend-error').remove();
          
          error.css({
            "color": "#ef4444",
            "font-size": "0.8rem",
            "display": "block",
            "margin-top": "4px"
          });
          element.parent().append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass("is-invalid");
        },
        submitHandler: function(form) {
          var btn = $(form).find('button[type="submit"]');
          btn.prop('disabled', true);
          btn.html('<svg class="spinner-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg> Sending...');
          form.submit();
        }
      });
    });
  </script>
@endsection
