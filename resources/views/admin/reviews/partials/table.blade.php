<div class="panel-body admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 70px;">S.No</th>
                <th>Vendor</th>
                <th>Customer / User</th>
                <th>Vehicle / Booking</th>
                <th>Rating</th>
                <th>Review Comment</th>
                <th>Date</th>
                <th style="width: 80px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $startingNumber = ($reviews->currentPage() - 1) * $reviews->perPage() + 1;
            @endphp
            @forelse ($reviews as $review)
                <tr>
                    <td>{{ $startingNumber++ }}</td>
                    <td>
                        <strong style="color: var(--text, #f8fafc);">{{ $review->vendor->name ?? 'N/A' }}</strong>
                    </td>
                    <td>
                        <div>
                            <strong style="color: var(--text, #f8fafc);">{{ $review->user->name ?? 'Customer' }}</strong>
                            @if($review->user && $review->user->email)
                                <div style="font-size: 0.8rem; color: #94a3b8;">{{ $review->user->email }}</div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span style="font-size: 0.88rem; color: #cbd5e1;">
                            {{ $review->vehicle->name ?? ($review->booking ? 'Booking #' . $review->booking->id : 'N/A') }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 3px; color: #fbbf24; font-weight: 800;">
                            <span>{{ $review->rating }}</span>
                            <svg viewBox="0 0 24 24" style="width: 15px; height: 15px; fill: #fbbf24; stroke: #fbbf24;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                    </td>
                    <td>
                        <span style="font-size: 0.88rem; color: #cbd5e1; max-width: 250px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $review->comment }}">
                            {{ $review->comment }}
                        </span>
                    </td>
                    <td>
                        <span style="font-size: 0.82rem; color: #94a3b8;">{{ $review->created_at->format('Y-m-d H:i') }}</span>
                    </td>
                    <td>
                        <div class="table-actions" style="display: flex; gap: 6px; align-items: center;">
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="delete-form" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="icon-button delete-btn" title="Delete Review" style="color: #ef4444; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 6px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <svg viewBox="0 0 24 24" style="width: 15px; height: 15px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4" style="color: #94a3b8; font-style: italic;">No customer reviews found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($reviews->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line, rgba(255,255,255,0.08));">
        <div class="text-muted small">
            Showing {{ $reviews->firstItem() ?? 0 }} to {{ $reviews->lastItem() ?? 0 }} of {{ $reviews->total() }} reviews
        </div>
        <div>
            {{ $reviews->links('vendor.pagination.custom') }}
        </div>
    </div>
@endif
