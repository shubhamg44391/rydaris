@extends('frontend.layout.main')

@section('title', $seo_title ?? 'About Us | Rydaris')

@section('content')
  <main>
    <section class="page-hero">
      <div class="wrap">
        <p class="eyebrow">About Rydaris</p>
        <h1 class="page-title">We build calm software for high-speed rental operations.</h1>
        <p class="lead">Rydaris exists for car rental companies that have outgrown spreadsheets, messaging apps, and disconnected billing tools, but still need software their front desk can actually use during a busy pickup rush.</p>
      </div>
    </section>

    <section class="section light">
      <div class="wrap split">
        <div>
          <p class="eyebrow">Our mission</p>
          <h2>Make every vehicle, booking, and payment easier to trust.</h2>
          <p class="lead">Rental work depends on tiny details being right: dates, deposits, customer documents, service windows, fuel, mileage, damage records, and rate changes. Rydaris connects those details into one reliable operating layer.</p>
          <div class="grid cols-3">
            <article class="info-card"><h3>Less confusion</h3><p>Everyone sees the same live status instead of relying on calls and chat messages.</p></article>
            <article class="info-card"><h3>More control</h3><p>Managers can review pricing, utilization, late returns, and outstanding balances daily.</p></article>
            <article class="info-card"><h3>Better service</h3><p>Customers move through quote, pickup, extension, and return flows with fewer delays.</p></article>
          </div>
        </div>
        <div class="app-window">
          <div class="window-bar"><div class="dots"><span></span><span></span><span></span></div><strong>Operating principles</strong><span>Rydaris</span></div>
          <div class="board">
            <div class="rental-list">
              <div class="rental-item"><div><strong>Operational truth</strong><br><span>Fleet, booking, and billing states should match reality.</span></div><b class="status">Core</b></div>
              <div class="rental-item"><div><strong>Branch-friendly design</strong><br><span>Fast screens, obvious actions, and clear next steps.</span></div><b class="status">UX</b></div>
              <div class="rental-item"><div><strong>Audit-ready records</strong><br><span>Every agreement, charge, inspection, and change has context.</span></div><b class="status">Trust</b></div>
              <div class="rental-item"><div><strong>Scalable workflows</strong><br><span>Start simple, then add approvals, integrations, and reporting.</span></div><b class="status">Scale</b></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section dark">
      <div class="wrap">
        <p class="eyebrow">Who we serve</p>
        <h2>Built for rental teams with real-world moving parts.</h2>
        <div class="grid cols-4">
          <article class="card feature-card"><h3>Independent agencies</h3><p>Replace spreadsheets with a professional system that still stays easy to run day to day.</p></article>
          <article class="card feature-card"><h3>Multi-branch operators</h3><p>Coordinate availability, branch transfers, user roles, and reports from a single workspace.</p></article>
          <article class="card feature-card"><h3>Corporate rental teams</h3><p>Manage recurring customers, account-specific rates, documents, and longer rental cycles.</p></article>
          <article class="card feature-card"><h3>Mobility startups</h3><p>Launch with structured operations and reporting before fleet complexity slows the team down.</p></article>
        </div>
      </div>
    </section>

    <section class="section soft">
      <div class="wrap split">
        <div>
          <p class="eyebrow">How we work</p>
          <h2>Implementation starts with your rental workflow, not a generic template.</h2>
          <p class="lead">Before launch, Rydaris maps your vehicle classes, price rules, branches, pickup and return process, finance checks, and staff permissions. The goal is adoption, not just installation.</p>
        </div>
        <div class="flow">
          <div class="flow-step"><span class="step-number">01</span><div><h3>Process discovery</h3><p>We review current booking, dispatch, agreement, billing, and reporting pain points.</p></div></div>
          <div class="flow-step"><span class="step-number">02</span><div><h3>Data and configuration</h3><p>Vehicles, customers, branches, rates, taxes, and roles are configured for your team.</p></div></div>
          <div class="flow-step"><span class="step-number">03</span><div><h3>Guided launch</h3><p>Staff training, launch support, and first-week review help the system settle into daily use.</p></div></div>
        </div>
      </div>
    </section>
  </main>
@endsection
