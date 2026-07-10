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
        </style>

        <section id="overview" class="admin-hero">
          <div>
            <h1>Welcome, {{ Auth::user()->first_name ?? Auth::user()->name }}!</h1>
          </div>
          <div class="admin-date-card">
            <strong>{{ now()->format('F Y') }}</strong>
            <p class="panel-muted">Billing period: {{ now()->startOfMonth()->format('M d') }} to {{ now()->endOfMonth()->format('M d') }}</p>
          </div>
        </section>

        <!-- KPI Metrics Section for Vendor -->
        <section class="admin-kpis" aria-label="Vendor KPIs" style="margin-top: 22px; margin-bottom: 22px;">
          <!-- Monthly Earnings -->
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon" style="background: rgba(82,234,210,0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 42px; height: 42px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#52ead2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                  <line x1="12" y1="1" x2="12" y2="23"/>
                  <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
              </span>
            </div>
            <strong>₹{{ number_format($monthlyEarnings, 2) }}</strong>
            <span>monthly rental earnings</span>
          </article>

          <!-- Total Vehicles -->
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

          <!-- Total Bookings -->
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

          <!-- Rating -->
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon" style="background: rgba(251,113,133,0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 42px; height: 42px;">
                <svg viewBox="0 0 24 24" fill="#fb7185" stroke="#fb7185" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                  <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
              </span>
            </div>
            <strong>4.9 ★</strong>
            <span>customer review score</span>
          </article>
        </section>

        <!-- Charts Grid Section for Vendor -->
        <section id="analytics" class="admin-grid" style="margin-bottom: 22px;">
          <article class="admin-panel">
            <div class="panel-head">
              <div><h2>Rental volume</h2><p class="panel-muted">Total booking requests and active vehicle utilization by month.</p></div>
              <div class="section-tabs" aria-label="Chart range"><button class="active">12M</button></div>
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
              <div class="donut"><div class="donut-inner"><div><strong>{{ $totalVehicles }}</strong><span class="panel-muted">vehicles</span></div></div></div>
              <div class="legend">
                <span><b><i style="background: var(--brand);"></i>Automatic</b><strong>{{ $autoPercent }}%</strong></span>
                <span><b><i style="background: rgba(82, 234, 210, 0.4);"></i>Manual</b><strong>{{ $manualPercent }}%</strong></span>
              </div>
            </div>
          </article>
        </section>

        <!-- Fleet Health and Activity Lists -->
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
                    <span class="admin-icon" style="background: rgba(82, 234, 210, 0.1); color: var(--brand);"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>
                    <p><strong>{{ $b->vehicle->name ?? 'Vehicle' }}</strong> check-in completed by customer <strong>{{ $b->customer_fname }} {{ $b->customer_lname }}</strong>.</p>
                  @else
                    <span class="admin-icon" style="background: rgba(82, 234, 210, 0.1); color: var(--brand);"><svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></svg></span>
                    <p>New booking request received for <strong>{{ $b->vehicle->name ?? 'Vehicle' }}</strong>.</p>
                  @endif
                  <small>{{ $b->created_at->diffForHumans() }}</small>
                </div>
              @empty
                <p style="color: #64748b; font-style: italic; font-size: 0.9rem; padding: 10px 0;">No recent activities.</p>
              @endforelse
            </div>
          </article>
        </section>
@endsection
