@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2>Page Management</h2>
            </div>
            @php
                $allowedPredefined = [
                    'help-center' => 'Help Center',
                    'roi-guide' => 'ROI Guide',
                    'fleet-playbook' => 'Fleet Playbook',
                    'support-desk' => 'Support Desk',
                    'sitemap' => 'Sitemap',
                    'security' => 'Security',
                    'privacy-policy' => 'Privacy Policy'
                ];

                $existingSlugs = \App\Models\Page::pluck('slug')->toArray();
                $missingPredefined = [];
                foreach($allowedPredefined as $slug => $label) {
                    if(!in_array($slug, $existingSlugs, true)) {
                        $missingPredefined[$slug] = $label;
                    }
                }
            @endphp
            @if(count($missingPredefined) > 0)
                <div>
                    <a href="{{ route('admin.pages.create') }}" class="admin-action" style="background: var(--brand); color: #061218; font-weight: bold; border-radius: var(--radius); padding: 8px 16px; display: inline-flex; align-items: center; gap: 5px; text-decoration: none;">
                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Page
                    </a>
                </div>
            @endif
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">S.No</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Meta Title</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingNumber = ($pages->currentPage() - 1) * $pages->perPage() + 1;
                    @endphp
                    @forelse ($pages as $page)
                        <tr>
                            <td>{{ $startingNumber++ }}</td>
                            <td>{{ $page->title }}</td>
                            <td><code>{{ $page->slug }}</code></td>
                            <td>{{ $page->meta_title ?? '-' }}</td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <a href="{{ route('frontend.page', $page->slug) }}" class="icon-button" title="View Page" target="_blank" style="color: var(--brand);">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: var(--brand); stroke-width: 2;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="icon-button" title="Edit">
                                        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-button delete-btn" title="Delete">
                                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4" style="color: #64748b; font-style: italic;">No pages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pages->hasPages())
            <div style="padding: 15px; display: flex; justify-content: flex-end;">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
