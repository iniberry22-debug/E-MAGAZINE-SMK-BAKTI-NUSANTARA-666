@extends('admin.layouts.app')
@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Daftar Kategori</h6>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm" style="border-radius:8px;">
            <i class="bi bi-plus me-1"></i>Tambah Kategori
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $i => $kat)
                    <tr>
                        <td class="ps-4">{{ $kategoris->firstItem() + $i }}</td>
                        <td>{{ $kat->nama_kategori }}</td>
                        <td>{{ Str::limit($kat->deskripsi, 50) ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.kategori.edit', $kat->id_kategori) }}" class="btn btn-warning btn-action me-1">Edit</a>
                            <form action="{{ route('admin.kategori.destroy', $kat->id_kategori) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-action">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $kategoris->links() }}</div>
    </div>
</div>
@endsection
