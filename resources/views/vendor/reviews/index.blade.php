@extends('admin.layouts.app')

@section('title', 'Customer Reviews')

@section('main-content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1" style="color: #f8fafc;">Customer Reviews & Ratings</h4>
            <p style="color: #94a3b8; font-size: 0.88rem; margin: 0;">Manage customer feedback and rating scores for your vehicle rentals.</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="p-2 px-3 text-center" style="background: rgba(251, 191, 36, 0.1); border: 1px solid rgba(251, 191, 36, 0.3); border-radius: 10px;">
                <span id="stat-avg-rating" style="font-size: 1.2rem; font-weight: 800; color: #fbbf24;">{{ number_format($avgRating, 1) }} ★</span>
                <span style="display: block; font-size: 0.72rem; color: #cbd5e1; text-transform: uppercase; font-weight: 700;">Average Rating</span>
            </div>
            <div class="p-2 px-3 text-center" style="background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.3); border-radius: 10px;">
                <span id="stat-total-reviews" style="font-size: 1.2rem; font-weight: 800; color: #52ead2;">{{ $totalReviews }}</span>
                <span style="display: block; font-size: 0.72rem; color: #cbd5e1; text-transform: uppercase; font-weight: 700;">Total Reviews</span>
            </div>
        </div>
    </div>

    {{-- Reviews Container --}}
    <div class="dark-card p-4" style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px;">
        <div id="reviews-container">
            @include('vendor.reviews.partials.table')
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $(document).on('click', '.ajax-pagination-container a', function(e) {
        e.preventDefault();
        var pageUrl = $(this).attr('href');
        if (pageUrl) {
            fetchReviews(pageUrl);
        }
    });
});

function fetchReviews(pageUrl) {
    var url = pageUrl || '{{ route("vendor.reviews.index") }}';

    $('#reviews-container').css('opacity', '0.5');

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            $('#reviews-container').css('opacity', '1');
            if (response.status === 'success') {
                $('#reviews-container').html(response.html);
                if (response.avgRating) {
                    $('#stat-avg-rating').text(response.avgRating + ' ★');
                }
                if (response.totalReviews !== undefined) {
                    $('#stat-total-reviews').text(response.totalReviews);
                }
            }
        },
        error: function() {
            $('#reviews-container').css('opacity', '1');
        }
    });
}

function deleteReview(reviewId) {
    Swal.fire({
        title: 'Delete Review?',
        text: 'Are you sure you want to delete this customer review?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#475569',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ url("vendor/reviews") }}/' + reviewId,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#review-row-' + reviewId).fadeOut(300, function() {
                            $(this).remove();
                        });
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Review deleted successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Error', response.message || 'Failed to delete review.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to delete review.', 'error');
                }
            });
        }
    });
}
</script>
@endsection
