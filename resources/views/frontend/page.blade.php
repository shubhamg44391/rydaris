@extends('frontend.layout.main')

@section('title', ($page->meta_title ?? $page->title) . ' | Rydaris')

@section('meta_description')
    @if($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif
@endsection

@section('content')
  <main>
    <section class="page-hero">
      <div class="wrap">
        <h1 class="page-title">{{ $page->title }}</h1>
      </div>
    </section>

    <section class="section light">
      <div class="wrap">
        <div style="color: var(--text); font-size: 1.1rem; line-height: 1.8;">
            {!! $page->content !!}
        </div>
      </div>
    </section>
  </main>
@endsection
