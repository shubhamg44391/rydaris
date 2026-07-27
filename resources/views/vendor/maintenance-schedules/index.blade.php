@extends('admin.layouts.app')

@section('main-content')
<div class="admin-panel">
    <!-- Top Header -->
    <div class="panel-head d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2>Maintenance Schedule & Work Orders</h2>
            <p class="panel-muted" style="margin: 4px 0 0 0; font-size: 0.88rem;">Manage separate maintenance requests and active vendor work orders with status tracking.</p>
        </div>

        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <button type="button" onclick="openCreateScheduleModal()" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                + Generate Maintenance Request
            </button>
            <button type="button" onclick="openWorkOrderModal()" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                + Create Work Order
            </button>
        </div>
    </div>

    <!-- Navigation Tabs for Separate Listings -->
    <div style="display: flex; gap: 12px; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px; flex-wrap: wrap;">
        <button type="button" id="tabBtnRequests" onclick="switchListTab('requests')" style="background: var(--brand, #0284c7); color: #ffffff; border: none; border-radius: 8px; padding: 10px 18px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            📋 Maintenance Requests Listing (<span id="countReq">4</span>)
        </button>
        <button type="button" id="tabBtnWorkOrders" onclick="switchListTab('work_orders')" style="background: rgba(255,255,255,0.05); color: var(--text, #94a3b8); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 10px 18px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            🛠️ Vendor Work Orders Listing (<span id="countWo">4</span>)
        </button>
    </div>

    <!-- LISTING 1: MAINTENANCE REQUESTS TABLE -->
    <div id="requestsTabContent" class="panel-body admin-table-wrap">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid rgba(255,255,255,0.08);">
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <input type="text" id="reqSearch" onkeyup="filterReqTable()" placeholder="Search maintenance request or vehicle..." class="form-control" style="padding: 8px 14px; font-size: 0.88rem; min-width: 280px;">
                <span class="panel-muted" style="font-size: 0.85rem; font-weight: 600;">Generated service requests ready for Work Order</span>
            </div>
            <button type="button" onclick="openCreateScheduleModal()" class="btn btn-secondary" style="padding: 6px 14px; font-size: 0.82rem; font-weight: 700;">+ New Request</button>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Vehicle & Plate</th>
                    <th>Trigger Interval</th>
                    <th>Service Checklist</th>
                    <th>Request Status</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody id="reqTableBody">
                <tr class="req-row">
                    <td><strong style="color: var(--brand, #0284c7);">REQ-2026-088</strong></td>
                    <td>
                        <div><strong>Tata Nexon EV</strong></div>
                        <small style="color: var(--brand, #0284c7); font-weight: 700;">DL03 EF 9012</small>
                    </td>
                    <td>
                        <div><strong>Time & Inspection</strong></div>
                        <small class="panel-muted">Every 6 Months</small>
                    </td>
                    <td>EV Battery & Coolant Inspection</td>
                    <td>
                        <span class="badge" style="background: rgba(234, 179, 8, 0.12); color: #eab308; border: 1px solid rgba(234, 179, 8, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">
                            Pending Work Order
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <button type="button" onclick="openWorkOrderForReq('Tata Nexon EV (DL03 EF 9012)')" class="btn btn-primary" style="padding: 5px 12px; font-size: 0.78rem; font-weight: 700;">
                            + Convert to Work Order
                        </button>
                    </td>
                </tr>

                <tr class="req-row">
                    <td><strong style="color: var(--brand, #0284c7);">REQ-2026-004</strong></td>
                    <td>
                        <div><strong>Kia Seltos</strong></div>
                        <small style="color: var(--brand, #0284c7); font-weight: 700;">MH12 JK 7890</small>
                    </td>
                    <td>
                        <div><strong>Time (Annual)</strong></div>
                        <small class="panel-muted">12 Months Interval</small>
                    </td>
                    <td>AC & Cabin Filter Refresh</td>
                    <td>
                        <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">
                            Approved Request
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <button type="button" onclick="openWorkOrderForReq('Kia Seltos (MH12 JK 7890)')" class="btn btn-primary" style="padding: 5px 12px; font-size: 0.78rem; font-weight: 700;">
                            + Convert to Work Order
                        </button>
                    </td>
                </tr>

                <tr class="req-row">
                    <td><strong style="color: var(--brand, #0284c7);">REQ-2026-012</strong></td>
                    <td>
                        <div><strong>Mahindra XUV700</strong></div>
                        <small style="color: var(--brand, #0284c7); font-weight: 700;">GJ05 GH 3344</small>
                    </td>
                    <td>
                        <div><strong>Engine Hours</strong></div>
                        <small class="panel-muted">500 Engine Hrs Limit</small>
                    </td>
                    <td>Synthetic Engine Oil & Filter Change</td>
                    <td>
                        <span class="badge" style="background: rgba(234, 179, 8, 0.12); color: #eab308; border: 1px solid rgba(234, 179, 8, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">
                            Pending Work Order
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <button type="button" onclick="openWorkOrderForReq('Mahindra XUV700 (GJ05 GH 3344)')" class="btn btn-primary" style="padding: 5px 12px; font-size: 0.78rem; font-weight: 700;">
                            + Convert to Work Order
                        </button>
                    </td>
                </tr>

                <tr class="req-row">
                    <td><strong style="color: var(--brand, #0284c7);">REQ-2026-019</strong></td>
                    <td>
                        <div><strong>Hyundai Creta</strong></div>
                        <small style="color: var(--brand, #0284c7); font-weight: 700;">GJ01 AB 1234</small>
                    </td>
                    <td>
                        <div><strong>Odometer Km</strong></div>
                        <small class="panel-muted">10,000 Km Rotation</small>
                    </td>
                    <td>Brake Pad & Disc Wear Inspection</td>
                    <td>
                        <span class="badge" style="background: rgba(234, 179, 8, 0.12); color: #eab308; border: 1px solid rgba(234, 179, 8, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">
                            Pending Work Order
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <button type="button" onclick="openWorkOrderForReq('Hyundai Creta (GJ01 AB 1234)')" class="btn btn-primary" style="padding: 5px 12px; font-size: 0.78rem; font-weight: 700;">
                            + Convert to Work Order
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- LISTING 2: VENDOR WORK ORDERS TABLE -->
    <div id="workOrdersTabContent" class="panel-body admin-table-wrap" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid rgba(255,255,255,0.08);">
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <input type="text" id="woSearch" onkeyup="filterWoTable()" placeholder="Search work order #, mechanic, vehicle..." class="form-control" style="padding: 8px 14px; font-size: 0.88rem; min-width: 280px;">
                <span class="panel-muted" style="font-size: 0.85rem; font-weight: 600;">Active mechanic jobs & maintenance status lock</span>
            </div>
            <button type="button" onclick="openWorkOrderModal()" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.82rem; font-weight: 700;">+ New Work Order</button>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Work Order #</th>
                    <th>Vehicle & Plate</th>
                    <th>Assigned Mechanic</th>
                    <th>Vehicle Rental Status</th>
                    <th>Mechanic Progress</th>
                    <th>Est. / Final Cost</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody id="woTableBody">
                <tr class="wo-row">
                    <td><strong style="color: #8b5cf6;">WO-2026-042</strong></td>
                    <td>
                        <div><strong>Mahindra XUV700</strong></div>
                        <small style="color: var(--brand, #0284c7); font-weight: 700;">GJ05 GH 3344</small>
                    </td>
                    <td>
                        <div><strong>Ramesh Repair Services</strong></div>
                        <small class="panel-muted">Senior Mechanic assigned</small>
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                            <span style="width:6px; height:6px; border-radius:50%; background:#ef4444;"></span> In Maintenance
                        </span>
                    </td>
                    <td style="min-width: 140px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: 700; margin-bottom: 4px;">
                            <span>Progress</span>
                            <span>60%</span>
                        </div>
                        <div style="width: 100%; height: 6px; background: rgba(0,0,0,0.1); border-radius: 999px; overflow: hidden;">
                            <div style="width: 60%; height: 100%; background: linear-gradient(90deg, var(--brand, #0284c7), #8b5cf6); border-radius: 999px;"></div>
                        </div>
                    </td>
                    <td>
                        <strong style="color: #10b981;">₹4,500</strong>
                        <div><small class="panel-muted">Next Due Auto Update</small></div>
                    </td>
                    <td style="text-align: right;">
                        <button type="button" onclick="openUpdateWorkflowModal(101, 'Mahindra XUV700', 'WO-2026-042', 60, 'In Maintenance')" class="icon-button edit-btn" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; font-size: 0.8rem; font-weight: 700; cursor: pointer; border-radius: 6px;">
                            Update Progress ⚙️
                        </button>
                    </td>
                </tr>

                <tr class="wo-row">
                    <td><strong style="color: #8b5cf6;">WO-2026-039</strong></td>
                    <td>
                        <div><strong>Hyundai Creta</strong></div>
                        <small style="color: var(--brand, #0284c7); font-weight: 700;">GJ01 AB 1234</small>
                    </td>
                    <td>
                        <div><strong>Speedy Auto Care</strong></div>
                        <small class="panel-muted">Workshop Technician</small>
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                            <span style="width:6px; height:6px; border-radius:50%; background:#ef4444;"></span> In Maintenance
                        </span>
                    </td>
                    <td style="min-width: 140px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: 700; margin-bottom: 4px;">
                            <span>Progress</span>
                            <span>80%</span>
                        </div>
                        <div style="width: 100%; height: 6px; background: rgba(0,0,0,0.1); border-radius: 999px; overflow: hidden;">
                            <div style="width: 80%; height: 100%; background: linear-gradient(90deg, var(--brand, #0284c7), #8b5cf6); border-radius: 999px;"></div>
                        </div>
                    </td>
                    <td>
                        <strong style="color: #10b981;">₹3,200</strong>
                        <div><small class="panel-muted">Next Due Auto Update</small></div>
                    </td>
                    <td style="text-align: right;">
                        <button type="button" onclick="openUpdateWorkflowModal(102, 'Hyundai Creta', 'WO-2026-039', 80, 'In Maintenance')" class="icon-button edit-btn" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; font-size: 0.8rem; font-weight: 700; cursor: pointer; border-radius: 6px;">
                            Update Progress ⚙️
                        </button>
                    </td>
                </tr>

                <tr class="wo-row">
                    <td><strong style="color: #8b5cf6;">WO-2026-050</strong></td>
                    <td>
                        <div><strong>BMW 3 Series</strong></div>
                        <small style="color: var(--brand, #0284c7); font-weight: 700;">HR26 LM 1122</small>
                    </td>
                    <td>
                        <div><strong>Premium Auto Care Center</strong></div>
                        <small class="panel-muted">Master Specialist</small>
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                            <span style="width:6px; height:6px; border-radius:50%; background:#ef4444;"></span> In Maintenance
                        </span>
                    </td>
                    <td style="min-width: 140px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: 700; margin-bottom: 4px;">
                            <span>Progress</span>
                            <span>45%</span>
                        </div>
                        <div style="width: 100%; height: 6px; background: rgba(0,0,0,0.1); border-radius: 999px; overflow: hidden;">
                            <div style="width: 45%; height: 100%; background: linear-gradient(90deg, var(--brand, #0284c7), #8b5cf6); border-radius: 999px;"></div>
                        </div>
                    </td>
                    <td>
                        <strong style="color: #10b981;">₹15,000</strong>
                        <div><small class="panel-muted">Next Due Auto Update</small></div>
                    </td>
                    <td style="text-align: right;">
                        <button type="button" onclick="openUpdateWorkflowModal(107, 'BMW 3 Series', 'WO-2026-050', 45, 'In Maintenance')" class="icon-button edit-btn" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; font-size: 0.8rem; font-weight: 700; cursor: pointer; border-radius: 6px;">
                            Update Progress ⚙️
                        </button>
                    </td>
                </tr>

                <tr class="wo-row">
                    <td><strong style="color: #8b5cf6;">WO-2026-015</strong></td>
                    <td>
                        <div><strong>Toyota Fortuner</strong></div>
                        <small style="color: var(--brand, #0284c7); font-weight: 700;">MH02 CD 5678</small>
                    </td>
                    <td>
                        <div><strong>Toyota Authorized Workshop</strong></div>
                        <small class="panel-muted">OEM Service Center</small>
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                            <span style="width:6px; height:6px; border-radius:50%; background:#10b981;"></span> Available
                        </span>
                    </td>
                    <td style="min-width: 140px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: 700; margin-bottom: 4px;">
                            <span>Progress</span>
                            <span>100%</span>
                        </div>
                        <div style="width: 100%; height: 6px; background: rgba(0,0,0,0.1); border-radius: 999px; overflow: hidden;">
                            <div style="width: 100%; height: 100%; background: linear-gradient(90deg, #10b981, #059669); border-radius: 999px;"></div>
                        </div>
                    </td>
                    <td>
                        <strong style="color: #10b981;">₹12,800</strong>
                        <div><small class="panel-muted">Auto Next Service Updated</small></div>
                    </td>
                    <td style="text-align: right;">
                        <button type="button" onclick="openUpdateWorkflowModal(103, 'Toyota Fortuner', 'WO-2026-015', 100, 'Available')" class="icon-button edit-btn" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; font-size: 0.8rem; font-weight: 700; cursor: pointer; border-radius: 6px;">
                            Update Progress ⚙️
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal 1: Generate Maintenance Request -->
<div id="createScheduleModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(5, 7, 17, 0.75); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: var(--panel, #ffffff); border: 1px solid rgba(0,0,0,0.15); border-radius: 16px; width: 100%; max-width: 540px; padding: 24px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 12px;">
            <h3 style="margin: 0; font-size: 1.2rem; font-weight: 700;">Generate Maintenance Request</h3>
            <button onclick="closeCreateScheduleModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; cursor: pointer;">&times;</button>
        </div>

        <form onsubmit="handleCreateScheduleSubmit(event)">
            <div style="margin-bottom: 16px;">
                <label class="form-label-custom" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Select Vehicle</label>
                <select id="schedVehicle" required class="form-control" style="width: 100%; padding: 10px 14px; font-size: 0.9rem;">
                    <option value="">-- Select Vehicle --</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->name }} ({{ $v->reg_number ?? 'REG' }})">{{ $v->name }} ({{ $v->reg_number ?? 'REG' }})</option>
                    @endforeach
                    <option value="Mahindra XUV700 (GJ05 GH 3344)">Mahindra XUV700 (GJ05 GH 3344)</option>
                    <option value="Hyundai Creta (GJ01 AB 1234)">Hyundai Creta (GJ01 AB 1234)</option>
                    <option value="Toyota Fortuner (MH02 CD 5678)">Toyota Fortuner (MH02 CD 5678)</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Schedule Interval Type</label>
                    <select id="schedType" required class="form-control" style="width: 100%; padding: 10px 14px; font-size: 0.9rem;">
                        <option value="Time & Engine Hours">Time & Engine Hours</option>
                        <option value="Time (Months)">Time Interval (Months)</option>
                        <option value="Engine Hours">Engine Hours (Hrs)</option>
                        <option value="Odometer Distance">Odometer Distance (Km)</option>
                    </select>
                </div>

                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Trigger Limit / Value</label>
                    <input type="text" id="schedLimit" placeholder="e.g. 500 Hrs or 6 Months" required class="form-control" style="width: 100%; padding: 10px 14px; font-size: 0.9rem;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label-custom" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Service Checklist Items</label>
                <input type="text" id="schedChecklist" placeholder="e.g. Engine Oil, Brake Pads, Filter Replace" required class="form-control" style="width: 100%; padding: 10px 14px; font-size: 0.9rem;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeCreateScheduleModal()" class="btn btn-secondary" style="padding: 10px 18px; font-weight: 600;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="padding: 10px 22px; font-weight: 700;">Submit Request</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Create Vendor Work Order -->
<div id="workOrderModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(5, 7, 17, 0.75); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: var(--panel, #ffffff); border: 1px solid rgba(0,0,0,0.15); border-radius: 16px; width: 100%; max-width: 560px; padding: 24px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 12px;">
            <h3 style="margin: 0; font-size: 1.2rem; font-weight: 700;" id="modalWoTitle">Vendor Creates Work Order</h3>
            <button onclick="closeWorkOrderModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; cursor: pointer;">&times;</button>
        </div>

        <form onsubmit="handleWorkOrderSubmit(event)">
            <input type="hidden" id="woEditId">
            <div style="margin-bottom: 16px;">
                <label class="form-label-custom" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Select Vehicle</label>
                <select id="woVehicle" required class="form-control" style="width: 100%; padding: 10px 14px; font-size: 0.9rem;">
                    @foreach($vehicles as $v)
                        <option value="{{ $v->name }} ({{ $v->reg_number ?? 'REG' }})">{{ $v->name }} ({{ $v->reg_number ?? 'REG' }})</option>
                    @endforeach
                    <option value="Mahindra XUV700 (GJ05 GH 3344)">Mahindra XUV700 (GJ05 GH 3344)</option>
                    <option value="Hyundai Creta (GJ01 AB 1234)">Hyundai Creta (GJ01 AB 1234)</option>
                    <option value="BMW 3 Series (HR26 LM 1122)">BMW 3 Series (HR26 LM 1122)</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Assigned Mechanic / Workshop</label>
                    <input type="text" id="woMechanic" placeholder="e.g. Speed Auto Workshop" required class="form-control" style="width: 100%; padding: 10px 14px; font-size: 0.9rem;">
                </div>

                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Vehicle Rental Status</label>
                    <select id="woStatus" required class="form-control" style="width: 100%; padding: 10px 14px; font-size: 0.9rem;">
                        <option value="In Maintenance">In Maintenance (Lock Rental)</option>
                        <option value="Available">Available (Unlocked)</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Mechanic Progress (%)</label>
                    <input type="number" id="woProgress" min="0" max="100" placeholder="e.g. 50" required class="form-control" style="width: 100%; padding: 10px 14px; font-size: 0.9rem;">
                </div>

                <div>
                    <label class="form-label-custom" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">Estimated / Final Cost</label>
                    <input type="text" id="woCost" placeholder="e.g. ₹5,200" required class="form-control" style="width: 100%; padding: 10px 14px; font-size: 0.9rem;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 8px; background: rgba(2, 132, 199, 0.08); border: 1px solid rgba(2, 132, 199, 0.2); padding: 10px 14px; border-radius: 8px; font-size: 0.8rem; color: var(--brand, #0284c7);">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    Completing service automatically updates next service due date & stores history log.
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeWorkOrderModal()" class="btn btn-secondary" style="padding: 10px 18px; font-weight: 600;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="padding: 10px 22px; font-weight: 700;">Save Work Order</button>
            </div>
        </form>
    </div>
</div>

<script>
function switchListTab(tab) {
    const btnReq = document.getElementById('tabBtnRequests');
    const btnWo = document.getElementById('tabBtnWorkOrders');
    const contentReq = document.getElementById('requestsTabContent');
    const contentWo = document.getElementById('workOrdersTabContent');

    if (tab === 'requests') {
        btnReq.style.background = 'var(--brand, #0284c7)';
        btnReq.style.color = '#ffffff';
        btnReq.style.border = 'none';

        btnWo.style.background = 'rgba(255,255,255,0.05)';
        btnWo.style.color = 'var(--text, #94a3b8)';
        btnWo.style.border = '1px solid rgba(255,255,255,0.1)';

        contentReq.style.display = 'block';
        contentWo.style.display = 'none';
    } else {
        btnWo.style.background = '#8b5cf6';
        btnWo.style.color = '#ffffff';
        btnWo.style.border = 'none';

        btnReq.style.background = 'rgba(255,255,255,0.05)';
        btnReq.style.color = 'var(--text, #94a3b8)';
        btnReq.style.border = '1px solid rgba(255,255,255,0.1)';

        contentWo.style.display = 'block';
        contentReq.style.display = 'none';
    }
}

function openCreateScheduleModal() {
    document.getElementById('createScheduleModal').style.display = 'flex';
}
function closeCreateScheduleModal() {
    document.getElementById('createScheduleModal').style.display = 'none';
}

