@extends('admin.layouts.app')
@section('title', 'Artikel Siswa')
@section('page-title', 'Artikel Siswa')

@section('content')
<div class="card">
    <div class="card-header">
        <h6 class="mb-0 fw-bold">Daftar Artikel Siswa</h6>
    </div>
    <div class="card-body p-0">
        @if($artikel->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($artikel as $item)
                    <tr>
                        <td class="ps-4">{{ Str::limit($item->judul, 40) }}</td>
                        <td>{{ $item->user->nama ?? '-' }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td><span class="badge-status-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('guru.artikel-siswa.show', $item->id_artikel) }}" class="btn btn-info btn-action text-white me-1">Lihat</a>
                            @if($item->status == 'pending')
                            <form action="{{ route('guru.artikel-siswa.approve', $item->id_artikel) }}" method="POST" style="display:inline;" onsubmit="return confirm('Setujui artikel ini?')">
                                @csrf
                                <button class="btn btn-success btn-action me-1">Setujui</button>
                            </form>
                            <form action="{{ route('guru.artikel-siswa.reject', $item->id_artikel) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tolak artikel ini?')">
                                @csrf
                                <button class="btn btn-danger btn-action">Tolak</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $artikel->links() }}</div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-clipboard" style="font-size:2.5rem;"></i>
            <p class="mt-2">Tidak ada artikel siswa.</p>
        </div>
        @endif
    </div>
</div>
@endsection
