@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-3">Edit Galeri</h3>

    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" value="{{ $galeri->judul }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $galeri->deskripsi }}</textarea>
        </div>
        <div class="mb-3">
            <label>Foto Saat Ini</label><br>
            <img src="{{ asset('storage/' . $galeri->foto) }}" width="120" class="mb-2"><br>
            <label>Ganti Foto (opsional)</label>
            <input type="file" name="foto" class="form-control">
        </div>
        <button class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
