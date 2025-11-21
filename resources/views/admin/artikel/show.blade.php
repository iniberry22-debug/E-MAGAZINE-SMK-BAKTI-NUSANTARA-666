@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Artikel</h1>
        <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $artikel->judul }}</h6>
                </div>
                <div class="card-body">
                    @if($artikel->foto)
                    <img src="{{ asset('uploads/' . $artikel->foto) }}" class="img-fluid mb-3" style="max-height: 300px;">
                    @endif
                    
                    <p><strong>Penulis:</strong> {{ $artikel->user->nama ?? '-' }}</p>
                    <p><strong>Kategori:</strong> {{ $artikel->kategori->nama_kategori ?? '-' }}</p>
                    <p><strong>Tanggal:</strong> {{ $artikel->created_at->format('d/m/Y H:i') }}</p>
                    <hr>
                    <div class="article-content" style="line-height: 1.6; font-size: 16px;">
                        {!! $artikel->isi !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Verifikasi</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.artikel.approve', $artikel->id_artikel) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="form-group">
                            <label for="catatan_review">Catatan (Opsional)</label>
                            <textarea class="form-control" id="catatan_review" name="catatan_review" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-check"></i> Setujui & Publikasikan
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.artikel.reject', $artikel->id_artikel) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="catatan_reject">Alasan Penolakan</label>
                            <textarea class="form-control" id="catatan_reject" name="catatan_review" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin tolak artikel ini?')">
                            <i class="fas fa-times"></i> Tolak Artikel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection