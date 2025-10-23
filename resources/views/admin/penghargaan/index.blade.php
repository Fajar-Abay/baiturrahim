@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-3">Daftar Penghargaan</h3>
    <a href="{{ route('admin.penghargaan.create') }}" class="btn btn-success mb-3">Tambah Penghargaan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama Penghargaan</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penghargaans as $item)
            <tr>
                <td>
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" width="100">
                    @else
                        <span class="text-muted">Tidak ada foto</span>
                    @endif
                </td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>
                    <a href="{{ route('admin.penghargaan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.penghargaan.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
