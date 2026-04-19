@extends('layouts.siswa')
@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card blue">
            <div class="number">{{ $stats['my_articles'] }}</div>
            <div class="label"><i class="bi bi-newspaper me-1"></i>Total Artikel</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card green">
            <div class="number">{{ $stats['published'] }}</div>
            <div class="label"><i class="bi bi-check-circle me-1"></i>Published</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card orange">
            <div class="number">{{ $stats['pending'] }}</div>
            <div class="label"><i class="bi bi-clock me-1"></i>Menunggu Review</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card red">
            <div class="number">{{ $stats['rejected'] }}</div>
            <div class="label"><i class="bi bi-x-circle me-1"></i>Ditolak</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Artikel Terbaru Saya</h6>
        <a href="{{ route('siswa.artikel.create') }}" class="btn btn-primary btn-sm" style="border-radius:8px;">
            <i class="bi bi-plus me-1"></i>Buat Artikel
        </a>
    </div>
    <div class="card-body p-0">
        @if($my_articles->count() > 0)
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
                    @foreach($my_articles as $article)
                    <tr>
                        <td class="ps-4">{{ Str::limit($article->judul, 40) }}</td>
                        <td>{{ $article->kategori->nama_kategori ?? '-' }}</td>
                        <td><span class="badge-status-{{ $article->status }}">{{ ucfirst($article->status) }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($article->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('siswa.artikel.show', $article->id_artikel) }}" class="btn btn-info btn-action text-white me-1">Lihat</a>
                            @if($article->status == 'draft' || $article->status == 'rejected')
                            <a href="{{ route('siswa.artikel.edit', $article->id_artikel) }}" class="btn btn-warning btn-action">Edit</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-newspaper" style="font-size:2.5rem;"></i>
            <p class="mt-2">Belum ada artikel.</p>
            <a href="{{ route('siswa.artikel.create') }}" class="btn btn-primary btn-sm">Buat Artikel Pertama</a>
        </div>
        @endif
    </div>
</div>
@endsection
