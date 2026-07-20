@extends('admin.layouts.app')
@section('main-content')
        <section id="overview" class="admin-hero">
         
          <div>
            <h1>Welcome back, {{ auth()->user()->name ?? 'Admin' }}</h1>
          
          </div>
        </section>

        
        <section class="admin-kpis" aria-label="Business KPIs" style="margin-top: 22px; margin-bottom: 22px;">
          
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon" style="background: rgba(82,234,210,0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 42px; height: 42px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#52ead2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                  <line x1="12" y1="1" x2="12" y2="23"/>
                  <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
              </span>
              <span class="delta">+14.8%</span>
            </div>
            <strong>${{ number_format(($totalVendors * 1840) / 83, 0) }}</strong>
            <span>estimated recurring revenue</span>
          </article>

          
          <a class="kpi-card" href="{{ route('admin.vendors.index') }}" style="text-decoration: none; color: inherit; display: block;">
            <div class="kpi-top">
              <span class="admin-icon" style="background: rgba(129,140,248,0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 42px; height: 42px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                  <circle cx="9" cy="7" r="4"/>
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                  <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
              </span>
              <span class="delta" style="background: rgba(82,234,210,0.15); color: #52ead2;">+{{ $activeVendors }} active</span>
            </div>
            <strong>{{ $totalVendors }}</strong>
            <span>registered vendor accounts</span>
          </a>

          
          <article class="kpi-card">
            <div class="kpi-top">
              <span class="admin-icon" style="background: rgba(251,191,36,0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 42px; height: 42px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                  <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/>
                  <polyline points="17 18 23 18 23 12"/>
                </svg>
              </span>
              <span class="delta {{ $churnDelta <= 0 ? 'good' : 'bad' }}">
                {{ $churnDelta > 0 ? '+' : '' }}{{ $churnDelta }}%
              </span>
            </div>
            <strong>{{ $churnRate }}%</strong>
            <span>gross monthly churn</span>
          </article>

          
          <a class="kpi-card" href="{{ route('admin.vendors.index', ['status' => 'inactive']) }}" style="text-decoration: none; color: inherit; display: block;">
            <div class="kpi-top">
              <span class="admin-icon" style="background: rgba(251,113,133,0.12); border-radius: 10px; display: flex; align-items: center; justify-content: center; width: 42px; height: 42px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fb7185" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;">
                  <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                  <line x1="12" y1="9" x2="12" y2="13"/>
                  <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
              </span>
              <span class="delta bad">{{ $inactiveVendors }} pending</span>
            </div>
            <strong>{{ $inactiveVendors }}</strong>
            <span>inactive vendor accounts</span>
          </a>
        </section>

        
        <section id="customers" class="admin-panel" style="margin-bottom: 22px;">
          <div class="panel-head">
            <div><h2>Recent Vendor Registrations</h2><p class="panel-muted">Latest companies registered on Rydaris, contact details, status, and registration date.</p></div>
            <a href="{{ route('admin.vendors.index') }}" class="admin-action primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
              View All Vendors
            </a>
          </div>
          <div class="panel-body admin-table-wrap">
            <table class="admin-table">
              <thead><tr><th>Vendor Name</th><th>Email</th><th>Country Code</th><th>Contact Number</th><th>Status</th><th>Registration Date</th><th>Actions</th></tr></thead>
              <tbody>
                @forelse($recentVendors as $vendor)
                  <tr>
                    <td>
                      <div class="customer-cell">
                        <span class="avatar" style="background: var(--brand); color: #051013; font-weight: bold; display: grid; place-items: center; border-radius: 50%; width: 32px; height: 32px;">
                          {{ strtoupper(substr($vendor->first_name ?? $vendor->name ?? 'V', 0, 2)) }}
                        </span>
                        <div><strong>{{ $vendor->first_name ?? $vendor->name }}</strong></div>
                      </div>
                    </td>
                    <td>{{ $vendor->email }}</td>
                    <td>{{ $vendor->country_code ?? 'N/A' }}</td>
                    <td>{{ $vendor->contact_number ?? 'N/A' }}</td>
                    <td>
                      @if($vendor->status === 'active')
                        <span class="badge" style="background: #dcfce7; color: #067647; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem;">Active</span>
                      @else
                        <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem;">Inactive</span>
                      @endif
                    </td>
                    <td>{{ $vendor->created_at->format('M d, Y H:i') }}</td>
                    <td>
                      <div class="table-actions" style="display: flex; gap: 8px;">
                          <a href="{{ route('admin.vendors.edit', $vendor->id) }}" class="icon-button" title="Edit" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d7e0e8; border-radius: var(--radius); color: #0f766e; background: #ffffff;">
                              <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                          </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-center py-4">No recent vendors found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>

        
        
@endsection
