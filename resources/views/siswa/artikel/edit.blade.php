@extends('layouts.siswa')

@section('title', 'Edit Artikel')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2>Edit Artikel</h2>
            
            @if($artikel->status == 'rejected' && $artikel->catatan_review)
            <div class="alert alert-danger mb-3">
                <h5><i class="fas fa-exclamation-triangle me-2"></i>Artikel Ditolak</h5>
                <p class="mb-0"><strong>Alasan:</strong> {{ $artikel->catatan_review }}</p>
                <small class="text-muted">Silakan perbaiki artikel sesuai catatan di atas dan submit ulang.</small>
            </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('siswa.artikel.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Artikel</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" value="{{ old('judul', $artikel->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select class="form-select @error('id_kategori') is-invalid @enderror" 
                                    id="id_kategori" name="id_kategori" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}" 
                                            {{ old('id_kategori', $artikel->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Artikel</label>
                            @if($artikel->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('uploads/' . $artikel->foto) }}" alt="Foto saat ini" class="img-thumbnail" style="max-width: 200px;">
                                    <p class="text-muted">Foto saat ini</p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                                   id="foto" name="foto" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Artikel</label>
                            <textarea class="form-control @error('isi') is-invalid @enderror" 
                                      id="isi" name="isi" rows="10" required>{{ old('isi', $artikel->isi) }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('siswa.artikel.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update Artikel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection