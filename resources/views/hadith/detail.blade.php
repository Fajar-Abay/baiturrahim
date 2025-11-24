@extends('layouts.app')

@section('title', $bookInfo['name'] . ' - Hadits No. ' . $hadithData['number'])

@push('styles')
<style>
    .surah-header {
        background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
        color: white;
        padding: 2rem 0;
        border-radius: 0 0 15px 15px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .surah-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .surah-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .verse-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        border: none;
        overflow: hidden;
    }

    .verse-header {
        background: #f8f9fa;
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
    }

    .verse-number {
        width: 40px;
        height: 40px;
        background: #4caf50;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1rem;
    }

    .verse-body {
        padding: 1.5rem;
    }

    .verse-arabic {
        font-size: 1.8rem;
        line-height: 1.8;
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: 500;
        font-family: 'Traditional Arabic', serif;
        direction: rtl;
    }

    .verse-translation {
        line-height: 1.6;
        color: #333;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 3px solid #4caf50;
    }

    .navigation-buttons {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin: 1rem 0;
    }

    @media (max-width: 768px) {
        .surah-header {
            padding: 1.5rem 0;
        }

        .surah-title {
            font-size: 1.5rem;
        }

        .verse-arabic {
            font-size: 1.4rem;
        }

        .verse-body {
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')

<!-- Header -->
<section class="surah-header">
    <div class="container">
        <h1 class="surah-title">{{ $bookInfo['name'] }}</h1>
        <p class="surah-subtitle">Hadits No. {{ $hadithData['number'] }}</p>
    </div>
</section>

<div class="container">
    <!-- Navigasi -->
    <div class="navigation-buttons">
        <div class="row g-2">
            <div class="col-6">
                @if($hadithData['number'] > 1)
                    <a href="{{ route('hadith.detail', [$bookInfo['id'], $hadithData['number'] - 1]) }}"
                       class="btn btn-outline-success w-100 btn-sm">
                        ← Sebelumnya
                    </a>
                @endif
            </div>
            <div class="col-6">
                @if($hadithData['number'] < $bookInfo['available'])
                    <a href="{{ route('hadith.detail', [$bookInfo['id'], $hadithData['number'] + 1]) }}"
                       class="btn btn-outline-success w-100 btn-sm">
                        Selanjutnya →
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Kartu Hadits -->
    <div class="verse-card">
        <div class="verse-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="verse-number">{{ $hadithData['number'] }}</div>
                <small class="text-muted">Hadits No. {{ $hadithData['number'] }}</small>
            </div>
        </div>

        <div class="verse-body">
            <!-- Teks Arab -->
            <div class="verse-arabic" dir="rtl">
                {{ $hadithData['arab'] }}
            </div>

            <!-- Terjemahan -->
            <div class="verse-translation">
                <strong>Terjemahan:</strong><br>
                {{ $hadithData['id'] }}
            </div>
        </div>
    </div>

    <!-- Navigasi Bawah -->
    <div class="navigation-buttons">
        <div class="row g-2">
            <div class="col-6">
                @if($hadithData['number'] > 1)
                    <a href="{{ route('hadith.detail', [$bookInfo['id'], $hadithData['number'] - 1]) }}"
                       class="btn btn-outline-success w-100 btn-sm">
                        ← Sebelumnya
                    </a>
                @endif
            </div>
            <div class="col-6">
                @if($hadithData['number'] < $bookInfo['available'])
                    <a href="{{ route('hadith.detail', [$bookInfo['id'], $hadithData['number'] + 1]) }}"
                       class="btn btn-outline-success w-100 btn-sm">
                        Selanjutnya →
                    </a>
                @endif
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('hadith.show', $bookInfo['id']) }}" class="btn btn-success btn-sm me-2">
                Semua Hadits
            </a>
            <a href="{{ route('hadith.index') }}" class="btn btn-outline-success btn-sm">
                Semua Kitab
            </a>
        </div>
    </div>
</div>
@endsection
