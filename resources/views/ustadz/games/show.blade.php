@extends('layouts.ustadz')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Game
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('ustadz.games.questions.create', $game->id) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    ➕ Tambah Soal
                </a>
                <a href="{{ route('ustadz.games.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Game Info Card -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-start space-x-4">
                        <div class="text-6xl">
                            @if($game->type === 'tebak_gambar') 🖼️
                            @elseif($game->type === 'kosakata_tempat') 🏠
                            @elseif($game->type === 'pilihan_ganda') ✅
                            @else 💬
                            @endif
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $game->title }}</h1>
                            @if($game->type === 'tebak_gambar')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-pink-100 text-pink-800">
                                    Tebak Kosakata dari Gambar
                                </span>
                            @elseif($game->type === 'kosakata_tempat')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Kosakata di 30 Tempat
                                </span>
                            @elseif($game->type === 'pilihan_ganda')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Pilihan Ganda Melengkapi Kalimat
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Percakapan di 20 Tempat
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('ustadz.games.edit', $game->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            ✏️ Edit
                        </a>
                        <form action="{{ route('ustadz.games.destroy', $game->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus game ini? Semua pertanyaan akan ikut terhapus!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>

                @if($game->description)
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-gray-700 mb-2">Deskripsi:</h3>
                        <p class="text-gray-600">{{ $game->description }}</p>
                    </div>
                @endif

                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg p-4 text-white">
                        <div class="text-sm font-medium mb-1">Total Pertanyaan</div>
                        <div class="text-3xl font-bold">{{ $game->questions_count }}</div>
                    </div>
                    <div class="bg-gradient-to-r from-green-500 to-teal-500 rounded-lg p-4 text-white">
                        <div class="text-sm font-medium mb-1">Total Pengerjaan</div>
                        <div class="text-3xl font-bold">{{ $game->scores_count }}</div>
                    </div>
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg p-4 text-white">
                        <div class="text-sm font-medium mb-1">Dibuat</div>
                        <div class="text-xl font-bold">{{ $game->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Questions List -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-white">Daftar Pertanyaan</h2>
                        <a href="{{ route('ustadz.games.questions.create', $game->id) }}" class="px-4 py-2 bg-white text-purple-600 rounded-lg hover:bg-gray-100 transition font-medium">
                            ➕ Tambah Soal
                        </a>
                    </div>
                </div>

                @if($questions->count() > 0)
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($questions as $index => $question)
                                <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-purple-300 transition">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <span class="bg-purple-100 text-purple-800 text-sm font-bold px-3 py-1 rounded-full mr-3">
                                                    Soal #{{ $questions->firstItem() + $index }}
                                                </span>
                                                @if($question->location_name)
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded">
                                                        📍 {{ $question->location_name }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <p class="text-gray-800 font-medium mb-2">{{ $question->question_text }}</p>
                                            
                                            @if($question->image_path)
                                                <div class="mb-3">
                                                    <img src="{{ asset('storage/' . $question->image_path) }}" alt="Question Image" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
                                                </div>
                                            @endif
                                            
                                            <div class="bg-green-50 border-l-4 border-green-500 p-3 rounded">
                                                <p class="text-sm text-gray-700">
                                                    <span class="font-bold text-green-700">Jawaban:</span> {{ $question->correct_answer }}
                                                </p>
                                            </div>

                                            @if($question->options)
                                                @php
                                                    $options = json_decode($question->options, true);
                                                @endphp
                                                @if(is_array($options) && count($options) > 0)
                                                    <div class="mt-3">
                                                        <p class="text-sm font-bold text-gray-700 mb-2">Pilihan:</p>
                                                        <div class="grid grid-cols-2 gap-2">
                                                            @foreach($options as $option)
                                                                <div class="bg-gray-100 px-3 py-2 rounded text-sm">{{ $option }}</div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>

                                        <div class="flex space-x-2 ml-4">
                                            <a href="{{ route('ustadz.games.questions.edit', [$game->id, $question->id]) }}" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm">
                                                ✏️
                                            </a>
                                            <form action="{{ route('ustadz.games.questions.destroy', [$game->id, $question->id]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pertanyaan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $questions->links() }}
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">📝</div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Pertanyaan</h3>
                        <p class="text-gray-500 mb-6">Mulai tambahkan pertanyaan untuk game ini</p>
                        <a href="{{ route('ustadz.games.questions.create', $game->id) }}" class="inline-block px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:from-green-600 hover:to-teal-600 transition">
                            ➕ Tambah Pertanyaan Pertama
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
    @endsection