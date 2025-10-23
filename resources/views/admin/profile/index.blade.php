@extends('layouts.admin')

@section('title', 'Profil Masjid')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Profil Masjid</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nama Masjid</label>
            <input type="text" name="nama" class="form-control"
                   value="{{ old('nama', $profile->nama ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control">{{ old('alamat', $profile->alamat ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Desa / Kecamatan</label>
            <input type="text" name="desa_kecamatan" class="form-control"
                   value="{{ old('desa_kecamatan', $profile->desa_kecamatan ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $profile->deskripsi ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Visi</label>
            <textarea name="visi" class="form-control" rows="3">{{ old('visi', $profile->visi ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Misi</label>
            <textarea name="misi" class="form-control" rows="3">{{ old('misi', $profile->misi ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Koordinat (Latitude)</label>
            <input type="text" name="koordinat_lat" class="form-control"
                   value="{{ old('koordinat_lat', $profile->koordinat_lat ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Koordinat (Longitude)</label>
            <input type="text" name="koordinat_long" class="form-control"
                   value="{{ old('koordinat_long', $profile->koordinat_long ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Logo Masjid</label><br>
            @if(!empty($profile->foto_logo))
                <img src="{{ Storage::url($profile->foto_logo) }}" width="100" class="mb-2 rounded">
            @endif
            <input type="file" name="foto_logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
