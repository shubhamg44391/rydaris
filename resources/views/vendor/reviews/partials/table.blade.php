@if($reviews->count() > 0)
    <div class="table-responsive">
        <table class="table align-middle" style="color: #cbd5e1;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 0.8rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">
                    <th style="padding-bottom: 12px;">Customer</th>
                    <th style="padding-bottom: 12px;">Vehicle</th>
                    <th style="padding-bottom: 12px;">Booking Ref</th>
                    <th style="padding-bottom: 12px;">Rating</th>
                    <th style="padding-bottom: 12px;">Comments</th>
                    <th style="padding-bottom: 12px;">Date</th>
                    <th style="padding-bottom: 12px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $rev)
                    <tr id="review-row-{{ $rev->id }}" style="border-bottom: 1px solid rgba(255,255,255,0.04); font-size: 0.88rem;">
                        <td style="padding: 14px 8px;">
                            <strong style="color: #f8fafc; display: block;">{{ $rev->user->name ?? ($rev->booking->customer_fname . ' ' . $rev->booking->customer_lname) }}</strong>
                            <span style="font-size: 0.78rem; color: #94a3b8;">{{ $rev->user->email ?? $rev->booking->customer_email }}</span>
                        </td>
                        <td>
                            <span style="color: var(--brand, #52ead2); font-weight: 600;">{{ $rev->vehicle->name ?? 'Vehicle' }}</span>
                        </td>
                        <td>
                            <span style="font-family: monospace; font-size: 0.85rem; color: #94a3b8;">{{ $rev->booking->reservation_number ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <div style="color: #fbbf24; font-size: 1rem; font-weight: 700;">
                                @for($s = 1; $s <= 5; $s++)
                                    @if($s <= $rev->rating)
                                        ★
                                    @else
                                        ☆
                                    @endif
                                @endfor
                                <span class="ms-1" style="font-size: 0.8rem; color: #f8fafc;">({{ $rev->rating }})</span>
                            </div>
                        </td>
                        <td style="max-width: 280px;">
                            <span style="color: #e2e8f0; display: block; font-style: italic;">
                                "{{ $rev->comment ?? 'No comment provided' }}"
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 0.8rem; color: #94a3b8;">{{ $rev->created_at->format('d M, Y') }}</span>
                        </td>
                        <td style="text-align: right;">
                            <button type="button" onclick="deleteReview({{ $rev->id }})" class="btn btn-sm btn-outline-danger" style="padding: 4px 10px; font-size: 0.78rem; border-radius: 6px;" title="Delete Review">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3 ajax-pagination-container">
        {{ $reviews->links('vendor.pagination.custom') }}
    </div>
@else
    <div class="text-center py-5">
        <i class="fa fa-star text-warning fa-3x mb-3" style="opacity: 0.3;"></i>
        <h5 style="color: #cbd5e1; font-weight: 700;">No Reviews Found</h5>
        <p style="color: #94a3b8; font-size: 0.85rem; max-width: 400px; margin: 0 auto;">Customer ratings and comments will appear here as soon as users complete their rental trips.</p>
    </div>
@endif
