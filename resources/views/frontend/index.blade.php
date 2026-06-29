@extends('frontend.layout.main')

@section('title', 'Rydaris | Car Rental Management System')

@section('content')
    <main>
      <section class="hero">
        <div class="wrap hero-copy">
          <p class="eyebrow">Car rental command center</p>
          <h1>The operating system for modern rental fleets.</h1>
          <p class="lead">Rydaris brings reservations, fleet status, contracts, billing, inspections, and branch reporting into one beautifully connected workspace for car rental teams.</p>
          <div class="actions">
            <a class="btn primary" href="{{ route('contact') }}"><svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>See Rydaris in Action</a>
            <a class="btn secondary" href="{{ route('pricing') }}"><svg viewBox="0 0 24 24"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/></svg>View Pricing</a>
          </div>
        </div>

        <div class="product-stage">
          <div class="app-window" aria-label="Rydaris product dashboard preview">
            <div class="window-bar">
              <div class="dots" aria-hidden="true"><span></span><span></span><span></span></div>
              <strong>Rydaris Fleet Board</strong>
              <span>Live operations</span>
            </div>
            <div class="dashboard">
              <aside class="sidebar">
                <div class="side-item active"><span class="mini-icon"><svg viewBox="0 0 24 24"><path d="M3 13h18l-2-5H5l-2 5Z"/></svg></span>Fleet Board</div>
                <div class="side-item"><span class="mini-icon"><svg viewBox="0 0 24 24"><path d="M8 2v4"/><path d="M16 2v4"/><rect x="3" y="4" width="18" height="18" rx="2"/></svg></span>Reservations</div>
                <div class="side-item"><span class="mini-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/></svg></span>Agreements</div>
                <div class="side-item"><span class="mini-icon"><svg viewBox="0 0 24 24"><path d="M20 7h-9"/><path d="M14 17H5"/><circle cx="17" cy="17" r="3"/><circle cx="7" cy="7" r="3"/></svg></span>Reports</div>
              </aside>
              <section class="board">
                <div class="board-grid">
                  <div>
                    <div class="glass-card fleet-visual">
                      <h3>Airport branch utilization</h3>
                      <p>Pickup flow, ready vehicles, late returns, and service holds in one view.</p>
                    </div>
                    <div class="stat-row">
                      <div class="stat"><strong>86%</strong><span>utilization</span></div>
                      <div class="stat"><strong>42</strong><span>active rentals</span></div>
                      <div class="stat"><strong>7</strong><span>returns due</span></div>
                    </div>
                  </div>
                  <div class="glass-card">
                    <h3>Today</h3>
                    <div class="rental-list">
                      <div class="rental-item"><div><strong>Executive SUV</strong><br><span>Corporate weekly</span></div><b class="status">Out</b></div>
                      <div class="rental-item"><div><strong>City Sedan</strong><br><span>Airport pickup</span></div><b class="status">Ready</b></div>
                      <div class="rental-item"><div><strong>Compact Auto</strong><br><span>Walk-in hold</span></div><b class="status">Hold</b></div>
                      <div class="rental-item"><div><strong>Premium Van</strong><br><span>Service inspection</span></div><b class="status">Queue</b></div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </section>

      <div class="ticker" aria-label="Rydaris capabilities">
        <div class="ticker-track">
          <span>Reservations</span><span>Fleet Board</span><span>Contracts</span><span>Deposits</span><span>Inspections</span><span>Maintenance</span><span>Branch Transfers</span><span>Revenue Reports</span>
          <span>Reservations</span><span>Fleet Board</span><span>Contracts</span><span>Deposits</span><span>Inspections</span><span>Maintenance</span><span>Branch Transfers</span><span>Revenue Reports</span>
        </div>
      </div>

      <section class="section light">
        <div class="wrap">
          <p class="eyebrow">Everything connected</p>
          <h2>Run the full rental lifecycle without jumping between tools.</h2>
          <p class="lead">From the first customer inquiry to final settlement, Rydaris keeps every operational detail tied to the right vehicle, branch, agreement, invoice, and staff member.</p>
          <div class="grid cols-3">
            <article class="card feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M8 2v4"/><path d="M16 2v4"/><path d="M3 10h18"/><rect x="3" y="4" width="18" height="18" rx="2"/></svg></span><h3>Reservation workspace</h3><p>Create quotes, holds, confirmed bookings, extensions, cancellations, and no-show records with rate rules built in.</p></article>
            <article class="card feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M3 13h18l-2-5H5l-2 5Z"/><path d="M5 13v5"/><path d="M19 13v5"/></svg></span><h3>Live fleet status</h3><p>Know what is available, on rent, late, blocked, in cleaning, under service, or moving between branches.</p></article>
            <article class="card feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/><path d="M8 13h8"/></svg></span><h3>Digital agreements</h3><p>Capture customer details, signatures, deposits, mileage, fuel, damages, add-ons, and return notes in one agreement.</p></article>
            <article class="card feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/></svg></span><h3>Billing control</h3><p>Handle deposits, invoices, taxes, extra charges, refunds, settlements, and outstanding balances with clean audit trails.</p></article>
            <article class="card feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg></span><h3>Inspection records</h3><p>Document pickup and return condition, attach photos, flag damage, and keep vehicle history ready for review.</p></article>
            <article class="card feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-5 5"/></svg></span><h3>Performance reports</h3><p>Track utilization, revenue, booking sources, late returns, branch activity, service load, and fleet profitability.</p></article>
          </div>
        </div>
      </section>

      <section class="section dark">
        <div class="wrap split">
          <div>
            <p class="eyebrow">Operations flow</p>
            <h2>Plan pickups, dispatch vehicles, and close returns faster.</h2>
            <p class="lead">Counter staff, fleet coordinators, managers, and finance teams all see the same real-time context. Less chasing, fewer double-bookings, and cleaner handovers.</p>
            <div class="actions left">
              <a class="btn primary" href="{{ route('about') }}">Explore the Platform</a>
            </div>
          </div>
          <div class="flow">
            <div class="flow-step"><span class="step-number">01</span><div><h3>Convert inquiry to confirmed booking</h3><p>Choose branch, dates, rate plan, add-ons, customer profile, and payment status without leaving the reservation screen.</p></div></div>
            <div class="flow-step"><span class="step-number">02</span><div><h3>Prepare the vehicle</h3><p>Assign cars based on real status, service windows, fuel, documents, cleaning state, and expected return timing.</p></div></div>
            <div class="flow-step"><span class="step-number">03</span><div><h3>Return and settle</h3><p>Capture mileage, damage, fuel, extensions, extra charges, refunds, and invoice closure from a guided return flow.</p></div></div>
          </div>
        </div>
      </section>

      <section class="section soft">
        <div class="wrap">
          <p class="eyebrow">Designed for growing fleets</p>
          <h2>Give every branch a shared operating rhythm.</h2>
          <div class="grid cols-4">
            <article class="card info-card"><h3>Branch managers</h3><p>Monitor availability, staff activity, returns due, revenue, service holds, and fleet movement.</p></article>
            <article class="card info-card"><h3>Reservation teams</h3><p>Quote quickly, reduce conflicts, view customer history, and manage extensions with confidence.</p></article>
            <article class="card info-card"><h3>Fleet coordinators</h3><p>Keep inspections, cleaning, maintenance, registration, and availability aligned across vehicles.</p></article>
            <article class="card info-card"><h3>Finance teams</h3><p>Track deposits, unpaid invoices, refunds, tax lines, add-ons, and end-of-day settlement reports.</p></article>
          </div>
        </div>
      </section>

      <section class="section dark">
        <div class="wrap hero-copy">
          <p class="eyebrow">Ready for a cleaner rental workflow?</p>
          <h2>Move your fleet from scattered updates to one live workspace.</h2>
          <p class="lead">Rydaris can be shaped around your branches, vehicle classes, pricing rules, and customer journey.</p>
          <div class="actions">
            <a class="btn primary" href="{{ route('contact') }}">Book a Demo</a>
            <a class="btn secondary" href="{{ route('faq') }}">Read FAQ</a>
          </div>
        </div>
      </section>
    </main>
@endsection
