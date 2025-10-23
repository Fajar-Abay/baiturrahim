<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Masjid Al-Ikhlas' }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @stack("styles")

    <style>
        :root {
            --primary-green: #2e7d32;
            --secondary-green: #4caf50;
            --light-green: #e8f5e9;
            --text-dark: #1b1b1b;
            --text-light: #6c757d;
            --white: #ffffff;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--light-green);
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            scroll-behavior: smooth;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background-color: var(--primary-green);
            transition: all 0.3s ease;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand i {
            font-size: 1.8rem;
        }

        .nav-link {
            font-weight: 500;
            position: relative;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: var(--transition);
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: #c8e6c9;
            transition: var(--transition);
            transform: translateX(-50%);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }

        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            color: white;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 3rem;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            background-color: var(--white);
            transition: var(--transition);
            overflow: hidden;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: var(--transition);
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 0.75rem;
        }

        .card-text {
            color: var(--text-light);
        }

        /* Buttons */
        .btn-green {
            background-color: var(--secondary-green);
            color: white;
            border-radius: 8px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-green:hover {
            background-color: var(--primary-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-green {
            border: 2px solid var(--secondary-green);
            color: var(--secondary-green);
            background: transparent;
            border-radius: 8px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
        }

        .btn-outline-green:hover {
            background-color: var(--secondary-green);
            color: white;
            transform: translateY(-2px);
        }

        /* Section Styling */
        .section-title {
            position: relative;
            margin-bottom: 3rem;
            text-align: center;
        }

        .section-title h2 {
            font-weight: 700;
            color: var(--primary-green);
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--secondary-green);
            border-radius: 2px;
        }

        /* Footer */
        footer {
            background-color: var(--primary-green);
            color: white;
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h5 {
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-section h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--secondary-green);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            text-align: center;
        }

        .footer-bottom small {
            opacity: 0.8;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .hero {
                padding: 3rem 0;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .navbar-brand {
                font-size: 1.3rem;
            }

            .nav-link {
                margin: 0.25rem 0;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 1.75rem;
            }

            .card-body {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-house-heart"></i> Masjid Al-Ikhlas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/profil') }}" class="nav-link {{ request()->is('profil') ? 'active' : '' }}">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/artikel') }}" class="nav-link {{ request()->is('artikel') ? 'active' : '' }}">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/pengurus') }}" class="nav-link {{ request()->is('pengurus') ? 'active' : '' }}">Pengurus</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/infaq') }}" class="nav-link {{ request()->is('infaq') ? 'active' : '' }}">Infaq</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('alquran.index') }}" class="nav-link {{ request()->is('alquran*') ? 'active' : '' }}">Al-Qur'an</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5>Masjid Al-Ikhlas</h5>
                    <p>Menjadi pusat kegiatan umat Islam yang mendukung pembangunan spiritual dan sosial masyarakat.</p>
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-green btn-sm">
                            <i class="bi bi-geo-alt"></i> Lokasi Kami
                        </a>
                    </div>
                </div>

                <div class="footer-section">
                    <h5>Menu Cepat</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}"><i class="bi bi-arrow-right"></i> Beranda</a></li>
                        <li><a href="{{ url('/profil') }}"><i class="bi bi-arrow-right"></i> Profil Masjid</a></li>
                        <li><a href="{{ url('/artikel') }}"><i class="bi bi-arrow-right"></i> Artikel Islami</a></li>
                        <li><a href="{{ url('/pengurus') }}"><i class="bi bi-arrow-right"></i> Struktur Pengurus</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h5>Kontak Kami</h5>
                    <ul class="footer-links">
                        <li><a href="#"><i class="bi bi-geo-alt"></i> Jl. Arif Rahman Hakim No.59, Kotakaler, Kec. Sumedang Utara, Kabupaten Sumedang, Jawa Barat 45355</a></li>
                        <li><a href="tel:+62123456789"><i class="bi bi-telephone"></i> +62 812-3456-7891</a></li>
                        <li><a href="mailto:masjidbaiturrohim@gmail.com"><i class="bi bi-envelope"></i> masjidbaiturrohim@gmail.com</a></li>
                        <li><a href="#"><i class="bi bi-facebook"></i> Facebook</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="mb-1">&copy; {{ date('Y') }} Masjid Al-Ikhlas. Semua hak dilindungi.</p>
                <small>Dibuat dengan ❤️ oleh Tim IT Masjid</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Add animation to elements when they come into view
        document.addEventListener('DOMContentLoaded', function() {
            // Add fade-in animation to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.classList.add('fade-in-up');
            });

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.style.padding = '0.5rem 0';
                    navbar.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
                } else {
                    navbar.style.padding = '1rem 0';
                    navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                }
            });
        });
    </script>

    @stack("scripts")
</body>
</html>
