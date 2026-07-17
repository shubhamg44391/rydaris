@extends('demo.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="margin: 0; font-size: 1.8rem; font-weight: 700;">Buy Subscription</h1>
        <p style="margin: 6px 0 0; color: var(--text-muted); font-size: 0.9rem;">Choose a subscription plan for your account.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px;">
    @foreach($packages as $pkg)
        <div class="glass-card" style="{{ $pkg['highlight'] ? 'border-color: rgba(82,234,210,0.55); box-shadow: 0 0 0 1px rgba(82,234,210,0.25);' : '' }}">
            @if($pkg['highlight'])
                <div style="display:inline-block; background:rgba(82,234,210,0.15); color:var(--brand); font-size:0.72rem; font-weight:700; padding:4px 10px; border-radius:20px; margin-bottom:12px;">POPULAR</div>
            @endif
            <h3 style="margin:0 0 8px; font-size:1.3rem;">{{ $pkg['name'] }}</h3>
            <div style="font-size:1.6rem; font-weight:800; color:var(--brand); margin-bottom:16px;">{{ $pkg['price'] }}</div>
            <ul style="list-style:none; padding:0; margin:0 0 20px; color:var(--text-muted); font-size:0.9rem; line-height:1.9;">
                <li><i class="fa-solid fa-check" style="color:var(--brand); margin-right:8px;"></i>{{ $pkg['users'] }} users</li>
                <li><i class="fa-solid fa-check" style="color:var(--brand); margin-right:8px;"></i>{{ $pkg['vehicles'] }} vehicles</li>
                <li><i class="fa-solid fa-check" style="color:var(--brand); margin-right:8px;"></i>Bookings & reports</li>
                <li><i class="fa-solid fa-check" style="color:var(--brand); margin-right:8px;"></i>Email support</li>
            </ul>
            <button type="button" onclick="demoSelectPlan('{{ $pkg['name'] }}', '{{ $pkg['price'] }}')" class="xp-btn-save" style="width:100%;">Select Plan</button>
        </div>
    @endforeach
</div>

<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns: repeat(3"] { grid-template-columns: 1fr !important; }
}
</style>
<div id="demoPlanModal" class="xp-overlay">
    <div class="xp-modal">
        <div class="xp-modal-head">
            <span class="xp-modal-title">Confirm Plan</span>
            <button class="xp-modal-x" onclick="xpClose('demoPlanModal')">&times;</button>
        </div>
        <form onsubmit="event.preventDefault(); xpClose('demoPlanModal'); Swal.fire({icon:'success', title:'Plan selected', toast:true, position:'top-end', showConfirmButton:false, timer:1800});">
            <div class="xp-modal-body">
                <div class="xp-fg">
                    <label>Plan</label>
                    <input type="text" id="demoPlanName" readonly>
                </div>
                <div class="xp-fg">
                    <label>Price</label>
                    <input type="text" id="demoPlanPrice" readonly>
                </div>
                <div class="xp-fg">
                    <label>Billing Email</label>
                    <input type="email" placeholder="billing@example.com">
                </div>
            </div>
            <div class="xp-modal-foot">
                <button type="button" class="xp-btn-cancel" onclick="xpClose('demoPlanModal')">Cancel</button>
                <button type="submit" class="xp-btn-save">Confirm</button>
            </div>
        </form>
    </div>
</div>

<script>
function demoSelectPlan(name, price) {
    document.getElementById('demoPlanName').value = name;
    document.getElementById('demoPlanPrice').value = price;
    xpOpen('demoPlanModal');
}
</script>
@endsection
