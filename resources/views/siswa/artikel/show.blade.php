@extends('layouts.siswa')

@section('title', $artikel->judul)

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>{{ $artikel->judul }}</h2>
                <div>
                    <a href="{{ route('siswa.artikel.edit', $artikel->id_artikel) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('siswa.artikel.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Kategori:</strong> {{ $artikel->kategori->nama_kategori ?? '-' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong> 
                            @if($artikel->status == 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($artikel->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tanggal:</strong> {{ $artikel->tanggal->format('d F Y') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Penulis:</strong> {{ $artikel->user->nama ?? 'Unknown' }}
                        </div>
                    </div>

                    @if($artikel->foto)
                        <div class="mb-4">
                            <img src="{{ asset('uploads/' . $artikel->foto) }}" alt="{{ $artikel->judul }}" 
                                 class="img-fluid rounded" style="max-width: 100%; height: auto;">
                        </div>
                    @endif

                    <div class="article-content">
                        {!! nl2br(e($artikel->isi)) !!}
                    </div>

                    @if($artikel->status == 'rejected')
                        <div class="alert alert-danger mt-4">
                            <strong>Artikel Ditolak</strong><br>
                            Artikel ini ditolak oleh admin. Silakan edit dan perbaiki artikel Anda.
                        </div>
                    @elseif($artikel->status == 'pending')
                        <div class="alert alert-warning mt-4">
                            <strong>Menunggu Persetujuan</strong><br>
                            Artikel ini sedang menunggu persetujuan dari admin.
                        </div>
                    @endif
                </div>
            </div>

            @if($artikel->status == 'published')
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Komentar</h5>
                    </div>
                    <div class="card-body">
                        @if($artikel->comments && $artikel->comments->count() > 0)
                            @foreach($artikel->comments as $comment)
                                <div class="border-bottom pb-3 mb-3">
                                    <strong>{{ $comment->user->nama ?? 'Anonymous' }}</strong>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    <p class="mt-2">{{ $comment->isi }}</p>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Belum ada komentar.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection