@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2>Generate Maintenance Requests</h2>
        </div>

        <div>
            <button type="button" onclick="openAddReqModal()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Generate Request
            </button>
        </div>
    </div>

    <div class="panel-body admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Vehicle Name & Plate</th>
                    <th>Interval Type</th>
                    <th>Service Checklist Tasks</th>
                    <th>Request Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody id="reqTableBody">
                @forelse($requests as $req)
                    <tr class="req-row">
                        <td><strong style="color: var(--brand, #0284c7);">{{ $req->request_number }}</strong></td>
                        <td>
                            <div><strong>[{{ $req->vehicle->code ?? 'VEH-'.$req->vehicle_id }}] {{ $req->vehicle->name ?? 'Vehicle' }}</strong></div>
                            <small class="panel-muted">Priority: {{ $req->priority }}</small>
                        </td>
                        <td><strong>{{ $req->interval_type }}</strong></td>
                        <td style="max-width: 300px;">
                            @if(is_array($req->checklist_tasks))
                                @foreach($req->checklist_tasks as $t)
                                    <span style="display:inline-block; background:rgba(2, 132, 199, 0.08); border:1px solid rgba(2, 132, 199, 0.2); border-radius:4px; padding:2px 8px; font-size:0.75rem; margin:2px;">☑ {{ $t }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if($req->status === 'completed')
                                <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">
                                     COMPLETED
                                </span>
                            @elseif($req->status === 'converted' || $req->status === 'in_progress')
                                <span class="badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">
                                     WORK ORDER CREATED
                                </span>
                            @else
                                <span class="badge" style="background: rgba(234, 179, 8, 0.12); color: #eab308; border: 1px solid rgba(234, 179, 8, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">
                                     PENDING
                                </span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            @if($req->status === 'completed')
                                <span style="font-size: 0.82rem; font-weight: 700; color: #10b981; background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 8px; padding: 6px 14px; display: inline-flex; align-items: center; gap: 4px;">
                                    ✓ Work Order Finished
                                </span>
                            @elseif($req->status === 'converted' || $req->status === 'in_progress')
                                <a href="{{ route('vendor.work-orders.index') }}" class="btn btn-secondary" style="padding: 6px 14px; font-size: 0.78rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    ⚙️ View Work Order
                                </a>
                            @else
                                @php
                                    $tasksArr = is_array($req->checklist_tasks) ? $req->checklist_tasks : [$req->checklist_tasks];
                                    $tasksJson = json_encode(array_values(array_filter($tasksArr)));
                                @endphp
                                <a href="{{ route('vendor.work-orders.index') }}?openModal=1&vehicle_id={{ $req->vehicle_id }}&tasks={{ urlencode($tasksJson) }}" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.78rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    + Create Work Order
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr id="emptyReqRow">
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--muted, #64748b);">
                            No maintenance requests found. Click <strong>"Generate Request"</strong> to create one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Generate Maintenance Request -->
<div id="addReqModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(5, 7, 17, 0.75); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 24px;">
    <div style="background: var(--panel, #ffffff); border: 1px solid rgba(0,0,0,0.15); border-radius: 20px; width: 100%; max-width: 720px; padding: 32px; box-shadow: 0 25px 70px rgba(0,0,0,0.35); max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 14px;">
            <h3 style="margin: 0; font-size: 1.35rem; font-weight: 700;">Generate Maintenance Request Ticket</h3>
            <button onclick="closeAddReqModal()" style="background: none; border: none; font-size: 1.8rem; line-height: 1; cursor: pointer; color: var(--muted, #64748b);">&times;</button>
        </div>

        <form id="reqForm" onsubmit="handleAddReqSubmit(event)">
            @csrf
            <input type="hidden" name="request_id" id="reqEditId" value="">
            <!-- Vehicle Selection -->
            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px; text-transform: uppercase;">SELECT VEHICLE <span style="color: #ef4444;">*</span></label>
                
                <div id="vehicleReadonlyWrap" style="display: none;">
                    <input type="text" id="reqVehicleReadonlyInput" readonly class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem; background: rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.15); border-radius: 12px; font-weight: 600; cursor: not-allowed; color: inherit;" value="">
                    <input type="hidden" id="reqVehicleHiddenInput" name="vehicle_id" value="" disabled>
                </div>

                <div id="vehicleSelectWrap">
                    <select id="reqVehicleSelect" required class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem; border-radius: 12px;" onchange="handleVehicleSelectChange(this)">
                        <option value="">-- Select Vehicle --</option>
                        @foreach($vehicles as $v)
                            @php
                                $vLabel = '[' . ($v->code ?? ('VEH-'.$v->id)) . '] ' . $v->name . ' (' . ($v->reg_number ?? 'REG') . ')';
                            @endphp
                            <option value="{{ $v->id }}" data-label="{{ $vLabel }}">
                                {{ $vLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Priority Level -->
            <input type="hidden" name="interval_type" id="reqType" value="Engine Hours">
            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px;">Priority Level</label>
                <select id="reqPriority" name="priority" class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem; border-radius: 12px;">
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Low">Low</option>
                    <option value="Emergency">Emergency</option>
                </select>
            </div>

            <!-- Assigned Workshop / Mechanic & Vehicle Rental Status -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 20px;">
                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px; text-transform: uppercase;">Assigned Workshop / Mechanic <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="reqMechanic" name="mechanic_workshop" placeholder="e.g. Ramesh Repair Services" required class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem; border-radius: 12px;">
                </div>
                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px; text-transform: uppercase;">Vehicle Rental Status <span style="color: #ef4444;">*</span></label>
                    <select id="reqVehicleStatus" name="vehicle_status" required class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem; border-radius: 12px;">
                        <option value="In Maintenance">In Maintenance</option>
                        <option value="Available">Available</option>
                    </select>
                </div>
            </div>

            <!-- Service Checkboxes (Button-Style Cards) -->
            <div style="margin-bottom: 20px; background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.08); border-radius: 14px; padding: 18px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid rgba(0,0,0,0.08); padding-bottom: 10px;">
                    <label style="font-size: 0.9rem; font-weight: 700; margin: 0; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;">
                        <span>Service Checklist Tasks</span> <span style="color: #ef4444;">*</span>
                    </label>
                    <label class="chk-btn-card" style="padding: 6px 12px; font-size: 0.82rem; margin: 0;">
                        <input type="checkbox" id="chkSelectAll" onchange="toggleSelectAllReqTasks(this)">
                        Select All
                    </label>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <label class="chk-btn-card">
                        <input type="checkbox" name="checklist_tasks[]" class="req-chk-item" value="Engine Oil & Filter Replace" checked> Engine Oil & Filter Replace
                    </label>
                    <label class="chk-btn-card">
                        <input type="checkbox" name="checklist_tasks[]" class="req-chk-item" value="Brake Pad & Disc Wear Check" checked> Brake Pad & Disc Wear Check
                    </label>
                    <label class="chk-btn-card">
                        <input type="checkbox" name="checklist_tasks[]" class="req-chk-item" value="Tire Rotation & Alignment"> Tire Rotation & Alignment
                    </label>
                    <label class="chk-btn-card">
                        <input type="checkbox" name="checklist_tasks[]" class="req-chk-item" value="Battery & Electrical Systems"> Battery & Electrical Systems
                    </label>
                    <label class="chk-btn-card">
                        <input type="checkbox" name="checklist_tasks[]" class="req-chk-item" value="AC Air Filter Refresh"> AC Air Filter Refresh
                    </label>
                    <label class="chk-btn-card">
                        <input type="checkbox" name="checklist_tasks[]" class="req-chk-item" value="Full Safety Inspection"> Full Safety Inspection
                    </label>
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px;">Additional Service Notes</label>
                <textarea id="reqNotes" name="notes" rows="2" placeholder="Optional notes for mechanic..." class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem; border-radius: 12px;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 14px;">
                <button type="button" onclick="closeAddReqModal()" class="btn btn-secondary" style="padding: 12px 24px; font-weight: 600; font-size: 0.95rem; border-radius: 10px;">Cancel</button>
                <button type="submit" id="reqSubmitBtn" class="btn btn-primary" style="padding: 12px 28px; font-weight: 700; font-size: 0.95rem; border-radius: 10px;">Submit Ticket Request</button>
            </div>
        </form>
    </div>
</div>

<script>
function setVehicleReadonlyState(val, label) {
    const readonlyWrap = document.getElementById('vehicleReadonlyWrap');
    const readonlyInput = document.getElementById('reqVehicleReadonlyInput');
    const hiddenInput = document.getElementById('reqVehicleHiddenInput');
    const selectWrap = document.getElementById('vehicleSelectWrap');
    const selectElem = document.getElementById('reqVehicleSelect');

    if (val && val !== '') {
        readonlyInput.value = label;
        hiddenInput.value = val;
        hiddenInput.disabled = false;
        selectElem.disabled = true;

        readonlyWrap.style.display = 'block';
        selectWrap.style.display = 'none';
    } else {
        readonlyInput.value = '';
        hiddenInput.value = '';
        hiddenInput.disabled = true;
        selectElem.disabled = false;

        readonlyWrap.style.display = 'none';
        selectWrap.style.display = 'block';
    }
}

function handleVehicleSelectChange(select) {
    if (select.value) {
        const label = select.options[select.selectedIndex].text;
        setVehicleReadonlyState(select.value, label);
    }
}

function openAddReqModal(vehicleId, isEdit = false) {
    if (!isEdit) {
        const form = document.getElementById('reqForm');
        if (form) form.reset();
        if (document.getElementById('reqEditId')) document.getElementById('reqEditId').value = '';
    }
    document.getElementById('addReqModal').style.display = 'flex';

    const selectElem = document.getElementById('reqVehicleSelect');

    if (vehicleId) {
        let foundVal = '';
        let foundLabel = '';
        if (selectElem) {
            for (let i = 0; i < selectElem.options.length; i++) {
                const optVal = String(selectElem.options[i].value);
                const optTxt = selectElem.options[i].text;
                if (optVal === String(vehicleId) || optTxt.toLowerCase().includes(String(vehicleId).toLowerCase())) {
                    foundVal = selectElem.options[i].value;
                    foundLabel = optTxt;
                    selectElem.selectedIndex = i;
                    break;
                }
            }
        }
        if (foundVal) {
            setVehicleReadonlyState(foundVal, foundLabel);
        } else {
            setVehicleReadonlyState('', '');
        }
    } else {
        setVehicleReadonlyState('', '');
    }
}
function closeAddReqModal() {
    document.getElementById('addReqModal').style.display = 'none';
    document.getElementById('reqForm').reset();
    if (document.getElementById('reqEditId')) document.getElementById('reqEditId').value = '';
    setVehicleReadonlyState('', '');
}

function toggleSelectAllReqTasks(master) {
    document.querySelectorAll('.req-chk-item').forEach(chk => chk.checked = master.checked);
}

function handleAddReqSubmit(e) {
    e.preventDefault();
    const btn = document.getElementById('reqSubmitBtn');
    btn.disabled = true;
    btn.innerText = 'Saving Ticket to Database...';

    const formData = new FormData(document.getElementById('reqForm'));

    fetch("{{ route('vendor.maintenance-requests.store') }}", {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        btn.disabled = false;
        btn.innerText = 'Submit Ticket Request';

        if (res.success) {
            document.getElementById('addReqModal').style.display = 'none';
            closeAddReqModal();
            Swal.fire({
                icon: 'success',
                title: res.is_update ? 'Request Ticket Updated!' : 'Stored in Database!',
                text: res.message || 'Maintenance Request saved successfully.',
                timer: 1200,
                showConfirmButton: false
            }).then(() => {
                window.location.href = window.location.pathname;
            });
        } else {
            Swal.fire('Error', res.message || 'Failed to save request.', 'error');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerText = 'Submit Ticket Request';
        console.error(err);
        Swal.fire('Error', 'Database connection error.', 'error');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const vId = urlParams.get('vehicle_id') || urlParams.get('vehicle');
    if (urlParams.get('openModal') === '1' || vId) {
        openAddReqModal(vId);
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
</script>
@endsection
