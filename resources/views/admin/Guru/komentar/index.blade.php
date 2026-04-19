@extends('admin.layouts.app')
@section('title', 'Komentar')
@section('page-title', 'Manajemen Komentar')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0 fw-bold">Semua Komentar</h6></div>
    <div class="card-body p-0">
        @if($comments->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Komentar</th>
                        <th>Artikel</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $c)
                    <tr>
                        <td class="ps-4">{{ $c->nama ?? $c->user->nama ?? 'Anonim' }}</td>
                        <td>{{ Str::limit($c->komentar, 60) }}</td>
                        <td>{{ $c->artikel->judul ?? '-' }}</td>
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
            <p class="mt-2">Belum ada komentar.</p>
        </div>
        @endif
    </div>
</div>
@endsection
