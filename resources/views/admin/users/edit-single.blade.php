@extends('layouts.admin')

@section('title', 'Edit User - ' . $user->name)

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-user-edit text-primary me-2"></i>Edit User
            </h1>
            <p class="text-muted small mb-0">Edit data untuk user {{ $user->name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('admin.users.edit.bulk') }}" class="btn btn-primary">
                <i class="fas fa-users me-2"></i>Edit Massal
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error!</strong> Terdapat kesalahan pada form:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Informasi User
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user text-primary me-1"></i>Nama Lengkap
                                </label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Nama lengkap"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-envelope text-primary me-1"></i>Email
                                </label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="email@example.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-lock text-primary me-1"></i>Password
                                </label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Kosongkan jika tidak ingin mengubah">
                                <small class="text-muted">Minimal 8 karakter</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-lock text-primary me-1"></i>Konfirmasi Password
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="form-control"
                                       placeholder="Ulangi password">
                            </div>

                            <!-- Role -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user-tag text-primary me-1"></i>Role
                                </label>
                                <select name="role" 
                                        class="form-select @error('role') is-invalid @enderror"
                                        required>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="ustadz" {{ $user->role == 'ustadz' ? 'selected' : '' }}>Ustadz</option>
                                    <option value="ustadzah" {{ $user->role == 'ustadzah' ? 'selected' : '' }}>Ustadzah</option>
                                    <option value="santri_putra" {{ $user->role == 'santri_putra' ? 'selected' : '' }}>Santri Putra</option>
                                    <option value="santri_putri" {{ $user->role == 'santri_putri' ? 'selected' : '' }}>Santri Putri</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Class ID -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-school text-primary me-1"></i>Kelas (Opsional)
                                </label>
                                <input type="text" 
                                       name="class_id" 
                                       value="{{ old('class_id', $user->class_id) }}"
                                       class="form-control"
                                       placeholder="Contoh: 7A, Kelas B">
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="row mt-4 pt-4 border-top">
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <h6 class="fw-bold mb-2">
                                        <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                                    </h6>
                                    <p class="mb-1">
                                        <strong>ID User:</strong> {{ $user->id }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Dibuat:</strong> {{ $user->created_at->format('d M Y H:i') }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>Diupdate:</strong> {{ $user->updated_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Stats -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle mx-auto mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white font-weight-bold" 
                                style="width: 100px; height: 100px; font-size: 2.5rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        <h5 class="mb-1">{{ $user->name }}</h5>
                        <p class="text-muted small mb-0">{{ $user->email }}</p>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Role</span>
                            <span class="badge bg-primary">{{ $user->role }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Status</span>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                        @if($user->class_id)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Kelas</span>
                            <span class="badge bg-info">{{ $user->class_id }}</span>
                        </div>
                        @endif
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Terdaftar</span>
                            <span class="text-muted">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #5cb85c 0%, #4cae4c 100%);
}

.avatar-circle {
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
</style>
@endsection