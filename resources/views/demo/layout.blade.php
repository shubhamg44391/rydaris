<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rydaris | Vendor Demo Workspace</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for icons -->
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

        .menu-link:hover {
            color: var(--brand);
            background: rgba(82, 234, 210, 0.05);
        }

        .menu-link.active {
            color: var(--bg-1);
            background: var(--brand);
            box-shadow: 0 4px 12px rgba(82, 234, 210, 0.2);
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
            color: var(--brand);
        }

        .submenu-link.active::before {
            color: var(--brand);
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
            document.body.classList.toggle('sidebar-collapsed');
            const isCollapsed = document.body.classList.contains('sidebar-collapsed');
            const icon = document.getElementById('collapse-icon');
            if (isCollapsed) {
                icon.className = 'fa-solid fa-chevron-right';
            } else {
                icon.className = 'fa-solid fa-chevron-left';
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.xp-overlay').forEach(o => {
                o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); });
            });
        });
    </script>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-text">Rydaris.<span></span></div>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('demo.dashboard') }}" class="menu-link {{ request()->routeIs('demo.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i> <span>Dashboard</span>
            </a>
            
            <div class="menu-item-with-submenu">
                <a class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa-regular fa-calendar-days"></i> <span>Booking</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s;"></i>
                </a>
                <div class="submenu" style="display: none; background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="#" onclick="alert('Demo Mode: Booking list clicked')" class="submenu-link">Booking List</a>
                    <a href="#" onclick="alert('Demo Mode: Add Booking clicked')" class="submenu-link">Add Booking</a>
                </div>
            </div>

            <div class="menu-item-with-submenu">
                <a class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-car"></i> <span>Vehicles</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s;"></i>
                </a>
                <div class="submenu" style="display: none; background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="#" onclick="alert('Demo Mode: Vehicle list clicked')" class="submenu-link">Vehicle List</a>
                    <a href="#" onclick="alert('Demo Mode: Add Vehicle clicked')" class="submenu-link">Add Vehicle</a>
                </div>
            </div>

            <div class="menu-item-with-submenu">
                <a class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-map-pin"></i> <span>Locations</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s;"></i>
                </a>
                <div class="submenu" style="display: none; background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="#" onclick="alert('Demo Mode: Location list clicked')" class="submenu-link">Location List</a>
                    <a href="#" onclick="alert('Demo Mode: Add Location clicked')" class="submenu-link">Add Location</a>
                </div>
            </div>

            <div class="menu-item-with-submenu">
                <a class="menu-link {{ request()->routeIs('demo.customers') ? 'active' : '' }}" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-users"></i> <span>Customers</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s; {{ request()->routeIs('demo.customers') ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="submenu" style="{{ request()->routeIs('demo.customers') ? 'display: flex;' : 'display: none;' }} background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="{{ route('demo.customers') }}" class="submenu-link {{ request()->routeIs('demo.customers') ? 'active' : '' }}">Customer List</a>
                    <a href="#" onclick="alert('Demo Mode: User Invitations is a placeholder.')" class="submenu-link">User Invitations</a>
                </div>
            </div>

            <a href="{{ route('demo.fleet') }}" class="menu-link {{ request()->routeIs('demo.fleet') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> <span>Fleet Management</span>
            </a>

            <div class="menu-item-with-submenu">
                <a class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-circle-plus"></i> <span>Extras</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s;"></i>
                </a>
                <div class="submenu" style="display: none; background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="#" onclick="alert('Demo Mode: Extras List clicked')" class="submenu-link">Extras List</a>
                    <a href="#" onclick="alert('Demo Mode: Insurance List clicked')" class="submenu-link">Insurance List</a>
                    <a href="#" onclick="alert('Demo Mode: Features Mapping clicked')" class="submenu-link">Features Mapping</a>
                    <a href="#" onclick="alert('Demo Mode: Rules clicked')" class="submenu-link">Rules</a>
                </div>
            </div>

            <a href="#" onclick="alert('Demo Mode: Coupons is a placeholder.')" class="menu-link">
                <i class="fa-solid fa-ticket"></i> <span>Coupons</span>
            </a>

            <a href="#" onclick="alert('Demo Mode: Support Ticket is a placeholder.')" class="menu-link">
                <i class="fa-regular fa-comment-dots"></i> <span>Support Ticket</span>
            </a>

            <div class="menu-item-with-submenu">
                <a class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-wallet"></i> <span>Subscription</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s;"></i>
                </a>
                <div class="submenu" style="display: none; background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="#" onclick="alert('Demo Mode: Buy Subscription clicked')" class="submenu-link">Buy Subscription</a>
                    <a href="#" onclick="alert('Demo Mode: Subscription History clicked')" class="submenu-link">Subscription History</a>
                </div>
            </div>

            <a href="#" onclick="alert('Demo Mode: Terms & Conditions is a placeholder.')" class="menu-link">
                <i class="fa-solid fa-file-contract"></i> <span>Terms & Conditions</span>
            </a>

            <div class="menu-item-with-submenu">
                <a class="menu-link" onclick="toggleSubmenu(this)">
                    <i class="fa-solid fa-gear"></i> <span>Settings</span> <i class="fa-solid fa-chevron-down arrow" style="margin-left:auto; font-size:0.75rem; transition: transform 0.2s;"></i>
                </a>
                <div class="submenu" style="display: none; background: rgba(255,255,255,0.02); border-left: 1px solid rgba(82, 234, 210, 0.15); margin: 0; padding: 6px 12px 10px 36px; flex-direction: column; gap: 4px;">
                    <a href="#" onclick="alert('Demo Mode: Business Settings clicked')" class="submenu-link">Business Settings</a>
                    <a href="#" onclick="alert('Demo Mode: Payment Settings clicked')" class="submenu-link">Payment Settings</a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Viewport -->
    <div class="viewport">
        <!-- Topbar -->
        <header class="topbar">
            <!-- Left Topbar Elements matching screenshot -->
            <div class="topbar-left" style="gap: 15px; display: flex; align-items: center;">
                <button class="btn-collapse-sidebar" onclick="toggleSidebarCollapse()" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); color: #fff; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; outline: none; transition: all 0.2s;">
                    <i class="fa-solid fa-chevron-left" id="collapse-icon"></i>
                </button>
                <a href="{{ route('home') }}" style="background: rgba(82, 234, 210, 0.05); border: 1px solid rgba(82, 234, 210, 0.2); color: var(--brand, #52ead2); padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                    <i class="fa-solid fa-globe"></i> Visit Website
                </a>
            </div>

            <!-- Right Topbar Elements matching screenshot -->
            <div class="topbar-right" style="gap: 25px; display: flex; align-items: center;">
                <div class="branch-display-wrap" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(82, 234, 210, 0.08); border: 1px solid rgba(82, 234, 210, 0.2); border-radius: 8px; padding: 6px 12px; font-size: 0.85rem; font-weight: 600; color: #f8fafc;">
                    <i class="fa-solid fa-house-chimney" style="color: var(--brand, #52ead2); font-size: 0.85rem;"></i>
                    <span>Branch: Dhili</span>
                </div>
                <span style="font-weight: 600; font-size: 0.9rem; color: #fff; display: inline-flex; align-items: center; gap: 8px;">
                    Hello, Cynthia Keane Meyers Buck 
                    <i class="fa-regular fa-circle-user" style="color: var(--brand); font-size: 1.1rem;"></i>
                </span>
                <a href="{{ route('home') }}" style="border: none; background: transparent; padding: 0; color: #ef4444; font-size: 0.9rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; transition: color 0.2s;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </a>
            </div>
        </header>

        <!-- Content -->
        <main class="content">
            @yield('content')
        </main>
    </div>

</body>
</html>
