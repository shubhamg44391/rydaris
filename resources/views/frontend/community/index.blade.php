@extends('frontend.layout.main')

@section('title', 'Vendor Community | Rydaris')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/boxicons.css') }}" />

<style>
  .community-page {
    padding: 140px 0 80px;
    background: #08121c;
    min-height: 80vh;
    color: #f8fafc;
    transition: background 0.25s ease, color 0.25s ease;
  }
  .community-wrap {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 20px;
  }
  .community-header-border {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 40px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    padding-bottom: 24px;
  }
  .community-eyebrow {
    color: #52ead2;
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 6px;
  }
  .community-header-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #ffffff;
    margin: 0;
    line-height: 1.2;
  }
  .community-header-sub {
    color: #94a3b8;
    font-size: 1.05rem;
    margin-top: 8px;
    max-width: 640px;
  }
  .community-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 24px;
  }
  .community-post-card {
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
    background: linear-gradient(180deg, #141f30 0%, #0d1522 100%);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 16px;
    padding: 0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
  }
  .community-post-card:hover {
    transform: translateY(-4px);
    border-color: rgba(82, 234, 210, 0.5);
    box-shadow: 0 12px 36px rgba(82, 234, 210, 0.15);
  }
  .community-image-wrap {
    height: 200px;
    overflow: hidden;
    background: rgba(0, 0, 0, 0.08);
    position: relative;
  }
  .community-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .community-card-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
  }
  .community-author-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
  }
  .community-author-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--brand, #52ead2);
    color: #061218;
    font-weight: 800;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .author-name-text {
    font-size: 0.95rem;
    margin: 0;
    color: #ffffff;
    font-weight: 800;
  }
  .author-meta-text {
    font-size: 0.8rem;
    color: #94a3b8;
  }
  .community-card-title {
    font-size: 1.15rem;
    font-weight: 800;
    line-height: 1.4;
    margin-bottom: 10px;
  }
  .card-title-link {
    color: #ffffff;
    text-decoration: none;
    font-weight: 800;
    transition: color 0.2s ease;
  }
  .card-title-link:hover {
    color: #52ead2;
  }
  .snippet-text {
    font-size: 0.9rem;
    line-height: 1.6;
    flex-grow: 1;
    margin-bottom: 20px;
    color: #cbd5e1;
  }
  .community-post-footer {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 16px;
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .answers-badge {
    background: rgba(82, 234, 210, 0.15);
    color: #0f766e;
    border: 1px solid rgba(82, 234, 210, 0.4);
    font-weight: 700;
    font-size: 0.78rem;
    padding: 5px 12px;
    border-radius: 20px;
  }
  .btn-view-answers {
    background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
    color: #061218 !important;
    font-size: 0.85rem !important;
    font-weight: 800 !important;
    padding: 8px 18px !important;
    border-radius: 12px !important;
    text-decoration: none !important;
    transition: all 0.25s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    border: none !important;
    box-shadow: 0 3px 12px rgba(82, 234, 210, 0.35) !important;
  }
  .btn-view-answers:hover {
    background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important;
    color: #061218 !important;
    box-shadow: 0 5px 16px rgba(82, 234, 210, 0.5) !important;
    transform: translateY(-2px) !important;
  }
  .btn-community-action {
    background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
    color: #061218 !important;
    font-weight: 800 !important;
    border-radius: 12px !important;
    padding: 10px 22px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    text-decoration: none !important;
    border: none !important;
    box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35) !important;
    transition: all 0.25s ease !important;
  }
  .btn-community-action:hover {
    background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important;
    color: #061218 !important;
    box-shadow: 0 6px 20px rgba(82, 234, 210, 0.5) !important;
    transform: translateY(-2px) !important;
  }
  .community-empty-box {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
  }
  .community-pagination-wrap {
    margin-top: 40px;
    padding-top: 24px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    flex-wrap: wrap !important;
    gap: 16px !important;
    width: 100% !important;
  }
  .community-pagination-links {
    margin-left: auto !important;
    display: flex !important;
    justify-content: flex-end !important;
  }
  .community-pagination-wrap nav {
    display: flex !important;
    justify-content: flex-end !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  .community-pagination-wrap .pagination {
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;
  }
  .community-pagination-wrap .page-item .page-link {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    color: #cbd5e1 !important;
    border-radius: 10px !important;
    padding: 8px 14px !important;
    font-size: 0.9rem !important;
    font-weight: 700 !important;
    transition: all 0.2s ease !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-width: 38px !important;
    height: 38px !important;
    box-shadow: none !important;
  }
  .community-pagination-wrap .page-item .page-link:hover {
    background: rgba(82, 234, 210, 0.15) !important;
    border-color: rgba(82, 234, 210, 0.4) !important;
    color: #52ead2 !important;
    transform: translateY(-1px);
  }
  .community-pagination-wrap .page-item.active .page-link {
    background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
    border-color: transparent !important;
    color: #061218 !important;
    font-weight: 800 !important;
    box-shadow: 0 4px 14px rgba(82, 234, 210, 0.35) !important;
  }
  .community-pagination-wrap .page-item.disabled .page-link {
    background: rgba(255, 255, 255, 0.02) !important;
    border-color: rgba(255, 255, 255, 0.05) !important;
    color: #475569 !important;
    cursor: not-allowed !important;
    opacity: 0.5 !important;
  }
  .community-alert-error {
    margin-bottom: 24px;
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #f87171;
    border-radius: 10px;
    padding: 14px 20px;
    font-weight: 600;
  }

  /* --- LIGHT MODE SPECIFIC OVERRIDES --- */
  body.light-mode .community-page {
    background: #ffffff !important;
    color: #1e293b !important;
  }
  body.light-mode .community-header-title {
    color: #0f172a !important;
  }
  body.light-mode .community-header-sub {
    color: #475569 !important;
  }
  body.light-mode .community-header-border {
    border-bottom: 1px solid #e2e8f0 !important;
  }
  body.light-mode .community-post-card {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05) !important;
  }
  body.light-mode .community-post-card:hover {
    border-color: rgba(82, 234, 210, 0.6) !important;
    box-shadow: 0 8px 24px rgba(82, 234, 210, 0.2) !important;
  }
  body.light-mode .card-title-link {
    color: #0f172a !important;
  }
  body.light-mode .card-title-link:hover {
    color: #0f766e !important;
  }
  body.light-mode .author-name-text {
    color: #0f172a !important;
  }
  body.light-mode .author-meta-text {
    color: #64748b !important;
  }
  body.light-mode .snippet-text {
    color: #475569 !important;
  }
  body.light-mode .community-post-footer {
    border-top: 1px solid #e2e8f0 !important;
  }
  body.light-mode .btn-view-answers:not(:hover) {
    background: #f1f5f9 !important;
    color: #1e293b !important;
    border: 1px solid #cbd5e1 !important;
  }
  body.light-mode .community-pagination-wrap {
    border-top: 1px solid #e2e8f0 !important;
  }
  body.light-mode .community-pagination-wrap .page-item .page-link {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    color: #334155 !important;
  }
  body.light-mode .community-pagination-wrap .page-item .page-link:hover {
    background: rgba(82, 234, 210, 0.2) !important;
    border-color: #52ead2 !important;
    color: #0f766e !important;
  }
  body.light-mode .community-pagination-wrap .page-item.active .page-link {
    background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
    color: #061218 !important;
  }
  body.light-mode .community-pagination-wrap .page-item.disabled .page-link {
    background: #f1f5f9 !important;
    border-color: #e2e8f0 !important;
    color: #94a3b8 !important;
  }
