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
                        <th>Method</th>
                        <th>Payment ID (Ref No)</th>
                        <th>Order ID</th>
                        <th>Duration (Start - End)</th>
                        <th>Status</th>
                        <th style="text-align: right;">Action</th>
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
                                    {{ $sub->amount_paid ? '$' . number_format($sub->amount_paid / 83, 2) : 'N/A' }}
                                </strong>
                            </td>
                            <td>
                                <span class="badge" style="background: rgba(82,234,210,0.1); color: #52ead2; padding: 4px 8px; border-radius: 4px; font-weight: 500; font-size: 0.8rem; text-transform: capitalize;">
                                    {{ $sub->payment_method ?? 'Unknown' }}
                                </span>
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
                            <td style="text-align: right;">
                                <a href="javascript:void(0);" onclick="showInvoice('{{ route('admin.subscriptions.invoice', $sub->id) }}')" style="background: rgba(82,234,210,0.1); color: #52ead2; border: 1px solid rgba(82,234,210,0.3); padding: 5px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                    Invoice
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: #aab7cb; padding: 30px;">
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

    
    <div id="invoiceModal" style="display: none; position: fixed; inset: 0; z-index: 100000; padding: 16px; box-sizing: border-box; align-items: center; justify-content: center;">
        
        <div style="position: absolute; inset: 0; background: rgba(5, 7, 17, 0.85); backdrop-filter: blur(8px);" onclick="closeInvoiceModal()"></div>
        
        
        <div style="position: relative; z-index: 1; width: 100%; max-width: 900px; height: calc(100vh - 40px); background: #050711; border-radius: 12px; overflow: hidden; box-shadow: 0 24px 80px rgba(0,0,0,0.7); display: flex; flex-direction: column; border: 1px solid rgba(82, 234, 210, 0.25);">
            
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid rgba(82, 234, 210, 0.2); background: #0b1020;">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #ffffff;">Package Invoice</h3>
                <button onclick="closeInvoiceModal()" style="background: none; border: none; font-size: 24px; color: #94a3b8; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            
            
            <iframe id="invoiceIframe" style="width: 100%; height: 100%; border: none; background: #050711;"></iframe>
        </div>
    </div>

    <script>
        function showInvoice(url) {
            var modal = document.getElementById('invoiceModal');
            var iframe = document.getElementById('invoiceIframe');
            
            iframe.src = url;
            modal.style.display = 'flex';
        }

        function closeInvoiceModal() {
            var modal = document.getElementById('invoiceModal');
            var iframe = document.getElementById('invoiceIframe');
            
            modal.style.display = 'none';
            iframe.src = '';
        }
    </script>
@endsection
