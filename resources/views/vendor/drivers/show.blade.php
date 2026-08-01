@extends('admin.layouts.app')

@section('title', 'Driver Details - ' . $driver->name)

@section('main-content')
<div class="container-fluid px-4 py-4">
    <div class="admin-panel" style="padding: 28px 32px; border-radius: 12px; margin-bottom: 30px;">
        <!-- Header Bar -->
        <div class="panel-head d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <a href="{{ route('vendor.drivers.index') }}" class="btn btn-sm btn-secondary" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 800; background: rgba(255,255,255,0.06); color: var(--text, #f8fafc); border: 1px solid var(--line, rgba(255,255,255,0.12)); padding: 8px 16px; border-radius: var(--radius, 8px); text-decoration: none;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Back to Drivers
                </a>
                <div>
                    <h2 style="margin: 0; font-weight: 800; font-size: 1.5rem; color: var(--text, #f8fafc); display: flex; align-items: center; gap: 10px;">
                        {{ $driver->name }}
                        <span style="font-size: 0.85rem; padding: 4px 12px; border-radius: 20px; font-weight: 800; {{ $driver->status === 'active' ? 'background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3);' : 'background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3);' }}">
                            ● {{ ucfirst($driver->status) }}
                        </span>
                    </h2>
                    <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 4px; margin-bottom: 0;">Driver ID: #DRV-{{ $driver->id }} | Registered on {{ $driver->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <div>
                <a href="{{ route('vendor.drivers.edit', $driver->id) }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 800 !important; background: var(--brand, #52ead2); color: #061218 !important; border: none; padding: 10px 22px; border-radius: var(--radius, 8px); text-decoration: none; font-size: 0.95rem;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    <span style="font-weight: 800 !important;">Edit Driver</span>
                </a>
            </div>
        </div>

        <!-- Quick Stats Cards Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div style="background: var(--bg-card, #121e28); border: 1px solid var(--line, rgba(255,255,255,0.08)); border-radius: var(--radius, 10px); padding: 18px 20px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <span style="color: #94a3b8; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Assignments</span>
                        <h3 style="margin: 6px 0 0 0; color: var(--text, #f8fafc); font-weight: 800; font-size: 1.6rem;">{{ $bookings->count() }}</h3>
                    </div>
                    <div style="width: 46px; height: 46px; min-width: 46px; border-radius: 10px; background: rgba(82, 234, 210, 0.15); border: 1px solid rgba(82, 234, 210, 0.3); display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#52ead2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <path d="M9 17h6"></path>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div style="background: var(--bg-card, #121e28); border: 1px solid var(--line, rgba(255,255,255,0.08)); border-radius: var(--radius, 10px); padding: 18px 20px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <span style="color: #94a3b8; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Active / Ongoing Trips</span>
                        <h3 style="margin: 6px 0 0 0; color: var(--brand, #52ead2); font-weight: 800; font-size: 1.6rem;">
                            {{ $bookings->whereNotIn('booking_status', ['completed', 'cancelled'])->count() }}
                        </h3>
                    </div>
                    <div style="width: 46px; height: 46px; min-width: 46px; border-radius: 10px; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#38bdf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="6" cy="19" r="3"></circle>
                            <path d="M9 19h8.5a3.5 3.5 0 0 0 0-7h-11a3.5 3.5 0 0 1 0-7H15"></path>
                            <circle cx="18" cy="5" r="3"></circle>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div style="background: var(--bg-card, #121e28); border: 1px solid var(--line, rgba(255,255,255,0.08)); border-radius: var(--radius, 10px); padding: 18px 20px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <span style="color: #94a3b8; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Completed Trips</span>
                        <h3 style="margin: 6px 0 0 0; color: #22c55e; font-weight: 800; font-size: 1.6rem;">
                            {{ $bookings->where('booking_status', 'completed')->count() }}
                        </h3>
                    </div>
                    <div style="width: 46px; height: 46px; min-width: 46px; border-radius: 10px; background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Split Grid -->
        <div class="row g-4">
            <!-- Driver Profile Information Card -->
            <div class="col-lg-4">
                <div style="background: var(--bg-card, #121e28); border: 1px solid var(--line, rgba(255,255,255,0.08)); border-radius: var(--radius, 10px); overflow: hidden;">
                    <div style="padding: 24px; text-align: center; border-bottom: 1px solid var(--line, rgba(255,255,255,0.08));">
                        <div style="margin-bottom: 12px;">
                            @if($driver->photo)
                                <img src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->name }}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--brand, #52ead2);" />
                            @else
                                <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--brand, #52ead2); color: #061218; font-size: 2rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    {{ strtoupper(substr($driver->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <h4 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: var(--text, #f8fafc);">{{ $driver->name }}</h4>
                        <p style="margin: 4px 0 0 0; color: #94a3b8; font-size: 0.88rem;"><i class="fa-solid fa-phone me-1" style="color: var(--brand, #52ead2);"></i> {{ $driver->phone }}</p>
                    </div>

                    <div style="padding: 20px;">
                        <div class="d-flex flex-column gap-3" style="font-size: 0.88rem;">
                            <div>
                                <span style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">Email Address</span>
                                <strong style="color: var(--text, #f8fafc);">{{ $driver->email ?? 'N/A' }}</strong>
                            </div>

                            <div>
                                <span style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">Driver License Number</span>
                                @if($driver->license_number)
                                    <span class="badge" style="background: rgba(82, 234, 210, 0.1); color: var(--brand, #52ead2); border: 1px solid rgba(82, 234, 210, 0.2); font-weight: 700; font-size: 0.82rem; padding: 4px 10px; border-radius: 6px;">
                                        {{ $driver->license_number }}
                                    </span>
                                @else
                                    <span style="color: #64748b;">N/A</span>
                                @endif
                            </div>

                            <div>
                                <span style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">License Expiry Date</span>
                                <strong style="color: var(--text, #f8fafc);">
                                    {{ $driver->license_expiry ? \Carbon\Carbon::parse($driver->license_expiry)->format('d M, Y') : 'N/A' }}
                                </strong>
                            </div>

                            <div>
                                <span style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">Full Address</span>
                                <span style="color: var(--text, #cbd5e1); line-height: 1.4;">{{ $driver->address }}</span>
                            </div>

                            @if($driver->notes)
                                <div>
                                    <span style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 2px;">Notes / Remarks</span>
                                    <span style="color: var(--text, #cbd5e1); font-style: italic;">{{ $driver->notes }}</span>
                                </div>
                            @endif

                            <div style="border-top: 1px solid var(--line, rgba(255,255,255,0.08)); padding-top: 14px; margin-top: 4px;">
                                <span style="color: #94a3b8; font-size: 0.76rem; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 8px;">Driver License Document</span>
                                @if($driver->license_image)
                                    @php $ext = pathinfo($driver->license_image, PATHINFO_EXTENSION); @endphp
                                    @if(strtolower($ext) === 'pdf')
                                        <div style="padding: 12px; border-radius: 8px; background: rgba(255,255,255,0.02); border: 1px solid var(--line, rgba(255,255,255,0.1)); text-align: center;">
                                            <i class="fa-solid fa-file-pdf text-danger" style="font-size: 2.2rem; display: block; margin-bottom: 8px;"></i>
                                            <a href="{{ asset('storage/' . $driver->license_image) }}" target="_blank" class="btn btn-sm" style="background: rgba(82, 234, 210, 0.1); color: var(--brand, #52ead2); border: 1px solid rgba(82, 234, 210, 0.2); font-weight: 800; border-radius: 6px; width: 100%;">
                                                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Open License PDF
                                            </a>
                                        </div>
                                    @else
                                        <div style="position: relative; border-radius: 8px; overflow: hidden; border: 1px solid var(--line, rgba(255,255,255,0.12)); background: rgba(0,0,0,0.3); text-align: center;">
                                            <a href="{{ asset('storage/' . $driver->license_image) }}" target="_blank" title="Click to view full image">
                                                <img src="{{ asset('storage/' . $driver->license_image) }}" alt="Driver License Image" style="max-height: 180px; width: 100%; object-fit: contain; padding: 6px;" />
                                            </a>
                                            <div style="padding: 6px 10px; background: rgba(0,0,0,0.5); font-size: 0.75rem; text-align: center; border-top: 1px solid var(--line, rgba(255,255,255,0.08));">
                                                <a href="{{ asset('storage/' . $driver->license_image) }}" target="_blank" style="color: var(--brand, #52ead2); font-weight: 800; text-decoration: none;">
                                                    <i class="fa-solid fa-magnifying-glass-plus me-1"></i> View Full License Image
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div style="padding: 12px; border-radius: 8px; background: rgba(255,255,255,0.02); border: 1px dashed rgba(255,255,255,0.1); text-align: center; color: #64748b; font-size: 0.85rem; font-style: italic;">
                                        No license photo / document uploaded.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Bookings History Table -->
            <div class="col-lg-8">
                <div style="background: var(--bg-card, #121e28); border: 1px solid var(--line, rgba(255,255,255,0.08)); border-radius: var(--radius, 10px); overflow: hidden;">
                    <div style="padding: 16px 20px; border-bottom: 1px solid var(--line, rgba(255,255,255,0.08)); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: var(--text, #f8fafc);">Booking Assignment History</h3>
                            <p style="margin: 2px 0 0 0; color: #94a3b8; font-size: 0.82rem;">List of all vehicle rental bookings assigned to this driver</p>
                        </div>
                        <span style="background: rgba(82, 234, 210, 0.1); color: var(--brand, #52ead2); border: 1px solid rgba(82, 234, 210, 0.2); font-weight: 800; font-size: 0.8rem; padding: 4px 12px; border-radius: 6px;">
                            {{ $bookings->count() }} Total Assigned
                        </span>
                    </div>

                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Booking Ref</th>
                                    <th>Customer</th>
                                    <th>Vehicle</th>
                                    <th>Pickup & Return</th>
                                    <th>Status</th>
                                    <th>Assigned On</th>
                                    <th style="width: 120px; text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $bk)
                                    <tr>
                                        <td style="white-space: nowrap;">
                                            <a href="{{ route('vendor.bookings.show', $bk->id) }}" class="booking-ref-link" style="background: transparent !important; border: none !important; box-shadow: none !important; padding: 0 !important; color: var(--brand, #52ead2) !important; font-weight: 800; text-decoration: none !important;">
                                                {{ $bk->reservation_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: var(--text, #f8fafc);">{{ $bk->customer_fname }} {{ $bk->customer_lname }}</div>
                                            <span style="color: #94a3b8; font-size: 0.82rem;">{{ $bk->customer_phone }}</span>
                                        </td>
                                        <td>
                                            <strong style="color: var(--text, #f8fafc); font-size: 0.88rem;">{{ $bk->vehicle->name ?? 'Vehicle N/A' }}</strong>
                                        </td>
                                        <td>
                                            <div style="font-size: 0.82rem; line-height: 1.4;">
                                                <div><i class="fa-solid fa-calendar-check me-1" style="color: var(--brand, #52ead2);"></i> {{ $bk->pickup_date }}</div>
                                                <div style="color: #94a3b8;"><i class="fa-solid fa-calendar-xmark me-1"></i> {{ $bk->return_date }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $st = strtolower($bk->booking_status);
                                            @endphp
                                            @if($st === 'completed')
                                                <span class="status-badge-active" style="background: rgba(34, 197, 94, 0.15); color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3); font-weight: 800; border-radius: 12px; padding: 3px 10px; font-size: 0.78rem;">Completed</span>
                                            @elseif($st === 'cancelled')
                                                <span class="status-badge-inactive" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); font-weight: 800; border-radius: 12px; padding: 3px 10px; font-size: 0.78rem;">Cancelled</span>
                                            @elseif($st === 'confirmed')
                                                <span style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); font-weight: 800; border-radius: 12px; padding: 3px 10px; font-size: 0.78rem;">Confirmed</span>
                                            @else
                                                <span style="background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); font-weight: 800; border-radius: 12px; padding: 3px 10px; font-size: 0.78rem;">{{ ucfirst($bk->booking_status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="font-size: 0.82rem; color: #94a3b8;">
                                                {{ $bk->assigned_at ? \Carbon\Carbon::parse($bk->assigned_at)->format('Y-m-d') : $bk->created_at->format('Y-m-d') }}
                                            </span>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="{{ route('vendor.bookings.show', $bk->id) }}" class="btn btn-sm" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; font-weight: 800 !important; font-size: 0.85rem; padding: 6px 16px; text-decoration: none;" title="View Booking Details">
                                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                <span style="font-weight: 800 !important;">View</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5" style="color: #94a3b8; font-style: italic;">
                                            No booking assignments found for this driver yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .booking-ref-link {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        border-radius: 0 !important;
        color: var(--brand, #52ead2) !important;
        -webkit-text-fill-color: var(--brand, #52ead2) !important;
    }
    body.light-mode .booking-ref-link {
        color: #0f766e !important;
        -webkit-text-fill-color: #0f766e !important;
    }
</style>
@endsection
