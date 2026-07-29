@extends('frontend.layout.main')

@section('title', $post->title . ' | Rydaris Community')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/boxicons.css') }}" />

<style>
  .community-detail-page {
    padding: 140px 0 80px;
    background: #08121c;
    min-height: 80vh;
    color: #f8fafc;
    transition: background 0.25s ease, color 0.25s ease;
  }
  .community-detail-wrap {
    max-width: 960px;
    margin: 0 auto;
    padding: 0 20px;
  }
  .community-back-container {
    margin-bottom: 24px;
  }
  .btn-back-posts {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #ffffff;
    padding: 10px 22px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.25s ease;
  }
  .btn-back-posts:hover {
    background: linear-gradient(135deg, #80a7ff, #52ead2) !important;
    color: #061218 !important;
    border-color: transparent !important;
    box-shadow: 0 4px 15px rgba(82, 234, 210, 0.4) !important;
    transform: translateY(-2px);
  }
  .community-alert-success {
    margin-bottom: 24px;
    background: rgba(34, 197, 94, 0.15);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: #4ade80;
    border-radius: 10px;
    padding: 14px 20px;
    font-weight: 600;
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
  .community-detail-container {
    background: linear-gradient(180deg, #141f30 0%, #0d1522 100%);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 18px;
    padding: 32px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.4);
    margin-bottom: 40px;
    transition: all 0.25s ease;
  }
  .community-author-box {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
    padding: 16px 20px;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
  }
  .community-author-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--brand, #52ead2);
    color: #061218;
    font-weight: 800;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .community-author-name {
    margin: 0 0 2px 0;
    font-weight: 800;
    color: #ffffff;
    font-size: 1rem;
  }
  .community-author-meta {
    font-size: 0.84rem;
    color: #94a3b8;
  }
  .community-post-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 20px;
    line-height: 1.35;
  }
  .community-image-container {
    margin-bottom: 24px;
    max-width: 100%;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(0,0,0,0.05);
    text-align: center;
  }
  .community-image-detail {
    max-width: 100%;
    max-height: 480px;
    height: auto;
    display: inline-block;
    object-fit: contain;
  }
  .community-content-body {
    font-size: 1.05rem;
    line-height: 1.85;
    color: #e2e8f0;
    white-space: pre-line;
    margin-bottom: 32px;
    padding-bottom: 24px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }
  .community-section-title {
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 24px;
    font-size: 1.3rem;
  }
  .community-form-box {
    margin-bottom: 32px;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px;
    padding: 24px;
  }
  .community-form-title {
    margin: 0 0 14px 0;
    font-weight: 700;
    color: #ffffff;
    font-size: 1rem;
  }
  .community-form-textarea {
    background: rgba(0,0,0,0.2);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 10px;
    padding: 14px;
    font-size: 0.95rem;
    width: 100%;
    color: #ffffff;
    outline: none;
    font-family: inherit;
  }
  .btn-community-action {
    background: var(--brand, #52ead2) !important;
    color: #061218 !important;
    font-weight: 800 !important;
    border-radius: 10px !important;
    padding: 10px 22px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    text-decoration: none !important;
    border: none !important;
    box-shadow: 0 4px 15px rgba(82, 234, 210, 0.3) !important;
    transition: all 0.25s ease !important;
  }
  .btn-community-action:hover {
    background: #3bb8a0 !important;
    color: #061218 !important;
    box-shadow: 0 6px 20px rgba(82, 234, 210, 0.45) !important;
    transform: translateY(-2px) !important;
  }
  .community-guest-prompt {
    margin-bottom: 32px;
    background: rgba(82, 234, 210, 0.08);
    border: 1px solid rgba(82, 234, 210, 0.25);
    border-radius: 14px;
    padding: 24px;
    text-align: center;
  }
  .community-customer-alert {
    margin-bottom: 32px;
    background: rgba(234, 179, 8, 0.1);
    border: 1px solid rgba(234, 179, 8, 0.25);
    border-radius: 14px;
    padding: 20px;
    color: #fde047;
    text-align: center;
  }
  .community-replies-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  .community-reply-item {
    padding: 20px;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 14px;
  }
  .community-reply-item.admin-reply {
    background: rgba(82, 234, 210, 0.08);
    border-color: rgba(82, 234, 210, 0.35);
  }
  .reply-author-row {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .reply-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--brand, #52ead2);
    color: #061218;
    font-weight: 800;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .reply-avatar.admin-avatar {
    background: #38bdf8;
  }
  .community-reply-name {
    margin: 0;
    font-weight: 800;
    color: #ffffff;
    font-size: 0.95rem;
  }
  .admin-badge {
    background: var(--brand, #52ead2);
    color: #061218;
    font-weight: 800;
    font-size: 0.72rem;
    padding: 3px 8px;
    border-radius: 12px;
  }
  .community-reply-meta {
    font-size: 0.82rem;
    color: #94a3b8;
    display: block;
    margin-top: 2px;
  }
  .community-reply-content {
    font-size: 0.95rem;
    line-height: 1.65;
    color: #cbd5e1;
    white-space: pre-line;
    padding-left: 54px;
  }
  .community-no-replies {
    text-align: center;
    color: #94a3b8;
    font-style: italic;
    padding: 30px;
    background: rgba(255,255,255,0.02);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.06);
  }

  /* --- LIGHT MODE SPECIFIC OVERRIDES --- */
  body.light-mode .community-detail-page {
    background: #ffffff !important;
    color: #1e293b !important;
  }
  body.light-mode .btn-back-posts:not(:hover) {
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #1e293b !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
  }
  body.light-mode .community-detail-container {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
  }
  body.light-mode .community-author-box {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
  }
  body.light-mode .community-author-name {
    color: #0f172a !important;
  }
  body.light-mode .community-author-meta {
    color: #64748b !important;
  }
  body.light-mode .community-post-title {
    color: #0f172a !important;
  }
  body.light-mode .community-content-body {
    color: #334155 !important;
    border-bottom: 1px solid #e2e8f0 !important;
  }
  body.light-mode .community-section-title {
    color: #0f172a !important;
  }
  body.light-mode .community-form-box {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
  }
  body.light-mode .community-form-title {
    color: #0f172a !important;
  }
  body.light-mode .community-form-textarea {
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #0f172a !important;
  }
  body.light-mode .community-reply-item {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
  }
  body.light-mode .community-reply-name {
    color: #0f172a !important;
  }
  body.light-mode .community-reply-meta {
    color: #64748b !important;
  }
  body.light-mode .community-reply-content {
    color: #334155 !important;
  }
  body.light-mode .community-guest-prompt {
    background: #f0fdf4 !important;
    border: 1px solid #bbf7d0 !important;
  }
</style>

<main class="community-detail-page">
  <div class="community-detail-wrap">
    <!-- Back Button -->
    <div class="community-back-container">
      <a href="{{ route('community.index') }}" class="btn-back-posts">
        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2.5;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back
      </a>
    </div>

    <!-- Main Post Container -->
    <div class="community-detail-container">
      <!-- Author Card -->
      <div class="community-author-box">
        <div class="community-author-avatar">
          {{ strtoupper(substr($post->user->name ?? 'V', 0, 2)) }}
        </div>
        <div>
          <h5 class="community-author-name">
            {{ $post->user->name ?? 'Vendor' }}
          </h5>
          <span class="community-author-meta">
            @if(!empty($post->user->company_name))
              {{ $post->user->company_name }} &bull;
            @endif
            Posted {{ $post->created_at->format('d M Y, h:i A') }} ({{ $post->created_at->diffForHumans() }})
          </span>
        </div>
      </div>

      <!-- Post Title -->
      <h1 class="community-post-title">
        {{ $post->title }}
      </h1>

      <!-- Image Preview -->
      @if($post->image)
        <div class="community-image-container">
          <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="community-image-detail">
        </div>
      @endif

      <!-- Content Body -->
      <div class="community-content-body">
        {!! e($post->content) !!}
      </div>

      <!-- Answers & Replies Header -->
      <div style="margin-top: 32px;">
        <h3 class="community-section-title">
          Answers & Replies ({{ $post->comments->count() }})
        </h3>

        <!-- Add Answer Form or Permission Box -->
        @if(Auth::check())
          @if(Auth::user()->role === 'vendor' || Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin')
            <div class="community-form-box">
              <h5 class="community-form-title">Write an Answer / Reply</h5>
              <form method="POST" action="{{ route('community.comment', $post->id) }}">
                @csrf
                <div style="margin-bottom: 16px;">
                  <textarea name="comment" rows="4" class="community-form-textarea" placeholder="Write your answer or response to this post..." required></textarea>
                </div>
                <button type="submit" class="btn-community-action">
                  Post Answer
                </button>
              </form>
            </div>
          @else
            <div class="community-customer-alert">
              <p style="margin: 0; font-weight: 600; font-size: 0.95rem;">Only registered Vendors and Admins can post answers in the Community.</p>
            </div>
          @endif
        @else
          <!-- Guest Login Prompt Box -->
          <div class="community-guest-prompt">
            <h4 class="community-form-title" style="margin: 0 0 8px 0; font-size: 1.1rem;">Join the Discussion</h4>
            <p style="color: #94a3b8; font-size: 0.92rem; margin-bottom: 16px;">Please log in as a Vendor or Admin to write an answer or reply to this post.</p>
            <a href="{{ route('login') }}" class="btn-community-action">
              Log In to Reply
            </a>
          </div>
        @endif

        <!-- Existing Answers List -->
        <div class="community-replies-list">
          @forelse($post->comments as $reply)
            <div class="community-reply-item {{ ($reply->user->role ?? '') === 'admin' ? 'admin-reply' : '' }}">
              <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                <!-- Avatar + Author Header -->
                <div class="reply-author-row">
                  <div class="reply-avatar {{ ($reply->user->role ?? '') === 'admin' ? 'admin-avatar' : '' }}">
                    {{ strtoupper(substr($reply->user->name ?? 'U', 0, 2)) }}
                  </div>
                  <div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                      <h6 class="community-reply-name">
                        {{ $reply->user->name ?? 'User' }}
                      </h6>
                      @if(($reply->user->role ?? '') === 'admin')
                        <span class="admin-badge">
                          Official Admin Response
                        </span>
                      @endif
                    </div>
                    <span class="community-reply-meta">
                      @if(!empty($reply->user->company_name))
                        {{ $reply->user->company_name }} &bull;
                      @endif
                      Posted {{ $reply->created_at->format('d M Y, h:i A') }} ({{ $reply->created_at->diffForHumans() }})
                    </span>
                  </div>
                </div>
              </div>

              <!-- Comment Content -->
              <div class="community-reply-content">
                {!! e($reply->comment) !!}
              </div>
            </div>
          @empty
            <div class="community-no-replies">
              No answers or replies yet. Be the first to post an answer!
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
