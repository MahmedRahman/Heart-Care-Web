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
                    <a href="{{ route('patients.index') }}" class="sidebar-menu-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">people</span>
                        <span>Patients</span>
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
