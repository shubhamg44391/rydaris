<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #INV-{{ $subscription->created_at->format('Y') }}-{{ str_pad($subscription->id, 4, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        html, body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
            color: #1e293b !important;
            margin: 0 !important;
            padding: 30px 20px !important;
        }
        .invoice-card {
            max-width: 850px !important;
            margin: 0 auto !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06) !important;
            padding: 50px 60px !important;
            box-sizing: border-box !important;
            border: 1px solid #e2e8f0 !important;
            color: #1e293b !important;
        }
        .invoice-header {
            display: flex !important;
            justify-content: space-between !important;
            align-items: flex-start !important;
            border-bottom: 2px solid #f1f5f9 !important;
            padding-bottom: 30px !important;
            margin-bottom: 30px !important;
        }
        .brand-section p {
            margin: 4px 0 0 0 !important;
            font-size: 0.9rem !important;
            color: #64748b !important;
        }
        .company-details {
            text-align: right !important;
        }
        .company-details h3 {
            margin: 0 !important;
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
        }
        .company-details p {
            margin: 6px 0 0 0 !important;
            font-size: 0.85rem !important;
            color: #64748b !important;
            line-height: 1.5 !important;
        }
        .invoice-meta {
            display: flex !important;
            justify-content: space-between !important;
            margin-bottom: 35px !important;
        }
        .meta-col h4 {
            margin: 0 0 12px 0 !important;
            font-size: 0.78rem !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            color: #0d9488 !important;
            font-weight: 700 !important;
        }
        .meta-col p {
            margin: 4px 0 !important;
            font-size: 0.9rem !important;
            line-height: 1.5 !important;
            color: #334155 !important;
        }
        .meta-col p strong {
            color: #0f172a !important;
            font-size: 1rem !important;
        }
        .details-col {
            text-align: right !important;
        }
        .details-grid {
            display: grid !important;
            grid-template-columns: auto auto !important;
            gap: 8px 24px !important;
            justify-content: right !important;
            font-size: 0.9rem !important;
        }
        .details-grid .label {
            color: #64748b !important;
            text-align: right !important;
        }
        .details-grid .val {
            font-weight: 700 !important;
            color: #0f172a !important;
            text-align: left !important;
        }
        .invoice-table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-bottom: 35px !important;
        }
        .invoice-table th {
            background-color: #f8fafc !important;
            color: #0f172a !important;
            font-weight: 700 !important;
            font-size: 0.78rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.8px !important;
            padding: 14px 16px !important;
            text-align: left !important;
            border-bottom: 2px solid #e2e8f0 !important;
            white-space: nowrap !important;
        }
        .invoice-table td {
            padding: 18px 16px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 0.9rem !important;
            color: #334155 !important;
        }
        .invoice-table th:nth-child(2), .invoice-table td:nth-child(2),
        .invoice-table th:nth-child(3), .invoice-table td:nth-child(3),
        .invoice-table th:nth-child(4), .invoice-table td:nth-child(4) {
            text-align: right !important;
        }
        .invoice-table td.desc strong {
            display: block !important;
            font-size: 0.95rem !important;
            color: #0f172a !important;
            margin-bottom: 4px !important;
        }
        .invoice-table td.desc span {
            font-size: 0.8rem !important;
            color: #0d9488 !important;
        }
        .summary-section {
            display: flex !important;
            justify-content: flex-end !important;
            margin-bottom: 40px !important;
        }
        .summary-table {
            width: 320px !important;
            font-size: 0.9rem !important;
        }
        .summary-row {
            display: flex !important;
            justify-content: space-between !important;
            padding: 8px 0 !important;
            color: #64748b !important;
        }
        .summary-row .val {
            color: #0f172a !important;
            font-weight: 600 !important;
        }
        .summary-row.total {
            border-top: 2px solid #e2e8f0 !important;
            padding-top: 14px !important;
            margin-top: 6px !important;
            color: #0f172a !important;
            font-size: 1.1rem !important;
            font-weight: 800 !important;
        }
        .summary-row.total .val {
            color: #0d9488 !important;
        }
        .invoice-footer {
            border-top: 2px solid #f1f5f9 !important;
            padding-top: 25px !important;
            text-align: center !important;
        }
        .invoice-footer h5 {
            margin: 0 0 6px 0 !important;
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
        }
        .invoice-footer p {
            margin: 0 !important;
            font-size: 0.8rem !important;
            color: #64748b !important;
            line-height: 1.4 !important;
        }
        .invoice-footer .thank-you {
            margin-top: 20px !important;
            font-size: 0.95rem !important;
            font-weight: 700 !important;
            color: #0d9488 !important;
        }
        
        /* Interactive Controls */
        .controls {
            max-width: 850px !important;
            margin: 0 auto 20px auto !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }
        .back-btn {
            text-decoration: none !important;
            color: #64748b !important;
            font-size: 0.9rem !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            transition: color 0.2s !important;
        }
        .back-btn:hover {
            color: #0f172a !important;
        }
        .print-btn, #download-pdf-btn {
            background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important;
            color: #051013 !important;
            border: none !important;
            padding: 10px 22px !important;
            border-radius: 999px !important;
            font-weight: 800 !important;
            font-size: 0.88rem !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            box-shadow: 0 4px 14px rgba(82, 234, 210, 0.35) !important;
            transition: all 0.25s ease !important;
        }
        .print-btn:hover, #download-pdf-btn:hover {
            background: linear-gradient(135deg, #52ead2 0%, #80a7ff 100%) !important;
            color: #051013 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(82, 234, 210, 0.5) !important;
            opacity: 0.95 !important;
        }

        @media print {
            body {
                background-color: #ffffff !important;
                color: #1e293b !important;
                padding: 0 !important;
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
                color: #0d9488 !important;
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
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Print Invoice
            </button>
            <button id="download-pdf-btn" class="print-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download PDF
            </button>
        </div>
    </div>

    @php
        $total = (float)($subscription->amount_paid ?? 0);
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
                    {{ $site_setting->contact_email ?? 'support@rydaris.com' }}<br>
                    {{ $site_setting->contact_phone ?? '+918882688646' }}
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
                        <strong style="display: block; font-size: 1.05rem; color: #0f172a; margin-bottom: 6px;">
                            {{ optional($subscription->package)->name ?? 'Standard Package' }} Plan
                        </strong>
                        @if(optional($subscription->package)->description)
                            <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 8px; line-height: 1.4;">
                                {{ $subscription->package->description }}
                            </div>
                        @endif
                        <span style="font-size: 0.8rem; color: #0d9488; display: block; font-weight: 600; margin-bottom: 8px;">
                            Subscription Period: {{ $subscription->starts_at->format('d M Y') }} to {{ $subscription->ends_at->format('d M Y') }}
                        </span>
                        
                        @if(optional($subscription->package)->no_of_users || optional($subscription->package)->no_of_vehicles || optional($subscription->package)->no_of_locations)
                            <div style="font-size: 0.78rem; color: #64748b; line-height: 1.5; margin-top: 6px;">
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
