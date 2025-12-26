@extends('layouts.santri')

@section('title', 'Arabic Sentence Builder')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Game -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between text-white">
            <div>
                <h1 class="text-3xl font-bold mb-2">🧩 Arabic Sentence Builder</h1>
                <p class="text-purple-100">Susun kata-kata menjadi kalimat bahasa Arab yang benar!</p>
            </div>
            <div class="text-right">
                <div class="text-4xl font-bold" id="timer">10:00</div>
                <div class="text-sm text-purple-100">Waktu Tersisa</div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Progress</span>
            <span class="text-sm font-medium text-gray-700">
                <span id="current-question">1</span> / <span id="total-questions">{{ count($questions) }}</span>
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div id="progress-bar" class="bg-gradient-to-r from-purple-600 to-indigo-600 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
        </div>
    </div>

    <!-- Score Display -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-green-50 border-2 border-green-500 rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-green-600" id="score">0</div>
            <div class="text-sm text-green-700 font-medium">Skor</div>
        </div>
        <div class="bg-blue-50 border-2 border-blue-500 rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-blue-600" id="correct">0</div>
            <div class="text-sm text-blue-700 font-medium">Benar</div>
        </div>
        <div class="bg-red-50 border-2 border-red-500 rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-red-600" id="wrong">0</div>
            <div class="text-sm text-red-700 font-medium">Salah</div>
        </div>
    </div>

    <!-- Question Card -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
        <!-- Category Badge -->
        <div class="mb-6">
            <span id="category-badge" class="inline-block px-4 py-2 rounded-full text-sm font-semibold"></span>
        </div>

        <!-- Translation (Hint) -->
        <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
            <div class="text-sm text-gray-600 mb-2">📖 Terjemahan:</div>
            <div id="translation" class="text-xl font-medium text-gray-800"></div>
        </div>

        <!-- Answer Area (Drop Zone) -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-3">Susun kalimat di sini:</label>
            <div id="answer-area" 
                 class="min-h-[100px] p-6 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg flex flex-wrap gap-3 items-center justify-center transition-all duration-200"
                 ondrop="drop(event)" 
                 ondragover="allowDrop(event)">
                <span class="text-gray-400 text-lg" id="placeholder-text">Seret kata-kata ke sini</span>
            </div>
        </div>

        <!-- Word Options (Draggable) -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-3">Pilihan kata:</label>
            <div id="word-options" class="flex flex-wrap gap-3 justify-center p-6 bg-purple-50 rounded-lg min-h-[100px]"></div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 justify-center">
            <button onclick="clearAnswer()" 
                    class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset
            </button>
            
            <button id="check-btn" 
                    onclick="checkAnswer()" 
                    class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-medium transition-all duration-200 flex items-center gap-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Cek Jawaban
            </button>
        </div>

        <!-- Feedback Area -->
        <div id="feedback" class="mt-6 hidden"></div>
    </div>

    <!-- Finish Button (Hidden until last question) -->
    <div id="finish-section" class="text-center hidden">
        <button onclick="finishGame()" 
                class="px-10 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg font-bold text-lg transition-all duration-200 shadow-lg">
            🎉 Selesai & Lihat Hasil
        </button>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loading" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-purple-600 mx-auto mb-4"></div>
        <p class="text-gray-700 font-medium">Memproses jawaban...</p>
    </div>
</div>

@push('scripts')
<script>
// ==========================================
// DATA & VARIABLES
// ==========================================
const questions = @json($questions);
let currentQuestionIndex = 0;
let score = 0;
let correctCount = 0;
let wrongCount = 0;
let userAnswers = [];
let startTime = Date.now();
let timerInterval;

// ==========================================
// INITIALIZE GAME
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    loadQuestion();
    startTimer();
});

// ==========================================
// TIMER FUNCTION
// ==========================================
function startTimer() {
    const duration = 10 * 60; // 10 menit dalam detik
    let timeLeft = duration;
    
    timerInterval = setInterval(() => {
        timeLeft--;
        
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        
        document.getElementById('timer').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        // Warning saat 1 menit tersisa
        if (timeLeft === 60) {
            alert('⚠️ Peringatan: Waktu tersisa 1 menit!');
        }
        
        // Waktu habis
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert('⏰ Waktu habis!');
            finishGame();
        }
    }, 1000);
}

// ==========================================
// LOAD QUESTION
// ==========================================
function loadQuestion() {
    if (currentQuestionIndex >= questions.length) {
        return;
    }
    
    const question = questions[currentQuestionIndex];
    const options = JSON.parse(question.options);
    
    // Update question number & progress
    document.getElementById('current-question').textContent = currentQuestionIndex + 1;
    document.getElementById('total-questions').textContent = questions.length;
    
    const progress = ((currentQuestionIndex + 1) / questions.length) * 100;
    document.getElementById('progress-bar').style.width = progress + '%';
    
    // Update category badge
    const categoryBadge = document.getElementById('category-badge');
    if (question.question_text.includes('ismiyyah')) {
        categoryBadge.textContent = '📚 Jumlah Ismiyah';
        categoryBadge.className = 'inline-block px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-700';
    } else {
        categoryBadge.textContent = '⚡ Jumlah Filiyyah';
        categoryBadge.className = 'inline-block px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-700';
    }
    
    // Display translation
    document.getElementById('translation').textContent = question.correct_answer;
    
    // Clear previous state
    document.getElementById('answer-area').innerHTML = '<span class="text-gray-400 text-lg" id="placeholder-text">Seret kata-kata ke sini</span>';
    document.getElementById('feedback').classList.add('hidden');
    
    // Shuffle and display word options
    const shuffled = shuffleArray([...options]);
    const wordOptionsDiv = document.getElementById('word-options');
    wordOptionsDiv.innerHTML = '';
    
    shuffled.forEach((word, index) => {
        const wordElement = document.createElement('div');
        wordElement.id = `word-${index}`;
        wordElement.draggable = true;
        wordElement.textContent = word;
        wordElement.className = 'px-6 py-3 bg-white border-2 border-purple-300 rounded-lg cursor-move hover:bg-purple-50 hover:border-purple-500 transition-all duration-200 text-xl font-arabic shadow-sm';
        wordElement.ondragstart = drag;
        wordOptionsDiv.appendChild(wordElement);
    });
    
    // Show/hide finish button
    if (currentQuestionIndex === questions.length - 1) {
        document.getElementById('finish-section').classList.remove('hidden');
    }
}

// ==========================================
// DRAG & DROP FUNCTIONS
// ==========================================
function allowDrop(ev) {
    ev.preventDefault();
    ev.currentTarget.classList.add('border-purple-500', 'bg-purple-50');
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    ev.currentTarget.classList.remove('border-purple-500', 'bg-purple-50');
    
    const data = ev.dataTransfer.getData("text");
    const draggedElement = document.getElementById(data);
    
    if (draggedElement) {
        // Remove placeholder if exists
        const placeholder = document.getElementById('placeholder-text');
        if (placeholder) {
            placeholder.remove();
        }
        
        const answerArea = document.getElementById('answer-area');
        answerArea.appendChild(draggedElement);
    }
}

// ==========================================
// UTILITY FUNCTIONS
// ==========================================
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

function clearAnswer() {
    const answerArea = document.getElementById('answer-area');
    const wordOptions = document.getElementById('word-options');
    
    // Move all words back to options
    const words = answerArea.querySelectorAll('[draggable="true"]');
    words.forEach(word => {
        wordOptions.appendChild(word);
    });
    
    // Show placeholder
    answerArea.innerHTML = '<span class="text-gray-400 text-lg" id="placeholder-text">Seret kata-kata ke sini</span>';
    
    // Hide feedback
    document.getElementById('feedback').classList.add('hidden');
}

// ==========================================
// CHECK ANSWER
// ==========================================
function checkAnswer() {
    const answerArea = document.getElementById('answer-area');
    const words = Array.from(answerArea.querySelectorAll('[draggable="true"]'));
    
    if (words.length === 0) {
        alert('⚠️ Silakan susun kata-kata terlebih dahulu!');
        return;
    }
    
    const userAnswer = words.map(word => word.textContent.trim()).join(' ');
    const correctAnswer = questions[currentQuestionIndex].question_text;
    
    const isCorrect = userAnswer === correctAnswer;
    const feedbackDiv = document.getElementById('feedback');
    
    if (isCorrect) {
        score += 10;
        correctCount++;
        
        feedbackDiv.innerHTML = `
            <div class="p-6 bg-green-50 border-l-4 border-green-500 rounded-lg">
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xl font-bold text-green-700">✅ Benar!</span>
                </div>
                <div class="text-gray-700">
                    <strong>Jawaban Anda:</strong> <span class="font-arabic text-lg">${userAnswer}</span>
                </div>
            </div>
        `;
    } else {
        wrongCount++;
        
        feedbackDiv.innerHTML = `
            <div class="p-6 bg-red-50 border-l-4 border-red-500 rounded-lg">
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xl font-bold text-red-700">❌ Salah!</span>
                </div>
                <div class="text-gray-700 mb-2">
                    <strong>Jawaban Anda:</strong> <span class="font-arabic text-lg">${userAnswer}</span>
                </div>
                <div class="text-gray-700">
                    <strong>Jawaban Benar:</strong> <span class="font-arabic text-lg text-green-600">${correctAnswer}</span>
                </div>
            </div>
        `;
    }
    
    feedbackDiv.classList.remove('hidden');
    
    // Update score display
    document.getElementById('score').textContent = score;
    document.getElementById('correct').textContent = correctCount;
    document.getElementById('wrong').textContent = wrongCount;
    
    // Save answer
    userAnswers.push({
        question_id: questions[currentQuestionIndex].id,
        user_answer: userAnswer,
        is_correct: isCorrect
    });
    
    // Auto next after 2 seconds
    setTimeout(() => {
        currentQuestionIndex++;
        if (currentQuestionIndex < questions.length) {
            loadQuestion();
        } else {
            document.getElementById('check-btn').disabled = true;
            document.getElementById('check-btn').classList.add('opacity-50', 'cursor-not-allowed');
        }
    }, 2000);
}

// ==========================================
// FINISH GAME
// ==========================================
function finishGame() {
    if (userAnswers.length === 0) {
        alert('⚠️ Anda belum menjawab satupun soal!');
        return;
    }
    
    clearInterval(timerInterval);
    document.getElementById('loading').classList.remove('hidden');
    
    const endTime = Date.now();
    const duration = Math.floor((endTime - startTime) / 1000);
    
    fetch('/santri/sentence-builder/submit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            answers: userAnswers,
            score: score,
            duration: duration
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '/santri/sentence-builder/result';
        } else {
            alert('❌ Gagal menyimpan hasil: ' + data.message);
            document.getElementById('loading').classList.add('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat menyimpan hasil!');
        document.getElementById('loading').classList.add('hidden');
    });
}

// Prevent accidental page leave
window.addEventListener('beforeunload', function (e) {
    if (currentQuestionIndex < questions.length && userAnswers.length > 0) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>

<style>
.font-arabic {
    font-family: 'Traditional Arabic', 'Arial', sans-serif;
    direction: rtl;
}

[draggable="true"] {
    transition: transform 0.2s ease;
}

[draggable="true"]:hover {
    transform: scale(1.05);
}

#answer-area.border-purple-500 {
    border-color: #9333ea;
    background-color: #faf5ff;
}
</style>
@endpush
@endsection