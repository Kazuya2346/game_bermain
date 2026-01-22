@extends('layouts.admin')

@section('title', 'Tambah Pertanyaan Baru (Mode Bulk)')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Tambah Pertanyaan Baru (Mode Bulk)</h1>
            <p class="text-muted small mb-0">Game: <strong>{{ $game->title }}</strong></p>
        </div>
        <a href="{{ route('admin.games.show', $game->id) }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Error!</strong> Terdapat kesalahan pada form Anda:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Game Info Card -->
    <div class="card bg-gradient-primary text-white shadow-lg mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="display-4 me-4">
                    @if($game->type === 'tebak_gambar') 🖼️
                    @elseif($game->type === 'kosakata_tempat') 🏠
                    @elseif($game->type === 'pilihan_ganda') ✅
                    @else 💬
                    @endif
                </div>
                <div>
                    <h2 class="mb-1 fw-bold">{{ $game->title }}</h2>
                    <p class="mb-0 opacity-75">{{ $game->description ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Box Fleksibilitas -->
    <div class="alert alert-info border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-start">
            <div class="fs-2 me-3">✨</div>
            <div>
                <h6 class="alert-heading fw-bold mb-2">Fitur Baru: Tipe Jawaban Fleksibel!</h6>
                <p class="mb-0 small">Setiap pertanyaan bisa memiliki <strong>tipe jawaban berbeda</strong>. Anda bisa membuat pertanyaan dengan <strong>Pilihan Ganda</strong> atau <strong>Essay</strong> dalam satu game yang sama!</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data" id="bulkQuestionForm">
        @csrf
        <input type="hidden" name="game_id" value="{{ $game->id }}">

        <div id="questionsContainer">
            <!-- Question Template akan di-inject di sini -->
        </div>

        <!-- Tombol Tambah Soal -->
        <div class="mb-4">
            <button type="button" onclick="addQuestion()" class="btn btn-lg btn-outline-primary w-100 py-4 border-2 border-dashed">
                <i class="fas fa-plus-circle me-2"></i>Tambah Soal Baru
            </button>
        </div>

        <!-- Info Box -->
        <div class="alert alert-success border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-start">
                <div class="fs-3 me-3">💡</div>
                <div>
                    <h6 class="alert-heading fw-bold mb-2">Tips:</h6>
                    <ul class="mb-0 small">
                        <li>Anda bisa membuat <strong>variasi tipe jawaban</strong> dalam satu game</li>
                        <li>Pilihan Ganda: untuk soal yang membutuhkan opsi pilihan</li>
                        <li>Essay: untuk soal yang membutuhkan jawaban singkat</li>
                        <li>Pastikan semua field yang bertanda <span class="text-danger">*</span> terisi</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('admin.games.show', $game->id) }}" class="btn btn-light btn-lg px-5">
                <i class="fas fa-times me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                <i class="fas fa-save me-2"></i>Simpan Semua Pertanyaan
            </button>
        </div>
    </form>
</div>

<!-- Question Template (Hidden) -->
<template id="questionTemplate">
    <div class="question-card card shadow-lg border-0 mb-4" data-question-index="0">
        <div class="card-header bg-gradient-warning py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold text-dark">
                    <i class="fas fa-question-circle me-2"></i>Pertanyaan #<span class="question-number">1</span>
                </h5>
                <button type="button" onclick="removeQuestion(this)" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash me-1"></i>Hapus
                </button>
            </div>
        </div>
        <div class="card-body p-4">
            
            <!-- Pilihan Tipe Jawaban -->
            <div class="mb-4 p-4 bg-light rounded-3 border-2 border-primary">
                <label class="form-label fw-bold mb-3">
                    <i class="fas fa-bullseye text-primary me-2"></i>Tipe Jawaban <span class="text-danger">*</span>
                </label>
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="radio" class="btn-check answer-type-radio" name="questions[0][answer_type]" id="mc_0" value="multiple_choice" checked autocomplete="off" onchange="toggleAnswerType(this)">
                        <label class="btn btn-outline-primary w-100 py-3" for="mc_0">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="fs-3 me-3">✅</span>
                                <div class="text-start">
                                    <div class="fw-bold">Pilihan Ganda</div>
                                    <small>Multiple Choice (A, B, C, D)</small>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <input type="radio" class="btn-check answer-type-radio" name="questions[0][answer_type]" id="essay_0" value="essay" autocomplete="off" onchange="toggleAnswerType(this)">
                        <label class="btn btn-outline-info w-100 py-3" for="essay_0">
                            <div class="d-flex align-items-center justify-content-center">
                                <span class="fs-3 me-3">✍️</span>
                                <div class="text-start">
                                    <div class="fw-bold">Essay</div>
                                    <small>Jawaban Singkat (Teks)</small>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Pertanyaan -->
            <div class="mb-4">
                <label class="form-label fw-bold">
                    <i class="fas fa-question-circle text-info me-2"></i>Pertanyaan <span class="text-danger">*</span>
                </label>
                <textarea name="questions[0][question_text]" rows="3" class="form-control" placeholder="Contoh: Apa bahasa Arab dari 'rumah'?" required></textarea>
            </div>

            <!-- Upload Gambar -->
            @if($game->type === 'tebak_gambar' || $game->type === 'kosakata_tempat')
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-image text-success me-2"></i>Upload Gambar 
                        @if($game->type === 'tebak_gambar')<span class="text-danger">*</span>@endif
                    </label>
                    <input type="file" name="questions[0][image]" class="form-control" accept="image/*" @if($game->type === 'tebak_gambar') required @endif>
                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                </div>
            @endif

            <!-- Nama Lokasi -->
            @if($game->type === 'kosakata_tempat' || $game->type === 'percakapan')
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>Nama Tempat <span class="text-danger">*</span>
                    </label>
                    <select name="questions[0][location_name]" class="form-select" required>
                        <option value="">-- Pilih Tempat --</option>
                        @foreach($locationOptions ?? [] as $location)
                            <option value="{{ $location }}">{{ $location }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Pilihan Jawaban (Multiple Choice) -->
            <div class="mb-4 options-container">
                <label class="form-label fw-bold">
                    <i class="fas fa-list-ul text-warning me-2"></i>Pilihan Jawaban <span class="text-danger">*</span>
                </label>
                <div class="space-y-2">
                    @for($i = 0; $i < 4; $i++)
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-primary text-white fw-bold">{{ chr(65 + $i) }}</span>
                            <input type="text" name="questions[0][options][]" class="form-control option-input" placeholder="Pilihan {{ chr(65 + $i) }}" required>
                        </div>
                    @endfor
                </div>
                <small class="text-muted">Isi semua 4 pilihan untuk pilihan ganda</small>
            </div>

            <!-- Jawaban yang Benar -->
            <div class="mb-4">
                <label class="form-label fw-bold">
                    <i class="fas fa-check-circle text-success me-2"></i>Jawaban yang Benar <span class="text-danger">*</span>
                </label>
                <input type="text" name="questions[0][correct_answer]" class="form-control form-control-lg" placeholder="Contoh: بَيْتٌ" required>
                <small class="text-muted answer-hint-mc">⚠️ Harus sama persis dengan salah satu pilihan di atas</small>
                <small class="text-muted answer-hint-essay" style="display: none;">💡 Jawaban yang akan dicocokkan dengan input santri (case-insensitive)</small>
            </div>

            <!-- Badge Indicator -->
            <div class="answer-type-badge">
                <span class="badge bg-primary px-3 py-2 fs-6">
                    <i class="fas fa-check-square me-1"></i>Pilihan Ganda
                </span>
            </div>

        </div>
    </div>
</template>

<script>
let questionCount = 0;

// Initialize pertanyaan pertama saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    addQuestion();
});

