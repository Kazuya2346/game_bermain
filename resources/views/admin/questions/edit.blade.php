@extends('layouts.admin')

@section('title', 'Edit Pertanyaan')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Edit Pertanyaan</h1>
            <p class="text-muted small mb-0">Perbarui informasi pertanyaan game</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.games.show', $question->game) }}" class="btn btn-info shadow-sm">
                <i class="fas fa-eye me-2"></i>Lihat Game
            </a>
            <a href="{{ route('admin.games.show', $question->game) }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Current Question Info -->
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-10 mx-auto">
            <div class="alert alert-warning border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-edit fa-2x text-warning me-3"></i>
                    <div>
                        <h6 class="alert-heading mb-1 fw-bold">Sedang Mengedit Pertanyaan:</h6>
                        <p class="mb-0">
                            <strong>{{ Str::limit($question->question_text, 60) }}</strong>
                            <span class="badge bg-secondary ms-2">ID: {{ $question->id }}</span>
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
                        <i class="fas fa-edit me-2"></i>Form Edit Pertanyaan
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Game Selection -->
                        <div class="mb-4">
                            <label for="game_id" class="form-label fw-bold text-dark">
                                <i class="fas fa-gamepad text-primary me-2"></i>Pilih Game
                                <span class="text-danger">*</span>
                            </label>
                            <select name="game_id" 
                                    id="game_id" 
                                    class="form-select form-select-lg @error('game_id') is-invalid @enderror" 
                                    required>
                                <option value="" disabled>-- Pilih Game --</option>
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}" {{ old('game_id', $question->game_id) == $game->id ? 'selected' : '' }}>
                                        {{ $game->title }} ({{ ucfirst(str_replace('_', ' ', $game->type)) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('game_id')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Question Text -->
                        <div class="mb-4">
                            <label for="question_text" class="form-label fw-bold text-dark">
                                <i class="fas fa-question-circle text-info me-2"></i>Teks Pertanyaan
                                <span class="text-danger">*</span>
                            </label>
                            <textarea name="question_text" 
                                      id="question_text" 
                                      rows="4" 
                                      class="form-control @error('question_text') is-invalid @enderror" 
                                      placeholder="Tulis pertanyaan di sini..."
                                      required>{{ old('question_text', $question->question_text) }}</textarea>
                            @error('question_text')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Buat pertanyaan yang jelas dan mudah dipahami
                            </small>
                        </div>

                        <!-- Current Image Preview -->
                        @if($question->image_path)
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">
                                    <i class="fas fa-image text-success me-2"></i>Gambar Saat Ini
                                </label>
                                <div class="card border-0 bg-light">
                                    <div class="card-body text-center p-3">
                                        <img src="{{ asset('storage/' . $question->image_path) }}" 
                                             alt="Current Question Image" 
                                             class="img-fluid rounded shadow-sm"
                                             style="max-height: 200px; object-fit: contain;">
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-check-circle text-success me-1"></i>Gambar tersimpan
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label for="image_path" class="form-label fw-bold text-dark">
                                <i class="fas fa-upload text-primary me-2"></i>{{ $question->image_path ? 'Ganti Gambar' : 'Upload Gambar' }}
                                <span class="text-muted small">(Opsional)</span>
                            </label>
                            <input type="file" 
                                   name="image_path" 
                                   id="image_path" 
                                   class="form-control @error('image_path') is-invalid @enderror" 
                                   accept="image/*">
                            @error('image_path')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Format: JPG, PNG, GIF. Max: 2MB
                            </small>
                        </div>

                        <!-- Correct Answer -->
                        <div class="mb-4">
                            <label for="correct_answer" class="form-label fw-bold text-dark">
                                <i class="fas fa-check-circle text-success me-2"></i>Jawaban Benar
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="correct_answer" 
                                   id="correct_answer" 
                                   value="{{ old('correct_answer', $question->correct_answer) }}" 
                                   class="form-control form-control-lg @error('correct_answer') is-invalid @enderror" 
                                   placeholder="Masukkan jawaban yang benar"
                                   required>
                            @error('correct_answer')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Options Section -->
                        <div class="mb-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary bg-opacity-10 py-3">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="has_options"
                                               {{ $question->options ? 'checked' : '' }}
                                               onchange="toggleOptions()">
                                        <label class="form-check-label fw-bold text-dark" for="has_options">
                                            <i class="fas fa-list-ul text-warning me-2"></i>
                                            Ini adalah pertanyaan pilihan ganda
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body p-4" id="options_container" style="display: {{ $question->options ? 'block' : 'none' }};">
                                    <label class="form-label fw-bold text-dark mb-3">
                                        <i class="fas fa-list-ol me-2"></i>Pilihan Jawaban
                                    </label>
                                    <div id="options_list">
                                        @if($question->options && count($question->options) > 0)
                                            @foreach($question->options as $index => $option)
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text bg-primary text-white fw-bold">{{ chr(65 + $index) }}</span>
                                                    <input type="text" 
                                                           name="options[]" 
                                                           value="{{ $option }}" 
                                                           class="form-control" 
                                                           placeholder="Pilihan {{ $index + 1 }}">
                                                </div>
                                            @endforeach
                                        @else
                                            @for($i = 0; $i < 4; $i++)
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text bg-primary text-white fw-bold">{{ chr(65 + $i) }}</span>
                                                    <input type="text" 
                                                           name="options[]" 
                                                           class="form-control" 
                                                           placeholder="Pilihan {{ $i + 1 }}">
                                                </div>
                                            @endfor
                                        @endif
                                    </div>
                                    @error('options')
                                        <div class="text-danger small mt-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Pastikan salah satu pilihan sama dengan jawaban benar di atas
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Location Name -->
                        <div class="mb-4">
                            <label for="location_name" class="form-label fw-bold text-dark">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>Nama Lokasi
                                <span class="text-muted small">(Opsional)</span>
                            </label>
                            <input type="text" 
                                   name="location_name" 
                                   id="location_name" 
                                   value="{{ old('location_name', $question->location_name) }}" 
                                   class="form-control @error('location_name') is-invalid @enderror" 
                                   placeholder="Contoh: Di Masjid, Di Sekolah, Di Pasar">
                            @error('location_name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Untuk game kosakata tempat atau percakapan
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{ route('admin.games.show', $question->game) }}" class="btn btn-light px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning px-5 shadow-sm">
                                <i class="fas fa-save me-2"></i>Update Pertanyaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card border-0 bg-light mt-4">
                <div class="card-body">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="fas fa-lightbulb text-warning me-2"></i>Tips Mengedit Pertanyaan
                    </h6>
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Pastikan pertanyaan jelas dan mudah dipahami
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Untuk pilihan ganda, jawaban benar harus ada dalam pilihan
                        </li>
                        <li>
                            <i class="fas fa-check text-success me-2"></i>
                            Gunakan gambar untuk memperjelas pertanyaan jika diperlukan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleOptions() {
    const checkbox = document.getElementById('has_options');
    const container = document.getElementById('options_container');
    container.style.display = checkbox.checked ? 'block' : 'none';
}
</script>

<style>
.bg-gradient-warning {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
}

.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}

.form-control:focus,
.form-select:focus {
    border-color: #f6c23e;
    box-shadow: 0 0 0 0.2rem rgba(246, 194, 62, 0.25);
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

.input-group-text {
    min-width: 50px;
    justify-content: center;
}

.gap-2 {
    gap: 0.5rem;
}
</style>
@endsection