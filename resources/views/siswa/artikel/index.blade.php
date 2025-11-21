@extends('layouts.siswa')

@section('title', 'Artikel Saya')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Artikel Saya</h2>
                <a href="{{ route('siswa.artikel.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Artikel Baru
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($artikel->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($artikel as $item)
                                    <tr>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                        <td>
                                            @if($item->status == 'published')
                                                <span class="badge bg-success">Published</span>
                                            @elseif($item->status == 'pending')
                                                <span class="badge bg-warning">Pending Review</span>
                                            @elseif($item->status == 'approved')
                                                <span class="badge bg-info">Approved - Menunggu Publikasi</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('siswa.artikel.show', $item->id_artikel) }}" class="btn btn-sm btn-info">Lihat</a>
                                            @if(in_array($item->status, ['pending', 'rejected']))
                                                <a href="{{ route('siswa.artikel.edit', $item->id_artikel) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('siswa.artikel.destroy', $item->id_artikel) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $artikel->links('custom.pagination') }}
                    @else
                        <div class="text-center py-4">
                            <p>Belum ada artikel.</p>
                            <a href="{{ route('siswa.artikel.create') }}" class="btn btn-primary">Buat Artikel Pertama</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection