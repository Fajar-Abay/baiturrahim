@extends('layouts.app')

@section('title', 'Kitab Hadits')

@push('styles')
<style>
    .hadith-hero {
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

    .book-card {
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

    .book-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #2e7d32, #4caf50);
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .book-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #2e7d32, #4caf50);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 1rem;
    }

    .book-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1b1b1b;
        margin-bottom: 0.5rem;
    }

    .book-id {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .book-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.85rem;
        color: #888;
    }

    .book-hadith-count {
        background: #e8f5e9;
        color: #2e7d32;
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
        .hadith-hero {
            padding: 40px 0 30px;
        }

        .book-card {
            padding: 1rem;
        }

        .book-name {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hadith-hero">
    <div class="container">
        <div class="text-center text-white">
            <h1 class="display-5 fw-bold mb-3">📚 Kitab Hadits</h1>
            <p class="lead mb-4">Kumpulan kitab hadits shahih dengan terjemahan Bahasa Indonesia</p>

            <!-- Search Form -->
            <div class="search-container">
                <form action="{{ route('hadith.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text"
                               name="q"
                               class="form-control search-input"
                               placeholder="Cari hadits (contoh: shalat, zakat, puasa...)"
                               value="{{ request('q') }}"
                               style="border-right: none;">
                        <button class="btn btn-light" type="submit" style="border-radius: 0 50px 50px 0; border-left: none;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="container">
    @if(request('q'))
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-success fw-bold">
                Hasil pencarian untuk "{{ request('q') }}"
            </h4>
            <a href="{{ route('hadith.index') }}" class="btn btn-outline-success btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Semua Kitab
            </a>
        </div>
    @else
        <div class="text-center mb-5">
            <h3 class="text-success fw-bold">Daftar Kitab Hadits</h3>
            <p class="text-muted">Klik salah satu kitab untuk membaca hadits-haditsnya</p>
        </div>
    @endif

    <div class="row">
        @if(isset($books['data']) && is_array($books['data']) && count($books['data']) > 0)
            @foreach($books['data'] as $book)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <a href="{{ route('hadith.show', $book['id'] ?? '') }}" class="text-decoration-none">
                        <div class="book-card">
                            <div class="d-flex align-items-start">
                                <div class="book-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="book-name">{{ $book['name'] ?? 'Unknown Book' }}</div>
                                    <div class="book-id">{{ $book['id'] ?? '' }}</div>
                                    <div class="book-meta">
                                        <span class="book-hadith-count">{{ $book['available'] ?? 0 }} hadits</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-book"></i>
                    <h4 class="text-muted">Kitab hadits tidak tersedia</h4>
                    <p class="text-muted">Silakan refresh halaman atau coba beberapa saat lagi</p>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
