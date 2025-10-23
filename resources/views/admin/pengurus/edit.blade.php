@extends('layouts.admin')

@section('title', 'Edit Pengurus')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Edit Data Pengurus</h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.pengurus.update', $pengurus->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $pengurus->nama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" value="{{ $pengurus->jabatan }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $pengurus->no_hp }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $pengurus->email }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ $pengurus->alamat }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto</label><br>
                    @if($pengurus->foto)
                        <img src="{{ asset('storage/' . $pengurus->foto) }}" alt="Foto" width="100" class="mb-2 rounded">
                    @endif
                    <input type="file" name="foto" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('admin.pengurus.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
