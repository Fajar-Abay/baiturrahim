@extends('layouts.admin')
@section('title', 'Tambah Rekening')

@section('content')
<div class="container py-4">
    <h3 class="text-success fw-bold mb-4">Tambah Rekening</h3>

    <form action="{{ route('admin.rekening.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Bank</label>
            <input type="text" name="nama_bank" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor Rekening</label>
            <input type="text" name="nomor_rekening" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Atas Nama</label>
            <input type="text" name="atas_nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload QRIS (opsional)</label>
            <input type="file" name="qris_code" class="form-control" accept="image/*">
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.rekening.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
