@extends('layouts.app')

@section('title', 'Struktur Pengurus - Masjid Al-Ikhlas')

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

    .hero-pengurus {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.9) 0%, rgba(76, 175, 80, 0.8) 100%),
                    url('{{ asset('images/pengurus-bg.jpg') }}') center/cover no-repeat;
        color: white;
        padding: 100px 0 80px;
        text-align: center;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
        position: relative;
        overflow: hidden;
    }

    .hero-pengurus::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

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

    .pengurus-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        overflow: hidden;
        height: 100%;
        background: white;
    }

    .pengurus-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .pengurus-photo {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--light-green);
        margin: 0 auto;
        transition: var(--transition);
    }

    .pengurus-card:hover .pengurus-photo {
        border-color: var(--secondary-green);
        transform: scale(1.05);
    }

    .jabatan-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1rem;
        background: var(--secondary-green);
        color: white;
    }

    .contact-info {
        background: var(--light-green);
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .contact-item:last-child {
        margin-bottom: 0;
    }

    .contact-item i {
        color: var(--secondary-green);
        width: 16px;
    }

    .jabatan-section {
        margin-bottom: 4rem;
    }

    .jabatan-header {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        color: white;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        text-align: center;
    }

    .jabatan-title {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .jabatan-title i {
        font-size: 2rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
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

    /* Struktur Organisasi Sederhana */
    .struktur-sederhana {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 2rem;
        margin-bottom: 3rem;
    }

    .struktur-item {
        text-align: center;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
        margin-bottom: 1rem;
        border: 2px solid var(--light-green);
    }

    .struktur-item:hover {
        border-color: var(--secondary-green);
        transform: translateY(-3px);
    }

    .struktur-icon {
        font-size: 2.5rem;
        color: var(--secondary-green);
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .hero-pengurus {
            padding: 80px 0 60px;
        }

        .pengurus-photo {
            width: 120px;
            height: 120px;
        }

        .jabatan-title {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-pengurus mb-5">
    <div class="container">
        <div class="hero-content">
            <h1 class="display-5 fw-bold mb-3">Struktur Pengurus</h1>
            <p class="lead mb-4">Kenali para pengurus masjid yang berdedikasi dalam mengelola dan memakmurkan {{ $profile->nama ?? 'Masjid Al-Ikhlas' }}</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <span class="badge bg-light text-dark fs-6">
                    <i class="bi bi-people-fill me-2"></i>{{ $penguruses->flatten()->count() }} Pengurus
                </span>
                <span class="badge bg-light text-dark fs-6">
                    <i class="bi bi-diagram-3 me-2"></i>{{ $penguruses->count() }} Jabatan
                </span>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">

    <!-- Struktur Organisasi Sederhana -->
    <section class="mb-5 fade-in-up">
        <div class="section-title">
            <h2>Struktur Organisasi</h2>
        </div>

        <div class="struktur-sederhana">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="struktur-item">
                        <i class="bi bi-person-badge struktur-icon"></i>
                        <h5 class="fw-bold text-success">Ketua</h5>
                        <p class="text-muted small mb-0">Pimpinan utama masjid</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="struktur-item">
                        <i class="bi bi-journal-text struktur-icon"></i>
                        <h5 class="fw-bold text-success">Sekretaris</h5>
                        <p class="text-muted small mb-0">Mengurus administrasi</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="struktur-item">
                        <i class="bi bi-cash-coin struktur-icon"></i>
                        <h5 class="fw-bold text-success">Bendahara</h5>
                        <p class="text-muted small mb-0">Mengelola keuangan</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="struktur-item">
                        <i class="bi bi-people struktur-icon"></i>
                        <h5 class="fw-bold text-success">Anggota</h5>
                        <p class="text-muted small mb-0">Pelaksana kegiatan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Pengurus per Jabatan -->
    @foreach($penguruses as $jabatan => $pengurusJabatan)
        <section class="jabatan-section fade-in-up">
            <div class="jabatan-header">
                <div class="jabatan-title">
                    @php
                        $icon = 'bi-person-gear';
                        if (str_contains(strtolower($jabatan), 'ketua')) {
                            $icon = 'bi-person-badge';
                        } elseif (str_contains(strtolower($jabatan), 'sekretaris')) {
                            $icon = 'bi-journal-text';
                        } elseif (str_contains(strtolower($jabatan), 'bendahara')) {
                            $icon = 'bi-cash-coin';
                        } elseif (str_contains(strtolower($jabatan), 'anggota')) {
                            $icon = 'bi-people';
                        }
                    @endphp
                    <i class="bi {{ $icon }}"></i>
                    <h3 class="mb-0">{{ $jabatan }}</h3>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($pengurusJabatan as $pengurus)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card pengurus-card h-100 text-center">
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <img src="{{ $pengurus->foto ? asset('storage/' . $pengurus->foto) : asset('images/default-avatar.jpg') }}"
                                         alt="{{ $pengurus->nama }}"
                                         class="pengurus-photo">
                                </div>

                                <h5 class="fw-bold text-dark mb-2">{{ $pengurus->nama }}</h5>

                                <div class="jabatan-badge">
                                    {{ $pengurus->jabatan }}
                                </div>

                                @if($pengurus->no_hp || $pengurus->email || $pengurus->alamat)
                                    <div class="contact-info">
                                        @if($pengurus->no_hp)
                                            <div class="contact-item">
                                                <i class="bi bi-telephone-fill"></i>
                                                <span>{{ $pengurus->no_hp }}</span>
                                            </div>
                                        @endif
                                        @if($pengurus->email)
                                            <div class="contact-item">
                                                <i class="bi bi-envelope-fill"></i>
                                                <span>{{ $pengurus->email }}</span>
                                            </div>
                                        @endif
                                        @if($pengurus->alamat)
                                            <div class="contact-item">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                <span>{{ Str::limit($pengurus->alamat, 30) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach

    <!-- Empty State -->
    @if($penguruses->isEmpty())
        <div class="empty-state fade-in-up">
            <i class="bi bi-people"></i>
            <h4 class="text-muted mb-3">Belum Ada Data Pengurus</h4>
            <p class="text-muted">Informasi struktur pengurus sedang dalam proses pembaruan.</p>
        </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi fade in untuk sections
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

        // Highlight card on hover dengan efek yang lebih smooth
        const pengurusCards = document.querySelectorAll('.pengurus-card');
        pengurusCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
                this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'var(--box-shadow)';
            });
        });
    });
</script>
@endpush
