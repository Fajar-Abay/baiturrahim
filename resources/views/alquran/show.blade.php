@extends('layouts.app')

@section('title', $data['namaLatin'])

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
        font-size: 2.5rem;
        line-height: 1.8;
        text-align: right;
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: #1b1b1b;
    }

    .verse-latin {
        font-size: 1.1rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-style: italic;
        border-left: 3px solid #4caf50;
        padding-left: 1rem;
    }

    .verse-translation {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #333;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .tafsir-section {
        background: #e8f5e9;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        animation: fadeIn 0.5s ease;
    }

    .tafsir-title {
        color: #2e7d32;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tafsir-content {
        color: #333;
        line-height: 1.7;
        text-align: justify;
    }

    .navigation-buttons {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin: 2rem 0;
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
            font-size: 2rem;
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
    }

    @media (max-width: 480px) {
        .verse-arabic {
            font-size: 1.8rem;
        }
    }
</style>
@endpush

@section('content')

<!-- Header Surat -->
<section class="surah-header">
    <div class="container">
        <h1 class="surah-title">{{ $data['namaLatin'] }}</h1>
        <p class="surah-subtitle">{{ $data['arti'] }}</p>

        <div class="surah-meta">
            <div class="meta-item">
                <i class="bi bi-journal-text me-1"></i> {{ $data['jumlahAyat'] }} Ayat
            </div>
            <div class="meta-item">
                <i class="bi bi-geo-alt me-1"></i> {{ $data['tempatTurun'] }}
            </div>
            <div class="meta-item">
                <i class="bi bi-sort-numeric-up me-1"></i> Surat ke-{{ $data['nomor'] }}
            </div>
        </div>
    </div>
</section>

<div class="container">
    <!-- Tombol Navigasi Atas -->
    <div class="navigation-buttons">
        <div class="row">
            <div class="col-6">
                @if($data['nomor'] > 1)
                    <a href="{{ route('alquran.show', $data['nomor'] - 1) }}" class="btn btn-outline-success w-100">
                        <i class="bi bi-chevron-left me-1"></i> Surat Sebelumnya
                    </a>
                @endif
            </div>
            <div class="col-6">
                @if($data['nomor'] < 114)
                    <a href="{{ route('alquran.show', $data['nomor'] + 1) }}" class="btn btn-outline-success w-100">
                        Surat Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Daftar Ayat -->
    @foreach($data['ayat'] as $ayat)
        <div class="verse-card">
            <div class="verse-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="verse-number">{{ $ayat['nomorAyat'] }}</div>
                    <small class="text-muted">Ayat {{ $ayat['nomorAyat'] }}</small>
                </div>
            </div>

            <div class="verse-body">
                <div class="verse-arabic" dir="rtl">{{ $ayat['teksArab'] }}</div>
                <div class="verse-latin">{{ $ayat['teksLatin'] }}</div>

                <div class="verse-translation">
                    <strong>Terjemahan:</strong><br>
                    {{ $ayat['teksIndonesia'] }}
                </div>

                @if(isset($tafsir[$ayat['nomorAyat']]))
                    <div class="text-center mt-3">
                        <button class="btn btn-sm btn-outline-success"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#tafsir{{ $ayat['nomorAyat'] }}"
                                aria-expanded="false"
                                aria-controls="tafsir{{ $ayat['nomorAyat'] }}">
                            <i class="bi bi-book"></i> Tampilkan Tafsir
                        </button>
                    </div>

                    <div class="collapse mt-3" id="tafsir{{ $ayat['nomorAyat'] }}">
                        <div class="tafsir-section">
                            <div class="tafsir-title">
                                <i class="bi bi-lightbulb"></i> Tafsir Ayat {{ $ayat['nomorAyat'] }}
                            </div>
                            <div class="tafsir-content">
                                {{ $tafsir[$ayat['nomorAyat']]['teks'] }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <!-- Tombol Navigasi Bawah -->
    <div class="navigation-buttons">
        <div class="row">
            <div class="col-6">
                @if($data['nomor'] > 1)
                    <a href="{{ route('alquran.show', $data['nomor'] - 1) }}" class="btn btn-outline-success w-100">
                        <i class="bi bi-chevron-left me-1"></i> Surat Sebelumnya
                    </a>
                @endif
            </div>
            <div class="col-6">
                @if($data['nomor'] < 114)
                    <a href="{{ route('alquran.show', $data['nomor'] + 1) }}" class="btn btn-outline-success w-100">
                        Surat Selanjutnya <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('alquran.index') }}" class="btn btn-success">
                <i class="bi bi-list-ul me-1"></i> Daftar Semua Surat
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Ubah teks tombol ketika tafsir dibuka/tutup
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(btn => {
            const target = document.querySelector(btn.dataset.bsTarget);

            target.addEventListener('shown.bs.collapse', () => {
                btn.innerHTML = '<i class="bi bi-book"></i> Sembunyikan Tafsir';
            });
            target.addEventListener('hidden.bs.collapse', () => {
                btn.innerHTML = '<i class="bi bi-book"></i> Tampilkan Tafsir';
            });
        });
    });
</script>
@endpush
