@extends('admin.layouts.app')

@section('title', 'Rules Management')

@section('main-content')

<style>
/* Retain modal styles but remove custom table styles */
.xp-overlay      { display:none; position:fixed; inset:0; background:rgba(5, 7, 17, 0.85); backdrop-filter: blur(8px); z-index:2000; align-items:center; justify-content:center; }
.xp-overlay.open { display:flex; }
.xp-modal        { background:#0b1020; border: 1px solid rgba(82, 234, 210, 0.25); border-radius:16px; width:480px; max-width:95vw; max-height:90vh; overflow-y:auto; box-shadow:0 12px 40px rgba(0, 0, 0, 0.5); }
.xp-modal-head   { display:flex; justify-content:space-between; align-items:center; padding:16px 22px; border-bottom:1px solid rgba(255,255,255,0.05); }
.xp-modal-title  { font-weight:700; font-size:1.05rem; color:#f8fafc; }
.xp-modal-x      { background:none; border:none; font-size:1.4rem; cursor:pointer; color:#cbd5e1; line-height:1; }
.xp-modal-body   { padding:20px 22px; }
.xp-modal-foot   { display:flex; justify-content:flex-end; gap:10px; padding:14px 22px; border-top:1px solid rgba(255,255,255,0.05); }

.xp-modal .xp-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
.xp-modal .xp-fg  { margin-bottom:14px; }
.xp-modal .xp-fg label { display:block !important; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px; gap:0 !important; }
.xp-modal .xp-fg input,
.xp-modal .xp-fg select {
    width:100%; padding:12px !important; min-height:unset !important;
    border:1px solid rgba(255, 255, 255, 0.15) !important; border-radius:8px !important;
    font-size:.88rem !important; color:#fff; outline:none; box-sizing:border-box; background:rgba(255, 255, 255, 0.05) !important;
}
.xp-modal .xp-fg select option {
    background-color: #0b1020 !important;
    color: #f8fafc !important;
}
.xp-modal .xp-fg input:focus,
.xp-modal .xp-fg select:focus { border-color:var(--brand, #52ead2) !important; box-shadow: 0 0 0 3px rgba(82, 234, 210, 0.15) !important; outline:none !important; }

.xp-btn-cancel { background:rgba(255, 255, 255, 0.05); border:1px solid rgba(255, 255, 255, 0.15); color:#cbd5e1; padding:10px 20px; border-radius:8px; cursor:pointer; font-size:.88rem; transition: all 0.2s; }
.xp-btn-cancel:hover { background:rgba(255, 255, 255, 0.1); }
.xp-btn-save   { background:var(--brand, #52ead2) !important; color:#050711 !important; border:none; padding:10px 20px; border-radius:8px; cursor:pointer; font-size:.88rem; font-weight:700 !important; box-shadow:0 8px 16px rgba(82, 234, 210, 0.2); transition: all 0.2s; }
.xp-btn-save:hover { background:#2bc2a8 !important; box-shadow:0 8px 20px rgba(82, 234, 210, 0.3); }
</style>

<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2>Rules Management</h2>
        </div>
        <div>
            <button class="btn btn-primary" onclick="xpOpen('xpAddModal')" style="display: inline-flex; align-items: center; gap: 4px;">
                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add New Rule
            </button>
        </div>
    </div>
    <div class="panel-body admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Driver Age</th>
                    <th>Charges</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rules as $i => $rule)
                <tr data-min="{{ $rule->min_age }}" data-max="{{ $rule->max_age }}" data-charge="{{ $rule->underage_charge }}">
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $rule->min_age }} – {{ $rule->max_age }} yrs</td>
                    <td style="color: #dc2626; font-weight: 600;">${{ number_format($rule->underage_charge, 2) }}</td>
                    <td>
                        @if($rule->status)
                            <span class="badge" style="background: #dcfce7; color: #067647; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem; cursor: pointer;" onclick="xpToggleRule({{ $rule->id }}, this)">Active</span>
                        @else
                            <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem; cursor: pointer;" onclick="xpToggleRule({{ $rule->id }}, this)">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $rule->updated_at->format('d M Y g:i A') }}</td>
                    <td>
                        <div class="table-actions" style="display: flex; gap: 8px;">
                            <button class="icon-button" title="View" onclick="xpView({{ $rule->min_age }}, {{ $rule->max_age }}, '{{ $rule->underage_charge }}')" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #0ea5e9; background: #ffffff; cursor: pointer; padding: 0;">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <button class="icon-button" title="Edit" onclick="xpEdit({{ $rule->id }}, {{ $rule->min_age }}, {{ $rule->max_age }}, '{{ $rule->underage_charge }}', {{ $rule->status ? 1 : 0 }})" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #0f766e; background: #ffffff; cursor: pointer; padding: 0;">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                            </button>
                            <button class="icon-button delete-btn" title="Delete" onclick="xpDelete({{ $rule->id }})" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #fee2e2; border-radius: var(--radius); color: #ef4444; background: #ffffff; cursor: pointer; padding: 0;">
                                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4" style="text-align: center; padding: 20px;">
                        No rules found. Click <strong>Add New Rule</strong> to get started.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Rule Modal --}}
<div id="xpAddModal" class="xp-overlay">
    <div class="xp-modal">
        <div class="xp-modal-head">
            <span class="xp-modal-title">Add New Rule</span>
            <button class="xp-modal-x" onclick="xpClose('xpAddModal')">&times;</button>
        </div>
        <form id="xpAddForm" onsubmit="xpSave(event)">
            @csrf
            <div class="xp-modal-body">
                <div class="xp-row">
                    <div class="xp-fg">
                        <label>Min Age</label>
                        <input type="number" name="min_age" min="0" required placeholder="e.g. 18">
                    </div>
                    <div class="xp-fg">
                        <label>Max Age</label>
                        <input type="number" name="max_age" min="0" required placeholder="e.g. 25">
                    </div>
                </div>
                <div class="xp-fg">
                    <label>Charges</label>
                    <input type="number" step="0.01" min="0" name="underage_charge" required placeholder="e.g. 10.00">
                </div>
                <div class="xp-fg">
                    <label>Status</label>
                    <select name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="xp-modal-foot">
                <button type="button" class="xp-btn-cancel" onclick="xpClose('xpAddModal')">Cancel</button>
                <button type="submit" class="xp-btn-save" style="background: #22c55e;">Add Rule</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Rule Modal --}}
<div id="xpEditModal" class="xp-overlay">
    <div class="xp-modal">
        <div class="xp-modal-head">
            <span class="xp-modal-title">Edit Rule</span>
            <button class="xp-modal-x" onclick="xpClose('xpEditModal')">&times;</button>
        </div>
        <form id="xpEditForm" onsubmit="xpUpdate(event)">
            @csrf
            <div class="xp-modal-body">
                <div class="xp-row">
                    <div class="xp-fg">
                        <label>Min Age</label>
                        <input type="number" name="min_age" id="xe_min" min="0" required>
                    </div>
                    <div class="xp-fg">
                        <label>Max Age</label>
                        <input type="number" name="max_age" id="xe_max" min="0" required>
                    </div>
                </div>
                <div class="xp-fg">
                    <label>Charges</label>
                    <input type="number" step="0.01" min="0" name="underage_charge" id="xe_charge" required>
                </div>
                <div class="xp-fg">
                    <label>Status</label>
                    <select name="status" id="xe_status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="xp-modal-foot">
                <button type="button" class="xp-btn-cancel" onclick="xpClose('xpEditModal')">Cancel</button>
                <button type="submit" class="xp-btn-save" style="background: #22c55e;">Update Rule</button>
            </div>
        </form>
    </div>
</div>

{{-- View Modal --}}
<div id="xpViewModal" class="xp-overlay">
    <div class="xp-modal" style="width:420px;">
        <div class="xp-modal-head">
            <span class="xp-modal-title">Rule Details</span>
            <button class="xp-modal-x" onclick="xpClose('xpViewModal')">&times;</button>
        </div>
        <div class="xp-modal-body" id="xpViewContent"></div>
        <div class="xp-modal-foot">
            <button type="button" class="xp-btn-cancel" onclick="xpClose('xpViewModal')">Close</button>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
let xpEditId = null;
function xpOpen(id){ document.getElementById(id).classList.add('open'); }
function xpClose(id){ document.getElementById(id).classList.remove('open'); }

function xpSave(e) {
    e.preventDefault();
    fetch('{{ route("vendor.rules.store") }}', {method:'POST', body:new FormData(e.target), headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(d=>{ 
        if(d.status==='success') {
            xpClose('xpAddModal');
            Swal.fire('Added!','Rule saved.','success').then(()=>location.reload()); 
        }
    });
}

function xpEdit(id, min, max, charge, status) {
    xpEditId = id;
    document.getElementById('xe_min').value    = min;
    document.getElementById('xe_max').value    = max;
    document.getElementById('xe_charge').value = charge;
    document.getElementById('xe_status').value = status;
    xpOpen('xpEditModal');
}

function xpUpdate(e) {
    e.preventDefault();
    fetch(`{{ url('vendor/rules') }}/${xpEditId}`, {method:'POST', body:new FormData(e.target), headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(d=>{ 
        if(d.status==='success') {
            xpClose('xpEditModal');
            Swal.fire('Updated!','Rule updated.','success').then(()=>location.reload()); 
        }
    });
}

function xpToggleRule(id, el) {
    const cur = el.innerText === 'Active' ? 1 : 0;
    const nw  = cur === 1 ? 0 : 1;
    const row = el.closest('tr');
    const fd  = new FormData();
    fd.append('_token','{{ csrf_token() }}');
    fd.append('status', nw);
    fd.append('min_age', row.dataset.min);
    fd.append('max_age', row.dataset.max);
    fd.append('underage_charge', row.dataset.charge);
    fetch(`{{ url('vendor/rules') }}/${id}`, {method:'POST', body:fd, headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(d=>{ 
        if(d.status==='success'){ 
            el.style.background = nw ? '#dcfce7' : '#f1f5f9';
            el.style.color = nw ? '#067647' : '#64748b';
            el.innerText = nw ? 'Active' : 'Inactive'; 
        } 
    });
}

function xpDelete(id) {
    Swal.fire({title:'Delete rule?',icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',confirmButtonText:'Delete'})
    .then(r=>{ if(r.isConfirmed){ fetch(`{{ url('vendor/rules') }}/${id}`,{method:'DELETE',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}}).then(r=>r.json()).then(d=>{ if(d.status==='success') Swal.fire('Deleted!','','success').then(()=>location.reload()); }); } });
}

function xpView(min, max, charge) {
    document.getElementById('xpViewContent').innerHTML = `
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
            <div style="width:50px;height:50px;border-radius:10px;background:rgba(82, 234, 210, 0.1);display:flex;align-items:center;justify-content:center;color:var(--brand, #52ead2);flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
            </div>
            <div><div style="font-size:1.05rem;font-weight:700;color:#f8fafc;">Age ${min} – ${max} Years</div><div style="color:#a8b3c5;font-size:.83rem;">Driver Age Rule</div></div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
            <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);padding:14px;border-radius:8px;text-align:center;">
                <div style="font-size:.7rem;color:#94a3b8;font-weight:700;text-transform:uppercase;margin-bottom:3px;">Min Age</div>
                <div style="font-size:1.4rem;font-weight:700;color:#f8fafc;">${min}</div>
            </div>
            <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);padding:14px;border-radius:8px;text-align:center;">
                <div style="font-size:.7rem;color:#94a3b8;font-weight:700;text-transform:uppercase;margin-bottom:3px;">Max Age</div>
                <div style="font-size:1.4rem;font-weight:700;color:#f8fafc;">${max}</div>
            </div>
            <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);padding:14px;border-radius:8px;text-align:center;">
                <div style="font-size:.7rem;color:#f87171;font-weight:700;text-transform:uppercase;margin-bottom:3px;">Charge</div>
                <div style="font-size:1.4rem;font-weight:700;color:#ef4444;">$${charge}</div>
            </div>
        </div>
    `;
    xpOpen('xpViewModal');
}

document.querySelectorAll('.xp-overlay').forEach(o=>{ o.addEventListener('click',e=>{ if(e.target===o) o.classList.remove('open'); }); });
</script>
@endsection
