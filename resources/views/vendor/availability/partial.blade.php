
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
        overflow-x: auto;
        overflow-y: auto;
        max-height: 400px;
        width: 100%;
        max-width: 100%;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 8px;
        position: relative;
    }
    .rate-table {
        width: 100%;
        min-width: 1500px;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.85rem;
    }
    .rate-table th {
        background: var(--table-head);
        color: #fff;
        padding: 8px 10px;
        font-weight: 600;
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
        text-align: center;
        border-bottom: 2px solid var(--line-dark);
        font-size: 0.8rem;
    }
    .rate-table th:nth-child(1) { left: 0; z-index: 11; width: 100px; }
    .rate-table th:nth-child(2) { 
        left: 100px; 
        z-index: 11; 
        width: 180px; 
        box-shadow: 4px 0px 8px -2px rgba(0,0,0,0.5);
    }
    
    /* Day Column Colors (Solid) */
    .rate-table th:nth-child(odd):not(:nth-child(1)) {
        background: #0b1020 !important;
        color: #fff !important;
        border-bottom-color: var(--line-dark);
    }
    .rate-table th:nth-child(even):not(:nth-child(2)) {
        background: #0b1020 !important;
        color: #fff !important;
        border-bottom-color: var(--line-dark);
    }

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
        box-shadow: 4px 0px 8px -2px rgba(0,0,0,0.5);
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
    .row-group td.sticky-group { background: rgba(225, 29, 72, 0.1) !important; color: #fda4af !important; }
    
    .row-vehicle td { background: rgba(202, 138, 4, 0.1) !important; color: #fde047 !important; }
    .row-vehicle td.sticky-group { background: rgba(202, 138, 4, 0.1) !important; color: #fde047 !important; }

    .row-group.alt td { background: rgba(3, 105, 161, 0.1) !important; color: #7dd3fc !important; }
    .row-group.alt td.sticky-group { background: rgba(3, 105, 161, 0.1) !important; color: #7dd3fc !important; }

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

<div class="admin-panel" style="padding: 10px; background: var(--bg); max-width: 100%; overflow-x: hidden; box-sizing: border-box;">
    
    <div style="background: var(--bg-2); border-radius: 6px; border: 1px solid var(--line); padding: 10px; margin-bottom: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <h2 style="margin: 0; font-size: 1.1rem; color: var(--text); font-weight: 700; text-align: center;">Pricing Management</h2>
        <span style="margin-top: 2px; font-size: 0.75rem; color: var(--muted-2, #a1a1aa); text-align: center; display: block;">Fleet & Rates</span>
    </div>

    
    <div style="background: var(--bg-2); border-radius: 6px; border: 1px solid var(--line); padding: 8px; margin-bottom: 10px; display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px;">
        <button class="toolbar-btn btn-primary" onclick="openBulkModal()" style="padding: 8px; font-size: 0.85rem;">
            <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
            Update Prices
        </button>
        <button class="toolbar-btn btn-success" onclick="copyRates()" style="padding: 8px; font-size: 0.85rem;">
            <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
            Copy Rates
        </button>
        <button class="toolbar-btn btn-ink" onclick="exportRates()" style="padding: 8px; font-size: 0.85rem;">
            <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Export
        </button>
        <button class="toolbar-btn btn-ink" onclick="triggerImport()" style="padding: 8px; font-size: 0.85rem;">
            <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
            Import
        </button>
        <input type="file" id="csvFileInput" style="display: none;" accept=".csv" onchange="handleImport(event)">
        <button class="toolbar-btn btn-violet" onclick="openHistoryModal()" style="padding: 8px; font-size: 0.85rem;">
            <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            View History
        </button>
    </div>

    
    <div style="display: grid; grid-template-columns: 1fr 1.5fr 2fr; gap: 10px; margin-bottom: 10px;">
        
        
        <div style="background: var(--bg-2); border-radius: 6px; border: 1px solid var(--line); padding: 10px;">
            <div class="filter-title" style="margin-bottom: 6px; color: var(--muted-2, #a1a1aa); font-size: 0.7rem;">YEAR</div>
            <div id="yearFilters" style="margin-bottom: 10px;">
                @php $currentYear = (int)date('Y'); @endphp
                @for($y = $currentYear - 1; $y <= $currentYear + 1; $y++)
                    <span class="chip {{ $y === $currentYear ? 'active-blue' : '' }}" onclick="setYear({{ $y }}, this)">{{ $y }}</span>
                @endfor
            </div>
            
            <div style="border-top: 1px dashed #cbd5e1; margin-bottom: 10px;"></div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <div class="filter-title" style="margin: 0; color: var(--muted-2, #a1a1aa); font-size: 0.7rem;">DATE RANGE</div>
                <button class="btn btn-sm" style="border: 1px solid var(--line); background: var(--bg-2); color: var(--text); font-size:0.65rem; padding:2px 6px; border-radius:4px; font-weight:500; cursor:pointer;" onclick="clearDateRange()">Clear</button>
            </div>
            <div style="display: flex; gap: 8px;">
                <input type="text" id="dateStart" class="form-control date-input" placeholder="Start" style="flex: 1; padding: 4px 6px; font-size: 0.8rem; border-radius: 4px; background-color: var(--bg-2); text-align: center;">
                <input type="text" id="dateEnd" class="form-control date-input" placeholder="End" style="flex: 1; padding: 4px 6px; font-size: 0.8rem; border-radius: 4px; background-color: var(--bg-2); text-align: center;">
            </div>
        </div>

        
        <div style="background: var(--bg-2); border-radius: 6px; border: 1px solid var(--line); padding: 10px;">
            <div class="filter-title" style="margin-bottom: 6px; color: var(--muted-2, #a1a1aa); font-size: 0.7rem;">MONTH</div>
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

        @if(!isset($singleVehicleMode) || !$singleVehicleMode)
        
        <div style="background: var(--bg-2); border-radius: 6px; border: 1px solid var(--line); padding: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <div class="filter-title" style="margin: 0; color: var(--muted-2, #a1a1aa); font-size: 0.7rem; display: flex; align-items: center; gap: 4px;">
                    <svg viewBox="0 0 24 24" style="width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    VEHICLE GROUPS
                </div>
                <div style="display: flex; gap: 6px;">
                    <button class="btn btn-sm" style="border: 1px solid var(--line); background: var(--bg-2); color: var(--text); font-size:0.65rem; padding:2px 6px; border-radius:4px; font-weight:500; cursor:pointer;" onclick="selectAllGroups(true)">Select all</button>
                    <button class="btn btn-sm" style="border: 1px solid var(--line); background: var(--bg-2); color: var(--text); font-size:0.65rem; padding:2px 6px; border-radius:4px; font-weight:500; cursor:pointer;" onclick="selectAllGroups(false)">Clear</button>
                </div>
            </div>
            <div id="groupFilters" style="display: flex; flex-wrap: wrap; gap: 4px;">
                @foreach($groups as $index => $g)
                    <span class="chip group-chip active-green" data-id="{{ $g->id }}" onclick="toggleGroup(this)" style="margin:0;">{{ $g->name }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    
    <div style="background: var(--bg); padding: 10px 15px; border: 1px solid var(--line); border-radius: 8px; font-size: 0.85rem; color: var(--text); margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; box-shadow: none;">
        <div>
            <strong style="color: var(--text);">Viewing: <span id="viewingText" style="color: var(--brand); font-weight:600;">Next 30 Days</span> &nbsp;&bull;&nbsp; 
            @if(!isset($singleVehicleMode) || !$singleVehicleMode)
            <strong style="color: var(--text);">Groups: <span id="groupsText" style="color:#10b981; font-weight:600;">All</span>
            @endif
        </div>
        <div style="color: var(--muted-2, #a1a1aa); font-size: 0.85rem;">Date Range: <span id="dateRangeText" style="color: var(--text); font-weight:600;">Loading...</span></div>
    </div>

    <div style="margin-bottom: 10px;">
        <span id="statusBadge" style="display:inline-flex; align-items:center; gap:4px; border:1px solid #a7f3d0; background:#ecfdf5; color:#059669; padding:4px 10px; border-radius:20px; font-size:0.8rem; font-weight:600;">
            <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            Ready
        </span>
    </div>

</div>

<div class="admin-panel mt-3" style="padding: 10px; background: var(--bg); width: 100%; max-width: 100%; overflow-x: hidden; box-sizing: border-box;">
    
    <div class="rate-table-container">
        <table class="rate-table" id="rateTable">
            <thead>
                <tr id="tableHeader">
                    
                </tr>
            </thead>
            <tbody id="tableBody">
                
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay" id="bulkModal">
    <div class="modal-content" style="width: 1000px; max-width: 95%; padding: 0;; background: var(--bg-2) !important;">
        
        <div style="display:flex; justify-content:space-between; align-items:center; padding: 16px 20px; border-bottom: 1px solid var(--line);">
            <h3 style="margin:0; font-size: 1.1rem; color: var(--text); display:flex; align-items:center; gap:10px;">
                <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> 
                Bulk Update Prices
            </h3>
            <button onclick="closeBulkModal()" style="background: var(--bg-2); border: 1px solid var(--line); border-radius:4px; padding:4px 8px; cursor:pointer; color: var(--muted-2, #a1a1aa); display:flex; align-items:center; justify-content:center;">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        
        
        <div class="custom-table-scrollbar" style="padding: 20px; max-height: calc(100vh - 200px); overflow-y: auto;">
            <div class="row" style="margin-bottom: 24px;">
                
                <div class="col-md-6">
                    <label style="font-size:0.85rem; font-weight:600; color: var(--text); display:block; margin-bottom:8px;">Date Range</label>
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        <button class="btn btn-sm date-range-btn active" onclick="setBulkRange('7')">Next 7 Days</button>
                        <button class="btn btn-sm date-range-btn" onclick="setBulkRange('30')">Full Month</button>
                        <button class="btn btn-sm date-range-btn" onclick="setBulkRange('90')">Next 3 Months</button>
                        <button class="btn btn-sm date-range-btn" onclick="setBulkRange('custom')">Custom</button>
                    </div>
                    
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
                
                
                <div class="col-md-6">
                    <label style="font-size:0.85rem; font-weight:600; color: var(--text); display:block; margin-bottom:8px;">New Price / Operation</label>
                    <input type="text" id="bulkOperation" class="form-control" placeholder="120, +10, -15, +5%, -8%" style="border: 1px solid var(--line); padding:8px; border-radius:4px; width:100%; font-size:0.85rem;">
                    
                    
                    <div style="background:rgba(82, 234, 210, 0.05); border:1px solid rgba(82, 234, 210, 0.3); border-radius:4px; padding:10px; margin-top:10px; font-size:0.75rem; color: var(--text); line-height:1.4;">
                        <strong style="color:var(--brand);">Accepted formats:<br>
                        <span style="color:#ef4444;">120</span> set fixed price &bull; <span style="color:#ef4444;">+10</span> add amount &bull; <span style="color:#ef4444;">-5%</span> reduce by percentage
                    </div>
                </div>
            </div>
            
            @if(!isset($singleVehicleMode) || !$singleVehicleMode)
            
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
                        <span class="chip active-green bulk-group-chip" data-id="{{ $g->id }}" onclick="toggleBulkGroupChip(this)" style="margin-bottom:4px; margin-right:4px;">{{ $g->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            
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

            
            <div style="background:rgba(234, 179, 8, 0.1); border:1px solid rgba(234, 179, 8, 0.3); border-radius:6px; padding:12px 16px;">
                <div style="font-size:0.85rem; font-weight:700; color:#facc15; margin-bottom:2px;">Preview Summary</div>
                <div style="font-size:0.8rem; color:#fde047;" id="bulkPreviewText">Select a date range to preview.</div>
            </div>
        </div>
        
        
        <div style="display:flex; justify-content:flex-end; gap:10px; padding: 16px 20px; border-top: 1px solid var(--line); background: var(--bg); border-radius: 0 0 8px 8px;">
            <button class="toolbar-btn btn-ink" style="width:auto;" onclick="closeBulkModal()">Cancel</button>
            <button class="toolbar-btn btn-primary" style="width:auto;" onclick="submitBulkUpdate()">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:2;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Update Prices
            </button>
        </div>
    </div>
</div>

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
                const date = this.dataset.date;
                const day = this.dataset.day;
                const gid = this.dataset.gid;
                const vid = this.dataset.vid || null;
                
                this.innerHTML = `<input type="number" class="cell-input" style="min-width: 50px;" value="${val !== '0.00' ? val : ''}" />`;
                const input = this.querySelector('input');
                input.focus();
                
                input.addEventListener('blur', function() {
                    saveSingleRate(this.value, date, day, gid, vid, cell);
                });
                input.addEventListener('keydown', function(e) {
                    if(e.key === 'Enter') this.blur();
                });
            });
        });
    }

    function saveSingleRate(price, date, day, gid, vid, cell) {
        if (price === '' || price === null || isNaN(price)) {
            price = 0;
        }

        // Optimistic UI Update (immediate visual feedback)
        cell.innerText = parseFloat(price).toFixed(2);
        
        fetch('{{ route('vendor.availability.update-rate') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                date: date,
                day: day,
                price: price,
                group_id: gid,
                vehicle_id: vid,
                _token: '{{ csrf_token() }}'
            })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                // successfully saved in background
            } else {
                alert(res.message);
                cell.innerText = '0.00';
            }
        })
        .catch(err => {
            console.error(err);
            cell.innerText = 'Error';
        });
    }

    function copyRates() {
        let updates = [];
        
        let day1Cells = document.querySelectorAll('.cell-price[data-day="1"]');
        
        day1Cells.forEach(cell => {
            let price = parseFloat(cell.innerText);
            if (isNaN(price)) price = 0;
            
            let date = cell.dataset.date;
            let gid = cell.dataset.gid;
            let vid = cell.dataset.vid || null;
            
            updates.push({
                date: date,
                group_id: gid,
                vehicle_id: vid,
                price: price
            });
            
            // Optimistic UI update
            let row = cell.closest('tr');
            let otherCells = row.querySelectorAll('.cell-price');
            let formattedPrice = price.toFixed(2);
            otherCells.forEach(c => {
                c.innerText = formattedPrice;
            });
        });
        
        if (updates.length === 0) return;
        
        const badge = document.getElementById('statusBadge');
        let originalBadgeHtml = badge ? badge.innerHTML : '';
        if (badge) {
            badge.innerHTML = 'Saving...';
        }

        fetch('{{ route('vendor.availability.bulk-copy-day1') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                updates: updates,
                _token: '{{ csrf_token() }}'
            })
        })
        .then(res => res.json())
        .then(res => {
            if(badge) {
                badge.innerHTML = 'Copied successfully!';
                setTimeout(() => { badge.innerHTML = originalBadgeHtml; }, 2000);
            }
        })
        .catch(err => {
            console.error(err);
            if(badge) {
                badge.innerHTML = 'Error copying!';
                setTimeout(() => { badge.innerHTML = originalBadgeHtml; }, 2000);
            }
        });
    }

    function exportRates() {
        window.location.href = '{{ route("vendor.availability.export") }}';
    }

    function triggerImport() {
        document.getElementById('csvFileInput').click();
    }

    function handleImport(event) {
        const file = event.target.files[0];
        if (!file) return;

        const badge = document.getElementById('statusBadge');
        let originalBadgeHtml = badge ? badge.innerHTML : '';
        if (badge) badge.innerHTML = 'Importing...';

        const formData = new FormData();
        formData.append('csv_file', file);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("vendor.availability.import-csv") }}', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                if(badge) {
                    badge.innerHTML = 'Imported successfully!';
                    setTimeout(() => { badge.innerHTML = originalBadgeHtml; }, 2000);
                }
                fetchRates(); // Reload table
            } else {
                alert('Import failed: ' + (res.message || 'Unknown error'));
            }
        })
        .catch(err => {
            console.error(err);
            if(badge) {
                badge.innerHTML = 'Error importing!';
                setTimeout(() => { badge.innerHTML = originalBadgeHtml; }, 2000);
            }
        })
        .finally(() => {
            event.target.value = ''; // Reset input
        });
    }

    function openHistoryModal() {
        document.getElementById('historyModal').style.display = 'flex';
        const tbody = document.getElementById('historyBody');
        tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;">Loading...</td></tr>';
        
        fetch('{{ route("vendor.availability.history") }}')
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                if(res.history.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;">No history found.</td></tr>';
                    return;
                }
                let html = '';
                res.history.forEach(item => {
                    const date = new Date(item.created_at).toLocaleString();
                    html += `<tr>
                        <td style="text-align:left;">${date}</td>
                        <td style="text-align:left; text-transform:uppercase; font-size:0.8rem; font-weight:bold;">${item.action_type.replace('_', ' ')}</td>
                        <td style="text-align:left; font-size:0.85rem; color: var(--muted-2, #a1a1aa);">${item.details || ''}</td>
                    </tr>`;
                });
                tbody.innerHTML = html;
            }
        })
        .catch(err => console.error(err));
    }

    function closeHistoryModal() {
        document.getElementById('historyModal').style.display = 'none';
    }

    // Modal Logic
    function openBulkModal() { 
        document.getElementById('bulkModal').style.display = 'flex'; 
        setBulkRange('7'); // default selection
    }
    function closeBulkModal() { document.getElementById('bulkModal').style.display = 'none'; }
    
    function setBulkRange(days) {
        const fromDate = new Date(); // assume starting from today for preset ranges
        let toDate = new Date();
        const customContainer = document.getElementById('customDateContainer');
        const bulkFrom = document.getElementById('bulkFrom');
        const bulkTo = document.getElementById('bulkTo');
        
        if(days === 'custom') {
            customContainer.style.display = 'flex';
            // Show fields but don't set default value automatically
            bulkFrom.value = '';
            bulkTo.value = '';
        } else {
            customContainer.style.display = 'none';
            
            // For car rentals, 7 days means 8 calendar dates (e.g. 1st to 8th)
            toDate.setDate(fromDate.getDate() + parseInt(days));
            
            bulkFrom.value = fromDate.toISOString().split('T')[0];
            bulkTo.value = toDate.toISOString().split('T')[0];
        }
        
        // Update button styles exactly as per mockup
        const btns = document.querySelectorAll('.date-range-btn');
        btns.forEach(b => b.classList.remove('active'));
        const clickedBtn = Array.from(btns).find(b => b.innerText.includes(days === '7' ? '7 Days' : days === '30' ? 'Month' : days === '90' ? '3 Months' : 'Custom'));
        if(clickedBtn) {
            clickedBtn.classList.add('active');
        }
        
        updateBulkPreview();
    }
    
    function toggleBulkGroupChip(el) {
        el.classList.toggle('active-green');
    }
    
    function toggleBulkGroups() {
        const chips = document.querySelectorAll('.bulk-group-chip');
        const anyActive = Array.from(chips).some(c => c.classList.contains('active-green'));
        chips.forEach(c => {
            if(anyActive) c.classList.remove('active-green');
            else c.classList.add('active-green');
        });
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
        if(from && to) {
            preview.innerText = `${from} to ${to} • ${checkedDaysCount} days selected`;
        } else {
            preview.innerText = `Select a custom date range to preview.`;
        }
    }
    
    function submitBulkUpdate() {
        const from = document.getElementById('bulkFrom').value;
        const to = document.getElementById('bulkTo').value;
        const op = document.getElementById('bulkOperation').value;
        
        let gids = Array.from(document.querySelectorAll('.bulk-group-chip.active-green')).map(cb => cb.dataset.id);
        const days = Array.from(document.querySelectorAll('.bulk-day-cb:checked')).map(cb => parseInt(cb.value));

        if (typeof singleVehicleMode !== 'undefined' && singleVehicleMode) {
            gids = [filterGroupId]; // Use the vehicle's group ID to pass validation
        }

        if(!from || !to || !op || gids.length === 0 || days.length === 0) {
            Swal.fire('Error', 'Please fill all fields, select at least one group, and check at least one day.', 'error');
            return;
        }
        
        // 1. Close Modal immediately
        closeBulkModal();
        
        // 2. Show Loader in the Ready Badge immediately
        const badge = document.getElementById('statusBadge');
        if (badge) {
            badge.style.background = '#fffbeb';
            badge.style.borderColor = '#fde68a';
            badge.style.color = '#d97706';
            badge.innerHTML = `<svg viewBox="0 0 24 24" class="spin" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path></svg> Updating Bulk Rates...`;
        }

        fetch('{{ route('vendor.availability.bulk-update') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                from_date: from,
                to_date: to,
                operation: op,
                group_ids: gids,
                days: days,
                view_year: currentYear,
                view_month: currentMonth,
                view_groups: getSelectedGroups(),
                vehicle_id: typeof filterVehicleId !== 'undefined' ? filterVehicleId : null,
                _token: '{{ csrf_token() }}'
            })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                if(res.data) {
                    renderTable(res.data, res.dates);
                    Swal.fire({
                        icon: 'success',
                        title: 'Rates updated successfully.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    fetchRates();
                }
            } else {
                Swal.fire('Error', res.message, 'error');
                if (badge) {
                    badge.style.background = '#fee2e2';
                    badge.style.borderColor = '#fecaca';
                    badge.style.color = '#dc2626';
                    badge.innerHTML = 'Error';
                }
            }
        })
        .catch(err => {
            Swal.fire('Error', 'Failed to update rates', 'error');
            if (badge) {
                badge.style.background = '#fee2e2';
                badge.style.borderColor = '#fecaca';
                badge.style.color = '#dc2626';
                badge.innerHTML = 'Error';
            }
        });
    }

    function copyRates() {
        Swal.fire({
            title: 'Copy Day 1 to All Days?',
            text: "This will copy the price of Day 1 to Days 2-31 for all currently visible rows.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, copy it!'
        }).then(res => {
            if(res.isConfirmed) {
                // Collect day 1 data
                const updates = [];
                const day1Cells = document.querySelectorAll('td.cell-price[data-day="1"]');
                
                day1Cells.forEach(cell => {
                    const price = parseFloat(cell.innerText) || 0;
                    if (price > 0) {
                        updates.push({
                            date: cell.dataset.date,
                            price: price,
                            group_id: cell.dataset.gid,
                            vehicle_id: cell.dataset.vid || null
                        });
                    }
                });
                
                if (updates.length === 0) {
                    Swal.fire('No Data', 'No valid Day 1 prices found to copy (prices must be > 0).', 'info');
                    return;
                }
                
                Swal.fire({
                    title: 'Copying...',
                    text: 'Please wait while we update the prices.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                fetch('{{ route('vendor.availability.bulk-copy-day1') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        updates: updates,
                        _token: '{{ csrf_token() }}'
                    })
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        Swal.fire('Success!', 'Day 1 rates copied successfully to Days 2-31.', 'success');
                        fetchRates();
                    } else {
                        Swal.fire('Error', res.message || 'Something went wrong', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Server error occurred.', 'error');
                });
            }
        });
    }

    // Attach listeners to custom date inputs to update preview
    document.getElementById('bulkFrom').addEventListener('change', updateBulkPreview);
    document.getElementById('bulkTo').addEventListener('change', updateBulkPreview);

    // Initial load
    fetchRates();
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    let dateRangePicker;
    let bulkDateRangePicker;

    document.addEventListener("DOMContentLoaded", function() {
        dateRangePicker = flatpickr("#dateStart", {
            mode: "range",
            showMonths: 2,
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                if(selectedDates.length === 1) {
                    document.getElementById('dateStart').value = instance.formatDate(selectedDates[0], "Y-m-d");
                    document.getElementById('dateEnd').value = '';
                }
                if(selectedDates.length === 2) {
                    let start = instance.formatDate(selectedDates[0], "Y-m-d");
                    let end = instance.formatDate(selectedDates[1], "Y-m-d");
                    
                    document.getElementById('dateStart').value = start;
                    document.getElementById('dateEnd').value = end;
                    
                    document.getElementById('dateRangeText').innerText = start + " to " + end;
                    fetchRates();
                }
            }
        });
        
        document.getElementById('dateEnd').addEventListener('click', function() {
            dateRangePicker.open();
        });

        // Bulk Modal Date Range
        bulkDateRangePicker = flatpickr("#bulkFrom", {
            mode: "range",
            showMonths: 2,
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                if(selectedDates.length === 1) {
                    document.getElementById('bulkFrom').value = instance.formatDate(selectedDates[0], "Y-m-d");
                    document.getElementById('bulkTo').value = '';
                }
                if(selectedDates.length === 2) {
                    let start = instance.formatDate(selectedDates[0], "Y-m-d");
                    let end = instance.formatDate(selectedDates[1], "Y-m-d");
                    
                    document.getElementById('bulkFrom').value = start;
                    document.getElementById('bulkTo').value = end;
                    
                    updateBulkPreview();
                }
            }
        });
        
        document.getElementById('bulkTo').addEventListener('click', function() {
            bulkDateRangePicker.open();
        });
    });

    function clearDateRange() {
        if(typeof dateRangePicker !== 'undefined' && dateRangePicker) {
            dateRangePicker.clear();
        }
        document.getElementById('dateStart').value = '';
        document.getElementById('dateEnd').value = '';
        document.getElementById('dateRangeText').innerText = 'Loading...';
        fetchRates();
    }
</script>
