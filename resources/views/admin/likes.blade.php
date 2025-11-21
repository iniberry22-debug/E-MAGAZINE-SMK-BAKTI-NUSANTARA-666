@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Likes</h1>
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
                            <th>User</th>
                            <th>IP Address</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($likes as $like)
                        <tr>
                            <td>{{ $likes->firstItem() + $loop->index }}</td>
                            <td>
                                @if($like->artikel_id)
                                    @php
                                        $artikel = \App\Models\Artikel::find($like->artikel_id);
                                    @endphp
                                    @if($artikel)
                                        <strong>{{ $artikel->judul }}</strong>
                                    @else
                                        <span class="text-muted">Artikel tidak ditemukan</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($like->user_id)
                                    @php
                                        $user = \App\Models\User::find($like->user_id);
                                    @endphp
                                    {{ $user->nama ?? 'User tidak ditemukan' }}
                                @else
                                    <span class="text-muted">Guest</span>
                                @endif
                            </td>
                            <td>{{ $like->ip_address }}</td>
                            <td>{{ $like->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada likes</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $likes->links('custom.pagination') }}
        </div>
    </div>
</div>
@endsection