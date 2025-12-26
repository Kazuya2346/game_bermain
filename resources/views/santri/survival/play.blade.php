@extends('layouts.santri')

@section('title', 'Survival Quiz')

@section('content')
<div class="container mx-auto px-4 py-8 relative">
    <!-- Enhanced Header with Animation -->
    <div class="relative overflow-hidden rounded-3xl shadow-2xl mb-8"
         x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 100)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-[-20px]">
        
        <div class="absolute inset-0 bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500 animate-gradient"></div>
        
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full -ml-32 -mb-32 blur-2xl"></div>
        
        <div class="relative p-8 text-white">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-5xl animate-bounce">🔥</span>
                        <h1 class="text-4xl font-extrabold drop-shadow-lg">Survival Quiz</h1>
                    </div>
                    <p class="text-lg opacity-95 mb-2">Jawab sebanyak mungkin sebelum waktu habis!</p>
                    <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full inline-flex border-2 border-white/30">
                        <span class="text-xl">🏆</span>
                        <span class="font-bold">High Score:</span>
                        <span class="text-yellow-300 font-bold text-xl">{{ $highScore }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Game Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="glass-card rounded-2xl shadow-xl p-6 text-center transform hover:scale-105 transition-all">
            <div class="text-gray-600 text-sm mb-2 font-semibold flex items-center justify-center gap-2">
                <span class="text-lg">📊</span>
                <span>Skor</span>
            </div>
            <div id="score-display" class="text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">0</div>
        </div>
        <div class="glass-card rounded-2xl shadow-xl p-6 text-center transform hover:scale-105 transition-all">
            <div class="text-gray-600 text-sm mb-2 font-semibold flex items-center justify-center gap-2">
                <span class="text-lg">⏱️</span>
                <span>Waktu</span>
            </div>
            <div id="timer-display" class="text-5xl font-extrabold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">30</div>
        </div>
        <div class="glass-card rounded-2xl shadow-xl p-6 text-center transform hover:scale-105 transition-all">
            <div class="text-gray-600 text-sm mb-2 font-semibold flex items-center justify-center gap-2">
                <span class="text-lg">💖</span>
                <span>Lives</span>
            </div>
            <div id="lives-display" class="text-4xl font-bold">❤️❤️❤️</div>
        </div>
    </div>

    <!-- Enhanced Game Container -->
    <div id="game-container" class="glass-card rounded-3xl shadow-2xl p-8 lg:p-12">
        <!-- Start Screen -->
        <div id="start-screen" class="text-center">
            <div class="mb-8">
                <div class="inline-block mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-400 rounded-3xl blur-xl opacity-50 animate-pulse"></div>
                        <div class="relative bg-gradient-to-br from-green-500 to-blue-500 rounded-3xl p-8 shadow-2xl">
                            <span class="text-8xl">🎮</span>
                        </div>
                    </div>
                </div>
                <h2 class="text-4xl font-extrabold mb-6 bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">Siap Bermain?</h2>
                
                <div class="max-w-lg mx-auto space-y-3 text-left">
                    <div class="flex items-start gap-3 bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border-2 border-green-200">
                        <span class="text-2xl flex-shrink-0">✅</span>
                        <p class="text-gray-700 font-medium">Jawab soal dengan benar untuk dapat poin</p>
                    </div>
                    <div class="flex items-start gap-3 bg-gradient-to-r from-red-50 to-orange-50 p-4 rounded-xl border-2 border-red-200">
                        <span class="text-2xl flex-shrink-0">❌</span>
                        <p class="text-gray-700 font-medium">Jawaban salah mengurangi nyawa</p>
                    </div>
                    <div class="flex items-start gap-3 bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-xl border-2 border-purple-200">
                        <span class="text-2xl flex-shrink-0">💀</span>
                        <p class="text-gray-700 font-medium">Habis nyawa = Game Over</p>
                    </div>
                    <div class="flex items-start gap-3 bg-gradient-to-r from-yellow-50 to-amber-50 p-4 rounded-xl border-2 border-yellow-200">
                        <span class="text-2xl flex-shrink-0">⭐</span>
                        <p class="text-gray-700 font-medium">Dapatkan XP untuk naik level!</p>
                    </div>
                </div>
            </div>
            <button 
                type="button"
                id="start-game-btn"
                class="relative overflow-hidden bg-gradient-to-r from-green-500 via-emerald-500 to-blue-500 hover:from-green-600 hover:via-emerald-600 hover:to-blue-600 text-white px-12 py-5 rounded-2xl font-bold text-2xl transition-all transform hover:scale-110 active:scale-95 shadow-2xl cursor-pointer group">
                <span class="relative z-10 flex items-center justify-center gap-3">
                    <span class="text-3xl group-hover:rotate-12 transition-transform">🚀</span>
                    <span>MULAI GAME</span>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-200%] transition-transform duration-1000"></div>
            </button>
        </div>

        <!-- Question Screen -->
        <div id="question-screen" class="hidden">
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 pb-4 border-b-2 border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="bg-gradient-to-br from-purple-500 to-blue-500 text-white w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg shadow-lg">
                            <span id="question-number">1</span>
                        </div>
                        <span class="text-gray-600 font-semibold">Soal ke-<span id="question-number-text">1</span></span>
                    </div>
                    <span class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-100 to-red-100 text-orange-700 px-4 py-2 rounded-full text-sm font-bold border-2 border-orange-300">
                        <span class="text-lg">🔥</span>
                        <span>Survival Quiz</span>
                    </span>
                </div>
                
                <div class="relative mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-100 via-blue-100 to-indigo-100 rounded-2xl blur-sm"></div>
                    <div class="relative bg-gradient-to-br from-purple-50 via-blue-50 to-indigo-50 rounded-2xl p-6 lg:p-8 border-2 border-purple-200 shadow-lg">
                        <div class="flex items-start gap-4">
                            <span class="text-4xl flex-shrink-0">❓</span>
                            <h3 id="question-text" class="text-xl lg:text-2xl font-bold text-gray-800 leading-relaxed"></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div id="options-container" class="space-y-4">
                <!-- Options akan di-generate oleh JavaScript -->
            </div>

            <div id="feedback-message" class="mt-8 p-6 rounded-2xl text-center font-bold text-lg hidden shadow-lg"></div>
        </div>
    </div>
