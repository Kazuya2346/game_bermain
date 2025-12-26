@extends('layouts.ustadz')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Pertanyaan
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

            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Error!</p>
                    <p>{{ session('error') }}</p>
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
                        <p class="text-sm opacity-90">
                            @if($game->type === 'tebak_gambar') Tebak Kosakata dari Gambar
                            @elseif($game->type === 'kosakata_tempat') Kosakata di 30 Tempat
                            @elseif($game->type === 'pilihan_ganda') Pilihan Ganda Melengkapi Kalimat
                            @else Percakapan di 20 Tempat
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg p-8"
                 x-data="{ 
                     answerType: '{{ old('answer_type', $question->answer_type ?? 'multiple_choice') }}',
                     options: {{ json_encode(old('options', $options ?? ['', '', '', ''])) }}
                 }">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Edit Pertanyaan</h3>
                    <p class="text-gray-600">Update informasi pertanyaan</p>
                </div>

                <form action="{{ route('ustadz.games.questions.update', [$game->id, $question->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                    name="answer_type" 
                                    value="multiple_choice"
                                    x-model="answerType"
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
                                    name="answer_type" 
                                    value="essay"
                                    x-model="answerType"
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
                        <p class="text-sm text-gray-500 mt-3 flex items-center gap-2">
                            <span>💡</span>
                            <span><strong>Current:</strong> 
                                <span x-show="answerType === 'multiple_choice'" class="text-purple-700 font-semibold">Pilihan Ganda</span>
                                <span x-show="answerType === 'essay'" class="text-blue-700 font-semibold">Essay</span>
                            </span>
                        </p>
                    </div>

                    <!-- Pertanyaan -->
                    <div class="mb-6">
                        <label for="question_text" class="block text-sm font-bold text-gray-700 mb-2">
                            Pertanyaan <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="question_text" 
                            id="question_text" 
                            rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                            placeholder="Contoh: Apa bahasa Arab dari 'rumah'?"
                            required
                        >{{ old('question_text', $question->question_text) }}</textarea>
                        @error('question_text')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Gambar (untuk tebak_gambar) -->
                    @if($game->type === 'tebak_gambar' || $game->type === 'kosakata_tempat')
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-bold text-gray-700 mb-2">
                                Upload Gambar Baru (opsional)
                            </label>
                            
                            @if($question->image_path)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $question->image_path) }}" alt="Current Image" class="w-48 h-48 object-cover rounded-lg border-4 border-gray-300 shadow-md">
                                </div>
                            @endif
                            
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                accept="image/*"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                            >
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah gambar.</p>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Nama Lokasi (untuk kosakata_tempat dan percakapan) -->
                    @if($game->type === 'kosakata_tempat' || $game->type === 'percakapan')
                        <div class="mb-6">
                            <label for="location_name" class="block text-sm font-bold text-gray-700 mb-2">
                                Nama Tempat <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="location_name" 
                                id="location_name" 
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                                required
                            >
                                <option value="">-- Pilih Tempat --</option>
                                @foreach($locationOptions as $location)
                                    <option value="{{ $location }}" {{ old('location_name', $question->location_name) == $location ? 'selected' : '' }}>
                                        {{ $location }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Pilihan Jawaban (Hanya untuk Multiple Choice) -->
                    <div x-show="answerType === 'multiple_choice'" class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Pilihan Jawaban <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-3">
                            <template x-for="i in 4" :key="i">
                                <div class="flex items-center space-x-2">
                                    <span class="bg-gradient-to-r from-purple-200 to-pink-200 text-gray-700 font-bold px-3 py-2 rounded" x-text="String.fromCharCode(64 + i)"></span>
                                    <input 
                                        type="text" 
                                        name="options[]" 
                                        x-model="options[i - 1]"
                                        class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                                        :placeholder="'Pilihan ' + String.fromCharCode(64 + i)"
                                        :required="answerType === 'multiple_choice'"
                                    >
                                </div>
                            </template>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Isi semua 4 pilihan untuk pilihan ganda</p>
                        @error('options')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jawaban yang Benar -->
                    <div class="mb-6">
                        <label for="correct_answer" class="block text-sm font-bold text-gray-700 mb-2">
                            Jawaban yang Benar <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="correct_answer" 
                            id="correct_answer" 
                            value="{{ old('correct_answer', $question->correct_answer) }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                            placeholder="Contoh: بَيْتٌ"
                            required
                        >
                        <p class="text-sm text-gray-500 mt-1" x-show="answerType === 'multiple_choice'">
                            ⚠️ Harus sama persis dengan salah satu pilihan di atas
                        </p>
                        <p class="text-sm text-gray-500 mt-1" x-show="answerType === 'essay'">
                            💡 Jawaban yang akan dicocokkan dengan input santri (case-insensitive)
                        </p>
                        @error('correct_answer')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Indicator Badge -->
                    <div class="mb-6 flex items-center gap-2">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold" 
                              :class="answerType === 'multiple_choice' ? 'bg-purple-100 text-purple-700 border-2 border-purple-300' : 'bg-blue-100 text-blue-700 border-2 border-blue-300'">
                            <span x-text="answerType === 'multiple_choice' ? '✅' : '✍️'"></span>
                            <span x-text="answerType === 'multiple_choice' ? 'Pilihan Ganda' : 'Essay'"></span>
                        </span>
                    </div>

                    <!-- Info Box -->
                    <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                        <div class="flex items-start">
                            <div class="text-2xl mr-3">⚠️</div>
                            <div>
                                <p class="font-bold text-yellow-800 mb-1">Perhatian:</p>
                                <ul class="text-sm text-yellow-700 space-y-1">
                                    <li>• Pastikan semua perubahan sudah benar sebelum menyimpan</li>
                                    <li>• Perubahan tipe jawaban akan mengubah cara pertanyaan ditampilkan</li>
                                    <li>• Perubahan jawaban dapat mempengaruhi skor yang sudah ada</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('ustadz.games.questions.index', $game->id) }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600 transition font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                            💾 Update Pertanyaan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection