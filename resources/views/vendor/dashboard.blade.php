@extends('admin.layouts.app')

@section('main-content')
        <section id="overview" class="admin-hero">
          <div>
            <h1>Welcome, {{ Auth::user()->first_name ?? Auth::user()->name }}! 🎉</h1>
          </div>
          <div class="admin-date-card">
            <strong>{{ now()->format('F Y') }} close</strong>
            <p class="panel-muted">Billing period: {{ now()->startOfMonth()->format('M d') }} to {{ now()->endOfMonth()->format('M d') }}</p>
          </div>
        </section>

        <!-- KPI Metrics Section for Vendor -->
        <section class="admin-kpis" aria-label="Vendor KPIs" style="margin-top: 22px; margin-bottom: 22px;">
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon"><svg viewBox="0 0 24 24"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/></svg></span>
              <span class="delta">+18.2%</span>
            </div>
            <strong>$12,450</strong>
            <span>monthly rental earnings</span>
          </article>
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>
              <span class="delta" style="background: #e2fbf6; color: #0f766e;">95% active</span>
            </div>
            <strong>42</strong>
            <span>total fleet vehicles</span>
          </article>
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
              <span class="delta">+12 new</span>
            </div>
            <strong>138</strong>
            <span>active rental bookings</span>
          </article>
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon"><svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></span>
              <span class="delta" style="background: #ffedd5; color: #9a3412;">4.9 rating</span>
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
              <div class="section-tabs" aria-label="Chart range"><button class="active">12M</button><button>6M</button><button>30D</button></div>
            </div>
            <div class="panel-body">
              <div class="chart-bars" aria-label="Monthly booking volume chart">
                <span class="bar" style="height: 48%;" data-month="Jul"></span>
                <span class="bar" style="height: 52%;" data-month="Aug"></span>
                <span class="bar" style="height: 56%;" data-month="Sep"></span>
                <span class="bar" style="height: 50%;" data-month="Oct"></span>
                <span class="bar" style="height: 64%;" data-month="Nov"></span>
                <span class="bar" style="height: 72%;" data-month="Dec"></span>
                <span class="bar" style="height: 68%;" data-month="Jan"></span>
                <span class="bar" style="height: 78%;" data-month="Feb"></span>
                <span class="bar" style="height: 84%;" data-month="Mar"></span>
                <span class="bar" style="height: 80%;" data-month="Apr"></span>
                <span class="bar" style="height: 89%;" data-month="May"></span>
                <span class="bar" style="height: 95%;" data-month="Jun"></span>
              </div>
              <div class="analytics-row">
                <div class="mini-metric"><strong>284</strong><span class="panel-muted">bookings completed</span></div>
                <div class="mini-metric"><strong>$43.9K</strong><span class="panel-muted">total revenue</span></div>
                <div class="mini-metric"><strong>94%</strong><span class="panel-muted">utilization rate</span></div>
              </div>
            </div>
          </article>

          <article class="admin-panel">
            <div class="panel-head">
              <div><h2>Fleet Distribution</h2><p class="panel-muted">Distribution of vehicles by category/class.</p></div>
            </div>
            <div class="panel-body">
              <div class="donut"><div class="donut-inner"><div><strong>42</strong><span class="panel-muted">vehicles</span></div></div></div>
              <div class="legend">
                <span><b><i></i>Sedan</b><strong>55%</strong></span>
                <span><b><i></i>SUV</b><strong>25%</strong></span>
                <span><b><i></i>Luxury</b><strong>15%</strong></span>
                <span><b><i></i>Electric</b><strong>5%</strong></span>
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
              <div class="activity-item">
                <span class="admin-icon" style="background: rgba(82, 234, 210, 0.1); color: var(--brand);"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>
                <p><strong>Tesla Model 3</strong> check-out completed by customer <strong>Alice S.</strong></p>
                <small>15 min ago</small>
              </div>
              <div class="activity-item">
                <span class="admin-icon" style="background: rgba(255, 237, 213, 1); color: #9a3412;"><svg viewBox="0 0 24 24"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></span>
                <p><strong>Ford Mustang</strong> low tire pressure warning alert triggered.</p>
                <small>1 hr ago</small>
              </div>
              <div class="activity-item">
                <span class="admin-icon" style="background: rgba(82, 234, 210, 0.1); color: var(--brand);"><svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></svg></span>
                <p>New booking request received for <strong>Audi A6</strong>.</p>
                <small>3 hrs ago</small>
              </div>
              <div class="activity-item">
                <span class="admin-icon" style="background: rgba(82, 234, 210, 0.1); color: var(--brand);"><svg viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></svg></span>
                <p>Payment of <strong>$450</strong> received for booking <strong>#BK-8492</strong>.</p>
                <small>Yesterday</small>
              </div>
            </div>
          </article>
        </section>
@endsection
