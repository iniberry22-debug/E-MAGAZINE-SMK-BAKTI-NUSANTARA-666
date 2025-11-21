@extends('admin.layouts.app-guru')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Artikel</h1>
        <a href="{{ route('guru.artikel.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Artikel</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('guru.artikel.update', $article->id_artikel ?? 1) }}" method="POST" enctype="multipart/form-data" id="article-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="judul">Judul Artikel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" value="{{ old('judul', $article->judul ?? '') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="isi">Konten Artikel <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('isi') is-invalid @enderror" 
                                      id="isi" name="isi" rows="15" required>{{ old('isi', $article->isi ?? '') }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="foto">Gambar Utama</label>
                            @if(isset($article->foto) && $article->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('uploads/' . $article->foto) }}" 
                                         alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                                    <p class="text-muted small">Gambar saat ini</p>
                                </div>
                            @endif
                            <input type="file" class="form-control-file @error('foto') is-invalid @enderror" 
                                   id="foto" name="foto" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="status" value="draft" class="btn btn-warning">
                                <i class="fas fa-save"></i> Simpan sebagai Draft
                            </button>
                            <button type="submit" name="status" value="published" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Publish Artikel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengaturan</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="category_id">Kategori</label>
                        <select class="form-control @error('id_kategori') is-invalid @enderror" 
                                id="id_kategori" name="id_kategori" form="article-form">
                            <option value="">Pilih Kategori</option>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->id_kategori }}" 
                                        {{ old('id_kategori', $article->id_kategori ?? '') == $category->id_kategori ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                               id="tags" name="tags" value="{{ old('tags', $article->tags ?? '') }}" 
                               placeholder="Pisahkan dengan koma" form="article-form">
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Contoh: teknologi, pendidikan, tutorial</small>
                    </div>

                    <div class="form-group">
                        <label>Status Saat Ini</label>
                        <div>
                            @if(isset($article->status))
                                @if($article->status == 'published')
                                    <span class="badge badge-success">Published</span>
                                @elseif($article->status == 'draft')
                                    <span class="badge badge-warning">Draft</span>
                                @else
                                    <span class="badge badge-secondary">{{ $article->status }}</span>
                                @endif
                            @else
                                <span class="badge badge-secondary">Draft</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Statistik</label>
                        <div>
                            <small class="text-muted">
                                Views: {{ $article->views ?? 0 }}<br>
                                Dibuat: {{ isset($article->created_at) ? $article->created_at->format('d/m/Y H:i') : '-' }}<br>
                                Diupdate: {{ isset($article->updated_at) ? $article->updated_at->format('d/m/Y H:i') : '-' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection