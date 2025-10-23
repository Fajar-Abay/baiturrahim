@extends('layouts.app')

@section('title', 'Al-Qur\'an')

@push('styles')
<style>
    .quran-hero {
        background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
        color: white;
        padding: 60px 0 40px;
        border-radius: 0 0 20px 20px;
        margin-bottom: 3rem;
    }

    .search-container {
        max-width: 500px;
        margin: 0 auto 2rem;
    }

    .search-input {
        border-radius: 50px;
        border: 2px solid #e8f5e9;
        padding: 12px 20px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
    }

    .surah-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        border: none;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .surah-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #2e7d32, #4caf50);
    }

    .surah-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .surah-number {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #2e7d32, #4caf50);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.9rem;
        margin-right: 1rem;
    }

    .surah-name-arabic {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2e7d32;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .surah-name-latin {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1b1b1b;
        margin-bottom: 0.25rem;
    }

    .surah-meaning {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .surah-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.85rem;
        color: #888;
    }

    .surah-verse-count {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .surah-revelation {
        background: #e3f2fd;
        color: #1976d2;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #666;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #ccc;
    }

    @media (max-width: 768px) {
        .quran-hero {
            padding: 40px 0 30px;
        }

        .surah-card {
            padding: 1rem;
        }

        .surah-name-arabic {
            font-size: 1.3rem;
        }

        .surah-name-latin {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="quran-hero">
    <div class="container">
        <div class="text-center text-white">
            <h1 class="display-5 fw-bold mb-3">📖 Al-Qur'an Digital</h1>
            <p class="lead mb-4">Baca dan pelajari Al-Qur'an dengan mudah dan nyaman</p>

            <!-- Search Form -->
            <div class="search-container">
                <form action="{{ route('alquran.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text"
                               name="search"
                               class="form-control search-input"
                               placeholder="Cari surat (contoh: Al-Fatihah, Ar-Rahman...)"
                               value="{{ request('search') }}"
                               style="border-right: none;">
                        <button class="btn btn-light" type="submit" style="border-radius: 0 50px 50px 0; border-left: none;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="container">
    @if(request('search'))
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-success fw-bold">
                Hasil pencarian untuk "{{ request('search') }}"
            </h4>
            <a href="{{ route('alquran.index') }}" class="btn btn-outline-success btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Semua Surat
            </a>
        </div>
    @else
        <div class="text-center mb-5">
            <h3 class="text-success fw-bold">Daftar Surat Al-Qur'an</h3>
            <p class="text-muted">Klik salah satu surat untuk membaca ayat-ayatnya</p>
        </div>
    @endif

    <div class="row">
        @forelse($surat as $s)
            <div class="col-lg-6 col-xl-4 mb-4">
                <a href="{{ route('alquran.show', $s['nomor']) }}" class="text-decoration-none">
                    <div class="surah-card">
                        <div class="d-flex align-items-start">
                            <div class="surah-number">{{ $s['nomor'] }}</div>
                            <div class="flex-grow-1">
                                <div class="surah-name-arabic" dir="rtl">{{ $s['nama'] }}</div>
                                <div class="surah-name-latin">{{ $s['namaLatin'] }}</div>
                                <div class="surah-meaning">{{ $s['arti'] }}</div>
                                <div class="surah-meta">
                                    <span class="surah-verse-count">{{ $s['jumlahAyat'] }} ayat</span>
                                    <span class="surah-revelation">{{ $s['tempatTurun'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="bi bi-search"></i>
                    <h4 class="text-muted">Surat tidak ditemukan</h4>
                    <p class="text-muted">Coba gunakan kata kunci lain atau <a href="{{ route('alquran.index') }}">lihat semua surat</a></p>
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection
