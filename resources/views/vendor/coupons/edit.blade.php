@extends('admin.layouts.app')

@section('main-content')
<div class="container-fluid p-4">
    
    <div class="mb-4 text-center">
        <h3 class="text-white" style="font-weight: 800;">Edit Coupon</h3>
        <p style="color: #94a3b8; font-size: 0.9rem;">Update your existing coupon details.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; color: #fff;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vendor.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="type" id="coupon_type" value="{{ $coupon->type }}">

        
        <div class="row mb-5 justify-content-center">
            <div class="col-md-5">
                <div class="type-selector" id="type-percentage" onclick="selectType('percentage')" style="cursor: pointer; padding: 20px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; gap: 15px; background: rgba(11, 16, 32, 0.6); transition: all 0.3s;">
                    <div class="icon-container" style="color: #94a3b8; display: flex; flex-direction: column; align-items: center;">
                        <span style="font-size: 1.2rem; font-weight: 800;">%</span>
                    </div>
                    <div>
                        <h6 class="mb-1 title-text" style="color: #f8fafc; font-weight: 700;">Percentage Based</h6>
                        <span style="color: #94a3b8; font-size: 0.8rem;">Discount as a percentage</span>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="type-selector active" id="type-fixed" onclick="selectType('fixed')" style="cursor: pointer; padding: 20px; border: 1px solid #ef4444; border-radius: 8px; display: flex; align-items: center; justify-content: center; gap: 15px; background: rgba(239, 68, 68, 0.05); transition: all 0.3s;">
                    <div class="icon-container" style="color: #ef4444; display: flex; flex-direction: column; align-items: center;">
                        <span style="font-size: 1.2rem; font-weight: 800;">$</span>
                    </div>
                    <div>
                        <h6 class="mb-1 title-text" style="color: #ef4444; font-weight: 700;">Amount Based</h6>
                        <span class="desc-text" style="color: #ef4444; font-size: 0.8rem;">Fixed amount discount</span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card mx-auto" style="max-width: 900px; background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 12px;">
            <div class="card-body p-5">
                <div class="mb-4">
                    <h4 class="text-white mb-1" id="form-title" style="font-weight: 800; display: flex; align-items: center; gap: 10px;">
                        <span id="form-icon" style="color: #ef4444;">$</span> 
                        <span id="form-title-text">Amount-Based Coupon</span>
                    </h4>
                    <p style="color: #94a3b8; font-size: 0.85rem;" id="form-subtitle">Create a coupon with fixed amount discount</p>
                </div>
                
                <hr style="border-color: rgba(255,255,255,0.1); margin-bottom: 25px;">

                <div class="row g-4">
                    <div class="col-md-6">
                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Coupon Name *</label>
                        <input type="text" name="code" class="form-control" placeholder="e.g., SAVE50" value="{{ old('code', $coupon->code) }}" required style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px 15px;">
                    </div>
                    <div class="col-md-6">
                        <label id="discount-label" style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Discount Amount ($) *</label>
                        <input type="number" step="0.01" name="discount" class="form-control" placeholder="e.g., 50.00" value="{{ old('discount', $coupon->discount) }}" required style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px 15px;">
                    </div>
                    
                    <div class="col-12">
                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Coupon Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe the coupon conditions, terms, and rules..." style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px 15px;">{{ old('description', $coupon->description) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">From Date</label>
                        <input type="date" name="valid_from" min="{{ date('Y-m-d') }}" class="form-control" value="{{ old('valid_from', $coupon->valid_from) }}" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8; padding: 12px 15px; color-scheme: dark;">
                    </div>
                    <div class="col-md-6">
                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">To Date</label>
                        <input type="date" name="valid_to" min="{{ date('Y-m-d') }}" class="form-control" value="{{ old('valid_to', $coupon->valid_to) }}" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8; padding: 12px 15px; color-scheme: dark;">
                    </div>

                    <div class="col-md-6">
                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Minimum Booking Amount ($)</label>
                        <input type="number" step="0.01" name="min_booking_amount" class="form-control" placeholder="e.g., 200.00" value="{{ old('min_booking_amount', $coupon->min_booking_amount) }}" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px 15px;">
                    </div>
                    <div class="col-md-6">
                        <label style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Availability Count</label>
                        <input type="number" name="availability_count" class="form-control" placeholder="e.g., 25" value="{{ old('availability_count', $coupon->availability_count) }}" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px 15px;">
                    </div>

                    <div class="col-12 mt-5">
                        <button type="submit" id="submit-btn" class="btn btn-primary w-100 py-3" style="font-weight: 800; border-radius: 8px; font-size: 1rem;">
                            Update Amount-Based Coupon
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function selectType(type) {
    document.getElementById('coupon_type').value = type;
    
    const percentageDiv = document.getElementById('type-percentage');
    const fixedDiv = document.getElementById('type-fixed');
    
    // Reset both to inactive styles
    const inactiveStyle = "cursor: pointer; padding: 20px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; gap: 15px; background: rgba(11, 16, 32, 0.6); transition: all 0.3s;";
    percentageDiv.style.cssText = inactiveStyle;
    fixedDiv.style.cssText = inactiveStyle;
    
    // Reset colors
    percentageDiv.querySelector('.icon-container').style.color = "#94a3b8";
    percentageDiv.querySelector('.title-text').style.color = "#f8fafc";
    percentageDiv.querySelector('span:last-child').style.color = "#94a3b8";
    
    fixedDiv.querySelector('.icon-container').style.color = "#94a3b8";
    fixedDiv.querySelector('.title-text').style.color = "#f8fafc";
    fixedDiv.querySelector('.desc-text').style.color = "#94a3b8";
    
    // Apply active styles to selected
    const activeStyle = "cursor: pointer; padding: 20px; border: 1px solid #ef4444; border-radius: 8px; display: flex; align-items: center; justify-content: center; gap: 15px; background: rgba(239, 68, 68, 0.05); transition: all 0.3s;";
    const activeDiv = document.getElementById('type-' + type);
    activeDiv.style.cssText = activeStyle;
    
    activeDiv.querySelector('.icon-container').style.color = "#ef4444";
    activeDiv.querySelector('.title-text').style.color = "#ef4444";
    const descText = activeDiv.querySelector('span:last-child');
    if(descText) descText.style.color = "#ef4444";
    
    // Update Form Content
    if (type === 'percentage') {
        document.getElementById('form-icon').innerText = '%';
        document.getElementById('form-title-text').innerText = 'Percentage-Based Coupon';
        document.getElementById('form-subtitle').innerText = 'Update a coupon with percentage discount';
        document.getElementById('discount-label').innerText = 'Discount Percentage (%) *';
        document.getElementById('submit-btn').innerText = 'Update Percentage-Based Coupon';
    } else {
        document.getElementById('form-icon').innerText = '$';
        document.getElementById('form-title-text').innerText = 'Amount-Based Coupon';
        document.getElementById('form-subtitle').innerText = 'Update a coupon with fixed amount discount';
        document.getElementById('discount-label').innerText = 'Discount Amount ($) *';
        document.getElementById('submit-btn').innerText = 'Update Amount-Based Coupon';
    }
}

// Initialize on page load based on existing value
window.addEventListener('DOMContentLoaded', () => {
    selectType('{{ $coupon->type }}');
});
</script>
@endsection
