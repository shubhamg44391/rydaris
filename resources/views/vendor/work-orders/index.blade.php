@extends('admin.layouts.app')

@section('main-content')
<style>
.swal2-container.swal2-center {
    align-items: center !important;
    justify-content: center !important;
    padding: 20px !important;
}
.swal2-popup.swal-centered-record-modal {
    max-height: 82vh !important;
    margin: auto !important;
    padding: 20px 24px !important;
    border-radius: 18px !important;
    top: 0 !important;
    bottom: 0 !important;
}
.swal-centered-record-modal .swal2-title {
    font-size: 1.2rem !important;
    margin: 0 0 12px 0 !important;
    padding: 0 !important;
}
.swal-centered-record-modal .swal2-html-container {
    margin: 0 !important;
    padding: 0 !important;
}
</style>
<div class="admin-panel">
    <div class="panel-head d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2>Vendor Work Orders & Service History Log</h2>
        </div>

        <div>
            <button type="button" onclick="openAddWoModal()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Create Work Order
            </button>
        </div>
    </div>

    <!-- Tabs: Active Work Orders vs Complete Service History -->
    <div style="display: flex; gap: 12px; margin-bottom: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 10px; margin-left: 10px;">
        <button type="button" id="tabActiveBtn" onclick="switchWoTab('active')"
            style="padding: 10px 20px; font-weight: 700; font-size: 0.9rem; border-radius: 8px; border: none; cursor: pointer;
                   background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%); color: #061218;">
            Active Work Orders
        </button>
        <button type="button" id="tabHistoryBtn" onclick="switchWoTab('history')"
            style="padding: 10px 20px; font-weight: 700; font-size: 0.9rem; border-radius: 8px; cursor: pointer;
                   background: transparent; color: var(--text, #1e293b); border: 1px solid rgba(0,0,0,0.15);">
            Complete Service History Log
        </button>
    </div>

    <!-- TAB 1: Active Work Orders -->
    <div id="tabActiveContent" class="panel-body admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Work Order #</th>
                    <th>Vehicle & Plate</th>
                    <th>Assigned Workshop</th>
                    <th>Vehicle Status</th>
                    <th>Checklist Progress</th>
                    <th>Incident Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody id="woTableBody">
                @php $activeCount = 0; @endphp
                @foreach($workOrders as $wo)
                    @if($wo->status !== 'completed')
                        @php $activeCount++; @endphp
                        <tr class="wo-row">
                            <td><strong style="color: #8b5cf6;">{{ $wo->work_order_number }}</strong></td>
                            <td>
                                <div><strong>[{{ $wo->vehicle->code ?? 'VEH-'.$wo->vehicle_id }}] {{ $wo->vehicle->name ?? 'Vehicle' }}</strong></div>
                                <small class="panel-muted">Logged on {{ $wo->created_at->format('d M Y') }}</small>
                            </td>
                            <td>
                                <div><strong>{{ $wo->mechanic_workshop }}</strong></div>
                                <small class="panel-muted">Assigned Workshop</small>
                            </td>
                            <td>
                                @if($wo->vehicle_status === 'In Maintenance')
                                    <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;"><span style="width:6px; height:6px; border-radius:50%; background:#ef4444;"></span> In Maintenance</span>
                                @else
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;"><span style="width:6px; height:6px; border-radius:50%; background:#10b981;"></span> Available</span>
                                @endif
                            </td>
                            <td style="min-width: 150px;">
                                <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: 700; margin-bottom: 4px;">
                                    <span>Completed</span>
                                    <span>{{ $wo->progress_percentage }}%</span>
                                </div>
                                <div style="width: 100%; height: 6px; background: rgba(0,0,0,0.1); border-radius: 999px; overflow: hidden;">
                                    <div style="width: {{ $wo->progress_percentage }}%; height: 100%; background: linear-gradient(90deg, var(--brand, #0284c7), #10b981); border-radius: 999px;"></div>
                                </div>
                            </td>
                            <td>
                                @if($wo->incident_flag === 'Incident Flagged')
                                    <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">⚠️ Incident Flagged</span>
                                @else
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.08); color: #64748b; border: 1px solid rgba(0,0,0,0.1); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 600;">Normal</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <button type="button" 
                                        onclick="openEditWoModalFromBtn(this)" 
                                        data-vehicle="{{ $wo->vehicle_id }}"
                                        data-tasks="{{ json_encode($wo->checklist_completed ?? []) }}"
                                        data-all-tasks="{{ json_encode($wo->checklist_tasks ?? []) }}"
                                        data-mechanic="{{ $wo->mechanic_workshop }}"
                                        data-status="{{ $wo->vehicle_status }}"
                                        data-incident="{{ $wo->incident_flag }}"
                                        data-id="{{ $wo->id }}"
                                        title="Edit Work Order" 
                                        style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: none; border-radius: 9px; color: #1e293b; background: #ffffff; box-shadow: 0 1px 4px rgba(0,0,0,0.15); cursor: pointer; transition: all 0.2s ease;">
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @endif
                @endforeach

                @if($activeCount === 0)
                    <tr id="emptyWoRow">
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--muted, #64748b);">
                            No active work orders found. Click <strong>"Create Work Order"</strong> to start one.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- TAB 2: Complete Service History Log -->
    <div id="tabHistoryContent" class="panel-body admin-table-wrap" style="display: none;">
       

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Work Order #</th>
                    <th>Vehicle Name & Plate</th>
                    <th>Completion Date & Time</th>
                    <th>Serviced By (Workshop)</th>
                    <th>Service Checklist Tasks</th>
                    <th>Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody id="historyTableBody">
                @foreach($workOrders as $wo)
                    @php
                        $completedList = is_array($wo->checklist_completed) ? $wo->checklist_completed : (json_decode($wo->checklist_completed, true) ?? []);
                    @endphp
                    @if($wo->status === 'completed' || count($completedList) > 0 || $wo->progress_percentage > 0)
                        <tr class="wo-hist-row">
                            <td><strong style="color: #8b5cf6;">{{ $wo->work_order_number }}</strong></td>
                            <td>
                                <div><strong>[{{ $wo->vehicle->code ?? 'VEH-'.$wo->vehicle_id }}] {{ $wo->vehicle->name ?? 'Vehicle' }}</strong></div>
                                <small style="color: var(--brand, #0284c7); font-weight: 700;">{{ $wo->status === 'completed' ? 'Completed' : $wo->progress_percentage.'% Progress Logged' }}</small>
                            </td>
                            <td>
                                <div><strong>{{ $wo->updated_at ? $wo->updated_at->format('Y-m-d') : date('Y-m-d') }}</strong></div>
                                <small class="panel-muted">{{ $wo->updated_at ? $wo->updated_at->format('h:i A') : date('h:i A') }}</small>
                            </td>
                            <td>{{ $wo->mechanic_workshop }}</td>
                            <td style="max-width: 340px;">
                                @forelse($completedList as $item)
                                    @php
                                        $tName = is_array($item) ? ($item['task'] ?? '') : $item;
                                        $tTime = is_array($item) ? ($item['time'] ?? '') : ($wo->updated_at ? $wo->updated_at->format('Y-m-d H:i') : '');
                                    @endphp
                                    <span title="Completed at: {{ $tTime }}" style="display:inline-block; background:rgba(2, 132, 199, 0.08); border:1px solid rgba(2, 132, 199, 0.2); border-radius:6px; padding:4px 9px; font-size:0.75rem; margin:2px; font-weight: 600;">
                                        ☑ {{ $tName }}
                                        @if($tTime)
                                            <span style="font-size:0.68rem; color:#64748b; font-weight:400; display:block; margin-top:1px;">
                                                🕒 {{ $tTime }}
                                            </span>
                                        @endif
                                    </span>
                                @empty
                                    <span style="color: var(--muted, #64748b); font-size: 0.78rem;">No tasks selected</span>
                                @endforelse
                            </td>
                            <td>
                                @if($wo->status === 'completed')
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">
                                        🟢 Completed & Stored
                                    </span>
                                @else
                                    <span class="badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">
                                        ⚙️ {{ $wo->progress_percentage }}% Progress Log
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <button type="button" 
                                        onclick="openViewHistoryRecordFromBtn(this)" 
                                        data-number="{{ $wo->work_order_number }}"
                                        data-vehicle="{{ addslashes($wo->vehicle->name ?? 'Vehicle') }}{{ !empty($wo->vehicle->reg_number) ? ' ('.$wo->vehicle->reg_number.')' : '' }}"
                                        data-date="{{ $wo->updated_at ? $wo->updated_at->format('Y-m-d') : date('Y-m-d') }}"
                                        data-time="{{ $wo->updated_at ? $wo->updated_at->format('h:i A') : date('h:i A') }}"
                                        data-workshop="{{ addslashes($wo->mechanic_workshop) }}"
                                        data-tasks="{{ json_encode(array_values($completedList)) }}"
                                        title="View Record" 
                                        class="btn btn-secondary" 
                                        style="padding: 6px 14px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; border-radius: 8px;">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    View Record
                                </button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Create Vendor Work Order -->
<div id="addWoModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(5, 7, 17, 0.75); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 24px;">
    <div style="background: var(--panel, #ffffff); border: 1px solid rgba(0,0,0,0.15); border-radius: 20px; width: 100%; max-width: 740px; padding: 32px; box-shadow: 0 25px 70px rgba(0,0,0,0.35); max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 14px;">
            <div>
                <h3 style="margin: 0; font-size: 1.35rem; font-weight: 700;">Work Order</h3>
            </div>
            <button onclick="closeAddWoModal()" style="background: none; border: none; font-size: 1.8rem; line-height: 1; cursor: pointer; color: var(--muted, #64748b);">&times;</button>
        </div>

        <form id="woForm" onsubmit="handleAddWoSubmit(event)">
            @csrf
            <input type="hidden" name="work_order_id" id="woEditId" value="">
            <!-- Vehicle Selection -->
            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px;">Select Vehicle <span style="color: #ef4444;">*</span></label>
                <select id="woVehicle" name="vehicle_id" required class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem;">
                    <option value="">-- Select Vehicle --</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}">
                            [{{ $v->code ?? ('VEH-'.$v->id) }}] {{ $v->name }} ({{ $v->reg_number ?? 'REG' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 20px;">
                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px;">Assigned Workshop / Mechanic <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="woMechanic" name="mechanic_workshop" placeholder="e.g. Ramesh Repair Services" required class="form-control" readonly style="width: 100%; padding: 12px 16px; font-size: 0.95rem; cursor: not-allowed; background: rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.15); font-weight: 600;">
                </div>

                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px;">Vehicle Rental Status <span style="color: #ef4444;">*</span></label>
                    <select id="woStatus" name="vehicle_status" required class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem;">
                        <option value="In Maintenance">In Maintenance</option>
                        <option value="Available">Available</option>
                    </select>
                </div>
            </div>

            <!-- Mechanic Work Order Task Checkboxes (Button-Style Cards) -->
            <div style="margin-bottom: 20px; background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.08); border-radius: 14px; padding: 18px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid rgba(0,0,0,0.08); padding-bottom: 10px;">
                    <label style="font-size: 0.9rem; font-weight: 700; margin: 0;">Service Checklist Tasks</label>
                    <span id="woProgressDisplay" style="font-weight: 800; color: var(--brand, #0284c7); font-size: 0.9rem;">0% Completed</span>
                </div>

                <div id="woChecklistContainer" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                    <!-- Checkboxes rendered dynamically matching exact number of checklist tasks -->
                </div>
                <input type="hidden" name="progress_percentage" id="woProgressValue" value="0">
            </div>

            <!-- Incident Flag Option -->
            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 8px;">Incident / Problem Flag</label>
                <select id="woIncident" name="incident_flag" class="form-control" style="width: 100%; padding: 12px 16px; font-size: 0.95rem;">
                    <option value="No Incident">Normal (No Issues)</option>
                    <option value="Incident Flagged"> Mark Incident / Problem Encountered</option>
                </select>
            </div>

          

            <div style="display: flex; justify-content: flex-end; gap: 14px;">
                <button type="button" onclick="closeAddWoModal()" class="btn btn-secondary" style="padding: 12px 24px; font-weight: 600; font-size: 0.95rem;">Cancel</button>
                <button type="submit" id="woSubmitBtn" class="btn btn-primary" style="padding: 12px 28px; font-weight: 700; font-size: 0.95rem;">Save Work Order</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: View Service History Record -->
<div id="viewRecordModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(5, 7, 17, 0.75); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 24px;">
    <div style="background: var(--panel, #ffffff); border: 1px solid rgba(0,0,0,0.15); border-radius: 20px; width: 100%; max-width: 620px; padding: 28px 32px; box-shadow: 0 25px 70px rgba(0,0,0,0.35); max-height: 85vh; overflow-y: auto; margin: auto;">
        <!-- Modal Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 14px;">
            <div>
                <h3 style="margin: 0; font-size: 1.3rem; font-weight: 700; color: var(--text, #1e293b);" id="vrWoNumber">Service Record</h3>
                <small style="color: var(--brand, #0284c7); font-weight: 600;" id="vrVehicle">Vehicle Name</small>
            </div>
            <button onclick="closeViewRecordModal()" style="background: none; border: none; font-size: 1.8rem; line-height: 1; cursor: pointer; color: var(--muted, #64748b);">&times;</button>
        </div>

        <!-- Modal Body -->
        <div style="font-size: 0.92rem; line-height: 1.6;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 18px; background: rgba(0,0,0,0.03); padding: 14px 18px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.06);">
                <div>
                    <span style="font-size: 0.75rem; color: var(--muted, #64748b); text-transform: uppercase; font-weight: 700; display: block;">Completion Date & Time</span>
                    <strong style="color: var(--text, #1e293b);" id="vrDateTime">--</strong>
                </div>
                <div>
                    <span style="font-size: 0.75rem; color: var(--muted, #64748b); text-transform: uppercase; font-weight: 700; display: block;">Workshop / Mechanic</span>
                    <strong style="color: var(--text, #1e293b);" id="vrWorkshop">--</strong>
                </div>
            </div>

            <div style="margin-bottom: 10px;">
                <h4 style="margin: 0 0 12px 0; font-size: 0.95rem; font-weight: 700; color: #10b981; display: flex; align-items: center; gap: 6px;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    Completed Checklist Tasks Audit Log
                </h4>
                <div id="vrTasksContainer" style="max-height: 250px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px; padding-right: 4px;">
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid rgba(0,0,0,0.1); padding-top: 16px; margin-top: 20px;">
            <button type="button" onclick="window.print()" class="btn btn-secondary" style="padding: 10px 20px; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 6px;">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Print Record
            </button>
            <button type="button" onclick="closeViewRecordModal()" class="btn btn-primary" style="padding: 10px 24px; font-weight: 700; font-size: 0.9rem;">
                Close Record
            </button>
        </div>
    </div>
</div>

<script>
const defaultWoTasks = [
    'Engine Oil & Filter Replace',
    'Brake Pad & Disc Wear Check',
    'Tire Rotation & Alignment',
    'Battery & Electrical Systems',
    'AC Air Filter Refresh',
    'Full Safety Inspection'
];

function renderWoChecklist(tasks) {
    const container = document.getElementById('woChecklistContainer');
    if (!container) return;

    let taskList = [];
    if (Array.isArray(tasks) && tasks.length > 0) {
        taskList = tasks;
    } else if (typeof tasks === 'string' && tasks.trim() !== '') {
        try {
            taskList = JSON.parse(tasks);
        } catch (e) {
            taskList = tasks.includes('|') ? tasks.split('|') : tasks.split(',');
        }
    }

    if (!Array.isArray(taskList) || taskList.length === 0) {
        taskList = defaultWoTasks;
    }

    taskList = taskList.map(t => typeof t === 'string' ? t.trim() : t).filter(Boolean);

    let html = '';
    taskList.forEach((task, idx) => {
        html += `
            <label class="chk-btn-card" style="display: flex; align-items: center; gap: 8px; padding: 10px 14px; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; background: rgba(0,0,0,0.02); font-size: 0.85rem; font-weight: 600; cursor: pointer;">
                <input type="checkbox" name="checklist_completed[]" class="wo-task-chk" onchange="recalcWoProgress()" value="${task}">
                <input type="hidden" name="checklist_tasks[]" value="${task}">
                <span>${idx + 1}. ${task}</span>
            </label>
        `;
    });

    container.innerHTML = html;
    recalcWoProgress();
}

function openAddWoModal(vehicleId, tasksParam, isEdit = false) {
    if (!isEdit) {
        const form = document.getElementById('woForm');
        if (form) form.reset();
        if (document.getElementById('woEditId')) document.getElementById('woEditId').value = '';
    }

    document.getElementById('addWoModal').style.display = 'flex';

    if (vehicleId) {
        const vehicleSelect = document.getElementById('woVehicle');
        if (vehicleSelect) {
            vehicleSelect.value = vehicleId;
            if (vehicleSelect.selectedIndex <= 0) {
                for (let i = 0; i < vehicleSelect.options.length; i++) {
                    const optVal = String(vehicleSelect.options[i].value);
                    const optTxt = vehicleSelect.options[i].text.toLowerCase();
                    if (optVal === String(vehicleId) || optTxt.includes(String(vehicleId).toLowerCase())) {
                        vehicleSelect.selectedIndex = i;
                        break;
                    }
                }
            }
        }
    }

    renderWoChecklist(tasksParam);
}

function openEditWoModalFromBtn(btn) {
    const vId = btn.getAttribute('data-vehicle');
    const tasksRaw = btn.getAttribute('data-tasks');       // completed tasks
    const allTasksRaw = btn.getAttribute('data-all-tasks'); // full task list
    const mechanic = btn.getAttribute('data-mechanic');
    const vStatus = btn.getAttribute('data-status');
    const incident = btn.getAttribute('data-incident');
    const editId = btn.getAttribute('data-id');

    let completedTasks = [];
    let allTasks = [];
    try { completedTasks = JSON.parse(tasksRaw); } catch(e) { completedTasks = []; }
    try { allTasks = JSON.parse(allTasksRaw); } catch(e) { allTasks = []; }

    editWoModal(vId, completedTasks, allTasks, mechanic, vStatus, incident, editId);
}

function editWoModal(vehicleId, completedTasks, allTasks, mechanic, vStatus, incidentFlag, editId) {
    // Resolve completed task names for pre-checking
    let checkedArr = [];
    if (Array.isArray(completedTasks)) {
        checkedArr = completedTasks.map(t => (typeof t === 'object' && t !== null && t.task) ? t.task : String(t));
    }

    // Use the stored full task list; fall back to checkedArr, then defaultWoTasks
    let taskListToRender = defaultWoTasks;
    if (Array.isArray(allTasks) && allTasks.length > 0) {
        taskListToRender = allTasks; // correct: stored original task list
    } else if (checkedArr.length > 0) {
        taskListToRender = checkedArr; // fallback: at least show completed tasks
    }

    // Open modal and render the correct task list
    openAddWoModal(vehicleId, taskListToRender, true);

    if (editId && document.getElementById('woEditId')) {
        document.getElementById('woEditId').value = editId;
    }

    if (mechanic) {
        const mInput = document.getElementById('woMechanic');
        if (mInput) mInput.value = mechanic;
    }

    if (vStatus) {
        const sSelect = document.getElementById('woStatus');
        if (sSelect) sSelect.value = vStatus;
    }

    if (incidentFlag) {
        const iSelect = document.getElementById('woIncident');
        if (iSelect) iSelect.value = incidentFlag;
    }

    // Pre-check the previously completed tasks
    setTimeout(() => {
        const chks = document.querySelectorAll('.wo-task-chk');
        chks.forEach(chk => {
            chk.checked = checkedArr.some(name => name.trim() === chk.value.trim());
        });
        recalcWoProgress();
    }, 50);
}

function closeAddWoModal() {
    document.getElementById('addWoModal').style.display = 'none';
    document.getElementById('woForm').reset();
    if (document.getElementById('woEditId')) document.getElementById('woEditId').value = '';
}

function openViewHistoryRecordFromBtn(btn) {
    const number = btn.getAttribute('data-number');
    const vehicle = btn.getAttribute('data-vehicle');
    const dateStr = btn.getAttribute('data-date');
    const timeStr = btn.getAttribute('data-time');
    const workshop = btn.getAttribute('data-workshop');
    const tasksRaw = btn.getAttribute('data-tasks');

    let tasks = [];
    try {
        tasks = JSON.parse(tasksRaw);
    } catch(e) {
        tasks = [];
    }

    viewHistoryRecord(number, vehicle, dateStr, timeStr, workshop, tasks);
}

function viewHistoryRecord(woNumber, vehName, dateStr, timeStr, workshop, tasksJson) {
    let tasks = [];
    try {
        tasks = typeof tasksJson === 'string' ? JSON.parse(tasksJson) : tasksJson;
    } catch(e) {
        tasks = [];
    }
    if (!Array.isArray(tasks)) tasks = tasks ? [tasks] : [];

    const numEl = document.getElementById('vrWoNumber');
    const vehEl = document.getElementById('vrVehicle');
    const dtEl = document.getElementById('vrDateTime');
    const wsEl = document.getElementById('vrWorkshop');
    const container = document.getElementById('vrTasksContainer');

    if (numEl) numEl.innerText = 'Service Record: ' + woNumber;
    if (vehEl) vehEl.innerText = vehName;
    if (dtEl) dtEl.innerText = dateStr + (timeStr ? (' at ' + timeStr) : '');
    if (wsEl) wsEl.innerText = workshop || 'Ramesh Repair Services';

    if (container) {
        if (tasks.length > 0) {
            let html = '';
            tasks.forEach(t => {
                const taskName = (typeof t === 'object' && t !== null && t.task) ? t.task : String(t);
                const taskTime = (typeof t === 'object' && t !== null && t.time) ? t.time : (dateStr + (timeStr ? (' at ' + timeStr) : ''));
                html += `
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 14px; background: rgba(2, 132, 199, 0.06); border: 1px solid rgba(2, 132, 199, 0.15); border-radius: 10px; font-weight: 600; font-size: 0.88rem; flex-wrap: wrap; gap: 8px;">
                        <span style="color: var(--text, #1e293b); display: flex; align-items: center; gap: 6px;">
                            <span style="color: #10b981; font-weight: 700;">☑</span> ${taskName}
                        </span>
                        <span style="font-size: 0.75rem; color: #10b981; font-weight: 700; background: rgba(16, 185, 129, 0.12); padding: 3px 10px; border-radius: 999px;">
                            ${taskTime}
                        </span>
                    </div>
                `;
            });
            container.innerHTML = html;
        } else {
            container.innerHTML = '<div style="color: var(--muted, #64748b); font-size: 0.88rem; padding: 10px;">No checklist tasks recorded for this work order.</div>';
        }
    }

    const modal = document.getElementById('viewRecordModal');
    if (modal) modal.style.display = 'flex';
}

function closeViewRecordModal() {
    const modal = document.getElementById('viewRecordModal');
    if (modal) modal.style.display = 'none';
}

function switchWoTab(tab) {
    const activeBtn = document.getElementById('tabActiveBtn');
    const historyBtn = document.getElementById('tabHistoryBtn');
    const activeContent = document.getElementById('tabActiveContent');
    const historyContent = document.getElementById('tabHistoryContent');

    if (!activeBtn || !historyBtn) return;

    const activeStyle  = 'linear-gradient(135deg, #80a7ff 0%, #52ead2 100%)';
    const inactiveStyle = 'transparent';
    const activeColor  = '#061218';
    const inactiveColor = 'var(--text, #1e293b)';
    const inactiveBorder = '1px solid rgba(0,0,0,0.15)';

    if (tab === 'history') {
        activeBtn.style.background  = inactiveStyle;
        activeBtn.style.color       = inactiveColor;
        activeBtn.style.border      = inactiveBorder;
        activeBtn.style.boxShadow   = 'none';

        historyBtn.style.background = activeStyle;
        historyBtn.style.color      = activeColor;
        historyBtn.style.border     = 'none';
        historyBtn.style.boxShadow  = 'none';

        if (activeContent) activeContent.style.display = 'none';
        if (historyContent) historyContent.style.display = 'block';
    } else {
        historyBtn.style.background = inactiveStyle;
        historyBtn.style.color      = inactiveColor;
        historyBtn.style.border     = inactiveBorder;
        historyBtn.style.boxShadow  = 'none';

        activeBtn.style.background  = activeStyle;
        activeBtn.style.color       = activeColor;
        activeBtn.style.border      = 'none';
        activeBtn.style.boxShadow   = 'none';

        if (historyContent) historyContent.style.display = 'none';
        if (activeContent) activeContent.style.display = 'block';
    }
}

function recalcWoProgress() {
    const chks = document.querySelectorAll('.wo-task-chk');
    const total = chks.length;
    const checked = document.querySelectorAll('.wo-task-chk:checked').length;
    const pct = total > 0 ? Math.round((checked / total) * 100) : 0;

    const displayEl = document.getElementById('woProgressDisplay');
    const valInput = document.getElementById('woProgressValue');

    if (displayEl) displayEl.innerText = pct + '% Completed (' + checked + ' of ' + total + ' Tasks)';
    if (valInput) valInput.value = pct;

    // Auto toggle status if 100%
    if (pct === 100) {
        document.getElementById('woStatus').value = 'Available';
    }
}

function handleAddWoSubmit(e) {
    e.preventDefault();
    const btn = document.getElementById('woSubmitBtn');
    btn.disabled = true;
    btn.innerText = 'Saving Work Order to Database...';

    const formData = new FormData(document.getElementById('woForm'));

    fetch("{{ route('vendor.work-orders.store') }}", {
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
        btn.innerText = 'Save Work Order';

        if (res.success) {
            document.getElementById('addWoModal').style.display = 'none';
            closeAddWoModal();
            Swal.fire({
                icon: 'success',
                title: res.is_update ? 'Work Order Updated!' : 'Stored in Database!',
                text: res.message || 'Work Order saved successfully.',
                timer: 1200,
                showConfirmButton: false
            }).then(() => {
                window.location.href = window.location.pathname;
            });
        } else {
            Swal.fire('Error', res.message || 'Failed to save Work Order.', 'error');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerText = 'Save Work Order';
        console.error(err);
        Swal.fire('Error', 'Database connection error.', 'error');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const targetVehicle = urlParams.get('vehicle_id') || urlParams.get('vehicle');
    const tasksParam = urlParams.get('tasks') || urlParams.get('checklist');

    if (urlParams.get('history') === '1') {
        switchWoTab('history');
    } else {
        switchWoTab('active');
    }

    if (urlParams.get('openModal') === '1' || targetVehicle || tasksParam) {
        openAddWoModal(targetVehicle, tasksParam);
        window.history.replaceState({}, document.title, window.location.pathname);
    } else {
        renderWoChecklist();
    }
});
</script>
@endsection
