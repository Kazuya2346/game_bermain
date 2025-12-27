@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Users Management</h1>
            <p class="text-muted small mb-0">Kelola pengguna sistem pembelajaran</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.edit.bulk') }}" class="btn btn-warning btn-lg shadow-sm">
                <i class="fas fa-users-cog me-2"></i>Edit Massal
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-user-plus me-2"></i>Tambah Pengguna Baru
            </a>
        </div>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Santri</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->whereIn('role', ['santri_putra', 'santri_putri'])->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ustadz/Ustadzah</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $users->whereIn('role', ['ustadz', 'ustadzah'])->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Admin</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('role', 'admin')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.users.edit.bulk') }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-users-cog me-1"></i>Edit Massal
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-user-plus me-1"></i>Tambah User
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">ID</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Nama</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Email</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Role</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Kelas</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="align-middle">
                                <td class="px-4 py-3">
                                    <span class="badge bg-secondary">{{ $user->id }}</span>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white font-weight-bold" 
                                                style="width: 40px; height: 40px; font-size: 16px;
                                                @if($user->role == 'admin') background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                                @elseif($user->role == 'ustadz') background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                                                @elseif($user->role == 'ustadzah') background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
                                                @elseif($user->role == 'santri_putra') background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                                @elseif($user->role == 'santri_putri') background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                                                @else background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
                                                @endif">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                            <small class="text-muted">Terdaftar: {{ $user->created_at->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-muted me-2"></i>
                                        <span class="text-muted">{{ $user->email }}</span>
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <span class="badge px-3 py-2
                                        @if($user->role == 'admin') bg-purple text-white
                                        @elseif($user->role == 'ustadz') bg-info
                                        @elseif($user->role == 'ustadzah') bg-pink text-white
                                        @elseif($user->role == 'santri_putra') bg-primary
                                        @elseif($user->role == 'santri_putri') bg-danger
                                        @else bg-success
                                        @endif">
                                        <i class="fas 
                                            @if($user->role == 'admin') fa-user-shield
                                            @elseif($user->role == 'ustadz') fa-chalkboard-teacher
                                            @elseif($user->role == 'ustadzah') fa-chalkboard-teacher
                                            @elseif($user->role == 'santri_putra') fa-user-graduate
                                            @elseif($user->role == 'santri_putri') fa-user-graduate
                                            @else fa-user
                                            @endif me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    @if($user->class_id)
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-school me-1"></i>
                                            Kelas {{ $user->class_id }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- View Button -->
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada pengguna</h5>
                                        <p class="text-muted">Mulai tambahkan pengguna ke sistem!</p>
                                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-user-plus me-2"></i>Tambah Pengguna Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}
.border-left-success {
    border-left: 4px solid #1cc88a !important;
}
.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}
.border-left-info {
    border-left: 4px solid #36b9cc !important;
}
.bg-purple {
    background-color: #6f42c1 !important;
}
.bg-pink {
    background-color: #e83e8c !important;
}
.card {
    transition: transform 0.2s;
}
.table tbody tr:hover {
    background-color: #f8f9fc;
    transition: background-color 0.2s;
}
.btn-group .btn {
    margin: 0 2px;
}
.avatar-circle {
    transition: transform 0.2s;
}
.avatar-circle:hover {
    transform: scale(1.1);
}
</style>
@endsection