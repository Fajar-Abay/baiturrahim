@extends('layouts.admin')
@section('title', 'Edit Rekening')

@section('content')
<div class="container py-4">
    <h3 class="text-success fw-bold mb-4">Edit Rekening</h3>

    <form action="{{ route('admin.rekening.update', $rekening->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Bank</label>
            <input type="text" name="nama_bank" class="form-control" value="{{ $rekening->nama_bank }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor Rekening</label>
            <input type="text" name="nomor_rekening" class="form-control" value="{{ $rekening->nomor_rekening }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Atas Nama</label>
            <input type="text" name="atas_nama" class="form-control" value="{{ $rekening->atas_nama }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">QRIS Saat Ini</label><br>
            @if($rekening->qris_code)
                <img src="{{ asset('storage/'.$rekening->qris_code) }}" alt="QRIS" width="120" class="rounded mb-2">
            @else
                <p class="text-muted">Belum ada QRIS</p>
            @endif
            <input type="file" name="qris_code" class="form-control" accept="image/*">
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.rekening.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
