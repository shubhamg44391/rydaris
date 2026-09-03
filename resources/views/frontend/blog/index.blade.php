@extends('frontend.layout.main')

@section('title', 'Blog | Rydaris')
@section('meta_description')
<meta name="description" content="Read the latest news, updates, and articles from Rydaris.">
@endsection

@section('content')
<main class="page-content" style="padding: 120px 0 60px;">
    <div class="wrap">
        <div style="text-align: center; margin-bottom: 60px;">
            <h1 style="font-size: 3.5rem; font-weight: 800; margin-bottom: 20px;">Rydaris Blog</h1>
            <p style="font-size: 1.25rem; color: var(--muted); max-width: 600px; margin: 0 auto;">Insights, updates, and strategies to help you scale your fleet rental business.</p>
        </div>

        @if($posts->count() > 0)
            <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 40px;">
                @foreach($posts as $post)
                    <article class="blog-card" style="background: var(--card-bg, rgba(255,255,255,0.03)); border: 1px solid var(--border-color, rgba(255,255,255,0.1)); border-radius: 16px; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column;">
                        <a href="{{ route('blog.show', $post->slug) }}" style="display: block; overflow: hidden; aspect-ratio: 16/9; background: #000;">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(82, 234, 210, 0.2) 0%, rgba(128, 167, 255, 0.2) 100%);">
                                    <svg viewBox="0 0 24 24" style="width: 48px; height: 48px; stroke: var(--brand); fill: none; opacity: 0.5;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                            @endif
                        </a>
                        <div style="padding: 24px; flex-grow: 1; display: flex; flex-direction: column;">
                            <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 12px; font-weight: 600;">
                                {{ $post->created_at->format('F d, Y') }}
                            </div>
                            <h2 style="font-size: 1.5rem; margin-top: 0; margin-bottom: 16px; line-height: 1.3;">
                                <a href="{{ route('blog.show', $post->slug) }}" style="color: inherit; text-decoration: none;">{{ $post->title }}</a>
                            </h2>
                            @if($post->excerpt)
                                <p style="color: var(--text-muted); margin-bottom: 24px; line-height: 1.6; flex-grow: 1;">
                                    {{ Str::limit($post->excerpt, 120) }}
                                </p>
                            @endif
                            <div style="margin-top: auto;">
                                <a href="{{ route('blog.show', $post->slug) }}" style="color: var(--brand); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                                    Read Article <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="margin-top: 60px; display: flex; justify-content: center;">
                {{ $posts->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 100px 0;">
                <svg viewBox="0 0 24 24" style="width: 64px; height: 64px; stroke: var(--muted); fill: none; opacity: 0.5; margin-bottom: 20px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <h3 style="font-size: 1.5rem; color: var(--muted); margin: 0;">No blog posts available yet.</h3>
                <p style="color: var(--muted); margin-top: 10px;">Check back later for updates!</p>
            </div>
        @endif
    </div>
</main>

<style>
    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        border-color: rgba(82, 234, 210, 0.3);
    }
    .blog-card:hover img {
        transform: scale(1.05);
    }
    
    .light-mode .blog-card {
        background: #ffffff !important;
        border-color: rgba(0, 0, 0, 0.1) !important;
    }
    .light-mode .blog-card:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08) !important;
        border-color: rgba(82, 234, 210, 0.5) !important;
    }
</style>
@endsection
