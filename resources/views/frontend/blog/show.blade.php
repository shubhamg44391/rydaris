@extends('frontend.layout.main')

@section('title', ($post->meta_title ?? $post->title) . ' | Rydaris Blog')
@section('meta_description')
<meta name="description" content="{{ $post->meta_description ?? ($post->excerpt ?? Str::limit(strip_tags($post->content), 150)) }}">
@endsection
@if($post->meta_keyword)
    @section('meta_keywords')
    <meta name="keywords" content="{{ $post->meta_keyword }}">
    @endsection
@endif

@section('content')
<main class="page-content" style="padding: 120px 0 60px;">
    <article class="wrap" style="max-width: 800px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 40px;">
            <div style="font-size: 0.95rem; color: var(--brand); font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 15px;">
                Rydaris Blog
            </div>
            <h1 style="font-size: 3rem; font-weight: 800; line-height: 1.2; margin-bottom: 20px;">
                {{ $post->title }}
            </h1>
            <div style="color: var(--text-muted); font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <span>{{ $post->created_at->format('F d, Y') }}</span>
                <span>&bull;</span>
                <span>{{ max(1, round(str_word_count(strip_tags($post->content)) / 200)) }} min read</span>
            </div>
        </div>

        @if($post->image)
            <div style="margin-bottom: 50px; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.3);">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="width: 100%; height: auto; display: block;">
            </div>
        @endif

        <div class="blog-content">
            {!! $post->content !!}
        </div>

        <div style="margin-top: 60px; padding-top: 40px; border-top: 1px solid var(--border-color, rgba(255,255,255,0.1)); text-align: center;">
            <a href="{{ route('blog.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="m15 18-6-6 6-6"/></svg> Back to all posts
            </a>
        </div>
    </article>
</main>

<style>
    .blog-content {
        font-size: 1.15rem;
        line-height: 1.8;
        color: var(--text-color, #e2e8f0);
    }
    
    .blog-content h2, .blog-content h3, .blog-content h4 {
        color: var(--heading-color, #fff);
        margin-top: 2em;
        margin-bottom: 1em;
        font-weight: 700;
        line-height: 1.3;
    }
    
    .blog-content h2 { font-size: 2rem; }
    .blog-content h3 { font-size: 1.5rem; }
    
    .blog-content p {
        margin-bottom: 1.5em;
    }
    
    .blog-content a {
        color: var(--brand);
        text-decoration: underline;
        text-decoration-color: rgba(82, 234, 210, 0.4);
        text-underline-offset: 4px;
        transition: all 0.2s;
    }
    
    .blog-content a:hover {
        text-decoration-color: var(--brand);
    }
    
    .blog-content ul, .blog-content ol {
        margin-bottom: 1.5em;
        padding-left: 1.5em;
    }
    
    .blog-content li {
        margin-bottom: 0.5em;
    }
    
    .blog-content blockquote {
        margin: 2em 0;
        padding: 1.5em 2em;
        border-left: 4px solid var(--brand);
        background: rgba(255, 255, 255, 0.03);
        border-radius: 0 12px 12px 0;
        font-style: italic;
    }
    
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 2em 0;
    }
    
    .light-mode .blog-content {
        color: #334155;
    }
    
    .light-mode .blog-content h2, 
    .light-mode .blog-content h3, 
    .light-mode .blog-content h4 {
        color: #0f172a;
    }
    
    .light-mode .blog-content blockquote {
        background: #f8fafc;
        border-left-color: var(--brand, #0e766f);
    }
</style>
@endsection
