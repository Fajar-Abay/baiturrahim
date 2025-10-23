@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-3">Edit Penghargaan</h3>

    <form action="{{ route('admin.penghargaan.update', $penghargaan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nama Penghargaan</label>
            <input type="text" name="name" value="{{ $penghargaan->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $penghargaan->deskripsi }}</textarea>
        </div>
        <div class="mb-3">
            <label>Foto Saat Ini</label><br>
            @if($penghargaan->foto)
                <img src="{{ asset('storage/' . $penghargaan->foto) }}" width="120" class="mb-2"><br>
            @else
                <p class="text-muted">Tidak ada foto</p>
            @endif
            <label>Ganti Foto (opsional)</label>
            <input type="file" name="foto" class="form-control">
        </div>
        <button class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
