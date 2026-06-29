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

        <form class="card contact-panel contact-form" action="#" method="post">
          @csrf
          <div class="field-grid">
            <label>Full name
              <input type="text" name="name" placeholder="Your name">
            </label>
            <label>Work email
              <input type="email" name="email" placeholder="name@company.com">
            </label>
          </div>
          <div class="field-grid">
            <label>Company
              <input type="text" name="company" placeholder="Rental company name">
            </label>
            <label>Phone
              <input type="tel" name="phone" placeholder="+1 555 012 3456">
            </label>
          </div>
          <div class="field-grid">
            <label>Fleet size
              <select name="fleet-size">
                <option>1-25 vehicles</option>
                <option>26-100 vehicles</option>
                <option>101-300 vehicles</option>
                <option>300+ vehicles</option>
              </select>
            </label>
            <label>Primary need
              <select name="need">
                <option>Book a product demo</option>
                <option>Compare pricing plans</option>
                <option>Migrate from spreadsheets</option>
                <option>Discuss enterprise setup</option>
              </select>
            </label>
          </div>
          <label>What should we help with?
            <textarea name="message" placeholder="Tell us about your branches, fleet, current tools, booking process, and biggest operational bottleneck."></textarea>
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
@endsection
