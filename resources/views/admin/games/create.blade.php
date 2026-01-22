@extends('layouts.admin')

@section('title', 'Tambah Game Baru')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Tambah Game Baru</h1>
            <p class="text-muted small mb-0">Buat game pembelajaran baru untuk santri</p>
        </div>
        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-xl-8 col-lg-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-gamepad me-2"></i>Form Tambah Game
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.games.store') }}" method="POST">
                        @csrf

                        <!-- Title Input -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold text-dark">
                                <i class="fas fa-heading text-primary me-2"></i>Judul Game
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title') }}" 
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
                                <option value="" disabled selected>-- Pilih Tipe Game --</option>
                                <option value="tebak_gambar" {{ old('type') == 'tebak_gambar' ? 'selected' : '' }}>
                                    🖼️ Tebak Kosakata dari Gambar
                                </option>
                                <option value="kosakata_tempat" {{ old('type') == 'kosakata_tempat' ? 'selected' : '' }}>
                                    📍 Kosakata di 30 Tempat
                                </option>
                                <option value="pilihan_ganda" {{ old('type') == 'pilihan_ganda' ? 'selected' : '' }}>
                                    ✅ Pilihan Ganda Melengkapi Kalimat
                                </option>
                                <option value="percakapan" {{ old('type') == 'percakapan' ? 'selected' : '' }}>
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
                                      placeholder="Jelaskan tentang game ini, tujuan pembelajaran, dan hal-hal yang akan dipelajari santri...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Tambahkan deskripsi untuk memberikan informasi lebih detail tentang game
                            </small>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-info border-0 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-lightbulb fa-2x text-info me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1 fw-bold">Tips:</h6>
                                    <p class="mb-0 small">Setelah membuat game, Anda bisa menambahkan pertanyaan-pertanyaan di halaman detail game.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('admin.games.index') }}" class="btn btn-light px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <i class="fas fa-save me-2"></i>Simpan Game
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card border-0 bg-light mt-4">
                <div class="card-body">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="fas fa-question-circle text-primary me-2"></i>Bantuan
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong class="d-block">Judul Game</strong>
                                    <small class="text-muted">Gunakan nama yang jelas dan mudah dipahami</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                <div>
                                    <strong class="d-block">Tipe Game</strong>
                                    <small class="text-muted">Sesuaikan dengan metode pembelajaran yang diinginkan</small>
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
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

.form-control:focus,
.form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.card {
    transition: transform 0.2s;
}

.btn-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #224abe 0%, #1a3a9e 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(78, 115, 223, 0.4);
}

.alert-info {
    background-color: #d1ecf1;
    border-left: 4px solid #0dcaf0;
}

.gap-2 {
    gap: 0.5rem;
}
</style>
@endsection