function openWorkOrderModal() {
    document.getElementById('modalWoTitle').innerText = 'Vendor Creates Work Order';
    document.getElementById('woEditId').value = '';
    document.getElementById('workOrderModal').style.display = 'flex';
}
function closeWorkOrderModal() {
    document.getElementById('workOrderModal').style.display = 'none';
}

function openWorkOrderForReq(vehicleVal) {
    switchListTab('work_orders');
    document.getElementById('woVehicle').value = vehicleVal;
    openWorkOrderModal();
}

function openUpdateWorkflowModal(id, vehicle, woNum, progress, vStatus) {
    switchListTab('work_orders');
    document.getElementById('modalWoTitle').innerText = 'Update Work Order Progress: ' + woNum;
    document.getElementById('woEditId').value = id;
    document.getElementById('woProgress').value = progress;
    document.getElementById('woStatus').value = vStatus;
    document.getElementById('workOrderModal').style.display = 'flex';
}

function filterReqTable() {
    const search = document.getElementById('reqSearch').value.toLowerCase();
    const rows = document.querySelectorAll('.req-row');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(search) ? '' : 'none';
    });
}

function filterWoTable() {
    const search = document.getElementById('woSearch').value.toLowerCase();
    const rows = document.querySelectorAll('.wo-row');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(search) ? '' : 'none';
    });
}