</div>

<!-- Enhanced Game Over Modal with Higher Z-Index -->
<div id="game-over-modal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-[9999] p-4">
    <div class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full mx-4 overflow-hidden transform scale-95 opacity-0 transition-all duration-500" id="modal-content">
        
        <!-- Decorative Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-purple-100 via-blue-100 to-indigo-100 opacity-50"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-purple-300/30 rounded-full blur-3xl -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-300/30 rounded-full blur-3xl -ml-32 -mb-32"></div>
        
        <div class="relative p-8 lg:p-10">
            <!-- Animated Trophy -->
            <div class="text-center mb-6">
                <div class="inline-block relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full blur-2xl opacity-50 animate-pulse"></div>
                    <div class="relative text-8xl animate-bounce">🎮</div>
                </div>
            </div>
            
            <h2 class="text-4xl font-extrabold text-center mb-6 bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 bg-clip-text text-transparent">
                Game Over!
            </h2>
            
            <!-- Score Display -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-8 mb-6 border-2 border-gray-200 shadow-inner">
                <p class="text-gray-600 text-sm mb-2 font-semibold text-center">Skor Akhir</p>
                <div class="flex items-center justify-center gap-3 mb-6">
                    <span class="text-3xl">🎯</span>
                    <p id="final-score" class="text-6xl font-extrabold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">0</p>
                </div>
                
                <div id="high-score-message" class="space-y-4">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button 
                    type="button"
                    onclick="location.reload()" 
                    class="w-full relative overflow-hidden bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 text-white px-6 py-4 rounded-xl font-bold text-lg transition-all transform hover:scale-105 active:scale-95 shadow-lg cursor-pointer group">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <span class="text-2xl group-hover:rotate-180 transition-transform duration-500">🔄</span>
                        <span>Main Lagi</span>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 translate-x-full group-hover:translate-x-[-200%] transition-transform duration-700"></div>
                </button>
                
                <a href="{{ route('santri.dashboard') }}" 
                   class="block w-full bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-4 rounded-xl font-bold text-lg transition-all transform hover:scale-105 active:scale-95 shadow-lg text-center">
                    <span class="flex items-center justify-center gap-2">
                        <span class="text-2xl">🏠</span>
                        <span>Kembali ke Dashboard</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Glass morphism effect */
.glass-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Gradient animation */
@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
}

