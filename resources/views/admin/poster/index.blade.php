@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Poster Siap Publish</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($posters->count() > 0)
                <div class="row">
                    @foreach($posters as $poster)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('uploads/' . $poster->foto) }}" class="card-img-top" alt="{{ $poster->judul }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $poster->judul }}</h5>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $poster->user->nama ?? 'Siswa' }}<br>
                                        <i class="fas fa-tag"></i> {{ $poster->kategori }}<br>
                                        <i class="fas fa-calendar"></i> {{ $poster->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </p>
                                <div class="d-flex justify-content-center">
                                    <form action="{{ route('admin.poster.publish', $poster->id) }}" method="POST" onsubmit="return confirm('Publish poster ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-globe"></i> Publish
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $posters->links('custom.pagination') }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-image fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Tidak ada poster yang siap dipublish</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection