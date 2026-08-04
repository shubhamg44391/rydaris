@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2>Add New Coupon</h2>
        </div>
        <div>
            <a href="{{ route('vendor.coupons.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 999px; color: #cbd5e1; border: 1px solid rgba(255,255,255,0.2); padding: 6px 18px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">Back to Coupons</a>
        </div>
    </div>

    <div class="panel-body">
        <form id="couponCreateForm" action="{{ route('vendor.coupons.store') }}" method="POST" onsubmit="submitCouponForm(event)">
            @csrf
            <input type="hidden" name="type" id="coupon_type" value="fixed">

            {{-- Type Selection Tabs --}}
            <div style="margin-bottom: 25px;">
                <label style="display: block; color: #cbd5e1; font-size: 0.88rem; font-weight: 600; margin-bottom: 10px;">Select Coupon Type <span style="color:#ef4444">*</span></label>
                <div class="row g-3" style="max-width: 600px;">
                    <div class="col-6">
                        <div class="type-selector" id="type-percentage" onclick="selectType('percentage')" style="cursor: pointer; padding: 14px 18px; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; gap: 12px; background: rgba(255, 255, 255, 0.03); transition: all 0.2s;">
                            <div class="icon-container" style="color: #94a3b8; font-weight: 800; font-size: 1.1rem; width: 28px; text-align: center;">%</div>
                            <div>
                                <h6 class="title-text" style="color: #f8fafc; font-weight: 700; margin: 0; font-size: 0.9rem;">Percentage Based</h6>
                                <span class="desc-text" style="color: #94a3b8; font-size: 0.78rem;">Discount as %</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="type-selector active" id="type-fixed" onclick="selectType('fixed')" style="cursor: pointer; padding: 14px 18px; border: 1px solid var(--brand, #52ead2); border-radius: 10px; display: flex; align-items: center; gap: 12px; background: rgba(255, 255, 255, 0.06); transition: all 0.2s;">
                            <div class="icon-container" style="color: var(--brand, #52ead2); font-weight: 800; font-size: 1.1rem; width: 28px; text-align: center;">$</div>
                            <div>
                                <h6 class="title-text" style="color: var(--brand, #52ead2); font-weight: 700; margin: 0; font-size: 0.9rem;">Amount Based</h6>
                                <span class="desc-text" style="color: var(--brand, #52ead2); font-size: 0.78rem;">Fixed amount ($)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <label style="display: inline-flex; align-items: center; gap: 4px; color: #f8fafc; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; white-space: nowrap;">
                        <span>Coupon Code</span>
                        <span style="color:#ef4444; display: inline;">*</span>
                    </label>
                    <input type="text" name="code" class="form-control" placeholder="e.g. SAVE50" value="{{ old('code') }}" required style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #fff; padding: 10px 14px; border-radius: 8px; font-weight: 700; text-transform: uppercase; outline: none;">
                </div>
                <div class="col-md-6">
                    <label id="discount-label" style="display: inline-flex; align-items: center; gap: 4px; color: #f8fafc; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; white-space: nowrap;">
                        <span>Discount Amount ($)</span>
                        <span style="color:#ef4444; display: inline;">*</span>
                    </label>
                    <input type="number" step="0.01" min="0" name="discount" class="form-control" placeholder="e.g. 50.00" value="{{ old('discount') }}" required style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #fff; padding: 10px 14px; border-radius: 8px; outline: none;">
                </div>
                
                <div class="col-12">
                    <label style="display: block; color: #f8fafc; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Coupon Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Describe the coupon conditions, terms, and rules..." style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #fff; padding: 10px 14px; border-radius: 8px; outline: none;">{{ old('description') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label style="display: block; color: #f8fafc; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">From Date</label>
                    <input type="date" name="valid_from" min="{{ date('Y-m-d') }}" class="form-control" value="{{ old('valid_from') }}" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #fff; padding: 10px 14px; border-radius: 8px; color-scheme: dark; outline: none;">
                </div>
                <div class="col-md-6">
                    <label style="display: block; color: #f8fafc; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">To Date</label>
                    <input type="date" name="valid_to" min="{{ date('Y-m-d') }}" class="form-control" value="{{ old('valid_to') }}" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #fff; padding: 10px 14px; border-radius: 8px; color-scheme: dark; outline: none;">
                </div>

                <div class="col-md-6">
                    <label style="display: block; color: #f8fafc; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Minimum Booking Amount ($)</label>
                    <input type="number" step="0.01" min="0" name="min_booking_amount" class="form-control" placeholder="e.g. 200.00" value="{{ old('min_booking_amount') }}" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #fff; padding: 10px 14px; border-radius: 8px; outline: none;">
                </div>
                <div class="col-md-6">
                    <label style="display: block; color: #f8fafc; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Availability Count</label>
                    <input type="number" min="1" name="availability_count" class="form-control" placeholder="e.g. 25" value="{{ old('availability_count') }}" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12); color: #fff; padding: 10px 14px; border-radius: 8px; outline: none;">
                </div>

                <div class="col-12 mt-4" style="display: flex; gap: 12px; align-items: center;">
                    <button type="submit" id="submit-btn" class="btn btn-primary" style="font-weight: 800; border-radius: 999px; font-size: 0.9rem; padding: 10px 28px; background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important; color: #051013 !important; border: none !important; box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35); cursor: pointer;">
                        Create Amount-Based Coupon
                    </button>
                    <a href="{{ route('vendor.coupons.index') }}" class="btn btn-link" style="color: #94a3b8; text-decoration: none; font-size: 0.88rem;">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function selectType(type) {
    document.getElementById('coupon_type').value = type;
    
    const percentageDiv = document.getElementById('type-percentage');
    const fixedDiv = document.getElementById('type-fixed');
    
    const inactiveStyle = "cursor: pointer; padding: 14px 18px; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; gap: 12px; background: rgba(255, 255, 255, 0.03); transition: all 0.2s;";
    percentageDiv.style.cssText = inactiveStyle;
    fixedDiv.style.cssText = inactiveStyle;
    
    percentageDiv.querySelector('.icon-container').style.color = "#94a3b8";
    percentageDiv.querySelector('.title-text').style.color = "#f8fafc";
    percentageDiv.querySelector('.desc-text').style.color = "#94a3b8";
    
    fixedDiv.querySelector('.icon-container').style.color = "#94a3b8";
    fixedDiv.querySelector('.title-text').style.color = "#f8fafc";
    fixedDiv.querySelector('.desc-text').style.color = "#94a3b8";
    
    const activeStyle = "cursor: pointer; padding: 14px 18px; border: 1px solid var(--brand, #52ead2); border-radius: 10px; display: flex; align-items: center; gap: 12px; background: rgba(255, 255, 255, 0.06); transition: all 0.2s;";
    const activeDiv = document.getElementById('type-' + type);
    activeDiv.style.cssText = activeStyle;
    
    activeDiv.querySelector('.icon-container').style.color = "var(--brand, #52ead2)";
    activeDiv.querySelector('.title-text').style.color = "var(--brand, #52ead2)";
    activeDiv.querySelector('.desc-text').style.color = "var(--brand, #52ead2)";
    
    if (type === 'percentage') {
        document.getElementById('discount-label').innerHTML = '<span>Discount Percentage (%)</span> <span style="color:#ef4444; display:inline;">*</span>';
        document.getElementById('submit-btn').innerText = 'Create Percentage-Based Coupon';
    } else {
        document.getElementById('discount-label').innerHTML = '<span>Discount Amount ($)</span> <span style="color:#ef4444; display:inline;">*</span>';
        document.getElementById('submit-btn').innerText = 'Create Amount-Based Coupon';
    }
}

function submitCouponForm(e) {
    if (e && e.preventDefault) e.preventDefault();
    
    var btn = $('#submit-btn');
    btn.prop('disabled', true).css('opacity', '0.7');
    
    $.ajax({
        url: $('#couponCreateForm').attr('action'),
        type: 'POST',
        data: $('#couponCreateForm').serialize(),
        dataType: 'json',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(response) {
            btn.prop('disabled', false).css('opacity', '1');
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Coupon created successfully.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = response.redirect || '{{ route("vendor.coupons.index") }}';
                });
            } else {
                Swal.fire('Error', response.message || 'Failed to create coupon.', 'error');
            }
        },
        error: function(xhr) {
            btn.prop('disabled', false).css('opacity', '1');
            var msg = 'Failed to create coupon.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            Swal.fire('Validation Error', msg, 'error');
        }
    });
}
</script>
@endsection

