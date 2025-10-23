@extends('layouts.app')

@section('title', 'Beranda Masjid')

@push("styles")
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

    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.9) 0%, rgba(76, 175, 80, 0.8) 100%),
                    url('{{ asset('images/masjid.jpg') }}') center/cover no-repeat;
        color: white;
        text-align: center;
        padding: 120px 20px;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
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
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero h1 {
        font-weight: 700;
        font-size: 2.8rem;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }

    /* Cards & Components */
    .hover-card {
        transition: var(--transition);
        border: none;
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--box-shadow);
    }

    .profile-img-wrapper {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid var(--secondary-green);
        background-color: var(--light-green);
        margin: 0 auto;
    }

    .profile-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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

    /* Prayer Time Styles */
    .prayer-card {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        color: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        text-align: center;
        transition: var(--transition);
    }

    .prayer-card:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 30px rgba(46, 125, 50, 0.3);
    }

    /* Buttons */
    .btn-green {
        background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
        color: white;
        border-radius: 50px;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border: none;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }

    .btn-green:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(76, 175, 80, 0.4);
        color: white;
    }

    /* Article Cards */
    .article-card {
        border: none;
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        height: 100%;
    }

    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--box-shadow);
    }

    .article-image {
        height: 200px;
        object-fit: cover;
        transition: var(--transition);
    }

    .article-card:hover .article-image {
        transform: scale(1.05);
    }

    .article-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--secondary-green);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero {
            padding: 80px 20px;
        }

        .hero h1 {
            font-size: 2rem;
        }

        .hero p {
            font-size: 1rem;
        }

        .profile-img-wrapper {
            width: 100px;
            height: 100px;
        }

        .prayer-card {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 576px) {
        .hero h1 {
            font-size: 1.75rem;
        }

        .section-title h2 {
            font-size: 1.5rem;
        }
    }

    /* Animation */
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
        animation: fadeInUp 0.6s ease-out;
    }
</style>
@endpush

@section('content')

{{-- 🌿 Hero Section --}}
<section class="hero mb-5">
    <div class="container">
        <div class="hero-content">
            <h1 class="mb-3">Selamat Datang di {{ $profile->nama ?? 'Masjid Al-Ikhlas' }}</h1>
            <p class="mb-4">{{ $profile->deskripsi ?? 'Mari kita makmurkan masjid dengan semangat kebersamaan dan ibadah.' }}</p>
            <button class="btn btn-green btn-lg" data-bs-toggle="modal" data-bs-target="#infaqModal">
                <i class="bi bi-heart-fill me-2"></i> Berikan Infaq Sekarang
            </button>
        </div>
    </div>
</section>

<div class="container py-5">

    {{-- 🕌 Profil Masjid --}}
    <section class="text-center mb-5 fade-in-up">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="profile-img-wrapper mb-4">
                    <img src="{{ $profile && $profile->foto_logo ? asset('storage/'.$profile->foto_logo) : asset('images/default-masjid.png') }}"
                         alt="Logo Masjid"
                         class="profile-img">
                </div>

                <h2 class="section-title">
                    <span>{{ $profile->nama ?? 'Masjid Kami' }}</span>
                </h2>

                @if($profile && ($profile->alamat || $profile->desa_kecamatan))
                    <div class="mb-3">
                        <p class="text-muted mb-1">
                            <i class="bi bi-geo-alt-fill text-success me-2"></i>
                            {{ $profile->alamat }}
                        </p>
                        @if($profile->desa_kecamatan)
                            <small class="fw-semibold text-success">{{ $profile->desa_kecamatan }}</small>
                        @endif
                    </div>
                @else
                    <p class="text-muted">
                        <i class="bi bi-geo-alt text-muted me-2"></i>Alamat belum diatur
                    </p>
                @endif

                @if($profile && $profile->deskripsi)
                    <p class="lead text-dark">{{ $profile->deskripsi }}</p>
                @else
                    <p class="text-secondary">Belum ada deskripsi masjid.</p>
                @endif
            </div>
        </div>
    </section>

    {{-- 📅 Jadwal Sholat --}}
    <section class="mb-5 fade-in-up">
        <div class="section-title">
            <h2>Jadwal Sholat Hari Ini</h2>
        </div>

        @if($jadwal)
            <div class="row g-3">
                @foreach ([
                    ['name' => 'Imsak', 'time' => $jadwal['imsak'] ?? '-', 'icon' => 'bi-sun'],
                    ['name' => 'Subuh', 'time' => $jadwal['subuh'] ?? '-', 'icon' => 'bi-sunrise'],
                    ['name' => 'Dzuhur', 'time' => $jadwal['dzuhur'] ?? '-', 'icon' => 'bi-sun'],
                    ['name' => 'Ashar', 'time' => $jadwal['ashar'] ?? '-', 'icon' => 'bi-sunset'],
                    ['name' => 'Maghrib', 'time' => $jadwal['maghrib'] ?? '-', 'icon' => 'bi-moon'],
                    ['name' => 'Isya', 'time' => $jadwal['isya'] ?? '-', 'icon' => 'bi-moon-stars']
                ] as $prayer)
                    <div class="col-md-4 col-lg-2">
                        <div class="prayer-card">
                            <i class="bi {{ $prayer['icon'] }} display-6 mb-3"></i>
                            <h6 class="fw-bold mb-2">{{ $prayer['name'] }}</h6>
                            <p class="mb-0 h5 fw-bold">{{ $prayer['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning text-center">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Tidak dapat memuat jadwal sholat saat ini.
            </div>
        @endif
    </section>

    {{-- 📰 Artikel Terbaru --}}
    <section class="mb-5 fade-in-up">
        <div class="section-title">
            <h2>Artikel Terbaru</h2>
        </div>

        <div class="row g-4">
            @forelse($artikels as $artikel)
                <div class="col-lg-4 col-md-6">
                    <div class="card article-card shadow-sm">
                        <div class="position-relative">
                            @if($artikel->foto_cover)
                                <img src="{{ asset('storage/'.$artikel->foto_cover) }}"
                                     alt="{{ $artikel->judul }}"
                                     class="card-img-top article-image">
                            @else
                                <img src="{{ asset('images/default-article.jpg') }}"
                                     alt="Default Artikel"
                                     class="card-img-top article-image">
                            @endif
                            <span class="article-badge">
                                <i class="bi bi-clock me-1"></i>{{ $artikel->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-success mb-3">
                                {{ Str::limit($artikel->judul, 50) }}
                            </h5>
                            <p class="card-text text-muted mb-3">
                                {{ Str::limit(strip_tags($artikel->konten), 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-eye me-1"></i>{{ $artikel->views ?? 0 }} views
                                </small>
                                <a href="{{ route('artikel.show', $artikel->slug) }}"
                                   class="btn btn-outline-success btn-sm">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada artikel yang tersedia.
                    </div>
                </div>
            @endforelse
        </div>

        @if($artikels->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ url('/artikel') }}" class="btn btn-green">
                    <i class="bi bi-journal-text me-2"></i>Lihat Semua Artikel
                </a>
            </div>
        @endif
    </section>

    {{-- 💰 Infaq dan Pengeluaran --}}
    <section class="mb-5 fade-in-up">
        <div class="row">
            {{-- Infaq Terbaru --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-cash-coin me-2"></i>Infaq Terbaru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($infaqs as $infaq)
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-circle p-2 me-3">
                                            <i class="bi bi-person-fill text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $infaq->nama_donatur ?? 'Anonim' }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>
                                                {{ $infaq->created_at->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div>
                                    <span class="badge bg-success rounded-pill fs-6">
                                        Rp {{ number_format($infaq->nominal, 0, ',', '.') }}
                                    </span>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                    Belum ada infaq
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pengeluaran Terbaru --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-wallet2 me-2"></i>Pengeluaran Terbaru
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($pengeluarans as $p)
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info rounded-circle p-2 me-3">
                                            <i class="bi bi-receipt text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $p->deskripsi }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>{{ $p->tanggal }}
                                            </small>
                                        </div>
                                    </div>
                                    <span class="badge bg-danger rounded-pill fs-6">
                                        - Rp {{ number_format($p->nominal, 0, ',', '.') }}
                                    </span>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                    Belum ada pengeluaran
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 👤 Pengurus Masjid --}}
    <section class="mb-5 fade-in-up">
        <div class="section-title">
            <h2>Pengurus Masjid</h2>
        </div>

        <div class="row justify-content-center g-4">
            @forelse($penguruses as $p)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm text-center hover-card h-100">
                        <div class="card-body">
                            <div class="profile-img-wrapper mx-auto mb-3">
                                <img src="{{ $p->foto ? asset('storage/'.$p->foto) : asset('images/default-user.png') }}"
                                     alt="{{ $p->nama }}"
                                     class="profile-img">
                            </div>
                            <h6 class="fw-bold text-dark mb-2">{{ $p->nama }}</h6>
                            <p class="text-success fw-semibold mb-3">{{ $p->jabatan }}</p>

                            @if($p->no_hp || $p->email)
                                <div class="contact-info">
                                    @if($p->no_hp)
                                        <small class="d-block text-muted mb-1">
                                            <i class="bi bi-telephone-fill text-success me-2"></i>
                                            {{ $p->no_hp }}
                                        </small>
                                    @endif
                                    @if($p->email)
                                        <small class="d-block text-muted">
                                            <i class="bi bi-envelope-fill text-success me-2"></i>
                                            {{ $p->email }}
                                        </small>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada data pengurus.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    {{-- 🏆 Penghargaan & Prestasi --}}
    <section class="mb-5 fade-in-up">
        <div class="section-title">
            <h2>Penghargaan & Prestasi</h2>
        </div>

        <div class="row g-4">
            @forelse($penghargaans as $p)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100 hover-card">
                        @if($p->foto)
                            <img src="{{ asset('storage/'.$p->foto) }}"
                                 alt="{{ $p->name }}"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-success mb-3">{{ $p->name }}</h6>
                            <p class="text-muted small">
                                {{ Str::limit($p->deskripsi ?? 'Tidak ada deskripsi', 120) }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada data penghargaan.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    {{-- 📸 Galeri Kegiatan --}}
    <section class="mb-5 fade-in-up">
        <div class="section-title">
            <h2>Galeri Kegiatan</h2>
        </div>

        <div class="row g-4">
            @forelse($galeris as $g)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm hover-card">
                        @if($g->foto)
                            <img src="{{ asset('storage/'.$g->foto) }}"
                                 alt="{{ $g->judul ?? 'Galeri' }}"
                                 class="card-img-top"
                                 style="height: 250px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/no-image.jpg') }}"
                                 alt="No Image"
                                 class="card-img-top"
                                 style="height: 250px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h6 class="fw-bold text-success mb-2">{{ $g->judul ?? 'Kegiatan Masjid' }}</h6>
                            <p class="text-muted small">
                                {{ Str::limit($g->deskripsi ?? 'Tidak ada deskripsi', 100) }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada foto galeri kegiatan.
                    </div>
                </div>
            @endforelse
        </div>
    </section>

</div>

{{-- 💚 Modal Infaq --}}
<div class="modal fade" id="infaqModal" tabindex="-1" aria-labelledby="infaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="infaqModalLabel">
                    <i class="bi bi-heart-fill me-2"></i>Infaq Online
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center mb-4 mb-md-0">
                        @if($rekening && $rekening->qris_code)
                            <img src="{{ asset('storage/'.$rekening->qris_code) }}"
                                 alt="QRIS Masjid"
                                 class="img-fluid rounded shadow-sm mb-3"
                                 style="max-width: 250px;">
                        @else
                            <img src="{{ asset('images/qris.png') }}"
                                 alt="QRIS Masjid"
                                 class="img-fluid rounded shadow-sm mb-3"
                                 style="max-width: 250px;">
                        @endif

                        @if($rekening)
                            <div class="bg-light rounded p-3">
                                <h6 class="fw-bold text-success mb-2">{{ $rekening->nama_bank }}</h6>
                                <p class="mb-1">
                                    <strong>No. Rek:</strong> {{ $rekening->nomor_rekening }}
                                </p>
                                <p class="mb-0">
                                    <strong>a.n:</strong> {{ $rekening->atas_nama }}
                                </p>
                            </div>
                        @else
                            <p class="text-muted">Rekening belum diatur.</p>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <form action="{{ url('infaq.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="metode" value="online">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Donatur</label>
                                <input type="text" name="nama_donatur" class="form-control"
                                       placeholder="Masukkan nama Anda" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nominal Infaq (Rp)</label>
                                <input type="number" name="nominal" class="form-control"
                                       placeholder="Contoh: 50000" min="1000" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Bukti Transfer</label>
                                <input type="file" name="bukti_transfer" class="form-control"
                                       accept="image/*" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Catatan (Opsional)</label>
                                <textarea name="catatan" class="form-control" rows="3"
                                          placeholder="Tuliskan catatan atau doa..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-2">
                                <i class="bi bi-send-fill me-2"></i>Kirim Infaq
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add fade-in animation to sections
        const sections = document.querySelectorAll('.fade-in-up');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        sections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endpush
