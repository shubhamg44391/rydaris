@extends('frontend.layout.main')

@section('title', 'Pricing | Rydaris')

@section('content')
  <main>
    <section class="page-hero">
      <div class="wrap">
        <p class="eyebrow">Pricing</p>
        <h1 class="page-title">Plans for every stage of fleet growth.</h1>
        <p class="lead">Choose the operating depth you need today, then expand into advanced reporting, branch controls, integrations, and guided onboarding as your rental business scales.</p>
      </div>
    </section>

    <section class="section light">
      <div class="wrap">
        <div class="grid cols-3">
          <article class="card pricing-card">
            <p class="eyebrow">Starter</p><h2>Launch</h2><p>For small operators formalizing day-to-day reservations and vehicle records.</p>
            <div class="price"><strong>$79</strong><span>/ month</span></div>
            <ul class="list"><li><span class="check">✓</span><span>Up to 25 vehicles</span></li><li><span class="check">✓</span><span>Reservation calendar</span></li><li><span class="check">✓</span><span>Customer and agreement records</span></li><li><span class="check">✓</span><span>Basic invoices and deposits</span></li><li><span class="check">✓</span><span>Email support</span></li></ul>
            <div class="actions left"><a class="btn secondary" href="{{ route('contact') }}">Start Launch</a></div>
          </article>
          <article class="card pricing-card featured">
            <p class="eyebrow">Most selected</p><h2>Growth</h2><p>For active rental teams managing higher booking volume and multiple staff roles.</p>
            <div class="price"><strong>$189</strong><span>/ month</span></div>
            <ul class="list"><li><span class="check">✓</span><span>Up to 100 vehicles</span></li><li><span class="check">✓</span><span>Multi-branch availability</span></li><li><span class="check">✓</span><span>Inspection and maintenance logs</span></li><li><span class="check">✓</span><span>Revenue and utilization dashboards</span></li><li><span class="check">✓</span><span>Priority onboarding support</span></li></ul>
            <div class="actions left"><a class="btn primary" href="{{ route('contact') }}">Book Growth Demo</a></div>
          </article>
          <article class="card pricing-card">
            <p class="eyebrow">Scale</p><h2>Enterprise</h2><p>For regional fleets needing advanced permissions, integrations, and launch support.</p>
            <div class="price"><strong>Custom</strong><span></span></div>
            <ul class="list"><li><span class="check">✓</span><span>Unlimited fleet bands</span></li><li><span class="check">✓</span><span>Custom approval workflows</span></li><li><span class="check">✓</span><span>Accounting and API integrations</span></li><li><span class="check">✓</span><span>Dedicated success manager</span></li><li><span class="check">✓</span><span>Custom reports and data exports</span></li></ul>
            <div class="actions left"><a class="btn secondary" href="{{ route('contact') }}">Talk to Sales</a></div>
          </article>
        </div>
      </div>
    </section>

    <section class="section soft">
      <div class="wrap">
        <p class="eyebrow">Compare plans</p>
        <h2>Pick the right operational layer.</h2>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Feature</th><th>Launch</th><th>Growth</th><th>Enterprise</th></tr></thead>
            <tbody>
              <tr><td>Fleet dashboard</td><td>Single branch</td><td>Multi-branch</td><td>Advanced regions</td></tr>
              <tr><td>Digital rental agreements</td><td>Included</td><td>Included</td><td>Custom templates</td></tr>
              <tr><td>Inspection records</td><td>Basic</td><td>Photo and damage logs</td><td>Approval workflows</td></tr>
              <tr><td>Reports</td><td>Daily summaries</td><td>Utilization and revenue</td><td>Custom dashboards</td></tr>
              <tr><td>Support</td><td>Email</td><td>Priority</td><td>Dedicated success</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <section class="section dark">
      <div class="wrap">
        <p class="eyebrow">Available add-ons</p>
        <h2>Extend Rydaris when your workflow needs more.</h2>
        <div class="grid cols-3">
          <article class="card feature-card"><h3>Online reservation portal</h3><p>Accept customer inquiries and booking requests from your website with staff approval rules.</p></article>
          <article class="card feature-card"><h3>Accounting connector</h3><p>Sync invoice, payment, tax, and customer balance data into compatible finance systems.</p></article>
          <article class="card feature-card"><h3>Advanced onboarding</h3><p>Data cleanup, workflow mapping, branch setup, staff training, and launch-week support.</p></article>
        </div>
      </div>
    </section>
  </main>
@endsection
