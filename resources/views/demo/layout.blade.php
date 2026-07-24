<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rydaris | Vendor Workspace</title>
    
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        :root {
            --bg-1: #050711;
            --bg-2: #0b1020;
            --brand: #52ead2;
            --brand-dark: #2bc2a8;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --radius: 12px;
            --font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        }

        body {
            margin: 0;
            background-color: var(--bg-1);
            color: var(--text-main);
            font-family: var(--font-family);
            overflow-x: hidden;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            background: var(--bg-2);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            position: sticky;
            top: 0;
        }

        .sidebar-logo {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-text {
            font-family: 'Outfit', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .logo-text span {
            color: var(--brand);
        }

        .sidebar-menu {
            flex: 1;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            overflow-y: auto;
        }

        .menu-header {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin: 15px 12px 6px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: var(--radius);
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .menu-link i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .menu-link:hover,
        .menu-link.active {
            color: #051013 !important;
            background: linear-gradient(135deg, var(--brand, #52ead2) 0%, #80a7ff 100%) !important;
            box-shadow: 0 4px 15px rgba(82, 234, 210, 0.25) !important;
        }

        .menu-link:hover i,
        .menu-link.active i,
        .menu-link:hover span,
        .menu-link.active span,
        .menu-link:hover .arrow,
        .menu-link.active .arrow {
            color: #051013 !important;
        }

        .submenu {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding-left: 36px;
            margin-top: 4px;
        }

        .submenu-link {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .submenu-link::before {
            content: "•";
            color: var(--text-muted);
        }

        .submenu-link:hover, .submenu-link.active {
            color: #52ead2 !important;
            background: rgba(82, 234, 210, 0.1) !important;
            font-weight: 700 !important;
        }

        .submenu-link.active::before,
        .submenu-link:hover::before {
            color: #52ead2 !important;
        }

        /* Main Viewport */
        .viewport {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* Topbar Header */
        .topbar {
            height: 75px;
            background: var(--bg-2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .demo-badge {
            background: rgba(82, 234, 210, 0.1);
            border: 1px solid rgba(82, 234, 210, 0.25);
            color: var(--brand);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .vendor-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .vendor-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-main);
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: var(--text-main);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        /* Content Area */
        .content {
            padding: 35px;
            flex: 1;
        }

        .glass-card {
            background: rgba(11, 16, 32, 0.6);
            border: 1px solid rgba(82, 234, 210, 0.15);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        /* Tables */
        .demo-table-wrap {
            overflow-x: auto;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--radius);
            background: rgba(11, 16, 32, 0.4);
            margin-top: 20px;
        }

        .demo-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .demo-table th {
            background: rgba(255, 255, 255, 0.02);
            padding: 16px 20px;
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            letter-spacing: 0.5px;
        }

        .demo-table td {
            padding: 16px 20px;
            font-size: 0.9rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text-main);
        }

        .demo-table tr:last-child td {
            border-bottom: none;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
        }

        .badge-active {
            background: rgba(82, 234, 210, 0.15);
            color: var(--brand);
        }

        .badge-inactive {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
        }
        .xp-overlay      { display:none; position:fixed; inset:0; background:rgba(5, 7, 17, 0.85); backdrop-filter: blur(8px); z-index:2000; align-items:center; justify-content:center; }
        .xp-overlay.open { display:flex; }
        .xp-modal        { background:#0b1020; border: 1px solid rgba(82, 234, 210, 0.25); border-radius:16px; width:480px; max-width:95vw; max-height:90vh; overflow-y:auto; box-shadow:0 12px 40px rgba(0, 0, 0, 0.5); }
        .xp-modal-head   { display:flex; justify-content:space-between; align-items:center; padding:16px 22px; border-bottom:1px solid rgba(255,255,255,0.05); }
        .xp-modal-title  { font-weight:700; font-size:1.05rem; color:#f8fafc; }
        .xp-modal-x      { background:none; border:none; font-size:1.4rem; cursor:pointer; color:#cbd5e1; line-height:1; }
        .xp-modal-body   { padding:20px 22px; }
        .xp-modal-foot   { display:flex; justify-content:flex-end; gap:10px; padding:14px 22px; border-top:1px solid rgba(255,255,255,0.05); }

        .xp-modal .xp-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .xp-modal .xp-fg  { margin-bottom:14px; }
        .xp-modal .xp-fg label { display:block !important; font-size:.83rem; font-weight:600; color:#f8fafc; margin-bottom:5px; gap:0 !important; }
        .xp-modal .xp-fg input,
        .xp-modal .xp-fg select {
            width:100%; padding:12px !important; min-height:unset !important;
            border:1px solid rgba(255, 255, 255, 0.15) !important; border-radius:8px !important;
            font-size:.88rem !important; color:#fff; outline:none; box-sizing:border-box; background:rgba(255, 255, 255, 0.05) !important;
        }
        .xp-modal .xp-fg select option {
            background-color: #0b1020 !important;
            color: #f8fafc !important;
        }
        .xp-modal .xp-fg input:focus,
        .xp-modal .xp-fg select:focus { border-color:var(--brand, #52ead2) !important; box-shadow: 0 0 0 3px rgba(82, 234, 210, 0.15) !important; outline:none !important; }

        .xp-btn-cancel { background:rgba(255, 255, 255, 0.05); border:1px solid rgba(255, 255, 255, 0.15); color:#cbd5e1; padding:10px 20px; border-radius:8px; cursor:pointer; font-size:.88rem; transition: all 0.2s; text-decoration: none; display: inline-block; text-align: center; }
        .xp-btn-cancel:hover { background:rgba(255, 255, 255, 0.1); }
        .xp-btn-save   { background:var(--brand, #52ead2) !important; color:#050711 !important; border:none; padding:10px 20px; border-radius:8px; cursor:pointer; font-size:.88rem; font-weight:700 !important; box-shadow:0 8px 16px rgba(82, 234, 210, 0.2); transition: all 0.2s; }
        .xp-btn-save:hover { background:#2bc2a8 !important; box-shadow:0 8px 20px rgba(82, 234, 210, 0.3); }

        /* Collapse Sidebar Styles */
        body.sidebar-collapsed .sidebar {
            width: 80px;
        }
        body.sidebar-collapsed .sidebar .logo-text,
        body.sidebar-collapsed .sidebar .menu-link span,
        body.sidebar-collapsed .sidebar .menu-link .arrow,
        body.sidebar-collapsed .sidebar .submenu {
            display: none !important;
        }
        body.sidebar-collapsed .sidebar .menu-link {
            justify-content: center;
            padding: 12px;
            border-radius: var(--radius);
        }
        body.sidebar-collapsed .sidebar .menu-link i {
            margin: 0;
            font-size: 1.2rem;
        }

        /* Glassmorphism SweetAlert2 theme (match vendor/admin) */
        body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) { background-color: rgba(5, 7, 17, 0.4) !important; backdrop-filter: blur(8px) !important; }
        div.swal2-container.swal2-backdrop-show { background: transparent !important; }
        div.swal2-popup { background: rgba(11, 16, 32, 0.95) !important; backdrop-filter: blur(16px) !important; border: 1px solid rgba(82, 234, 210, 0.25) !important; border-radius: 16px !important; color: #f8fafc !important; box-shadow: 0 0 40px rgba(82, 234, 210, 0.1), 0 24px 80px rgba(0, 0, 0, 0.5) !important; padding: 2.5em 2em !important; }
        div.swal2-popup.swal2-toast { padding: 1em 1.2em !important; }
        div.swal2-title { color: #f8fafc !important; font-weight: 700 !important; letter-spacing: -0.02em !important; }
        div.swal2-html-container { color: #a8b3c5 !important; }
        .swal2-icon.swal2-success { border-color: rgba(82, 234, 210, 0.5) !important; color: #52ead2 !important; box-shadow: 0 0 20px rgba(82, 234, 210, 0.1) !important; }
        .swal2-icon.swal2-success .swal2-success-ring { border-color: rgba(82, 234, 210, 0.4) !important; }
        .swal2-icon.swal2-success [class^=swal2-success-line] { background-color: #52ead2 !important; }
        .swal2-actions { margin-top: 2em !important; gap: 12px !important; }
        .swal2-confirm, .swal2-styled.swal2-confirm { background: linear-gradient(135deg, #52ead2, #2bc2a8) !important; color: #050711 !important; font-weight: 600 !important; border-radius: 8px !important; padding: 12px 28px !important; border: none !important; box-shadow: 0 8px 16px rgba(82, 234, 210, 0.2) !important; }
        .swal2-timer-progress-bar { background: rgba(82, 234, 210, 0.5) !important; }

        /* Mobile Responsiveness styling */
        @media (max-width: 991px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 280px !important;
                height: 100vh;
                z-index: 9999;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 10px 0 30px rgba(0, 0, 0, 0.5);
            }
            body.sidebar-open .sidebar {
                transform: translateX(0);
            }
            body.sidebar-open::after {
                content: "";
                position: fixed;
                inset: 0;
                background: rgba(5, 7, 17, 0.6);
                backdrop-filter: blur(4px);
                z-index: 9998;
                pointer-events: auto;
            }
            .btn-close-sidebar {
                display: block !important;
            }
            .btn-collapse-sidebar #collapse-icon::before {
                content: "\f0c9" !important; /* Hamburger icon */
            }
            body.sidebar-open .btn-collapse-sidebar #collapse-icon::before {
                content: "\f00d" !important; /* X icon */
            }
            .viewport {
                width: 100%;
                min-height: calc(100vh - 75px);
            }
            .topbar {
                padding: 0 16px;
            }
            .topbar-right a[href*="profile"] {
                font-size: 0 !important; /* Hide name text, keep only icon */
            }
            .topbar-right a[href*="profile"] i {
                font-size: 1.3rem;
                margin: 0 !important;
            }
            .content {
                padding: 16px;
            }
            .glass-card {
                padding: 16px;
            }
            .admin-kpis {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px;
            }
            .admin-grid {
                grid-template-columns: 1fr !important;
                gap: 16px;
            }
            .analytics-row {
                grid-template-columns: 1fr !important;
                gap: 10px;
                margin-top: 20px;
            }
            .admin-hero {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .admin-date-card {
                width: 100%;
                min-width: 0;
            }
            .chart-bars {
                overflow-x: auto;
                padding-bottom: 10px;
            }
            /* Modal Form fields stack on mobile */
            .xp-modal .xp-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .table-scroll-hint {
                display: flex !important;
            }
        }
        
        @media (max-width: 576px) {
            .admin-kpis {
                grid-template-columns: 1fr !important;
            }
            .topbar-right {
                gap: 12px !important;
            }
            .branch-display-wrap {
                display: none !important;
            }
            .topbar-right a[href*="logout"] {
                font-size: 0 !important;
            }
            .topbar-right a[href*="logout"] i {
                font-size: 1.2rem;
                margin: 0 !important;
            }
            .topbar-left a[style*="brand"] {
                padding: 6px 12px !important;
                font-size: 0.75rem !important;
            }
        }

        /* Horizontal scrollbar styling for tables */
        .demo-table-wrap {
            padding-bottom: 8px;
            scrollbar-width: thin !important;
            scrollbar-color: rgba(82, 234, 210, 0.4) rgba(255, 255, 255, 0.03) !important;
        }
        .demo-table-wrap::-webkit-scrollbar {
            height: 6px !important;
            display: block !important;
        }
        .demo-table-wrap::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.03) !important;
            border-radius: 99px !important;
        }
        .demo-table-wrap::-webkit-scrollbar-thumb {
            background: rgba(82, 234, 210, 0.4) !important;
            border-radius: 99px !important;
        }
        .demo-table-wrap::-webkit-scrollbar-thumb:hover {
            background: var(--brand, #52ead2) !important;
        }

        /* Swipe indicator arrow animation */
        @keyframes swipeRight {
            0%, 100% {
                transform: translateX(0);
                opacity: 0.6;
            }
            50% {
                transform: translateX(6px);
                opacity: 1;
            }
        }

        /* Demo Layout Light Mode CSS Overrides */
        body.light-mode {
            --bg-1: #f1f5f9;
            --bg-2: #ffffff;
            --text-main: #0f172a;
            --text-muted: #475569;
        }

        body.light-mode .sidebar {
            border-right: 1px solid rgba(15, 23, 42, 0.08) !important;
        }

        body.light-mode .menu-link:hover,
        body.light-mode .menu-link.active {
            color: #051013 !important;
            background: linear-gradient(135deg, #80a7ff 0%, #52ead2 100%) !important;
            box-shadow: 0 4px 15px rgba(82, 234, 210, 0.35) !important;
        }

        body.light-mode .menu-link:hover i,
        body.light-mode .menu-link.active i,
        body.light-mode .menu-link:hover span,
        body.light-mode .menu-link.active span,
        body.light-mode .menu-link:hover .arrow,
        body.light-mode .menu-link.active .arrow {
            color: #051013 !important;
        }

        body.light-mode .submenu-link:hover,
        body.light-mode .submenu-link.active {
            color: #0f766e !important;
            background: rgba(15, 118, 110, 0.1) !important;
            font-weight: 700 !important;
        }

        body.light-mode .submenu-link.active::before,
        body.light-mode .submenu-link:hover::before {
            color: #0f766e !important;
        }

        body.light-mode .sidebar-logo,
        body.light-mode .sidebar-menu {
            border-color: rgba(15, 23, 42, 0.08) !important;
        }

        body.light-mode .logo-text {
            color: #0f172a !important;
        }

        body.light-mode .topbar {
            background: #ffffff !important;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08) !important;
        }

        body.light-mode .topbar-left a {
            background: rgba(15, 118, 110, 0.06) !important;
            border-color: rgba(15, 118, 110, 0.2) !important;
            color: #0f766e !important;
        }

        body.light-mode .topbar-left a i {
            color: #0f766e !important;
        }

        body.light-mode .topbar-right .profile-trigger-btn {
            border-color: rgba(15, 23, 42, 0.15) !important;
            color: #0f172a !important;
        }

        body.light-mode .btn-collapse-sidebar {
            background: #ffffff !important;
            border-color: rgba(15, 23, 42, 0.15) !important;
            color: #475569 !important;
        }

        body.light-mode .btn-collapse-sidebar:hover {
            background: #f1f5f9 !important;
        }

        body.light-mode .branch-display-wrap {
            background: rgba(15, 118, 110, 0.06) !important;
            border-color: rgba(15, 118, 110, 0.18) !important;
            color: #0f766e !important;
        }

        body.light-mode .branch-display-wrap span {
            color: #0f766e !important;
        }

        body.light-mode .glass-card {
            background: #ffffff !important;
            border-color: rgba(15, 23, 42, 0.08) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.03) !important;
        }

        body.light-mode .demo-table-wrap {
            background: #ffffff !important;
            border-color: rgba(15, 23, 42, 0.08) !important;
        }

        body.light-mode .demo-table th {
            background: #f8fafc !important;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08) !important;
            color: #475569 !important;
        }

        body.light-mode .demo-table td {
            border-bottom: 1px solid rgba(15, 23, 42, 0.06) !important;
            color: #0f172a !important;
        }

        body.light-mode .badge-active {
            background: rgba(15, 118, 110, 0.1) !important;
            color: #0f766e !important;
        }

        body.light-mode .badge-inactive {
            background: #f1f5f9 !important;
            color: #475569 !important;
        }

        body.light-mode .btn-close-sidebar {
            color: #475569 !important;
        }

        /* Global Demo Site Inputs & Elements Light Mode Overrides */
        body.light-mode .content input,
        body.light-mode .content select,
        body.light-mode .content textarea,
        body.light-mode .xp-modal input,
        body.light-mode .xp-modal select,
        body.light-mode .xp-modal textarea {
            background-color: #ffffff !important;
            border: 1px solid rgba(15, 23, 42, 0.15) !important;
            color: #0f172a !important;
        }

        body.light-mode .content input[disabled],
        body.light-mode .content input:disabled,
        body.light-mode .content textarea[disabled],
        body.light-mode .content textarea:disabled {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
            border-color: rgba(15, 23, 42, 0.08) !important;
        }

        body.light-mode .content h2,
        body.light-mode .content h3,
        body.light-mode .content h4,
        body.light-mode .content h1 {
            color: #0f172a !important;
            border-color: rgba(15, 23, 42, 0.08) !important;
        }

        body.light-mode .content label {
            color: #475569 !important;
        }

        body.light-mode .content button[type="submit"],
        body.light-mode .content .xp-btn-save,
        body.light-mode .content .btn-primary,
        body.light-mode .xp-modal button[type="submit"],
        body.light-mode .xp-modal .xp-btn-save {
            background: linear-gradient(135deg, #0f766e, #0d9488) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.18) !important;
        }
        body.light-mode .content button[type="submit"]:hover,
        body.light-mode .content .xp-btn-save:hover,
        body.light-mode .content .btn-primary:hover,
        body.light-mode .xp-modal button[type="submit"]:hover,
        body.light-mode .xp-modal .xp-btn-save:hover {
            opacity: 0.9 !important;
        }

        body.light-mode .menu-link.active {
            color: #051013 !important;
        }

        body.light-mode .menu-link:hover {
            color: #0f766e !important;
            background: rgba(15, 118, 110, 0.05) !important;
        }

        body.light-mode .submenu-link.active {
            color: #0f766e !important;
        }

        body.light-mode .submenu-link.active::before {
            color: #0f766e !important;
        }

        body.light-mode .logo-text span {
            color: #0f766e !important;
        }

        body.light-mode .demo-badge {
            background: rgba(15, 118, 110, 0.08) !important;
            border-color: rgba(15, 118, 110, 0.2) !important;
            color: #0f766e !important;
        }

        /* Map light turquoise brand color to highly readable dark teal in light mode globally */
        body.light-mode [style*="var(--brand)"],
        body.light-mode [style*="#52ead2"],
        body.light-mode [style*="color: var(--brand)"],
        body.light-mode [style*="color:#52ead2"] {
            color: #0f766e !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/styles.css') }}?v={{ time() }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function xpOpen(id){ document.getElementById(id).classList.add('open'); }
        function xpClose(id){ document.getElementById(id).classList.remove('open'); }
        
        function toggleSubmenu(el) {
            const parent = el.closest('.menu-item-with-submenu');
            const submenu = parent.querySelector('.submenu');
            const arrow = el.querySelector('.arrow');
            if (submenu.style.display === 'none' || submenu.style.display === '') {
                submenu.style.display = 'flex';
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            } else {
                submenu.style.display = 'none';
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        }

        function toggleSidebarCollapse() {
            if (window.innerWidth <= 991) {
                document.body.classList.toggle('sidebar-open');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
                const isCollapsed = document.body.classList.contains('sidebar-collapsed');
                const icon = document.getElementById('collapse-icon');
                if (icon) {
                    if (isCollapsed) {
                        icon.className = 'fa-solid fa-chevron-right';
                    } else {
                        icon.className = 'fa-solid fa-chevron-left';
                    }
                }
            }
        }

        // Close sidebar on clicking outside of it on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 991) {
                const sidebar = document.querySelector('.sidebar');
                const collapseBtn = document.querySelector('.btn-collapse-sidebar');
                if (sidebar && document.body.classList.contains('sidebar-open')) {
                    if (!sidebar.contains(e.target) && !collapseBtn.contains(e.target) && !e.target.closest('.btn-collapse-sidebar')) {
                        document.body.classList.remove('sidebar-open');
                    }
                }
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.xp-overlay').forEach(o => {
                o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); });
            });
        });
    </script>
</head>
<body>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('rydaris_demo_theme') || 'dark';
            if (savedTheme === 'light') {
                document.body.classList.add('light-mode');
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>

    
    <aside class="sidebar">
        <div class="sidebar-logo" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
          <img class="brand-full" src="{{ asset('assets/logo/rydaris-logo.png') }}" data-dark-logo="{{ asset('assets/logo/rydaris-logo.png') }}" data-light-logo="{{ asset('assets/logo/rydaris-logo-light.png') }}" alt="Rydaris Logo" style="height: 32px; width: auto; display: block;">
          <img class="brand-mini" src="{{ asset('assets/logo/favicon.svg') }}" alt="Rydaris Logo" style="height: 32px; width: auto; display: none;">
            <button class="btn-close-sidebar" onclick="toggleSidebarCollapse()" style="display: none; background: none; border: none; color: #fff; font-size: 1.2rem; cursor: pointer; padding: 4px; line-height: 1;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('demo.dashboard') }}" class="menu-link {{ request()->routeIs('demo.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i> <span>Dashboard</span>
            </a>
            
            <div class="menu-item-with-submenu">
                <a class="menu-link {{ request()->routeIs('demo.bookings*') ? 'active' : '' }}" onclick="toggleSubmenu(this)">
                    <i class="fa-regular fa-calendar-days"></i> <span>Booking</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s; {{ request()->routeIs('demo.bookings*') ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="submenu" style="{{ request()->routeIs('demo.bookings*') ? 'display: flex;' : 'display: none;' }} background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="{{ route('demo.bookings') }}" class="submenu-link {{ request()->routeIs('demo.bookings') && !request()->routeIs('demo.bookings.payment') ? 'active' : '' }}">Booking List</a>
                    <a href="{{ route('demo.bookings.payment') }}" class="submenu-link {{ request()->routeIs('demo.bookings.payment') ? 'active' : '' }}">Booking Payment</a>
                </div>
            </div>

            <div class="menu-item-with-submenu">
                <a class="menu-link {{ request()->routeIs('demo.vehicles*') || request()->routeIs('demo.groups*') ? 'active' : '' }}" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-car"></i> <span>Vehicles</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s; {{ request()->routeIs('demo.vehicles*') || request()->routeIs('demo.groups*') ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="submenu" style="{{ request()->routeIs('demo.vehicles*') || request()->routeIs('demo.groups*') ? 'display: flex;' : 'display: none;' }} background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="{{ route('demo.groups') }}" class="submenu-link {{ request()->routeIs('demo.groups') ? 'active' : '' }}">Vehicle Group / Acriss Code</a>
                    <a href="{{ route('demo.vehicles') }}" class="submenu-link {{ request()->routeIs('demo.vehicles') && !request()->routeIs('demo.vehicles.create') ? 'active' : '' }}">Vehicle List</a>
                    <a href="{{ route('demo.vehicles.create') }}" class="submenu-link {{ request()->routeIs('demo.vehicles.create') ? 'active' : '' }}">Add Vehicle</a>
                </div>
            </div>

            <div class="menu-item-with-submenu">
                <a class="menu-link {{ request()->routeIs('demo.locations*') || request()->routeIs('demo.branches*') ? 'active' : '' }}" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-map-pin"></i> <span>Locations</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s; {{ request()->routeIs('demo.locations*') || request()->routeIs('demo.branches*') ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="submenu" style="{{ request()->routeIs('demo.locations*') || request()->routeIs('demo.branches*') ? 'display: flex;' : 'display: none;' }} background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="{{ route('demo.branches') }}" class="submenu-link {{ request()->routeIs('demo.branches') ? 'active' : '' }}">Branch List</a>
                    <a href="{{ route('demo.locations') }}" class="submenu-link {{ request()->routeIs('demo.locations') && !request()->routeIs('demo.locations.create') ? 'active' : '' }}">Location List</a>
                    <a href="{{ route('demo.locations.create') }}" class="submenu-link {{ request()->routeIs('demo.locations.create') ? 'active' : '' }}">Add Location</a>
                </div>
            </div>

            <div class="menu-item-with-submenu">
                <a class="menu-link {{ request()->routeIs('demo.customers') || request()->routeIs('demo.invitations') ? 'active' : '' }}" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-users"></i> <span>Customers</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s; {{ request()->routeIs('demo.customers') || request()->routeIs('demo.invitations') ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="submenu" style="{{ request()->routeIs('demo.customers') || request()->routeIs('demo.invitations') ? 'display: flex;' : 'display: none;' }} background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="{{ route('demo.customers') }}" class="submenu-link {{ request()->routeIs('demo.customers') ? 'active' : '' }}">Customer List</a>
                    <a href="{{ route('demo.invitations') }}" class="submenu-link {{ request()->routeIs('demo.invitations') ? 'active' : '' }}">User Invitations</a>
                </div>
            </div>

            <a href="{{ route('demo.fleet') }}" class="menu-link {{ request()->routeIs('demo.fleet') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> <span>Fleet Management</span>
            </a>

            <div class="menu-item-with-submenu">
                <a class="menu-link {{ request()->routeIs('demo.extras') || request()->routeIs('demo.insurance') || request()->routeIs('demo.features') || request()->routeIs('demo.rules') ? 'active' : '' }}" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-circle-plus"></i> <span>Extras</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s; {{ request()->routeIs('demo.extras') || request()->routeIs('demo.insurance') || request()->routeIs('demo.features') || request()->routeIs('demo.rules') ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="submenu" style="{{ request()->routeIs('demo.extras') || request()->routeIs('demo.insurance') || request()->routeIs('demo.features') || request()->routeIs('demo.rules') ? 'display: flex;' : 'display: none;' }} background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="{{ route('demo.extras') }}" class="submenu-link {{ request()->routeIs('demo.extras') ? 'active' : '' }}">Extras List</a>
                    <a href="{{ route('demo.insurance') }}" class="submenu-link {{ request()->routeIs('demo.insurance') ? 'active' : '' }}">Insurance List</a>
                    <a href="{{ route('demo.features') }}" class="submenu-link {{ request()->routeIs('demo.features') ? 'active' : '' }}">Features Mapping</a>
                    <a href="{{ route('demo.rules') }}" class="submenu-link {{ request()->routeIs('demo.rules') ? 'active' : '' }}">Rules</a>
                </div>
            </div>

            <a href="{{ route('demo.coupons') }}" class="menu-link {{ request()->routeIs('demo.coupons') ? 'active' : '' }}">
                <i class="fa-solid fa-ticket"></i> <span>Coupons</span>
            </a>

            <a href="{{ route('demo.support-tickets') }}" class="menu-link {{ request()->routeIs('demo.support-tickets') ? 'active' : '' }}">
                <i class="fa-regular fa-comment-dots"></i> <span>Support Ticket</span>
            </a>

            <div class="menu-item-with-submenu">
                <a class="menu-link {{ request()->routeIs('demo.subscription*') ? 'active' : '' }}" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-wallet"></i> <span>Subscription</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s; {{ request()->routeIs('demo.subscription*') ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="submenu" style="{{ request()->routeIs('demo.subscription*') ? 'display: flex;' : 'display: none;' }} background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="{{ route('demo.subscription') }}" class="submenu-link {{ request()->routeIs('demo.subscription') ? 'active' : '' }}">Buy Subscription</a>
                    <a href="{{ route('demo.subscription.history') }}" class="submenu-link {{ request()->routeIs('demo.subscription.history') ? 'active' : '' }}">Subscription History</a>
                </div>
            </div>

            <a href="{{ route('demo.terms') }}" class="menu-link {{ request()->routeIs('demo.terms') ? 'active' : '' }}">
                <i class="fa-solid fa-file-contract"></i> <span>Terms & Conditions</span>
            </a>

            <div class="menu-item-with-submenu">
                <a class="menu-link {{ request()->routeIs('demo.settings*') || request()->routeIs('demo.profile') ? 'active' : '' }}" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-gear"></i> <span>Settings</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s; {{ request()->routeIs('demo.settings*') || request()->routeIs('demo.profile') ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="submenu" style="{{ request()->routeIs('demo.settings*') || request()->routeIs('demo.profile') ? 'display: flex;' : 'display: none;' }} background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="{{ route('demo.settings.business') }}" class="submenu-link {{ request()->routeIs('demo.settings.business') ? 'active' : '' }}">Business Settings</a>
                    <a href="{{ route('demo.settings.payment') }}" class="submenu-link {{ request()->routeIs('demo.settings.payment') ? 'active' : '' }}">Payment Settings</a>
                    <a href="{{ route('demo.profile') }}" class="submenu-link {{ request()->routeIs('demo.profile') ? 'active' : '' }}">Profile Management</a>
                </div>
            </div>
        </div>
    </aside>

    
    <div class="viewport">
        
        <header class="topbar">
            
            <div class="topbar-left" style="gap: 15px; display: flex; align-items: center;">
                <button class="btn-collapse-sidebar" onclick="toggleSidebarCollapse()" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: #fff; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; outline: none; transition: all 0.2s;">
                    <i class="fa-solid fa-chevron-left" id="collapse-icon"></i>
                </button>
                <a href="{{ route('home') }}" style="background: rgba(82, 234, 210, 0.05); border: 1px solid rgba(82, 234, 210, 0.2); color: var(--brand, #52ead2); padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                    <i class="fa-solid fa-globe"></i> Visit Website
                </a>
            </div>

            
            <div class="topbar-right" style="gap: 15px; display: flex; align-items: center;">
                @php
                    $demoUser = Auth::user();
                    $currentBranchId = 1;
                    // Demo site always uses dummy branches — never pull from real DB
                    $vendorBranches = collect([
                        (object)['id' => 1, 'name' => 'Main Branch - Delhi'],
                        (object)['id' => 2, 'name' => 'Airport Branch - Mumbai'],
                        (object)['id' => 3, 'name' => 'Udhana Branch - Surat'],
                        (object)['id' => 4, 'name' => 'Central Branch - Ahmedabad'],
                        (object)['id' => 5, 'name' => 'Vesu Hub - Surat'],
                        (object)['id' => 6, 'name' => 'Connaught Place - Delhi'],
                        (object)['id' => 7, 'name' => 'BKC Center - Mumbai'],
                        (object)['id' => 8, 'name' => 'MG Road Depot - Bengaluru'],
                        (object)['id' => 9, 'name' => 'Hi-Tech City - Hyderabad'],
                        (object)['id' => 10, 'name' => 'Airport Counter - Goa'],
                    ]);
                @endphp

                <!-- 1. Branch Selector -->
                <div class="branch-selector-wrap" style="position: relative; display: inline-flex; align-items: center; gap: 6px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="branch-icon" style="width: 15px; height: 15px; color: #52ead2; flex-shrink: 0;">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    <span class="branch-label" style="font-size: 0.82rem; font-weight: 700; color: #94a3b8;">Branch:</span>
                    <select id="headerBranchSelect" class="header-branch-select" onchange="switchVendorBranch(this.value)" style="background: rgba(82, 234, 210, 0.08); color: #f8fafc; border: 1px solid rgba(82, 234, 210, 0.25); border-radius: 8px; padding: 5px 28px 5px 10px; font-size: 0.83rem; font-weight: 700; cursor: pointer; outline: none; appearance: none; -webkit-appearance: none; -moz-appearance: none; transition: all 0.2s;">
                        <option value="">All Branches</option>
                        @foreach($vendorBranches as $b)
                            <option value="{{ $b->id }}" {{ $currentBranchId == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                    <svg class="branch-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px; position: absolute; right: 10px; pointer-events: none; color: #52ead2;">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>

                <!-- 2. Theme Toggle Button -->
                <button type="button" class="theme-toggle-btn" onclick="toggleThemeMode()" title="Toggle Light/Dark Theme" aria-label="Toggle Light/Dark Theme">
                    <svg class="themeSunIcon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
                        <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                    <svg class="themeMoonIcon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                </button>

                <!-- 3. Profile Dropdown Component with Vendor Name -->
                <div class="profile-dropdown-container" style="position: relative; display: inline-block; line-height: 1;">
                    <button type="button" class="profile-trigger-btn" id="profileDropdownTrigger" style="background: rgba(82, 234, 210, 0.08); border: 1px solid rgba(82, 234, 210, 0.25); padding: 4px 12px 4px 6px; border-radius: 999px; cursor: pointer; display: flex; align-items: center; gap: 8px; color: var(--text, #f8fafc); transition: all 0.2s; outline: none;">
                        <span class="user-avatar-circle" style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #52ead2, #80a7ff); color: #051013; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.82rem; flex-shrink: 0;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'D', 0, 1)) }}
                        </span>
                        <span class="header-user-name" style="font-size: 0.85rem; font-weight: 700; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ Auth::user()->name ?? 'Demo Account' }}
                        </span>
                        <svg viewBox="0 0 24 24" class="profile-arrow-icon" style="width:12px; height:12px; fill:none; stroke:currentColor; stroke-width:2.5; flex-shrink: 0; color: #52ead2;"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="profile-dropdown-menu" id="profileDropdownMenu" style="display: none; position: absolute; right: 0; top: 45px; width: 220px; background: #0b1020; border: 1px solid var(--line, rgba(255,255,255,0.1)); border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); z-index: 1000; padding: 6px 0; overflow: hidden;">
                        <!-- User Info Header -->
                        <div style="padding: 12px 16px; border-bottom: 1px solid var(--line, rgba(255,255,255,0.05));">
                            <div style="font-weight: 600; color: var(--text, #f8fafc); font-size: 0.9rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; text-align: left;">{{ Auth::user()->name ?? 'Demo Account' }}</div>
                            <div style="font-size: 0.78rem; color: var(--muted, #aab7cb); margin-top: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; text-align: left;">{{ Auth::user()->email ?? 'demo@rydaris.com' }}</div>
                        </div>
                        <!-- Menu Links -->
                        <a href="{{ route('demo.profile') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; color: var(--text, #f8fafc); text-decoration: none; font-size: 0.85rem; transition: background 0.15s; text-align: left;" onmouseover="this.style.background='rgba(82, 234, 210, 0.08)';" onmouseout="this.style.background='transparent';">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--brand, #52ead2); flex-shrink: 0;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            My Profile
                        </a>
                        <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; color: #ef4444; text-decoration: none; font-size: 0.85rem; transition: background 0.15s; border-top: 1px solid var(--line, rgba(255,255,255,0.05)); text-align: left;" onmouseover="this.style.background='rgba(239, 68, 68, 0.05)';" onmouseout="this.style.background='transparent';">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>

        
        <main class="content">
            @yield('content')
        </main>
    </div>

    @yield('js')

    <style>
        .demo-pagination { display:flex; align-items:center; justify-content:flex-end; gap:6px; padding:16px 4px 0; flex-wrap:wrap; }
        .demo-pagination .dp-info { margin-right:auto; color: var(--text-muted); font-size:0.85rem; }
        .demo-pagination button { background: rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.1); color:#cbd5e1; min-width:34px; height:34px; padding:0 10px; border-radius:8px; cursor:pointer; font-size:0.85rem; font-weight:600; transition: all 0.2s; }
        .demo-pagination button:hover:not(:disabled) { border-color: var(--brand); color: var(--brand); }
        .demo-pagination button.active { background: var(--brand); color:#051013; border-color: var(--brand); }
        .demo-pagination button:disabled { opacity:0.4; cursor:not-allowed; }
    </style>
    <script>
        // Theme Switcher Functions
        function syncThemeIcons() {
            const isLight = document.body ? document.body.classList.contains('light-mode') : document.documentElement.classList.contains('light-mode');
            document.querySelectorAll('.themeSunIcon').forEach(function(el) {
                el.style.display = isLight ? 'none' : 'block';
            });
            document.querySelectorAll('.themeMoonIcon').forEach(function(el) {
                el.style.display = isLight ? 'block' : 'none';
            });
            
            // Update logo dynamically
            document.querySelectorAll('.brand-full').forEach(function(img) {
                const darkLogo = img.getAttribute('data-dark-logo');
                const lightLogo = img.getAttribute('data-light-logo');
                if (isLight && lightLogo) {
                    img.src = lightLogo;
                } else if (!isLight && darkLogo) {
                    img.src = darkLogo;
                }
            });
        }

        function toggleThemeMode() {
            if (document.body) document.body.classList.toggle('light-mode');
            document.documentElement.classList.toggle('light-mode');
            const isLight = document.body ? document.body.classList.contains('light-mode') : document.documentElement.classList.contains('light-mode');
            localStorage.setItem('rydaris_demo_theme', isLight ? 'light' : 'dark');
            syncThemeIcons();

            // Dynamically update active CKEditor instances background & text color
            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances) {
                for (let name in CKEDITOR.instances) {
                    const inst = CKEDITOR.instances[name];
                    if (inst && inst.document && inst.document.getBody()) {
                        const body = inst.document.getBody();
                        if (isLight) {
                            body.setStyle('background-color', '#ffffff');
                            body.setStyle('color', '#0f172a');
                        } else {
                            body.setStyle('background-color', '#050711');
                            body.setStyle('color', '#f8fafc');
                        }
                    }
                }
            }
        }

        function switchVendorBranch(branchId) {
            localStorage.setItem('rydaris_demo_branch', branchId);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (csrfToken) {
                fetch("{{ route('vendor.branches.select') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ branch_id: branchId })
                })
                .then(res => {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ title: 'Branch Switched!', text: 'Active branch changed successfully.', icon: 'success', timer: 1500, showConfirmButton: false });
                    }
                })
                .catch(err => {
                    console.warn('Demo branch switch:', err);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ title: 'Branch Switched!', text: 'Active branch changed successfully.', icon: 'success', timer: 1500, showConfirmButton: false });
                    }
                });
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ title: 'Branch Switched!', text: 'Active branch changed successfully.', icon: 'success', timer: 1500, showConfirmButton: false });
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            syncThemeIcons();

            // Profile Dropdown Toggle Logic
            const trigger = document.getElementById('profileDropdownTrigger');
            const menu = document.getElementById('profileDropdownMenu');
            
            if (trigger && menu) {
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = menu.style.display === 'block';
                    menu.style.display = isOpen ? 'none' : 'block';
                    trigger.classList.toggle('active', !isOpen);
                });
                
                document.addEventListener('click', function(e) {
                    if (!trigger.contains(e.target) && !menu.contains(e.target)) {
                        menu.style.display = 'none';
                        trigger.classList.remove('active');
                    }
                });
            }
        });
        if (document.body) syncThemeIcons();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Vendor-style success alert after a demo "save"
            try {
                var params = new URLSearchParams(window.location.search);
                if (params.get('saved') === '1' && typeof Swal !== 'undefined') {
                    Swal.fire({ title: 'Success!', text: 'Record saved successfully.', icon: 'success', timer: 3000, showConfirmButton: false });
                    params.delete('saved');
                    var clean = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
                    window.history.replaceState({}, '', clean);
                }
            } catch (e) {}

            // Client-side pagination: 10 rows per page for every demo table
            document.querySelectorAll('table.demo-table').forEach(function (table) {
                var tbody = table.tBodies[0];
                if (!tbody) return;
                var rows = Array.prototype.slice.call(tbody.rows);
                var perPage = 10;
                if (rows.length <= perPage) return;

                var pageCount = Math.ceil(rows.length / perPage);
                var current = 1;
                var nav = document.createElement('div');
                nav.className = 'demo-pagination';
                var wrap = table.closest('.demo-table-wrap') || table.parentElement;
                wrap.parentElement.insertBefore(nav, wrap.nextSibling);

                function render() {
                    rows.forEach(function (r, idx) {
                        r.style.display = (Math.floor(idx / perPage) + 1 === current) ? '' : 'none';
                    });
                    var startN = (current - 1) * perPage + 1;
                    var endN = Math.min(current * perPage, rows.length);
                    var html = '<span class="dp-info">Showing ' + startN + '–' + endN + ' of ' + rows.length + ' results</span>';
                    html += '<button ' + (current === 1 ? 'disabled' : '') + ' data-go="' + (current - 1) + '">‹</button>';
                    for (var p = 1; p <= pageCount; p++) {
                        html += '<button class="' + (p === current ? 'active' : '') + '" data-go="' + p + '">' + p + '</button>';
                    }
                    html += '<button ' + (current === pageCount ? 'disabled' : '') + ' data-go="' + (current + 1) + '">›</button>';
                    nav.innerHTML = html;
                    nav.querySelectorAll('button[data-go]').forEach(function (b) {
                        b.addEventListener('click', function () {
                            var g = parseInt(b.getAttribute('data-go'), 10);
                            if (g >= 1 && g <= pageCount) { current = g; render(); }
                        });
                    });
                }
                render();
            });
        });
    </script>
</body>
</html>
