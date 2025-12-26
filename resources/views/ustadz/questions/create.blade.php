@extends('layouts.ustadz')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tambah Pertanyaan Baru (Mode Bulk)
                </h2>
                <p class="text-sm text-gray-600 mt-1">Game: {{ $game->title }}</p>
            </div>
            <a href="{{ route('ustadz.games.questions.index', $game->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Error!</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Game Info Card -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl p-6 mb-6 text-white">
                <div class="flex items-center space-x-4">
                    <div class="text-5xl">
                        @if($game->type === 'tebak_gambar') 🖼️
                        @elseif($game->type === 'kosakata_tempat') 🏠
                        @elseif($game->type === 'pilihan_ganda') ✅
                        @else 💬
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $game->title }}</h1>
                        <p class="text-sm opacity-90">{{ $game->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Info Box Fleksibilitas -->
            <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-4 rounded-lg">
                <div class="flex items-start">
                    <div class="text-3xl mr-3">✨</div>
                    <div>
                        <p class="font-bold text-blue-800 mb-1">Fitur Baru: Tipe Jawaban Fleksibel!</p>
                        <p class="text-sm text-blue-700">Setiap pertanyaan bisa memiliki <strong>tipe jawaban berbeda</strong>. Anda bisa membuat pertanyaan dengan <strong>Pilihan Ganda</strong> atau <strong>Essay</strong> dalam satu game yang sama!</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('ustadz.games.questions.store', $game->id) }}" method="POST" enctype="multipart/form-data"
                  x-data="{ 
                      questions: [
                          { 
                              id: 1,
                              answer_type: 'multiple_choice',
                              question_text: '', 
                              correct_answer: '', 
                              location_name: '', 
                              options: ['', '', '', ''] 
                          }
                      ],
                      addQuestion() {
                          this.questions.push({ 
                              id: Date.now(),
                              answer_type: 'multiple_choice',
                              question_text: '', 
                              correct_answer: '', 
                              location_name: '', 
                              options: ['', '', '', ''] 
                          });
                      },
                      removeQuestion(index) {
                          if (this.questions.length > 1) {
                              this.questions.splice(index, 1);
                          }
                      }
                  }">
                @csrf

                <div class="space-y-8">
                    
                    <template x-for="(question, index) in questions" :key="question.id">
                        <div class="bg-white rounded-xl shadow-lg p-8 border-4 border-purple-100 relative">
                            
                            <!-- Header Pertanyaan & Tombol Hapus -->
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-800">
                                    Pertanyaan #<span x-text="index + 1"></span>
                                </h3>
                                <button 
                                    type="button" 
                                    @click="removeQuestion(index)"
                                    x-show="questions.length > 1"
                                    class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition font-medium">
                                    🗑️ Hapus Soal Ini
                                </button>
                            </div>

                            <!-- ✨ PILIHAN TIPE JAWABAN (BARU!) -->
                            <div class="mb-6 bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-300 rounded-xl p-6">
                                <label class="block text-sm font-bold text-gray-700 mb-3">
                                    <span class="text-lg">🎯</span> Tipe Jawaban <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Pilihan Ganda -->
                                    <label class="relative cursor-pointer group">
                                        <input 
                                            type="radio" 
                                            :name="'questions[' + index + '][answer_type]'" 
                                            value="multiple_choice"
                                            x-model="question.answer_type"
                                            class="peer sr-only"
                                            required
                                        >
                                        <div class="border-3 border-gray-300 rounded-xl p-4 transition-all peer-checked:border-purple-500 peer-checked:bg-purple-50 peer-checked:shadow-lg hover:border-purple-300 hover:shadow-md">
                                            <div class="flex items-center gap-3">
                                                <div class="text-3xl">✅</div>
                                                <div>
                                                    <div class="font-bold text-gray-800">Pilihan Ganda</div>
                                                    <div class="text-xs text-gray-600">Multiple Choice (A, B, C, D)</div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Essay -->
                                    <label class="relative cursor-pointer group">
                                        <input 
                                            type="radio" 
                                            :name="'questions[' + index + '][answer_type]'" 
                                            value="essay"
                                            x-model="question.answer_type"
                                            class="peer sr-only"
                                        >
                                        <div class="border-3 border-gray-300 rounded-xl p-4 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-lg hover:border-blue-300 hover:shadow-md">
                                            <div class="flex items-center gap-3">
                                                <div class="text-3xl">✍️</div>
                                                <div>
                                                    <div class="font-bold text-gray-800">Essay</div>
                                                    <div class="text-xs text-gray-600">Jawaban Singkat (Teks)</div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Pertanyaan -->
                            <div class="mb-6">
                                <label :for="'question_text_' + index" class="block text-sm font-bold text-gray-700 mb-2">
                                    Pertanyaan <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    :name="'questions[' + index + '][question_text]'" 
                                    :id="'question_text_' + index" 
                                    rows="3"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                                    placeholder="Contoh: Apa bahasa Arab dari 'rumah'?"
                                    required
                                    x-model="question.question_text"
                                ></textarea>
                            </div>

                            <!-- Upload Gambar -->
                            @if($game->type === 'tebak_gambar' || $game->type === 'kosakata_tempat')
                                <div class="mb-6">
                                    <label :for="'image_' + index" class="block text-sm font-bold text-gray-700 mb-2">
                                        Upload Gambar @if($game->type === 'tebak_gambar')<span class="text-red-500">*</span>@endif
                                    </label>
                                    <input 
                                        type="file" 
                                        :name="'questions[' + index + '][image]'" 
                                        :id="'image_' + index" 
                                        accept="image/*"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                                        @if($game->type === 'tebak_gambar') required @endif
                                    >
                                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                                </div>
                            @endif

                            <!-- Nama Lokasi -->
                            @if($game->type === 'kosakata_tempat' || $game->type === 'percakapan')
                                <div class="mb-6">
                                    <label :for="'location_name_' + index" class="block text-sm font-bold text-gray-700 mb-2">
                                        Nama Tempat <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        :name="'questions[' + index + '][location_name]'" 
                                        :id="'location_name_' + index" 
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                                        required
                                        x-model="question.location_name"
                                    >
                                        <option value="">-- Pilih Tempat --</option>
                                        @foreach($locationOptions as $location)
                                            <option value="{{ $location }}">{{ $location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Pilihan Jawaban (Hanya untuk Multiple Choice) -->
                            <div x-show="question.answer_type === 'multiple_choice'" class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Pilihan Jawaban <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-3">
                                    <template x-for="i in 4" :key="i">
                                        <div class="flex items-center space-x-2">
                                            <span class="bg-gradient-to-r from-purple-200 to-pink-200 text-gray-700 font-bold px-3 py-2 rounded" x-text="String.fromCharCode(64 + i)"></span>
                                            <input 
                                                type="text" 
                                                :name="'questions[' + index + '][options][]'" 
                                                x-model="question.options[i - 1]"
                                                class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                                                :placeholder="'Pilihan ' + String.fromCharCode(64 + i)"
                                                :required="question.answer_type === 'multiple_choice'"
                                            >
                                        </div>
                                    </template>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Isi semua 4 pilihan untuk pilihan ganda</p>
                            </div>

                            <!-- Jawaban yang Benar -->
                            <div class="mb-6">
                                <label :for="'correct_answer_' + index" class="block text-sm font-bold text-gray-700 mb-2">
                                    Jawaban yang Benar <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    :name="'questions[' + index + '][correct_answer]'" 
                                    :id="'correct_answer_' + index" 
                                    x-model="question.correct_answer"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                                    placeholder="Contoh: بَيْتٌ"
                                    required
                                >
                                <p class="text-sm text-gray-500 mt-1" x-show="question.answer_type === 'multiple_choice'">
                                    ⚠️ Harus sama persis dengan salah satu pilihan di atas
                                </p>
                                <p class="text-sm text-gray-500 mt-1" x-show="question.answer_type === 'essay'">
                                    💡 Jawaban yang akan dicocokkan dengan input santri (case-insensitive)
                                </p>
                            </div>

                            <!-- Indicator Badge -->
                            <div class="mt-4 flex items-center gap-2">
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold" 
                                      :class="question.answer_type === 'multiple_choice' ? 'bg-purple-100 text-purple-700 border-2 border-purple-300' : 'bg-blue-100 text-blue-700 border-2 border-blue-300'">
                                    <span x-text="question.answer_type === 'multiple_choice' ? '✅' : '✍️'"></span>
                                    <span x-text="question.answer_type === 'multiple_choice' ? 'Pilihan Ganda' : 'Essay'"></span>
                                </span>
                            </div>

                        </div>
                    </template>

                </div>

                <!-- Tombol Aksi -->
                <div class="mt-8">
                    <!-- Tombol Tambah Soal -->
                    <button 
                        type="button" 
                        @click="addQuestion()"
                        class="w-full mb-6 px-6 py-4 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 rounded-lg hover:from-blue-200 hover:to-indigo-200 transition font-bold text-center border-2 border-blue-300 border-dashed hover:border-solid transform hover:scale-105">
                        ➕ Tambah Soal Baru
                    </button>

                    <!-- Info Box -->
                    <div class="mb-6 bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 p-4 rounded-lg">
                        <div class="flex items-start">
                            <div class="text-2xl mr-3">💡</div>
                            <div>
                                <p class="font-bold text-emerald-800 mb-1">Tips:</p>
                                <ul class="text-sm text-emerald-700 list-disc list-inside space-y-1">
                                    <li>Anda bisa membuat <strong>variasi tipe jawaban</strong> dalam satu game</li>
                                    <li>Pilihan Ganda: untuk soal yang membutuhkan opsi pilihan</li>
                                    <li>Essay: untuk soal yang membutuhkan jawaban singkat</li>
                                    <li>Pastikan semua field yang bertanda <span class="text-red-500">*</span> terisi</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('ustadz.games.questions.index', $game->id) }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:from-green-600 hover:to-teal-600 transition font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                            ✅ Simpan Semua Pertanyaan
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection