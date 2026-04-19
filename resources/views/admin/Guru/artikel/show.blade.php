@extends('admin.layouts.app')
@section('title', 'Detail Artikel')
@section('page-title', 'Detail Artikel')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">{{ $artikel->judul }}</h6>
        <div class="d-flex gap-2">
            <a href="{{ route('guru.artikel.edit', $artikel->id_artikel) }}" class="btn btn-warning btn-sm" style="border-radius:8px;">Edit</a>
            <a href="{{ route('guru.artikel.index') }}" class="btn btn-secondary btn-sm" style="border-radius:8px;">Kembali</a>
        </div>
    </div>
    <div class="card-body">
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
        <div class="row mb-3">
            <div class="col-md-2 text-muted fw-semibold">Isi</div>
            <div class="col-md-10" style="line-height:1.8;">{!! nl2br(e($artikel->isi)) !!}</div>
        </div>
        <div class="row">
            <div class="col-md-2 text-muted fw-semibold">Komentar</div>
            <div class="col-md-10">{{ $artikel->comments->count() }} komentar</div>
        </div>
    </div>
</div>
@endsection
