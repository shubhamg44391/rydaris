@extends('frontend.layout.main')

@section('title', 'FAQ | Rydaris')

@section('content')
  <main>
    <section class="page-hero">
      <div class="wrap">
        <p class="eyebrow">FAQ</p>
        <h1 class="page-title">Answers for rental operators before the first demo.</h1>
        <p class="lead">Learn how Rydaris handles fleet visibility, branch operations, onboarding, payments, security, reporting, and support.</p>
      </div>
    </section>

    <section class="section light">
      <div class="wrap split">
        <div>
          <p class="eyebrow">Product basics</p>
          <h2>What Rydaris manages.</h2>
          <p class="lead">Rydaris is designed as the daily workspace for rental teams, not just a booking calendar. It connects customer, vehicle, branch, contract, payment, and inspection data.</p>
        </div>
        <div class="faq-stack">
          <details class="card faq-item" open><summary>Can Rydaris handle multiple rental branches?</summary><p>Yes. You can manage branch-level availability, staff permissions, transfers, pickups, returns, and reports from one system.</p></details>
          <details class="card faq-item"><summary>Does it support vehicle classes and rate plans?</summary><p>Yes. You can organize vehicles by class, set rate plans, track add-ons, and manage pricing by branch or customer account.</p></details>
          <details class="card faq-item"><summary>Can teams manage booking extensions?</summary><p>Yes. Extensions can update dates, rates, charges, vehicle status, customer balances, and expected return reports.</p></details>
          <details class="card faq-item"><summary>Does Rydaris include inspection records?</summary><p>Pickup and return inspections can record mileage, fuel, damage notes, service flags, and supporting images or documents.</p></details>
        </div>
      </div>
    </section>

    <section class="section soft">
      <div class="wrap split">
        <div class="faq-stack">
          <details class="card faq-item" open><summary>Can you migrate our current data?</summary><p>Yes. Onboarding can include vehicle records, customer lists, rates, branch setup, active rentals, and historical balance data when available.</p></details>
          <details class="card faq-item"><summary>How long does implementation take?</summary><p>Smaller teams can launch quickly. Larger fleets usually need workflow review, data cleanup, staff training, and a staged rollout plan.</p></details>
          <details class="card faq-item"><summary>Do staff need technical training?</summary><p>No deep technical knowledge is required. Rydaris is structured around rental actions: reserve, dispatch, inspect, invoice, return, and report.</p></details>
          <details class="card faq-item"><summary>Can we keep our existing processes?</summary><p>Most teams keep their core operating rules while replacing manual tracking with cleaner screens, permissions, and reporting.</p></details>
        </div>
        <div>
          <p class="eyebrow">Onboarding</p>
          <h2>Setup starts with your workflow.</h2>
          <p class="lead">Rydaris can be configured around your vehicle classes, branches, customer types, deposit rules, payment flows, service checks, and reporting needs.</p>
        </div>
      </div>
    </section>

    <section class="section light">
      <div class="wrap">
        <p class="eyebrow">Billing, security, and reporting</p>
        <h2>More questions teams ask.</h2>
        <div class="grid cols-2">
          <details class="card faq-item"><summary>What reports are included?</summary><p>Reports can include utilization, revenue, deposits, unpaid balances, booking sources, branch performance, maintenance activity, late returns, and vehicle profitability.</p></details>
          <details class="card faq-item"><summary>Can Rydaris manage deposits and refunds?</summary><p>Yes. Deposit collection, partial adjustments, extra charges, refunds, and outstanding balances can be tracked against each agreement.</p></details>
          <details class="card faq-item"><summary>Does it integrate with accounting tools?</summary><p>Integration options depend on the plan and accounting system. Enterprise customers can discuss custom API or export workflows.</p></details>
          <details class="card faq-item"><summary>How are user permissions handled?</summary><p>Roles can separate front desk, branch manager, finance, fleet coordinator, administrator, and reporting access.</p></details>
          <details class="card faq-item"><summary>Is Rydaris suitable for long-term rentals?</summary><p>Yes. The system supports longer agreements, recurring customer accounts, extensions, scheduled invoices, and vehicle status tracking over time.</p></details>
          <details class="card faq-item"><summary>What support is available?</summary><p>Support depends on plan level, from email support to guided onboarding, launch support, priority help, and dedicated success management.</p></details>
        </div>
      </div>
    </section>
  </main>
@endsection
