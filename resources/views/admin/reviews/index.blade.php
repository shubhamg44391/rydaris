@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 style="margin: 0; font-weight: 800; font-size: 1.5rem; color: var(--text, #f8fafc);">
                    Customer Reviews Management
                </h2>
                <p style="margin: 4px 0 0 0; color: #94a3b8; font-size: 0.88rem;">Monitor, filter, and manage all customer ratings and reviews across vendors.</p>
            </div>
        </div>

        <!-- Filter & Search Controls Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                <!-- Vendor Filter Dropdown -->
                <select id="reviewVendorFilter" style="border: 1px solid var(--line, rgba(255,255,255,0.12)); background: var(--bg-card, #121e28); color: var(--text, #f8fafc); border-radius: var(--radius, 8px); padding: 8px 14px; font-size: 0.88rem;">
                    <option value="">All Vendors</option>
                    @foreach($vendors as $v)
                        <option value="{{ $v->id }}" {{ ($vendorId == $v->id) ? 'selected' : '' }}>{{ $v->name }}</option>
                    @endforeach
                </select>

                <!-- Rating Filter Dropdown -->
                <select id="reviewRatingFilter" style="border: 1px solid var(--line, rgba(255,255,255,0.12)); background: var(--bg-card, #121e28); color: var(--text, #f8fafc); border-radius: var(--radius, 8px); padding: 8px 14px; font-size: 0.88rem;">
                    <option value="">All Ratings</option>
                    <option value="5" {{ ($rating == 5) ? 'selected' : '' }}>5 Stars ★★★★★</option>
                    <option value="4" {{ ($rating == 4) ? 'selected' : '' }}>4 Stars ★★★★</option>
                    <option value="3" {{ ($rating == 3) ? 'selected' : '' }}>3 Stars ★★★</option>
                    <option value="2" {{ ($rating == 2) ? 'selected' : '' }}>2 Stars ★★</option>
                    <option value="1" {{ ($rating == 1) ? 'selected' : '' }}>1 Star ★</option>
                </select>
            </div>

            <!-- Search Form -->
            <div style="position: relative; min-width: 280px;">
                <input type="text" id="reviewSearchInput" value="{{ $search ?? '' }}" placeholder="Search comment, customer, vendor..." style="width: 100%; border: 1px solid var(--line, rgba(255,255,255,0.12)); background: var(--bg-card, #121e28); color: var(--text, #f8fafc); border-radius: var(--radius, 8px); padding: 8px 36px 8px 14px; font-size: 0.88rem;" />
                <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); fill: none; stroke: #94a3b8; stroke-width: 2; pointer-events: none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
        </div>

        <div id="reviewTableContainer">
            @include('admin.reviews.partials.table')
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        var searchTimer;

        function fetchReviews(url, pushState) {
            if (pushState === undefined) pushState = true;

            $('#reviewTableContainer').css({ 'opacity': '0.5', 'pointer-events': 'none' });

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (data) {
                    if (data.success) {
                        $('#reviewTableContainer').html(data.html);

                        if (pushState) {
                            history.pushState({ url: url }, '', url);
                        }
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to fetch reviews data.', 'error');
                },
                complete: function () {
                    $('#reviewTableContainer').css({ 'opacity': '1', 'pointer-events': '' });
                }
            });
        }

        function triggerFilter() {
            var searchVal = $('#reviewSearchInput').val();
            var vendorVal = $('#reviewVendorFilter').val();
            var ratingVal = $('#reviewRatingFilter').val();

            var url = "{{ route('admin.reviews.index') }}?search=" + encodeURIComponent(searchVal);
            if (vendorVal) url += "&vendor_id=" + encodeURIComponent(vendorVal);
            if (ratingVal) url += "&rating=" + encodeURIComponent(ratingVal);

            fetchReviews(url);
        }

        // Live Search Input
        $('#reviewSearchInput').on('keyup input', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(triggerFilter, 350);
        });

        // Dropdown Filters
        $('#reviewVendorFilter, #reviewRatingFilter').on('change', function () {
            triggerFilter();
        });

        // Pagination Links Click (AJAX)
        $(document).on('click', '#reviewTableContainer .pagination a', function (e) {
            e.preventDefault();
            fetchReviews($(this).attr('href'));
        });

        // Delete Review Click (AJAX)
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var $button = $(this);
            var $form = $button.closest('form');
            var $row = $button.closest('tr');
            if (!$form.length) return;

            Swal.fire({
                title: 'Delete Review?',
                text: "Are you sure you want to delete this customer review?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
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
                                $row.fadeOut(300, function () {
                                    $(this).remove();
                                });
                                Swal.fire('Deleted!', data.message, 'success');
                            } else {
                                Swal.fire('Error!', data.message || 'Failed to delete review.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'An error occurred while deleting review.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
