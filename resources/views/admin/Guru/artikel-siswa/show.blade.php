@extends('admin.layouts.app')
@section('title', 'Detail Artikel Siswa')
@section('page-title', 'Detail Artikel Siswa')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">{{ $artikel->judul }}</h6>
        <a href="{{ route('guru.artikel-siswa.index') }}" class="btn btn-secondary btn-sm" style="border-radius:8px;">Kembali</a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-2 text-muted fw-semibold">Penulis</div>
            <div class="col-md-10">{{ $artikel->user->nama ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-2 text-muted fw-semibold">Status</div>
            <div class="col-md-10"><span class="badge-status-{{ $artikel->status }}">{{ ucfirst($artikel->status) }}</span></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-2 text-muted fw-semibold">Kategori</div>
            <div class="col-md-10">{{ $artikel->kategori->nama_kategori ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-2 text-muted fw-semibold">Tanggal</div>
            <div class="col-md-10">{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d F Y') }}</div>
        </div>
        @if($artikel->foto)
        <div class="row mb-3">
            <div class="col-md-2 text-muted fw-semibold">Foto</div>
            <div class="col-md-10"><img src="{{ asset('uploads/'.$artikel->foto) }}" style="max-height:200px; border-radius:10px;"></div>
        </div>
        @endif
        <div class="row mb-4">
            <div class="col-md-2 text-muted fw-semibold">Isi</div>
            <div class="col-md-10" style="line-height:1.8;">{!! nl2br(e($artikel->isi)) !!}</div>
        </div>

        @if($artikel->status == 'pending')
        <div class="d-flex gap-2">
            <form action="{{ route('guru.artikel-siswa.approve', $artikel->id_artikel) }}" method="POST" onsubmit="return confirm('Setujui artikel ini?')">
                @csrf
                <button class="btn btn-success"><i class="bi bi-check me-1"></i>Setujui</button>
            </form>
            <form action="{{ route('guru.artikel-siswa.reject', $artikel->id_artikel) }}" method="POST" onsubmit="return confirm('Tolak artikel ini?')">
                @csrf
                <div class="input-group">
                    <input type="text" name="catatan_review" class="form-control" placeholder="Alasan penolakan..." required>
                    <button class="btn btn-danger"><i class="bi bi-x me-1"></i>Tolak</button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
