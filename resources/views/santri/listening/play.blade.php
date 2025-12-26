@extends('layouts.santri')

@section('title', 'Mendengarkan dan Bermain')

@push('styles')
<style>
    .option-button {
        transition: all 0.3s ease;
        text-align: right;
        direction: rtl;
        cursor: pointer;
        border-width: 2px;
    }
    
    .option-button:hover:not(:disabled) {
        border-color: #14b8a6;
        background-color: #f0fdfa;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .option-selected {
        border-color: #0d9488 !important;
        background-color: #ccfbf1 !important;
        transform: scale(1.02);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.2);
    }
    
    .option-correct {
        border-color: #10b981 !important;
        background-color: #d1fae5 !important;
        animation: correctPulse 0.6s ease-in-out;
    }
    
    .option-incorrect {
        border-color: #ef4444 !important;
        background-color: #fee2e2 !important;
        animation: shake 0.5s ease-in-out;
    }
    
    .option-button:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    @keyframes correctPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
    
    .rtl-container {
        direction: rtl;
        text-align: right;
    }
    
    .rtl-input {
        direction: rtl;
        text-align: right;
    }
    
    /* Drag and Drop Styles */
    .drop-zone {
        min-height: 120px;
        border-radius: 12px;
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        align-items: center;
        gap: 8px;
        padding: 16px;
        transition: all 0.3s ease;
    }
    
    .drop-zone:empty::after {
        content: 'Susun item di sini...';
        color: #9ca3af;
        font-size: 1.125rem;
        width: 100%;
        text-align: center;
    }
    
    .drag-item {
        margin: 0;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .drag-item:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15);
    }
    
    .drag-item:active:not(:disabled) {
        transform: scale(0.95);
    }
    
    .drag-item:disabled {
        cursor: not-allowed;
    }
    
    /* Loading Spinner */
    .spinner {
        border: 3px solid #f3f4f6;
        border-top: 3px solid #0d9488;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Pulse Animation */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Prevent text selection on buttons */
    button {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    /* Timer Styles - Enhanced */
    .timer-container {
        position: relative;
        overflow: hidden;
    }
    
    .timer-warning {
        animation: urgentPulse 0.5s infinite;
    }
    
    @keyframes urgentPulse {
        0%, 100% { 
            opacity: 1;
            transform: scale(1);
        }
        50% { 
            opacity: 0.7;
            transform: scale(1.05);
        }
    }
    
    .timer-critical {
        animation: criticalShake 0.3s infinite;
        color: #dc2626 !important;
    }
    
    @keyframes criticalShake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-3px); }
        75% { transform: translateX(3px); }
    }

    /* Success Animation */
    @keyframes successBounce {
        0%, 100% { transform: scale(1); }
        25% { transform: scale(1.1); }
        50% { transform: scale(0.95); }
        75% { transform: scale(1.05); }
    }
    
    .success-animation {
        animation: successBounce 0.6s ease-in-out;
    }

    /* Feedback Card Enhanced */
    .feedback-card {
        backdrop-filter: blur(10px);
        border-width: 3px;
    }

    /* Hide element until Alpine.js is loaded */
    [x-cloak] {
        display: none !important;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8" x-data="listeningGame()" x-cloak>

    <div x-show="!gameInitialized && !fatalError" class="text-center py-20">
        <div class="spinner mx-auto mb-4"></div>
        <p class="text-gray-600 text-lg">Memuat sesi game...</p>
    </div>

    <div x-show="fatalError" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="bg-red-100 border-l-4 border-red-500 text-red-700 p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
        <div class="flex items-start">
            <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="font-bold text-lg mb-2">Kesalahan Fatal!</p>
                <p x-text="fatalErrorMessage" class="mb-4"></p>
                <a href="{{ route('santri.listening.index') }}" 
                   class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition-colors">
                    Kembali ke Pilih Level
                </a>
            </div>
        </div>
    </div>

    <div x-show="gameInitialized && !fatalError"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        
        <div class="bg-gradient-to-r from-teal-600 to-cyan-600 rounded-xl shadow-xl p-6 mb-6 text-white">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold mb-2">
                        🎧 Level <span x-text="levelName"></span>
                    </h1>
                    <div class="flex items-center gap-4 text-teal-100">
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="font-bold" x-text="totalScore">0</span> Poin
                        </span>
                        <span class="flex items-center gap-1">
                            🔥 <span class="font-bold" x-text="currentStreak">0</span> Streak
                        </span>
                    </div>
                </div>
                <button @click="confirmCancel" 
                        :disabled="isLoading"
                        class="bg-red-500 hover:bg-red-600 disabled:bg-red-400 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                    Batalkan Game
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 mb-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">Progress</span>
                <span class="text-sm font-semibold text-teal-600">
                    Soal <span x-text="currentIndex + 1"></span> dari <span x-text="totalQuestions"></span>
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-600 to-cyan-600 h-4 rounded-full transition-all duration-500 ease-out" 
                     :style="`width: ${((currentIndex + 1) / totalQuestions) * 100}%`">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 mb-6 timer-container">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Waktu Tersisa
                </span>
                <span class="text-3xl font-bold font-mono"
                      :class="{
                          'timer-critical': timeRemaining <= 3,
                          'timer-warning': timeRemaining > 3 && timeRemaining <= 5,
                          'text-teal-600': timeRemaining > 5
                      }"
                      x-text="timeDisplay"></span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div class="h-3 rounded-full transition-all duration-1000 ease-linear" 
                     :class="{
                         'bg-gradient-to-r from-red-600 to-red-500': timeRemaining <= 5,
                         'bg-gradient-to-r from-orange-500 to-yellow-500': timeRemaining > 5 && timeRemaining <= 7,
                         'bg-gradient-to-r from-teal-600 to-cyan-600': timeRemaining > 7
                     }"
                     :style="`width: ${timerProgress}%`">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-xl p-8 mb-6">

            <div class="text-center mb-10">
                <audio x-ref="audioPlayer" 
                       @ended="isAudioPlaying = false"
                       @play="isAudioPlaying = true"
                       @pause="isAudioPlaying = false"
                       class="hidden"></audio>
                
                <button @click="playAudio" 
                        :disabled="isAudioLoading || !question.audio_url"
                        class="bg-teal-500 hover:bg-teal-600 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-5 px-10 rounded-full text-lg transition-all duration-200 shadow-xl hover:shadow-2xl hover:scale-105 flex items-center gap-3 mx-auto">
                    
                    <svg x-show="isAudioLoading" class="animate-spin h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    
                    <svg x-show="!isAudioLoading && !isAudioPlaying" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    
                    <svg x-show="!isAudioLoading && isAudioPlaying" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    
                    <span x-show="isAudioLoading">Memuat Audio...</span>
                    <span x-show="!isAudioLoading && !isAudioPlaying">Putar Audio</span>
                    <span x-show="!isAudioLoading && isAudioPlaying">Sedang Diputar...</span>
                </button>
                
                <p class="text-gray-500 text-base mt-4" x-text="question.question_text || 'Dengarkan audio dan pilih jawaban yang tepat'"></p>
            </div>

            <template x-if="question.type === 'multiple_choice'">
                <div class="rtl-container">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 text-left">Pilih Jawaban:</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="(option, index) in question.options" :key="'option-' + index">
                            <button @click="selectOption(option)" 
                                    :disabled="isSubmitted || isLoading"
                                    :class="{
                                        'option-selected': userAnswer === option && !isSubmitted,
                                        'option-correct': isSubmitted && feedback.isCorrect && (option === feedback.correctAnswerDisplay || userAnswer === option),
                                        'option-incorrect': isSubmitted && !feedback.isCorrect && userAnswer === option,
                                        'border-gray-300': !isSubmitted && userAnswer !== option,
                                        'opacity-50': isSubmitted && userAnswer !== option && option !== feedback.correctAnswerDisplay
                                    }"
                                    class="option-button p-6 rounded-xl text-xl font-arabic focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                <span x-text="option"></span>
                                <span x-show="isSubmitted && option === feedback.correctAnswerDisplay" class="ml-2">✓</span>
                            </button>
                        </template>
                    </div>
                </div>
            </template>

            <template x-if="question.type === 'drag_drop_word' || question.type === 'drag_drop_letter'">
                <div class="rtl-container">
                    <h3 class="text-lg font-semibold mb-3 text-gray-700 text-left">Jawaban Anda:</h3>
                    
                    <div id="drop-zone" 
                         class="drop-zone bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 mb-6"
                         :class="{
                             'border-teal-400 bg-teal-50': submittedAnswerArray.length > 0 && !isSubmitted,
                             'border-green-400 bg-green-50': isSubmitted && feedback.isCorrect,
                             'border-red-400 bg-red-50': isSubmitted && !feedback.isCorrect
                         }">
                        <template x-for="(word, index) in submittedAnswerArray" :key="'answer-' + index">
                            <button @click="returnWord(word, index)"
                                    :disabled="isSubmitted || isLoading"
                                    class="bg-yellow-100 hover:bg-yellow-200 border-2 border-yellow-400 text-yellow-900 rounded-lg px-4 py-2 font-arabic drag-item text-lg font-semibold shadow-sm"
                                    :class="{'cursor-not-allowed opacity-60': isSubmitted || isLoading}">
                                <span x-text="word"></span>
                            </button>
                        </template>
                    </div>

                    <div x-show="isSubmitted && !feedback.isCorrect && feedback.correctAnswerDisplay" 
                         class="mb-6 p-4 bg-green-50 rounded-xl border-2 border-green-400">
                        <p class="text-gray-700 mb-2 font-semibold text-left">Jawaban Yang Benar:</p>
                        <div class="flex flex-wrap gap-2 justify-end">
                            <template x-for="(word, idx) in (Array.isArray(feedback.correctAnswerDisplay) ? feedback.correctAnswerDisplay : (feedback.correctAnswerDisplay || '').split(' '))" :key="'correct-' + idx">
                                <span class="bg-green-100 border-2 border-green-500 text-green-900 rounded-lg px-4 py-2 font-arabic text-lg font-semibold">
                                    <span x-text="word"></span>
                                </span>
                            </template>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-3 text-gray-700 text-left">Item Tersedia:</h3>
                    <div class="flex flex-wrap gap-3 justify-end">
                        <template x-for="(item, index) in shuffledItems" :key="'item-' + index">
                            <button @click="addWord(item, index)" 
                                    :disabled="item.used || isSubmitted || isLoading"
                                    class="bg-blue-100 hover:bg-blue-200 border-2 border-blue-400 text-blue-900 rounded-lg px-4 py-2 font-arabic drag-item text-lg font-semibold shadow-sm transition-all"
                                    :class="{'opacity-40 cursor-not-allowed': item.used || isSubmitted || isLoading}">
                                <span x-text="item.word"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </template>

            <div class="flex gap-4 justify-center mt-10 flex-wrap">
                <button @click="useHint" 
                        :disabled="isSubmitted || usedHint || isLoading"
                        class="bg-yellow-500 hover:bg-yellow-600 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                    <span class="flex items-center gap-2">
                        💡 Hint 
                        <span x-show="!usedHint">(-<span x-text="hintPenalty"></span> Poin)</span>
                        <span x-show="usedHint">✓ Terpakai</span>
                    </span>
                </button>

                <button @click="submitAnswer" 
                        :disabled="isSubmitted || !canSubmit || isLoading"
                        class="bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed text-white font-bold py-3 px-10 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                    <span x-show="!isLoading">Kirim Jawaban</span>
                    <span x-show="isLoading" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mengirim...
                    </span>
                </button>
            </div>

            <div x-show="feedback.show" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="mt-8 p-6 rounded-xl border-2 text-center shadow-lg feedback-card"
                 :class="{
                     'bg-green-50 border-green-500': feedback.isCorrect,
                     'bg-red-50 border-red-500': !feedback.isCorrect && !feedback.message.includes('Hint'),
                     'bg-blue-50 border-blue-500': feedback.message.includes('Hint')
                 }">
                
                <div class="flex items-center justify-center gap-3 mb-3">
                    <span x-show="feedback.isCorrect" class="text-5xl success-animation">✅</span>
                    <span x-show="!feedback.isCorrect && !feedback.message.includes('Hint')" class="text-5xl">❌</span>
                    <span x-show="feedback.message.includes('Hint')" class="text-5xl">💡</span>
                    <span class="text-2xl font-bold" 
                          :class="{
                              'text-green-700': feedback.isCorrect,
                              'text-red-700': !feedback.isCorrect && !feedback.message.includes('Hint'),
                              'text-blue-700': feedback.message.includes('Hint')
                          }" 
                          x-text="feedback.message"></span>
                </div>

                <div x-show="feedback.breakdown && feedback.isCorrect" class="mt-4 text-sm text-gray-700">
                    <p class="font-semibold text-xl">
                        Skor Soal: <span class="text-teal-600 text-2xl">+<span x-text="feedback.breakdown?.total || 0"></span> Poin</span>
                    </p>
                </div>

                <div x-show="!feedback.isCorrect && attemptsLeft > 0 && !feedback.message.includes('Hint') && !feedback.message.includes('Waktu')" class="mt-4">
                    <p class="text-orange-600 font-semibold text-lg">
                        💪 Percobaan tersisa: <span x-text="attemptsLeft" class="text-xl"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Configuration
const API_ROUTES = {
    start: '{{ route('santri.listening.api.start') }}',
    submit: '{{ route('santri.listening.api.submit') }}',
    next: '{{ route('santri.listening.api.next') }}',
    hint: '{{ route('santri.listening.api.hint') }}',
    cancel: '{{ route('santri.listening.api.cancel') }}'
};
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';

// API Helper
async function apiCall(url, method = 'GET', data = null) {
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    };

    if (data && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
        options.body = JSON.stringify(data);
    }

    try {
        const response = await fetch(url, options);
        
        // Cek content-type sebelum parse JSON
        const contentType = response.headers.get('content-type');
        if (!response.ok || !contentType || !contentType.includes('application/json')) {
            const errorText = await response.text();
            console.error('Response bukan JSON atau Error:', errorText);
            
            if (response.status === 404) {
                throw new Error('Endpoint tidak ditemukan (404). Periksa konfigurasi route.');
            } else if (response.status === 401) {
                throw new Error('Sesi Anda telah berakhir (401). Silakan login kembali.');
            } else if (response.status === 500) {
                 throw new Error('Terjadi kesalahan server (500). Cek file log Laravel.');
            } else if (response.status === 419) {
                 throw new Error('Sesi CSRF Token berakhir (419). Silakan refresh halaman.');
            }
            
            throw new Error(`Server mengembalikan error ${response.status}.`);
        }

        const responseData = await response.json();
        
        // Cek jika responseData.success adalah false (untuk error yg di-handle)
        if (responseData.success === false) {
             throw new Error(responseData.message || 'Server mengembalikan status gagal.');
        }
        
        return responseData;

    } catch (error) {
        if (error.name === 'TypeError' && error.message.includes('fetch')) {
            throw new Error('Tidak dapat terhubung ke server. Periksa koneksi internet Anda.');
        }
        throw error;
    }
}

