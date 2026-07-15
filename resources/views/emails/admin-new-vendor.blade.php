<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Vendor Registered</title>
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
            <h1>New Vendor Registered</h1>
            <p>A new vendor account has been created on Rydaris.</p>
        </div>
        <div class="content">
            <p>Hello Admin,</p>
            <p>This is to notify you that a new vendor has registered on the Rydaris platform. Below are the details of the registered vendor:</p>
            
            <div class="info-card">
                <h3 style="margin-top: 0; color: #0f172a; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">Vendor Details</h3>
                <div class="field-group">
                    <div class="field-label">Vendor Name</div>
                    <div class="field-value">{{ $user->first_name ?? $user->name }}</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Company Name</div>
                    <div class="field-value">{{ $user->company_name ?? 'N/A' }}</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Username</div>
                    <div class="field-value">{{ $user->username }}</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Email Address</div>
                    <div class="field-value">
                        <a href="mailto:{{ $user->email }}" style="color: #0f766e; text-decoration: none; font-weight: 600;">{{ $user->email }}</a>
                    </div>
                </div>
                <div class="field-group">
                    <div class="field-label">Contact Number</div>
                    <div class="field-value">{{ $user->country_code }}{{ $user->contact_number }}</div>
                </div>
                <div class="field-group">
                    <div class="field-label">Registration Date</div>
                    <div class="field-value">{{ $user->created_at->format('M d, Y h:i A') }}</div>
                </div>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('admin.login') }}" class="btn">Login to Admin Panel</a>
            </div>
        </div>
        <div class="footer">
            This is an automated notification from the Rydaris platform.
        </div>
    </div>
</body>
</html>
