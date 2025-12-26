@extends('layouts.santri')

@section('title', 'Hasil Game Listening')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="gameResult()">

    <div x-show="isLoading" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="text-center py-10">
        <div class="animate-spin rounded-full h-12 w-12 border-b-4 border-teal-600 mx-auto mb-4"></div>
        <p class="text-gray-600 text-lg">Menghitung hasil akhir...</p>
        <p class="text-gray-400 text-sm mt-2">Mohon tunggu sebentar</p>
    </div>

    <div x-show="fatalError" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="max-w-2xl mx-auto">
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-md p-6 mb-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-lg font-bold text-red-800 mb-2">Terjadi Kesalahan</h3>
                    <p class="text-red-700 mb-4" x-text="fatalErrorMessage"></p>
                    <div class="flex gap-3">
                        <a href="{{ route('santri.listening.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="!isLoading && !fatalError" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="max-w-4xl mx-auto">

        <div class="bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-600 rounded-2xl shadow-2xl p-8 mb-8 text-white text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -ml-16 -mb-16"></div>
            
            <div class="relative z-10">
                <div class="text-7xl mb-4 animate-bounce" x-text="getEmoji()"></div>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-3">
                    <span x-text="getTitle()"></span>
                </h1>
                <p class="text-lg md:text-xl text-purple-100">
                    Level: <span class="font-bold text-white" x-text="result.summary.level_name || '-'"></span>
                </p>
                <p class="text-sm text-purple-200 mt-2" x-text="getSubtitle()"></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center border-b-4 border-green-500 transform hover:scale-105 transition-transform duration-200">
                <div class="text-green-500 text-3xl mb-2">✓</div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Jawaban Benar</p>
                <div class="text-4xl font-bold text-green-700 mb-1" x-text="result.summary.correct_answers || 0"></div>
                <p class="text-xs text-gray-400">
                    dari <span x-text="result.summary.total_questions || 0"></span> soal
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center border-b-4 border-yellow-500 transform hover:scale-105 transition-transform duration-200">
                <div class="text-yellow-500 text-3xl mb-2">⭐</div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Skor Total</p>
                <div class="text-4xl font-bold text-yellow-700 mb-1" x-text="result.summary.total_score || 0"></div>
                <p class="text-xs text-gray-400">poin yang diperoleh</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center border-b-4 border-purple-500 transform hover:scale-105 transition-transform duration-200">
                <div class="text-purple-500 text-3xl mb-2">🎯</div>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-1">Akurasi</p>
                <div class="text-4xl font-bold text-purple-700 mb-1" x-text="(result.summary.accuracy || 0) + '%'"></div>
                <p class="text-xs text-gray-400" x-text="getAccuracyLabel()"></p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-xl p-6 md:p-8 mb-8">
            <div class="flex items-center mb-6">
                <div class="text-3xl mr-3">🎁</div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Detail Reward</h2>
            </div>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center py-3 border-b border-gray-200 hover:bg-gray-50 px-3 rounded transition-colors">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">🏆</span>
                        <div>
                            <p class="font-medium text-gray-700">Poin</p>
                            <p class="text-xs text-gray-500">untuk Leaderboard</p>
                        </div>
                    </div>
                    <span class="text-teal-600 font-bold text-xl">
                        +<span x-text="result.rewards.points || 0"></span>
                    </span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-gray-200 hover:bg-gray-50 px-3 rounded transition-colors">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">⚡</span>
                        <div>
                            <p class="font-medium text-gray-700">EXP</p>
                            <p class="text-xs text-gray-500">untuk Level Up</p>
                        </div>
                    </div>
                    <span class="text-teal-600 font-bold text-xl">
                        +<span x-text="result.rewards.exp || 0"></span>
                    </span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-gray-200 hover:bg-gray-50 px-3 rounded transition-colors">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">🔥</span>
                        <div>
                            <p class="font-medium text-gray-700">Streak Tertinggi</p>
                            <p class="text-xs text-gray-500">jawaban benar berturut-turut</p>
                        </div>
                    </div>
                    <span class="text-orange-600 font-bold text-xl" x-text="result.summary.max_streak || 0"></span>
                </div>
            </div>

            <div x-show="isLevelUp()" 
                 x-transition:enter="transition ease-out duration-300 delay-500"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="mt-6 p-4 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-xl text-center shadow-lg">
                <div class="text-4xl mb-2">🚀</div>
                <p class="font-bold text-white text-lg">
                    SELAMAT! Anda Naik Level!
                </p>
                <p class="text-white text-xl font-extrabold mt-1">
                    Level <span x-text="user.old_level"></span> → Level <span x-text="user.new_level"></span>
                </p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
            <a href="{{ route('santri.listening.index') }}" 
               class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Kembali ke Menu Utama
            </a>
            
            <button @click="shareResult()" 
                    class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
                Bagikan Hasil
            </button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function gameResult() {
    return {
        isLoading: true,
        fatalError: false,
        fatalErrorMessage: '',
        result: {
            summary: {
                level_name: '',
                correct_answers: 0,
                total_questions: 0,
                total_score: 0,
                accuracy: 0,
                max_streak: 0
            },
            rewards: {
                points: 0,
                exp: 0,
                new_level: 0,
                level_up: false
            },
        },
        user: {
            new_level: 0,
            old_level: 0,
        },

        init() {
            setTimeout(() => {
                this.fetchResults();
            }, 100);
        },

        async fetchResults() {
            this.isLoading = true;
            this.fatalError = false;
            
            try {
                const resultData = sessionStorage.getItem('listeningGameResult');

                if (!resultData) {
                    throw new Error('Data hasil tidak ditemukan. Sesi mungkin berakhir atau Anda me-refresh halaman. Silakan mulai game baru.');
                }

                sessionStorage.removeItem('listeningGameResult');
                
                const response = JSON.parse(resultData);
                console.log('Raw response from sessionStorage:', response);
                
                let gameData;
                
                if (response.success && response.data && response.data.status === 'completed') {
                    console.log('Format A detected: { success, data: { status: completed } }');
                    gameData = response.data;
                } else if (response.status === 'completed') {
                    console.log('Format B detected: { status: completed }');
                    gameData = response;
                } else if (response.data && response.data.data && response.data.data.status === 'completed') {
                    console.log('Format C detected: nested double');
                    gameData = response.data.data;
                } else {
                    console.error('Invalid data structure:', response);
                    throw new Error('Format data tidak valid. Struktur response tidak sesuai.');
                }

                if (!gameData.summary || !gameData.rewards) {
                    console.error('Missing summary or rewards:', gameData);
                    throw new Error('Data hasil game tidak lengkap (summary atau rewards tidak ada).');
                }

                const { summary = {}, rewards = {} } = gameData;

                this.result = {
                    summary: {
                        level_name: summary.level_name || 'Unknown',
                        correct_answers: parseInt(summary.correct_answers) || 0,
                        total_questions: parseInt(summary.total_questions) || 0,
                        total_score: parseInt(summary.total_score) || 0,
                        accuracy: parseFloat(summary.accuracy) || 0,
                        max_streak: parseInt(summary.max_streak) || 0
                    },
                    rewards: {
                        points: parseInt(rewards.points) || 0,
                        exp: parseInt(rewards.exp) || 0,
                        new_level: parseInt(rewards.new_level) || 1,
                        level_up: Boolean(rewards.level_up)
                    }
                };

                this.user = {
                    new_level: this.result.rewards.new_level,
                    old_level: this.result.rewards.level_up 
                        ? this.result.rewards.new_level - 1 
                        : this.result.rewards.new_level
                };

                console.log('Result loaded successfully:', this.result);

            } catch (error) {
                console.error('Error fetching results:', error);
                this.showError(error.message);
            } finally {
                setTimeout(() => {
                    this.isLoading = false;
                }, 500);
            }
        },

        showError(message) {
            this.fatalError = true;
            this.fatalErrorMessage = message || 'Terjadi kesalahan yang tidak diketahui.';
            this.isLoading = false;
        },

        isLevelUp() {
            return this.result.rewards.level_up && this.user.new_level > this.user.old_level;
        },

        getEmoji() {
            const accuracy = this.result.summary.accuracy || 0;
            if (accuracy >= 90) return '🏆';
            if (accuracy >= 70) return '🎉';
            if (accuracy >= 50) return '👍';
            return '📚';
        },

        getTitle() {
            const accuracy = this.result.summary.accuracy || 0;
            if (accuracy >= 90) return 'Sempurna!';
            if (accuracy >= 70) return 'Bagus Sekali!';
            if (accuracy >= 50) return 'Lumayan!';
            return 'Tetap Semangat!';
        },

        getSubtitle() {
            const accuracy = this.result.summary.accuracy || 0;
            if (accuracy >= 90) return 'Penguasaan luar biasa!';
            if (accuracy >= 70) return 'Teruskan usaha yang bagus!';
            if (accuracy >= 50) return 'Masih ada ruang untuk berkembang!';
            return 'Jangan menyerah, terus berlatih!';
        },

        getAccuracyLabel() {
            const accuracy = this.result.summary.accuracy || 0;
            if (accuracy >= 90) return 'Luar Biasa!';
            if (accuracy >= 70) return 'Sangat Baik';
            if (accuracy >= 50) return 'Cukup Baik';
            return 'Perlu Latihan';
        },

        shareResult() {
            const accuracy = this.result.summary.accuracy || 0;
            const level = this.result.summary.level_name || 'Unknown';
            const score = this.result.summary.total_score || 0;
            
            const text = `🎮 Saya baru saja menyelesaikan Game Listening Level ${level}!\n\n` +
                        `✓ Skor: ${score}\n` +
                        `✓ Akurasi: ${accuracy}%\n` +
                        `✓ Jawaban Benar: ${this.result.summary.correct_answers}/${this.result.summary.total_questions}\n\n` +
                        `Ayo coba juga! 💪`;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('✅ Hasil berhasil disalin ke clipboard!');
                }).catch(() => {
                    this.fallbackCopyText(text);
                });
            } else {
                this.fallbackCopyText(text);
            }
        },

        fallbackCopyText(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                alert('✅ Hasil berhasil disalin ke clipboard!');
            } catch (err) {
                alert('❌ Gagal menyalin. Silakan salin secara manual:\n\n' + text);
            }
            document.body.removeChild(textarea);
        }
    }
}
</script>
@endpush