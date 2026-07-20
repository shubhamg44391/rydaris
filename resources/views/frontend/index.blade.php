@extends('frontend.layout.main')

@section('title', $seo_title ?? 'Rydaris | Car Rental Management System')

@section('content')
    <main>
      <section class="hero">
        <div class="wrap hero-copy">
          <p class="eyebrow">Car rental command center</p>
          <h1>The operating system for modern rental fleets.</h1>
          <p class="lead">Rydaris brings reservations, fleet status, contracts, billing, inspections, and branch reporting into one beautifully connected workspace for car rental teams.</p>
          <div class="actions">
            <a class="btn primary" href="{{ route('contact') }}"><svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>See Rydaris in Action</a>
            <a class="btn secondary" href="{{ route('pricing') }}"><svg viewBox="0 0 24 24"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/></svg>View Pricing</a>
          </div>
        </div>

        <div class="product-stage">
          <div class="app-window" aria-label="Rydaris product dashboard preview">
            <div class="window-bar">
              <div class="dots" aria-hidden="true"><span></span><span></span><span></span></div>
              <span id="demo-title">Rydaris Fleet Board</span>
              <button type="button" onclick="openDemoInquiryModal()" style="background: linear-gradient(135deg, var(--brand-2, #80a7ff), var(--brand, #52ead2)); color: #050711; border: none; font-size: 0.72rem; font-weight: 700; padding: 4px 12px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 0 10px rgba(82, 234, 210, 0.3); transition: all 0.2s; cursor: pointer; outline: none;">Live operations</button>
            </div>
            <div class="dashboard">
              <aside class="sidebar">
                <div class="side-item active" data-tab="fleet" onclick="switchTab('fleet', this)">
                  <span class="mini-icon"><svg viewBox="0 0 24 24"><path d="M3 13h18l-2-5H5l-2 5Z"/></svg></span>Fleet Board
                </div>
                <div class="side-item" data-tab="reservations" onclick="switchTab('reservations', this)">
                  <span class="mini-icon"><svg viewBox="0 0 24 24"><path d="M8 2v4"/><path d="M16 2v4"/><rect x="3" y="4" width="18" height="18" rx="2"/></svg></span>Reservations
                </div>
                <div class="side-item" data-tab="agreements" onclick="switchTab('agreements', this)">
                  <span class="mini-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/></svg></span>Agreements
                </div>
                <div class="side-item" data-tab="reports" onclick="switchTab('reports', this)">
                  <span class="mini-icon"><svg viewBox="0 0 24 24"><path d="M20 7h-9"/><path d="M14 17H5"/><circle cx="17" cy="17" r="3"/><circle cx="7" cy="7" r="3"/></svg></span>Reports
                </div>
              </aside>

              
              <section class="board" id="panel-fleet" style="display:flex;">
                <div class="board-grid">
                  <div>
                    <div class="glass-card fleet-visual">
                      <h3>Airport branch utilization</h3>
                      <p>Pickup flow, ready vehicles, late returns, and service holds in one view.</p>
                    </div>
                    <div class="stat-row">
                      <div class="stat">86%<span>utilization</span></div>
                      <div class="stat">42<span>active rentals</span></div>
                      <div class="stat">7<span>returns due</span></div>
                    </div>
                  </div>
                  <div class="glass-card">
                    <h3>Today</h3>
                    <div class="rental-list">
                      <div class="rental-item"><div>Executive SUV<br><span>Corporate weekly</span></div><b class="status">Out</b></div>
                      <div class="rental-item"><div>City Sedan<br><span>Airport pickup</span></div><b class="status">Ready</b></div>
                      <div class="rental-item"><div>Compact Auto<br><span>Walk-in hold</span></div><b class="status">Hold</b></div>
                      <div class="rental-item"><div>Premium Van<br><span>Service inspection</span></div><b class="status">Queue</b></div>
                    </div>
                  </div>
                </div>
              </section>

              
              <section class="board" id="panel-reservations" style="display:none; flex-direction:column; padding:14px;">
                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                  <div style="display:flex; align-items:center; gap:10px;">
                    <h3 style="margin:0; font-size:0.85rem; font-weight:700; color:#f1f5f9;">Reservations</h3>
                    <span style="font-size:0.68rem; background:rgba(82,234,210,0.15); color:#52ead2; padding:2px 8px; border-radius:20px; font-weight:700;">20 Records</span>
                  </div>
                  <div style="display:flex; gap:8px; align-items:center;">
                    <span style="font-size:0.65rem; color:#52ead2; font-weight:700;">₹12,84,500</span>
                    <span style="font-size:0.65rem; color:#64748b;">total value</span>
                  </div>
                </div>

                
                <div style="border:1px solid rgba(255,255,255,0.08); border-radius:8px; overflow:hidden; flex:1;">
                  <table id="res-table" style="width:100%; border-collapse:collapse; font-size:0.7rem;">
                    <thead>
                      <tr style="background:rgba(255,255,255,0.04); border-bottom:1px solid rgba(255,255,255,0.08);">
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">#</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Reservation</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Customer</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Vehicle</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Pickup → Return</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Amount</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Status</th>
                        <th style="padding:8px 12px; text-align:right; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">T&amp;C</th>
                      </tr>
                    </thead>
                    <tbody id="res-tbody">
                      
                    </tbody>
                  </table>
                </div>

                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px;">
                  <span id="res-info" style="font-size:0.63rem; color:#64748b;"></span>
                  <div style="display:flex; gap:4px; align-items:center;" id="res-pagination"></div>
                </div>
              </section>

              
              <section class="board" id="panel-agreements" style="display:none; padding:14px; align-items:center; justify-content:center; height:100%; min-height:280px; width:100%;">
                <div style="width:100%; max-width:400px; padding:24px; text-align:center; display:flex; flex-direction:column; align-items:center; gap:16px; border:1px solid rgba(255,255,255,0.08); background:rgba(255,255,255,0.04); border-radius:12px; margin:auto;">
                  <div style="width: 50px; height: 50px; background: rgba(82, 234, 210, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg viewBox="0 0 24 24" style="width:24px; height:24px; fill:none; stroke:#52ead2; stroke-width:2; stroke-linecap:round; stroke-linejoin:round;">
                      <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                      <polyline points="14 2 14 8 20 8"></polyline>
                      <line x1="16" y1="13" x2="8" y2="13"></line>
                      <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                  </div>
                  <div>
                    <h3 style="margin:0 0 6px 0; font-size:0.95rem; font-weight:700; color:#f1f5f9;">Terms &amp; Conditions</h3>
                    <p style="margin:0; font-size:0.72rem; color:#94a3b8; line-height:1.4;">
                      Platform Rental Agreement policies, safety regulations, and rules set by the Admin.
                    </p>
                  </div>
                  <a href="{{ route('terms') }}" target="_blank"
                     style="display:inline-flex; align-items:center; gap:6px; padding:8px 20px; background:linear-gradient(135deg, var(--brand-2, #80a7ff), var(--brand, #52ead2)); color:#051013; border-radius:8px; font-weight:700; font-size:0.75rem; text-decoration:none; box-shadow:0 2px 10px rgba(82,234,210,0.15); transition:opacity 0.2s;"
                     onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <svg viewBox="0 0 24 24" style="width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:2.5;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    View Terms &amp; Conditions
                  </a>
                </div>
              </section>
 
              
              <section class="board" id="panel-reports" style="display:none; flex-direction:column; padding:14px;">
                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                  <div style="display:flex; align-items:center; gap:10px;">
                    <h3 style="margin:0; font-size:0.85rem; font-weight:700; color:#f1f5f9;">Booking Reports</h3>
                    <span style="font-size:0.68rem; background:rgba(82,234,210,0.15); color:#52ead2; padding:2px 8px; border-radius:20px; font-weight:700;">All Reservations</span>
                  </div>
                  <button onclick="downloadReportExcel()"
                     style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; background:linear-gradient(135deg, var(--brand-2, #80a7ff), var(--brand, #52ead2)); color:#051013; border:none; border-radius:6px; font-weight:700; font-size:0.68rem; cursor:pointer; transition:opacity 0.2s;"
                     onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    <svg viewBox="0 0 24 24" style="width:12px;height:12px;fill:none;stroke:currentColor;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Excel Download
                  </button>
                </div>

                
                <div style="border:1px solid rgba(255,255,255,0.08); border-radius:8px; overflow:hidden; flex:1;">
                  <table style="width:100%; border-collapse:collapse; font-size:0.7rem;">
                    <thead>
                      <tr style="background:rgba(255,255,255,0.04); border-bottom:1px solid rgba(255,255,255,0.08);">
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">#</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Reservation</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Customer</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Vehicle</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Pickup → Return</th>
                        <th style="padding:8px 12px; text-align:left; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Amount</th>
                        <th style="padding:8px 12px; text-align:right; font-size:0.6rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; white-space:nowrap;">Status</th>
                      </tr>
                    </thead>
                    <tbody id="rep-tbody">
                      
                    </tbody>
                  </table>
                </div>

                
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px;">
                  <span style="font-size:0.63rem; color:#64748b;">Showing active analytics overview reports</span>
                  <span style="font-size:0.63rem; color:#64748b;">Total volume: ₹12,84,500</span>
                </div>
              </section>

            </div>
          </div>
        </div>

        <style>
          /* Sidebar: only active gets full gradient; non-active hover = subtle glow */
          .side-item { cursor: pointer; transition: background 0.18s, color 0.18s; }

          /* Reservation table row hover */
          #res-tbody tr:hover td { background: rgba(82,234,210,0.04); }

          /* Pagination button base */
          .pg-btn {
            padding: 3px 8px;
            border-radius: 5px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.04);
            color: #94a3b8;
            font-size: 0.62rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
          }
          .pg-btn:hover { background: rgba(82,234,210,0.12); color: #52ead2; border-color: rgba(82,234,210,0.3); }
          .pg-btn.active-pg { background: rgba(82,234,210,0.2); color: #52ead2; border-color: rgba(82,234,210,0.5); }
          .pg-btn:disabled { opacity: 0.35; cursor: default; }
        </style>
        <script>
          /* ─── 20 Demo Reservation Records ─── */
          var resData = [
            {id:'RYD-10241', customer:'James Patel',    vehicle:'City Sedan',      dates:'Jul 14 → Jul 17', amount:'₹18,500', status:'confirmed'},
            {id:'RYD-10242', customer:'Sara Mehta',     vehicle:'Executive SUV',   dates:'Jul 14 → Jul 21', amount:'₹52,000', status:'confirmed'},
            {id:'RYD-10243', customer:'Ravi Kumar',     vehicle:'Compact Auto',    dates:'Jul 15 → Jul 16', amount:'₹6,200',  status:'pending'},
            {id:'RYD-10244', customer:'Lena Hoffmann',  vehicle:'Premium Van',     dates:'Jul 14 → Jul 18', amount:'₹32,000', status:'confirmed'},
            {id:'RYD-10245', customer:'Omar Al-Farsi',  vehicle:'Luxury Coupe',    dates:'Jul 16 → Jul 20', amount:'₹44,000', status:'cancelled'},
            {id:'RYD-10246', customer:'Priya Sharma',   vehicle:'City Sedan',      dates:'Jul 15 → Jul 19', amount:'₹22,000', status:'confirmed'},
            {id:'RYD-10247', customer:'David Müller',   vehicle:'Compact Auto',    dates:'Jul 15 → Jul 17', amount:'₹9,400',  status:'pending'},
            {id:'RYD-10248', customer:'Ayesha Khan',    vehicle:'Executive SUV',   dates:'Jul 16 → Jul 23', amount:'₹63,000', status:'confirmed'},
            {id:'RYD-10249', customer:'Carlos Rivera',  vehicle:'Premium Van',     dates:'Jul 17 → Jul 20', amount:'₹27,000', status:'confirmed'},
            {id:'RYD-10250', customer:'Nina Petrov',    vehicle:'Luxury Coupe',    dates:'Jul 16 → Jul 18', amount:'₹21,000', status:'pending'},
            {id:'RYD-10251', customer:'Amit Joshi',     vehicle:'Compact Auto',    dates:'Jul 17 → Jul 18', amount:'₹4,800',  status:'confirmed'},
            {id:'RYD-10252', customer:'Sophie Laurent', vehicle:'City Sedan',      dates:'Jul 18 → Jul 21', amount:'₹16,500', status:'cancelled'},
            {id:'RYD-10253', customer:'Kenji Tanaka',   vehicle:'Executive SUV',   dates:'Jul 18 → Jul 25', amount:'₹71,500', status:'confirmed'},
            {id:'RYD-10254', customer:'Fatima Noor',    vehicle:'Premium Van',     dates:'Jul 19 → Jul 22', amount:'₹24,000', status:'pending'},
            {id:'RYD-10255', customer:'Ethan Brooks',   vehicle:'Luxury Coupe',    dates:'Jul 19 → Jul 21', amount:'₹19,000', status:'confirmed'},
            {id:'RYD-10256', customer:'Meera Pillai',   vehicle:'City Sedan',      dates:'Jul 20 → Jul 24', amount:'₹20,800', status:'confirmed'},
            {id:'RYD-10257', customer:'Lars Jensen',    vehicle:'Compact Auto',    dates:'Jul 20 → Jul 21', amount:'₹5,100',  status:'pending'},
            {id:'RYD-10258', customer:'Zara Ahmed',     vehicle:'Executive SUV',   dates:'Jul 21 → Jul 28', amount:'₹68,000', status:'confirmed'},
            {id:'RYD-10259', customer:'Rohan Verma',    vehicle:'Premium Van',     dates:'Jul 21 → Jul 25', amount:'₹35,500', status:'cancelled'},
            {id:'RYD-10260', customer:'Chloe Martin',   vehicle:'Luxury Coupe',    dates:'Jul 22 → Jul 26', amount:'₹43,200', status:'confirmed'},
          ];

          var resPage = 1;
          var resPerPage = 10;

          /* Status badge HTML */
          function statusBadge(s) {
            var map = {
              confirmed: ['rgba(74,222,128,0.15)','#4ade80','Confirmed'],
              pending:   ['rgba(250,204,21,0.15)', '#facc15','Pending'],
              cancelled: ['rgba(239,68,68,0.15)',  '#f87171','Cancelled']
            };
            var m = map[s] || map['pending'];
            return '<span style="background:'+m[0]+';color:'+m[1]+';padding:2px 8px;border-radius:12px;font-size:0.6rem;font-weight:700;white-space:nowrap;">'+m[2]+'</span>';
          }

          function renderResTable(page) {
            resPage = page;
            var tbody = document.getElementById('res-tbody');
            if (!tbody) return;
            var start = (page - 1) * resPerPage;
            var end   = Math.min(start + resPerPage, resData.length);
            var termsUrl = '{{ route("terms") }}';
            var tcBtn = '<a href="'+termsUrl+'" target="_blank" '
              + 'style="display:inline-flex;align-items:center;gap:4px;padding:3px 9px;background:rgba(82,234,210,0.08);color:#52ead2;border:1px solid rgba(82,234,210,0.2);border-radius:5px;font-size:0.6rem;font-weight:700;text-decoration:none;white-space:nowrap;transition:all 0.2s;" '
              + 'onmouseover="this.style.background=\'rgba(82,234,210,0.2)\'" onmouseout="this.style.background=\'rgba(82,234,210,0.08)\'">'
              + '<svg viewBox="0 0 24 24" style="width:10px;height:10px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;">'
              + '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>'
              + '</svg>View T&amp;C</a>';
            var html = '';
            for (var i = start; i < end; i++) {
              var d = resData[i];
              var odd = (i % 2 === 0) ? 'rgba(255,255,255,0.015)' : 'transparent';
              html += '<tr>' +
                '<td style="padding:7px 12px; color:#64748b; background:'+odd+';">' + (i+1) + '</td>' +
                '<td style="padding:7px 12px; font-weight:700; color:#52ead2; background:'+odd+'; white-space:nowrap;">' + d.id + '</td>' +
                '<td style="padding:7px 12px; color:#f1f5f9; background:'+odd+';">' + d.customer + '</td>' +
                '<td style="padding:7px 12px; color:#94a3b8; background:'+odd+';">' + d.vehicle + '</td>' +
                '<td style="padding:7px 12px; color:#94a3b8; font-size:0.65rem; background:'+odd+'; white-space:nowrap;">' + d.dates + '</td>' +
                '<td style="padding:7px 12px; color:#52ead2; font-weight:700; background:'+odd+'; white-space:nowrap;">' + d.amount + '</td>' +
                '<td style="padding:7px 12px; background:'+odd+';">' + statusBadge(d.status) + '</td>' +
                '<td style="padding:7px 12px; text-align:right; background:'+odd+';">' + tcBtn + '</td>' +
              '</tr>';
            }
            tbody.innerHTML = html;

            /* Info text */
            var info = document.getElementById('res-info');
            if (info) info.textContent = 'Showing ' + (start+1) + '–' + end + ' of ' + resData.length + ' reservations';

            /* Pagination buttons */
            var totalPages = Math.ceil(resData.length / resPerPage);
            var pgDiv = document.getElementById('res-pagination');
            if (!pgDiv) return;
            var prevPage = page - 1;
            var nextPage = page + 1;
            var pgHtml = '<button class="pg-btn" onclick="renderResTable('+prevPage+')" ' + (page<=1?'disabled':'') + '>← Prev</button>';
            for (var p = 1; p <= totalPages; p++) {
              pgHtml += '<button class="pg-btn' + (p===page?' active-pg':'') + '" onclick="renderResTable('+p+')">' + p + '</button>';
            }
            pgHtml += '<button class="pg-btn" onclick="renderResTable('+nextPage+')" ' + (page>=totalPages?'disabled':'') + '>Next →</button>';
            pgDiv.innerHTML = pgHtml;
          }

        

          function renderReportTable() {
            var tbody = document.getElementById('rep-tbody');
            if (!tbody) return;
            var html = '';
            resData.forEach(function(d, i) {
              var odd = (i % 2 === 0) ? 'rgba(255,255,255,0.015)' : 'transparent';
              html += '<tr>' +
                '<td style="padding:7px 12px; color:#64748b; background:'+odd+';">' + (i+1) + '</td>' +
                '<td style="padding:7px 12px; font-weight:700; color:#52ead2; background:'+odd+'; white-space:nowrap;">' + d.id + '</td>' +
                '<td style="padding:7px 12px; color:#f1f5f9; background:'+odd+';">' + d.customer + '</td>' +
                '<td style="padding:7px 12px; color:#94a3b8; background:'+odd+';">' + d.vehicle + '</td>' +
                '<td style="padding:7px 12px; color:#94a3b8; font-size:0.65rem; background:'+odd+'; white-space:nowrap;">' + d.dates + '</td>' +
                '<td style="padding:7px 12px; color:#52ead2; font-weight:700; background:'+odd+'; white-space:nowrap;">' + d.amount + '</td>' +
                '<td style="padding:7px 12px; text-align:right; background:'+odd+';">' + statusBadge(d.status) + '</td>' +
              '</tr>';
            });
            tbody.innerHTML = html;
          }

          function downloadReportExcel() {
            var csv = 'Reservation #,Customer,Vehicle,Pickup - Return,Amount,Status\n';
            resData.forEach(function(d) {
              csv += d.id + ',' + d.customer + ',' + d.vehicle + ',"' + d.dates + '",' + d.amount.replace('₹','').replace(',','') + ',' + d.status + '\n';
            });
            var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            var link = document.createElement("a");
            if (link.download !== undefined) {
              var url = URL.createObjectURL(blob);
              link.setAttribute("href", url);
              link.setAttribute("download", "Rydaris_Booking_Report.csv");
              link.style.visibility = 'hidden';
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);
            }
          }

          /* ─── Tab Switcher ─── */
          function switchTab(tab, el) {
            ['fleet','reservations','agreements','reports'].forEach(function(t) {
              var p = document.getElementById('panel-' + t);
              if (p) p.style.display = 'none';
            });
            var panel = document.getElementById('panel-' + tab);
            if (panel) {
              panel.style.display = 'flex';
              /* reservations: column (table stacks vertically), reports: column, agreements: flex default, others: default */
              panel.style.flexDirection = (tab === 'reservations' || tab === 'reports') ? 'column' : '';
            }

            document.querySelectorAll('.side-item').forEach(function(item) {
              item.classList.remove('active');
            });
            el.classList.add('active');

            var titles = {
              fleet: 'Rydaris Fleet Board',
              reservations: 'Rydaris Reservations',
              agreements: 'Rydaris Agreements',
              reports: 'Rydaris Reports'
            };
            var titleEl = document.getElementById('demo-title');
            if (titleEl) titleEl.textContent = titles[tab] || 'Rydaris';

            if (tab === 'reservations') renderResTable(1);
            if (tab === 'reports')      renderReportTable();
          }
        </script>
      </section>

      <div class="ticker" aria-label="Rydaris capabilities">
        <div class="ticker-track">
          <span>Reservations</span><span>Fleet Board</span><span>Contracts</span><span>Deposits</span><span>Inspections</span><span>Maintenance</span><span>Branch Transfers</span><span>Revenue Reports</span>
          <span>Reservations</span><span>Fleet Board</span><span>Contracts</span><span>Deposits</span><span>Inspections</span><span>Maintenance</span><span>Branch Transfers</span><span>Revenue Reports</span>
        </div>
      </div>

      <section class="section light">
        <div class="wrap">
          <p class="eyebrow">Everything connected</p>
          <h2>Run the full rental lifecycle without jumping between tools.</h2>
          <p class="lead">From the first customer inquiry to final settlement, Rydaris keeps every operational detail tied to the right vehicle, branch, agreement, invoice, and staff member.</p>
          <div class="grid cols-3">
            <article class="feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M8 2v4"/><path d="M16 2v4"/><path d="M3 10h18"/><rect x="3" y="4" width="18" height="18" rx="2"/></svg></span><h3>Reservation workspace</h3><p>Create quotes, holds, confirmed bookings, extensions, cancellations, and no-show records with rate rules built in.</p></article>
            <article class="feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M3 13h18l-2-5H5l-2 5Z"/><path d="M5 13v5"/><path d="M19 13v5"/></svg></span><h3>Live fleet status</h3><p>Know what is available, on rent, late, blocked, in cleaning, under service, or moving between branches.</p></article>
            <article class="feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/><path d="M8 13h8"/></svg></span><h3>Digital agreements</h3><p>Capture customer details, signatures, deposits, mileage, fuel, damages, add-ons, and return notes in one agreement.</p></article>
            <article class="feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/></svg></span><h3>Billing control</h3><p>Handle deposits, invoices, taxes, extra charges, refunds, settlements, and outstanding balances with clean audit trails.</p></article>
            <article class="feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg></span><h3>Inspection records</h3><p>Document pickup and return condition, attach photos, flag damage, and keep vehicle history ready for review.</p></article>
            <article class="feature-card"><span class="icon"><svg viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-5 5"/></svg></span><h3>Performance reports</h3><p>Track utilization, revenue, booking sources, late returns, branch activity, service load, and fleet profitability.</p></article>
          </div>
        </div>
      </section>

      <section class="section dark">
        <div class="wrap split">
          <div>
            <p class="eyebrow">Operations flow</p>
            <h2>Plan pickups, dispatch vehicles, and close returns faster.</h2>
            <p class="lead">Counter staff, fleet coordinators, managers, and finance teams all see the same real-time context. Less chasing, fewer double-bookings, and cleaner handovers.</p>
            <div class="actions left">
              <a class="btn primary" href="{{ route('about') }}">Explore the Platform</a>
            </div>
          </div>
          <div class="flow">
            <div class="flow-step"><span class="step-number">01</span><div><h3>Convert inquiry to confirmed booking</h3><p>Choose branch, dates, rate plan, add-ons, customer profile, and payment status without leaving the reservation screen.</p></div></div>
            <div class="flow-step"><span class="step-number">02</span><div><h3>Prepare the vehicle</h3><p>Assign cars based on real status, service windows, fuel, documents, cleaning state, and expected return timing.</p></div></div>
            <div class="flow-step"><span class="step-number">03</span><div><h3>Return and settle</h3><p>Capture mileage, damage, fuel, extensions, extra charges, refunds, and invoice closure from a guided return flow.</p></div></div>
          </div>
        </div>
      </section>

      <section class="section soft">
        <div class="wrap">
          <p class="eyebrow">Designed for growing fleets</p>
          <h2>Give every branch a shared operating rhythm.</h2>
          <div class="grid cols-4">
            <article class="info-card"><h3>Branch managers</h3><p>Monitor availability, staff activity, returns due, revenue, service holds, and fleet movement.</p></article>
            <article class="info-card"><h3>Reservation teams</h3><p>Quote quickly, reduce conflicts, view customer history, and manage extensions with confidence.</p></article>
            <article class="info-card"><h3>Fleet coordinators</h3><p>Keep inspections, cleaning, maintenance, registration, and availability aligned across vehicles.</p></article>
            <article class="info-card"><h3>Finance teams</h3><p>Track deposits, unpaid invoices, refunds, tax lines, add-ons, and end-of-day settlement reports.</p></article>
          </div>
        </div>
      </section>

      <section class="section dark">
        <div class="wrap hero-copy">
          <p class="eyebrow">Ready for a cleaner rental workflow?</p>
          <h2>Move your fleet from scattered updates to one live workspace.</h2>
          <p class="lead">Rydaris can be shaped around your branches, vehicle classes, pricing rules, and customer journey.</p>
          <div class="actions">
            <a class="btn primary" href="{{ route('contact') }}">Book a Demo</a>
            <a class="btn secondary" href="{{ route('faq') }}">Read FAQ</a>
          </div>
        </div>
      </section>
    </main>
@endsection
