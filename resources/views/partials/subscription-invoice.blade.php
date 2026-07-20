<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #INV-{{ $subscription->created_at->format('Y') }}-{{ str_pad($subscription->id, 4, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #050711;
            color: #f8fafc;
            margin: 0;
            padding: 40px 20px;
        }
        .invoice-card {
            max-width: 850px;
            margin: 0 auto;
            background: #0b1020;
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
            padding: 60px 80px;
            box-sizing: border-box;
            border: 1px solid rgba(82, 234, 210, 0.2);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 40px;
            margin-bottom: 40px;
        }
        .brand-section p {
            margin: 4px 0 0 0;
            font-size: 0.9rem;
            color: #94a3b8;
        }
        .company-details {
            text-align: right;
        }
        .company-details h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: #52ead2;
        }
        .company-details p {
            margin: 6px 0 0 0;
            font-size: 0.85rem;
            color: #94a3b8;
            line-height: 1.5;
        }
        .invoice-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .meta-col h4 {
            margin: 0 0 12px 0;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #52ead2;
        }
        .meta-col p {
            margin: 4px 0;
            font-size: 0.9rem;
            line-height: 1.5;
            color: #f1f5f9;
        }
        .meta-col p strong {
            color: #ffffff;
            font-size: 1rem;
        }
        .details-col {
            text-align: right;
        }
        .details-grid {
            display: grid;
            grid-template-columns: auto auto;
            gap: 8px 24px;
            justify-content: right;
            font-size: 0.9rem;
        }
        .details-grid .label {
            color: #94a3b8;
            text-align: right;
        }
        .details-grid .val {
            font-weight: 600;
            color: #ffffff;
            text-align: left;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .invoice-table th {
            background-color: #0d1527;
            color: #52ead2;
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid rgba(82, 234, 210, 0.2);
            white-space: nowrap;
        }
        .invoice-table td {
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.9rem;
            color: #f1f5f9;
        }
        .invoice-table th:nth-child(2), .invoice-table td:nth-child(2),
        .invoice-table th:nth-child(3), .invoice-table td:nth-child(3),
        .invoice-table th:nth-child(4), .invoice-table td:nth-child(4) {
            text-align: right;
        }
        .invoice-table td.desc strong {
            display: block;
            font-size: 0.95rem;
            color: #ffffff;
            margin-bottom: 4px;
        }
        .invoice-table td.desc span {
            font-size: 0.8rem;
            color: #94a3b8;
        }
        .summary-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 50px;
        }
        .summary-table {
            width: 320px;
            font-size: 0.9rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            color: #94a3b8;
        }
        .summary-row .val {
            color: #ffffff;
            font-weight: 600;
        }
        .summary-row.total {
            border-top: 1px solid rgba(82, 234, 210, 0.25);
            padding-top: 14px;
            margin-top: 6px;
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 800;
        }
        .summary-row.total .val {
            color: #52ead2;
        }
        .invoice-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 30px;
            text-align: center;
        }
        .invoice-footer h5 {
            margin: 0 0 8px 0;
            font-size: 0.85rem;
            font-weight: 700;
            color: #52ead2;
        }
        .invoice-footer p {
            margin: 0;
            font-size: 0.8rem;
            color: #94a3b8;
            line-height: 1.4;
        }
        .invoice-footer .thank-you {
            margin-top: 24px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #52ead2;
        }
        
        /* Interactive Controls */
        .controls {
            max-width: 850px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .back-btn {
            text-decoration: none;
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }
        .back-btn:hover {
            color: #52ead2;
        }
        .print-btn {
            background-color: #1e293b;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: all 0.2s;
        }
        .print-btn:hover {
            background-color: #0f172a;
        }
        #download-pdf-btn {
            background-color: #52ead2;
            color: #050711;
            border: none;
            box-shadow: 0 2px 4px rgba(82, 234, 210, 0.25);
        }
        #download-pdf-btn:hover {
            background-color: #2bc2a8;
        }

        @media print {
            body {
                background-color: #ffffff !important;
                color: #1e293b !important;
                padding: 0;
            }
            .invoice-card {
                background: #ffffff !important;
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                color: #1e293b !important;
            }
            .invoice-header {
                border-bottom: 2px solid #f1f5f9 !important;
            }
            .company-details h3 {
                color: #0b1020 !important;
            }
            .company-details p, .brand-section p, .meta-col p, .details-grid .label, .invoice-table td.desc span, .invoice-table td.desc div, .summary-row, .invoice-footer p {
                color: #64748b !important;
            }
            .meta-col h4, .invoice-footer h5 {
                color: #0b1020 !important;
            }
            .meta-col p strong, .details-grid .val, .invoice-table td.desc strong, .summary-row .val, .summary-row.total {
                color: #0b1020 !important;
            }
            .invoice-table th {
                background-color: #f8fafc !important;
                color: #475569 !important;
                border-bottom: 1px solid #e2e8f0 !important;
            }
            .invoice-table td {
                border-bottom: 1px solid #f1f5f9 !important;
                color: #1e293b !important;
            }
            .summary-row.total {
                border-top: 1px solid #e2e8f0 !important;
            }
            .summary-row.total .val, .invoice-footer .thank-you {
                color: #3b82f6 !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="controls no-print">
        <a href="javascript:window.history.back();" class="back-btn">
            &larr; Back
        </a>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print();" class="print-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Print Invoice
            </button>
            <button id="download-pdf-btn" class="print-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download PDF
            </button>
        </div>
    </div>

    @php
        $total = $subscription->amount_paid;
        if ($total > 0) {
            $subtotal = $total / 1.18;
            $gst = $total - $subtotal;
            $cgst = $gst / 2;
            $sgst = $gst / 2;
        } else {
            $subtotal = 0;
            $gst = 0;
            $cgst = 0;
            $sgst = 0;
        }
    @endphp

    <div class="invoice-card">
        <div class="invoice-header">
            <div class="brand-section">
                <img src="{{ asset('assets/logo/rydaris-logo.png') }}" alt="Rydaris Logo" style="height: 32px; width: auto; display: block; margin-bottom: 6px;">
                <p>Rental Management Simplified</p>
            </div>
            <div class="company-details">
                <h3>Rydaris Operations</h3>
                <p>
                    support@rydaris.com<br>
                    +91 88826 88646
                </p>
            </div>
        </div>

        <div class="invoice-meta">
            <div class="meta-col">
                <h4>Billed To:</h4>
                <p><strong>{{ $subscription->vendor->name ?? 'N/A' }}</strong></p>
                @if($subscription->vendor->company_name)
                    <p>{{ $subscription->vendor->company_name }}</p>
                @endif
                <p>
                    {{ $subscription->street_address ?? '' }}<br>
                    @if($subscription->landmark)
                        {{ $subscription->landmark }}<br>
                    @endif
                    {{ $subscription->city ?? '' }}{{ $subscription->pincode ? ' - ' . $subscription->pincode : '' }}<br>
                    {{ $subscription->country ?? '' }}
                </p>
                <p>{{ $subscription->vendor->email ?? '' }}</p>
            </div>
            <div class="meta-col details-col">
                <h4>Invoice Details:</h4>
                <div class="details-grid">
                    <div class="label">Invoice No:</div>
                    <div class="val">#INV-{{ $subscription->created_at->format('Y') }}-{{ str_pad($subscription->id, 4, '0', STR_PAD_LEFT) }}</div>
                    
                    <div class="label">Date:</div>
                    <div class="val">{{ $subscription->created_at->format('F d, Y') }}</div>
                    
                    <div class="label">Due Date:</div>
                    <div class="val">{{ $subscription->starts_at->format('F d, Y') }}</div>
                    
                    
                </div>
            </div>
        </div>

        <table class="invoice-table" style="width: 100%; border-collapse: collapse; margin-bottom: 40px; table-layout: fixed;">
            <thead>
                <tr>
                    <th style="width: 55%;">Description</th>
                    <th style="width: 15%;">Quantity</th>
                    <th style="width: 15%;">Unit Price</th>
                    <th style="width: 15%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="desc">
                        <strong style="display: block; font-size: 1.05rem; color: #ffffff; margin-bottom: 6px;">
                            {{ optional($subscription->package)->name ?? 'Standard Package' }} Plan
                        </strong>
                        @if(optional($subscription->package)->description)
                            <div style="font-size: 0.85rem; color: #94a3b8; margin-bottom: 8px; line-height: 1.4;">
                                {{ $subscription->package->description }}
                            </div>
                        @endif
                        <span style="font-size: 0.8rem; color: #52ead2; display: block; font-weight: 500; margin-bottom: 8px;">
                            Subscription Period: {{ $subscription->starts_at->format('d M Y') }} to {{ $subscription->ends_at->format('d M Y') }}
                        </span>
                        
                        @if(optional($subscription->package)->no_of_users || optional($subscription->package)->no_of_vehicles || optional($subscription->package)->no_of_locations)
                            <div style="font-size: 0.78rem; color: #a8b3c5; line-height: 1.5; margin-top: 6px;">
                                @if(optional($subscription->package)->no_of_users)
                                    <span style="display: inline-block; margin-right: 12px;">• Max Users: {{ $subscription->package->no_of_users == -1 ? 'Unlimited' : $subscription->package->no_of_users }}</span>
                                @endif
                                @if(optional($subscription->package)->no_of_vehicles)
                                    <span style="display: inline-block; margin-right: 12px;">• Max Vehicles: {{ $subscription->package->no_of_vehicles == -1 ? 'Unlimited' : $subscription->package->no_of_vehicles }}</span>
                                @endif
                                @if(optional($subscription->package)->no_of_locations)
                                    <span style="display: inline-block; margin-right: 12px;">• Max Locations: {{ $subscription->package->no_of_locations == -1 ? 'Unlimited' : $subscription->package->no_of_locations }}</span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td>1</td>
                    <td>
                        ₹{{ number_format($subtotal, 2) }}
                    </td>
                    <td>
                        ₹{{ number_format($subtotal, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="summary-section">
            <div class="summary-table">
                <div class="summary-row">
                    <div class="label">Subtotal:</div>
                    <div class="val">₹{{ number_format($subtotal, 2) }}</div>
                </div>
                <div class="summary-row">
                    <div class="label">CGST (9%):</div>
                    <div class="val">₹{{ number_format($cgst, 2) }}</div>
                </div>
                <div class="summary-row">
                    <div class="label">SGST (9%):</div>
                    <div class="val">₹{{ number_format($sgst, 2) }}</div>
                </div>
                <div class="summary-row total">
                    <div class="label" style="white-space: nowrap;">Total Price (incl. 18.00% tax):</div>
                    <div class="val">₹{{ number_format($total, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="invoice-footer">
            <h5>Payment Terms</h5>
            <p>
                Payment is processed securely. 
                @if($subscription->razorpay_payment_id)
                    Reference Transaction ID: {{ $subscription->razorpay_payment_id }}.
                @else
                    Processed in Free / Trial Mode.
                @endif
            </p>
            <div class="thank-you">Thank you for your business!</div>
        </div>
    </div>

    <script>
        document.getElementById('download-pdf-btn').addEventListener('click', function() {
            var element = document.querySelector('.invoice-card');
            
            var opt = {
                margin:       [10, 10, 10, 10],
                filename:     'Invoice_#INV-{{ $subscription->created_at->format("Y") }}-{{ str_pad($subscription->id, 4, "0", STR_PAD_LEFT) }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2.5, useCORS: true, letterRendering: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            html2pdf().set(opt).from(element).save();
        });
    </script>
</body>
</html>
