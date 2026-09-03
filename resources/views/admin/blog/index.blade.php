@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2>Blog Management</h2>
            </div>
            <div>
                <a href="{{ route('admin.blog.create') }}" class="admin-action" style="background: var(--brand); color: #061218; font-weight: bold; border-radius: var(--radius); padding: 8px 16px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Post
                </a>
            </div>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">S.No</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $startingNumber = 1; @endphp
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>{{ $post->title }}</td>
                            <td>
                                @if($post->is_published)
                                    <span style="color: #10b981; font-weight: bold;">Published</span>
                                @else
                                    <span style="color: #f59e0b; font-weight: bold;">Draft</span>
                                @endif
                            </td>
                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="icon-button" title="View Post" target="_blank" style="color: var(--brand);">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: var(--brand); stroke-width: 2;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.blog.edit', $post->id) }}" class="icon-button" title="Edit">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-button delete-btn" title="Delete" onclick="return confirm('Are you sure you want to delete this post?');">
                                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4" style="color: #64748b; font-style: italic;">No blog posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
