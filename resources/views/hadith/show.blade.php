@extends('layouts.app')

@section('title', $bookInfo['name'])

@push('styles')
<style>
    .surah-header {
        background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
        color: white;
        padding: 3rem 0;
        border-radius: 0 0 20px 20px;
        margin-bottom: 3rem;
        text-align: center;
    }

    .surah-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .surah-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .surah-meta {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .meta-item {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        backdrop-filter: blur(10px);
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
        font-size: 2.2rem;
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

    .navigation-buttons {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin: 2rem 0;
    }

    .range-navigation {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .range-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: center;
    }

    .range-btn {
        padding: 0.5rem 1rem;
        border: 2px solid #4caf50;
        border-radius: 25px;
        background: white;
        color: #2e7d32;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .range-btn:hover {
        background: #4caf50;
        color: white;
        transform: translateY(-2px);
    }

    .search-box {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .surah-header {
            padding: 2rem 0;
        }

        .surah-title {
            font-size: 2rem;
        }

        .verse-arabic {
            font-size: 1.8rem;
        }

        .verse-body {
            padding: 1.5rem 1rem;
        }

        .surah-meta {
            gap: 1rem;
        }

        .meta-item {
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
        }

        .range-buttons {
            gap: 0.3rem;
        }

        .range-btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        .verse-arabic {
            font-size: 1.6rem;
        }
    }
</style>
@endpush

@section('content')

<!-- Header Kitab Hadits -->
<section class="surah-header">
    <div class="container">
        <h1 class="surah-title">{{ $bookInfo['name'] }}</h1>
        <p class="surah-subtitle">Kitab Hadits</p>

        <div class="surah-meta">
            <div class="meta-item">
                <i class="fas fa-hashtag me-1"></i> {{ $bookInfo['available'] }} Hadits
            </div>
            <div class="meta-item">
                <i class="fas fa-book me-1"></i> {{ $bookInfo['id'] }}
            </div>
            @if($bookInfo['requested_range'])
            <div class="meta-item">
                <i class="fas fa-eye me-1"></i> {{ $bookInfo['requested_range'] }}
            </div>
            @endif
        </div>
    </div>
</section>

<div class="container">
    <!-- Pencarian dalam Kitab -->
    <div class="search-box">
        <form action="{{ route('hadith.search') }}" method="GET">
            <input type="hidden" name="book" value="{{ $bookInfo['id'] }}">
            <div class="input-group input-group-lg">
                <input type="text" name="q" class="form-control"
                       placeholder="Cari hadits dalam {{ $bookInfo['name'] }}..."
                       required>
                <button class="btn btn-success" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Navigasi Range -->
    <div class="range-navigation">
        <h6 class="text-center mb-3 text-muted">
            <i class="fas fa-navicon me-2"></i>Navigasi Hadits
        </h6>
        <div class="range-buttons">
            @for($i = 1; $i <= min($bookInfo['available'], 1000); $i += 50)
                @if($i + 49 <= $bookInfo['available'])
                    <a href="{{ route('hadith.show', ['book' => $bookInfo['id'], 'range' => $i . '-' . ($i + 49)]) }}"
                       class="range-btn">
                        {{ $i }}-{{ $i + 49 }}
                    </a>
                @else
                    <a href="{{ route('hadith.show', ['book' => $bookInfo['id'], 'range' => $i . '-' . $bookInfo['available']]) }}"
                       class="range-btn">
                        {{ $i }}-{{ $bookInfo['available'] }}
                    </a>
                @endif
            @endfor
        </div>
        <div class="text-center mt-3">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>Maksimal 300 hadits per request
            </small>
        </div>
    </div>

    <!-- Tombol Navigasi Jumlah -->
    <div class="navigation-buttons">
        <div class="text-center">
            <h6 class="text-muted mb-3">Tampilkan Lebih Banyak Hadits</h6>
            <div class="btn-group" role="group">
                <a href="{{ route('hadith.show', ['book' => $bookInfo['id'], 'perpage' => 100]) }}"
                   class="btn btn-outline-success">100 Hadits</a>
                <a href="{{ route('hadith.show', ['book' => $bookInfo['id'], 'perpage' => 200]) }}"
                   class="btn btn-outline-success">200 Hadits</a>
                <a href="{{ route('hadith.show', ['book' => $bookInfo['id'], 'perpage' => 300]) }}"
                   class="btn btn-outline-success">300 Hadits</a>
            </div>
        </div>
    </div>

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Daftar Hadits -->
    @if(isset($result['data']['hadiths']) && count($result['data']['hadiths']) > 0)
        <div class="alert alert-success text-center">
            <i class="fas fa-info-circle"></i>
            Menampilkan {{ count($result['data']['hadiths']) }} hadits
            @if($bookInfo['requested_range'])
                dari range {{ $bookInfo['requested_range'] }}
            @endif
        </div>

        @foreach($result['data']['hadiths'] as $hadith)
            <div class="verse-card" style="animation: fadeIn 0.5s ease;">
                <div class="verse-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="verse-number">{{ $hadith['number'] ?? 'N/A' }}</div>
                        <div>
                            <small class="text-muted me-2">Hadits No. {{ $hadith['number'] ?? 'N/A' }}</small>
                            @if(isset($hadith['number']) && isset($bookInfo['id']))
                                <a href="{{ route('hadith.detail', [$bookInfo['id'], $hadith['number']]) }}"
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

                    <!-- Terjemahan -->
                    <div class="verse-translation">
                        <strong><i class="fas fa-language text-success me-2"></i>Terjemahan:</strong><br>
                        {{ $hadith['id'] ?? 'Terjemahan tidak tersedia' }}
                    </div>
                </div>
            </div>
        @endforeach

    @else
        <div class="alert alert-warning text-center py-5">
            <i class="fas fa-exclamation-triangle fa-3x mb-3 text-warning"></i>
            <h4 class="text-warning">Tidak ada hadits ditemukan</h4>
            <p class="text-muted">Silakan pilih range atau jumlah hadits yang berbeda.</p>
            <a href="{{ route('hadith.show', $bookInfo['id']) }}" class="btn btn-success mt-2">
                <i class="fas fa-redo me-1"></i> Tampilkan Hadits Pertama
            </a>
        </div>
    @endif

    <!-- Tombol Navigasi Kembali -->
    <div class="navigation-buttons">
        <div class="text-center">
            <a href="{{ route('hadith.index') }}" class="btn btn-success btn-lg">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Kitab
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animasi untuk kartu hadits
    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.verse-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });

        // Loading state untuk tombol
        document.querySelectorAll('a.btn, .range-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                this.classList.add('disabled');

                // Reset setelah 3 detik (fallback)
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('disabled');
                }, 3000);
            });
        });
    });
</script>
@endpush
