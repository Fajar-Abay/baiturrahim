@extends('layouts.app')

@section('title', $pageTitle)

@push('styles')
<style>
    .search-header {
        background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
        color: white;
        padding: 2rem 0;
        border-radius: 0 0 20px 20px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .search-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .search-results-count {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .verse-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .verse-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .verse-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #eee;
    }

    .verse-number {
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
    }

    .verse-body {
        padding: 2rem 1.5rem;
    }

    .verse-arabic {
        font-size: 2rem;
        line-height: 1.8;
        text-align: right;
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: #1b1b1b;
        font-family: 'Traditional Arabic', 'KFGQPC Uthman Taha Naskh', 'Scheherazade', serif;
    }

    .verse-translation {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #333;
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 12px;
        border-left: 4px solid #4caf50;
    }

    .book-badge {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .highlight {
        background-color: #fff3cd;
        padding: 0.1rem 0.3rem;
        border-radius: 3px;
        font-weight: 600;
    }

    .no-results {
        text-align: center;
        padding: 4rem 2rem;
    }

    .search-box {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .search-title {
            font-size: 1.5rem;
        }

        .verse-arabic {
            font-size: 1.6rem;
        }

        .verse-body {
            padding: 1.5rem 1rem;
        }
    }
</style>
@endpush

@section('content')

<!-- Search Header -->
<section class="search-header">
    <div class="container">
        <h1 class="search-title">Pencarian Hadits</h1>
        @if(isset($query) && $query)
            <p class="search-results-count">
                Hasil pencarian untuk: "<strong>{{ $query }}</strong>"
            </p>
        @endif
    </div>
</section>

@php
    function highlightText($text, $query) {
        if (empty($text) || empty($query)) return $text;
        $pattern = '/(' . preg_quote($query, '/') . ')/i';
        return preg_replace($pattern, '<span class="highlight">$1</span>', $text);
    }
@endphp

<div class="container">
    <!-- Search Form -->
    <div class="search-box">
        <form action="{{ route('hadith.search') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="q" class="form-control form-control-lg"
                           value="{{ $query ?? '' }}"
                           placeholder="Masukkan kata kunci pencarian..."
                           required>
                </div>
                <div class="col-md-4">
                    <select name="book" class="form-control form-control-lg">
                        <option value="">Semua Kitab</option>
                        @if(isset($books['data']) && is_array($books['data']))
                            @foreach($books['data'] as $bookItem)
                                <option value="{{ $bookItem['id'] }}"
                                    {{ ($book ?? '') == $bookItem['id'] ? 'selected' : '' }}>
                                    {{ $bookItem['name'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Popular Searches -->
    @if(!isset($results) || !$query)
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-fire text-success me-2"></i>Pencarian Populer</h5>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                @foreach($popularSearches as $popular)
                    <a href="{{ route('hadith.search', ['q' => $popular]) }}"
                       class="btn btn-outline-success btn-sm">
                        {{ $popular }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Search Results -->
    @if(isset($results) && $query)
        @if(isset($results['data']['hadiths']) && count($results['data']['hadiths']) > 0)
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                Ditemukan <strong>{{ $results['data']['total'] }}</strong> hasil untuk
                "<strong>{{ $query }}</strong>"
                @if($book)
                    @php
                        $bookName = collect($books['data'] ?? [])->firstWhere('id', $book)['name'] ?? $book;
                    @endphp
                    dalam kitab <strong>{{ $bookName }}</strong>
                @endif
            </div>

            @foreach($results['data']['hadiths'] as $hadith)
                <div class="verse-card">
                    <div class="verse-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="verse-number">{{ $hadith['number'] ?? 'N/A' }}</div>
                            <div class="d-flex align-items-center gap-3">
                                @if(isset($hadith['book_name']))
                                    <span class="book-badge">
                                        <i class="fas fa-book me-1"></i>{{ $hadith['book_name'] }}
                                    </span>
                                @endif
                                <small class="text-muted">Hadits No. {{ $hadith['number'] ?? 'N/A' }}</small>
                                @if(isset($hadith['number']) && isset($hadith['book_id']))
                                    <a href="{{ route('hadith.detail', [$hadith['book_id'], $hadith['number']]) }}"
                                       class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-external-link-alt"></i> Detail
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="verse-body">
                        <!-- Teks Arab -->
                        <div class="verse-arabic" dir="rtl">
                            {{ $hadith['arab'] ?? 'Teks arab tidak tersedia' }}
                        </div>

                        <!-- Terjemahan dengan highlight -->
                        <div class="verse-translation">
                            <strong><i class="fas fa-language text-success me-2"></i>Terjemahan:</strong><br>
                            @if(isset($hadith['id']))
                               {!! highlightText($hadith['id'], $query) !!}
                            @else
                                Terjemahan tidak tersedia
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        @else
            <div class="no-results">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h3 class="text-muted">Tidak ditemukan hasil</h3>
                <p class="text-muted mb-4">Tidak ada hadits yang mengandung "<strong>{{ $query }}</strong>"</p>

                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <a href="{{ route('hadith.search') }}" class="btn btn-success">
                        <i class="fas fa-redo me-1"></i> Cari Lagi
                    </a>
                    <a href="{{ route('hadith.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-book me-1"></i> Lihat Semua Kitab
                    </a>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection

@push('scripts')
<script>
// Highlight search terms in translation
function highlightText(text, query) {
    if (!text || !query) return text;

    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<span class="highlight">$1</span>');
}

// Apply highlighting on page load
document.addEventListener('DOMContentLoaded', function() {
    const query = "{{ $query ?? '' }}";
    if (query) {
        const translationElements = document.querySelectorAll('.verse-translation');
        translationElements.forEach(element => {
            const text = element.textContent;
            const highlighted = highlightText(text, query);
            element.innerHTML = element.innerHTML.replace(text, highlighted);
        });
    }
});
</script>
@endpush
