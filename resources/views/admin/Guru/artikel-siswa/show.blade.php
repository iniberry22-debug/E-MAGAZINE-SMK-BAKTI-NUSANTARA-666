@extends('admin.layouts.app-guru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Artikel Siswa</h1>
        <a href="{{ route('guru.artikel-siswa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $article->judul }}</h6>
                </div>
                <div class="card-body">
                    @if($article->foto && $article->foto != 'default.jpg')
                    <img src="{{ asset('uploads/' . $article->foto) }}" class="img-fluid mb-3" style="max-height: 300px;">
                    @endif
                    
                    <div class="article-content" style="line-height: 1.6; font-size: 16px;">
                        {!! $article->isi !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Artikel</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Penulis:</strong></td>
                            <td>{{ $article->user->nama ?? 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kategori:</strong></td>
                            <td>{{ $article->kategori->nama_kategori ?? 'No Category' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge badge-warning">Pending Review</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $article->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Review</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form action="{{ route('guru.artikel-siswa.approve', $article->id_artikel) }}" method="POST" onsubmit="return confirm('Publish artikel ini?')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-globe"></i> Publish Artikel
                            </button>
                        </form>
                        
                        <form action="{{ route('guru.artikel-siswa.reject', $article->id_artikel) }}" method="POST" onsubmit="return confirm('Tolak artikel ini?')">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="catatan_review">Alasan Penolakan</label>
                                <textarea class="form-control" name="catatan_review" rows="3" placeholder="Berikan alasan penolakan..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-times"></i> Tolak Artikel
                            </button>
                        </form>
                    </div>
                    
                    <hr>
                    <small class="text-muted">
                        <strong>Catatan:</strong><br>
                        - Artikel yang ditolak akan dikembalikan ke siswa
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection