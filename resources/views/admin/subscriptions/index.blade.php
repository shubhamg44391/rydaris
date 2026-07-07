@extends('admin.layouts.app')

@section('main-content')
    <div class="admin-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2>Subscription Payments & Invoices</h2>
                <p class="panel-muted" style="margin: 0; margin-top: 4px;">Monitor vendor subscription plans, amount collections, and Razorpay transaction reference numbers.</p>
            </div>
        </div>

        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Vendor / Company</th>
                        <th>Subscription Plan</th>
                        <th>Amount Paid</th>
                        <th>Payment ID (Ref No)</th>
                        <th>Order ID</th>
                        <th>Duration (Start - End)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subscriptions as $sub)
                        <tr>
                            <td>
                                <div style="display: flex; flex-direction: column;">
                                    <strong>{{ $sub->vendor->company_name ?? $sub->vendor->name ?? 'N/A' }}</strong>
                                    <span style="font-size: 0.8rem; color: #64748b;">{{ $sub->vendor->email ?? '' }}</span>
                                </div>
                            </td>
                            <td>
                                <strong style="color: #f8fafc;">{{ $sub->package->name ?? 'Deleted Plan' }}</strong>
                            </td>
                            <td>
                                <strong style="color: var(--brand, #52ead2);">
                                    {{ $sub->amount_paid ? '₹' . number_format($sub->amount_paid, 2) : 'N/A' }}
                                </strong>
                            </td>
                            <td>
                                @if($sub->razorpay_payment_id)
                                    <code style="background: rgba(255,255,255,0.05); color: #e2e8f0; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">{{ $sub->razorpay_payment_id }}</code>
                                @else
                                    <span style="font-size: 0.85rem; color: #64748b; font-style: italic;">Test Mode / Free</span>
                                @endif
                            </td>
                            <td>
                                @if($sub->razorpay_order_id)
                                    <code style="background: rgba(255,255,255,0.05); color: #e2e8f0; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">{{ $sub->razorpay_order_id }}</code>
                                @else
                                    <span style="font-size: 0.85rem; color: #64748b;">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 0.85rem; color: #aab7cb;">
                                    <div>{{ $sub->starts_at->format('M d, Y') }}</div>
                                    <div style="font-size: 0.75rem; color: #64748b;">to {{ $sub->ends_at->format('M d, Y') }}</div>
                                </div>
                            </td>
                            <td>
                                @if($sub->isValid())
                                    <span class="badge" style="background: #dcfce7; color: #067647; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem;">Active</span>
                                @else
                                    <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 0.8rem;">Expired</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #aab7cb; padding: 30px;">
                                No subscription or payment logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscriptions->hasPages())
            <div style="padding: 15px 24px; border-top: 1px solid rgba(255,255,255,0.05);">
                {{ $subscriptions->links() }}
            </div>
        @endif
    </div>
@endsection
