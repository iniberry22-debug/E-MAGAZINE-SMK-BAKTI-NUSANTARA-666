@extends('admin.layouts.app-guru')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Guru</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Artikel Saya -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Artikel Saya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['my_articles'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Artikel Published -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Artikel Published</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['published'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Artikel Draft -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Draft</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['draft'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-edit fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Artikel Siswa Pending -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Artikel Siswa Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['student_pending'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row">
        <!-- Poster Published -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-purple shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-purple text-uppercase mb-1">
                                Poster Published</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['published_posters'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-image fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Published Posters Section -->
    @if(isset($published_posters) && count($published_posters) > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Poster Yang Sudah Dipublish</h6>
                    <span class="badge badge-info">{{ $published_posters->total() }} Total</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($published_posters as $poster)
                        <div class="col-lg-2 col-md-3 col-sm-4 mb-3">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('uploads/' . $poster->foto) }}" class="card-img-top" style="height: 120px; object-fit: cover;" alt="{{ $poster->judul }}">
                                <div class="card-body p-2">
                                    <h6 class="card-title small mb-1">{{ Str::limit($poster->judul, 25) }}</h6>
                                    <small class="text-muted d-block">{{ $poster->user->nama ?? 'Siswa' }}</small>
                                    <small class="text-info">{{ $poster->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $published_posters->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif



    <!-- Articles Section -->
    <div class="row">
        <!-- Articles -->
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Artikel</h6>
                    <a href="{{ route('guru.artikel.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @if(isset($recent_articles) && count($recent_articles) > 0)
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="25%">Judul</th>
                                    <th width="15%">Penulis</th>
                                    <th width="12%">Kategori</th>
                                    <th width="10%">Status</th>
                                    <th width="8%">Komentar</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_articles as $article)
                                <tr>
                                    <td>{{ Str::limit($article->judul, 40) }}</td>
                                    <td>{{ $article->user->nama ?? '-' }}</td>
                                    <td><span class="badge badge-secondary">{{ $article->kategori->nama_kategori ?? '-' }}</span></td>
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
                                    <td class="text-center">{{ $article->comments->count() ?? 0 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($article->tanggal)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($article->user->role == 'guru')
                                                <a href="{{ route('guru.artikel.edit', $article->id_artikel) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('guru.artikel-siswa.show', $article->id_artikel) }}" class="btn btn-sm btn-info" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            @if($article->comments->count() > 0)
                                                <a href="{{ route('guru.komentar.artikel', $article->id_artikel) }}" class="btn btn-sm btn-primary" title="Komentar">
                                                    <i class="fas fa-comments"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $recent_articles->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-newspaper fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Belum ada artikel. <a href="{{ route('guru.artikel.create') }}" class="btn btn-sm btn-primary">Buat artikel pertama</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Student Articles Pending -->
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Artikel Siswa Menunggu Persetujuan</h6>
                    <a href="{{ route('guru.artikel-siswa.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @if(isset($student_articles) && count($student_articles) > 0)
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="40%">Judul</th>
                                    <th width="20%">Penulis</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="25%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student_articles as $article)
                                <tr>
                                    <td>{{ Str::limit($article->judul, 50) }}</td>
                                    <td>{{ $article->user->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($article->tanggal)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('guru.artikel-siswa.show', $article->id_artikel) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('guru.artikel-siswa.approve', $article->id_artikel) }}" method="POST" style="display: inline;" onsubmit="return confirm('Setujui artikel ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('guru.artikel-siswa.reject', $article->id_artikel) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tolak artikel ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $student_articles->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Tidak ada artikel siswa yang menunggu persetujuan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection