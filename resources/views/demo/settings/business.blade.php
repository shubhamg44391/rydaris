@extends('demo.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700;">Business Settings</h1>
        <p style="margin: 6px 0 0; color: var(--text-muted); font-size: 0.9rem;">Manage your company profile details.</p>
    </div>
</div>

<div class="glass-card" style="max-width: 900px;">
    <form onsubmit="event.preventDefault(); Swal.fire({icon:'success', title:'Saved successfully!', toast:true, position:'top-end', showConfirmButton:false, timer:1800});">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px;">
            <div class="xp-fg" style="margin:0;">
                <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">Company Name</label>
                <input type="text" value="Rydaris Motors" required style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box;">
            </div>
            <div class="xp-fg" style="margin:0;">
                <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">Contact Email</label>
                <input type="email" value="info@rydaris.com" required style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box;">
            </div>
            <div class="xp-fg" style="margin:0;">
                <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">Phone</label>
                <input type="text" value="+91 98765 00000" required style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box;">
            </div>
            <div class="xp-fg" style="margin:0;">
                <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">Default Branch</label>
                <input type="text" value="Dhili" required style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box;">
            </div>
            <div class="xp-fg" style="margin:0; grid-column:1 / -1;">
                <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">Business Address</label>
                <textarea rows="3" style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box; font-family:inherit;">Main Market Road, Dhili, Surat, Gujarat</textarea>
            </div>
        </div>
        <div style="display:flex; justify-content:flex-end; margin-top:24px; padding-top:18px; border-top:1px solid rgba(255,255,255,0.05);">
            <button type="submit" class="xp-btn-save">Save Settings</button>
        </div>
    </form>
</div>
<style>
@media (max-width: 700px) {
    div[style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
}
</style>
@endsection
