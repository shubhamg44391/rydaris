@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2>Coupons Management</h2>
        </div>
        <div>
            @if(Auth::user()->canAddCoupon())
                <a href="{{ route('vendor.coupons.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 20px; background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%); color: #051013; border-radius: 999px; font-weight: 800 !important; font-size: 0.85rem; border: none; cursor: pointer; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35); text-decoration: none;">
                    <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 3;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Coupon
                </a>
            @else
                <span class="badge" style="background: rgba(82, 234, 210, 0.1); color: var(--brand, #52ead2); border: 1px solid rgba(82, 234, 210, 0.3); padding: 8px 14px; font-size: 0.85rem; font-weight: 700; border-radius: 999px;">Limit Reached</span>
            @endif
        </div>
    </div>

    <div id="couponsTableContainer">
        @section('coupons_table_section')
        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Discount</th>
                        <th>Valid To</th>
                        <th>Usage</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td style="font-weight: 700; color: #fff;">
                                <span class="badge" style="background: rgba(82, 234, 210, 0.12); color: var(--brand, #52ead2); border: 1px solid rgba(82, 234, 210, 0.25); padding: 6px 12px; border-radius: 6px; font-size: 0.9rem; font-weight: 800; font-family: monospace;">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td>
                                <span style="text-transform: capitalize; color: #cbd5e1; font-size: 0.88rem; font-weight: 600;">
                                    {{ $coupon->type }}
                                </span>
                            </td>
                            <td>
                                <strong style="color: #f8fafc; font-size: 0.95rem;">
                                    @if($coupon->type === 'percentage')
                                        {{ $coupon->discount }}%
                                    @else
                                        ${{ number_format($coupon->discount, 2) }}
                                    @endif
                                </strong>
                            </td>
                            <td style="color: #94a3b8; font-size: 0.88rem;">
                                {{ $coupon->valid_to ? \Carbon\Carbon::parse($coupon->valid_to)->format('d M Y') : 'No Expiry' }}
                            </td>
                            <td style="color: #cbd5e1; font-size: 0.88rem;">
                                {{ $coupon->used_count }} / {{ $coupon->availability_count ?? '∞' }}
                            </td>
                            <td>
                                <div class="table-actions" style="display: flex; gap: 8px;">
                                    <a href="{{ route('vendor.coupons.edit', $coupon->id) }}" class="icon-button" title="Edit" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius, 8px); color: #0f766e; background: #ffffff; text-decoration: none;">
                                        <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <button type="button" class="icon-button delete-btn" title="Delete" onclick="deleteCoupon({{ $coupon->id }})" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #fee2e2; border-radius: var(--radius, 8px); color: #ef4444; background: #ffffff; cursor: pointer; padding: 0;">
                                        <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 30px; color: #94a3b8; text-align: center;">
                                No coupons found. Create your first coupon to offer discounts!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @show
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function fetchCoupons() {
        $('#couponsTableContainer').css('opacity', '0.5');
        $.ajax({
            url: '{{ route("vendor.coupons.index") }}',
            type: 'GET',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if (response.status === 'success' && response.html) {
                    $('#couponsTableContainer').html(response.html).css('opacity', '1');
                }
            },
            error: function() {
                $('#couponsTableContainer').css('opacity', '1');
            }
        });
    }

    function deleteCoupon(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the coupon. You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('vendor/coupons') }}/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    dataType: 'json',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'Coupon deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            fetchCoupons();
                        } else {
                            Swal.fire('Error', response.message || 'Failed to delete coupon.', 'error');
                        }
                    }
                });
            }
        });
    }
</script>
@endsection

