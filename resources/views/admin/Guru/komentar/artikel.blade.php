@extends('admin.layouts.app')
@section('title', 'Komentar Artikel')
@section('page-title', 'Komentar Artikel')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Komentar: {{ $artikel->judul }}</h6>
        <a href="{{ route('guru.komentar.index') }}" class="btn btn-secondary btn-sm" style="border-radius:8px;">Kembali</a>
    </div>
    <div class="card-body p-0">
        @if($comments->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Komentar</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $c)
                    <tr>
                        <td class="ps-4">{{ $c->nama ?? $c->user->nama ?? 'Anonim' }}</td>
                        <td>{{ $c->komentar }}</td>
                        <td>{{ $c->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $comments->links() }}</div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-chat-dots" style="font-size:2.5rem;"></i>
            <p class="mt-2">Belum ada komentar untuk artikel ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection
