@extends('admin.layouts.app')
@section('title', 'Poster')
@section('page-title', 'Manajemen Poster')

@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0 fw-bold">Semua Poster</h6></div>
    <div class="card-body">
        @if($posters->count() > 0)
        <div class="row g-3">
            @foreach($posters as $poster)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100" style="border-radius:12px; overflow:hidden;">
                    <img src="{{ asset('uploads/'.$poster->foto) }}" class="card-img-top" style="height:180px; object-fit:cover;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-1" style="font-size:0.9rem;">{{ Str::limit($poster->judul, 30) }}</h6>
                        <small class="text-muted d-block">{{ $poster->user->nama ?? 'Siswa' }}</small>
                        <small class="text-muted d-block mb-2">{{ $poster->created_at->format('d/m/Y') }}</small>
                        <span class="badge-status-{{ $poster->status == 'published' ? 'published' : 'pending' }}">{{ ucfirst($poster->status) }}</span>
                        @if($poster->status == 'pending')
                        <form action="{{ route('admin.poster.publish', $poster->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Publish poster ini?')">
                            @csrf
                            <button class="btn btn-success btn-sm w-100" style="border-radius:8px;">Publish</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-3">{{ $posters->links() }}</div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-image" style="font-size:2.5rem;"></i>
            <p class="mt-2">Belum ada poster.</p>
        </div>
        @endif
    </div>
</div>
@endsection
