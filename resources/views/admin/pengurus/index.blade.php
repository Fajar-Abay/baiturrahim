@extends('layouts.admin')

@section('title', 'Data Pengurus Masjid')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">👳‍♂️ Data Pengurus Masjid</h3>
        <a href="{{ route('admin.pengurus.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Pengurus
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penguruses as $key => $row)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if($row->foto)
                                    <img src="{{ asset('storage/' . $row->foto) }}" alt="Foto" width="60" height="60" class="rounded-circle object-fit-cover">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->jabatan }}</td>
                            <td>{{ $row->no_hp ?? '-' }}</td>
                            <td>{{ $row->email ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.pengurus.edit', $row->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.pengurus.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pengurus ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-muted text-center">Belum ada data pengurus.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