function addQuestion() {
    questionCount++;
    const container = document.getElementById('questionsContainer');
    const template = document.getElementById('questionTemplate');
    const clone = template.content.cloneNode(true);
    
    // Update semua index dan ID
    const card = clone.querySelector('.question-card');
    card.dataset.questionIndex = questionCount;
    
    // Update question number
    clone.querySelector('.question-number').textContent = questionCount;
    
    // Update semua name attributes
    clone.querySelectorAll('[name^="questions[0]"]').forEach(input => {
        input.name = input.name.replace('[0]', `[${questionCount}]`);
    });
    
    // Update radio button IDs dan labels
    const mcRadio = clone.querySelector('[id^="mc_"]');
    const essayRadio = clone.querySelector('[id^="essay_"]');
    const mcLabel = clone.querySelector('[for^="mc_"]');
    const essayLabel = clone.querySelector('[for^="essay_"]');
    
    mcRadio.id = `mc_${questionCount}`;
    essayRadio.id = `essay_${questionCount}`;
    mcLabel.setAttribute('for', `mc_${questionCount}`);
    essayLabel.setAttribute('for', `essay_${questionCount}`);
    
    container.appendChild(clone);
    
    // Scroll ke pertanyaan baru
    setTimeout(() => {
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 100);
}

function removeQuestion(button) {
    const card = button.closest('.question-card');
    const container = document.getElementById('questionsContainer');
    
    // Jangan hapus jika hanya ada 1 pertanyaan
    if (container.children.length <= 1) {
        alert('Minimal harus ada 1 pertanyaan!');
        return;
    }
    
    if (confirm('Yakin ingin menghapus pertanyaan ini?')) {
        card.remove();
        updateQuestionNumbers();
    }
}

function updateQuestionNumbers() {
    document.querySelectorAll('.question-number').forEach((el, index) => {
        el.textContent = index + 1;
    });
}

function toggleAnswerType(radio) {
    const card = radio.closest('.question-card');
    const isMultipleChoice = radio.value === 'multiple_choice';
    
    // Toggle options container
    const optionsContainer = card.querySelector('.options-container');
    optionsContainer.style.display = isMultipleChoice ? 'block' : 'none';
    
    // Toggle option inputs required
    card.querySelectorAll('.option-input').forEach(input => {
        input.required = isMultipleChoice;
    });
    
    // Toggle hints
    card.querySelector('.answer-hint-mc').style.display = isMultipleChoice ? 'block' : 'none';
    card.querySelector('.answer-hint-essay').style.display = isMultipleChoice ? 'none' : 'block';
    
    // Update badge
    const badge = card.querySelector('.answer-type-badge span');
    if (isMultipleChoice) {
        badge.className = 'badge bg-primary px-3 py-2 fs-6';
        badge.innerHTML = '<i class="fas fa-check-square me-1"></i>Pilihan Ganda';
    } else {
        badge.className = 'badge bg-info px-3 py-2 fs-6';
        badge.innerHTML = '<i class="fas fa-pen me-1"></i>Essay';
    }
}
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
}

.question-card {
    transition: all 0.3s ease;
}

.question-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.btn-check:checked + .btn-outline-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-check:checked + .btn-outline-info {
    background-color: #36b9cc;
    border-color: #36b9cc;
}

.input-group-text {
    min-width: 50px;
    justify-content: center;
}

.gap-3 {
    gap: 1rem;
}
</style>
@endsection