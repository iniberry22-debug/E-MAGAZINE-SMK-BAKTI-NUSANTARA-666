@extends('layouts.siswa')

@section('title', $artikel->judul)

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('siswa.baca-artikel') }}">Baca Artikel</a></li>
                    <li class="breadcrumb-item active">{{ $artikel->judul }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <article class="card">
                @if($artikel->foto)
                <img src="{{ asset('uploads/' . $artikel->foto) }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h1 class="card-title">{{ $artikel->judul }}</h1>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="text-muted">
                            <i class="fas fa-user"></i> {{ $artikel->user->nama ?? 'Unknown' }} |
                            <i class="fas fa-calendar"></i> {{ $artikel->created_at->format('d/m/Y H:i') }} |
                            <i class="fas fa-tag"></i> {{ $artikel->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                        </div>
                        
                        <div class="d-flex gap-2">
                            <form action="{{ route('siswa.artikel.like', $artikel->id_artikel) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $isLiked ? 'btn-danger' : 'btn-outline-danger' }}">
                                    <i class="fas fa-heart"></i> {{ $artikel->likes->count() }}
                                </button>
                            </form>
                            <span class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-comment"></i> {{ $artikel->comments->count() }}
                            </span>
                        </div>
                    </div>

                    <div class="article-content">
                        {!! nl2br(e($artikel->isi)) !!}
                    </div>
                </div>
            </article>

            <!-- Komentar -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-comments"></i> Komentar ({{ $artikel->comments->count() }})</h5>
                </div>
                <div class="card-body">
                    <!-- Form Komentar -->
                    <form action="{{ route('siswa.artikel.comment', $artikel->id_artikel) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="isi_komentar" class="form-label">Tulis Komentar</label>
                            <textarea class="form-control @error('isi_komentar') is-invalid @enderror" 
                                      id="isi_komentar" name="isi_komentar" rows="3" 
                                      placeholder="Tulis komentar Anda..." required>{{ old('isi_komentar') }}</textarea>
                            @error('isi_komentar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Kirim Komentar
                        </button>
                    </form>

                    <!-- Daftar Komentar -->
                    @forelse($artikel->comments->sortByDesc('created_at') as $comment)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $comment->user->nama ?? 'Unknown' }}</strong>
                                <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        <p class="mt-2 mb-0">{{ $comment->comment }}</p>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6><i class="fas fa-info-circle"></i> Informasi Artikel</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Penulis:</strong></td>
                            <td>{{ $artikel->user->nama ?? 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kategori:</strong></td>
                            <td>{{ $artikel->kategori->nama_kategori ?? 'Tanpa Kategori' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dipublikasi:</strong></td>
                            <td>{{ $artikel->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Like:</strong></td>
                            <td>{{ $artikel->likes->count() }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Komentar:</strong></td>
                            <td>{{ $artikel->comments->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection