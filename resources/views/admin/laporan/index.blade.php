@extends('layouts.admin')

@section('title', 'Laporan Infaq & Pengeluaran')

@section('content')
<style>
    .header {
        background: linear-gradient(135deg, #2d6a4f, #40916c);
        color: white;
        padding: 1.5rem;
        border-radius: 1rem;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background: linear-gradient(135deg, #2d6a4f, #40916c);
        color: white;
        border-radius: 1rem 1rem 0 0 !important;
        font-weight: 600;
        border: none;
    }
    .btn-export {
        background: linear-gradient(135deg, #2d6a4f, #40916c);
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        color: white;
    }
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
        background: #f8f9fa;
        border-radius: 0.5rem 0.5rem 0 0;
        padding: 0.5rem 0.5rem 0;
    }
    .nav-tabs .nav-link {
        border: none;
        border-radius: 0.5rem 0.5rem 0 0;
        font-weight: 500;
        color: #6c757d;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-link:hover {
        background-color: rgba(45, 106, 79, 0.1);
        color: #2d6a4f;
    }
    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, #2d6a4f, #40916c);
        color: white;
        border: none;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    }
    .tab-content {
        border-radius: 0 0 1rem 1rem;
        overflow: hidden;
    }
    .table th {
        background-color: #2d6a4f;
        color: white;
        border: none;
        font-weight: 600;
    }
    .table td {
        vertical-align: middle;
        border-color: #f1f1f1;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(45, 106, 79, 0.05);
    }
    .badge-success {
        background: linear-gradient(135deg, #28a745, #20c997);
    }
    .badge-danger {
        background: linear-gradient(135deg, #dc3545, #e83e8c);
    }
    .badge-info {
        background: linear-gradient(135deg, #17a2b8, #6f42c1);
    }
    .badge-secondary {
        background: linear-gradient(135deg, #6c757d, #868e96);
    }
    .alert-download {
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 1050;
        min-width: 300px;
    }
    .stats-badge {
        font-size: 0.8rem;
        margin-left: 0.5rem;
    }
</style>

<!-- Alert untuk download -->
@if(session('download_started'))
<div class="alert alert-success alert-download alert-dismissible fade show" role="alert">
    <i class="bi bi-download me-2"></i>
    <strong>Download dimulai!</strong> File Excel sedang didownload.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="container-fluid py-4">

    <div class="header mb-4">
        <h3 class="fw-bold"><i class="bi bi-file-earmark-text"></i> Laporan Infaq & Pengeluaran</h3>
        <p class="mb-0">SMKN 2 Sumedang — {{ now()->format('F Y') }}</p>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3" method="GET" id="filterForm">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $start->toDateString() }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $end->toDateString() }}" class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-success flex-fill">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <button type="button" class="btn btn-export flex-fill" id="exportBtn">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Infaq</h6>
                            <h3 class="mb-0">Rp {{ number_format($total_infaq, 0, ',', '.') }}</h3>
                        </div>
                        <i class="bi bi-cash-stack display-6 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Pengeluaran</h6>
                            <h3 class="mb-0">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</h3>
                        </div>
                        <i class="bi bi-wallet2 display-6 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Saldo Akhir</h6>
                            <h3 class="mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                        </div>
                        <i class="bi bi-graph-up display-6 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Single Table dengan Tab -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-table"></i> Data Laporan Keuangan</h5>
            <div>
                <span class="badge bg-success stats-badge">{{ $infaq->count() }} Infaq</span>
                <span class="badge bg-danger stats-badge">{{ $pengeluaran->count() }} Pengeluaran</span>
            </div>
        </div>

        <div class="card-body p-0">
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs" id="reportTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="infaq-tab" data-bs-toggle="tab" data-bs-target="#infaq" type="button" role="tab">
                        <i class="bi bi-cash-stack me-2"></i>Data Infaq
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pengeluaran-tab" data-bs-toggle="tab" data-bs-target="#pengeluaran" type="button" role="tab">
                        <i class="bi bi-wallet2 me-2"></i>Data Pengeluaran
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="reportTabsContent">
                <!-- Tab Infaq -->
                <div class="tab-pane fade show active" id="infaq" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Nama Donatur</th>
                                    <th width="20%">Nominal</th>
                                    <th width="15%">Metode</th>
                                    <th width="15%">Status</th>
                                    <th width="20%">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($infaq as $index => $i)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-person text-white"></i>
                                                </div>
                                                {{ $i->nama_donatur }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">Rp {{ number_format($i->nominal, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($i->metode) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">{{ ucfirst($i->status) }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($i->created_at)->format('d M Y') }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                            Tidak ada data infaq
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Pengeluaran -->
                <div class="tab-pane fade" id="pengeluaran" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Deskripsi</th>
                                    <th width="15%">Kategori</th>
                                    <th width="20%">Nominal</th>
                                    <th width="20%">Tanggal</th>
                                    <th width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengeluaran as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-danger rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-receipt text-white"></i>
                                                </div>
                                                {{ $p->deskripsi }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $p->kategori ?? 'Umum' }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-danger">Rp {{ number_format($p->nominal, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Selesai</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                            Tidak ada data pengeluaran
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Footer -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-info">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h6 class="mb-1">Total Transaksi</h6>
                        <h4 class="mb-0 text-primary">{{ $infaq->count() + $pengeluaran->count() }}</h4>
                    </div>
                    <div class="col-md-4">
                        <h6 class="mb-1">Periode Laporan</h6>
                        <h5 class="mb-0 text-dark">{{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</h5>
                    </div>
                    <div class="col-md-4">
                        <h6 class="mb-1">Status Saldo</h6>
                        <h4 class="mb-0 {{ $saldo >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $saldo >= 0 ? 'Surplus' : 'Defisit' }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.getElementById('exportBtn').addEventListener('click', function() {
    // Tampilkan alert
    showAlert('Memulai download...', 'info');

    // Dapatkan parameter filter
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);

    // Redirect ke URL export
    window.location.href = '{{ route("admin.laporan.export") }}?' + params.toString();
});

function showAlert(message, type = 'info') {
    // Hapus alert existing
    const existingAlert = document.querySelector('.alert-download');
    if (existingAlert) {
        existingAlert.remove();
    }

    // Buat alert baru
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-download alert-dismissible fade show`;
    alert.innerHTML = `
        <i class="bi ${type === 'info' ? 'bi-info-circle' : 'bi-download'} me-2"></i>
        <strong>${message}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alert);

    // Auto dismiss setelah 5 detik
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

// Auto-hide alert setelah 5 detik
setTimeout(() => {
    const alert = document.querySelector('.alert-download');
    if (alert) {
        alert.remove();
    }
}, 5000);

// Tambahkan efek smooth untuk tab switching
document.querySelectorAll('#reportTabs .nav-link').forEach(tab => {
    tab.addEventListener('click', function() {
        // Hapus class active dari semua tab
        document.querySelectorAll('#reportTabs .nav-link').forEach(t => {
            t.classList.remove('active');
        });
        // Tambahkan class active ke tab yang diklik
        this.classList.add('active');
    });
});
</script>
@endsection
