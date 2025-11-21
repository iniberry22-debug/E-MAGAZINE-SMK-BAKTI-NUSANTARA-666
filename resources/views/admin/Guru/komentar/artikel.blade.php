@extends('admin.layouts.app-guru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Komentar Artikel</h1>
        <a href="{{ route('guru.artikel.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $artikel->judul }}</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Penulis:</strong> {{ $artikel->user->nama ?? '-' }}<br>
                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($artikel->tanggal)->format('d/m/Y') }}<br>
                <strong>Total Komentar:</strong> {{ $artikel->comments->count() }}
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Komentar</h6>
        </div>
        <div class="card-body">
            @if($artikel->comments->count() > 0)
                @foreach($artikel->comments as $comment)
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $comment->user->nama ?? $comment->nama ?? 'Anonim' }}</strong>
                        <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <p class="mt-2 mb-0">{{ $comment->isi ?? $comment->content }}</p>
                </div>
                @endforeach
            @else
                <div class="text-center py-4">
                    <i class="fas fa-comments fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada komentar untuk artikel ini</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection