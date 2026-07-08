<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - Rydaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
            color: #4a5568;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #ffffff;
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
        }
        .logo {
            max-width: 150px;
        }
        .section {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .section-title {
            background-color: #0f766e;
            color: white;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 18px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            min-width: 150px;
        }
        .info-value {
            flex: 1;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th {
            background-color: #0d6059;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #718096;
        }
        .text-primary {
            color: #0f766e;
        }
        .text-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/logo/logo.png') }}" alt="Rydaris" class="logo">
        </div>
        
        <div class="section-title">NEW BOOKING RECEIVED</div>
        
        <div class="section">
            <div class="info-row">
                <div class="info-label">Booking Reference:</div>
                <div class="info-value text-bold">{{ $booking->reservation_number }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Booking Date:</div>
                <div class="info-value">{{ $booking->created_at->format('d.m.Y H:i') }} Hrs</div>
            </div>
            <div class="info-row">
                <div class="info-label">Payment Status:</div>
                <div class="info-value">{{ ucfirst(str_replace('_', ' ', $booking->payment_status)) }}</div>
            </div>
            @if (!empty($booking->payment_reference))
            <div class="info-row">
                <div class="info-label">Payment Reference:</div>
                <div class="info-value text-bold">{{ $booking->payment_reference }}</div>
            </div>
            @endif
        </div>
        
        <div class="section-title">CUSTOMER DETAILS</div>
        <div class="section">
            <div class="info-row">
                <div class="info-label">Customer Name:</div>
                <div class="info-value text-bold">{{ $booking->customer_fname }} {{ $booking->customer_lname }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value text-primary">{{ $booking->customer_email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Phone:</div>
                <div class="info-value text-primary">{{ $booking->customer_phone }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date of Birth:</div>
                <div class="info-value">{{ $booking->customer_dob ? \Carbon\Carbon::parse($booking->customer_dob)->format('d.m.Y') : '-' }}</div>
            </div>
        </div>
        
        <div class="section-title">RENTAL DETAILS</div>
        <div class="section">
            <table class="table">
                <tr>
                    <th>Pick-up Location</th>
                    <th>Return Location</th>
                </tr>
                <tr>
                    <td>{{ $booking->pickupLocation->name ?? 'N/A' }}</td>
                    <td>{{ $booking->returnLocation->name ?? 'N/A' }}</td>
                </tr>
            </table>
            
            <table class="table">
                <tr>
                    <th>Pick-up Date & Time</th>
                    <th>Return Date & Time</th>
                    <th>Period</th>
                </tr>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d.m.Y') }} {{ $booking->pickup_time }} Hrs</td>
                    <td>{{ \Carbon\Carbon::parse($booking->return_date)->format('d.m.Y') }} {{ $booking->return_time }} Hrs</td>
                    <td>{{ \Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->return_date)) }} Days</td>
                </tr>
            </table>
        </div>
        
        <div class="section-title">SELECTED VEHICLE</div>
        <div class="section">
            <table class="table">
                <tr>
                    <th>Vehicle</th>
                    <th>License Plate</th>
                </tr>
                <tr>
                    <td>{{ $vehicle->name }}</td>
                    <td>{{ $vehicle->license_plate ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        
        <div class="section-title">PAYMENT SUMMARY</div>
        <div class="section">
            <table class="table">
                <tr class="total-row">
                    <td>Total Amount</td>
                    <td>${{ number_format($booking->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Paid Amount</td>
                    <td style="color: green; font-weight: bold;">${{ number_format($booking->paid_amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Pending Amount</td>
                    <td style="color: orange; font-weight: bold;">${{ number_format($booking->pending_amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Payment Method</td>
                    <td style="text-transform: capitalize;">
                        {{ str_replace('_', ' ', $booking->payment_method) }}
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <p>Thank you for choosing Rydaris</p>
            <p>Email: support@rydaris.com</p>
        </div>
    </div>
</body>
</html>
