<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Inquiry</title>
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
        .field-group {
            margin-bottom: 24px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 16px;
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
        .message-box {
            background-color: #f8fafc;
            border-left: 3px solid #64748b;
            padding: 16px;
            border-radius: 4px;
            font-style: italic;
            color: #475569;
            margin-top: 6px;
            white-space: pre-wrap;
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
            <h1>New Contact Inquiry</h1>
            <p>A visitor has submitted an inquiry on the Rydaris website.</p>
        </div>
        <div class="content">
            <div class="field-group">
                <div class="field-label">Full Name</div>
                <div class="field-value">{{ $data['name'] ?? 'N/A' }}</div>
            </div>

            <div class="field-group">
                <div class="field-label">Work Email</div>
                <div class="field-value">
                    <a href="mailto:{{ $data['email'] ?? '' }}" style="color: #0f766e; text-decoration: none; font-weight: 600;">{{ $data['email'] ?? 'N/A' }}</a>
                </div>
            </div>

            <div class="field-group">
                <div class="field-label">Company</div>
                <div class="field-value">{{ $data['company'] ?? 'N/A' }}</div>
            </div>

            <div class="field-group">
                <div class="field-label">Phone Number</div>
                <div class="field-value">{{ $data['phone'] ?? 'N/A' }}</div>
            </div>

            <div class="field-group">
                <div class="field-label">Fleet Size</div>
                <div class="field-value">{{ $data['fleet_size'] ?? 'N/A' }}</div>
            </div>

            <div class="field-group">
                <div class="field-label">Primary Need</div>
                <div class="field-value">{{ $data['need'] ?? 'N/A' }}</div>
            </div>

            <div class="field-group" style="border-bottom: none; padding-bottom: 0;">
                <div class="field-label">What should we help with?</div>
                <div class="message-box">{{ $data['message'] ?? 'N/A' }}</div>
            </div>
        </div>
        <div class="footer">
            This is an automated notification from the Rydaris platform.
        </div>
    </div>
</body>
</html>
