<div class="panel-body admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 80px;">S.No</th>
                <th style="width: 150px;">Category</th>
                <th>Question / Title</th>
                <th>Answer / Description</th>
                <th style="width: 120px; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $startingNumber = ($faqs->currentPage() - 1) * $faqs->perPage() + 1;
            @endphp
            @forelse ($faqs as $faq)
                <tr>
                    <td>{{ $startingNumber++ }}</td>
                    <td>
                        <span class="badge" style="background: rgba(82,234,210,0.12); color: var(--brand, #0d9488); border: 1px solid rgba(82,234,210,0.25); padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.78rem;">
                            @if($faq->category === 'product_basics')
                                Product Basics
                            @elseif($faq->category === 'onboarding')
                                Onboarding
                            @elseif($faq->category === 'reporting')
                                Reporting
                            @else
                                {{ ucwords(str_replace('_', ' ', $faq->category)) }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <strong class="faq-title-text" style="color: var(--text, #f8fafc);">{{ $faq->title }}</strong>
                    </td>
                    <td>
                        <div class="faq-desc-text" style="color: var(--muted, #aab7cb); font-size: 0.9rem; line-height: 1.5; white-space: pre-line;">
                            {{ $faq->description }}
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <div class="table-actions" style="display: inline-flex; gap: 8px;">
                            @if(auth()->user()->hasAdminPermission('faqs', 'edit'))
                            <button type="button" class="icon-button edit-faq-btn" title="Edit FAQ"
                                data-id="{{ $faq->id }}"
                                data-category="{{ $faq->category }}"
                                data-title="{{ e($faq->title) }}"
                                data-description="{{ e($faq->description) }}">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                            </button>
                            @endif
                            @if(auth()->user()->hasAdminPermission('faqs', 'delete'))
                            <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="icon-button delete-faq-btn" title="Delete FAQ">
                                    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4" style="color: var(--muted, #64748b); font-style: italic;">No FAQs found in this category.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($faqs->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line, rgba(255,255,255,0.05));">
        <div class="text-muted small">
            Showing {{ $faqs->firstItem() ?? 0 }} to {{ $faqs->lastItem() ?? 0 }} of {{ $faqs->total() }} results
        </div>
        <div class="pagination-wrapper">
            {{ $faqs->appends(['category' => $category])->links('vendor.pagination.custom') }}
        </div>
    </div>
@endif
