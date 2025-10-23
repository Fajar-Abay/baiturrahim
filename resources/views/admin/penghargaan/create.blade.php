@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-3">Tambah Penghargaan</h3>

    <form action="{{ route('admin.penghargaan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nama Penghargaan</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Foto (opsional)</label>
            <input type="file" name="foto" class="form-control">
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
