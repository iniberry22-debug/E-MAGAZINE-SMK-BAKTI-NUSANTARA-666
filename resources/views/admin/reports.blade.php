@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Artikel Published</h1>
        <div>
            <a href="{{ route('admin.reports.export') }}" class="btn btn-primary" target="_blank">
                <i class="fas fa-print"></i> Print/PDF
            </a>
            <a href="{{ route('admin.reports.excel') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Artikel Bulan Ini -->
        <div class="col-xl-3 col-lg-3">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Artikel Published Bulan Ini</h6>
                </div>
                <div class="card-body text-center">
                    <div class="h2 mb-0 font-weight-bold text-primary">{{ $thisMonthPublished }}</div>
                    <div class="text-xs font-weight-bold text-gray-500 text-uppercase">Artikel</div>
                </div>
            </div>
        </div>
        
        <!-- Poster Bulan Ini -->
        <div class="col-xl-3 col-lg-3">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Poster Published Bulan Ini</h6>
                </div>
                <div class="card-body text-center">
                    <div class="h2 mb-0 font-weight-bold text-success">{{ $thisMonthPosters }}</div>
                    <div class="text-xs font-weight-bold text-gray-500 text-uppercase">Poster</div>
                </div>
            </div>
        </div>

        <!-- Artikel per Bulan -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Artikel Published per Bulan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Jumlah Artikel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($publishedByMonth as $data)
                                <tr>
                                    <td>{{ DateTime::createFromFormat('!m', $data->month)->format('F') }}</td>
                                    <td>{{ $data->year }}</td>
                                    <td><span class="badge badge-primary">{{ $data->total }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $publishedByMonth->appends(request()->query())->links('custom.pagination') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Artikel per Kategori -->
    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Artikel Published per Kategori</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Jumlah Artikel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($publishedByCategory as $data)
                                <tr>
                                    <td>{{ $data->nama_kategori }}</td>
                                    <td><span class="badge badge-success">{{ $data->total }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">Belum ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $publishedByCategory->appends(request()->query())->links('custom.pagination') }}
                </div>
            </div>
        </div>

        <!-- Artikel Terbaru -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Artikel Published Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPublished as $article)
                                <tr>
                                    <td>{{ Str::limit($article->judul, 30) }}</td>
                                    <td>{{ $article->kategori->nama_kategori ?? 'Tanpa Kategori' }}</td>
                                    <td>{{ $article->created_at ? $article->created_at->format('d/m/Y') : ($article->tanggal ? $article->tanggal->format('d/m/Y') : 'N/A') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada artikel</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $recentPublished->appends(request()->query())->links('custom.pagination') }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Poster Terbaru -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Poster Published Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPosters as $poster)
                                <tr>
                                    <td>{{ Str::limit($poster->judul, 40) }}</td>
                                    <td><span class="badge badge-success">{{ $poster->kategori }}</span></td>
                                    <td>{{ $poster->user->nama ?? 'Unknown' }}</td>
                                    <td>{{ $poster->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada poster</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $recentPosters->appends(request()->query())->links('custom.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection