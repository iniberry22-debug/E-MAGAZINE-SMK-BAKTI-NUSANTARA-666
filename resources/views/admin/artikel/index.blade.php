@extends('admin.layouts.app')
@section('title', 'Verifikasi Artikel')
@section('page-title', 'Verifikasi Artikel')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0 fw-bold">Semua Artikel</h6></div>
    <div class="card-body p-0">
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
                    @forelse($artikel as $item)
                    <tr>
                        <td class="ps-4">{{ Str::limit($item->judul, 40) }}</td>
                        <td>{{ $item->user->nama ?? '-' }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td><span class="badge-status-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.artikel.show', $item->id_artikel) }}" class="btn btn-info btn-action text-white me-1">Lihat</a>
                            @if($item->status == 'approved')
                            <form action="{{ route('admin.artikel.approve', $item->id_artikel) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-action me-1">Publish</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada artikel.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $artikel->links() }}</div>
    </div>
</div>
@endsection
