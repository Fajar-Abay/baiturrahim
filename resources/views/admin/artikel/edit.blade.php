@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Edit Artikel</h4>

    <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ $artikel->judul }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Isi</label>
            <textarea name="isi" rows="6" class="form-control" required>{{ $artikel->isi }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Penulis</label>
            <input type="text" name="penulis" class="form-control" value="{{ $artikel->penulis }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Cover</label><br>
            @if($artikel->foto_cover)
                <img src="{{ asset('storage/'.$artikel->foto_cover) }}" width="100" class="mb-2 rounded">
            @endif
            <input type="file" name="foto_cover" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="draft" {{ $artikel->status == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="publish" {{ $artikel->status == 'publish' ? 'selected' : '' }}>Publish</option>
            </select>
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.artikel') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
