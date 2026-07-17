@extends('demo.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700;">Terms & Conditions</h1>
        <p style="margin: 6px 0 0; color: var(--text-muted); font-size: 0.9rem;">Content shown to customers during booking.</p>
    </div>
</div>

<div class="glass-card" style="max-width: 900px;">
    <form onsubmit="event.preventDefault(); Swal.fire({icon:'success', title:'Saved successfully!', toast:true, position:'top-end', showConfirmButton:false, timer:1800});">
        <div class="xp-fg" style="margin-bottom:18px;">
            <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">Title</label>
            <input type="text" value="Rental Terms & Conditions" required
                style="width:100%; padding:12px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; font-size:.88rem; color:#fff; background:rgba(255,255,255,0.05); box-sizing:border-box;">
        </div>
        <div class="xp-fg" style="margin-bottom:18px;">
            <label style="display:block; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px;">Content</label>
            <textarea rows="14" required
                style="width:100%; padding:14px; border:1px solid rgba(255,255,255,0.15); border-radius:8px; font-size:.9rem; color:#cbd5e1; background:rgba(255,255,255,0.05); box-sizing:border-box; font-family:inherit; line-height:1.7; resize:vertical;">1. The renter must hold a valid driving licence for the full rental period.

2. Vehicles must be returned with the same fuel level as at pickup (Full to Full).

3. Smoking inside the vehicle is strictly prohibited.

4. Any damage beyond normal wear and tear will be charged to the renter.

5. Late returns beyond the grace period of 60 minutes may incur an extra day charge.

6. Mileage allowance is 250 km per day unless otherwise agreed in writing.</textarea>
        </div>
        <div style="display:flex; justify-content:flex-end;">
            <button type="submit" class="xp-btn-save">Update Terms</button>
        </div>
    </form>
</div>
@endsection
