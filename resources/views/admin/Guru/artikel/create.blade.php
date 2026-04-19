@extends('admin.layouts.app')
@section('title', 'Buat Artikel')
@section('page-title', 'Buat Artikel Baru')

@section('content')
<div class="card">
    <div class="card-header">
        <h6 class="mb-0 fw-bold">Form Buat Artikel</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger" style="border-radius:10px;">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('guru.artikel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Isi Artikel <span class="text-danger">*</span></label>
                    <textarea name="isi" class="form-control" rows="12" required>{{ old('isi') }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                    <a href="{{ route('guru.artikel.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
