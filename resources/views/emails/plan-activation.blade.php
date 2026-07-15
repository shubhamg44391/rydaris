<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plan Activated - Rydaris</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 40px 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            border-top: 5px solid #52ead2;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .header {
            background-color: #061218;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .header p {
            color: #aab7cb;
            margin: 8px 0 0;
            font-size: 0.9rem;
        }
        .content {
            padding: 35px 30px;
        }
        .welcome-text {
            font-size: 1.1rem;
            color: #0f172a;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .field-group {
            margin-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 12px;
        }
        .field-group:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        .field-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 800;
            color: #64748b;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }
        .field-value {
            font-size: 1rem;
            color: #0f172a;
            font-weight: 500;
        }
        .btn {
            display: inline-block;
            background-color: #061218;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.95rem;
            text-align: center;
            border: 2px solid #52ead2;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: #52ead2;
            color: #061218 !important;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            font-size: 0.8rem;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Subscription Plan Activated!</h1>
            <p>Your subscription on Rydaris has been successfully processed.</p>
        </div>
        <div class="content">
            <div class="welcome-text">
                Hello {{ $subscription->vendor->first_name ?? $subscription->vendor->name }},
            </div>
            <p>We are pleased to inform you that your subscription to the <strong>{{ optional($subscription->package)->name }}</strong> plan has been successfully activated. You now have full access to all features and limits included in your package.</p>
            
            <div class="info-card">
                <h3 style="margin-top: 0; color: #0f172a; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">Subscription Details</h3>
                
                <div class="field-group">
                    <div class="field-label">Package Name</div>
                    <div class="field-value">{{ optional($subscription->package)->name }}</div>
                </div>
                
                <div class="field-group">
                    <div class="field-label">Billing Period</div>
                    <div class="field-value" style="text-transform: capitalize;">{{ str_replace('/', '', optional($subscription->package)->billing_period) }}</div>
                </div>

                <div class="field-group">
                    <div class="field-label">Validity Period</div>
                    <div class="field-value">{{ $subscription->starts_at->format('d M Y') }} to {{ $subscription->ends_at->format('d M Y') }}</div>
                </div>

                <div class="field-group">
                    <div class="field-label">Amount Paid</div>
                    <div class="field-value">₹{{ number_format($subscription->amount_paid, 2) }}</div>
                </div>

                @if($subscription->razorpay_payment_id)
                <div class="field-group">
                    <div class="field-label">Razorpay Payment ID</div>
                    <div class="field-value" style="font-family: monospace; font-size: 0.9rem;">{{ $subscription->razorpay_payment_id }}</div>
                </div>
                @endif
            </div>

            <div class="info-card">
                <h3 style="margin-top: 0; color: #0f172a; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">Package Limits</h3>
                
                @if(optional($subscription->package)->no_of_users)
                <div class="field-group">
                    <div class="field-label">Maximum Users</div>
                    <div class="field-value">{{ $subscription->package->no_of_users == -1 ? 'Unlimited' : $subscription->package->no_of_users }}</div>
                </div>
                @endif

                @if(optional($subscription->package)->no_of_vehicles)
                <div class="field-group">
                    <div class="field-label">Maximum Vehicles</div>
                    <div class="field-value">{{ $subscription->package->no_of_vehicles == -1 ? 'Unlimited' : $subscription->package->no_of_vehicles }}</div>
                </div>
                @endif

                @if(optional($subscription->package)->no_of_locations)
                <div class="field-group">
                    <div class="field-label">Maximum Locations</div>
                    <div class="field-value">{{ $subscription->package->no_of_locations == -1 ? 'Unlimited' : $subscription->package->no_of_locations }}</div>
                </div>
                @endif
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('vendor.dashboard') }}" class="btn">Go to Vendor Dashboard</a>
            </div>

            <p style="font-size: 0.9rem; color: #64748b;">If you have any questions or require assistance with your account setup, please contact our support team.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Rydaris. All rights reserved.
        </div>
    </div>
</body>
</html>
