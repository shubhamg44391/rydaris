@extends('admin.layouts.app')

@section('main-content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4" style="color: #f8fafc;">
        <span style="color: #aab7cb; font-weight: 300;">Subscription /</span> History
    </h4>

    
    @php $active = $subscriptions->firstWhere('status', 'active'); @endphp
    @if($active && $active->package)
        <div style="background: linear-gradient(135deg, rgba(82,234,210,0.12), rgba(82,234,210,0.04)); border: 1px solid rgba(82,234,210,0.3); border-radius: 16px; padding: 20px 24px; margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(82,234,210,0.15); display: flex; align-items: center; justify-content: center;">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#52ead2" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                </div>
                <div>
                    <p style="margin:0; font-size: 0.78rem; color: #52ead2; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Currently Active Plan</p>
                    <p style="margin: 4px 0 0; font-size: 1.1rem; font-weight: 800; color: #f8fafc;">{{ $active->package->name }}</p>
                </div>
            </div>
            <div style="display: flex; gap: 24px; flex-wrap: wrap; text-align: center;">
                <div>
                    <p style="margin:0; font-size: 0.72rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px;">Starts</p>
                    <p style="margin: 2px 0 0; font-size: 0.9rem; color: #f1f5f9; font-weight: 600;">{{ optional($active->starts_at)->format('d M Y') }}</p>
                </div>
                <div>
                    <p style="margin:0; font-size: 0.72rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px;">Expires</p>
                    <p style="margin: 2px 0 0; font-size: 0.9rem; color: #f1f5f9; font-weight: 600;">{{ optional($active->ends_at)->format('d M Y') }}</p>
                </div>
                <div>
                    <p style="margin:0; font-size: 0.72rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px;">Amount Paid</p>
                    <p style="margin: 2px 0 0; font-size: 0.9rem; font-weight: 700; color: #52ead2;">
                        @if($active->amount_paid > 0) &#8377;{{ number_format($active->amount_paid, 2) }} @else Free @endif
                    </p>
                </div>
            </div>
            <span style="background: #dcfce7; color: #067647; font-size: 0.78rem; font-weight: 700; padding: 5px 14px; border-radius: 20px;">&#9679; Active</span>
        </div>
    @else
        <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; padding: 20px 24px; margin-bottom: 28px; display: flex; align-items: center; gap: 14px;">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#f59e0b" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span style="color: #f59e0b; font-weight: 600; font-size: 0.9rem;">
                You have no active subscription.
                <a href="{{ route('vendor.pricing') }}" style="color: #52ead2; text-decoration: underline; margin-left: 6px;">View Plans &#8594;</a>
            </span>
        </div>
    @endif

    
    <div class="admin-panel">
        <div class="panel-head" style="padding: 18px 24px; display: flex; align-items: center; justify-content: space-between;">
            <h2 style="font-size: 1rem; margin: 0; display: flex; align-items: center; gap: 8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                All Subscription Records
            </h2>
            <a href="{{ route('vendor.pricing') }}" style="font-size: 0.82rem; color: #52ead2; text-decoration: none; font-weight: 600;">Browse Plans &#8594;</a>
        </div>
        <div class="panel-body admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Package</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Expiry Date</th>
                        <th>Amount Paid</th>
                        <th>Method</th>
                        <th>Payment ID</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subscriptions as $index => $sub)
                        @php $isActive = $sub->status === 'active'; @endphp
                        <tr @if($isActive) style="background: rgba(82,234,210,0.03);" @endif>
                            <td style="color:#64748b; font-size:0.82rem;">{{ $index + 1 }}</td>
                            <td style="font-weight:700; font-size:0.9rem; color: {{ $isActive ? '#52ead2' : '#94a3b8' }};">
                                {{ optional($sub->package)->name ?? 'Unknown Package' }}
                            </td>
                            <td>
                                @if($isActive)
                                    <span style="background:#dcfce7; color:#067647; font-size:0.75rem; font-weight:700; padding:3px 11px; border-radius:20px;">Active</span>
                                @elseif($sub->status === 'expired')
                                    <span style="background:#f1f5f9; color:#64748b; font-size:0.75rem; font-weight:700; padding:3px 11px; border-radius:20px;">Expired</span>
                                @else
                                    <span style="background:rgba(245,158,11,0.1); color:#f59e0b; font-size:0.75rem; font-weight:700; padding:3px 11px; border-radius:20px;">{{ ucfirst($sub->status) }}</span>
                                @endif
                            </td>
                            <td style="font-size:0.85rem; color:#94a3b8;">{{ optional($sub->starts_at)->format('d M Y') }}</td>
                            <td style="font-size:0.85rem; color:#94a3b8;">{{ optional($sub->ends_at)->format('d M Y') }}</td>
                            <td style="font-weight:700; font-size:0.9rem;">
                                @if($sub->amount_paid > 0)
                                    <span style="color:#f1f5f9;">&#8377;{{ number_format($sub->amount_paid, 2) }}</span>
                                @else
                                    <span style="color:#52ead2;">Free</span>
                                @endif
                            </td>
                            <td style="font-weight: 500; font-size: 0.8rem;">
                                <span class="badge" style="background: rgba(82,234,210,0.1); color: #52ead2; padding: 4px 8px; border-radius: 4px;">
                                    {{ $sub->payment_method }}
                                </span>
                            </td>
                            <td style="font-size:0.75rem; color:#64748b; font-family:monospace;">
                                {{ $sub->razorpay_payment_id ?? '—' }}
                            </td>
                            <td style="text-align: right;">
                                <a href="javascript:void(0);" onclick="showInvoice('{{ route('vendor.subscription.invoice', $sub->id) }}')" style="background: rgba(82,234,210,0.1); color: #52ead2; border: 1px solid rgba(82,234,210,0.3); padding: 5px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                    Invoice
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center; padding:40px; color:#64748b;">
                                No subscription history found.
                                <a href="{{ route('vendor.pricing') }}" style="color:#52ead2; display:block; margin-top:6px; font-size:0.85rem;">Browse Plans &#8594;</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
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

