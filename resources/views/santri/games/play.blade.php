<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $game->title }} - TPQ Arabic Learning</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .fade-enter {
            opacity: 0;
            transform: translateX(20px);
        }
        .fade-enter-active {
            transition: opacity 0.3s, transform 0.3s;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 to-blue-50 min-h-screen">

    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('santri.dashboard') }}" class="text-2xl font-bold text-purple-600">🕌 TPQ Arabic</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="
            @if($game->type == 'tebak_gambar') bg-gradient-to-br from-pink-400 to-red-500
            @elseif($game->type == 'kosakata_tempat') bg-gradient-to-br from-blue-400 to-indigo-500
            @elseif($game->type == 'pilihan_ganda') bg-gradient-to-br from-green-400 to-teal-500
            @else bg-gradient-to-br from-yellow-400 to-orange-500
            @endif
            rounded-2xl shadow-2xl p-8 mb-8 text-white text-center
        ">
            <div class="text-6xl mb-4">
                @if($game->type == 'tebak_gambar')
                    🖼️
                @elseif($game->type == 'kosakata_tempat')
                    🏫
                @elseif($game->type == 'pilihan_ganda')
                    ✅
                @else
                    💬
                @endif
            </div>
            <h1 class="text-4xl font-bold mb-2">{{ $game->title }}</h1>
            <p class="text-lg opacity-90">{{ $game->description }}</p>
            <div class="mt-4 inline-block bg-white bg-opacity-20 px-6 py-2 rounded-full">
                <span class="font-semibold">{{ $questions->count() }} Soal</span>
            </div>
        </div>

        <form method="POST" action="{{ route('santri.games.submit', $game->id) }}" 
              x-data="{ 
                  currentQuestion: 0,
                  totalQuestions: {{ $questions->count() }},
                  answers: {},
                  nextQuestion() {
                      if (this.currentQuestion < this.totalQuestions - 1) {
                          this.currentQuestion++;
                      }
                  },
                  prevQuestion() {
                      if (this.currentQuestion > 0) {
                          this.currentQuestion--;
                      }
                  },
                  isAnswered(questionIndex) {
                      const questionId = this.getQuestionId(questionIndex);
                      return this.answers[questionId] !== undefined && this.answers[questionId] !== '';
                  },
                  getQuestionId(index) {
                      return document.querySelector(`[data-question-index='${index}']`)?.dataset?.questionId || '';
                  },
                  canSubmit() {
                      return Object.keys(this.answers).length === this.totalQuestions;
                  },
                  submitForm(event) {
                      if (!this.canSubmit()) {
                          alert('Mohon jawab semua pertanyaan terlebih dahulu!');
                          return;
                      }
                      if (confirm('Apakah kamu yakin ingin submit jawaban?')) {
                          event.target.submit();
                      }
                  }
              }"
              @submit.prevent="submitForm($event)">
            @csrf

            <!-- Progress Bar -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-600">Progress</span>
                    <span class="text-sm font-semibold text-purple-600" x-text="`${currentQuestion + 1} / ${totalQuestions}`"></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-3 rounded-full transition-all duration-300"
                         :style="`width: ${((currentQuestion + 1) / totalQuestions) * 100}%`"></div>
                </div>
            </div>

            <!-- Questions Container -->
            <div class="space-y-6">
                @foreach($questions as $index => $question)
                <div class="bg-white rounded-2xl shadow-xl p-8"
                     x-show="currentQuestion === {{ $index }}"
                     x-transition:enter="fade-enter fade-enter-active"
                     data-question-index="{{ $index }}"
                     data-question-id="{{ $question->id }}">
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-purple-100 text-purple-700 px-4 py-2 rounded-full font-bold text-sm">
                            Soal {{ $index + 1 }} dari {{ $questions->count() }}
                        </span>
                        <span class="text-sm" 
                              :class="isAnswered({{ $index }}) ? 'text-green-600 font-semibold' : 'text-gray-400'">
                            <span x-show="isAnswered({{ $index }})">✓ Terjawab</span>
                            <span x-show="!isAnswered({{ $index }})">Belum dijawab</span>
                        </span>
                    </div>

                    @if($question->image_path)
                    <div class="mb-6 text-center">
                        <img src="{{ asset('storage/' . $question->image_path) }}" 
                             alt="Question Image" 
                             class="max-w-full h-auto rounded-xl border-4 border-purple-200 mx-auto"
                             style="max-height: 300px;">
                    </div>
                    @endif

                    <div class="mb-6 bg-gradient-to-br from-purple-50 to-blue-50 rounded-xl p-6 border-2 border-purple-200">
                        <p class="text-xl text-gray-800 font-semibold text-center">
                            {{ $question->question_text }}
                        </p>
                    </div>

                    @if($question->options)
                        @php
                            $options = is_array($question->options) ? $question->options : json_decode($question->options, true);
                        @endphp
                        
                        <div class="space-y-3">
                            @foreach($options as $optIndex => $option)
                            <label class="flex items-center gap-4 p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-purple-400 hover:bg-purple-50 transition-all"
                                   :class="answers[{{ $question->id }}] === '{{ $option }}' ? 'border-purple-500 bg-purple-50' : ''">
                                <input type="radio" 
                                       name="answers[{{ $question->id }}]" 
                                       value="{{ $option }}" 
                                       class="w-5 h-5 text-purple-600"
                                       x-model="answers[{{ $question->id }}]"
                                       required>
                                <span class="flex-1 text-gray-800 font-medium">
                                    {{ chr(65 + $optIndex) }}. {{ $option }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    @else
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Jawaban Kamu:</label>
                            <input type="text" 
                                   name="answers[{{ $question->id }}]" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all"
                                   placeholder="Ketik jawabanmu di sini..."
                                   x-model="answers[{{ $question->id }}]"
                                   required>
                        </div>
                    @endif

                </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-8 flex gap-4">
                <button type="button"
                        @click="prevQuestion()"
                        x-show="currentQuestion > 0"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 py-4 rounded-xl font-bold text-lg transition-colors">
                    ← Sebelumnya
                </button>
                
                <a href="{{ route('santri.games.index') }}"
                   x-show="currentQuestion === 0"
                   class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 text-center py-4 rounded-xl font-bold text-lg transition-colors">
                    ← Batal
                </a>
                
                <button type="button"
                        @click="nextQuestion()"
                        x-show="currentQuestion < totalQuestions - 1"
                        class="flex-1 bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white py-4 rounded-xl font-bold text-lg transition-colors">
                    Selanjutnya →
                </button>
                
                <button type="submit" 
                        x-show="currentQuestion === totalQuestions - 1"
                        class="flex-1 bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white py-4 rounded-xl font-bold text-lg transition-colors transform hover:scale-105"
                        :disabled="!canSubmit()"
                        :class="!canSubmit() ? 'opacity-50 cursor-not-allowed' : ''">
                    ✓ Submit Jawaban
                </button>
            </div>

            <!-- Question Navigator -->
            <div class="mt-6 bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-sm font-semibold text-gray-600 mb-3">Navigasi Soal:</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($questions as $index => $question)
                    <button type="button"
                            @click="currentQuestion = {{ $index }}"
                            class="w-12 h-12 rounded-lg font-bold text-sm transition-all"
                            :class="{
                                'bg-purple-500 text-white': currentQuestion === {{ $index }},
                                'bg-green-100 text-green-700 border-2 border-green-500': currentQuestion !== {{ $index }} && isAnswered({{ $index }}),
                                'bg-gray-200 text-gray-600': currentQuestion !== {{ $index }} && !isAnswered({{ $index }})
                            }">
                        {{ $index + 1 }}
                    </button>
                    @endforeach
                </div>
            </div>

        </form>

    </div>

</body>
</html>