function handleCreateScheduleSubmit(e) {
    e.preventDefault();
    const vehicle = document.getElementById('schedVehicle').value;
    const type = document.getElementById('schedType').value;
    const limit = document.getElementById('schedLimit').value;
    const checklist = document.getElementById('schedChecklist').value;

    const tbody = document.getElementById('reqTableBody');
    const tr = document.createElement('tr');
    tr.className = 'req-row';
    const reqNum = 'REQ-2026-' + Math.floor(100+Math.random()*900);
    
    tr.innerHTML = `
        <td><strong style="color: var(--brand, #0284c7);">${reqNum}</strong></td>
        <td>
            <div><strong>${vehicle}</strong></div>
            <small style="color: var(--brand, #0284c7); font-weight: 700;">Reg Scheduled</small>
        </td>
        <td>
            <div><strong>${type}</strong></div>
            <small class="panel-muted">${limit}</small>
        </td>
        <td>${checklist}</td>
        <td>
            <span class="badge" style="background: rgba(234, 179, 8, 0.12); color: #eab308; border: 1px solid rgba(234, 179, 8, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700;">
                Pending Work Order
            </span>
        </td>
        <td style="text-align: right;">
            <button type="button" onclick="openWorkOrderForReq('${vehicle}')" class="btn btn-primary" style="padding: 5px 12px; font-size: 0.78rem; font-weight: 700;">
                + Convert to Work Order
            </button>
        </td>
    `;
    tbody.insertBefore(tr, tbody.firstChild);

    closeCreateScheduleModal();
    switchListTab('requests');

    Swal.fire({
        icon: 'success',
        title: 'Maintenance Request Generated!',
        text: 'Request added to Maintenance Requests listing.',
        timer: 2000,
        showConfirmButton: false
    });
}

