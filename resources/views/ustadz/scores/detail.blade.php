@extends('layouts.ustadz')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detail Jawaban Santri
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $score->user->name }} - {{ $score->game->title }}</p>
            </div>
            <a href="{{ route('ustadz.scores.game', $score->game_id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Student & Score Info -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Student Avatar -->
                        <div class="text-6xl">
                            @if($score->user->role === 'santri_putra') 👨‍🎓
                            @else 👩‍🎓
                            @endif
                        </div>
                        
                        <!-- Student Info -->
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">{{ $score->user->name }}</h1>
                            <p class="text-gray-600">{{ $score->user->email }}</p>
                            <div class="flex items-center space-x-3 mt-2">
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm font-semibold rounded-full">
                                    Level {{ $score->user->level ?? 1 }}
                                </span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                                    {{ $score->user->experience_points ?? 0 }} XP
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Score Display -->
                    <div class="text-center">
                        @php
                            $scoreValue = ($score->correct_answers / $score->total_questions) * 100;
                        @endphp
                        @if($scoreValue >= 80)
                            <div class="text-6xl font-bold text-green-600">{{ number_format($scoreValue, 0) }}</div>
                            <p class="text-green-600 font-semibold mt-2">🌟 Excellent!</p>
                        @elseif($scoreValue >= 60)
                            <div class="text-6xl font-bold text-blue-600">{{ number_format($scoreValue, 0) }}</div>
                            <p class="text-blue-600 font-semibold mt-2">👍 Good!</p>
                        @else
                            <div class="text-6xl font-bold text-purple-600">{{ number_format($scoreValue, 0) }}</div>
                            <p class="text-purple-600 font-semibold mt-2">💪 Keep Going!</p>
                        @endif
                        <p class="text-sm text-gray-500 mt-1">{{ $score->correct_answers }}/{{ $score->total_questions }} Benar</p>
                    </div>
                </div>

                <!-- Game Info -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="text-3xl">
                                @if($score->game->type === 'tebak_gambar') 🖼️
                                @elseif($score->game->type === 'kosakata_tempat') 🏠
                                @elseif($score->game->type === 'pilihan_ganda') ✅
                                @else 💬
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">{{ $score->game->title }}</h3>
                                <p class="text-sm text-gray-500">
                                    @if($score->game->type === 'tebak_gambar') Tebak Kosakata dari Gambar
                                    @elseif($score->game->type === 'kosakata_tempat') Kosakata di 30 Tempat
                                    @elseif($score->game->type === 'pilihan_ganda') Pilihan Ganda Melengkapi Kalimat
                                    @else Percakapan di 20 Tempat
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Dikerjakan pada:</p>
                            <p class="font-semibold text-gray-800">{{ $score->completed_at->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-gray-400">{{ $score->completed_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Answer Details -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                    <h2 class="text-2xl font-bold text-white">Detail Jawaban Per Soal</h2>
                    <p class="text-white text-sm opacity-90 mt-1">Analisis jawaban benar dan salah</p>
                </div>

                <div class="p-6">
                    @if($answerLogs->count() > 0)
                        <div class="space-y-6">
                            @foreach($answerLogs as $index => $log)
                                <div class="border-2 {{ $log->is_correct ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50' }} rounded-xl p-6">
                                    <!-- Question Header -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <span class="bg-white px-4 py-2 rounded-full font-bold text-gray-800 shadow">
                                                Soal #{{ $index + 1 }}
                                            </span>
                                            @if($log->is_correct)
                                                <span class="px-3 py-1 bg-green-500 text-white text-sm font-bold rounded-full">
                                                    ✓ BENAR
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-red-500 text-white text-sm font-bold rounded-full">
                                                    ✗ SALAH
                                                </span>
                                            @endif
                                            @if($log->question->location_name)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                                    📍 {{ $log->question->location_name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Question Text -->
                                    <div class="bg-white border-l-4 {{ $log->is_correct ? 'border-green-500' : 'border-red-500' }} p-4 rounded-lg mb-4">
                                        <p class="font-semibold text-gray-800 mb-2">Pertanyaan:</p>
                                        <p class="text-gray-700">{{ $log->question->question_text }}</p>
                                    </div>

                                    <!-- Question Image -->
                                    @if($log->question->image_path)
                                        <div class="mb-4">
                                            <p class="text-sm font-bold text-gray-700 mb-2">Gambar:</p>
                                            <img src="{{ asset('storage/' . $log->question->image_path) }}" 
                                                 alt="Question Image" 
                                                 class="w-64 h-64 object-cover rounded-lg border-4 border-gray-300 shadow-md">
                                        </div>
                                    @endif

                                    <!-- Options (if exists) -->
                                    @if($log->question->options)
                                        @php
                                            $options = json_decode($log->question->options, true);
                                        @endphp
                                        @if(is_array($options) && count($options) > 0)
                                            <div class="mb-4">
                                                <p class="text-sm font-bold text-gray-700 mb-2">Pilihan Jawaban:</p>
                                                <div class="grid grid-cols-2 gap-2">
                                                    @foreach($options as $option)
                                                        <div class="bg-white border border-gray-300 px-3 py-2 rounded text-sm">
                                                            {{ $option }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    <!-- Answers Comparison -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- User Answer -->
                                        <div class="bg-white rounded-lg p-4 border-2 {{ $log->is_correct ? 'border-green-400' : 'border-red-400' }}">
                                            <p class="text-sm font-bold mb-2 {{ $log->is_correct ? 'text-green-700' : 'text-red-700' }}">
                                                Jawaban Santri:
                                            </p>
                                            <p class="text-lg font-semibold {{ $log->is_correct ? 'text-green-800' : 'text-red-800' }}">
                                                {{ $log->user_answer ?: '(Tidak dijawab)' }}
                                            </p>
                                        </div>

                                        <!-- Correct Answer -->
                                        <div class="bg-white rounded-lg p-4 border-2 border-green-400">
                                            <p class="text-sm font-bold text-green-700 mb-2">
                                                Jawaban yang Benar:
                                            </p>
                                            <p class="text-lg font-semibold text-green-800">
                                                {{ $log->correct_answer }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📝</div>
                            <p class="text-gray-500 text-lg">Data jawaban tidak tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 rounded-xl p-6 text-white shadow-lg">
                    <div class="text-4xl mb-2">✓</div>
                    <div class="text-3xl font-bold">{{ $score->correct_answers }}</div>
                    <p class="text-sm opacity-90">Jawaban Benar</p>
                </div>

                <div class="bg-gradient-to-r from-red-500 to-pink-500 rounded-xl p-6 text-white shadow-lg">
                    <div class="text-4xl mb-2">✗</div>
                    <div class="text-3xl font-bold">{{ $score->total_questions - $score->correct_answers }}</div>
                    <p class="text-sm opacity-90">Jawaban Salah</p>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 rounded-xl p-6 text-white shadow-lg">
                    <div class="text-4xl mb-2">📊</div>
                    <div class="text-3xl font-bold">{{ number_format(($score->correct_answers / $score->total_questions) * 100, 1) }}%</div>
                    <p class="text-sm opacity-90">Persentase</p>
                </div>
            </div>

        </div>
    </div>

@endsection