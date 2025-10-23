<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Masjid')</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Icon --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #198754;
            --primary-dark: #157347;
            --primary-light: #20c997;
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --text-dark: #343a40;
            --text-light: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }

        /* Sidebar */
        .sidebar {
            background-color: var(--primary-color);
            color: var(--white);
            height: 100vh;
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            transition: var(--transition);
            z-index: 1000;
            overflow-y: auto;
            padding: 1rem 0;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-header h4 {
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-menu {
            padding: 0 1rem;
        }

        .sidebar-menu a {
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 0.5rem;
            transition: var(--transition);
            font-weight: 500;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }

        .sidebar-menu a i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            transition: var(--transition);
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 280px;
        }

        /* Navbar */
        .navbar {
            background-color: var(--white);
            box-shadow: var(--box-shadow);
            padding: 1rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Mobile Toggle */
        .mobile-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: var(--transition);
        }

        .mobile-toggle:hover {
            background-color: rgba(25, 135, 84, 0.1);
        }

        /* Content Area */
        .content-area {
            padding: 1.5rem;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: var(--white);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            font-weight: 600;
            color: var(--primary-color);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: var(--border-radius);
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline-danger {
            border-radius: var(--border-radius);
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        /* Responsive */
        @media (min-width: 992px) {
            .sidebar {
                left: 0;
            }

            .main-content {
                margin-left: 280px;
            }

            .mobile-toggle {
                display: none;
            }
        }

        @media (max-width: 991px) {
            .main-content.expanded {
                margin-left: 0;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }

            .overlay.active {
                display: block;
            }
        }

        /* Custom Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>

    @stack('styles')
</head>
<body>
    {{-- Overlay for mobile --}}
    <div class="overlay"></div>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-house-door-fill"></i> Admin Masjid</h4>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.profil') }}" class="{{ request()->routeIs('admin.profil') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Profil Masjid
            </a>
            <a href="{{ route('admin.jadwal-sholat') }}" class="{{ request()->routeIs('admin.jadwal-sholat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Jadwal Sholat
            </a>
            <a href="{{ route('admin.infaq') }}" class="{{ request()->routeIs('admin.infaq') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> Data Infaq
            </a>
            <a href="{{ route('admin.pengeluaran') }}" class="{{ request()->routeIs('admin.pengeluaran') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i> Pengeluaran
            </a>
            <a href="{{ route('admin.artikel') }}" class="{{ request()->routeIs('admin.artikel') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Artikel
            </a>
            <a href="{{ route('admin.pengurus.index') }}" class="{{ request()->routeIs('admin.pengurus.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Pengurus
            </a>
            <a href="{{ route('admin.rekening.index') }}" class="{{ request()->routeIs('admin.rekening.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i> Rekening
            </a>
            <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i> Galeri
            </a>
            <a href="{{ route('admin.penghargaan.index') }}" class="{{ request()->routeIs('admin.penghargaan.*') ? 'active' : '' }}">
                <i class="bi bi-award"></i> Penghargaan
            </a>
            <a href="{{ route("admin.laporan") }}">
                <i class="bi bi-file-break-fill"></i> Laporan
            </a>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Navbar --}}
        <nav class="navbar">
            <div class="container-fluid">
                <button class="mobile-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <span class="navbar-brand ">Panel Admin</span>
                <div class="navbar-user">
                    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                    <div class="user-avatar">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <a href="{{ route('admin.logout') }}" class="btn btn-outline-danger btn-sm">Logout</a>
                </div>
            </div>
        </nav>

        {{-- Page Content --}}
        <main class="content-area">
            @yield('content')
        </main>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle sidebar for mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.overlay').classList.toggle('active');
        });

        // Close sidebar when clicking overlay
        document.querySelector('.overlay').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.remove('active');
            this.classList.remove('active');
        });

        // Auto-close sidebar on mobile when menu item is clicked
        if (window.innerWidth < 992) {
            document.querySelectorAll('.sidebar-menu a').forEach(function(item) {
                item.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.remove('active');
                    document.querySelector('.overlay').classList.remove('active');
                });
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
