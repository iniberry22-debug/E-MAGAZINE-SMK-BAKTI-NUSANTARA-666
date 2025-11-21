@extends('admin.layouts.app-guru')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Artikel</h1>
        <div>
            <a href="{{ route('guru.artikel.edit', $article->id ?? 1) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('guru.artikel.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <!-- Article Header -->
                    <div class="mb-4">
                        <h2 class="mb-3">{{ $article->title ?? 'Judul Artikel' }}</h2>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
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
                            
                            @if(isset($article->category))
                                <div class="mr-3">
                                    <span class="badge badge-primary">{{ $article->category->name }}</span>
                                </div>
                            @endif
                            
                            <div class="text-muted small">
                                <i class="fas fa-eye"></i> {{ $article->views ?? 0 }} views
                            </div>
                        </div>

                        <div class="text-muted small mb-3">
                            <i class="fas fa-calendar"></i> 
                            Dibuat: {{ isset($article->created_at) ? $article->created_at->format('d F Y, H:i') : '-' }}
                            @if(isset($article->updated_at) && $article->updated_at != $article->created_at)
                                | Diupdate: {{ $article->updated_at->format('d F Y, H:i') }}
                            @endif
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if(isset($article->featured_image) && $article->featured_image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                 alt="{{ $article->title }}" class="img-fluid rounded">
                        </div>
                    @endif

                    <!-- Excerpt -->
                    @if(isset($article->excerpt) && $article->excerpt)
                        <div class="mb-4">
                            <div class="alert alert-info">
                                <strong>Ringkasan:</strong><br>
                                {{ $article->excerpt }}
                            </div>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="article-content">
                        {!! nl2br(e($article->content ?? 'Konten artikel akan ditampilkan di sini...')) !!}
                    </div>

                    <!-- Tags -->
                    @if(isset($article->tags) && $article->tags)
                        <div class="mt-4 pt-3 border-top">
                            <strong>Tags:</strong>
                            @foreach(explode(',', $article->tags) as $tag)
                                <span class="badge badge-light mr-1">#{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Article Stats -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Artikel</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-right">
                                <h4 class="text-primary">{{ $article->views ?? 0 }}</h4>
                                <small class="text-muted">Views</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ $article->comments_count ?? 0 }}</h4>
                            <small class="text-muted">Comments</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('guru.artikel.edit', $article->id ?? 1) }}" class="btn btn-warning btn-block">
                            <i class="fas fa-edit"></i> Edit Artikel
                        </a>
                        
                        @if(isset($article->status) && $article->status == 'draft')
                            <form action="{{ route('guru.artikel.publish', $article->id ?? 1) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-paper-plane"></i> Publish Artikel
                                </button>
                            </form>
                        @elseif(isset($article->status) && $article->status == 'published')
                            <form action="{{ route('guru.artikel.unpublish', $article->id ?? 1) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-secondary btn-block">
                                    <i class="fas fa-eye-slash"></i> Unpublish
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('guru.artikel.destroy', $article->id ?? 1) }}" method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash"></i> Hapus Artikel
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Article Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><strong>Penulis:</strong></td>
                            <td>{{ $article->author->name ?? auth()->user()->name ?? 'Admin' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kategori:</strong></td>
                            <td>{{ $article->category->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
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
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ isset($article->created_at) ? $article->created_at->format('d/m/Y') : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection