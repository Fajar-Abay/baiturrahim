@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-4">Dashboard</h1>

    {{-- Statistik Kecil --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6>Total Infaq</h6>
                    <h4 class="text-success fw-bold">Rp {{ number_format($totalInfaq, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6>Total Pengeluaran</h6>
                    <h4 class="text-danger fw-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6>Saldo</h6>
                    <h4 class="text-primary fw-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6>Artikel</h6>
                    <h4 class="text-warning fw-bold">{{ $jumlahArtikel }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- CHART SECTION --}}
    <div class="row g-4">
        {{-- Pie Chart --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="text-center text-success fw-bold mb-3">Status Infaq</h5>
                    <canvas id="statusChart" height="250"></canvas>
                </div>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="text-center text-success fw-bold mb-3">Infaq & Pengeluaran Bulanan</h5>
                    <canvas id="bulananChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const statusChart = new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($infaqStatus->keys()) !!},
        datasets: [{
            data: {!! json_encode($infaqStatus->values()->map(fn($v)=>(float)$v)) !!},
            backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d'],
        }]
    },
    options: {
        plugins: { legend: { position: 'bottom' } }
    }
});

const bulananChart = new Chart(document.getElementById('bulananChart'), {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [
            {
                label: 'Infaq',
                data: {!! json_encode(array_values($infaqBulanan)) !!},
                backgroundColor: '#28a745',
            },
            {
                label: 'Pengeluaran',
                data: {!! json_encode(array_values($pengeluaranBulanan)) !!},
                backgroundColor: '#dc3545',
            }
        ]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } },
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>
@endpush
