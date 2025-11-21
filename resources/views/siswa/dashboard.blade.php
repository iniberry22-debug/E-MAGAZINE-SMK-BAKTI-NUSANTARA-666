@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2>Dashboard Siswa</h2>
            <p>Selamat datang, {{ Auth::user()->nama }}!</p>
        </div>
    </div>



    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Total Artikel</h5>
                    <h3>{{ $totalArtikel }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Artikel Published</h5>
                    <h3>{{ $artikelPublished }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5>Artikel Pending</h5>
                    <h3>{{ $artikelPending }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Artikel Approved</h5>
                    <h3>{{ $artikelApproved }}</h3>
                    <small>Menunggu publikasi</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5>Artikel Rejected</h5>
                    <h3>{{ $artikelRejected }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <a href="{{ route('siswa.artikel.create') }}" class="btn btn-light mb-2">
                        <i class="fas fa-plus"></i> Buat Artikel
                    </a>
                    <br>
                    <a href="{{ route('siswa.baca-artikel') }}" class="btn btn-outline-light">
                        <i class="fas fa-book-open"></i> Baca Artikel
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Artikel Saya</h5>
                    <a href="{{ route('siswa.artikel.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @if($artikelSaya->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($artikelSaya->take(5) as $artikel)
                                    <tr>
                                        <td>{{ $artikel->judul }}</td>
                                        <td>
                                            @if($artikel->status == 'published')
                                                <span class="badge bg-success">Published</span>
                                            @elseif($artikel->status == 'pending')
                                                <span class="badge bg-warning">Pending Review</span>
                                            @elseif($artikel->status == 'approved')
                                                <span class="badge bg-info">Approved - Menunggu Publikasi</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $artikel->tanggal->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('siswa.artikel.show', $artikel->id_artikel) }}" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('siswa.artikel.edit', $artikel->id_artikel) }}" class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Belum ada artikel. <a href="{{ route('siswa.artikel.create') }}">Buat artikel pertama Anda!</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection