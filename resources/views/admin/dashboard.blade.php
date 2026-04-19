@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card blue">
            <div class="number">{{ $stats['total_artikel'] }}</div>
            <div class="label"><i class="bi bi-newspaper me-1"></i>Total Artikel</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card green">
            <div class="number">{{ $stats['total_users'] }}</div>
            <div class="label"><i class="bi bi-people me-1"></i>Total User</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card orange">
            <div class="number">{{ $stats['total_comments'] }}</div>
            <div class="label"><i class="bi bi-chat-dots me-1"></i>Total Komentar</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card red">
            <div class="number">{{ $stats['pending_artikel'] }}</div>
            <div class="label"><i class="bi bi-clock me-1"></i>Artikel Pending</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Artikel Terbaru</h6>
                <a href="{{ route('admin.artikel.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Judul</th>
                                <th>Penulis</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_articles as $article)
                            <tr>
                                <td class="ps-4">{{ Str::limit($article->judul, 35) }}</td>
                                <td>{{ $article->user->nama ?? '-' }}</td>
                                <td><span class="badge-status-{{ $article->status }}">{{ ucfirst($article->status) }}</span></td>
                                <td>
                                    <a href="{{ route('admin.artikel.show', $article->id_artikel) }}" class="btn btn-info btn-action text-white">Lihat</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Log Aktivitas</h6>
            </div>
            <div class="card-body p-0">
                @foreach($recent_logs as $log)
                <div class="p-3 border-bottom" style="font-size:0.82rem;">
                    <div class="fw-semibold">{{ $log->user->nama ?? 'System' }}</div>
                    <div class="text-muted">{{ $log->aksi }}</div>
                    <div class="text-muted" style="font-size:0.75rem;">{{ $log->created_at->diffForHumans() }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
