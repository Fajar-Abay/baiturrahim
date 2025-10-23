@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Tambah Pengeluaran</h4>

    <form action="{{ route('admin.pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Nominal</label>
            <input type="number" name="nominal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Bukti Pengeluaran</label>
            <input type="file" name="bukti_pengeluaran" class="form-control">
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.pengeluaran') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
