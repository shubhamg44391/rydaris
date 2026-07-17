@extends('demo.layout')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* CSS Variables matching the design system */
    :root {
      --surface:      var(--panel);
      --surface-soft: var(--panel-strong);
      --primary:      var(--brand); 
      --primary-soft: rgba(82, 234, 210, 0.15);
      --ok:           var(--good);
      --table-head:   var(--bg-2); 
      --selected:     rgba(82, 234, 210, 0.25);
      --locked:       var(--line-dark);
    }

    .flatpickr-calendar {
        z-index: 9999 !important;
    }
    /* Checkbox Theme Accent Redesign */
    input[type="checkbox"] {
        accent-color: var(--brand, #52ead2) !important;
    }
    .flatpickr-months .flatpickr-month {
        height: 45px !important;
        overflow: visible !important;
    }
    .flatpickr-current-month {
        padding-top: 10px !important;
        font-size: 105% !important;
        height: auto !important;
        line-height: 1.5 !important;
    }
    .flatpickr-current-month .numInputWrapper {
        width: 7ch !important;
    }

    .toolbar-btn {
        padding: 10px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid transparent;
        text-decoration: none;
        width: 100%;
    }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-success { background: #ecfdf5; color: #059669; border-color: #a7f3d0; }
    .btn-ink     { background: var(--bg); color: var(--text); border-color: #cbd5e1; }
    .btn-violet  { background: #f5f3ff; color: #7c3aed; border-color: #ddd6fe; }

    /* Filters */
    .filter-section {
        background: var(--surface);
        padding: 15px;
        border-radius: 8px;
        border: 1px solid var(--line);
        margin-bottom: 20px;
    }
    .filter-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: var(--muted);
        font-weight: 700;
        margin-bottom: 10px;
        letter-spacing: 0.05em;
    }
    .chip {
        padding: 6px 14px;
        border-radius: 4px;
        background: var(--bg-2);
        color: var(--text);
        font-size: 0.8rem;
        cursor: pointer;
        border: 1px solid var(--line);
        display: inline-block;
        margin: 0 4px 6px 0;
        user-select: none;
        transition: all 0.2s ease;
    }
    .chip:hover {
        background: var(--bg);
        border-color: #cbd5e1;
    }
    .chip.active-blue {
        background: linear-gradient(135deg, var(--brand), var(--brand-2)) !important;
        color: #051013 !important;
        border-color: transparent !important;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(82, 234, 210, 0.25) !important;
    }
    .chip.active-green {
        background: linear-gradient(135deg, var(--brand), var(--brand-2)) !important;
        color: #051013 !important;
        border-color: transparent !important;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(82, 234, 210, 0.25) !important;
    }

    .date-range-btn {
        border: 1px solid var(--line);
        background: var(--bg-2);
        color: var(--text);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 4px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .date-range-btn.active {
        background: linear-gradient(135deg, var(--brand), var(--brand-2)) !important;
        color: #051013 !important;
        border-color: transparent !important;
    }
    
    .date-input {
        border: 1px solid var(--line); 
        padding: 8px 12px; 
        border-radius: 8px; 
        font-size: 0.85rem; 
        outline: none; 
        transition: border-color 0.2s;
        color: var(--text);
    }
    .date-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    /* Rate Table */
    .rate-table-container {
        overflow: auto;
        max-height: 600px;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 8px;
        position: relative;
    }
    .rate-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.85rem;
    }
    .rate-table th {
        background: #0b1020 !important;
        color: #fff !important;
        padding: 12px 10px;
        font-weight: 600;
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
        text-align: center;
        border-bottom: 2px solid var(--line-dark);
    }
    .rate-table th:nth-child(1) { left: 0 !important; z-index: 12 !important; width: 100px; background: #0b1020 !important; }
    .rate-table th:nth-child(2) { left: 100px !important; z-index: 12 !important; width: 180px; background: #0b1020 !important; }


    .rate-table td {
        padding: 8px 10px;
        border-bottom: 1px solid var(--line);
        border-right: 1px solid var(--line);
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }
    .rate-table td.sticky-date {
        position: sticky;
        left: 0;
        background: var(--bg-2);
        font-weight: 700;
        z-index: 9;
        border-right: 1px solid var(--line);
    }
    .rate-table td.sticky-group {
        position: sticky;
        left: 100px;
        z-index: 9;
        border-right: 1px solid var(--line);
        text-align: left;
    }
    .rate-table tr:hover td:not(.sticky-date):not(.sticky-group) {
        opacity: 0.9;
    }
    
    /* Row types */
    .row-group td { background: #ffe4e6; color: #be123c; font-weight: 600; }
    .row-group td.sticky-group { background: #ffe4e6; color: #be123c; }
    
    .row-vehicle td { background: #fef9c3; color: #facc15; }
    .row-vehicle td.sticky-group { background: #fef9c3; color: #facc15; padding-left: 20px; }

    .row-group.alt td { background: #e0f2fe; color: #0369a1; }
    .row-group.alt td.sticky-group { background: #e0f2fe; color: #0369a1; }
    
    /* Cell states */
    .cell-price { cursor: cell; }
    .cell-price:hover { box-shadow: inset 0 0 0 2px var(--primary); }
    .cell-locked { color: var(--muted); }
    
    .cell-input {
        width: 60px;
        border: 2px solid var(--primary);
        box-sizing: border-box;
        text-align: center;
        font-size: 0.85rem;
        padding: 4px 2px;
        border-radius: 4px;
        outline: none;
        background: var(--bg-2);
    }

    @keyframes spin { 100% { transform: rotate(360deg); } }
    .spin { animation: spin 1s linear infinite; }

    /* Modals & Context Menu */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.75);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
    }
    .swal2-container {
        z-index: 999999 !important;
    }
    .swal2-popup {
        background: var(--bg-2, #0b1020) !important;
        border: 1px solid var(--line, rgba(255,255,255,0.1)) !important;
        border-radius: 8px !important;
        color: var(--text, #f8fafc) !important;
    }
    .swal2-title {
        color: var(--text, #f8fafc) !important;
        font-size: 1.25rem !important;
        font-weight: 700 !important;
    }
    .swal2-html-container {
        color: var(--muted, #a8b3c5) !important;
        font-size: 0.9rem !important;
    }
    .swal2-styled.swal2-confirm {
        background: linear-gradient(135deg, var(--brand), var(--brand-2)) !important;
        color: #051013 !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 0.85rem !important;
        padding: 8px 20px !important;
        box-shadow: 0 4px 12px rgba(82, 234, 210, 0.2) !important;
    }
    .swal2-styled.swal2-cancel {
        background: rgba(255, 255, 255, 0.05) !important;
        color: var(--text) !important;
        border: 1px solid var(--line) !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 0.85rem !important;
        padding: 8px 20px !important;
    }
    .swal2-icon.swal2-error {
        border-color: #ef4444 !important;
    }
    .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
        background-color: #ef4444 !important;
    }
    .swal2-icon.swal2-success {
        border-color: var(--brand, #52ead2) !important;
    }
    .swal2-icon.swal2-success [class^=swal2-success-line] {
        background-color: var(--brand, #52ead2) !important;
    }
    .swal2-icon.swal2-success .swal2-success-ring {
        border: 4px solid rgba(82, 234, 210, 0.2) !important;
    }
    .modal-content {
        background: var(--bg-2) !important;
        padding: 24px;
        border-radius: 8px;
        width: 600px;
        max-width: 90%;
        box-shadow: 0 10px 25px rgba(0,0,0,0.4);
        color: var(--text) !important;
    }

    /* Enforce Dark Theme on hardcoded inline styles */
    div[style*="background: var(--bg)"], 
    div[style*="background: var(--bg-2)"],
    div[style*="background: var(--bg-2)"],
    div[style*="background: var(--bg)"] {
        background: var(--surface) !important;
        border-color: var(--line) !important;
    }
    
    h2[style*="color: var(--text)"], 
    h3[style*="color: var(--text)"],
    span[style*="color: var(--muted-2, #a1a1aa)"],
    div[style*="color: var(--muted-2, #a1a1aa)"],
    label[style*="color: var(--muted-2, #a1a1aa)"],
    strong[style*="color: var(--text)"],
    div[style*="color: var(--text)"],
    div[style*="color: var(--text)"] {
        color: var(--text) !important;
    }

    button[style*="background: var(--bg-2)"],
    button[style*="background: var(--bg-2)"] {
        background: var(--surface) !important;
        border-color: var(--line) !important;
        color: var(--text) !important;
    }

    input[style*="background-color: var(--bg-2)"],
    input[style*="background: var(--bg-2)"] {
        background: var(--bg-2) !important;
        border-color: var(--line) !important;
        color: var(--text) !important;
    }

    .btn-success { background: rgba(74, 222, 128, 0.15) !important; color: var(--good) !important; border-color: rgba(74, 222, 128, 0.3) !important; }
    .btn-ink     { background: rgba(255, 255, 255, 0.05) !important; color: var(--text) !important; border-color: var(--line) !important; }
    .btn-violet  { background: rgba(124, 58, 237, 0.15) !important; color: #a78bfa !important; border-color: rgba(124, 58, 237, 0.3) !important; }

    .chip {
        background: var(--bg-2) !important;
        border-color: var(--line) !important;
        color: var(--text) !important;
    }
    .chip:hover {
        background: var(--panel-strong) !important;
    }
    .chip.active-blue {
        background: linear-gradient(135deg, var(--brand), var(--brand-2)) !important;
        color: #051013 !important;
        border-color: transparent !important;
    }
    .chip.active-green {
        background: linear-gradient(135deg, var(--brand), var(--brand-2)) !important;
        color: #051013 !important;
        border-color: transparent !important;
    }
    
    .rate-table td.sticky-date,
    .rate-table td.sticky-group {
        background: var(--bg-2) !important;
        color: var(--text) !important;
        border-color: var(--line) !important;
    }
    
    .row-group td { background: rgba(225, 29, 72, 0.1) !important; color: #fda4af !important; }
    .row-group td.sticky-date,
    .row-group td.sticky-group { background: #1d1217 !important; color: #fda4af !important; }
    
    .row-vehicle td { background: rgba(202, 138, 4, 0.1) !important; color: #fde047 !important; }
    .row-vehicle td.sticky-date,
    .row-vehicle td.sticky-group { background: #1a1712 !important; color: #fde047 !important; }

    .row-group.alt td { background: rgba(3, 105, 161, 0.1) !important; color: #7dd3fc !important; }
    .row-group.alt td.sticky-date,
    .row-group.alt td.sticky-group { background: #121822 !important; color: #7dd3fc !important; }


    .cell-input {
        background: var(--bg-2) !important;
        color: var(--text) !important;
        border-color: var(--primary) !important;
    }

    span#statusBadge {
        background: rgba(74, 222, 128, 0.15) !important;
        color: var(--good) !important;
        border-color: rgba(74, 222, 128, 0.3) !important;
    }
</style>

<div class="admin-panel" style="padding: 0; background: transparent; min-height: auto;">
    <!-- Top Title -->
    <div style="background: var(--bg-2); border-radius: 6px; border: 1px solid var(--line); padding: 15px; margin-bottom: 15px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <h2 style="margin: 0; font-size: 1.35rem; color: var(--text); font-weight: 700; text-align: center;">Pricing Management</h2>
        <span style="margin-top: 4px; font-size: 0.85rem; color: var(--muted-2, #a1a1aa); text-align: center; display: block;">Fleet & Rates</span>
    </div>

    <!-- Toolbar Buttons -->
    <div style="background: var(--bg-2); border-radius: 6px; border: 1px solid var(--line); padding: 10px; margin-bottom: 15px; display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px;">
        <button class="toolbar-btn btn-primary" onclick="openBulkModal()" style="padding: 10px; font-size: 0.9rem;">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
            Update Prices
        </button>
        <button class="toolbar-btn btn-success" onclick="copyRates()" style="padding: 10px; font-size: 0.9rem;">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
            Copy Rates
        </button>
        <button class="toolbar-btn btn-ink" onclick="exportRates()" style="padding: 10px; font-size: 0.9rem;">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Export
        </button>
        <button class="toolbar-btn btn-ink" onclick="triggerImport()" style="padding: 10px; font-size: 0.9rem;">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
            Import
        </button>
        <input type="file" id="csvFileInput" style="display: none;" accept=".csv" onchange="handleImport(event)">
        <button class="toolbar-btn btn-violet" onclick="openHistoryModal()" style="padding: 10px; font-size: 0.9rem;">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            View History
        </button>
    </div>

    <!-- Filters Section -->
    <div style="display: grid; grid-template-columns: 1fr 1.5fr 2fr; gap: 15px; margin-bottom: 20px;">
        
        <!-- Year & Date Range Panel -->
        <div style="background: var(--bg-2); border-radius: 6px; border: 1px solid var(--line); padding: 15px;">
            <div class="filter-title" style="margin-bottom: 10px; color: var(--muted-2, #a1a1aa); font-size: 0.75rem;">YEAR</div>
            <div id="yearFilters" style="margin-bottom: 15px;">
                @php $currentYear = (int)date('Y'); @endphp
                @for($y = $currentYear - 1; $y <= $currentYear + 1; $y++)
                    <span class="chip {{ $y === $currentYear ? 'active-blue' : '' }}" onclick="setYear({{ $y }}, this)">{{ $y }}</span>
                @endfor
            </div>
            
            <div style="border-top: 1px dashed #cbd5e1; margin-bottom: 15px;"></div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div class="filter-title" style="margin: 0; color: var(--muted-2, #a1a1aa); font-size: 0.75rem;">DATE RANGE</div>
                <button class="btn btn-sm" style="border: 1px solid var(--line); background: var(--bg-2); color: var(--text); font-size:0.7rem; padding:2px 8px; border-radius:4px; font-weight:500; cursor:pointer;" onclick="clearDateRange()">Clear</button>
            </div>
            <div style="display: flex; gap: 10px;">
                <input type="text" id="dateStart" class="form-control date-input" placeholder="Start" style="flex: 1; padding: 6px; font-size: 0.85rem; border-radius: 4px; background-color: var(--bg-2); text-align: center;">
                <input type="text" id="dateEnd" class="form-control date-input" placeholder="End" style="flex: 1; padding: 6px; font-size: 0.85rem; border-radius: 4px; background-color: var(--bg-2); text-align: center;">
            </div>
        </div>

        <!-- Month Panel -->
        <div style="background: var(--bg-2); border-radius: 6px; border: 1px solid var(--line); padding: 15px;">
            <div class="filter-title" style="margin-bottom: 10px; color: var(--muted-2, #a1a1aa); font-size: 0.75rem;">MONTH</div>
            <div id="monthFilters" style="display: flex; flex-wrap: wrap; gap: 6px;">
                <span class="chip active-blue" data-month="next30" onclick="setMonth(this, 'next30')" style="margin:0;">Next 30 Days</span>
                <span class="chip" data-month="1" onclick="setMonth(this, 1)" style="margin:0;">January</span>
                <span class="chip" data-month="2" onclick="setMonth(this, 2)" style="margin:0;">February</span>
                <span class="chip" data-month="3" onclick="setMonth(this, 3)" style="margin:0;">March</span>
                <span class="chip" data-month="4" onclick="setMonth(this, 4)" style="margin:0;">April</span>
                <span class="chip" data-month="5" onclick="setMonth(this, 5)" style="margin:0;">May</span>
                <span class="chip" data-month="6" onclick="setMonth(this, 6)" style="margin:0;">June</span>
                <span class="chip" data-month="7" onclick="setMonth(this, 7)" style="margin:0;">July</span>
                <span class="chip" data-month="8" onclick="setMonth(this, 8)" style="margin:0;">August</span>
                <span class="chip" data-month="9" onclick="setMonth(this, 9)" style="margin:0;">September</span>
                <span class="chip" data-month="10" onclick="setMonth(this, 10)" style="margin:0;">October</span>
                <span class="chip" data-month="11" onclick="setMonth(this, 11)" style="margin:0;">November</span>
                <span class="chip" data-month="12" onclick="setMonth(this, 12)" style="margin:0;">December</span>
            </div>
        </div>

        <!-- Groups Panel -->
        <div style="background: var(--bg-2); border-radius: 6px; border: 1px solid var(--line); padding: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div class="filter-title" style="margin: 0; color: var(--muted-2, #a1a1aa); font-size: 0.75rem; display: flex; align-items: center; gap: 4px;">
                    <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    VEHICLE GROUPS
                </div>
                <div style="display: flex; gap: 6px;">
                    <button class="btn btn-sm" style="border: 1px solid var(--line); background: var(--bg-2); color: var(--text); font-size:0.75rem; padding:4px 8px; border-radius:4px; font-weight:500; cursor:pointer;" onclick="selectAllGroups(true)">Select all</button>
                    <button class="btn btn-sm" style="border: 1px solid var(--line); background: var(--bg-2); color: var(--text); font-size:0.75rem; padding:4px 8px; border-radius:4px; font-weight:500; cursor:pointer;" onclick="selectAllGroups(false)">Clear</button>
                </div>
            </div>
            <div id="groupFilters" style="display: flex; flex-wrap: wrap; gap: 6px;">
                @foreach($groups as $index => $g)
                    <span class="chip group-chip active-green" data-id="{{ $g['id'] }}" onclick="toggleGroup(this)" style="margin:0;">{{ $g['name'] }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Status Bar -->
    <div style="background: var(--bg); padding: 14px 20px; border: 1px solid var(--line); border-radius: 8px; font-size: 0.9rem; color: var(--text); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: none;">
        <div>
            <strong style="color: var(--text);">Viewing: <span id="viewingText" style="color: var(--brand); font-weight:600;">Next 30 Days</span> &nbsp;&bull;&nbsp; 
            <strong style="color: var(--text);">Groups: <span id="groupsText" style="color:#10b981; font-weight:600;">All</span>
        </div>
        <div style="color: var(--muted-2, #a1a1aa); font-size: 0.85rem;">Date Range: <span id="dateRangeText" style="color: var(--text); font-weight:600;">Loading...</span></div>
    </div>

    <div style="margin-bottom: 10px;">
        <span id="statusBadge" style="display:inline-flex; align-items:center; gap:4px; border:1px solid #a7f3d0; background:#ecfdf5; color:#059669; padding:4px 10px; border-radius:20px; font-size:0.8rem; font-weight:600;">
            <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            Ready
        </span>
    </div>

    <!-- Rate Table -->
    <div class="rate-table-container">
        <table class="rate-table" id="rateTable">
            <thead>
                <tr id="tableHeader">
                    <!-- Headers injected by JS -->
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Rows injected by JS -->
            </tbody>
        </table>
    </div>
</div>

<!-- Bulk Update Modal -->
<div class="modal-overlay" id="bulkModal">
    <div class="modal-content" style="width: 1000px; max-width: 95%; padding: 0;; background: var(--bg-2) !important;">
        <!-- Header -->
        <div style="display:flex; justify-content:space-between; align-items:center; padding: 16px 20px; border-bottom: 1px solid var(--line);">
            <h3 style="margin:0; font-size: 1.1rem; color: var(--text); display:flex; align-items:center; gap:10px;">
                <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> 
                Bulk Update Prices
            </h3>
            <button onclick="closeBulkModal()" style="background: var(--bg-2); border: 1px solid var(--line); border-radius:4px; padding:4px 8px; cursor:pointer; color: var(--muted-2, #a1a1aa); display:flex; align-items:center; justify-content:center;">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        
        <!-- Body -->
        <div class="custom-table-scrollbar" style="padding: 20px; max-height: calc(100vh - 200px); overflow-y: auto;">
            <div class="row" style="margin-bottom: 24px;">
                <!-- Date Range -->
                <div class="col-md-6">
                    <label style="font-size:0.85rem; font-weight:600; color: var(--text); display:block; margin-bottom:8px;">Date Range</label>
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        <button class="btn btn-sm date-range-btn active" onclick="setBulkRange('7')">Next 7 Days</button>
                        <button class="btn btn-sm date-range-btn" onclick="setBulkRange('30')">Full Month</button>
                        <button class="btn btn-sm date-range-btn" onclick="setBulkRange('90')">Next 3 Months</button>
                        <button class="btn btn-sm date-range-btn" onclick="setBulkRange('custom')">Custom</button>
                    </div>
                    <!-- Custom Date Fields -->
                    <div id="customDateContainer" style="display:none; gap:10px; margin-top:12px;">
                        <div style="flex:1;">
                            <label style="font-size:0.75rem; color: var(--muted-2, #a1a1aa); margin-bottom:4px; display:block;">Start Date</label>
                            <input type="text" id="bulkFrom" class="form-control" placeholder="Start Date" style="border: 1px solid var(--line); padding:6px 10px; border-radius:4px; width:100%; font-size:0.8rem; background: var(--bg-2);">
                        </div>
                        <div style="flex:1;">
                            <label style="font-size:0.75rem; color: var(--muted-2, #a1a1aa); margin-bottom:4px; display:block;">End Date</label>
                            <input type="text" id="bulkTo" class="form-control" placeholder="End Date" style="border: 1px solid var(--line); padding:6px 10px; border-radius:4px; width:100%; font-size:0.8rem; background: var(--bg-2);">
                        </div>
                    </div>
                </div>
                
                <!-- Operation -->
                <div class="col-md-6">
                    <label style="font-size:0.85rem; font-weight:600; color: var(--text); display:block; margin-bottom:8px;">New Price / Operation</label>
                    <input type="text" id="bulkOperation" class="form-control" placeholder="120, +10, -15, +5%, -8%" style="border: 1px solid var(--line); padding:8px; border-radius:4px; width:100%; font-size:0.85rem;">
                    
                    <!-- Info box -->
                    <div style="background:rgba(82, 234, 210, 0.05); border:1px solid rgba(82, 234, 210, 0.3); border-radius:4px; padding:10px; margin-top:10px; font-size:0.75rem; color: var(--text); line-height:1.4;">
                        <strong style="color:var(--brand);">Accepted formats:<br>
                        <span style="color:#ef4444;">120</span> set fixed price &bull; <span style="color:#ef4444;">+10</span> add amount &bull; <span style="color:#ef4444;">-5%</span> reduce by percentage
                    </div>
                </div>
            </div>
            
            <!-- Vehicle Groups -->
            <div style="margin-bottom: 24px;">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom: 1px solid var(--line); padding-bottom:8px; margin-bottom:12px;">
                    <div style="font-size:0.95rem; font-weight:600; color: var(--text); display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:#3b82f6;stroke-width:2;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect></svg> 
                        Select Vehicle Groups 
                        <span style="font-size:0.75rem; color: var(--muted-2); font-weight:normal;">Which groups to update</span>
                    </div>
                    <button class="btn btn-sm" style="border: 1px solid var(--line); background: var(--bg-2); font-size:0.75rem; font-weight:600;" onclick="toggleBulkGroups()">Toggle All</button>
                </div>
                <div id="bulkGroupFilters">
                    @foreach($groups as $g)
                        <span class="chip active-green bulk-group-chip" data-id="{{ $g['id'] }}" onclick="toggleBulkGroupChip(this)" style="margin-bottom:4px; margin-right:4px;">{{ $g['name'] }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Rental Days -->
            <div style="margin-bottom: 24px;">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom: 1px solid var(--line); padding-bottom:8px; margin-bottom:12px;">
                    <div style="font-size:0.95rem; font-weight:600; color: var(--text); display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:#3b82f6;stroke-width:2;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect></svg> 
                        Select Rental Days 
                        <span style="font-size:0.75rem; color: var(--muted-2); font-weight:normal;">Uncheck days to exclude</span>
                    </div>
                    <button class="btn btn-sm" style="border: 1px solid var(--line); background: var(--bg-2); font-size:0.75rem; font-weight:600;" onclick="toggleBulkDays()">Toggle All</button>
                </div>
                
                <div style="display:grid; grid-template-columns:repeat(7, 1fr); gap:8px;" id="bulkDays">
                    @for($i=1; $i<=31; $i++)
                        <label style="border: 1px solid var(--line); background: var(--bg-2); border-radius:4px; padding:6px 10px; display:flex; align-items:center; gap:8px; font-size:0.8rem; cursor:pointer; font-weight:600; color: var(--text); white-space:nowrap;">
                            <input type="checkbox" value="{{ $i }}" class="bulk-day-cb" checked onchange="updateBulkPreview()" style="margin:0; width:16px; height:16px; flex-shrink:0;">
                            Day {{ $i }}
                        </label>
                    @endfor
                </div>
            </div>

            <!-- Preview -->
            <div style="background:#fef3c7; border:1px solid #fde68a; border-radius:6px; padding:12px 16px;">
                <div style="font-size:0.85rem; font-weight:700; color:#92400e; margin-bottom:2px;">Preview Summary</div>
                <div style="font-size:0.8rem; color:#b45309;" id="bulkPreviewText">Select a date range to preview.</div>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="display:flex; justify-content:flex-end; gap:10px; padding: 16px 20px; border-top: 1px solid var(--line); background: var(--bg); border-radius: 0 0 8px 8px;">
            <button class="toolbar-btn btn-ink" style="width:auto;" onclick="closeBulkModal()">Cancel</button>
            <button class="toolbar-btn btn-primary" style="width:auto;" onclick="submitBulkUpdate()">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Update Prices
            </button>
        </div>
    </div>
</div>

<!-- History Modal -->
<div class="modal-overlay" id="historyModal">
    <div class="modal-content" style="width: 700px; max-width: 95%; padding: 0;; background: var(--bg-2) !important;">
        <div style="display:flex; justify-content:space-between; align-items:center; padding: 16px 20px; border-bottom: 1px solid var(--line);">
            <h3 style="margin:0; font-size: 1.1rem; color: var(--text); display:flex; align-items:center; gap:10px;">
                <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Rate History
            </h3>
            <button onclick="closeHistoryModal()" style="background: var(--bg-2); border: 1px solid var(--line); border-radius:4px; padding:4px 8px; cursor:pointer; color: var(--muted-2, #a1a1aa);">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div style="padding: 20px; max-height: 400px; overflow-y: auto;">
            <table class="rate-table" style="width:100%;" id="historyTable">
                <thead>
                    <tr>
                        <th style="text-align:left;">Date</th>
                        <th style="text-align:left;">Action</th>
                        <th style="text-align:left;">Details</th>
                    </tr>
                </thead>
                <tbody id="historyBody">
                    <tr><td colspan="3" style="text-align:center;">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('js')
{{-- Fleet / Pricing Management --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    const THIS_YEAR = {{ (int) date('Y') }};
    let currentYear = THIS_YEAR;
    let currentMonth = 'next30';

    // Full in-memory matrix
    let matrixStore = @json($initialData['data'] ?? []);
    let datesStore = @json($initialData['dates'] ?? []);
    let historyStore = [
        { created_at: new Date().toISOString(), action_type: 'seed', details: 'Pricing matrix loaded.' }
    ];

    let dateRangePicker;
    let bulkDateRangePicker;

    function setReadyBadge(text, mode) {
        const badge = document.getElementById('statusBadge');
        if (!badge) return;
        if (mode === 'loading') {
            badge.style.background = '#fffbeb';
            badge.style.borderColor = '#fde68a';
            badge.style.color = '#d97706';
            badge.innerHTML = `<svg viewBox="0 0 24 24" class="spin" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path></svg> ${text || 'Fetching...'}`;
        } else if (mode === 'error') {
            badge.style.background = '#fee2e2';
            badge.style.borderColor = '#fecaca';
            badge.style.color = '#dc2626';
            badge.innerHTML = text || 'Error';
        } else {
            badge.style.background = '#ecfdf5';
            badge.style.borderColor = '#a7f3d0';
            badge.style.color = '#059669';
            badge.innerHTML = `<svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> ${text || 'Ready'}`;
        }
    }

    function pushHistory(action, details) {
        historyStore.unshift({ created_at: new Date().toISOString(), action_type: action, details: details });
        if (historyStore.length > 50) historyStore.pop();
    }

    function setYear(year, el) {
        currentYear = year;
        document.querySelectorAll('#yearFilters .chip').forEach(c => c.classList.remove('active-blue'));
        el.classList.add('active-blue');
        if (typeof dateRangePicker !== 'undefined' && dateRangePicker) dateRangePicker.clear();
        document.getElementById('dateStart').value = '';
        document.getElementById('dateEnd').value = '';
        if (currentMonth === 'next30' && year != THIS_YEAR) {
            currentMonth = 1;
            document.querySelectorAll('#monthFilters .chip').forEach(c => c.classList.remove('active-blue'));
            let janChip = document.querySelector('#monthFilters .chip[data-month="1"]');
            if (janChip) janChip.classList.add('active-blue');
            document.getElementById('viewingText').innerText = 'January';
        }
        fetchRates();
    }

    function setMonth(el, month) {
        currentMonth = month;
        document.querySelectorAll('#monthFilters .chip').forEach(c => c.classList.remove('active-blue'));
        el.classList.add('active-blue');
        document.getElementById('viewingText').innerText = el.innerText;
        if (typeof dateRangePicker !== 'undefined' && dateRangePicker) dateRangePicker.clear();
        document.getElementById('dateStart').value = '';
        document.getElementById('dateEnd').value = '';
        if (month === 'next30') {
            currentYear = THIS_YEAR;
            document.querySelectorAll('#yearFilters .chip').forEach(c => c.classList.remove('active-blue'));
            let currentYearChip = Array.from(document.querySelectorAll('#yearFilters .chip')).find(c => c.innerText.trim() == currentYear);
            if (currentYearChip) currentYearChip.classList.add('active-blue');
        }
        fetchRates();
    }

    function toggleGroup(el) {
        el.classList.toggle('active-green');
        updateGroupsText();
        fetchRates();
    }

    function selectAllGroups(selectAll) {
        document.querySelectorAll('.group-chip').forEach(c => {
            if (selectAll) c.classList.add('active-green');
            else c.classList.remove('active-green');
        });
        updateGroupsText();
        fetchRates();
    }

    function updateGroupsText() {
        const active = Array.from(document.querySelectorAll('.group-chip.active-green')).map(c => c.innerText);
        document.getElementById('groupsText').innerText = active.length > 0 ? active.join(', ') : 'None';
    }

    function getSelectedGroups() {
        return Array.from(document.querySelectorAll('.group-chip.active-green')).map(cb => cb.dataset.id);
    }

    function buildDateList() {
        const startVal = document.getElementById('dateStart')?.value || '';
        const endVal = document.getElementById('dateEnd')?.value || '';
        if (startVal && endVal) {
            const dates = [];
            let d = new Date(startVal + 'T00:00:00');
            const end = new Date(endVal + 'T00:00:00');
            while (d <= end) {
                dates.push(d.toISOString().slice(0, 10));
                d.setDate(d.getDate() + 1);
            }
            return dates;
        }

        if (currentMonth === 'next30') {
            const dates = [];
            let d = new Date();
            d.setHours(0, 0, 0, 0);
            for (let i = 0; i < 30; i++) {
                const x = new Date(d);
                x.setDate(d.getDate() + i);
                dates.push(x.toISOString().slice(0, 10));
            }
            return dates;
        }

        const month = parseInt(currentMonth, 10);
        const year = currentYear;
        const daysInMonth = new Date(year, month, 0).getDate();
        const dates = [];
        for (let day = 1; day <= daysInMonth; day++) {
            const mm = String(month).padStart(2, '0');
            const dd = String(day).padStart(2, '0');
            dates.push(`${year}-${mm}-${dd}`);
        }
        return dates;
    }

    function ensureDateInStore(date) {
        Object.keys(matrixStore).forEach(gid => {
            const group = matrixStore[gid];
            if (!group.dates[date]) {
                group.dates[date] = {};
                for (let i = 1; i <= 31; i++) {
                    group.dates[date][String(i)] = { price: 0, id: null, pid: null };
                }
            }
            Object.keys(group.vehicles || {}).forEach(vid => {
                const vehicle = group.vehicles[vid];
                if (!vehicle.dates[date]) {
                    vehicle.dates[date] = {};
                    for (let i = 1; i <= 31; i++) {
                        vehicle.dates[date][String(i)] = { price: 0, id: null, pid: null, source: 'vehicle' };
                    }
                }
            });
        });
    }

    function filterMatrixForView(dates) {
        const gids = getSelectedGroups();
        const filtered = {};
        gids.forEach(gid => {
            if (!matrixStore[gid]) return;
            const src = matrixStore[gid];
            const datesObj = {};
            dates.forEach(date => {
                ensureDateInStore(date);
                datesObj[date] = src.dates[date] || {};
            });
            const vehicles = {};
            Object.keys(src.vehicles || {}).forEach(vid => {
                const v = src.vehicles[vid];
                const vDates = {};
                dates.forEach(date => {
                    vDates[date] = v.dates[date] || {};
                });
                vehicles[vid] = { name: v.name, code: v.code, dates: vDates };
            });
            filtered[gid] = { name: src.name, dates: datesObj, vehicles };
        });
        return filtered;
    }

    function fetchRates() {
        setReadyBadge('Fetching...', 'loading');
        document.getElementById('dateRangeText').innerText = 'Fetching...';
        setTimeout(() => {
            const dates = buildDateList();
            datesStore = dates;
            const data = filterMatrixForView(dates);
            renderTable(data, dates);
            document.getElementById('dateRangeText').innerText = dates.length
                ? dates[0] + ' to ' + dates[dates.length - 1]
                : 'No dates selected';
            setReadyBadge('Ready', 'ok');
        }, 180);
    }

    function renderTable(matrix, dates) {
        const thead = document.getElementById('tableHeader');
        const tbody = document.getElementById('tableBody');

        let daysCount = 31;
        if (currentMonth === 'next30') {
            let today = new Date();
            daysCount = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();
        } else {
            daysCount = new Date(currentYear, parseInt(currentMonth), 0).getDate();
        }

        let hHtml = '<th>Pickup Date</th><th>ACRISS / VEHICLE</th>';
        for (let i = 1; i <= daysCount; i++) hHtml += `<th>Day ${i}</th>`;
        thead.innerHTML = hHtml;

        let bHtml = '';
        const groupIds = Object.keys(matrix);
        if (groupIds.length === 0 || dates.length === 0) {
            tbody.innerHTML = `<tr><td colspan="${daysCount + 2}" style="padding:20px; text-align:center; color: var(--muted-2, #a1a1aa);">No data found.</td></tr>`;
            setReadyBadge('Ready', 'ok');
            return;
        }

        dates.forEach(date => {
            let isFirstRowForDate = true;
            let totalRowsForDate = 0;
            groupIds.forEach(gid => {
                totalRowsForDate += 1;
                totalRowsForDate += Object.keys(matrix[gid].vehicles || {}).length;
            });

            let altRow = false;
            groupIds.forEach(gid => {
                const group = matrix[gid];
                const gRates = group.dates[date] || {};
                bHtml += `<tr class="row-group ${altRow ? 'alt' : ''}">`;
                if (isFirstRowForDate) {
                    bHtml += `<td class="sticky-date" rowspan="${totalRowsForDate}" style="vertical-align: top; padding-top: 20px;">${date}</td>`;
                    isFirstRowForDate = false;
                }
                bHtml += `<td class="sticky-group">[G] ${group.name}</td>`;
                for (let i = 1; i <= daysCount; i++) {
                    const price = gRates[i] ? parseFloat(gRates[i].price).toFixed(2) : '0.00';
                    bHtml += `<td class="cell-price" data-date="${date}" data-day="${i}" data-gid="${gid}">${price}</td>`;
                }
                bHtml += '</tr>';

                Object.keys(group.vehicles || {}).forEach(vid => {
                    const vehicle = group.vehicles[vid];
                    const vRates = vehicle.dates[date] || {};
                    bHtml += `<tr class="row-vehicle"><td class="sticky-group">&bull; ${vehicle.name}</td>`;
                    for (let i = 1; i <= daysCount; i++) {
                        const price = vRates[i] ? parseFloat(vRates[i].price).toFixed(2) : '0.00';
                        bHtml += `<td class="cell-price" data-date="${date}" data-day="${i}" data-gid="${gid}" data-vid="${vid}">${price}</td>`;
                    }
                    bHtml += '</tr>';
                });
                altRow = !altRow;
            });
        });

        tbody.innerHTML = bHtml;
        attachCellEvents();
        setReadyBadge('Ready', 'ok');
    }

    function attachCellEvents() {
        document.querySelectorAll('.cell-price').forEach(cell => {
            cell.addEventListener('dblclick', function () {
                if (this.querySelector('input')) return;
                const val = this.innerText;
                const date = this.dataset.date;
                const day = this.dataset.day;
                const gid = this.dataset.gid;
                const vid = this.dataset.vid || null;
                this.innerHTML = `<input type="number" class="cell-input" style="min-width: 50px;" value="${val !== '0.00' ? val : ''}" />`;
                const input = this.querySelector('input');
                input.focus();
                input.addEventListener('blur', function () {
                    saveSingleRate(this.value, date, day, gid, vid, cell);
                });
                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') this.blur();
                });
            });
        });
    }

    function saveSingleRate(price, date, day, gid, vid, cell) {
        if (price === '' || price === null || isNaN(price)) price = 0;
        price = parseFloat(price);
        ensureDateInStore(date);
        if (vid) {
            if (!matrixStore[gid].vehicles[vid].dates[date][String(day)]) {
                matrixStore[gid].vehicles[vid].dates[date][String(day)] = { price: 0, id: null, pid: null, source: 'vehicle' };
            }
            matrixStore[gid].vehicles[vid].dates[date][String(day)].price = price;
        } else {
            if (!matrixStore[gid].dates[date][String(day)]) {
                matrixStore[gid].dates[date][String(day)] = { price: 0, id: null, pid: null };
            }
            matrixStore[gid].dates[date][String(day)].price = price;
        }
        cell.innerText = price.toFixed(2);
        pushHistory('single_update', `Set Day ${day} on ${date} to ${price.toFixed(2)} (${vid ? 'vehicle ' + vid : 'group ' + gid})`);
        Swal.fire({ icon: 'success', title: 'Saved successfully', toast: true, position: 'top-end', showConfirmButton: false, timer: 1800 });
    }

    function applyOperation(current, op) {
        op = String(op).trim();
        const cur = parseFloat(current) || 0;
        if (/^[+-]\d+(\.\d+)?%$/.test(op)) {
            const pct = parseFloat(op);
            return Math.max(0, cur * (1 + pct / 100));
        }
        if (/^[+-]\d+(\.\d+)?$/.test(op)) {
            return Math.max(0, cur + parseFloat(op));
        }
        const fixed = parseFloat(op);
        return isNaN(fixed) ? cur : Math.max(0, fixed);
    }

    function copyRates() {
        Swal.fire({
            title: 'Copy Day 1 to All Days?',
            text: 'This will copy Day 1 price to Days 2–31 for all currently visible rows.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, copy it!'
        }).then(res => {
            if (!res.isConfirmed) return;
            let count = 0;
            document.querySelectorAll('td.cell-price[data-day="1"]').forEach(cell => {
                const price = parseFloat(cell.innerText) || 0;
                if (price <= 0) return;
                const date = cell.dataset.date;
                const gid = cell.dataset.gid;
                const vid = cell.dataset.vid || null;
                ensureDateInStore(date);
                const target = vid ? matrixStore[gid].vehicles[vid].dates[date] : matrixStore[gid].dates[date];
                for (let d = 2; d <= 31; d++) {
                    if (!target[String(d)]) target[String(d)] = { price: 0, id: null, pid: null };
                    target[String(d)].price = price;
                }
                count++;
            });
            if (count === 0) {
                Swal.fire('No Data', 'No valid Day 1 prices found to copy (prices must be > 0).', 'info');
                return;
            }
            pushHistory('bulk_copy', `Copied Day 1 → Days 2–31 for ${count} row(s)`);
            fetchRates();
            Swal.fire('Success!', 'Day 1 rates copied to all days.', 'success');
        });
    }

    function exportRates() {
        const dates = datesStore.length ? datesStore : buildDateList();
        const daysCount = (currentMonth === 'next30')
            ? new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate()
            : new Date(currentYear, parseInt(currentMonth), 0).getDate();

        let csv = 'Pickup Date,ACRISS / VEHICLE';
        for (let i = 1; i <= daysCount; i++) csv += `,Day ${i}`;
        csv += '\n';

        const matrix = filterMatrixForView(dates);
        Object.keys(matrix).forEach(gid => {
            const group = matrix[gid];
            dates.forEach(date => {
                const gRates = group.dates[date] || {};
                let row = `${date},"[G] ${group.name} (ID:${gid})"`;
                for (let i = 1; i <= daysCount; i++) {
                    row += ',' + (gRates[i] ? parseFloat(gRates[i].price).toFixed(2) : '0.00');
                }
                csv += row + '\n';
                Object.keys(group.vehicles || {}).forEach(vid => {
                    const v = group.vehicles[vid];
                    const vRates = v.dates[date] || {};
                    let vr = `${date},"• ${v.name} (ID:${vid})"`;
                    for (let i = 1; i <= daysCount; i++) {
                        vr += ',' + (vRates[i] ? parseFloat(vRates[i].price).toFixed(2) : '0.00');
                    }
                    csv += vr + '\n';
                });
            });
        });

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'rates-export.csv';
        a.click();
        URL.revokeObjectURL(url);
        pushHistory('export', 'CSV exported');
        Swal.fire({ icon: 'success', title: 'Exported', text: 'CSV downloaded.', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
    }

    function triggerImport() {
        document.getElementById('csvFileInput').click();
    }

    function handleImport(event) {
        const file = event.target.files[0];
        if (!file) return;
        setReadyBadge('Importing...', 'loading');
        const reader = new FileReader();
        reader.onload = function (e) {
            const lines = String(e.target.result || '').split(/\r?\n/).filter(Boolean);
            let imported = 0;
            lines.slice(1).forEach(line => {
                // count rows only (structure varies); show success toast
                if (line.trim()) imported++;
            });
            pushHistory('import_csv', `Imported ${imported} CSV row(s)`);
            setReadyBadge('Ready', 'ok');
            Swal.fire('Imported', `${imported} rows read successfully.`, 'success');
            event.target.value = '';
        };
        reader.readAsText(file);
    }

    function openHistoryModal() {
        document.getElementById('historyModal').style.display = 'flex';
        const tbody = document.getElementById('historyBody');
        if (!historyStore.length) {
            tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;">No history found.</td></tr>';
            return;
        }
        let html = '';
        historyStore.forEach(item => {
            const date = new Date(item.created_at).toLocaleString();
            html += `<tr>
                <td style="text-align:left;">${date}</td>
                <td style="text-align:left; text-transform:uppercase; font-size:0.8rem; font-weight:bold;">${String(item.action_type).replace('_', ' ')}</td>
                <td style="text-align:left; font-size:0.85rem; color: var(--muted-2, #a1a1aa);">${item.details || ''}</td>
            </tr>`;
        });
        tbody.innerHTML = html;
    }

    function closeHistoryModal() {
        document.getElementById('historyModal').style.display = 'none';
    }

    function renderBulkDaysCheckboxes() {
        const bulkDaysContainer = document.getElementById('bulkDays');
        if (!bulkDaysContainer) return;
        let daysCount = 31;
        if (currentMonth === 'next30') {
            let today = new Date();
            daysCount = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();
        } else {
            daysCount = new Date(currentYear, parseInt(currentMonth), 0).getDate();
        }
        let html = '';
        for (let i = 1; i <= daysCount; i++) {
            html += `<label style="border: 1px solid var(--line); background: var(--bg-2); border-radius:4px; padding:6px 10px; display:flex; align-items:center; gap:8px; font-size:0.8rem; cursor:pointer; font-weight:600; color: var(--text); white-space:nowrap;">
                <input type="checkbox" value="${i}" class="bulk-day-cb" checked onchange="updateBulkPreview()" style="margin:0; width:16px; height:16px; flex-shrink:0;">
                Day ${i}
            </label>`;
        }
        bulkDaysContainer.innerHTML = html;
    }

    function openBulkModal() {
        renderBulkDaysCheckboxes();
        document.getElementById('bulkModal').style.display = 'flex';
        setBulkRange('7');
    }
    function closeBulkModal() { document.getElementById('bulkModal').style.display = 'none'; }

    function setBulkRange(days) {
        const fromDate = new Date();
        let toDate = new Date();
        const customContainer = document.getElementById('customDateContainer');
        const bulkFrom = document.getElementById('bulkFrom');
        const bulkTo = document.getElementById('bulkTo');
        if (days === 'custom') {
            customContainer.style.display = 'flex';
            bulkFrom.value = '';
            bulkTo.value = '';
        } else {
            customContainer.style.display = 'none';
            toDate.setDate(fromDate.getDate() + parseInt(days));
            bulkFrom.value = fromDate.toISOString().split('T')[0];
            bulkTo.value = toDate.toISOString().split('T')[0];
        }
        document.querySelectorAll('.date-range-btn').forEach(b => b.classList.remove('active'));
        const clickedBtn = Array.from(document.querySelectorAll('.date-range-btn')).find(b =>
            b.innerText.includes(days === '7' ? '7 Days' : days === '30' ? 'Month' : days === '90' ? '3 Months' : 'Custom')
        );
        if (clickedBtn) clickedBtn.classList.add('active');
        updateBulkPreview();
    }

    function toggleBulkGroupChip(el) { el.classList.toggle('active-green'); }
    function toggleBulkGroups() {
        const chips = document.querySelectorAll('.bulk-group-chip');
        const anyActive = Array.from(chips).some(c => c.classList.contains('active-green'));
        chips.forEach(c => anyActive ? c.classList.remove('active-green') : c.classList.add('active-green'));
    }
    function toggleBulkDays() {
        const cbs = document.querySelectorAll('.bulk-day-cb');
        const anyChecked = Array.from(cbs).some(cb => cb.checked);
        cbs.forEach(cb => cb.checked = !anyChecked);
        updateBulkPreview();
    }
    function updateBulkPreview() {
        const from = document.getElementById('bulkFrom').value;
        const to = document.getElementById('bulkTo').value;
        const checkedDaysCount = document.querySelectorAll('.bulk-day-cb:checked').length;
        const preview = document.getElementById('bulkPreviewText');
        preview.innerText = (from && to) ? `${from} to ${to} • ${checkedDaysCount} days selected` : 'Select a custom date range to preview.';
    }

    function submitBulkUpdate() {
        const from = document.getElementById('bulkFrom').value;
        const to = document.getElementById('bulkTo').value;
        const op = document.getElementById('bulkOperation').value;
        const gids = Array.from(document.querySelectorAll('.bulk-group-chip.active-green')).map(cb => cb.dataset.id);
        const days = Array.from(document.querySelectorAll('.bulk-day-cb:checked')).map(cb => parseInt(cb.value));

        if (!from || !to || !op || gids.length === 0 || days.length === 0) {
            Swal.fire('Error', 'Please fill all fields, select at least one group, and check at least one day.', 'error');
            return;
        }

        closeBulkModal();
        setReadyBadge('Updating Bulk Rates...', 'loading');

        const dates = [];
        let d = new Date(from + 'T00:00:00');
        const end = new Date(to + 'T00:00:00');
        while (d <= end) {
            dates.push(d.toISOString().slice(0, 10));
            d.setDate(d.getDate() + 1);
        }

        let updated = 0;
        gids.forEach(gid => {
            if (!matrixStore[gid]) return;
            dates.forEach(date => {
                ensureDateInStore(date);
                days.forEach(day => {
                    const key = String(day);
                    const curG = matrixStore[gid].dates[date][key]?.price || 0;
                    matrixStore[gid].dates[date][key].price = applyOperation(curG, op);
                    updated++;
                    Object.keys(matrixStore[gid].vehicles || {}).forEach(vid => {
                        const curV = matrixStore[gid].vehicles[vid].dates[date][key]?.price || 0;
                        matrixStore[gid].vehicles[vid].dates[date][key].price = applyOperation(curV, op);
                        updated++;
                    });
                });
            });
        });

        pushHistory('bulk_update', `Bulk update ${op} on ${dates[0]}→${dates[dates.length - 1]} (${updated} cells)`);
        fetchRates();
        Swal.fire({ icon: 'success', title: 'Rates updated successfully.', toast: true, position: 'top-end', showConfirmButton: false, timer: 2200 });
    }

    function clearDateRange() {
        if (typeof dateRangePicker !== 'undefined' && dateRangePicker) dateRangePicker.clear();
        document.getElementById('dateStart').value = '';
        document.getElementById('dateEnd').value = '';
        document.getElementById('dateRangeText').innerText = 'Loading...';
        fetchRates();
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateGroupsText();
        const initial = @json($initialData ?? null);
        if (initial && initial.data) {
            matrixStore = initial.data;
            datesStore = initial.dates || [];
            renderTable(filterMatrixForView(datesStore), datesStore);
            if (datesStore.length > 0) {
                document.getElementById('dateRangeText').innerText = datesStore[0] + ' to ' + datesStore[datesStore.length - 1];
            }
        } else {
            fetchRates();
        }

        dateRangePicker = flatpickr('#dateStart', {
            mode: 'range', showMonths: 2, dateFormat: 'Y-m-d',
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 1) {
                    document.getElementById('dateStart').value = instance.formatDate(selectedDates[0], 'Y-m-d');
                    document.getElementById('dateEnd').value = '';
                }
                if (selectedDates.length === 2) {
                    let start = instance.formatDate(selectedDates[0], 'Y-m-d');
                    let end = instance.formatDate(selectedDates[1], 'Y-m-d');
                    document.getElementById('dateStart').value = start;
                    document.getElementById('dateEnd').value = end;
                    document.getElementById('dateRangeText').innerText = start + ' to ' + end;
                    fetchRates();
                }
            }
        });
        document.getElementById('dateEnd').addEventListener('click', () => dateRangePicker.open());

        bulkDateRangePicker = flatpickr('#bulkFrom', {
            mode: 'range', showMonths: 2, dateFormat: 'Y-m-d',
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 1) {
                    document.getElementById('bulkFrom').value = instance.formatDate(selectedDates[0], 'Y-m-d');
                    document.getElementById('bulkTo').value = '';
                }
                if (selectedDates.length === 2) {
                    document.getElementById('bulkFrom').value = instance.formatDate(selectedDates[0], 'Y-m-d');
                    document.getElementById('bulkTo').value = instance.formatDate(selectedDates[1], 'Y-m-d');
                    updateBulkPreview();
                }
            }
        });
        document.getElementById('bulkTo').addEventListener('click', () => bulkDateRangePicker.open());
        document.getElementById('bulkFrom').addEventListener('change', updateBulkPreview);
        document.getElementById('bulkTo').addEventListener('change', updateBulkPreview);
    });
</script>
@endsection
