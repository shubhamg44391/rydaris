@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2>Maintenance Schedules</h2>
        </div>

        <div>
            <button type="button" onclick="openAddScheduleModal()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add Maintenance Schedule
            </button>
        </div>
    </div>

    <div class="panel-body admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Vehicle Name & Plate</th>
                    <th>Distance (Km)</th>
                    <th>Engine Hours (Hrs)</th>
                    <th>Next Due Date</th>
                    <th>Schedule Status / Alert</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody id="schTableBody">
                @forelse($schedules as $index => $sch)
                    <tr class="sch-row">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div><strong>[{{ $sch->vehicle->code ?? 'VEH-'.$sch->vehicle_id }}] {{ $sch->vehicle->name ?? 'Vehicle' }}</strong></div>
                            <small class="panel-muted">{{ $sch->checklist_summary }}</small>
                        </td>
                        <td><strong>{{ $sch->target_km }} Km</strong></td>
                        <td><strong>{{ $sch->engine_hours }} Hrs</strong></td>
                        <td><strong style="color: #0284c7;">{{ $sch->next_due_date }}</strong></td>
                        <td>
                            @if($sch->next_due_date && $sch->next_due_date < date('Y-m-d'))
                                <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">🔴 OVERDUE ALERT ⚠️</span>
                            @else
                                <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">🟢 On Schedule</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 8px;">
                                <a href="{{ route('vendor.maintenance-requests.index') }}?openModal=1&vehicle_id={{ $sch->vehicle_id }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.78rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    + Generate Request
                                </a>
                                <button type="button" onclick="openAddScheduleModal({{ $sch->vehicle_id }}, '{{ $sch->target_km }}', '{{ $sch->engine_hours }}', '{{ $sch->next_due_date ? \Carbon\Carbon::parse($sch->next_due_date)->format('Y-m-d') : '' }}', '{{ addslashes($sch->checklist_summary) }}', {{ $sch->id }})" title="Edit Schedule" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: none; border-radius: 9px; color: #1e293b; background: #ffffff; box-shadow: 0 1px 4px rgba(0,0,0,0.15); cursor: pointer; transition: all 0.2s ease;">
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="emptySchRow">
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--muted, #64748b);">
                            No maintenance schedules configured. Click <strong>"Add Maintenance Schedule"</strong> to create one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add Maintenance Schedule -->
<div id="addScheduleModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(5, 7, 17, 0.75); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 24px;">
    <div style="background: var(--panel, #ffffff); border: 1px solid rgba(0,0,0,0.15); border-radius: 20px; width: 100%; max-width: 720px; padding: 32px; box-shadow: 0 25px 70px rgba(0,0,0,0.35);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 16px;">
            <div>
                <h3 id="schModalTitle" style="margin: 0; font-size: 1.35rem; font-weight: 700;">Add Maintenance Schedule</h3>
            </div>
            <button onclick="closeAddScheduleModal()" style="background: none; border: none; font-size: 1.8rem; line-height: 1; cursor: pointer; color: var(--muted, #64748b);">&times;</button>
        </div>

        <form id="schForm" onsubmit="handleAddScheduleSubmit(event)">
            @csrf
            <input type="hidden" name="schedule_id" id="schEditId" value="">
            <!-- Vehicle Selection -->
            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px;">Select Vehicle <span style="color: #ef4444;">*</span></label>
                <select id="schVehicle" name="vehicle_id" required class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem;">
                    <option value="">-- Select Vehicle --</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}">
                            [{{ $v->code ?? ('VEH-'.$v->id) }}] {{ $v->name }} ({{ $v->reg_number ?? 'REG' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.88rem; font-weight: 700; margin-bottom: 8px;">Target Km (Kilometers) <span style="color: #ef4444;">*</span></label>
                    <input type="number" id="schKm" name="target_km" min="100" placeholder="e.g. 10000" required class="form-control" style="width: 100%; padding: 12px 14px; font-size: 0.95rem;">
                </div>

                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.88rem; font-weight: 700; margin-bottom: 8px;">Engine Hours (Hrs) <span style="color: #ef4444;">*</span></label>
                    <input type="number" id="schLimit" name="engine_hours" min="1" placeholder="e.g. 500" required class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem;">
                </div>

                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.88rem; font-weight: 700; margin-bottom: 8px;">Expected Due Date <span style="color: #ef4444;">*</span></label>
                    <input type="date" id="schNextDue" name="next_due_date" required class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px;">Maintenance Checklist Summary <span style="color: #ef4444;">*</span></label>
                <input type="text" id="schChecklist" name="checklist_summary" placeholder="e.g. Synthetic Oil Change, Air Filter & Brake Inspection" required class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 14px;">
                <button type="button" onclick="closeAddScheduleModal()" class="btn btn-secondary" style="padding: 12px 24px; font-weight: 600; font-size: 0.95rem;">Cancel</button>
                <button type="submit" id="schSubmitBtn" class="btn btn-primary" style="padding: 12px 28px; font-weight: 700; font-size: 0.95rem;">Save Schedule</button>
            </div>
        </form>
    </div>
</div>

<script>
let schCounter = {{ count($schedules) }};

function openAddScheduleModal(vehicleId, targetKm, engineHours, nextDueDate, checklistSummary, editId) {
    document.getElementById('addScheduleModal').style.display = 'flex';

    const editInput = document.getElementById('schEditId');
    const titleEl = document.getElementById('schModalTitle');
    const btnEl = document.getElementById('schSubmitBtn');

    if (editId) {
        if (editInput) editInput.value = editId;
        if (titleEl) titleEl.innerText = 'Update Maintenance Schedule';
        if (btnEl) btnEl.innerText = 'Update Schedule';
    } else {
        const form = document.getElementById('schForm');
        if (form) form.reset();
        if (editInput) editInput.value = '';
        if (titleEl) titleEl.innerText = 'Add Maintenance Schedule';
        if (btnEl) btnEl.innerText = 'Save Schedule';
    }

    if (vehicleId) {
        const select = document.getElementById('schVehicle');
        if (select) {
            select.value = vehicleId;
            if (select.selectedIndex <= 0) {
                for (let i = 0; i < select.options.length; i++) {
                    const optVal = String(select.options[i].value);
                    const optTxt = select.options[i].text.toLowerCase();
                    if (optVal === String(vehicleId) || optTxt.includes(String(vehicleId).toLowerCase())) {
                        select.selectedIndex = i;
                        break;
                    }
                }
            }
        }
    }

    if (targetKm && document.getElementById('schKm')) document.getElementById('schKm').value = targetKm;
    if (engineHours && document.getElementById('schLimit')) document.getElementById('schLimit').value = engineHours;
    if (nextDueDate && document.getElementById('schNextDue')) {
        document.getElementById('schNextDue').value = nextDueDate;
    } else if (document.getElementById('schNextDue') && !editId) {
        document.getElementById('schNextDue').value = new Date().toISOString().split('T')[0];
    }
    if (checklistSummary && document.getElementById('schChecklist')) document.getElementById('schChecklist').value = checklistSummary;
}

function closeAddScheduleModal() {
    document.getElementById('addScheduleModal').style.display = 'none';
    document.getElementById('schForm').reset();
    if (document.getElementById('schEditId')) document.getElementById('schEditId').value = '';
}

function handleAddScheduleSubmit(e) {
    e.preventDefault();
    const btn = document.getElementById('schSubmitBtn');
    btn.disabled = true;
    btn.innerText = 'Saving to Database...';

    const formData = new FormData(document.getElementById('schForm'));

    fetch("{{ route('vendor.maintenance-schedules.store') }}", {
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
        btn.innerText = 'Save Schedule';

        if (res.success) {
            document.getElementById('addScheduleModal').style.display = 'none';
            closeAddScheduleModal();
            Swal.fire({
                icon: 'success',
                title: res.is_update ? 'Schedule Updated!' : 'Stored in Database!',
                text: res.message || 'Maintenance Schedule saved successfully.',
                timer: 1200,
                showConfirmButton: false
            }).then(() => {
                window.location.href = window.location.pathname;
            });
        } else {
            Swal.fire('Error', res.message || 'Failed to save schedule.', 'error');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerText = 'Save Schedule';
        console.error(err);
        Swal.fire('Error', 'Database connection error.', 'error');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const vId = urlParams.get('vehicle_id') || urlParams.get('vehicle');
    if (urlParams.get('openModal') === '1' || vId) {
        openAddScheduleModal(vId);
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
</script>
@endsection
