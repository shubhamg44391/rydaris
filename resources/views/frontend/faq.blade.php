@extends('frontend.layout.main')

@section('title', $seo_title ?? 'FAQ | Rydaris')

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
          @forelse ($productBasics as $index => $faq)
            <details class="faq-item">
              <summary>{{ $faq->title }}</summary>
              <p>{{ $faq->description }}</p>
            </details>
          @empty
            <p style="color: var(--muted-2);">No product basics questions available.</p>
          @endforelse
        </div>
      </div>
    </section>

    <section class="section soft">
      <div class="wrap split">
        <div class="faq-stack">
          @forelse ($onboarding as $index => $faq)
            <details class="faq-item">
              <summary>{{ $faq->title }}</summary>
              <p>{{ $faq->description }}</p>
            </details>
          @empty
            <p style="color: var(--muted-2);">No onboarding questions available.</p>
          @endforelse
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
          @forelse ($reporting as $faq)
            <details class="faq-item">
              <summary>{{ $faq->title }}</summary>
              <p>{{ $faq->description }}</p>
            </details>
          @empty
            <p style="color: var(--muted-2); grid-column: span 2;">No reporting or security questions available.</p>
          @endforelse
        </div>
      </div>
    </section>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('details.faq-item').forEach((el) => {
        el.addEventListener('toggle', (e) => {
          if (el.open) {
            document.querySelectorAll('details.faq-item').forEach((otherEl) => {
              if (otherEl !== el && otherEl.open) {
                otherEl.open = false;
              }
            });
          }
        });
      });
    });
  </script>
@endsection
