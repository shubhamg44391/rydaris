@extends('admin.layouts.app')

@section('main-content')
        <style>
            .mini-metric {
                background: rgba(255, 255, 255, 0.02) !important;
                border: 1px solid rgba(255, 255, 255, 0.05) !important;
                border-radius: 8px;
                padding: 15px;
                transition: all 0.2s ease;
            }
            .mini-metric:hover {
                background: rgba(255, 255, 255, 0.04) !important;
                border-color: rgba(82, 234, 210, 0.15) !important;
            }
            .mini-metric strong {
                color: #f8fafc !important;
                font-size: 1.25rem !important;
                font-weight: 700 !important;
                display: block;
            }
            .mini-metric .panel-muted {
                color: #94a3b8 !important;
                font-size: 0.85rem !important;
                display: block;
                margin-top: 4px;
            }
            /* Donut Chart Styling Overrides */
            .donut {
                background: conic-gradient(#52ead2 0% {{ $autoPercent }}%, rgba(82, 234, 210, 0.2) {{ $autoPercent }}% 100%) !important;
            }
            .donut-inner {
                background: #0b1020 !important;
            }
            .donut-inner strong {
                color: #f8fafc !important;
            }
            .donut-inner .panel-muted {
                color: #94a3b8 !important;
            }
            /* Activity Items Dark Theme Overrides */
            .activity-item {
                background: rgba(255, 255, 255, 0.02) !important;
                border: 1px solid rgba(255, 255, 255, 0.05) !important;
                transition: all 0.2s ease;
            }
            .activity-item:hover {
                background: rgba(255, 255, 255, 0.04) !important;
                border-color: rgba(82, 234, 210, 0.15) !important;
            }
            .activity-item p {
                color: #cbd5e1 !important;
            }
            .activity-item strong {
                color: #ffffff !important;
            }
            .activity-item small {
                color: #94a3b8 !important;
            }
            /* Progress Bar Dark Theme Overrides */
            .progress {
                background: rgba(255, 255, 255, 0.08) !important;
            }
            /* Health Rows Text Theme Overrides */
            .health-row strong {
                color: #aab7cb !important;
                font-weight: 500 !important;
            }
            .health-row span {
                color: #ffffff !important;
                font-weight: 600 !important;
            }
            
            /* Chart dynamic column adjustments */
            .chart-bars {
                grid-template-columns: repeat({{ count($monthlyRevenue) }}, minmax(20px, 1fr)) !important;
                margin-bottom: 24px !important;
            }
            .bar::after {
                content: attr(data-month) !important;
                white-space: nowrap !important;
                bottom: -28px !important;
                font-size: 0.72rem !important;
                color: #a8b3c5 !important;
            }
            
            /* Theme cohesive dropdown and date pickers */
            #rangeSelect {
                background-color: #0b1020 !important;
                border: 1px solid rgba(82, 234, 210, 0.25) !important;
                color: #ffffff !important;
                padding: 8px 36px 8px 16px !important;
                border-radius: 8px !important;
                font-size: 0.85rem !important;
                cursor: pointer;
                outline: none;
                font-family: inherit;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
                background-repeat: no-repeat !important;
                background-position: right 14px center !important;
            }
            #rangeSelect option {
                background: #050711 !important;
                color: #ffffff !important;
            }
            .filter-controls input[type="month"] {
                background: #0b1020 !important;
                border: 1px solid rgba(82, 234, 210, 0.25) !important;
                color: #ffffff !important;
                padding: 6px 12px !important;
                border-radius: 8px !important;
                font-size: 0.82rem !important;
                outline: none;
                color-scheme: dark;
            }

            /* Light mode overrides for rangeSelect dropdown & date pickers */
            body.light-mode #rangeSelect {
                background-color: #ffffff !important;
                border: 1px solid #cbd5e1 !important;
                color: #0f172a !important;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%230f172a' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
                background-repeat: no-repeat !important;
                background-position: right 14px center !important;
            }
            body.light-mode #rangeSelect option {
                background: #ffffff !important;
                color: #0f172a !important;
            }
            body.light-mode .filter-controls input[type="month"] {
                background: #ffffff !important;
                border: 1px solid #cbd5e1 !important;
                color: #0f172a !important;
                color-scheme: light !important;
            }
        </style>

        <section id="overview" class="admin-hero">
          <div>
            <h1>Welcome, {{ Auth::user()->first_name ?? Auth::user()->name }}!</h1>
          </div>
          @php
            $sub = Auth::user()->activeSubscription ?? Auth::user()->subscription;
            if ($sub) {
                $startObj = $sub->starts_at ? \Carbon\Carbon::parse($sub->starts_at) : ($sub->created_at ? \Carbon\Carbon::parse($sub->created_at) : now());
                $startDate = $startObj->format('Y-m-d');
                if ($sub->ends_at) {
                    $endDate = \Carbon\Carbon::parse($sub->ends_at)->format('Y-m-d');
                } else {
                    $period = strtolower($sub->package->billing_period ?? 'year');
                    if (str_contains($period, 'year') || str_contains($period, 'annual') || str_contains($period, 'yr')) {
                        $endDate = (clone $startObj)->addYear()->format('Y-m-d');
                    } else {
                        $endDate = (clone $startObj)->addMonth()->format('Y-m-d');
                    }
                }
            } else {
                $startObj = Auth::user()->created_at ? \Carbon\Carbon::parse(Auth::user()->created_at) : now();
                $startDate = $startObj->format('Y-m-d');
                $endDate = (clone $startObj)->addYear()->format('Y-m-d');
            }
          @endphp
          <div class="admin-date-card">
            <p class="panel-muted" style="margin: 0; font-weight: 600;">Billing period: {{ $startDate }} to {{ $endDate }}</p>
          </div>
        </section>

        
        <section class="admin-kpis" aria-label="Vendor KPIs" style="margin-top: 22px; margin-bottom: 22px;">
          
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon" style="background: rgba(82,234,210,0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 42px; height: 42px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#52ead2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                  <line x1="12" y1="1" x2="12" y2="23"/>
                  <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
              </span>
            </div>
            <strong>{{ number_format($monthlyEarnings, 2) }}</strong>
            <span>monthly rental earnings</span>
          </article>

          
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon" style="background: rgba(129,140,248,0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 42px; height: 42px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                  <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                  <circle cx="7" cy="17" r="2"/>
                  <path d="M9 17h6"/>
                  <circle cx="17" cy="17" r="2"/>
                </svg>
              </span>
            </div>
            <strong>{{ $totalVehicles }}</strong>
            <span>total fleet vehicles</span>
          </article>

          
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon" style="background: rgba(251,191,36,0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 42px; height: 42px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                  <line x1="16" y1="2" x2="16" y2="6"/>
                  <line x1="8" y1="2" x2="8" y2="6"/>
                  <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
              </span>
            </div>
            <strong>{{ $totalBookings }}</strong>
            <span>total rental bookings</span>
          </article>

          
          <article class="kpi-card" onclick="window.location.href='{{ route('vendor.reviews.index') }}'" style="cursor: pointer;">
            <div class="kpi-top">
              <span class="admin-icon" style="background: rgba(251,191,36,0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 42px; height: 42px;">
                <svg viewBox="0 0 24 24" fill="#fbbf24" stroke="#fbbf24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                  <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
              </span>
            </div>
            <strong style="color: #fbbf24;">{{ number_format($avgRating, 1) }} ★</strong>
            <span>customer review score ({{ $totalReviewsCount }} reviews)</span>
          </article>
        </section>

        <!-- Single Vehicle Trip Status Bar -->
        <div style="margin-bottom: 22px; background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(82, 234, 210, 0.2); border-radius: 12px; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
          <div style="display: flex; align-items: center; gap: 12px;">
            <span style="width: 40px; height: 40px; border-radius: 10px; background: rgba(82, 234, 210, 0.12); display: flex; align-items: center; justify-content: center; color: var(--brand, #52ead2);">
              <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="3" width="15" height="13" rx="2"></rect>
                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                <circle cx="18.5" cy="18.5" r="2.5"></circle>
              </svg>
            </span>
            <div>
              <h4 style="margin: 0; font-size: 1rem; font-weight: 800; color: #f8fafc;">Vehicle Trip Status</h4>
              <p style="margin: 2px 0 0 0; font-size: 0.8rem; color: #94a3b8;">Active trips out today, upcoming queue, and returned vehicles</p>
            </div>
          </div>

          <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
            <!-- 1. On Trip Cars -->
            <div style="display: flex; align-items: center; gap: 10px; background: rgba(34, 197, 94, 0.08); border: 1px solid rgba(34, 197, 94, 0.25); padding: 8px 16px; border-radius: 8px;">
              <span style="font-size: 0.82rem; font-weight: 700; color: #4ade80;">On Trip:</span>
              <strong style="font-size: 1.3rem; font-weight: 900; color: #ffffff;">{{ $onTripCount }}</strong>
            </div>

            <!-- 2. Queue Cars -->
            <div style="display: flex; align-items: center; gap: 10px; background: rgba(234, 179, 8, 0.08); border: 1px solid rgba(234, 179, 8, 0.25); padding: 8px 16px; border-radius: 8px;">
              <span style="font-size: 0.82rem; font-weight: 700; color: #facc15;">In Queue:</span>
              <strong style="font-size: 1.3rem; font-weight: 900; color: #ffffff;">{{ $inQueueCount }}</strong>
            </div>

            <!-- 3. Return Cars -->
            <div style="display: flex; align-items: center; gap: 10px; background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.25); padding: 8px 16px; border-radius: 8px;">
              <span style="font-size: 0.82rem; font-weight: 700; color: #60a5fa;">Returned:</span>
              <strong style="font-size: 1.3rem; font-weight: 900; color: #ffffff;">{{ $returnedCount }}</strong>
            </div>
          </div>
        </div>

        
        <section id="analytics" class="admin-grid" style="margin-bottom: 22px;">
          <article class="admin-panel">
            <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
              <div>
                <h2>Rental volume</h2>
                <p class="panel-muted">Total booking requests and active vehicle utilization by month.</p>
              </div>
              <div class="filter-controls" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <form method="GET" action="{{ route('vendor.dashboard') }}" id="filterForm" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin: 0;">
                  <select name="range" id="rangeSelect" onchange="handleRangeChange(this.value)" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; outline: none; cursor: pointer; font-family: inherit;">
                    <option value="3" {{ request('range') == '3' ? 'selected' : '' }}>3 Months</option>
                    <option value="6" {{ request('range') == '6' ? 'selected' : '' }}>6 Months</option>
                    <option value="12" {{ request('range') == '12' || !request('range') ? 'selected' : '' }}>12 Months</option>
                    <option value="custom" {{ request('range') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                  </select>

                  <div id="customDatesWrapper" style="display: {{ request('range') == 'custom' ? 'flex' : 'none' }}; align-items: center; gap: 6px;">
                    <input type="month" name="start_month" value="{{ request('start_month') }}" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 5px 8px; border-radius: 6px; font-size: 0.8rem; outline: none;" required>
                    <span style="color: #64748b; font-size: 0.8rem;">to</span>
                    <input type="month" name="end_month" value="{{ request('end_month') }}" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 5px 8px; border-radius: 6px; font-size: 0.8rem; outline: none;" required>
                    <button type="submit" style="background: var(--brand, #52ead2); border: none; color: #050711; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; cursor: pointer; transition: opacity 0.2s;">Apply</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="panel-body">
              <div class="chart-bars" aria-label="Monthly booking volume chart">
                @foreach($monthlyRevenue as $item)
                  @php
                    $height = $maxRevenue > 0 ? ($item['revenue'] / $maxRevenue) * 90 : 10;
                    if ($item['count'] > 0 && $height < 15) {
                        $height = 15;
                    }
                  @endphp
                  <span class="bar" style="height: {{ $height }}%;" data-month="{{ $item['month'] }}" title="${{ number_format($item['revenue'], 2) }} ({{ $item['count'] }} bookings)"></span>
                @endforeach
              </div>
              <div class="analytics-row">
                <div class="mini-metric"><strong>{{ $totalBookings }}</strong><span class="panel-muted">bookings completed</span></div>
                <div class="mini-metric"><strong>${{ number_format($totalEarnings, 2) }}</strong><span class="panel-muted">total revenue</span></div>
                <div class="mini-metric"><strong>94%</strong><span class="panel-muted">utilization rate</span></div>
              </div>
            </div>
          </article>

          <article class="admin-panel">
            <div class="panel-head">
              <div><h2>Fleet Distribution</h2><p class="panel-muted">Distribution of vehicles by gear transmission type.</p></div>
            </div>
            <div class="panel-body">
              <div class="donut"><div class="donut-inner"><div><strong class="donut-count">{{ $totalVehicles }}</strong><span class="donut-label">vehicles</span></div></div></div>
              <div class="legend">
                <span class="legend-item"><b><i class="legend-dot-auto"></i>Automatic</b><strong class="legend-val">{{ $autoPercent }}%</strong></span>
                <span class="legend-item"><b><i class="legend-dot-manual"></i>Manual</b><strong class="legend-val">{{ $manualPercent }}%</strong></span>
              </div>
            </div>
          </article>
        </section>

        
        <section class="admin-grid" style="margin-bottom: 22px;">
          <article class="admin-panel">
            <div class="panel-head">
              <div><h2>Fleet health</h2><p class="panel-muted">Maintenance schedules, insurance validation, and service alerts.</p></div>
            </div>
            <div class="panel-body health-grid">
              <div><div class="health-row"><strong>Vehicles with active GPS & tracking</strong><span>98%</span></div><div class="progress"><span style="width: 98%;"></span></div></div>
              <div><div class="health-row"><strong>Insurance & registration validation success</strong><span>100%</span></div><div class="progress"><span style="width: 100%;"></span></div></div>
              <div><div class="health-row"><strong>Regular maintenance checks up to date</strong><span>92%</span></div><div class="progress"><span style="width: 92%;"></span></div></div>
              <div><div class="health-row"><strong>Vehicles requiring service/repair</strong><span>5%</span></div><div class="progress"><span style="width: 5%; background: #ef4444;"></span></div></div>
            </div>
          </article>

          <article id="support" class="admin-panel">
            <div class="panel-head">
              <div><h2>Recent activity</h2><p class="panel-muted">Real-time alerts, check-ins, check-outs, and feedback.</p></div>
            </div>
            <div class="panel-body activity-list">
              @forelse($recentBookings as $b)
                <div class="activity-item">
                  @if($b->checkin_status)
                    <span class="admin-icon" style="background: rgba(8, 145, 178, 0.1); color: #0891b2;"><svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>
                    <p><strong>{{ optional($b->vehicle)->name ?: 'Vehicle #' . ($b->vehicle_id ?? '') }}</strong> check-in completed by customer <strong>{{ trim(($b->customer_fname ?? '') . ' ' . ($b->customer_lname ?? '')) ?: 'Customer' }}</strong>.</p>
                  @else
                    <span class="admin-icon" style="background: rgba(8, 145, 178, 0.1); color: #0891b2;"><svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></span>
                    <p>New booking request received for <strong>{{ optional($b->vehicle)->name ?: 'Vehicle #' . ($b->vehicle_id ?? '') }}</strong>.</p>
                  @endif
                  <small>{{ $b->created_at ? $b->created_at->diffForHumans() : 'Recently' }}</small>
                </div>
              @empty
                <p style="color: #64748b; font-style: italic; font-size: 0.9rem; padding: 10px 0;">No recent activities.</p>
              @endforelse
            </div>
          </article>
        </section>

        <script>
            function handleRangeChange(val) {
                var wrapper = document.getElementById('customDatesWrapper');
                var form = document.getElementById('filterForm');
                if (val === 'custom') {
                    wrapper.style.display = 'flex';
                } else {
                    wrapper.style.display = 'none';
                    form.submit();
                }
            }
        </script>
@endsection
