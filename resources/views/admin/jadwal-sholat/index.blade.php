@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Jadwal Sholat Hari Ini</h4>

    @if(!$jadwal)
        <div class="alert alert-warning">
            Gagal memuat jadwal sholat. Pastikan koneksi internet aktif dan koordinat masjid sudah diset.
        </div>
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3 text-center">{{ $profile->nama ?? 'Masjid Anda' }}</h5>
                <p class="text-center text-muted">Tanggal: {{ $jadwal['tanggal'] ?? now()->format('d-m-Y') }}</p>

                <div class="row justify-content-center">
                    @foreach (['Imsak', 'Subuh', 'Dzuhur', 'Ashar', 'Maghrib', 'Isya'] as $sholat)
                        <div class="col-md-2 col-6 mb-3">
                            <div class="card text-center border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-uppercase">{{ $sholat }}</h6>
                                    <p class="fw-bold text-success">{{ $jadwal[strtolower($sholat)] ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
