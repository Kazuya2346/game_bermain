@extends('layouts.admin')

@section('title', 'Detail User - ' . $user->name)

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-user text-primary me-2"></i>Detail User
            </h1>
            <p class="text-muted small mb-0">Informasi lengkap pengguna {{ $user->name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Profile Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-id-card me-2"></i>Profil User
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="avatar-circle mx-auto mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white font-weight-bold" 
                            style="width: 120px; height: 120px; font-size: 3rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                        @if($user->class_id)
                            <span class="badge bg-info">Kelas {{ $user->class_id }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- User Details -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Detail
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">ID User</label>
                            <div class="form-control bg-light">{{ $user->id }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="form-control bg-light">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <div class="form-control bg-light">
                                <span class="badge 
                                    @if($user->role == 'admin') bg-purple text-white
                                    @elseif($user->role == 'ustadz') bg-info
                                    @elseif($user->role == 'ustadzah') bg-pink text-white
                                    @elseif($user->role == 'santri_putra') bg-primary
                                    @elseif($user->role == 'santri_putri') bg-danger
                                    @else bg-success
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kelas</label>
                            <div class="form-control bg-light">
                                {{ $user->class_id ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Dibuat Pada</label>
                            <div class="form-control bg-light">
                                {{ $user->created_at->format('d M Y H:i:s') }}
                                <small class="text-muted d-block">({{ $user->created_at->diffForHumans() }})</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Diupdate Pada</label>
                            <div class="form-control bg-light">
                                {{ $user->updated_at->format('d M Y H:i:s') }}
                                <small class="text-muted d-block">({{ $user->updated_at->diffForHumans() }})</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit User
                </a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                        <i class="fas fa-trash me-2"></i>Hapus User
                    </button>
                </form>
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

.bg-purple {
    background-color: #6f42c1 !important;
}
.bg-pink {
    background-color: #e83e8c !important;
}
</style>
@endsection