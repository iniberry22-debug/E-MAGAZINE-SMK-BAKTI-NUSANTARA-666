@extends('layouts.siswa')
@section('title', 'Detail Artikel')
@section('page-title', 'Detail Artikel')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">{{ $artikel->judul }}</h6>
        <a href="{{ route('siswa.artikel.index') }}" class="btn btn-secondary btn-sm" style="border-radius:8px;">Kembali</a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3 text-muted fw-semibold">Status</div>
            <div class="col-md-9"><span class="badge-status-{{ $artikel->status }}">{{ ucfirst($artikel->status) }}</span></div>
        </div>
        @if($artikel->catatan_review)
        <div class="row mb-3">
            <div class="col-md-3 text-muted fw-semibold">Catatan Review</div>
            <div class="col-md-9"><div class="alert alert-warning mb-0" style="border-radius:8px;">{{ $artikel->catatan_review }}</div></div>
        </div>
        @endif
        <div class="row mb-3">
            <div class="col-md-3 text-muted fw-semibold">Kategori</div>
            <div class="col-md-9">{{ $artikel->kategori->nama_kategori ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 text-muted fw-semibold">Tanggal</div>
            <div class="col-md-9">{{ \Carbon\Carbon::parse($artikel->tanggal)->format('d F Y') }}</div>
        </div>
        @if($artikel->foto)
        <div class="row mb-3">
            <div class="col-md-3 text-muted fw-semibold">Foto</div>
            <div class="col-md-9"><img src="{{ asset('uploads/'.$artikel->foto) }}" style="max-height:200px; border-radius:10px;"></div>
        </div>
        @endif
        <div class="row mb-3">
            <div class="col-md-3 text-muted fw-semibold">Isi Artikel</div>
            <div class="col-md-9" style="line-height:1.8;">{!! nl2br(e($artikel->isi)) !!}</div>
        </div>
        @if(in_array($artikel->status, ['draft','rejected']))
        <a href="{{ route('siswa.artikel.edit', $artikel->id_artikel) }}" class="btn btn-warning">Edit Artikel</a>
        @endif
    </div>
</div>
@endsection
