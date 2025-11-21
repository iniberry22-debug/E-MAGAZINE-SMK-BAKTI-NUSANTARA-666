@extends('layouts.siswa')

@section('title', 'Baca Artikel')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2>Artikel Published</h2>
            <p class="text-muted">Baca artikel yang telah dipublikasikan</p>
        </div>
    </div>

    <div class="row">
        @forelse($artikel as $item)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                @if($item->foto)
                <img src="{{ asset('uploads/' . $item->foto) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $item->judul }}</h5>
                    <p class="card-text text-muted small">
                        <i class="fas fa-tag"></i> {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }} |
                        <i class="fas fa-user"></i> {{ $item->user->nama ?? 'Unknown' }} |
                        <i class="fas fa-calendar"></i> {{ $item->created_at->format('d/m/Y') }}
                    </p>
                    <p class="card-text">{{ Str::limit(strip_tags($item->isi), 100) }}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-heart"></i> {{ $item->likes->count() }} |
                                <i class="fas fa-comment"></i> {{ $item->comments->count() }}
                            </small>
                            <a href="{{ route('siswa.artikel-detail', $item->id_artikel) }}" class="btn btn-primary btn-sm">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h4>Belum ada artikel published</h4>
                <p class="text-muted">Artikel akan muncul di sini setelah disetujui oleh admin/guru</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($artikel->hasPages())
    <div class="row">
        <div class="col-12">
            {{ $artikel->links('custom.pagination') }}
        </div>
    </div>
    @endif
</div>
@endsection