@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Verifikasi Artikel</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($artikels as $artikel)
                        <tr>
                            <td>{{ $artikels->firstItem() + $loop->index }}</td>
                            <td>{{ $artikel->judul }}</td>
                            <td>{{ $artikel->user->nama ?? 'Unknown' }}</td>
                            <td>{{ $artikel->kategori->nama_kategori ?? '-' }}</td>
                            <td>
                                <span class="badge badge-info">Approved - Menunggu Publikasi</span>
                            </td>
                            <td>{{ $artikel->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.artikel.show', $artikel->id_artikel) }}" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada artikel yang perlu diverifikasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $artikels->links('custom.pagination') }}
        </div>
    </div>
</div>
@endsection