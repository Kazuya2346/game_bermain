@extends('layouts.admin')

@section('title', 'Manage Games')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Games Management</h1>
            <p class="text-muted small mb-0">Kelola semua game pembelajaran</p>
        </div>
        <a href="{{ route('admin.games.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus-circle me-2"></i>Tambah Game Baru
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error!</strong> {{ session('error') }}
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Games</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $games->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-gamepad fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Published</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $games->where('status', 'published')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Draft</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $games->where('status', 'draft')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-edit fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Questions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $games->sum(function($game) { return $game->questions->count(); }) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Games Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Games</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">ID</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Judul Game</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Tipe</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Dibuat Oleh</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Jumlah Soal</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Status</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($games as $game)
                            <tr class="align-middle">
                                <td class="px-4 py-3">
                                    <span class="badge bg-secondary">{{ $game->id }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="game-icon me-3">
                                            <i class="fas fa-gamepad text-primary fa-lg"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $game->title }}</div>
                                            <small class="text-muted">Dibuat: {{ $game->created_at->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge 
                                        @if($game->type == 'tebak_gambar') bg-info
                                        @elseif($game->type == 'kosakata_tempat') bg-success
                                        @elseif($game->type == 'pilihan_ganda') bg-warning text-dark
                                        @else bg-purple
                                        @endif px-3 py-2">
                                        <i class="fas 
                                            @if($game->type == 'tebak_gambar') fa-image
                                            @elseif($game->type == 'kosakata_tempat') fa-map-marker-alt
                                            @elseif($game->type == 'pilihan_ganda') fa-list-ul
                                            @else fa-puzzle-piece
                                            @endif me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $game->type)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($game->creator)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px;">
                                                {{ strtoupper(substr($game->creator->name, 0, 1)) }}
                                            </div>
                                            <span>{{ $game->creator->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic">
                                            <i class="fas fa-user-slash me-1"></i>Unknown
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-question-circle me-1"></i>
                                        {{ $game->questions->count() }} soal
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($game->status == 'published')
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i>Published
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">
                                            <i class="fas fa-file-alt me-1"></i>Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Toggle Status Button -->
                                        <form action="{{ route('admin.games.toggleStatus', $game) }}" method="POST" class="d-inline">
                                            @csrf
                                            @if($game->status == 'published')
                                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Jadikan Draft">
                                                    <i class="fas fa-arrow-down"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Publish">
                                                    <i class="fas fa-rocket"></i>
                                                </button>
                                            @endif
                                        </form>

                                        <!-- View Button -->
                                        <a href="{{ route('admin.games.show', $game) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.games.edit', $game) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.games.destroy', $game) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus game ini? Semua soal di dalamnya juga akan terhapus.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="fas fa-gamepad fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada game</h5>
                                        <p class="text-muted">Mulai buat game pembelajaran pertama Anda!</p>
                                        <a href="{{ route('admin.games.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus-circle me-2"></i>Buat Game Baru
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
            {{ $games->links() }}
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
</style>
@endsection