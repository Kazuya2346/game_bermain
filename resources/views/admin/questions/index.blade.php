@extends('layouts.admin')

@section('title', 'Manage Questions')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Questions Management</h1>
            <p class="text-muted small mb-0">Kelola semua pertanyaan dalam game</p>
        </div>
        <a href="{{ route('admin.questions.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus-circle me-2"></i>Tambah Pertanyaan Baru
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pertanyaan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $questions->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-question-circle fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tebak Gambar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $questions->filter(function($q) { return $q->game && $q->game->type == 'tebak_gambar'; })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-image fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pilihan Ganda</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $questions->filter(function($q) { return $q->game && $q->game->type == 'pilihan_ganda'; })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list-ul fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Kosakata Tempat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $questions->filter(function($q) { return $q->game && $q->game->type == 'kosakata_tempat'; })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pertanyaan</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">ID</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Game</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Pertanyaan</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Jawaban Benar</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small">Lokasi</th>
                            <th class="border-0 px-4 py-3 text-muted text-uppercase small text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr class="align-middle">
                                <td class="px-4 py-3">
                                    <span class="badge bg-secondary">{{ $question->id }}</span>
                                </td>
                                
                                <td class="px-4 py-3">
                                    @if($question->game)
                                        <a href="{{ route('admin.games.show', $question->game) }}" class="text-decoration-none">
                                            <div class="d-flex align-items-center">
                                                <span class="badge 
                                                    @if($question->game->type == 'tebak_gambar') bg-info
                                                    @elseif($question->game->type == 'kosakata_tempat') bg-success
                                                    @elseif($question->game->type == 'pilihan_ganda') bg-warning text-dark
                                                    @else bg-purple
                                                    @endif me-2">
                                                    <i class="fas 
                                                        @if($question->game->type == 'tebak_gambar') fa-image
                                                        @elseif($question->game->type == 'kosakata_tempat') fa-map-marker-alt
                                                        @elseif($question->game->type == 'pilihan_ganda') fa-list-ul
                                                        @else fa-puzzle-piece
                                                        @endif"></i>
                                                </span>
                                                <span class="text-primary">{{ $question->game->title }}</span>
                                            </div>
                                        </a>
                                    @else
                                        <span class="text-danger fst-italic">
                                            <i class="fas fa-exclamation-triangle me-1"></i>(Game Terhapus)
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="question-text" style="max-width: 300px;">
                                        <p class="mb-0 text-truncate" title="{{ $question->question_text }}">
                                            <i class="fas fa-question-circle text-primary me-2"></i>
                                            {{ $question->question_text }}
                                        </p>
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check me-1"></i>
                                        {{ $question->correct_answer }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    @if($question->location_name)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-map-pin text-danger me-2"></i>
                                            <span class="text-muted">{{ $question->location_name }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <div class="btn-group" role="group">
                                        <!-- View Button -->
                                        <a href="{{ route('admin.questions.show', $question) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus pertanyaan ini?')">
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
                                        <i class="fas fa-question-circle fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum ada pertanyaan</h5>
                                        <p class="text-muted">Mulai buat pertanyaan untuk game Anda!</p>
                                        <a href="{{ route('admin.questions.create') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-plus-circle me-2"></i>Buat Pertanyaan Baru
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
            {{ $questions->links() }}
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
.question-text p {
    line-height: 1.5;
}
</style>
@endsection