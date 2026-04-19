@extends('layouts.siswa')
@section('title', 'Upload Poster')
@section('page-title', 'Upload Poster')

@section('content')
<div class="card">
    <div class="card-header">
        <h6 class="mb-0 fw-bold">Form Upload Poster</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger" style="border-radius:10px;">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('siswa.poster.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Judul Poster <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">File Poster <span class="text-danger">*</span></label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                    <small class="text-muted">Format: JPG, PNG, GIF. Maks 2MB.</small>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-upload me-1"></i>Upload Poster</button>
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
