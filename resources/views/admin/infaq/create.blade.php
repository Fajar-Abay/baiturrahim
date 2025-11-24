@extends('layouts.admin')

@section('title', 'Tambah Infaq')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Tambah Data Infaq</h2>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.infaq.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Donatur</label>
                        <input type="text" name="nama_donatur" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nominal (Rp)</label>
                        <input type="number" name="nominal" class="form-control" min="1000" step="0.01" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Metode</label>
                        <select name="metode" class="form-select" required>
                            <option value="offline">Offline</option>
                            <option value="online">Online</option>
                        </select>
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea name="catatan" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bukti Transfer</label>
                    <input type="file" name="bukti_transfer" class="form-control" accept="image/*" required>
                    <small class="text-muted">Format: JPG, JPEG, PNG | Maksimal 2MB</small>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('admin.infaq') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
