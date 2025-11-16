<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Heart Care</title>

    <!-- Material Design 3 -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --md-sys-color-primary: #0D268D;
            --md-sys-color-on-primary: #FFFFFF;
            --md-sys-color-secondary: #1E3FA8;
            --md-sys-color-surface: #FFFFFF;
            --md-sys-color-on-surface: #1C1B1F;
            --md-sys-color-surface-variant: #F5F7FA;
            --md-sys-color-on-surface-variant: #64748B;
            --md-sys-color-outline: #E2E8F0;
            --md-sys-color-outline-variant: #F1F5F9;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--md-sys-color-on-surface);
        }

        .header {
            background: linear-gradient(135deg, var(--md-sys-color-primary) 0%, var(--md-sys-color-secondary) 100%);
            box-shadow: 0 4px 20px rgba(13, 38, 141, 0.15);
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 1000;
            height: var(--header-height);
            display: flex;
            align-items: center;
        }

        .header-content {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: white;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .logo {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logo .material-symbols-outlined {
            color: white;
            font-size: 28px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
            color: white;
            letter-spacing: -0.5px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .swagger-link {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .swagger-link:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        .swagger-link .material-symbols-outlined {
            font-size: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 12px;
            color: white;
            font-size: 14px;
            font-weight: 500;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .main-container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--md-sys-color-surface);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.05);
            min-height: calc(100vh - var(--header-height));
            position: sticky;
            top: var(--header-height);
            padding: 24px 0;
            transition: transform 0.3s ease;
            border-right: 1px solid var(--md-sys-color-outline);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 16px;
        }

        .sidebar-menu-item {
            margin-bottom: 8px;
        }

        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 20px;
            color: var(--md-sys-color-on-surface-variant);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 15px;
            font-weight: 500;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--md-sys-color-primary);
            transform: scaleY(0);
            transition: transform 0.2s ease;
        }

        .sidebar-menu-link:hover {
            background: var(--md-sys-color-surface-variant);
            color: var(--md-sys-color-primary);
            transform: translateX(4px);
        }

        .sidebar-menu-link.active {
            background: linear-gradient(135deg, rgba(13, 38, 141, 0.1) 0%, rgba(30, 63, 168, 0.1) 100%);
            color: var(--md-sys-color-primary);
            font-weight: 600;
        }

        .sidebar-menu-link.active::before {
            transform: scaleY(1);
        }

        .sidebar-menu-link .material-symbols-outlined {
            font-size: 24px;
            transition: transform 0.2s ease;
        }

        .sidebar-menu-link:hover .material-symbols-outlined {
            transform: scale(1.1);
        }

        .sidebar-menu-group {
            margin-bottom: 8px;
        }

        .sidebar-menu-group-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 20px;
            color: var(--md-sys-color-on-surface-variant);
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 15px;
            font-weight: 500;
            border-radius: 12px;
            position: relative;
            user-select: none;
        }

        .sidebar-menu-group-header:hover {
            background: var(--md-sys-color-surface-variant);
            color: var(--md-sys-color-primary);
        }

        .sidebar-menu-group-header.active {
            background: linear-gradient(135deg, rgba(13, 38, 141, 0.1) 0%, rgba(30, 63, 168, 0.1) 100%);
            color: var(--md-sys-color-primary);
            font-weight: 600;
        }

        .expand-icon {
            margin-left: auto;
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .sidebar-menu-group-header.active .expand-icon {
            transform: rotate(90deg);
        }

        .sidebar-submenu {
            list-style: none;
            padding: 0;
            margin: 8px 0 0 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
            padding-left: 0;
        }

        .sidebar-submenu.open {
            max-height: 300px;
            padding-left: 20px;
        }

        .sidebar-submenu li {
            margin-bottom: 4px;
        }

        .sidebar-submenu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: var(--md-sys-color-on-surface-variant);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 400;
            border-radius: 8px;
            position: relative;
        }

        .sidebar-submenu-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: var(--md-sys-color-primary);
            transition: height 0.2s ease;
            border-radius: 0 2px 2px 0;
        }

        .sidebar-submenu-link:hover {
            background: var(--md-sys-color-surface-variant);
            color: var(--md-sys-color-primary);
            padding-left: 20px;
        }

        .sidebar-submenu-link:hover::before {
            height: 60%;
        }

        .sidebar-submenu-link.active {
            background: linear-gradient(135deg, rgba(13, 38, 141, 0.08) 0%, rgba(30, 63, 168, 0.08) 100%);
            color: var(--md-sys-color-primary);
            font-weight: 600;
            padding-left: 20px;
        }

        .sidebar-submenu-link.active::before {
            height: 60%;
        }

        .sidebar-submenu-link .material-symbols-outlined {
            font-size: 20px;
        }

        .content-area {
            flex: 1;
            padding: 32px;
            min-height: calc(100vh - var(--header-height) - 80px);
        }

        .mdc-button {
            height: 44px;
            padding: 0 28px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--md-sys-color-primary) 0%, var(--md-sys-color-secondary) 100%);
            color: var(--md-sys-color-on-primary);
            font-size: 14px;
            font-weight: 600;
            font-family: 'Roboto', sans-serif;
            letter-spacing: 0.3px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(13, 38, 141, 0.25);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .mdc-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 38, 141, 0.35);
        }

        .mdc-button:active {
            transform: translateY(0);
        }

        .mdc-button--outlined {
            background-color: transparent !important;
            border: 2px solid var(--md-sys-color-outline) !important;
            color: #FFFFFF !important;
            box-shadow: none !important;
            text-decoration: none !important;
        }

        .mdc-button--outlined:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: var(--md-sys-color-outline) !important;
            color: #FFFFFF !important;
            box-shadow: none !important;
            text-decoration: none !important;
            transform: translateY(-2px);
        }

        .mdc-button--outlined:active {
            transform: translateY(0);
        }

        .footer {
            background: var(--md-sys-color-surface);
            padding: 20px 32px;
            text-align: center;
            color: var(--md-sys-color-on-surface-variant);
            font-size: 13px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
            border-top: 1px solid var(--md-sys-color-outline);
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Enhanced Form Input Styles */
        .form-input, .form-textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--md-sys-color-outline-variant);
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Roboto', sans-serif;
            color: var(--md-sys-color-on-surface);
            background-color: var(--md-sys-color-surface);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.05);
            font-weight: 400;
        }

        .form-input:hover, .form-textarea:hover {
            border-color: var(--md-sys-color-outline);
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.08);
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--md-sys-color-primary);
            border-width: 2px;
            box-shadow: 0px 0px 0px 4px rgba(13, 38, 141, 0.1),
                        0px 2px 8px 0px rgba(13, 38, 141, 0.15);
            transform: translateY(-1px);
            background-color: var(--md-sys-color-surface);
        }

        .form-input::placeholder, .form-textarea::placeholder {
            color: var(--md-sys-color-on-surface-variant);
            opacity: 0.6;
        }

        .form-input:disabled, .form-textarea:disabled {
            background-color: var(--md-sys-color-surface-variant);
            color: var(--md-sys-color-on-surface-variant);
            cursor: not-allowed;
            opacity: 0.6;
        }

        .form-group:has(.form-input:focus) .form-label,
        .form-group:has(.form-textarea:focus) .form-label {
            color: var(--md-sys-color-primary);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .sidebar {
                position: fixed;
                left: 0;
                top: var(--header-height);
                z-index: 999;
                transform: translateX(-100%);
                box-shadow: 4px 0 30px rgba(0, 0, 0, 0.2);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .content-area {
                width: 100%;
                padding: 20px;
            }

            .header-title {
                font-size: 18px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="logo">
                    <span class="material-symbols-outlined">favorite</span>
                </div>
                <h1 class="header-title">Heart Care</h1>
            </div>
            <div class="header-right">
                <a href="{{ url('/api/documentation') }}" target="_blank" class="swagger-link" title="API Documentation">
                    <span class="material-symbols-outlined">api</span>
                    <span>API Docs</span>
                </a>
                <div class="user-info">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('users.index') }}" class="sidebar-menu-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">person</span>
                        <span>Users (Employees)</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('patients.index') }}" class="sidebar-menu-link {{ request()->routeIs('patients.*') && !request()->routeIs('patients.heart-rate-readings.*') && !request()->routeIs('patients.blood-pressure-readings.*') && !request()->routeIs('patients.oxygen-saturation-readings.*') && !request()->routeIs('patients.weight-readings.*') && !request()->routeIs('patients.random-blood-sugar-readings.*') && !request()->routeIs('patients.fluid-balance-readings.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">people</span>
                        <span>Patients</span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-menu-group">
                    <div class="sidebar-menu-group-header {{ request()->routeIs('vitals.*') || request()->routeIs('patients.heart-rate-readings.*') || request()->routeIs('patients.blood-pressure-readings.*') || request()->routeIs('patients.oxygen-saturation-readings.*') || request()->routeIs('patients.weight-readings.*') || request()->routeIs('patients.random-blood-sugar-readings.*') || request()->routeIs('patients.fluid-balance-readings.*') ? 'active' : '' }}" onclick="toggleVitalsMenu()">
                        <span class="material-symbols-outlined">monitor_heart</span>
                        <span>Vitals Signs</span>
                        <span class="material-symbols-outlined expand-icon">chevron_right</span>
                    </div>
                    <ul class="sidebar-submenu {{ request()->routeIs('vitals.*') || request()->routeIs('patients.heart-rate-readings.*') || request()->routeIs('patients.blood-pressure-readings.*') || request()->routeIs('patients.oxygen-saturation-readings.*') || request()->routeIs('patients.weight-readings.*') || request()->routeIs('patients.random-blood-sugar-readings.*') || request()->routeIs('patients.fluid-balance-readings.*') ? 'open' : '' }}">
                        <li>
                            <a href="{{ route('vitals.heart-rate') }}" class="sidebar-submenu-link {{ request()->routeIs('vitals.heart-rate') || request()->routeIs('patients.heart-rate-readings.*') ? 'active' : '' }}">
                                <span class="material-symbols-outlined">favorite</span>
                                <span>Heart Rate</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vitals.blood-pressure') }}" class="sidebar-submenu-link {{ request()->routeIs('vitals.blood-pressure') || request()->routeIs('patients.blood-pressure-readings.*') ? 'active' : '' }}">
                                <span class="material-symbols-outlined">monitor_heart</span>
                                <span>Blood Pressure</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vitals.oxygen-saturation') }}" class="sidebar-submenu-link {{ request()->routeIs('vitals.oxygen-saturation') || request()->routeIs('patients.oxygen-saturation-readings.*') ? 'active' : '' }}">
                                <span class="material-symbols-outlined">air</span>
                                <span>Oxygen Saturation</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vitals.weight') }}" class="sidebar-submenu-link {{ request()->routeIs('vitals.weight') || request()->routeIs('patients.weight-readings.*') ? 'active' : '' }}">
                                <span class="material-symbols-outlined">monitor_weight</span>
                                <span>Weight</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vitals.random-blood-sugar') }}" class="sidebar-submenu-link {{ request()->routeIs('vitals.random-blood-sugar') || request()->routeIs('patients.random-blood-sugar-readings.*') ? 'active' : '' }}">
                                <span class="material-symbols-outlined">bloodtype</span>
                                <span>Random Blood Sugar</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vitals.fluid-balance') }}" class="sidebar-submenu-link {{ request()->routeIs('vitals.fluid-balance') || request()->routeIs('patients.fluid-balance-readings.*') ? 'active' : '' }}">
                                <span class="material-symbols-outlined">water_drop</span>
                                <span>Fluid Balance</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('radiology-reports.index') }}" class="sidebar-menu-link {{ request()->routeIs('radiology-reports.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">radiology</span>
                        <span>Radiology Reports</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('lab-reports.index') }}" class="sidebar-menu-link {{ request()->routeIs('lab-reports.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">science</span>
                        <span>Lab Reports</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('settings') }}" class="sidebar-menu-link {{ request()->routeIs('settings') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;" id="logout-form">
                        @csrf
                        <button type="button" onclick="confirmLogout()" class="sidebar-menu-link" style="width: 100%; text-align: left; border: none; background: none; cursor: pointer; color: inherit;">
                            <span class="material-symbols-outlined">logout</span>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- Content Area -->
        <main class="content-area">
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true,
                        position: 'top-end'
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true,
                        position: 'top-end'
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div>
            © {{ date('Y') }} Heart Care. All rights reserved.
        </div>
    </footer>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        function toggleVitalsMenu() {
            const submenu = document.querySelector('.sidebar-submenu');
            const header = document.querySelector('.sidebar-menu-group-header');
            
            if (submenu) {
                submenu.classList.toggle('open');
                if (header) {
                    header.classList.toggle('active');
                }
            }
        }

        // Auto-expand vitals menu if on vitals pages
        document.addEventListener('DOMContentLoaded', function() {
            const isVitalsPage = window.location.pathname.includes('vitals') ||
                                window.location.pathname.includes('heart-rate-readings') || 
                                window.location.pathname.includes('blood-pressure-readings') ||
                                window.location.pathname.includes('oxygen-saturation-readings') ||
                                window.location.pathname.includes('weight-readings') ||
                                window.location.pathname.includes('random-blood-sugar-readings') ||
                                window.location.pathname.includes('fluid-balance-readings');
            if (isVitalsPage) {
                const submenu = document.querySelector('.sidebar-submenu');
                const header = document.querySelector('.sidebar-menu-group-header');
                if (submenu && header) {
                    submenu.classList.add('open');
                    header.classList.add('active');
                }
            }
        });

        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of the system",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0D268D',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.querySelector('.menu-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
