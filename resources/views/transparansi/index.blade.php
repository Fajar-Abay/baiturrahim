@extends('layouts.app')

@section('title', 'Transparansi Keuangan - Masjid Al-Ikhlas')

@push('styles')
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

    .hero-transparansi {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.9) 0%, rgba(76, 175, 80, 0.8) 100%),
                    url('{{ asset('images/transparansi-bg.jpg') }}') center/cover no-repeat;
        color: white;
        padding: 100px 0 80px;
        text-align: center;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
        position: relative;
        overflow: hidden;
    }

    .hero-transparansi::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 2rem;
        text-align: center;
        transition: var(--transition);
        border: none;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.8rem;
    }

    .stat-icon.income {
        background: linear-gradient(135deg, #4caf50, #2e7d32);
        color: white;
    }

    .stat-icon.outcome {
        background: linear-gradient(135deg, #f44336, #d32f2f);
        color: white;
    }

    .stat-icon.balance {
        background: linear-gradient(135deg, #2196f3, #1976d2);
        color: white;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-title {
        font-size: 1rem;
        color: #666;
        margin-bottom: 0;
    }

    .section-title {
        position: relative;
        margin-bottom: 2rem;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid var(--light-green);
    }

    .section-title h3 {
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 80px;
        height: 3px;
        background: var(--secondary-green);
    }

    .table-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
    }

    .table-card .card-header {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        color: white;
        border: none;
        padding: 1.5rem;
    }

    .table-card .table {
        margin-bottom: 0;
    }

    .table-card .table th {
        border-top: none;
        font-weight: 600;
        color: var(--primary-green);
        background: var(--light-green);
    }

    .table-card .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-success {
        background: #e8f5e9;
        color: var(--primary-green);
    }

    .badge-pending {
        background: #fff3e0;
        color: #f57c00;
    }

    .badge-failed {
        background: #ffebee;
        color: #d32f2f;
    }

    .nominal-income {
        color: var(--primary-green);
        font-weight: 600;
    }

    .nominal-outcome {
        color: #d32f2f;
        font-weight: 600;
    }

    .pagination .page-link {
        color: var(--primary-green);
        border: 1px solid #dee2e6;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
    }

    .pagination .page-link:hover {
        color: var(--primary-green);
        background-color: #e9ecef;
        border-color: #dee2e6;
    }


    .widget-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 1.5rem;
        margin-bottom: 2rem;
        height: 100%;
    }

    .widget-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-green);
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-green);
    }

    .widget-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .widget-list li {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
        transition: var(--transition);
    }

    .widget-list li:last-child {
        border-bottom: none;
    }

    .widget-list li:hover {
        background: var(--light-green);
        padding-left: 0.5rem;
    }

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    .modal-backdrop {
        z-index: 1040;
    }

    .modal {
        z-index: 1050;
    }

    .bukti-image {
        max-height: 70vh;
        width: auto;
        object-fit: contain;
    }

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

    .nav-tabs {
        border-bottom: 2px solid var(--light-green);
    }

    .nav-tabs .nav-link {
        border: none;
        color: #666;
        font-weight: 500;
        padding: 1rem 1.5rem;
        transition: var(--transition);
    }

    .nav-tabs .nav-link:hover {
        border: none;
        color: var(--primary-green);
    }

    .nav-tabs .nav-link.active {
        background: none;
        border: none;
        color: var(--primary-green);
        border-bottom: 3px solid var(--secondary-green);
    }

    @media (max-width: 768px) {
        .hero-transparansi {
            padding: 80px 0 60px;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .table-card {
            overflow-x: auto;
        }

        .nav-tabs .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
         .bukti-image {
            max-height: 50vh;
        }
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-transparansi mb-5">
    <div class="container">
        <div class="hero-content">
            <h1 class="display-5 fw-bold mb-3">Transparansi Keuangan</h1>
            <p class="lead mb-4">Laporan keuangan masjid yang transparan dan akuntabel untuk kepercayaan jamaah</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <span class="badge bg-light text-dark fs-6">
                    <i class="bi bi-cash-coin me-2"></i>Transparan 100%
                </span>
                <span class="badge bg-light text-dark fs-6">
                    <i class="bi bi-shield-check me-2"></i>Terpercaya
                </span>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">

    <!-- Statistik Keuangan -->
    <section class="mb-5 fade-in-up">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon income">
                        <i class="bi bi-arrow-down-circle"></i>
                    </div>
                    <div class="stat-number nominal-income">Rp {{ number_format($total_infaq, 0, ',', '.') }}</div>
                    <h4 class="stat-title">Total Pemasukan</h4>
                    <small class="text-muted">Dari infaq dan donasi</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon outcome">
                        <i class="bi bi-arrow-up-circle"></i>
                    </div>
                    <div class="stat-number nominal-outcome">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</div>
                    <h4 class="stat-title">Total Pengeluaran</h4>
                    <small class="text-muted">Untuk operasional masjid</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon balance">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div class="stat-number" style="color: #2196f3;">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
                    <h4 class="stat-title">Saldo Tersedia</h4>
                    <small class="text-muted">Saldo saat ini</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Tabs untuk Infaq dan Pengeluaran -->
    <section class="fade-in-up">
        <ul class="nav nav-tabs mb-4" id="financeTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="infaq-tab" data-bs-toggle="tab" data-bs-target="#infaq" type="button" role="tab">
                    <i class="bi bi-cash-coin me-2"></i>Data Infaq
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pengeluaran-tab" data-bs-toggle="tab" data-bs-target="#pengeluaran" type="button" role="tab">
                    <i class="bi bi-receipt me-2"></i>Data Pengeluaran
                </button>
            </li>
        </ul>

        <div class="tab-content" id="financeTabsContent">
            <!-- Tab Infaq -->
            <div class="tab-pane fade show active" id="infaq" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="table-card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-cash-coin me-2"></i>Daftar Infaq Masuk
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th width="20%">Tanggal</th>
                                                <th width="25%">Donatur</th>
                                                <th width="15%">Metode</th>
                                                <th width="20%">Nominal</th>
                                                <th width="20%">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($infaqs as $infaq)
                                                <tr>
                                                    <td>
                                                        <small class="text-muted">{{ $infaq->created_at->format('d M Y') }}</small>
                                                        <br>
                                                        <small>{{ $infaq->created_at->format('H:i') }}</small>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $infaq->nama_donatur }}</strong>
                                                        @if($infaq->catatan)
                                                            <br>
                                                            <small class="text-muted">{{ Str::limit($infaq->catatan, 30) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($infaq->metode == 'online')
                                                            <span class="badge bg-info">Online</span>
                                                        @else
                                                            <span class="badge bg-secondary">Offline</span>
                                                        @endif
                                                    </td>
                                                    <td class="nominal-income">
                                                        + Rp {{ number_format($infaq->nominal, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        <span class="badge-status badge-success">
                                                            <i class="bi bi-check-circle me-1"></i>Sukses
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <i class="bi bi-inbox display-4 text-muted d-block mb-2"></i>
                                                        <span class="text-muted">Belum ada data infaq</span>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination Infaq -->
                        @if($infaqs->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $infaqs->appends(['pengeluaran_page' => $pengeluarans->currentPage()])->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar Infaq -->
                    <div class="col-lg-4">
                        <div class="widget-card">
                            <h5 class="widget-title">
                                <i class="bi bi-clock-history me-2"></i>Infaq Terbaru
                            </h5>
                            <ul class="widget-list">
                                @foreach($infaq_terbaru as $infaq)
                                    <li>
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong class="d-block">{{ $infaq->nama_donatur }}</strong>
                                                <small class="text-muted">{{ $infaq->created_at->diffForHumans() }}</small>
                                            </div>
                                            <span class="nominal-income">+Rp {{ number_format($infaq->nominal, 0, ',', '.') }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Pengeluaran -->
            <div class="tab-pane fade" id="pengeluaran" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="table-card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-receipt me-2"></i>Daftar Pengeluaran
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th width="15%">Tanggal</th>
                                                <th width="30%">Keterangan</th>
                                                <th width="20%">Kategori</th>
                                                <th width="20%">Nominal</th>
                                                <th width="15%">Bukti</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pengeluarans as $pengeluaran)
                                                <tr>
                                                    <td>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d M Y') }}</small>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $pengeluaran->deskripsi }}</strong>
                                                    </td>
                                                    <td>
                                                        @if($pengeluaran->kategori)
                                                            <span class="badge bg-light text-dark">{{ $pengeluaran->kategori }}</span>
                                                        @else
                                                            <span class="badge bg-light text-dark">Lainnya</span>
                                                        @endif
                                                    </td>
                                                    <td class="nominal-outcome">
                                                        - Rp {{ number_format($pengeluaran->nominal, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        @if($pengeluaran->bukti_pengeluaran)
                                                            <button class="btn btn-sm btn-outline-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#buktiModal{{ $pengeluaran->id }}">
                                                                <i class="bi bi-eye"></i> Lihat
                                                            </button>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4">
                                                        <i class="bi bi-receipt display-4 text-muted d-block mb-2"></i>
                                                        <span class="text-muted">Belum ada data pengeluaran</span>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination Pengeluaran -->
                        @if($pengeluarans->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $pengeluarans->appends(['infaq_page' => $infaqs->currentPage()])->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar Pengeluaran -->
                    <div class="col-lg-4">
                        <div class="widget-card">
                            <h5 class="widget-title">
                                <i class="bi bi-graph-up me-2"></i>Pengeluaran Terbesar
                            </h5>
                            <ul class="widget-list">
                                @foreach($pengeluaran_terbesar as $pengeluaran)
                                    <li>
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong class="d-block">{{ Str::limit($pengeluaran->deskripsi, 25) }}</strong>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d M Y') }}</small>
                                            </div>
                                            <span class="nominal-outcome">-Rp {{ number_format($pengeluaran->nominal, 0, ',', '.') }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- Modal Bukti Pengeluaran - Ditempatkan di luar konten utama -->
@foreach($pengeluarans as $pengeluaran)
    @if($pengeluaran->bukti_pengeluaran)
        <div class="modal fade"
             id="buktiModal{{ $pengeluaran->id }}"
             tabindex="-1"
             aria-labelledby="buktiModalLabel{{ $pengeluaran->id }}"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold" id="buktiModalLabel{{ $pengeluaran->id }}">
                            <i class="bi bi-receipt me-2"></i>Bukti Pengeluaran
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">{{ $pengeluaran->deskripsi }}</h6>
                            <p class="text-muted mb-1">
                                <i class="bi bi-calendar me-2"></i>
                                {{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d F Y') }}
                            </p>
                            <p class="text-danger fw-bold fs-5">
                                <i class="bi bi-currency-dollar me-2"></i>
                                Rp {{ number_format($pengeluaran->nominal, 0, ',', '.') }}
                            </p>
                            @if($pengeluaran->kategori)
                                <span class="badge bg-light text-dark border">
                                    {{ $pengeluaran->kategori }}
                                </span>
                            @endif
                        </div>

                        <div class="border rounded p-3 bg-light">
                            <img src="{{ asset('storage/' . $pengeluaran->bukti_pengeluaran) }}"
                                 alt="Bukti Pengeluaran {{ $pengeluaran->deskripsi }}"
                                 class="img-fluid bukti-image rounded shadow-sm">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi fade in
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in-up').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });

        // Smooth tab switching
        const financeTabs = document.querySelectorAll('#financeTabs .nav-link');
        financeTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                financeTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Format numbers with animation
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(stat => {
            const originalText = stat.textContent;
            stat.textContent = 'Rp 0';

            setTimeout(() => {
                stat.textContent = originalText;
                stat.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    stat.style.transform = 'scale(1)';
                }, 200);
            }, 500);
        });

        // Modal initialization dengan konfigurasi yang tepat
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function () {
                // Pastikan backdrop berfungsi dengan baik
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            });

            modal.addEventListener('hidden.bs.modal', function () {
                // Hapus backdrop saat modal ditutup
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });
        });
    });
</script>
@endpush
