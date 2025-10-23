@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Daftar Artikel</h4>

    <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary mb-3">+ Tambah Artikel</a>

    {{-- 🔍 Filter & Search --}}
    <form method="GET" action="{{ route('admin.artikel') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari judul..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="publish" {{ request('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="baru" {{ request('sort') == 'baru' ? 'selected' : '' }}>Terbaru</option>
                <option value="lama" {{ request('sort') == 'lama' ? 'selected' : '' }}>Terlama</option>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </form>

    {{-- ✅ Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 📋 Tabel Artikel --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Cover</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($artikels as $artikel)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $artikel->judul }}</td>
                    <td>{{ $artikel->penulis ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $artikel->status == 'publish' ? 'success' : 'secondary' }}">
                            {{ ucfirst($artikel->status) }}
                        </span>
                    </td>
                    <td>{{ $artikel->tanggal_posting }}</td>
                    <td>
                        @if($artikel->foto_cover)
                            <img src="{{ asset('storage/'.$artikel->foto_cover) }}" width="70" class="rounded shadow-sm">
                        @else
                            <small>Tidak ada</small>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus artikel ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Belum ada artikel.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 🔢 Pagination --}}
    <div class="mt-3">
        {{ $artikels->appends(request()->query())->links() }}
    </div>
</div>
@endsection
