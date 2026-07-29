@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 class="panel-title">Post Details & Answers</h2>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="{{ route('admin.community.index') }}" class="btn btn-outline-secondary" style="border-radius: var(--radius); padding: 8px 16px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    &larr; Back to Posts
                </a>
                <form action="{{ route('admin.community.toggle-status', $post->id) }}" method="POST" style="display: inline-flex; align-items: center;">
                    @csrf
                    <button type="submit" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 20px; padding: 6px 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;" title="Click to toggle Public / Private status">
                        <div style="width: 36px; height: 20px; background: {{ $post->is_published ? '#22c55e' : '#64748b' }}; border-radius: 20px; padding: 2px; position: relative; transition: all 0.25s ease; display: flex; align-items: center; justify-content: {{ $post->is_published ? 'flex-end' : 'flex-start' }};">
                            <div style="width: 16px; height: 16px; background: #ffffff; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,0.3);"></div>
                        </div>
                        <span style="font-size: 0.85rem; font-weight: 700; color: {{ $post->is_published ? '#4ade80' : '#94a3b8' }};">
                            {{ $post->is_published ? 'Public' : 'Private' }}
                        </span>
                    </button>
                </form>
                <form action="{{ route('admin.community.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="background: #ef4444; border: none; color: #ffffff; font-weight: 700; border-radius: var(--radius); padding: 8px 16px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        Delete Post
                    </button>
                </form>
            </div>
        </div>

        <div class="panel-body" style="padding: 28px;">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); color: #4ade80; border-radius: 8px; padding: 12px 16px;">
                    <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Author Card -->
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 24px; padding: 16px 20px; background: var(--bg-2, #f8fafc); border: 1px solid var(--line, #e2e8f0); border-radius: var(--radius, 12px);">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--brand, #52ead2); color: #061218; font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    {{ strtoupper(substr($post->user->name ?? 'V', 0, 2)) }}
                </div>
                <div>
                    <h5 style="margin: 0 0 2px 0; font-weight: 800; color: var(--text, #1e293b); font-size: 1rem;">
                        {{ $post->user->name ?? 'Vendor' }}
                    </h5>
                    <span style="font-size: 0.84rem; color: var(--muted, #64748b);">
                        @if(!empty($post->user->company_name))
                            {{ $post->user->company_name }} &bull;
                        @endif
                        Posted {{ $post->created_at->format('d M Y, h:i A') }} ({{ $post->created_at->diffForHumans() }})
                    </span>
                </div>
            </div>

            <!-- Post Title -->
            <h1 style="font-size: 1.65rem; font-weight: 800; color: var(--text, #1e293b); margin-bottom: 20px; line-height: 1.4;">
                {{ $post->title }}
            </h1>

            <!-- Optional Image -->
            @if($post->image)
                <div style="margin-bottom: 24px; max-width: 100%; border-radius: var(--radius, 12px); overflow: hidden; border: 1px solid var(--line, #e2e8f0); background: var(--bg-2, #f8fafc); text-align: center;">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="max-width: 100%; max-height: 480px; height: auto; display: inline-block; object-fit: contain;">
                </div>
            @endif

            <!-- Post Content Body -->
            <div style="font-size: 1rem; line-height: 1.85; color: var(--text, #334155); white-space: pre-line; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid var(--line, #e2e8f0);">
                {!! e($post->content) !!}
            </div>

            <!-- Answers / Replies Section -->
            <div style="margin-top: 32px;">
                <h4 style="font-weight: 800; color: var(--text, #1e293b); margin-bottom: 20px; font-size: 1.2rem;">
                    Answers & Replies ({{ $post->comments->count() }})
                </h4>

                <!-- Admin Add Answer Form -->
                <div style="margin-bottom: 28px; background: var(--bg-2, #f8fafc); border: 1px solid var(--line, #e2e8f0); border-radius: var(--radius, 12px); padding: 20px;">
                    <h5 style="margin: 0 0 12px 0; font-weight: 700; color: var(--text, #1e293b); font-size: 0.95rem;">Post Admin Answer / Official Response</h5>
                    <form method="POST" action="{{ route('admin.community.reply', $post->id) }}">
                        @csrf
                        <div class="mb-3">
                            <textarea name="comment" rows="4" class="form-control form-input-custom" placeholder="Write an official answer or reply to this vendor post..." required style="border: 1px solid var(--line, #d7e0e8); border-radius: var(--radius); padding: 12px; font-size: 0.95rem; width: 100%; color: var(--text, #1e293b);"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" style="font-weight: 800; background: var(--brand, #52ead2); border: none; color: #061218;">
                            Post Answer
                        </button>
                    </form>
                </div>

                <!-- Existing Replies List -->
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @forelse($post->comments as $reply)
                        <div style="padding: 20px; background: {{ ($reply->user->role ?? '') === 'admin' ? 'rgba(82, 234, 210, 0.06)' : 'var(--bg-2, #f8fafc)' }}; border: 1px solid {{ ($reply->user->role ?? '') === 'admin' ? 'rgba(82, 234, 210, 0.3)' : 'var(--line, #e2e8f0)' }}; border-radius: var(--radius, 12px);">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                <!-- Avatar + Author Header -->
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 42px; height: 42px; border-radius: 50%; background: {{ ($reply->user->role ?? '') === 'admin' ? '#38bdf8' : 'var(--brand, #52ead2)' }}; color: #061218; font-weight: 800; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        {{ strtoupper(substr($reply->user->name ?? 'U', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <h6 style="margin: 0; font-weight: 800; color: var(--text, #1e293b); font-size: 0.95rem;">
                                                {{ $reply->user->name ?? 'User' }}
                                            </h6>
                                            @if(($reply->user->role ?? '') === 'admin')
                                                <span class="badge" style="background: var(--brand, #52ead2); color: #061218; font-weight: 800; font-size: 0.72rem; padding: 3px 8px; border-radius: 12px;">
                                                    Official Admin Response
                                                </span>
                                            @endif
                                        </div>
                                        <span style="font-size: 0.82rem; color: var(--muted, #64748b); display: block; margin-top: 2px;">
                                            @if(!empty($reply->user->company_name))
                                                {{ $reply->user->company_name }} &bull;
                                            @endif
                                            Posted {{ $reply->created_at->format('d M Y, h:i A') }} ({{ $reply->created_at->diffForHumans() }})
                                        </span>
                                    </div>
                                </div>

                                <!-- Delete Action -->
                                @if(auth()->user()->role === 'admin' || $reply->user_id === auth()->id())
                                    <form action="{{ route('admin.community.reply.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Delete this reply?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 4px; border-radius: 6px; display: inline-flex; align-items: center;" title="Delete Answer">
                                            <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <!-- Comment Content -->
                            <div style="font-size: 0.95rem; line-height: 1.6; color: var(--text, #334155); white-space: pre-line; padding-left: 54px;">
                                {!! e($reply->comment) !!}
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; color: var(--muted, #64748b); font-style: italic; padding: 20px;">
                            No answers or replies yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
