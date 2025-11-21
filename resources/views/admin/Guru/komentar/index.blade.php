@extends('admin.layouts.app-guru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Komentar Artikel</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Artikel</th>
                            <th>Komentator</th>
                            <th>Isi Komentar</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                        @php
                            $artikel = \DB::table('artikel')->where('id_artikel', $comment->content_id)->first();
                        @endphp
                        <tr>
                            <td>{{ $comments->firstItem() + $loop->index }}</td>
                            <td>
                                <strong>{{ $artikel->judul ?? 'Artikel tidak ditemukan' }}</strong>
                                <br><small class="text-muted">ID: {{ $comment->content_id }}</small>
                            </td>
                            <td>
                                <strong>{{ $comment->name }}</strong>
                                <br><small class="text-muted">{{ $comment->email }}</small>
                            </td>
                            <td>
                                <div style="max-width: 300px;">
                                    {{ $comment->comment }}
                                </div>
                            </td>
                            <td>{{ date('d/m/Y H:i', strtotime($comment->created_at)) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada komentar</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $comments->links('custom.pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection