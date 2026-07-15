<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tc->title ?? 'Terms & Conditions' }} - {{ $vendor->company_name ?? $vendor->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #050d1a;
            color: #cbd5e1;
            min-height: 100vh;
            line-height: 1.7;
        }

        /* Top bar */
        .topbar {
            background: rgba(15, 34, 53, 0.95);
            border-bottom: 1px solid rgba(82, 234, 210, 0.15);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(12px);
        }
        .vendor-name {
            font-size: 1rem;
            font-weight: 700;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .vendor-name span {
            color: #52ead2;
        }
        .close-btn {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 8px 16px;
            color: #94a3b8;
            font-size: 0.85rem;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
        }
        .close-btn:hover {
            background: rgba(255,255,255,0.1);
            color: #f1f5f9;
        }

        /* Content */
        .container {
            max-width: 820px;
            margin: 0 auto;
            padding: 48px 32px 80px;
        }

        .tc-header {
            margin-bottom: 36px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .tc-header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .tc-header h1 svg {
            color: #52ead2;
            flex-shrink: 0;
        }
        .tc-header p {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* T&C body content */
        .tc-body {
            font-size: 0.97rem;
            line-height: 1.8;
            color: #cbd5e1;
        }
        .tc-body h1, .tc-body h2, .tc-body h3, .tc-body h4 {
            color: #f1f5f9;
            margin: 28px 0 12px;
            font-weight: 700;
        }
        .tc-body h2 { font-size: 1.25rem; }
        .tc-body h3 { font-size: 1.1rem; }
        .tc-body p { margin: 0 0 14px; }
        .tc-body ul, .tc-body ol { padding-left: 22px; margin: 0 0 14px; }
        .tc-body li { margin-bottom: 6px; }
        .tc-body a { color: #52ead2; }
        .tc-body strong { color: #f1f5f9; }
        .tc-body blockquote {
            border-left: 3px solid #52ead2;
            padding: 10px 18px;
            margin: 16px 0;
            background: rgba(82,234,210,0.05);
            border-radius: 0 8px 8px 0;
        }
        .tc-body hr {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin: 28px 0;
        }
        .tc-body table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }
        .tc-body th, .tc-body td {
            padding: 10px 14px;
            border: 1px solid rgba(255,255,255,0.1);
            text-align: left;
        }
        .tc-body th {
            background: rgba(82,234,210,0.08);
            color: #f1f5f9;
            font-weight: 600;
        }

        .no-tc {
            text-align: center;
            padding: 80px 0;
            color: #475569;
        }
        .no-tc svg { margin-bottom: 16px; color: #334155; }

        @media (max-width: 600px) {
            .topbar { padding: 12px 18px; }
            .container { padding: 32px 18px 60px; }
            .tc-header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    <!-- Top Bar -->
    <div class="topbar">
        <div class="vendor-name">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
            <span>{{ $vendor->company_name ?? $vendor->name }}</span>
        </div>
        <button class="close-btn" onclick="window.close()">✕ Close</button>
    </div>

    <!-- Content -->
    <div class="container">

        <div class="tc-header">
            <h1>
                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
                {{ $tc->title ?? 'Terms & Conditions' }}
            </h1>
            <p>Provided by <strong style="color:#94a3b8;">{{ $vendor->company_name ?? $vendor->name }}</strong></p>
        </div>

        <div class="tc-body">
            @if($tc && $tc->description)
                {!! $tc->description !!}
            @else
                <div class="no-tc">
                    <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    <p style="font-size:1.1rem; margin-bottom:8px; color:#64748b;">No Terms & Conditions available</p>
                    <p style="font-size:0.9rem;">This vendor has not yet published their Terms & Conditions.</p>
                </div>
            @endif
        </div>

    </div>

</body>
</html>
