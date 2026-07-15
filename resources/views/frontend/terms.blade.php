@extends('frontend.layout.main')

@section('title', (optional($page)->meta_title ?? optional($page)->title ?? 'Terms & Conditions') . ' | Rydaris')

@if(optional($page)->meta_description)
@section('meta_description')
  <meta name="description" content="{{ $page->meta_description }}">
@endsection
@endif

@section('content')
  <main>
    <section class="page-hero">
      <div class="wrap">
        <p class="eyebrow">Legal</p>
        <h1 class="page-title">{{ $page->title ?? 'Terms & Conditions' }}</h1>
      </div>
    </section>

    <section class="section light">
      <div class="wrap" style="max-width: 900px;">
        @if($page && $page->description)
          <div class="tc-body" style="font-size: 1rem; line-height: 1.8; color: var(--text, #cbd5e1);">
            {!! $page->description !!}
          </div>
        @else
          <p style="color: var(--muted-2); text-align: center; padding: 40px 0;">
            Terms &amp; Conditions have not been published yet.
          </p>
        @endif
      </div>
    </section>
  </main>

  <style>
    .tc-body h1, .tc-body h2, .tc-body h3, .tc-body h4 {
      color: #f1f5f9;
      margin: 28px 0 12px;
      font-weight: 700;
    }
    .tc-body h2 { font-size: 1.25rem; }
    .tc-body h3 { font-size: 1.1rem; }
    .tc-body p { margin: 0 0 14px; }
    .tc-body ul, .tc-body ol { padding-left: 22px; margin: 0 0 14px; }
    .tc-body li { margin-bottom: 6px; }
    .tc-body a { color: #52ead2; }
    .tc-body strong { color: #f1f5f9; }
    .tc-body blockquote {
      border-left: 3px solid #52ead2;
      padding: 10px 18px;
      margin: 16px 0;
      background: rgba(82,234,210,0.05);
      border-radius: 0 8px 8px 0;
    }
    .tc-body table {
      width: 100%;
      border-collapse: collapse;
      margin: 16px 0;
    }
    .tc-body th, .tc-body td {
      padding: 10px 14px;
      border: 1px solid rgba(255,255,255,0.1);
      text-align: left;
    }
    .tc-body th {
      background: rgba(82,234,210,0.08);
      color: #f1f5f9;
      font-weight: 600;
    }
  </style>
@endsection
