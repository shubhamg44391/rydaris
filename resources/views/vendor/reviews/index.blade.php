@extends('admin.layouts.app')

@section('title', 'Customer Reviews')

@section('main-content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #f8fafc;">Customer Reviews & Ratings</h4>
            <p style="color: #94a3b8; font-size: 0.88rem; margin: 0;">Manage customer feedback and rating scores for your vehicle rentals.</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="p-2 px-3 text-center" style="background: rgba(251, 191, 36, 0.1); border: 1px solid rgba(251, 191, 36, 0.3); border-radius: 10px;">
                <span style="font-size: 1.2rem; font-weight: 800; color: #fbbf24;">{{ number_format($avgRating, 1) }} ★</span>
                <span style="display: block; font-size: 0.72rem; color: #cbd5e1; text-transform: uppercase; font-weight: 700;">Average Rating</span>
            </div>
            <div class="p-2 px-3 text-center" style="background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.3); border-radius: 10px;">
                <span style="font-size: 1.2rem; font-weight: 800; color: #52ead2;">{{ $totalReviews }}</span>
                <span style="display: block; font-size: 0.72rem; color: #cbd5e1; text-transform: uppercase; font-weight: 700;">Total Reviews</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: rgba(34, 197, 94, 0.15); border-color: rgba(34, 197, 94, 0.3); color: #4ade80;">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="dark-card p-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px;">
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
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.04); font-size: 0.88rem;">
                                <td style="padding: 14px 8px;">
                                    <strong style="color: #f8fafc; display: block;">{{ $rev->user->name ?? ($rev->booking->customer_fname . ' ' . $rev->booking->customer_lname) }}</strong>
                                    <span style="font-size: 0.78rem; color: #64748b;">{{ $rev->user->email ?? $rev->booking->customer_email }}</span>
                                </td>
                                <td>
                                    <span style="color: #52ead2; font-weight: 600;">{{ $rev->vehicle->name ?? 'Vehicle' }}</span>
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
                                    <form action="{{ route('vendor.reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 3px 8px; font-size: 0.75rem;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa fa-star text-warning fa-3x mb-3" style="opacity: 0.3;"></i>
                <h5 style="color: #cbd5e1; font-weight: 700;">No Reviews Received Yet</h5>
                <p style="color: #64748b; font-size: 0.85rem; max-width: 400px; margin: 0 auto;">Customer ratings and comments will appear here automatically as soon as users complete their rental trips.</p>
            </div>
        @endif
    </div>
</div>
@endsection
