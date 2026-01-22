@extends('layouts.admin')

@section('title', 'Edit Game')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Edit Game</h1>
            <p class="text-muted small mb-0">Perbarui informasi game pembelajaran</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.games.show', $game) }}" class="btn btn-info shadow-sm">
                <i class="fas fa-eye me-2"></i>Lihat Detail
            </a>
            <a href="{{ route('admin.games.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Current Game Info Alert -->
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-10 mx-auto">
            <div class="alert alert-primary border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-2x me-3"></i>
                    <div>
                        <h6 class="alert-heading mb-1 fw-bold">Sedang Mengedit:</h6>
                        <p class="mb-0">
                            <strong>{{ $game->title }}</strong> 
                            <span class="badge bg-white text-primary ms-2">ID: {{ $game->id }}</span>
                            <span class="badge 
                                @if($game->type == 'tebak_gambar') bg-info
                                @elseif($game->type == 'kosakata_tempat') bg-success
                                @elseif($game->type == 'pilihan_ganda') bg-warning text-dark
                                @else bg-purple
                                @endif ms-2">
                                {{ ucfirst(str_replace('_', ' ', $game->type)) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-xl-8 col-lg-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-warning py-3">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-edit me-2"></i>Form Edit Game
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.games.update', $game) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title Input -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold text-dark">
                                <i class="fas fa-heading text-primary me-2"></i>Judul Game
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title', $game->title) }}" 
                                   class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   placeholder="Contoh: Belajar Kosakata Hewan"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Masukkan judul yang menarik dan deskriptif
                            </small>
                        </div>

                        <!-- Type Select -->
                        <div class="mb-4">
                            <label for="type" class="form-label fw-bold text-dark">
                                <i class="fas fa-puzzle-piece text-success me-2"></i>Tipe Game
                                <span class="text-danger">*</span>
                            </label>
                            <select name="type" 
                                    id="type" 
                                    class="form-select form-select-lg @error('type') is-invalid @enderror" 
                                    required>
                                <option value="" disabled>-- Pilih Tipe Game --</option>
                                <option value="tebak_gambar" {{ old('type', $game->type) == 'tebak_gambar' ? 'selected' : '' }}>
                                    🖼️ Tebak Kosakata dari Gambar
                                </option>
                                <option value="kosakata_tempat" {{ old('type', $game->type) == 'kosakata_tempat' ? 'selected' : '' }}>
                                    📍 Kosakata di 30 Tempat
                                </option>
                                <option value="pilihan_ganda" {{ old('type', $game->type) == 'pilihan_ganda' ? 'selected' : '' }}>
                                    ✅ Pilihan Ganda Melengkapi Kalimat
                                </option>
                                <option value="percakapan" {{ old('type', $game->type) == 'percakapan' ? 'selected' : '' }}>
                                    💬 Percakapan di 20 Tempat
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Pilih tipe game yang sesuai dengan materi pembelajaran
                            </small>
                        </div>

                        <!-- Description Textarea -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold text-dark">
                                <i class="fas fa-align-left text-info me-2"></i>Deskripsi
                                <span class="text-muted small">(Opsional)</span>
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="5" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Jelaskan tentang game ini, tujuan pembelajaran, dan hal-hal yang akan dipelajari santri...">{{ old('description', $game->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Tambahkan deskripsi untuk memberikan informasi lebih detail tentang game
                            </small>
                        </div>

                        <!-- Warning Box -->
                        <div class="alert alert-warning border-0 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1 fw-bold">Perhatian:</h6>
                                    <p class="mb-0 small">Perubahan pada tipe game mungkin mempengaruhi pertanyaan yang sudah ada. Pastikan semua pertanyaan masih sesuai dengan tipe game yang baru.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <div>
                                <a href="{{ route('admin.games.index') }}" class="btn btn-light px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.games.show', $game) }}" class="btn btn-info px-4">
                                    <i class="fas fa-eye me-2"></i>Preview
                                </a>
                                <button type="submit" class="btn btn-warning px-5 shadow-sm">
                                    <i class="fas fa-save me-2"></i>Update Game
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Info Cards -->
            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fas fa-clock text-info me-2"></i>Informasi Waktu
                            </h6>
                            <div class="small">
                                <div class="mb-2">
                                    <strong>Dibuat:</strong> {{ $game->created_at->format('d M Y, H:i') }}
                                </div>
                                <div>
                                    <strong>Update Terakhir:</strong> {{ $game->updated_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-0 bg-light h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fas fa-chart-bar text-success me-2"></i>Statistik Game
                            </h6>
                            <div class="small">
                                <div class="mb-2">
                                    <strong>Total Soal:</strong> 
                                    <span class="badge bg-primary">{{ $game->questions->count() }}</span>
                                </div>
                                <div>
                                    <strong>Status:</strong> 
                                    @if($game->status == 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-warning {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
}

.bg-purple {
    background-color: #6f42c1 !important;
}

.form-control:focus,
.form-select:focus {
    border-color: #f6c23e;
    box-shadow: 0 0 0 0.2rem rgba(246, 194, 62, 0.25);
}

.card {
    transition: transform 0.2s;
}

.btn-warning {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
    border: none;
    color: #1f2937;
    font-weight: 600;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #dda20a 0%, #c7930a 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(246, 194, 62, 0.4);
    color: #1f2937;
}

.btn-info {
    background-color: #36b9cc;
    border: none;
}

.btn-info:hover {
    background-color: #2c9faf;
    transform: translateY(-2px);
}

.alert-primary {
    background-color: #cfe2ff;
    border-left: 4px solid #0d6efd;
}

.alert-warning {
    background-color: #fff3cd;
    border-left: 4px solid #f6c23e;
}

.gap-2 {
    gap: 0.5rem;
}
</style>
@endsection