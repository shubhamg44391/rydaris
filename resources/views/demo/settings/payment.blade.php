@extends('demo.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700;">Payment Settings</h1>
        <p style="margin: 6px 0 0; color: var(--text-muted); font-size: 0.9rem;">Configure your Razorpay payment keys.</p>
    </div>
</div>

<div class="glass-card" style="max-width: 700px;">
    <form onsubmit="event.preventDefault(); Swal.fire({icon:'success', title:'Saved successfully!', toast:true, position:'top-end', showConfirmButton:false, timer:1800});">
        <div class="xp-fg" style="margin-bottom:18px;">
            <label style="display:flex; align-items:center; gap:10px; font-size:.9rem; font-weight:600; color:#f8fafc; cursor:pointer;">
                <input type="checkbox" checked style="width:18px; height:18px; accent-color:var(--brand);">
                Enable Razorpay
            </label>
        </div>
        <div class="xp-fg" style="margin-bottom:18px;">
            <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">Key ID</label>
            <input type="text" value="rzp_test_xxxxxxxxxxxx" style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box;">
        </div>
        <div class="xp-fg" style="margin-bottom:18px;">
            <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">Key Secret</label>
            <input type="password" value="rzp_secret_xxxxxxxx" style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box;">
        </div>
        <div class="xp-fg" style="margin-bottom:18px;">
            <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">Tax Percentage (%)</label>
            <input type="number" value="18" min="0" max="100" style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box;">
        </div>
        <div style="display:flex; justify-content:flex-end;">
            <button type="submit" class="xp-btn-save">Save Payment Settings</button>
        </div>
    </form>
</div>
@endsection
