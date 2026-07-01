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
          @forelse ($packages as $pkg)
            <article class="card pricing-card {{ $pkg->is_featured ? 'featured' : '' }}">
              @if($pkg->eyebrow)
                <p class="eyebrow">{{ $pkg->eyebrow }}</p>
              @endif
              <h2>{{ $pkg->name }}</h2>
              <p>{{ $pkg->description }}</p>
              <div class="price"><strong>{{ $pkg->price }}</strong><span>{{ $pkg->billing_period }}</span></div>
              
              @if(is_array($pkg->features))
                <ul class="list">
                  @foreach($pkg->features as $feature)
                    <li><span class="check">✓</span><span>{{ $feature }}</span></li>
                  @endforeach
                </ul>
              @endif

              <div class="actions left">
                <a class="btn {{ $pkg->is_featured ? 'primary' : 'secondary' }}" href="{{ route('contact') }}">{{ $pkg->button_text }}</a>
              </div>
            </article>
          @empty
            <p style="grid-column: span 3; text-align: center; color: var(--muted-2);">No pricing plans available.</p>
          @endforelse
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