/* Modal animation */
#game-over-modal.show #modal-content {
    transform: scale(1);
    opacity: 1;
}
</style>

<script>
    // Game Data
    const questions = @json($questions);
    let currentQuestionIndex = 0;
    let score = 0;
    let lives = 3;
    let timeLeft = 30;
    let timerInterval;
    let gameOver = false;

    // Initialize game when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Game initialized with', questions.length, 'questions');
        
        // Shuffle questions
        shuffleArray(questions);
        
        // Add event listener to start button
        const startBtn = document.getElementById('start-game-btn');
        if (startBtn) {
            startBtn.addEventListener('click', function() {
                console.log('Start button clicked');
                startGame();
            });
        }
    });

    // Game Functions
    function startGame() {
        console.log('Starting game...');
        
        document.getElementById('start-screen').classList.add('hidden');
        document.getElementById('question-screen').classList.remove('hidden');
        
        currentQuestionIndex = 0;
        score = 0;
        lives = 3;
        timeLeft = 30;
        gameOver = false;
        
        updateDisplay();
        loadQuestion();
        startTimer();
    }

    function startTimer() {
        timerInterval = setInterval(() => {
            timeLeft--;
            document.getElementById('timer-display').textContent = timeLeft;
            
            // Warning effect saat waktu < 10 detik
            if (timeLeft <= 10) {
                document.getElementById('timer-display').classList.add('animate-pulse');
            }
            
            if (timeLeft <= 0) {
                endGame();
            }
        }, 1000);
    }

    function loadQuestion() {
        if (currentQuestionIndex >= questions.length) {
            // Jika soal habis, muat ulang soal dari awal
            currentQuestionIndex = 0;
            shuffleArray(questions);
        }

        const question = questions[currentQuestionIndex];
        document.getElementById('question-number').textContent = currentQuestionIndex + 1;
        document.getElementById('question-number-text').textContent = currentQuestionIndex + 1;
        document.getElementById('question-text').textContent = question.question_text;
        
        // Reset feedback message
        const feedbackEl = document.getElementById('feedback-message');
        feedbackEl.classList.add('hidden');
        
        // Acak pilihan jawaban sebelum ditampilkan
        shuffleArray(question.options);
        
        // Load options with enhanced styling
        const optionsContainer = document.getElementById('options-container');
        optionsContainer.innerHTML = '';
        
        question.options.forEach((option, index) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'group w-full bg-white hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 border-2 border-gray-300 hover:border-blue-500 rounded-xl p-5 text-left font-semibold transition-all transform hover:scale-[1.02] hover:shadow-lg cursor-pointer';
            
            button.innerHTML = `
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gradient-to-br from-purple-100 to-blue-100 group-hover:from-purple-500 group-hover:to-blue-500 flex items-center justify-center font-bold text-purple-600 group-hover:text-white transition-all border-2 border-purple-300 group-hover:border-transparent">
                        ${String.fromCharCode(65 + index)}
                    </div>
                    <span class="flex-1 text-gray-800 text-base lg:text-lg">${option}</span>
                </div>
            `;
            
            button.addEventListener('click', function() {
                checkAnswer(option, question.correct_answer);
            });
            optionsContainer.appendChild(button);
        });
    }

    function checkAnswer(userAnswer, correctAnswer) {
        if (gameOver) return;

        const feedbackEl = document.getElementById('feedback-message');
        const isCorrect = userAnswer.toLowerCase().trim() === correctAnswer.toLowerCase().trim();

        if (isCorrect) {
            // Jawaban Benar
            score++;
            timeLeft += 5; // Bonus waktu
            
            feedbackEl.innerHTML = `
                <div class="flex items-center justify-center gap-3">
                    <span class="text-3xl">✅</span>
                    <span>Benar! +5 detik bonus</span>
                </div>
            `;
            feedbackEl.className = 'mt-8 p-6 rounded-2xl text-center font-bold text-lg bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-2 border-green-300 shadow-lg';
            feedbackEl.classList.remove('hidden');
            
            updateDisplay();
            
            setTimeout(() => {
                currentQuestionIndex++;
                loadQuestion();
            }, 1000);
            
        } else {
            // Jawaban Salah
            lives--;
            
            feedbackEl.innerHTML = `
                <div class="space-y-2">
                    <div class="flex items-center justify-center gap-3">
                        <span class="text-3xl">❌</span>
                        <span>Salah!</span>
                    </div>
                    <div class="text-sm">Jawaban yang benar: <span class="font-extrabold">${correctAnswer}</span></div>
                </div>
            `;
            feedbackEl.className = 'mt-8 p-6 rounded-2xl text-center font-bold text-lg bg-gradient-to-r from-red-100 to-orange-100 text-red-800 border-2 border-red-300 shadow-lg';
            feedbackEl.classList.remove('hidden');
            
            updateDisplay();
            
            if (lives <= 0) {
                setTimeout(() => {
                    endGame();
                }, 1500);
            } else {
                setTimeout(() => {
                    currentQuestionIndex++;
                    loadQuestion();
                }, 1500);
            }
        }
    }

    function updateDisplay() {
        document.getElementById('score-display').textContent = score;
        document.getElementById('timer-display').textContent = timeLeft;
        
        // Update lives display
        const heartsArray = Array(lives).fill('❤️');
        const emptyHearts = Array(3 - lives).fill('🖤');
        document.getElementById('lives-display').textContent = heartsArray.concat(emptyHearts).join('');
    }

    function endGame() {
        gameOver = true;
        clearInterval(timerInterval);
        
        // Submit score ke backend
        fetch('{{ route("santri.survival.submit") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                score: score,
                correct_answers: score,
                total_questions: questions.length
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response:', data);
            
            // 📊 TAMPILKAN HASIL (DENGAN XP & LEVEL INFO) - ENHANCED VERSION
            document.getElementById('final-score').textContent = score;
            
            let message = '';
            
            // New Record Badge
            if (data.is_new_record) {
                message += `
                    <div class="relative overflow-hidden bg-gradient-to-r from-yellow-400 via-orange-400 to-red-400 rounded-xl p-4 mb-4 animate-pulse">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 animate-gradient"></div>
                        <div class="relative flex items-center justify-center gap-2 text-white font-extrabold text-xl">
                            <span class="text-3xl">🎉</span>
                            <span>REKOR BARU!</span>
                            <span class="text-3xl">🎉</span>
                        </div>
                    </div>
                `;
            }
            
            // High Score Display
            message += `
                <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-xl p-4 mb-4 border-2 border-gray-300">
                    <div class="flex items-center justify-center gap-2 text-gray-700">
                        <span class="text-2xl">🏆</span>
                        <span class="text-sm font-semibold">High Score:</span>
                        <span class="text-3xl font-extrabold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent">${data.high_score}</span>
                    </div>
                </div>
            `;
            
            // XP Earned Card
            message += `
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-100 to-cyan-100 rounded-xl p-4 mb-3 border-2 border-blue-300 shadow-md">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-3xl">⭐</span>
                            <div>
                                <div class="text-blue-800 font-bold text-lg">+${data.xp_earned} XP</div>
                                <div class="text-blue-600 text-xs">Experience Points</div>
                            </div>
                        </div>
                        <div class="text-4xl opacity-20">✨</div>
                    </div>
                </div>
            `;
            
            // Level Info Card
            message += `
                <div class="relative overflow-hidden bg-gradient-to-br from-purple-100 to-indigo-100 rounded-xl p-4 border-2 border-purple-300 shadow-md">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <span class="text-3xl">🎯</span>
                            <div>
                                <div class="text-purple-800 font-bold text-lg">Level ${data.new_level}</div>
                                <div class="text-purple-600 text-sm font-semibold">${data.level_name}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-purple-700 text-xs">Total XP</div>
                            <div class="text-purple-800 font-bold text-lg">${data.total_xp}</div>
                        </div>
                    </div>
                    
                    <!-- XP Progress Bar -->
                    <div class="mt-3">
                        <div class="w-full bg-purple-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 h-2 rounded-full transition-all duration-500" 
                                 style="width: ${(data.total_xp % 100)}%"></div>
                        </div>
                        <div class="text-purple-600 text-xs text-center mt-1">${data.total_xp % 100}/100 XP to next level</div>
                    </div>
                </div>
            `;
            
            document.getElementById('high-score-message').innerHTML = message;
            
            // Show modal with animation
            const modal = document.getElementById('game-over-modal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan skor');
            const modal = document.getElementById('game-over-modal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        });
    }

    // Utility function to shuffle array
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }
</script>
@endsection