@extends('layouts.admin')

@section('title', 'Detail Game')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Detail Game</h1>
            <p class="text-muted small mb-0">Informasi lengkap dan manajemen pertanyaan game</p>
        </div>
        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>

    <!-- Game Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-info py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0 font-weight-bold text-white">
                            <i class="fas fa-gamepad me-2"></i>{{ $game->title }}
                        </h5>
                        <div class="d-flex gap-2">
                            <!-- Toggle Status Button -->
                            <form action="{{ route('admin.games.toggleStatus', $game) }}" method="POST" class="d-inline">
                                @csrf
                                @if($game->status == 'published')
                                    <button type="submit" class="btn btn-light btn-sm" title="Jadikan Draft">
                                        <i class="fas fa-arrow-down me-1"></i>Unpublish
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-success btn-sm" title="Publish">
                                        <i class="fas fa-rocket me-1"></i>Publish
                                    </button>
                                @endif
                            </form>
                            <a href="{{ route('admin.games.edit', $game) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit Game
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6 mb-3">
                            <div class="info-item mb-4">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-tag me-1"></i>TIPE GAME
                                </label>
                                <div>
                                    <span class="badge 
                                        @if($game->type == 'tebak_gambar') bg-info
                                        @elseif($game->type == 'kosakata_tempat') bg-success
                                        @elseif($game->type == 'pilihan_ganda') bg-warning text-dark
                                        @else bg-purple
                                        @endif px-3 py-2 fs-6">
                                        <i class="fas 
                                            @if($game->type == 'tebak_gambar') fa-image
                                            @elseif($game->type == 'kosakata_tempat') fa-map-marker-alt
                                            @elseif($game->type == 'pilihan_ganda') fa-list-ul
                                            @else fa-puzzle-piece
                                            @endif me-2"></i>
                                        {{ ucfirst(str_replace('_', ' ', $game->type)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="info-item mb-4">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-user me-1"></i>DIBUAT OLEH
                                </label>
                                <div class="d-flex align-items-center">
                                    @if($game->creator)
                                        <div class="avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <strong>{{ strtoupper(substr($game->creator->name, 0, 1)) }}</strong>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $game->creator->name }}</div>
                                            <small class="text-muted">{{ $game->creator->email }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic">
                                            <i class="fas fa-user-slash me-1"></i>Unknown
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-item">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-info-circle me-1"></i>STATUS
                                </label>
                                <div>
                                    @if($game->status == 'published')
                                        <span class="badge bg-success px-3 py-2 fs-6">
                                            <i class="fas fa-check-circle me-1"></i>Published
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 fs-6">
                                            <i class="fas fa-file-alt me-1"></i>Draft
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6 mb-3">
                            <div class="info-item mb-4">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-clock me-1"></i>TANGGAL DIBUAT
                                </label>
                                <div class="text-dark fw-semibold">
                                    {{ $game->created_at->format('d F Y, H:i') }} WIB
                                </div>
                            </div>

                            <div class="info-item mb-4">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-sync me-1"></i>TERAKHIR DIUPDATE
                                </label>
                                <div class="text-dark fw-semibold">
                                    {{ $game->updated_at->format('d F Y, H:i') }} WIB
                                    <small class="text-muted">({{ $game->updated_at->diffForHumans() }})</small>
                                </div>
                            </div>

                            <div class="info-item">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-align-left me-1"></i>DESKRIPSI
                                </label>
                                <div class="text-dark">
                                    {{ $game->description ?? '— Tidak ada deskripsi —' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-question-circle me-2"></i>Daftar Pertanyaan
                            </h6>
                            <small class="text-muted">Total: {{ $game->questions->count() }} pertanyaan</small>
                        </div>
                        <a href="{{ route('admin.questions.create', ['game_id' => $game->id]) }}" class="btn btn-success shadow-sm">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Pertanyaan
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($game->questions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3 text-muted text-uppercase small" style="width: 5%;">No</th>
                                        <th class="border-0 px-4 py-3 text-muted text-uppercase small" style="width: 40%;">Pertanyaan</th>
                                        <th class="border-0 px-4 py-3 text-muted text-uppercase small" style="width: 25%;">Jawaban Benar</th>
                                        <th class="border-0 px-4 py-3 text-muted text-uppercase small" style="width: 15%;">Lokasi</th>
                                        <th class="border-0 px-4 py-3 text-muted text-uppercase small text-center" style="width: 15%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($game->questions as $index => $question)
                                        <tr class="align-middle">
                                            <td class="px-4 py-3">
                                                <span class="badge bg-secondary">{{ $index + 1 }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="fw-bold text-dark">{{ $question->question_text }}</div>
                                                @if($question->image_url)
                                                    <small class="text-muted">
                                                        <i class="fas fa-image me-1"></i>Dengan gambar
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="badge bg-success-soft text-success px-3 py-2">
                                                    <i class="fas fa-check-circle me-1"></i>{{ $question->correct_answer }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($question->location_name)
                                                    <small class="text-muted">
                                                        <i class="fas fa-map-marker-alt me-1 text-danger"></i>{{ $question->location_name }}
                                                    </small>
                                                @else
                                                    <small class="text-muted">—</small>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.questions.edit', $question) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-danger" 
                                                                title="Hapus" 
                                                                onclick="return confirm('Yakin ingin menghapus pertanyaan ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="py-4">
                                <i class="fas fa-question-circle fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum Ada Pertanyaan</h5>
                                <p class="text-muted mb-4">Game ini belum memiliki pertanyaan. Tambahkan pertanyaan untuk memulai!</p>
                                <a href="{{ route('admin.questions.create', ['game_id' => $game->id]) }}" class="btn btn-success shadow-sm">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Pertanyaan Pertama
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                @if($game->questions->count() > 0)
                    <div class="card-footer bg-light py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>Menampilkan {{ $game->questions->count() }} pertanyaan
                            </small>
                            <a href="{{ route('admin.questions.create', ['game_id' => $game->id]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-plus me-1"></i>Tambah Lagi
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-danger shadow-sm">
                <div class="card-header bg-danger text-white py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Hapus Game Ini</h6>
                            <p class="text-muted small mb-0">Sekali dihapus, data tidak dapat dikembalikan. Semua pertanyaan juga akan terhapus.</p>
                        </div>
                        <form action="{{ route('admin.games.destroy', $game) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger shadow-sm" onclick="return confirm('⚠️ PERINGATAN!\n\nYakin ingin menghapus game \"{{ $game->title }}\"?\n\nSemua data berikut akan terhapus PERMANEN:\n- Game ini\n- {{ $game->questions->count() }} pertanyaan\n- Semua data terkait\n\nTindakan ini TIDAK DAPAT dibatalkan!')">
                                <i class="fas fa-trash-alt me-2"></i>Hapus Game
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-info {
    background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
}

.bg-purple {
    background-color: #6f42c1 !important;
}

.bg-success-soft {
    background-color: #d1f2e8 !important;
}

.info-item {
    padding-bottom: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.info-item:last-child {
    border-bottom: none;
}

.table tbody tr:hover {
    background-color: #f8f9fc;
    transition: background-color 0.2s;
}

.btn-group .btn {
    margin: 0 2px;
}

.card {
    transition: transform 0.2s;
}

.gap-2 {
    gap: 0.5rem;
}

.avatar-sm {
    font-size: 18px;
}
</style>
@endsection