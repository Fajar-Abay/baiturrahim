@extends('layouts.admin')

@section('title', 'Data Infaq')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h2 class="fw-bold mb-3 mb-md-0">Data Infaq</h2>
        <a href="{{ route('admin.infaq.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Infaq
        </a>
    </div>

    {{-- Alert pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Section --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.infaq') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="sukses" {{ request('status') == 'sukses' ? 'selected' : '' }}>Sukses</option>
                        <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>Gagal</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Metode</label>
                    <select name="metode" class="form-select">
                        <option value="">Semua</option>
                        <option value="offline" {{ request('metode') == 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="online" {{ request('metode') == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="dari" value="{{ request('dari') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="sampai" value="{{ request('sampai') }}" class="form-control">
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('admin.infaq') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Donatur</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Bukti Transfer</th>
                        <th>Tanggal</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($infaq as $key => $row)
                        <tr id="row-{{ $row->id }}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $row->nama_donatur }}</td>
                            <td>Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($row->metode) }}</td>
                            <td class="text-center">
                                <select class="form-select form-select-sm status-select" data-id="{{ $row->id }}">
                                    <option value="pending" {{ $row->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="sukses" {{ $row->status == 'sukses' ? 'selected' : '' }}>Sukses</option>
                                    <option value="gagal" {{ $row->status == 'gagal' ? 'selected' : '' }}>Gagal</option>
                                    <option value="dibatalkan" {{ $row->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </td>
                            <td class="text-center">
                                @if($row->bukti_transfer)
                                    <button class="btn btn-sm btn-primary view-image-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#imageModal"
                                            data-image="{{ asset('storage/' . $row->bukti_transfer) }}">
                                        <i class="bi bi-eye"></i> Lihat
                                    </button>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}</td>
                            <td>{{ $row->catatan ?? '-' }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.infaq.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data infaq.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Preview Gambar --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="imageModalLabel">Bukti Transfer</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Bukti Transfer" class="img-fluid rounded shadow-sm">
            </div>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === Ubah status via AJAX ===
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function () {
            const id = this.dataset.id;
            const status = this.value;

            fetch(`/admin/infaq/${id}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ status })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('✅ Status berhasil diperbarui!');
                } else {
                    alert('❌ Gagal memperbarui status!');
                }
            })
            .catch(() => alert('⚠️ Terjadi kesalahan koneksi.'));
        });
    });

    // === Preview bukti transfer di modal ===
    const previewImage = document.getElementById('previewImage');
    document.querySelectorAll('.view-image-btn').forEach(button => {
        button.addEventListener('click', function () {
            const imageSrc = this.getAttribute('data-image');
            previewImage.src = imageSrc;
        });
    });
});
</script>
@endsection
