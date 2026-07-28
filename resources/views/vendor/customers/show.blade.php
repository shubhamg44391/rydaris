@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel" style="margin-bottom: 25px;">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; padding-bottom: 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
            <div>
                <a href="{{ route('vendor.customers.index') }}" style="color: var(--brand, #52ead2); text-decoration: none; font-size: 0.88rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                    &larr; Back to Customers
                </a>
                <h2 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #f8fafc;">Customer Details: {{ $customer->first_name ?? $customer->name }} {{ $customer->last_name ?? '' }}</h2>
                <p style="margin: 4px 0 0 0; color: #94a3b8; font-size: 0.88rem;">Registered Customer Profile, Driver Documents & Complete Booking History</p>
            </div>
            <div>
                <a href="{{ route('vendor.customers.edit', $customer->id) }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    Edit Customer Profile
                </a>
            </div>
        </div>

        <!-- KPI Metrics Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-top: 22px; margin-bottom: 25px;">
            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(82, 234, 210, 0.2); border-radius: 12px; padding: 18px; display: flex; align-items: center; gap: 15px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(82, 234, 210, 0.12); display: flex; align-items: center; justify-content: center; color: var(--brand, #52ead2);">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                </div>
                <div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Total Bookings</span>
                    <strong style="display: block; font-size: 1.35rem; font-weight: 900; color: #f8fafc; margin-top: 2px;">{{ $totalBookings }}</strong>
                </div>
            </div>

            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(34, 197, 94, 0.2); border-radius: 12px; padding: 18px; display: flex; align-items: center; gap: 15px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(34, 197, 94, 0.12); display: flex; align-items: center; justify-content: center; color: #4ade80;">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
                <div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Total Spend</span>
                    <strong style="display: block; font-size: 1.35rem; font-weight: 900; color: #4ade80; margin-top: 2px;">${{ number_format($totalSpent, 2) }}</strong>
                </div>
            </div>

            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(234, 179, 8, 0.2); border-radius: 12px; padding: 18px; display: flex; align-items: center; gap: 15px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(234, 179, 8, 0.12); display: flex; align-items: center; justify-content: center; color: #facc15;">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                </div>
                <div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Contact Number</span>
                    <strong style="display: block; font-size: 1.05rem; font-weight: 800; color: #f8fafc; margin-top: 2px;">{{ trim(($customer->country_code ?? '') . ' ' . ($customer->contact_number ?? 'N/A')) }}</strong>
                </div>
            </div>

            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(168, 85, 247, 0.2); border-radius: 12px; padding: 18px; display: flex; align-items: center; gap: 15px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(168, 85, 247, 0.12); display: flex; align-items: center; justify-content: center; color: #c084fc;">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <div>
                    <span style="font-size: 0.8rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Member Since</span>
                    <strong style="display: block; font-size: 1.05rem; font-weight: 800; color: #f8fafc; margin-top: 2px;">{{ $customer->created_at->format('M d, Y') }}</strong>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 25px;">
            <!-- Customer Information Card -->
            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(82, 234, 210, 0.15); border-radius: 12px; padding: 22px;">
                <h3 style="margin: 0 0 16px 0; font-size: 1.1rem; font-weight: 800; color: #f8fafc; padding-bottom: 12px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--brand, #52ead2)" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    Personal Information
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 3px;">Full Name</span>
                        <strong style="font-size: 0.95rem; color: #f8fafc;">{{ $customer->first_name ?? $customer->name }} {{ $customer->middle_name ?? '' }} {{ $customer->last_name ?? '' }}</strong>
                    </div>

                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 3px;">Username</span>
                        <strong style="font-size: 0.95rem; color: #f8fafc;">{{ $customer->username ?? 'N/A' }}</strong>
                    </div>

                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 3px;">Email Address</span>
                        <a href="mailto:{{ $customer->email }}" style="font-size: 0.95rem; color: #f8fafc; background: transparent !important; padding: 0 !important; border: none !important; box-shadow: none !important; text-decoration: none; font-weight: 700; display: inline-block;">{{ $customer->email }}</a>
                    </div>

                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 3px;">Phone</span>
                        <strong style="font-size: 0.95rem; color: #f8fafc;">{{ trim(($customer->country_code ?? '') . ' ' . ($customer->contact_number ?? 'N/A')) }}</strong>
                    </div>

                    <div style="grid-column: span 2;">
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 3px;">Address</span>
                        <strong style="font-size: 0.95rem; color: #cbd5e1; font-weight: 500;">
                            {{ implode(', ', array_filter([$customer->street_address, $customer->landmark, $customer->city, $customer->pincode, $customer->country])) ?: 'No address specified' }}
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Customer Documents & Identity Card -->
            <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(82, 234, 210, 0.15); border-radius: 12px; padding: 22px;">
                <h3 style="margin: 0 0 16px 0; font-size: 1.1rem; font-weight: 800; color: #f8fafc; padding-bottom: 12px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--brand, #52ead2)" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"></rect><line x1="7" y1="8" x2="17" y2="8"></line><line x1="7" y1="12" x2="13" y2="12"></line></svg>
                    Driver & Verification Documents
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 3px;">Driving License No.</span>
                        <strong style="font-size: 0.95rem; color: #f8fafc;">{{ $latestDocBooking->license_number ?? 'Not uploaded' }}</strong>
                    </div>

                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 3px;">License Expiry</span>
                        <strong style="font-size: 0.95rem; color: #f8fafc;">{{ $latestDocBooking->license_expiry_date ?? 'N/A' }}</strong>
                    </div>

                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 3px;">Passport / National ID</span>
                        <strong style="font-size: 0.95rem; color: #f8fafc;">{{ $latestDocBooking->pass_number ?? 'Not provided' }}</strong>
                    </div>

                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 3px;">Flight / Reference No.</span>
                        <strong style="font-size: 0.95rem; color: #f8fafc;">{{ $latestDocBooking->flight_number ?? 'N/A' }}</strong>
                    </div>
                </div>

                <!-- Document Image Proofs -->
                <div style="display: flex; gap: 16px; border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 14px;">
                    <!-- License Image -->
                    <div style="flex: 1;">
                        <span style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 6px;">License Copy</span>
                        @if(!empty($latestDocBooking->license_image))
                            <a href="{{ asset('storage/' . $latestDocBooking->license_image) }}" target="_blank" style="display: block; border-radius: 8px; overflow: hidden; border: 1px solid rgba(82, 234, 210, 0.3); height: 90px; background: rgba(0,0,0,0.3);">
                                <img src="{{ asset('storage/' . $latestDocBooking->license_image) }}" alt="License Image" style="width: 100%; height: 100%; object-fit: cover;">
                            </a>
                        @else
                            <div style="height: 90px; border-radius: 8px; background: rgba(255, 255, 255, 0.03); border: 1px dashed rgba(255, 255, 255, 0.15); display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 0.8rem;">
                                No License Image
                            </div>
                        @endif
                    </div>

                    <!-- Passport Image -->
                    <div style="flex: 1;">
                        <span style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 6px;">Passport / ID Copy</span>
                        @if(!empty($latestDocBooking->passport_image))
                            <a href="{{ asset('storage/' . $latestDocBooking->passport_image) }}" target="_blank" style="display: block; border-radius: 8px; overflow: hidden; border: 1px solid rgba(82, 234, 210, 0.3); height: 90px; background: rgba(0,0,0,0.3);">
                                <img src="{{ asset('storage/' . $latestDocBooking->passport_image) }}" alt="Passport Image" style="width: 100%; height: 100%; object-fit: cover;">
                            </a>
                        @else
                            <div style="height: 90px; border-radius: 8px; background: rgba(255, 255, 255, 0.03); border: 1px dashed rgba(255, 255, 255, 0.15); display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 0.8rem;">
                                No Passport Copy
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: All Bookings History Table -->
        <div style="background: rgba(11, 16, 32, 0.6); border: 1px solid rgba(82, 234, 210, 0.15); border-radius: 12px; padding: 22px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #f8fafc; display: flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--brand, #52ead2)" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    Customer Booking History ({{ $bookings->count() }} Bookings)
                </h3>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Vehicle</th>
                            <th>Pickup Date</th>
                            <th>Return Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        @if($booking->vehicle && $booking->vehicle->image)
                                            <img src="{{ asset('storage/' . $booking->vehicle->image) }}" alt="Car" style="width: 38px; height: 26px; object-fit: cover; border-radius: 4px;">
                                        @endif
                                        <span style="font-weight: 700; color: #f8fafc;">{{ $booking->vehicle->name ?? 'Vehicle Deleted' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-size: 0.85rem; color: #cbd5e1;">{{ $booking->pickup_date ? date('M d, Y H:i', strtotime($booking->pickup_date)) : 'N/A' }}</span>
                                </td>
                                <td>
                                    <span style="font-size: 0.85rem; color: #cbd5e1;">{{ $booking->return_date ? date('M d, Y H:i', strtotime($booking->return_date)) : 'N/A' }}</span>
                                </td>
                                <td>
                                    <strong style="color: #ffffff;">${{ number_format($booking->total_price ?? 0, 2) }}</strong>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match(strtolower($booking->status ?? 'pending')) {
                                            'confirmed', 'active' => 'background: rgba(34, 197, 94, 0.15); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3);',
                                            'completed' => 'background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);',
                                            'cancelled' => 'background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);',
                                            default => 'background: rgba(234, 179, 8, 0.15); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3);'
                                        };
                                    @endphp
                                    <span style="padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; {{ $statusClass }}">
                                        {{ ucfirst($booking->status ?? 'Pending') }}
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size: 0.82rem; color: #94a3b8; font-weight: 600;">{{ ucfirst($booking->payment_status ?? 'Unpaid') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('vendor.bookings.show', $booking->id) }}" title="View Booking Invoice" style="color: var(--brand, #52ead2); background: rgba(82, 234, 210, 0.1); border: 1px solid rgba(82, 234, 210, 0.25); padding: 5px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                        Invoice &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; color: #64748b; font-style: italic; padding: 24px;">
                                    No bookings found for this customer.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
