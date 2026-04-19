@extends('admin.layouts.app')
@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard Guru')

@section('content')
<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card blue">
            <div class="number">{{ $stats['my_articles'] }}</div>
            <div class="label"><i class="bi bi-newspaper me-1"></i>Total Artikel Saya</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card green">
            <div class="number">{{ $stats['published'] }}</div>
            <div class="label"><i class="bi bi-check-circle me-1"></i>Artikel Published</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card orange">
            <div class="number">{{ $stats['draft'] }}</div>
            <div class="label"><i class="bi bi-pencil me-1"></i>Draft</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card red">
            <div class="number">{{ $stats['student_pending'] }}</div>
            <div class="label"><i class="bi bi-clock me-1"></i>Artikel Siswa Pending</div>
        </div>
    </div>
</div>

<!-- Artikel Terbaru -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Artikel Terbaru</h6>
        <a href="{{ route('guru.artikel.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        @if($recent_articles->count() > 0)
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
                    @foreach($recent_articles as $article)
                    <tr>
                        <td class="ps-4">{{ Str::limit($article->judul, 40) }}</td>
                        <td>{{ $article->user->nama ?? '-' }}</td>
                        <td>{{ $article->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            <span class="badge-status-{{ $article->status }}">{{ ucfirst($article->status) }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($article->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            @if($article->user && $article->user->role == 'guru')
                                <a href="{{ route('guru.artikel.edit', $article->id_artikel) }}" class="btn btn-warning btn-action">Edit</a>
                            @else
                                <a href="{{ route('guru.artikel-siswa.show', $article->id_artikel) }}" class="btn btn-info btn-action text-white">Lihat</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $recent_articles->links() }}</div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-newspaper" style="font-size:2.5rem;"></i>
            <p class="mt-2">Belum ada artikel.</p>
            <a href="{{ route('guru.artikel.create') }}" class="btn btn-primary btn-sm">Buat Artikel</a>
        </div>
        @endif
    </div>
</div>

<!-- Artikel Siswa Pending -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Artikel Siswa Menunggu Persetujuan</h6>
        <a href="{{ route('guru.artikel-siswa.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        @if($student_articles->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Judul</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student_articles as $article)
                    <tr>
                        <td class="ps-4">{{ Str::limit($article->judul, 50) }}</td>
                        <td>{{ $article->user->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($article->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('guru.artikel-siswa.show', $article->id_artikel) }}" class="btn btn-info btn-action text-white me-1">Lihat</a>
                            <form action="{{ route('guru.artikel-siswa.approve', $article->id_artikel) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-action" onclick="return confirm('Setujui artikel ini?')">Setujui</button>
                            </form>
                            <form action="{{ route('guru.artikel-siswa.reject', $article->id_artikel) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-danger btn-action ms-1" onclick="return confirm('Tolak artikel ini?')">Tolak</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $student_articles->links() }}</div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-clipboard-check" style="font-size:2.5rem;"></i>
            <p class="mt-2">Tidak ada artikel siswa yang menunggu persetujuan.</p>
        </div>
        @endif
    </div>
</div>
@endsection
