@extends('layouts.app')

@section('title', 'Profil Masjid - ' . ($profile->nama ?? 'Masjid Al-Ikhlas'))

@push('styles')
<style>
    :root {
        --primary-green: #2e7d32;
        --secondary-green: #4caf50;
        --light-green: #e8f5e9;
        --text-dark: #1b1b1b;
        --border-radius: 16px;
        --box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    .hero-profile {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.9) 0%, rgba(76, 175, 80, 0.8) 100%),
                    url('{{ asset('images/masjid-bg.jpg') }}') center/cover no-repeat;
        color: white;
        padding: 100px 0 80px;
        text-align: center;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
        position: relative;
        overflow: hidden;
    }

    .hero-profile::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .profile-logo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.3);
        background: white;
        margin: 0 auto 2rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .profile-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .section-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 2.5rem;
        margin-bottom: 2rem;
        transition: var(--transition);
        border: none;
    }

    .section-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .section-title {
        position: relative;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        color: var(--primary-green);
        font-weight: 700;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--secondary-green);
        border-radius: 2px;
    }

    .visi-misi-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        background: var(--light-green);
        border-radius: 12px;
        border-left: 4px solid var(--secondary-green);
    }

    .visi-misi-icon {
        background: var(--secondary-green);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .location-map {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        height: 400px;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        transition: var(--transition);
    }

    .info-item:hover {
        background: var(--light-green);
        transform: translateX(5px);
    }

    .info-icon {
        width: 50px;
        height: 50px;
        background: var(--secondary-green);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

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

    @media (max-width: 768px) {
        .hero-profile {
            padding: 80px 0 60px;
        }

        .profile-logo {
            width: 120px;
            height: 120px;
        }

        .section-card {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-profile">
    <div class="container">
        <div class="hero-content">
            <div class="profile-logo">
                <img src="{{ $profile && $profile->foto_logo ? asset('storage/'.$profile->foto_logo) : asset('images/default-masjid.png') }}"
                     alt="Logo {{ $profile->nama ?? 'Masjid' }}">
            </div>
            <h1 class="display-4 fw-bold mb-3">{{ $profile->nama ?? 'Masjid Al-Ikhlas' }}</h1>
            <p class="lead mb-0">{{ $profile->deskripsi ?? 'Menjadi pusat ibadah dan kebersamaan umat Islam' }}</p>
        </div>
    </div>
</section>

<div class="container py-5">

    <!-- Informasi Umum -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <div class="section-card fade-in-up">
                <h2 class="section-title">Tentang Masjid</h2>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Alamat</h6>
                                <p class="mb-0 text-muted">
                                    {{ $profile->alamat ?? 'Alamat belum diatur' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Desa/Kecamatan</h6>
                                <p class="mb-0 text-muted">
                                    {{ $profile->desa_kecamatan ?? 'Belum diatur' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($profile && $profile->deskripsi)
                    <div class="bg-light-green p-4 rounded">
                        <h5 class="text-success mb-3">Deskripsi Masjid</h5>
                        <p class="mb-0 text-dark">{{ $profile->deskripsi }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Visi dan Misi -->
    @if($profile && ($profile->visi || $profile->misi))
    <div class="row mb-5">
        <div class="col-12">
            <div class="section-card fade-in-up">
                <h2 class="section-title">Visi & Misi Masjid</h2>

                <div class="row">
                    @if($profile->visi)
                    <div class="col-lg-6 mb-4">
                        <div class="visi-misi-item">
                            <div class="visi-misi-icon">
                                <i class="bi bi-eye-fill"></i>
                            </div>
                            <div>
                                <h5 class="text-success fw-bold mb-3">Visi</h5>
                                <p class="mb-0">{{ $profile->visi }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($profile->misi)
                    <div class="col-lg-6 mb-4">
                        <div class="visi-misi-item">
                            <div class="visi-misi-icon">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <div>
                                <h5 class="text-success fw-bold mb-3">Misi</h5>
                                <p class="mb-0">{{ $profile->misi }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Peta Lokasi -->
    @if($profile && $profile->koordinat_lat && $profile->koordinat_long)
    <div class="row mb-5">
        <div class="col-12">
            <div class="section-card fade-in-up">
                <h2 class="section-title">Lokasi Masjid</h2>

                <div class="location-map" id="map"></div>

                <div class="mt-3 text-center">
                    <a href="https://maps.google.com/?q={{ $profile->koordinat_lat }},{{ $profile->koordinat_long }}"
                       target="_blank"
                       class="btn btn-success">
                        <i class="bi bi-arrow-up-right-square me-2"></i>
                        Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Fasilitas Masjid -->
    <div class="row">
        <div class="col-12">
            <div class="section-card fade-in-up">
                <h2 class="section-title">Fasilitas Masjid</h2>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="text-center p-4 bg-light-green rounded">
                            <i class="bi bi-droplet-fill display-4 text-success mb-3"></i>
                            <h5 class="fw-bold text-success">Tempat Wudhu</h5>
                            <p class="text-muted mb-0">Fasilitas wudhu yang nyaman dan bersih</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="text-center p-4 bg-light-green rounded">
                            <i class="bi bi-book-fill display-4 text-success mb-3"></i>
                            <h5 class="fw-bold text-success">Perpustakaan</h5>
                            <p class="text-muted mb-0">Koleksi buku Islami untuk jamaah</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="text-center p-4 bg-light-green rounded">
                            <i class="bi bi-mic-fill display-4 text-success mb-3"></i>
                            <h5 class="fw-bold text-success">Sound System</h5>
                            <p class="text-muted mb-0">Sistem audio yang memadai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
@if($profile && $profile->koordinat_lat && $profile->koordinat_long)
<!-- Leaflet JS untuk Peta -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi peta
        const map = L.map('map').setView([{{ $profile->koordinat_lat }}, {{ $profile->koordinat_long }}], 15);

        // Tambahkan tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Tambahkan marker
        const mosqueIcon = L.divIcon({
            html: '<i class="bi bi-house-heart-fill text-danger" style="font-size: 2rem;"></i>',
            iconSize: [30, 30],
            className: 'mosque-marker'
        });

        L.marker([{{ $profile->koordinat_lat }}, {{ $profile->koordinat_long }}], {icon: mosqueIcon})
            .addTo(map)
            .bindPopup('<strong>{{ $profile->nama }}</strong><br>{{ $profile->alamat }}')
            .openPopup();

        // Animasi fade in untuk section
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in-up').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });
    });
</script>

<style>
    .mosque-marker {
        background: transparent !important;
        border: none !important;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
</style>
@else
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi fade in untuk section
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in-up').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });
    });
</script>
@endif
@endpush