function handleWorkOrderSubmit(e) {
    e.preventDefault();
    const vehicle = document.getElementById('woVehicle').value;
    const mechanic = document.getElementById('woMechanic').value;
    const status = document.getElementById('woStatus').value;
    const progress = parseInt(document.getElementById('woProgress').value);
    const cost = document.getElementById('woCost').value;

    const tbody = document.getElementById('woTableBody');
    const tr = document.createElement('tr');
    tr.className = 'wo-row';
    
    const isMaint = status === 'In Maintenance';
    const statusBadge = isMaint 
        ? '<span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;"><span style="width:6px; height:6px; border-radius:50%; background:#ef4444;"></span> In Maintenance</span>'
        : '<span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;"><span style="width:6px; height:6px; border-radius:50%; background:#10b981;"></span> Available</span>';

    const woNum = 'WO-2026-' + Math.floor(100+Math.random()*900);

    tr.innerHTML = `
        <td><strong style="color: #8b5cf6;">${woNum}</strong></td>
        <td>
            <div><strong>${vehicle}</strong></div>
            <small style="color: var(--brand, #0284c7); font-weight: 700;">Work Order Active</small>
        </td>
        <td>
            <div><strong>${mechanic}</strong></div>
            <small class="panel-muted">Assigned Technician</small>
        </td>
        <td>${statusBadge}</td>
        <td style="min-width: 140px;">
            <div style="display: flex; justify-content: space-between; font-size: 0.78rem; font-weight: 700; margin-bottom: 4px;">
                <span>Progress</span>
                <span>${progress}%</span>
            </div>
            <div style="width: 100%; height: 6px; background: rgba(0,0,0,0.1); border-radius: 999px; overflow: hidden;">
                <div style="width: ${progress}%; height: 100%; background: linear-gradient(90deg, var(--brand, #0284c7), #8b5cf6); border-radius: 999px;"></div>
            </div>
        </td>
        <td>
            <strong style="color: #10b981;">${cost}</strong>
            <div><small class="panel-muted">${progress >= 100 ? 'Auto Next Updated' : 'In Progress'}</small></div>
        </td>
        <td style="text-align: right;">
            <button type="button" onclick="openUpdateWorkflowModal(999, '${vehicle}', '${woNum}', ${progress}, '${status}')" class="icon-button edit-btn" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; font-size: 0.8rem; font-weight: 700; cursor: pointer; border-radius: 6px;">
                Update Progress ⚙️
            </button>
        </td>
    `;
    tbody.insertBefore(tr, tbody.firstChild);

    closeWorkOrderModal();
    switchListTab('work_orders');

    let msg = 'Work Order created & Vehicle Status updated.';
    if (progress >= 100) {
        msg = 'Service Complete! Vehicle status set to Available & Next Service Date updated automatically.';
    }

    Swal.fire({
        icon: 'success',
        title: 'Work Order Saved!',
        text: msg,
        timer: 2500,
        showConfirmButton: false
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const openParam = urlParams.get('open');
    if (openParam === 'request') {
        switchListTab('requests');
    } else if (openParam === 'work_order') {
        switchListTab('work_orders');
    }
});
</script>
@endsection
