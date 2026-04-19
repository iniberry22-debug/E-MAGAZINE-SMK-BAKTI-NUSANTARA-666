@extends('admin.layouts.app')
@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel')

@section('content')
<div class="card">
    <div class="card-header">
        <h6 class="mb-0 fw-bold">Edit Artikel</h6>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger" style="border-radius:10px;">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ route('guru.artikel.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $artikel->judul) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ old('id_kategori', $artikel->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $artikel->tanggal) }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" {{ $artikel->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $artikel->status == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Foto</label>
                    @if($artikel->foto)
                        <div class="mb-2"><img src="{{ asset('uploads/'.$artikel->foto) }}" style="height:80px; border-radius:8px;"></div>
                    @endif
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Isi Artikel <span class="text-danger">*</span></label>
                    <textarea name="isi" class="form-control" rows="12" required>{{ old('isi', $artikel->isi) }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                    <a href="{{ route('guru.artikel.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
