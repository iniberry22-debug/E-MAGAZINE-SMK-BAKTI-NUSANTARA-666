@extends('admin.layouts.app-guru')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Artikel</h1>
        <a href="{{ route('guru.artikel.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Artikel
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('guru.artikel.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari artikel..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="category" class="form-control">
                            <option value="">Semua Kategori</option>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->id_kategori }}" {{ request('category') == $category->id_kategori ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Articles Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Artikel</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if(isset($articles) && count($articles) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Judul</th>
                                <th width="10%">Penulis</th>
                                <th width="15%">Kategori</th>
                                <th width="10%">Status</th>
                                <th width="10%">Komentar</th>
                                <th width="10%">Tanggal</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $index => $article)
                            <tr>
                                <td>{{ $articles->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $article->judul }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit(strip_tags($article->isi), 50) }}</small>
                                </td>
                                <td>{{ $article->user->nama ?? '-' }}</td>
                                <td>
                                    @if($article->kategori)
                                        <span class="badge badge-secondary">{{ $article->kategori->nama_kategori }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($article->status == 'published')
                                        <span class="badge badge-success">Published</span>
                                    @elseif($article->status == 'approved')
                                        <span class="badge badge-info">Approved</span>
                                    @elseif($article->status == 'draft')
                                        <span class="badge badge-warning">Draft</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $article->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $article->comments->count() ?? 0 }}</td>
                                <td>{{ \Carbon\Carbon::parse($article->tanggal)->format('d/m/Y') }}</td>
                                <td>
                                    @if($article->status == 'published')
                                        <a href="{{ route('blog.details', $article->id_artikel) }}" class="btn btn-sm btn-info" title="Lihat di Website">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                    @if($article->user->role == 'guru')
                                        <a href="{{ route('guru.artikel.edit', $article->id_artikel) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                    @if($article->comments && $article->comments->count() > 0)
                                        <a href="{{ route('guru.komentar.artikel', $article->id_artikel) }}" class="btn btn-sm btn-primary" title="Komentar">
                                            <i class="fas fa-comments"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-newspaper fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada artikel.</p>
                    <a href="{{ route('guru.artikel.create') }}" class="btn btn-primary">Buat Artikel Pertama</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection