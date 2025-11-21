@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reset Password User</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Reset Password Manual</h6>
                </div>
                <div class="card-body">
                    <p><strong>User:</strong> {{ $user->username }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                    
                    <form action="{{ route('admin.users.reset-password', $user->id_user) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                   id="new_password" name="new_password" required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" 
                                   id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-warning">Reset Password Otomatis</h6>
                </div>
                <div class="card-body">
                    <p>Generate password acak untuk user ini.</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Password yang di-generate akan ditampilkan sekali saja. Pastikan untuk mencatatnya!
                    </div>
                    
                    <form action="{{ route('admin.users.generate-password', $user->id_user) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin generate password acak untuk user ini?')">
                        @csrf
                        <button type="submit" class="btn btn-warning">Generate Password Acak</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection