<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Invoice - #{{ $booking->reservation_number }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    
    <style>
        :root {
            --brand: #52ead2;
            --brand-dark: #00a4e4;
            --bg: #050711;
            --bg-2: #0b1020;
            --text: #f8fafc;
            --muted: #a8b3c5;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Public Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Interactive Controls */
        .controls {
            max-width: 800px;
            width: 100%;
            margin: 20px auto 10px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            box-sizing: border-box;
        }
        .back-btn {
            text-decoration: none;
            background: rgba(82, 234, 210, 0.05);
            border: 1px solid rgba(82, 234, 210, 0.25);
            color: var(--brand, #52ead2);
            font-size: 0.85rem;
            font-weight: 700;
            border-radius: 6px;
            padding: 8px 16px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease-in-out;
        }
        .back-btn:hover {
            background: rgba(82, 234, 210, 0.15);
            color: #ffffff;
            border-color: var(--brand, #52ead2);
            transform: translateY(-1px);
        }
        .action-buttons {
            display: flex;
            gap: 12px;
        }
        .btn-action {
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }
        .btn-print {
            background: rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .btn-print:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }
        .btn-download {
            background: var(--brand);
            color: #050711;
        }
        .btn-download:hover {
            background: #3ecab2;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(82, 234, 210, 0.2);
        }

        /* Invoice Container */
        .invoice-card {
            max-width: 800px;
            width: 100%;
            margin: 10px auto 40px auto;
            background: var(--bg-2);
            color: var(--text);
            border-radius: 16px;
            padding: 50px 60px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(82, 234, 210, 0.2);
            box-sizing: border-box;
        }

        /* Invoice Header */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: 0.5px;
        }
        .invoice-title p {
            margin: 5px 0 0 0;
            font-size: 0.95rem;
            color: var(--muted);
            font-weight: 600;
        }
        
        .separator-line {
            height: 3px;
            background: linear-gradient(90deg, var(--brand), var(--brand-dark));
            margin-bottom: 35px;
        }

        /* Details Section */
        .details-row {
            display: flex;
            gap: 40px;
            margin-bottom: 35px;
        }
        .details-col {
            flex: 1;
        }
        .details-col h4 {
            margin: 0 0 12px 0;
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--brand);
            text-transform: uppercase;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            padding-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .info-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--muted);
        }
        .info-item {
            display: flex;
        }
        .info-label {
            font-weight: 700;
            color: var(--muted);
            width: 130px;
            flex-shrink: 0;
        }
        .info-value {
            font-weight: 600;
            color: var(--text);
        }

        /* Card Section Styles */
        .section-box {
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.02);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 25px;
        }
        .section-header {
            background: rgba(255, 255, 255, 0.04);
            padding: 10px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            font-weight: 800;
            font-size: 0.9rem;
            color: var(--brand);
        }
        .section-body {
            padding: 15px;
            font-size: 0.85rem;
            color: var(--text);
        }

        /* Tables */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }
        .invoice-table th {
            background: rgba(255, 255, 255, 0.04);
            padding: 10px 15px;
            font-weight: 700;
            color: var(--brand);
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }
        .invoice-table td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text);
        }
        .invoice-table tr:last-child td {
            border-bottom: none;
        }

        /* Summary Panel */
        .summary-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }
        .summary-table {
            width: 320px;
            font-size: 0.85rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            color: var(--muted);
        }
        .summary-row.total {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 12px;
            margin-top: 6px;
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text);
        }
        
        .footer-terms {
            margin-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            text-align: center;
            font-size: 0.8rem;
            color: var(--muted);
            line-height: 1.4;
        }

        /* Custom styles for details and text inside card */
        .rental-label {
            font-weight: 700;
            color: var(--muted);
            margin-bottom: 4px;
            font-size: 0.75rem;
            text-transform: uppercase;
        }
        .rental-value {
            font-weight: 600;
            color: var(--text);
            font-size: 0.85rem;
        }
        .rental-sub {
            color: var(--muted);
            font-size: 0.8rem;
            margin-top: 3px;
        }
        .rental-divider {
            width: 1px;
            background: rgba(255, 255, 255, 0.1);
        }
        .vehicle-desc {
            font-weight: 700;
            color: var(--text);
        }
        .extra-desc {
            padding-left: 25px;
            color: var(--muted);
        }
        .extra-amount {
            color: var(--muted);
        }
        .summary-dashed {
            border-top: 1px dashed rgba(255, 255, 255, 0.1);
            padding-top: 8px;
            margin-top: 4px;
            font-weight: 600;
        }

        /* Hide elements on Print */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .controls {
                display: none !important;
            }
            .invoice-card {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                background: #ffffff !important;
                color: #000000 !important;
                border: none !important;
            }
            .invoice-title h1 {
                color: #000000 !important;
            }
            .invoice-title p {
                color: #64748b !important;
            }
            .details-col h4 {
                color: #000000 !important;
                border-bottom: 1px solid #cbd5e1 !important;
            }
            .info-list {
                color: #475569 !important;
            }
            .info-label {
                color: #475569 !important;
            }
            .info-value {
                color: #000000 !important;
            }
            .section-box {
                border: 1px solid #cbd5e1 !important;
                background: none !important;
            }
            .section-header {
                background: #f8fafc !important;
                color: #000000 !important;
                border-bottom: 1px solid #cbd5e1 !important;
            }
            .section-body {
                color: #000000 !important;
            }
            .rental-label {
                color: #475569 !important;
            }
            .rental-value {
                color: #000000 !important;
            }
            .rental-sub {
                color: #64748b !important;
            }
            .rental-divider {
                background: #cbd5e1 !important;
            }
            .invoice-table th {
                background: #f8fafc !important;
                color: #475569 !important;
                border-bottom: 1px solid #cbd5e1 !important;
            }
            .invoice-table td {
                border-bottom: 1px solid #f1f5f9 !important;
                color: #000000 !important;
            }
            .vehicle-desc {
                color: #000000 !important;
            }
            .extra-desc {
                color: #475569 !important;
            }
            .extra-amount {
                color: #475569 !important;
            }
            .summary-row {
                color: #475569 !important;
            }
            .summary-row.total {
                border-top: 1px solid #cbd5e1 !important;
                color: #000000 !important;
            }
            .summary-row.total span:last-child {
                color: #000000 !important;
            }
            .summary-dashed {
                border-top: 1px dashed #cbd5e1 !important;
            }
            .footer-terms {
                border-top: 1px solid #cbd5e1 !important;
                color: #64748b !important;
            }
        }
    </style>
</head>
<body>

    <!-- Controls Row -->
    <div class="controls">
        <a href="javascript:void(0);" onclick="window.parent.closeInvoiceModal ? window.parent.closeInvoiceModal() : window.history.back();" class="back-btn">
            <i class="fa fa-arrow-left"></i> Back to Dashboard
        </a>
        <div class="action-buttons">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fa fa-print"></i> Print Invoice
            </button>
            <button id="download-pdf-btn" class="btn-action btn-download">
                <i class="fa fa-file-pdf"></i> Download PDF
            </button>
        </div>
    </div>

    <!-- Invoice Sheet -->
    @php
        $logoBase64 = null;
        $vendor = $booking->vehicle->vendor ?? null;
        if ($vendor && $vendor->company_logo) {
            $logoPath = storage_path('app/public/' . $vendor->company_logo);
            if (file_exists($logoPath)) {
                $logoData = base64_encode(file_get_contents($logoPath));
                $mimeType = mime_content_type($logoPath);
                $logoBase64 = 'data:' . $mimeType . ';base64,' . $logoData;
            }
        }
        
        // Calculate Rental Days
        $pDate = $booking->pickup_date_parsed;
        $rDate = $booking->return_date_parsed;
        $rentalDays = $pDate->diffInDays($rDate);
        $rentalDays = $rentalDays > 0 ? $rentalDays : 1;
        
        // Calculate GST Tax breakdown (18%)
        $totalAmount = (float)$booking->total_amount;
        $subtotal = $totalAmount / 1.18;
        $cgst = $subtotal * 0.09;
        $sgst = $subtotal * 0.09;
    @endphp
    
    <div class="invoice-card">
        <!-- Logo & Header -->
        <div class="invoice-header">
            <div>
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="{{ $vendor->company_name ?? $vendor->name }}" style="max-height: 55px; max-width: 180px; object-fit: contain;">
                @elseif($vendor && $vendor->company_logo)
                    <img src="{{ asset('storage/' . $vendor->company_logo) }}" alt="{{ $vendor->company_name ?? $vendor->name }}" style="max-height: 55px; max-width: 180px; object-fit: contain;">
                @else
                    <span style="font-size: 1.5rem; font-weight: 800; color: #00a4e4; letter-spacing: -0.5px;">{{ $vendor->company_name ?? $vendor->name ?? 'Car Rental' }}</span>
                @endif
            </div>
            <div class="invoice-title">
                <h1>BOOKING INVOICE</h1>
                <p>Order #<span>{{ $booking->reservation_number }}</span></p>
            </div>
        </div>

        <div class="separator-line"></div>

        <!-- Details Row -->
        <div class="details-row">
            <div class="details-col">
                <h4>Booking Details</h4>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Order Number:</span>
                        <span class="info-value">{{ $booking->reservation_number }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Invoice Date:</span>
                        <span class="info-value">{{ $booking->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Status:</span>
                        <span class="info-value" style="color: #10b981; font-weight: 700; text-transform: uppercase;">{{ str_replace('_', ' ', $booking->payment_status) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Method:</span>
                        <span class="info-value" style="text-transform: capitalize;">{{ $booking->payment_method_label }}</span>
                    </div>
                    @if($booking->payment_reference)
                    <div class="info-item">
                        <span class="info-label">Transaction Ref:</span>
                        <span class="info-value" style="font-family: monospace; font-size: 0.8rem;">{{ $booking->payment_reference }}</span>
                    </div>
                    @endif
                </div>
            </div>
            <div class="details-col">
                <h4>Customer Details</h4>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <span class="info-value">{{ $booking->customer_fname }} {{ $booking->customer_lname }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $booking->customer_email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $booking->customer_phone }}</span>
                    </div>
                    @if($booking->customer_dob)
                    <div class="info-item">
                        <span class="info-label">DOB:</span>
                        <span class="info-value">{{ $booking->customer_dob_parsed->format('M d, Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Rental Locations Box -->
        <div class="section-box">
            <div class="section-header">Rental Details</div>
            <div class="section-body" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <div class="rental-label">Pickup</div>
                    <div class="rental-value">{{ $booking->pickup_date_parsed->format('M d, Y') }} @ {{ $booking->pickup_time }} Hrs</div>
                    <div class="rental-sub">{{ $booking->pickupLocation->name ?? $booking->pickupLocation->location ?? 'N/A' }}</div>
                </div>
                <div class="rental-divider"></div>
                <div style="flex: 1;">
                    <div class="rental-label">Return</div>
                    <div class="rental-value">{{ $booking->return_date_parsed->format('M d, Y') }} @ {{ $booking->return_time }} Hrs</div>
                    <div class="rental-sub">{{ $booking->returnLocation->name ?? $booking->returnLocation->location ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Itemized Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right; width: 100px;">Days</th>
                    <th style="text-align: right; width: 140px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- Vehicle -->
                <tr>
                    <td class="vehicle-desc">
                        {{ $booking->vehicle->name }} ({{ $booking->vehicle->type ?? 'Vehicle Rental' }})
                    </td>
                    <td align="right">{{ $rentalDays }}</td>
                    <td align="right" style="font-weight: 600;">${{ number_format($booking->total_amount, 2) }}</td>
                </tr>
                
                <!-- Extras if any -->
                @foreach($booking->extras as $extra)
                <tr>
                    <td class="extra-desc">
                        • {{ $extra->vendorExtra->name ?? 'Extra Service' }} (Qty: {{ $extra->qty }})
                    </td>
                    <td align="right">—</td>
                    <td align="right" class="extra-amount">${{ number_format($extra->price * $extra->qty * $rentalDays, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Panel -->
        <div class="summary-wrapper">
            <div class="summary-table">
                <div class="summary-row">
                    <span>Subtotal (Excl. Tax):</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>CGST (9%):</span>
                    <span>${{ number_format($cgst, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>SGST (9%):</span>
                    <span>${{ number_format($sgst, 2) }}</span>
                </div>
                <div class="summary-row total">
                    <span>Total Amount (incl. 18.00% GST):</span>
                    <span style="color: var(--brand-dark);">${{ number_format($totalAmount, 2) }}</span>
                </div>
                <div class="summary-row summary-dashed">
                    <span style="color: #10b981;">Paid Amount:</span>
                    <span style="color: #10b981;">${{ number_format((float)$booking->paid_amount, 2) }}</span>
                </div>
                <div class="summary-row" style="font-weight: 600;">
                    <span style="color: #ef4444;">Pending Due:</span>
                    <span style="color: #ef4444;">${{ number_format((float)$booking->pending_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="footer-terms">
            <h5>Terms & Conditions</h5>
            <p>Please keep a copy of this invoice for your pick-up verification. Rental charges are subject to vendor policy agreements. For support, please contact the vendor directly or write to {{ $vendor->email ?? 'support@carrental.com' }}.</p>
            <p style="margin-top: 15px; font-weight: 700; color: var(--brand-dark);">Thank you for choosing {{ $vendor->company_name ?? $vendor->name ?? 'our Car Rental' }}!</p>
        </div>
    </div>

    <!-- html2pdf scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('download-pdf-btn').addEventListener('click', function() {
            var element = document.querySelector('.invoice-card');
            
            var opt = {
                margin:       [10, 10, 10, 10],
                filename:     'Invoice_#{{ $booking->reservation_number }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2.5, useCORS: true, letterRendering: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            html2pdf().set(opt).from(element).save();
        });
    </script>
</body>
</html>