</style>

<main class="community-page">
  <div class="community-wrap">
    <!-- Page Header -->
    <div class="community-header-border">
      <div>
        <p class="community-eyebrow">Operator Network</p>
        <h1 class="community-header-title">Car Rental Vendor Community</h1>
        <p class="community-header-sub">Connect, share insights, ask fleet questions, and learn from car rental operators and industry experts.</p>
      </div>
      <div>
        @if(Auth::check() && (Auth::user()->role === 'vendor' || Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin'))
          <a href="{{ Auth::user()->role === 'admin' ? route('admin.community.create') : route('vendor.community.create') }}" class="btn-community-action">
            <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: none; stroke: currentColor; stroke-width: 2.5;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Create Post
          </a>
        @else
          <a href="{{ route('login') }}" class="btn-community-action">
            Login to Post
          </a>
        @endif
      </div>
    </div>

    <!-- Cards Grid -->
    <div class="community-grid">
      @forelse ($posts as $post)
        <div class="community-post-card">
          @if($post->image)
            <div class="community-image-wrap">
              <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="community-image">
            </div>
          @endif

          <div class="community-card-body">
            <!-- Author Header -->
            <div class="community-author-row">
              <div class="community-author-avatar">
                {{ strtoupper(substr($post->user->name ?? 'V', 0, 2)) }}
              </div>
              <div>
                <h6 class="author-name-text">{{ $post->user->name ?? 'Vendor' }}</h6>
                <span class="author-meta-text">
                  @if(!empty($post->user->company_name))
                    {{ $post->user->company_name }} &bull;
                  @endif
                  {{ $post->created_at->diffForHumans() }}
                </span>
              </div>
            </div>

            <!-- Post Title -->
            <h3 class="community-card-title">
              <a href="{{ route('community.show', $post->id) }}" class="card-title-link">
                {{ $post->title }}
              </a>
            </h3>

            <!-- Snippet -->
            <p class="snippet-text">
              {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 130) }}
            </p>

            <!-- Footer Actions -->
            <div class="community-post-footer">
              <span class="answers-badge">
                {{ $post->comments->count() }} ANSWERS
              </span>

              <a href="{{ route('community.show', $post->id) }}" class="btn-view-answers">
                View & Answers &rarr;
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="community-empty-box">
          <h3 style="font-weight: 700; margin-bottom: 8px;">No Community Posts Found</h3>
          <p style="color: #94a3b8;">There are no public vendor posts in the community yet.</p>
        </div>
      @endforelse
    </div>

    @if($posts->hasPages())
      <div class="community-pagination-wrap">
        <div style="color: #94a3b8; font-size: 0.9rem;">
          Showing {{ $posts->firstItem() ?? 0 }} to {{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} results
        </div>
        <div class="community-pagination-links">
          {{ $posts->links('vendor.pagination.custom') }}
        </div>
      </div>
    @endif
  </div>
</main>
@endsection
