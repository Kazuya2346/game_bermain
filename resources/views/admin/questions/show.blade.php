@extends('layouts.admin')

@section('title', 'Detail Pertanyaan')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Detail Pertanyaan</h1>
            <p class="text-muted small mb-0">Informasi lengkap pertanyaan game</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-warning shadow-sm">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.games.show', $question->game) }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Game Info Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-primary py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-gamepad me-2"></i>Game Terkait
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('admin.games.show', $question->game) }}" class="text-decoration-none">
                                <h5 class="text-primary mb-2 fw-bold">{{ $question->game->title }}</h5>
                            </a>
                            <span class="badge 
                                @if($question->game->type == 'tebak_gambar') bg-info
                                @elseif($question->game->type == 'kosakata_tempat') bg-success
                                @elseif($question->game->type == 'pilihan_ganda') bg-warning text-dark
                                @else bg-purple
                                @endif px-3 py-2">
                                <i class="fas 
                                    @if($question->game->type == 'tebak_gambar') fa-image
                                    @elseif($question->game->type == 'kosakata_tempat') fa-map-marker-alt
                                    @elseif($question->game->type == 'pilihan_ganda') fa-list-ul
                                    @else fa-puzzle-piece
                                    @endif me-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $question->game->type)) }}
                            </span>
                        </div>
                        <a href="{{ route('admin.games.show', $question->game) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i>Lihat Game
                        </a>
                    </div>
                </div>
            </div>

            <!-- Question Text Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-question-circle me-2 text-primary"></i>Pertanyaan
                    </h6>
                </div>
                <div class="card-body p-4">
                    <p class="h5 text-dark mb-0">{{ $question->question_text }}</p>
                </div>
            </div>

            <!-- Image Card -->
            @if($question->image_path)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="m-0 font-weight-bold text-dark">
                            <i class="fas fa-image me-2 text-info"></i>Gambar Pertanyaan
                        </h6>
                    </div>
                    <div class="card-body p-4 text-center">
                        <img src="{{ asset('storage/' . $question->image_path) }}" 
                             alt="Question Image" 
                             class="img-fluid rounded shadow-sm"
                             style="max-width: 500px; max-height: 400px; object-fit: contain;">
                    </div>
                </div>
            @endif

            <!-- Correct Answer Card -->
            <div class="card shadow-sm border-0 border-start border-success border-4 mb-4">
                <div class="card-header bg-success-soft py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-check-circle me-2"></i>Jawaban Benar
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-success text-white me-3">
                            <i class="fas fa-check"></i>
                        </div>
                        <h4 class="text-success mb-0 fw-bold">{{ $question->correct_answer }}</h4>
                    </div>
                </div>
            </div>

            <!-- Options Card -->
            @if($question->options && count($question->options) > 0)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="m-0 font-weight-bold text-dark">
                            <i class="fas fa-list-ul me-2 text-warning"></i>Pilihan Jawaban
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="list-group list-group-flush">
                            @foreach($question->options as $index => $option)
                                <div class="list-group-item border-0 px-0 py-3 {{ $option == $question->correct_answer ? 'bg-success-soft' : '' }}">
                                    <div class="d-flex align-items-center">
                                        <div class="option-number {{ $option == $question->correct_answer ? 'bg-success text-white' : 'bg-light text-dark' }} me-3">
                                            {{ chr(65 + $index) }}
                                        </div>
                                        <span class="fs-5 {{ $option == $question->correct_answer ? 'fw-bold text-success' : 'text-dark' }}">
                                            {{ $option }}
                                        </span>
                                        @if($option == $question->correct_answer)
                                            <span class="badge bg-success ms-auto">
                                                <i class="fas fa-check me-1"></i>Benar
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Location Card -->
            @if($question->location_name)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="m-0 font-weight-bold text-dark">
                            <i class="fas fa-map-marker-alt me-2 text-danger"></i>Lokasi
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-danger text-white me-3">
                                <i class="fas fa-map-pin"></i>
                            </div>
                            <h5 class="text-dark mb-0">{{ $question->location_name }}</h5>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-info-circle me-2 text-info"></i>Informasi Tambahan
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-calendar-plus me-1"></i>Dibuat
                            </small>
                            <span class="text-dark fw-semibold">{{ $question->created_at->format('d F Y, H:i') }} WIB</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-calendar-check me-1"></i>Terakhir Diupdate
                            </small>
                            <span class="text-dark fw-semibold">{{ $question->updated_at->format('d F Y, H:i') }} WIB</span>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block mb-1">
                                <i class="fas fa-hashtag me-1"></i>ID Pertanyaan
                            </small>
                            <span class="badge bg-secondary">{{ $question->id }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.games.show', $question->game) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Game
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Pertanyaan
                            </a>
                            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus pertanyaan ini?')">
                                    <i class="fas fa-trash-alt me-2"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

.bg-purple {
    background-color: #6f42c1 !important;
}

.bg-success-soft {
    background-color: #d1f2e8 !important;
}

.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.option-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
}

.list-group-item {
    transition: background-color 0.2s;
}

.list-group-item:hover {
    background-color: #f8f9fc !important;
}

.card {
    transition: transform 0.2s;
}

.gap-2 {
    gap: 0.5rem;
}

.border-start {
    border-left-width: 4px !important;
}
</style>
@endsection