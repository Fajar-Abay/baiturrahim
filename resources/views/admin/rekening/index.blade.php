@extends('layouts.admin')
@section('title', 'Kelola Rekening')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-success fw-bold">Daftar Rekening</h3>
        <a href="{{ route('admin.rekening.create') }}" class="btn btn-success">+ Tambah Rekening</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive shadow-sm">
        <table class="table table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th>No</th>
                    <th>Nama Bank</th>
                    <th>Nomor Rekening</th>
                    <th>Atas Nama</th>
                    <th>QRIS</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekenings as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->nama_bank }}</td>
                        <td>{{ $r->nomor_rekening }}</td>
                        <td>{{ $r->atas_nama }}</td>
                        <td>
                            @if($r->qris_code)
                                <img src="{{ asset('storage/'.$r->qris_code) }}" alt="QRIS" width="60" class="rounded shadow-sm">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.rekening.edit', $r->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.rekening.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada data rekening</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
