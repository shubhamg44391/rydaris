<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation to Join Portal</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #050711;
            color: #f8fafc;
            margin: 0;
            padding: 40px 10px;
            line-height: 1.6;
        }
        .wrapper {
            width: 100%;
            background-color: #050711;
            padding: 20px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #0b1020;
            border-radius: 12px;
            border-top: 4px solid #52ead2;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }
        .header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .header img {
            max-height: 55px;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .greeting {
            font-size: 1.25rem;
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 16px;
            text-align: left;
        }
        .body-text {
            font-size: 1rem;
            color: #cbd5e1;
            margin-bottom: 30px;
            text-align: left;
            line-height: 1.7;
        }
        .cta-btn {
            display: inline-block;
            background-color: #52ead2;
            color: #051013 !important;
            font-weight: 800;
            text-decoration: none;
            padding: 14px 35px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(82, 234, 210, 0.2);
            font-size: 1rem;
            margin: 10px auto;
            text-align: center;
        }
        .link-note {
            margin-top: 35px;
            font-size: 0.8rem;
            color: #64748b;
            text-align: left;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 20px;
        }
        .link-url {
            color: #52ead2;
            text-decoration: underline;
            word-break: break-all;
        }
        .footer {
            padding: 24px 30px;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.8rem;
            color: #64748b;
            background-color: rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <!-- Vendor custom logo or fall back to vendor name -->
                @if($invitation->vendor->company_logo && file_exists(public_path($invitation->vendor->company_logo)))
                    <img src="{{ url($invitation->vendor->company_logo) }}" alt="{{ $invitation->vendor->company_name ?? $invitation->vendor->name }}">
                @else
                    <h2 style="color: #52ead2; margin: 0; font-family: 'Inter', sans-serif;">{{ $invitation->vendor->company_name ?? $invitation->vendor->name }}</h2>
                @endif
            </div>
            
            <div class="content">
                <div class="greeting">
                    Hello {{ $invitation->name ?? 'there' }},
                </div>
                
                <div class="body-text">
                    You have been invited by <strong>{{ $invitation->vendor->company_name ?? $invitation->vendor->name }}</strong> to register and join their customer portal. 
                    <br><br>
                    Please click the button below to accept this invitation, complete your profile details, and set up your account password:
                </div>
                
                <!-- CTA Button -->
                <div style="margin: 25px 0;">
                    <a href="{{ $registrationUrl }}" class="cta-btn">Accept Invitation & Register</a>
                </div>
                
                <!-- Link fallback -->
                <div class="link-note">
                    If the button above doesn't work, copy and paste this link into your web browser:
                    <br><br>
                    <a href="{{ $registrationUrl }}" class="link-url">{{ $registrationUrl }}</a>
                </div>
            </div>
            
            <div class="footer">
                This is an automated invitation sent by {{ $invitation->vendor->company_name ?? $invitation->vendor->name }}.
            </div>
        </div>
    </div>
</body>
</html>
