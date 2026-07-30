<div class="panel-body admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Vendor / Company</th>
                <th>Subscription Plan</th>
                <th>Amount Paid</th>
                <th>Method</th>
                <th>Payment ID (Ref No)</th>
                <th>Order ID</th>
                <th>Duration (Start - End)</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subscriptions as $sub)
                <tr>
                    <td>
                        <div style="display: flex; flex-direction: column;">
                            <strong class="sub-vendor-name" style="color: var(--text, #f8fafc);">{{ $sub->vendor->company_name ?? $sub->vendor->name ?? 'N/A' }}</strong>
                            <span style="font-size: 0.8rem; color: var(--muted, #64748b);">{{ $sub->vendor->email ?? '' }}</span>
                        </div>
                    </td>
                    <td>
                        <strong class="sub-plan-name" style="color: var(--text, #f8fafc);">{{ $sub->package->name ?? 'Deleted Plan' }}</strong>
                    </td>
                    <td>
                        <strong style="color: var(--brand, #0d9488);">
                            {{ $sub->amount_paid ? '$' . number_format((float) ($sub->amount_paid / 83), 2) : 'N/A' }}
                        </strong>
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(13,148,136,0.12); color: var(--brand, #0d9488); padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.8rem; text-transform: capitalize; border: 1px solid rgba(13,148,136,0.25);">
                            {{ $sub->payment_method ?? 'Unknown' }}
                        </span>
                    </td>
                    <td>
                        @if($sub->razorpay_payment_id)
                            <code class="sub-code-block" style="background: var(--bg-2, rgba(255,255,255,0.05)); color: var(--text, #e2e8f0); border: 1px solid var(--line, rgba(255,255,255,0.1)); padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">{{ $sub->razorpay_payment_id }}</code>
                        @else
                            <span style="font-size: 0.85rem; color: var(--muted, #64748b); font-style: italic;">Test Mode / Free</span>
                        @endif
                    </td>
                    <td>
                        @if($sub->razorpay_order_id)
                            <code class="sub-code-block" style="background: var(--bg-2, rgba(255,255,255,0.05)); color: var(--text, #e2e8f0); border: 1px solid var(--line, rgba(255,255,255,0.1)); padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">{{ $sub->razorpay_order_id }}</code>
                        @else
                            <span style="font-size: 0.85rem; color: var(--muted, #64748b);">N/A</span>
                        @endif
                    </td>
                    <td>
                        <div class="sub-duration-text" style="font-size: 0.85rem; color: var(--muted, #aab7cb); line-height: 1.4;">
                            <div style="font-weight: 600;">{{ $sub->starts_at ? $sub->starts_at->format('Y-m-d') : 'N/A' }}</div>
                            <div style="font-size: 0.78rem; opacity: 0.8;">to {{ $sub->ends_at ? $sub->ends_at->format('Y-m-d') : 'N/A' }}</div>
                        </div>
                    </td>
                    <td>
                        @if($sub->isValid())
                            <span class="badge" style="background: #dcfce7; color: #067647; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 0.78rem;">Active</span>
                        @else
                            <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 0.78rem; border: 1px solid #cbd5e1;">Expired</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; align-items: center; gap: 6px;">
                            <button type="button" class="btn-sub-edit edit-subscription-btn" title="Edit Subscription"
                                data-id="{{ $sub->id }}"
                                data-vendor_id="{{ $sub->vendor_id }}"
                                data-package_id="{{ $sub->package_id }}"
                                data-starts_at="{{ $sub->starts_at ? $sub->starts_at->format('Y-m-d') : '' }}"
                                data-ends_at="{{ $sub->ends_at ? $sub->ends_at->format('Y-m-d') : '' }}"
                                data-amount_paid="{{ $sub->amount_paid }}"
                                data-status="{{ $sub->status }}"
                                data-payment_id="{{ $sub->razorpay_payment_id }}">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                            </button>

                            <a href="javascript:void(0);" onclick="showInvoice('{{ route('admin.subscriptions.invoice', $sub->id) }}')" class="btn-sub-invoice" title="View Invoice">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            </a>

                            <form action="{{ route('admin.subscriptions.destroy', $sub->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-sub-delete delete-subscription-btn" title="Delete Subscription">
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: var(--muted, #aab7cb); padding: 30px;">
                        No subscription or payment logs found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($subscriptions->hasPages())
    <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-top: 1px solid var(--line, rgba(255,255,255,0.05));">
        <div class="text-muted small">
            Showing {{ $subscriptions->firstItem() ?? 0 }} to {{ $subscriptions->lastItem() ?? 0 }} of {{ $subscriptions->total() }} results
        </div>
        <div class="pagination-wrapper">
            {{ $subscriptions->appends(['status' => $status])->links() }}
        </div>
    </div>
@endif
