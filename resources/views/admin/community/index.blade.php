@extends('admin.layouts.app')

@section('main-content')
    <style>
        .community-panel-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 24px;
            padding: 24px 24px 0 24px;
        }
        .community-panel-title {
            font-weight: 800;
            margin: 0;
            color: #ffffff;
        }
        .btn-community-create {
            background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
            color: #061218 !important;
            font-weight: 800 !important;
            border-radius: 12px !important;
            padding: 10px 22px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            text-decoration: none !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35) !important;
            transition: all 0.25s ease !important;
        }
        .btn-community-create:hover {
            background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important;
            color: #061218 !important;
            box-shadow: 0 6px 20px rgba(82, 234, 210, 0.5) !important;
            transform: translateY(-2px) !important;
        }
        .community-alert-success {
            margin: 0 24px 24px 24px;
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #4ade80;
            border-radius: 10px;
            padding: 12px 16px;
        }
        .community-alert-danger {
            margin: 0 24px 24px 24px;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            border-radius: 10px;
            padding: 12px 16px;
        }
        .community-grid-wrap {
            padding: 0 24px 24px 24px;
        }
        .community-post-card {
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            background: linear-gradient(180deg, #141f30 0%, #0d1522 100%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .community-post-card:hover {
            transform: translateY(-3px);
            border-color: rgba(82, 234, 210, 0.5);
            box-shadow: 0 8px 30px rgba(82, 234, 210, 0.15);
        }
        .community-card-img-wrap {
            height: 180px;
            overflow: hidden;
            background: rgba(0,0,0,0.2);
            position: relative;
        }
        .community-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .community-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .community-author-avatar {
            width: 40px;
            height: 40px;
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
        .author-name-text {
            font-size: 0.92rem;
            margin: 0;
            font-weight: 800;
            color: #ffffff;
        }
        .author-meta-text {
            font-size: 0.78rem;
            color: #94a3b8;
        }
        .community-post-title-text {
            font-size: 1.1rem;
            font-weight: 800;
            line-height: 1.4;
            margin-bottom: 8px;
        }
        .card-title-link {
            color: #ffffff;
            text-decoration: none;
            font-weight: 800;
        }
        .card-title-link:hover {
            color: #52ead2;
        }
        .snippet-text {
            font-size: 0.88rem;
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 16px;
            color: #cbd5e1;
        }
        .community-post-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 16px;
            margin-top: auto;
        }
        .answers-badge {
            background: rgba(82, 234, 210, 0.18);
            color: #52ead2;
            border: 1px solid rgba(82, 234, 210, 0.5);
            font-weight: 700;
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 20px;
        }
        .btn-toggle-status {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .toggle-switch-track {
            width: 34px;
            height: 18px;
            border-radius: 20px;
            padding: 2px;
            position: relative;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
        }
        .toggle-switch-dot {
            width: 14px;
            height: 14px;
            background: #ffffff;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        .toggle-switch-label {
            font-size: 0.78rem;
            font-weight: 700;
        }
        .btn-community-view {
            background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
            color: #061218 !important;
            font-size: 0.82rem !important;
            font-weight: 800 !important;
            padding: 6px 18px !important;
            border-radius: 12px !important;
            border: none !important;
            box-shadow: 0 3px 12px rgba(82, 234, 210, 0.35) !important;
            text-decoration: none !important;
            transition: all 0.25s ease !important;
        }
        .btn-community-view:hover {
            background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important;
            color: #061218 !important;
            box-shadow: 0 5px 16px rgba(82, 234, 210, 0.5) !important;
            transform: translateY(-2px) !important;
        }
        .btn-community-delete {
            padding: 4px 8px;
            font-size: 0.8rem;
            border-radius: 6px;
        }
        .community-empty-state {
            padding: 48px 24px;
            text-align: center;
        }
        .community-icon-large {
            font-size: 3.5rem;
            color: #64748b;
            margin-bottom: 12px;
        }
        .community-empty-title {
            font-weight: 700;
            color: #ffffff;
        }
        .community-empty-sub {
            color: #94a3b8;
        }

        /* --- LIGHT MODE CARD OVERRIDES --- */
        body.light-mode .community-panel-title,
        html.light-mode .community-panel-title,
        .light-mode .community-panel-title {
            color: #0f172a !important;
        }
        body.light-mode .community-post-card,
        html.light-mode .community-post-card,
        .light-mode .community-post-card {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05) !important;
        }
        body.light-mode .community-post-card:hover,
        html.light-mode .community-post-card:hover,
        .light-mode .community-post-card:hover {
            border-color: rgba(82, 234, 210, 0.6) !important;
            box-shadow: 0 8px 24px rgba(82, 234, 210, 0.2) !important;
        }
        body.light-mode .card-title-link,
        html.light-mode .card-title-link,
        .light-mode .card-title-link {
            color: #0f172a !important;
        }
        body.light-mode .card-title-link:hover,
        html.light-mode .card-title-link:hover,
        .light-mode .card-title-link:hover {
            color: #0f766e !important;
        }
        body.light-mode .author-name-text,
        html.light-mode .author-name-text,
        .light-mode .author-name-text {
            color: #0f172a !important;
        }
        body.light-mode .author-meta-text,
        html.light-mode .author-meta-text,
        .light-mode .author-meta-text {
            color: #64748b !important;
        }
        body.light-mode .snippet-text,
        html.light-mode .snippet-text,
        .light-mode .snippet-text {
            color: #334155 !important;
        }
        body.light-mode .community-post-footer,
        html.light-mode .community-post-footer,
        .light-mode .community-post-footer {
            border-top: 1px solid #e2e8f0 !important;
        }
        body.light-mode .community-empty-title,
        html.light-mode .community-empty-title,
        .light-mode .community-empty-title {
            color: #0f172a !important;
        }

        /* --- COMMUNITY PAGINATION STYLES --- */
        .community-pagination-wrap {
            margin-top: 24px;
            padding-top: 20px;
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
            padding: 6px 12px !important;
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 34px !important;
            height: 34px !important;
        }
        .community-pagination-wrap .page-item .page-link:hover {
            background: rgba(82, 234, 210, 0.15) !important;
            border-color: rgba(82, 234, 210, 0.4) !important;
            color: #52ead2 !important;
        }
        .community-pagination-wrap .page-item.active .page-link {
            background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
            border-color: transparent !important;
            color: #061218 !important;
            font-weight: 800 !important;
        }
        .community-pagination-wrap .page-item.disabled .page-link {
            background: rgba(255, 255, 255, 0.02) !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
            color: #475569 !important;
            opacity: 0.5 !important;
        }
    </style>

    <div class="admin-panel">
        <div class="panel-head community-panel-head">
            <div>
                <h2 class="community-panel-title">Vendor Community Posts</h2>
            </div>
            <div>
                <a href="{{ route('admin.community.create') }}" class="btn btn-community-create">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2.5;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Create Post
                </a>
            </div>
        </div>



        <div class="community-grid-wrap">
            <div class="row g-4">
                @forelse ($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="community-post-card">
                            @if($post->image)
                                <div class="community-card-img-wrap">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="community-card-img">
                                </div>
                            @endif

                            <div class="community-card-body">
                                <!-- Author Header with Top-Right Delete Button -->
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-3">
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

                                    <form action="{{ route('admin.community.destroy', $post->id) }}" method="POST" class="d-inline delete-community-post-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-community-delete" title="Delete Post" style="border-radius: 8px; padding: 5px 9px;">
                                            <i class="bx bx-trash" style="font-size: 1.1rem; vertical-align: middle;"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Post Title -->
                                <h5 class="community-post-title-text">
                                    <a href="{{ route('admin.community.show', $post->slug ?? $post->id) }}" class="card-title-link">
                                        {{ $post->title }}
                                    </a>
                                </h5>

                                <!-- Snippet -->
                                <p class="snippet-text">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                                </p>

                                <!-- Footer Actions -->
                                <div class="d-flex align-items-center justify-content-between community-post-footer">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge answers-badge">
                                            {{ $post->comments->count() }} ANSWERS
                                        </span>

                                        <!-- Toggle Switch for Public / Private -->
                                        <form action="{{ route('admin.community.toggle-status', $post->id) }}" method="POST" class="d-inline-flex align-items-center toggle-community-status-form">
                                            @csrf
                                            <button type="submit" class="btn-toggle-status" title="Click to toggle Public / Private">
                                                <div class="toggle-switch-track" style="background: {{ $post->is_published ? '#22c55e' : '#64748b' }}; justify-content: {{ $post->is_published ? 'flex-end' : 'flex-start' }};">
                                                    <div class="toggle-switch-dot"></div>
                                                </div>
                                                <span class="toggle-switch-label" style="color: {{ $post->is_published ? '#4ade80' : '#94a3b8' }};">
                                                    {{ $post->is_published ? 'Public' : 'Private' }}
                                                </span>
                                            </button>
                                        </form>
                                    </div>

                                    <div>
                                        <a href="{{ route('admin.community.show', $post->slug ?? $post->id) }}" class="btn btn-sm btn-community-view">
                                            View 
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="community-empty-state">
                            <i class="bx bx-conversation community-icon-large"></i>
                            <h4 class="community-empty-title">No Community Posts Found</h4>
                            <p class="community-empty-sub">There are no vendor posts created yet.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($posts->hasPages())
                <div class="community-pagination-wrap">
                    <div style="color: #94a3b8; font-size: 0.88rem; font-weight: 600;">
                        Showing {{ $posts->firstItem() ?? 0 }} to {{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} results
                    </div>
                    <div class="community-pagination-links">
                        {{ $posts->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        // AJAX Pagination (No Page Refresh)
        $(document).on('click', '.community-pagination-wrap .pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if (!url) return;

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (response) {
                    var $newContent = $(response).find('.community-grid-wrap');
                    if ($newContent.length) {
                        $('.community-grid-wrap').replaceWith($newContent);
                        $('html, body').animate({ scrollTop: $('.admin-panel').offset().top - 80 }, 300);
                    } else {
                        window.location.href = url;
                    }
                },
                error: function () {
                    window.location.href = url;
                }
            });
        });
        // Toggle Status Public / Private via jQuery AJAX
        $(document).on('submit', '.toggle-community-status-form', function (e) {
            e.preventDefault();
            var $form = $(this);
            var formData = new FormData(this);

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (data) {
                    if (data.success) {
                        var $track = $form.find('.toggle-switch-track');
                        var $label = $form.find('.toggle-switch-label');

                        if (data.is_published) {
                            $track.css({ 'background': '#22c55e', 'justify-content': 'flex-end' });
                            $label.css('color', '#4ade80').text('Public');
                        } else {
                            $track.css({ 'background': '#64748b', 'justify-content': 'flex-start' });
                            $label.css('color', '#94a3b8').text('Private');
                        }

                        Swal.fire({
                            title: 'Status Updated!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });

        // Delete Post via jQuery AJAX
        $(document).on('submit', '.delete-community-post-form', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $cardCol = $form.closest('.col-md-6, .col-lg-4');

            Swal.fire({
                title: 'Delete this post?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    var formData = new FormData($form[0]);
                    formData.append('_method', 'DELETE');

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function (data) {
                            if (data.success) {
                                $cardCol.css({
                                    'transition': 'opacity 0.3s ease, transform 0.3s ease',
                                    'opacity': '0',
                                    'transform': 'translateY(20px)'
                                });
                                setTimeout(function () { $cardCol.remove(); }, 300);

                                Swal.fire({
                                    title: 'Deleted!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to delete post.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
