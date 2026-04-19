@extends('admin.layouts.app')
@section('title', 'Artikel Saya')
@section('page-title', 'Artikel Saya')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Daftar Artikel Saya</h6>
        <a href="{{ route('guru.artikel.create') }}" class="btn btn-primary btn-sm" style="border-radius:8px;">
            <i class="bi bi-plus me-1"></i>Buat Artikel
        </a>
    </div>
    <div class="card-body p-0">
        @if($artikel->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($artikel as $item)
                    <tr>
                        <td class="ps-4">{{ Str::limit($item->judul, 45) }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td><span class="badge-status-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('guru.artikel.show', $item->id_artikel) }}" class="btn btn-info btn-action text-white me-1">Lihat</a>
                            <a href="{{ route('guru.artikel.edit', $item->id_artikel) }}" class="btn btn-warning btn-action me-1">Edit</a>
                            <form action="{{ route('guru.artikel.destroy', $item->id_artikel) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-action">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $artikel->links() }}</div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-newspaper" style="font-size:2.5rem;"></i>
            <p class="mt-2">Belum ada artikel.</p>
            <a href="{{ route('guru.artikel.create') }}" class="btn btn-primary btn-sm">Buat Artikel</a>
        </div>
        @endif
    </div>
</div>
@endsection
