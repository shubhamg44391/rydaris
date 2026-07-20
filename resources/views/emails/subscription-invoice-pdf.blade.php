<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #INV-{{ $subscription->created_at->format('Y') }}-{{ str_pad($subscription->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 13px;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        .header-table, .meta-table, .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .header-table td, .meta-table td {
            vertical-align: top;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #0b1020;
            margin: 0;
        }
        .text-right {
            text-align: right;
        }
        .company-details h3 {
            margin: 0;
            font-size: 16px;
            color: #00a4e4;
        }
        .company-details p {
            margin: 5px 0 0 0;
            color: #555;
            font-size: 12px;
        }
        .meta-col-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #888;
            font-weight: bold;
            margin-bottom: 8px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }
        .meta-value {
            line-height: 1.6;
        }
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-items th {
            background-color: #0b1020;
            color: #ffffff;
            font-weight: bold;
            padding: 10px;
            font-size: 11px;
            text-transform: uppercase;
            text-align: left;
            border-bottom: 2px solid #52ead2;
        }
        .invoice-items td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
        }
        .invoice-items th.text-right, .invoice-items td.text-right {
            text-align: right;
        }
        .invoice-items td.desc strong {
            display: block;
            font-size: 14px;
            color: #111;
            margin-bottom: 4px;
        }
        .invoice-items td.desc span {
            font-size: 11px;
            color: #666;
        }
        .summary-wrapper-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-wrapper-table td {
            vertical-align: top;
        }
        .summary-inner-table {
            width: 280px;
            float: right;
            border-collapse: collapse;
        }
        .summary-inner-table td {
            padding: 6px 0;
            color: #555;
        }
        .summary-inner-table td.val {
            text-align: right;
            font-weight: bold;
            color: #111;
        }
        .summary-inner-table tr.total td {
            border-top: 1px solid #ddd;
            font-size: 15px;
            font-weight: bold;
            padding-top: 10px;
            color: #0b1020;
        }
        .summary-inner-table tr.total td.val {
            color: #00a4e4;
        }
        .footer {
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
        .footer h5 {
            margin: 0 0 5px 0;
            color: #0b1020;
            font-size: 12px;
        }
        .thank-you {
            margin-top: 15px;
            font-weight: bold;
            color: #00a4e4;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        
        <table class="header-table">
            <tr>
                <td>
                    @if(file_exists(public_path('assets/logo/rydaris-logo.png')))
                        <img src="{{ public_path('assets/logo/rydaris-logo.png') }}" style="height: 35px;">
                    @else
                        <span style="font-size: 20px; font-weight: bold; color: #0b1020;">RYDARIS</span>
                    @endif
                    <p style="margin: 5px 0 0 0; font-size: 11px; color: #666;">Rental Management Simplified</p>
                </td>
                <td class="text-right company-details">
                    <h3>Rydaris Operations</h3>
                    <p>
                        support@rydaris.com<br>
                        +91 88826 88646
                    </p>
                </td>
            </tr>
        </table>

        
        <table class="meta-table">
            <tr>
                <td style="width: 50%;">
                    <div class="meta-col-title">Billed To:</div>
                    <div class="meta-value">
                        <strong>{{ $subscription->vendor->name ?? 'N/A' }}</strong><br>
                        @if($subscription->vendor->company_name)
                            {{ $subscription->vendor->company_name }}<br>
                        @endif
                        {{ $subscription->street_address ?? '' }}<br>
                        @if($subscription->landmark)
                            {{ $subscription->landmark }}<br>
                        @endif
                        {{ $subscription->city ?? '' }}{{ $subscription->pincode ? ' - ' . $subscription->pincode : '' }}<br>
                        {{ $subscription->country ?? '' }}<br>
                        {{ $subscription->vendor->email ?? '' }}
                    </div>
                </td>
                <td style="width: 50%; padding-left: 40px;">
                    <div class="meta-col-title">Invoice Details:</div>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 3px 0; color: #666;">Invoice No:</td>
                            <td style="padding: 3px 0; font-weight: bold; text-align: right;">#INV-{{ $subscription->created_at->format('Y') }}-{{ str_pad($subscription->id, 4, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 0; color: #666;">Date:</td>
                            <td style="padding: 3px 0; font-weight: bold; text-align: right;">{{ $subscription->created_at->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 0; color: #666;">Due Date:</td>
                            <td style="padding: 3px 0; font-weight: bold; text-align: right;">{{ $subscription->starts_at->format('F d, Y') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        
        <table class="invoice-items">
            <thead>
                <tr>
                    <th style="width: 50%;">Description</th>
                    <th style="width: 15%; text-align: right;">Quantity</th>
                    <th style="width: 15%; text-align: right;">Unit Price</th>
                    <th style="width: 20%; text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
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
                <tr>
                    <td class="desc">
                        <strong>{{ optional($subscription->package)->name ?? 'Standard Package' }} Plan</strong>
                        @if(optional($subscription->package)->description)
                            <div style="font-size: 11px; color: #666; margin-top: 4px;">{{ $subscription->package->description }}</div>
                        @endif
                        <span style="font-size: 11px; color: #00a4e4; display: block; margin-top: 4px;">
                            Period: {{ $subscription->starts_at->format('d M Y') }} to {{ $subscription->ends_at->format('d M Y') }}
                        </span>
                    </td>
                    <td class="text-right">1</td>
                    <td class="text-right">₹{{ number_format($subtotal, 2) }}</td>
                    <td class="text-right">₹{{ number_format($subtotal, 2) }}</td>
                </tr>
            </tbody>
        </table>

        
        <table class="summary-wrapper-table">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%;">
                    <table class="summary-inner-table">
                        <tr>
                            <td>Subtotal:</td>
                            <td class="val">₹{{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td>CGST (9%):</td>
                            <td class="val">₹{{ number_format($cgst, 2) }}</td>
                        </tr>
                        <tr>
                            <td>SGST (9%):</td>
                            <td class="val">₹{{ number_format($sgst, 2) }}</td>
                        </tr>
                        <tr class="total">
                            <td>Total Price:</td>
                            <td class="val">₹{{ number_format($total, 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        
        <div class="footer">
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
</body>
</html>