function listeningGame() {
    return {
        // Game State
        level: '',
        levelName: 'Memuat...',
        totalQuestions: 0,
        currentIndex: 0,
        totalScore: 0,
        currentStreak: 0,
        attemptsLeft: 3,
        usedHint: false,
        hintPenalty: 5,

        // Timer State
        timeLimit: 0,
        timeRemaining: 0,
        timerInterval: null,
        timerWarning: false,

        // Question Data
        question: {},
        shuffledItems: [],
        submittedAnswerArray: [],
        userAnswer: null,

        // UI State
        gameInitialized: false,
        isAudioLoading: false,
        isAudioPlaying: false,
        isSubmitted: false,
        isLoading: false,
        fatalError: false,
        fatalErrorMessage: '',

        // Feedback
        feedback: {
            show: false,
            isCorrect: false,
            message: '',
            breakdown: null,
            correctAnswerDisplay: null,
        },

        // Computed Properties
        get canSubmit() {
            if (!this.userAnswer && this.submittedAnswerArray.length === 0) {
                return false;
            }

            if (this.question.type === 'multiple_choice') {
                return this.userAnswer !== null && this.userAnswer !== '';
            }
            
            if (this.question.type === 'drag_drop_word' || this.question.type === 'drag_drop_letter') {
                return this.shuffledItems.every(item => item.used === true);
            }
            
            return false;
        },

        get timeDisplay() {
            const minutes = Math.floor(this.timeRemaining / 60);
            const seconds = this.timeRemaining % 60;
            return `${minutes}:${seconds.toString().padStart(2, '0')}`;
        },

        get timerProgress() {
            if (this.timeLimit === 0) return 0;
            const remaining = Math.max(0, this.timeRemaining);
            return (remaining / this.timeLimit) * 100;
        },

        // Initialization
        init() {
            console.log('Initializing Listening Game...');
            
            const selectedLevel = localStorage.getItem('selected_listening_level');
            
            if (!selectedLevel) {
                this.showFatalError('Level belum dipilih. Silakan kembali ke halaman utama dan pilih level terlebih dahulu.');
                return;
            }

            this.level = selectedLevel;
            this.startGame(this.level);
        },

        // Show Fatal Error
        showFatalError(message) {
            this.fatalError = true;
            this.fatalErrorMessage = message;
            this.gameInitialized = false;
            this.stopTimer();
            console.error('Fatal Error:', message);
        },

        // Timer methods
        startTimer() {
            this.stopTimer();

            let levelTimer = this.question.time_limit;
            
            if (!levelTimer || typeof levelTimer !== 'number' || levelTimer <= 0) {
                const defaultTimers = {
                    'pemula': 30,
                    'menengah': 25,
                    'sulit': 20
                };
                
                levelTimer = defaultTimers[this.level] || 30;
                console.log(`Using default timer for ${this.level}: ${levelTimer}s`);
            }
            
            this.timeLimit = levelTimer;
            this.timeRemaining = this.timeLimit;
            this.timerWarning = false;

            console.log('Timer started:', this.timeRemaining, 'seconds');

            this.timerInterval = setInterval(() => {
                this.timeRemaining--;

                if (this.timeRemaining <= 0) {
                    console.log('Timer finished!');
                    this.stopTimer();
                    this.handleTimeUp();
                }
            }, 1000);
        },

        stopTimer() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
            }
            this.timerWarning = false;
        },

        async handleTimeUp() {
            if (this.isSubmitted) {
                return;
            }

            console.log('Time is up!');
            this.isSubmitted = true;
            this.isLoading = true;

            let correctDisplayOnTimeUp = null;
            if (this.question.type === 'multiple_choice') {
                correctDisplayOnTimeUp = this.question.correct_answer;
            } else if (this.question.correct_answer) { 
                correctDisplayOnTimeUp = this.question.correct_answer.split(' '); 
            }
            
            this.feedback = {
                show: true,
                isCorrect: false,
                message: '⏱️ Waktu Habis!',
                breakdown: null,
                correctAnswerDisplay: correctDisplayOnTimeUp,
            };
            
            try {
                const payload = {
                    user_answer: "TIME_UP",
                    time_up: true
                };
                
                const result = await apiCall(API_ROUTES.submit, 'POST', payload);
                
                if (result.success && result.data && result.data.correct_answer) {
                    let correctAns = result.data.correct_answer;
                    if (this.question.type !== 'multiple_choice' && !Array.isArray(correctAns)) {
                         correctAns = (correctAns || '').split(' ').filter(w => w.trim());
                    }
                    this.feedback.correctAnswerDisplay = correctAns;
                }

            } catch (error) {
                console.warn('Gagal mengirim status Time Up:', error.message);
            }
            
            this.isLoading = false;

            setTimeout(() => {
                this.nextQuestion();
            }, 2000);
        },

        // Start Game
        async startGame(level) {
            this.isLoading = true;
            this.gameInitialized = false;

            try {
                console.log('Starting game for level:', level);
                
                const result = await apiCall(API_ROUTES.start, 'POST', { level: level });

                if (result.success && result.data?.status === 'started') {
                    const sessionData = result.data.session;
                    const firstQuestion = result.data.question;

                    if (!sessionData || !firstQuestion) {
                        throw new Error('Data sesi tidak lengkap dari server');
                    }

                    this.levelName = sessionData.level_name || level;
                    this.totalQuestions = sessionData.total_questions || 0;
                    this.totalScore = 0;
                    this.currentIndex = 0;
                    this.currentStreak = 0;

                    this.loadQuestion(firstQuestion);
                    this.gameInitialized = true;
                    
                    console.log('Game started successfully');
                } else {
                    throw new Error(result.message || 'Gagal memulai sesi game. Silakan coba lagi.');
                }
            } catch (error) {
                this.showFatalError(error.message);
            } finally {
                this.isLoading = false;
            }
        },

        // Load Question
        loadQuestion(qData) {
            if (!qData || !qData.type) {
                this.showFatalError('Data soal tidak valid');
                return;
            }

            console.log('Loading question:', qData);

            this.stopTimer();

            this.question = qData;
            this.isSubmitted = false;
            this.userAnswer = null;
            this.submittedAnswerArray = [];
            this.feedback = {
                show: false,
                isCorrect: false,
                message: '',
                breakdown: null,
                correctAnswerDisplay: null,
            };
            
            if (this.level === 'sulit' && !qData.type.includes('drag_drop')) {
                console.warn(`Level 'sulit' seharusnya menggunakan drag & drop, tetapi mendapat: ${qData.type}`);
            }
            
            this.attemptsLeft = 3;
            this.usedHint = false;

            if (qData.type === 'multiple_choice') {
                if (!Array.isArray(qData.options) || qData.options.length === 0) {
                    this.showFatalError('Opsi pilihan ganda tidak valid');
                    return;
                }
                const uniqueOptions = [...new Set(qData.options.filter(opt => opt && opt.trim()))];
                if (uniqueOptions.length < 2) {
                    this.showFatalError('Jumlah opsi tidak mencukupi (minimal 2)');
                    return;
                }
                this.question.options = uniqueOptions;
                this.shuffledItems = [];
                
            } else if (qData.type === 'drag_drop_word' || qData.type === 'drag_drop_letter') {
                if (!Array.isArray(qData.shuffled_items)) {
                    this.showFatalError('Data item drag & drop tidak valid (bukan array)');
                    return;
                }
                
                if (qData.shuffled_items.length === 0) {
                    console.error('No shuffled_items provided from backend!');
                    this.showFatalError('Backend tidak mengirim data soal. Silakan hubungi admin.');
                    return;
                }
                
                const filteredItems = qData.shuffled_items
                    .map(item => String(item).trim())
                    .filter(itemStr => {
                        if (itemStr.length === 0) return false;
                        const lowerItem = itemStr.toLowerCase();
                        const fileExtensions = ['.mp3', '.wav', '.ogg', '.m4a', '.webm', '.aac'];
                        if (fileExtensions.some(ext => lowerItem.endsWith(ext))) {
                            console.log('Filtering out file:', itemStr);
                            return false;
                        }
                        const hasArabic = /[\u0600-\u06FF]/.test(itemStr);
                        const isPureEnglish = /^[a-zA-Z0-9_\-]+$/.test(itemStr);
                        if (isPureEnglish && !hasArabic) {
                            console.log('Filtering out non-Arabic item:', itemStr);
                            return false;
                        }
                        return true;
                    });
                
                if (filteredItems.length === 0) {
                    console.error('All items were filtered out! Original items:', qData.shuffled_items);
                    this.showFatalError('Data soal tidak mengandung item yang valid. Silakan hubungi admin.');
                    return;
                }
                
                this.shuffledItems = filteredItems.map((word, index) => ({
                    id: `item-${index}-${Date.now()}`,
                    word: word,
                    used: false
                }));
            }

            this.startTimer();

            this.$nextTick(() => {
                if(qData.audio_url) {
                    this.playAudio();
                } else {
                    console.warn('Tidak ada audio_url untuk diputar.');
                }
            });
        },

        // Play Audio
        async playAudio() {
            if (this.isAudioLoading || !this.question.audio_url) {
                console.warn('Cannot play audio: loading or no URL');
                return;
            }

            this.isAudioLoading = true;

            try {
                const audioPlayer = this.$refs.audioPlayer;
                
                if (!audioPlayer) {
                    throw new Error('Audio player tidak tersedia');
                }

                audioPlayer.src = this.question.audio_url;
                
                await new Promise((resolve, reject) => {
                    audioPlayer.oncanplaythrough = resolve;
                    audioPlayer.onerror = (e) => {
                        console.error('Audio Playback Error:', e);
                        reject(new Error('Gagal memuat file audio. Format mungkin tidak didukung.'));
                    };
                    setTimeout(() => reject(new Error('Audio memuat terlalu lama')), 10000);
                });

                await audioPlayer.play();
                console.log('Audio playing');
                
            } catch (error) {
                console.error('Error playing audio:', error);
                this.feedback = { show: true, isCorrect: false, message: error.message };
                setTimeout(() => this.feedback.show = false, 3000);
            } finally {
                this.isAudioLoading = false;
            }
        },

        // Multiple Choice: Select Option
        selectOption(option) {
            if (this.isSubmitted || this.isLoading) {
                return;
            }
            
            console.log('Selected option:', option);
            this.userAnswer = option;
        },

        // Drag & Drop: Add Word
        addWord(item, index) {
            if (this.isSubmitted || this.isLoading || item.used) {
                return;
            }

            console.log('Adding word:', item.word);
            this.submittedAnswerArray.push(item.word);
            this.shuffledItems[index].used = true;
            
            this.userAnswer = this.submittedAnswerArray;
        },

        // Drag & Drop: Return Word
        returnWord(word, answerIndex) {
            if (this.isSubmitted || this.isLoading) {
                return;
            }

            console.log('Returning word:', word);
            this.submittedAnswerArray.splice(answerIndex, 1);

            const itemIndex = this.shuffledItems.findIndex(item => item.word === word && item.used);
            
            if (itemIndex !== -1) {
                this.shuffledItems[itemIndex].used = false;
            }

            this.userAnswer = this.submittedAnswerArray.length > 0 ? this.submittedAnswerArray : null;
        },

        // ✅ PERBAIKAN KRITIS: Submit Answer dengan logika warna yang benar
        async submitAnswer() {
            if (this.isSubmitted || !this.canSubmit || this.isLoading) {
                console.warn('Cannot submit: conditions not met');
                return;
            }

            this.stopTimer();
            this.isLoading = true;
            // JANGAN set isSubmitted = true di sini! Biarkan sampai dapat response

            let answerToSubmit;
            
            if (this.question.type === 'multiple_choice') {
                answerToSubmit = this.userAnswer;
            } else {
                answerToSubmit = [...this.submittedAnswerArray];
            }

            console.log('Submitting answer:', answerToSubmit);

            const payload = {
                user_answer: answerToSubmit
            };

            try {
                const result = await apiCall(API_ROUTES.submit, 'POST', payload);

                if (!result.success) {
                    throw new Error(result.message || 'Gagal mengirim jawaban');
                }

                const data = result.data;
                
                this.attemptsLeft = data.attempts_left ?? 0;
                this.currentStreak = data.streak ?? 0;
                this.totalScore = data.total_score ?? this.totalScore;

                // ✅ PERBAIKAN PENTING: Set isSubmitted = true HANYA setelah dapat response
                this.isSubmitted = true;

                if (data.status === 'correct') {
                    this.feedback = {
                        show: true,
                        isCorrect: true,
                        message: '✅ Jawaban Benar! Luar biasa!',
                        breakdown: data.score?.breakdown || null,
                        correctAnswerDisplay: data.correct_answer || null,
                    };

                    console.log('Answer correct! Score:', this.totalScore);

                    this.isLoading = false;

                    setTimeout(() => {
                        this.nextQuestion();
                    }, 1500);

                } else if (data.status === 'incorrect' || data.status === 'no_attempts') {
                    let correctDisplay = data.correct_answer;
                    
                    if (this.question.type !== 'multiple_choice' && !Array.isArray(correctDisplay)) {
                         correctDisplay = (correctDisplay || '').split(' ').filter(w => w.trim());
                    }

                    this.feedback = {
                        show: true,
                        isCorrect: false,
                        message: data.message || (data.status === 'incorrect' ? '❌ Jawaban Salah' : '❌ Kesempatan Habis'),
                        breakdown: null,
                        correctAnswerDisplay: correctDisplay,
                    };

                    console.log('Answer incorrect. Attempts left:', this.attemptsLeft);

                    this.isLoading = false;

                    if (data.status === 'incorrect' && data.attempts_left > 0) {
                        setTimeout(() => {
                            this.resetQuestionState();
                            this.startTimer();
                        }, 2000);
                    } else {
                        setTimeout(() => {
                            this.nextQuestion();
                        }, 2500);
                    }
                }

            } catch (error) {
                console.error('Submit error:', error);
                
                // ✅ PERBAIKAN: Reset state dengan benar saat error
                this.isLoading = false;
                this.isSubmitted = false;
                
                alert(`Terjadi kesalahan: ${error.message}\n\nMencoba lanjut ke soal berikutnya...`);
                this.nextQuestion();
            }
        },

        // Reset Question State (for retry)
        resetQuestionState() {
            console.log('Resetting question state for retry');
            
            this.isSubmitted = false;
            this.isLoading = false;
            this.userAnswer = null;
            this.submittedAnswerArray = [];
            
            if (this.shuffledItems.length > 0) {
                this.shuffledItems.forEach(item => {
                    item.used = false;
                });
            }
            
            this.feedback.show = false;
            this.feedback.isCorrect = false;
        },

        // Next Question
        async nextQuestion() {
            if (this.isLoading && this.isSubmitted) {
                return;
            }

            this.stopTimer();
            this.isLoading = true;
            this.isSubmitted = true;

            try {
                console.log('Moving to next question...');
                
                const result = await apiCall(API_ROUTES.next, 'POST');

                if (!result.success) {
                    throw new Error(result.message || 'Gagal memuat soal berikutnya');
                }

                const data = result.data;

                if (data.status === 'completed') {
                    console.log('Game completed! Saving to sessionStorage and redirecting...');
                    sessionStorage.setItem('listeningGameResult', JSON.stringify(data));
                    localStorage.removeItem('selected_listening_level');
                    
                    this.isLoading = false;
                    
                    window.location.href = '{{ route("santri.listening.result") }}';
                    return;
                }

                if (data.status === 'next_question') {
                    this.currentIndex = (data.progress?.current ?? 1) - 1;
                    this.isLoading = false;
                    
                    this.loadQuestion(data.question);
                    console.log('Loaded question', this.currentIndex + 1);
                }

            } catch (error) {
                console.error('Next question error:', error);
                
                this.isLoading = false;
                this.showFatalError(error.message);
            }
        },

        // Use Hint
        async useHint() {
            if (this.usedHint || this.isSubmitted || this.isLoading) {
                return;
            }

            this.isLoading = true;

            try {
                console.log('Requesting hint...');
                
                const result = await apiCall(API_ROUTES.hint, 'POST');

                if (!result.success) {
                    throw new Error(result.message || 'Gagal mendapatkan hint');
                }

                const data = result.data;
                
                this.usedHint = true;
                this.hintPenalty = data.penalty ?? 5;

                this.feedback = {
                    show: true,
                    isCorrect: false,
                    message: `💡 Hint: ${data.hint?.text || 'Perhatikan baik-baik audio yang diputar'}`,
                    breakdown: null,
                    correctAnswerDisplay: null,
                };

                console.log('Hint received. Penalty:', this.hintPenalty);

                setTimeout(() => {
                    if (this.feedback.message.includes('Hint:')) {
                        this.feedback.show = false;
                    }
                }, 5000);

            } catch (error) {
                console.error('Hint error:', error);
                alert(error.message);
            } finally {
                this.isLoading = false;
            }
        },

        // Confirm Cancel
        confirmCancel() {
            const confirmed = confirm(
                'Apakah Anda yakin ingin membatalkan game ini?\n\n' +
                'Skor Anda tidak akan disimpan dan progress akan hilang.'
            );

            if (confirmed) {
                this.cancelGame();
            }
        },

        // Cancel Game
        async cancelGame() {
            this.stopTimer();
            this.isLoading = true;

            try {
                console.log('Cancelling game...');
                await apiCall(API_ROUTES.cancel, 'POST');
                localStorage.removeItem('selected_listening_level');
                window.location.href = '{{ route('santri.listening.index') }}';
            } catch (error) {
                console.error('Cancel error:', error);
                alert('Terjadi kesalahan saat membatalkan. Anda akan diarahkan ke halaman utama.');
                window.location.href = '{{ route('santri.listening.index') }}';
            }
        }
    }
}

// Keyboard shortcuts
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('keydown', (e) => {
        if (e.code === 'Space' && e.target.tagName !== 'BUTTON' && e.target.tagName !== 'INPUT') {
            e.preventDefault();
            const playButton = document.querySelector('[\\@click="playAudio"]');
            if (playButton && !playButton.disabled) {
                playButton.click();
            }
        }
        
        if (e.code === 'Enter' && e.target.tagName !== 'BUTTON') {
            const submitButton = document.querySelector('[\\@click="submitAnswer"]');
            if (submitButton && !submitButton.disabled) {
                submitButton.click();
            }
        }
    });
});
</script>
@endpush