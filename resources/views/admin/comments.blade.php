@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Komentar</h1>
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Komentar</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                        <tr>
                            <td>{{ $comments->firstItem() + $loop->index }}</td>
                            <td>
                                @if($comment->artikel)
                                    <strong>{{ $comment->artikel->judul }}</strong>
                                @else
                                    <span class="text-muted">Artikel tidak ditemukan</span>
                                @endif
                            </td>
                            <td>{{ $comment->name }}</td>
                            <td>{{ $comment->email }}</td>
                            <td>
                                <div style="max-width: 300px;">
                                    {{ Str::limit($comment->comment, 100) }}
                                </div>
                            </td>
                            <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada komentar</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $comments->links('custom.pagination') }}
        </div>
    </div>
</div>
@endsection