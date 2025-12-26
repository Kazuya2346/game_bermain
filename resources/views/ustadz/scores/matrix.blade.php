@extends('layouts.ustadz')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    📊 Matrix Review: {{ $game->title }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Lihat semua jawaban semua santri dalam satu tampilan
                </p>
            </div>
            <a href="{{ route('ustadz.scores.game', $game->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            
            <!-- Info Game -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl shadow-lg p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">{{ $game->title }}</h3>
                        <p class="opacity-90">
                            @if($game->type === 'tebak_gambar') 🖼️ Tebak Kosakata dari Gambar
                            @elseif($game->type === 'kosakata_tempat') 🏠 Kosakata di 30 Tempat
                            @elseif($game->type === 'pilihan_ganda') ✅ Pilihan Ganda Melengkapi Kalimat
                            @else 💬 Percakapan di 20 Tempat
                            @endif
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-4xl font-bold">{{ $game->questions->count() }}</div>
                        <div class="text-sm opacity-90">Total Soal</div>
                    </div>
                </div>
            </div>

            @if($santriList->count() > 0 && $game->questions->count() > 0)
                <!-- Matrix Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100 sticky top-0">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider sticky left-0 bg-gray-100 z-10">
                                        Nama Santri
                                    </th>
                                    @foreach($game->questions as $index => $question)
                                        <th class="px-4 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider min-w-[120px]">
                                            <div class="flex flex-col items-center">
                                                <span class="text-lg mb-1">📝</span>
                                                <span>Soal {{ $index + 1 }}</span>
                                            </div>
                                        </th>
                                    @endforeach
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider sticky right-0 bg-gray-100 z-10">
                                        Total Benar
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($santriList as $santri)
                                    @php
                                        $totalCorrect = 0;
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white z-10 border-r-2 border-gray-200">
                                            <div class="flex items-center">
                                                <div class="text-2xl mr-3">
                                                    @if($santri->role === 'santri_putra') 👨‍🎓
                                                    @else 👩‍🎓
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">{{ $santri->name }}</div>
                                                    <div class="text-xs text-gray-500">Level {{ $santri->level }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        @foreach($game->questions as $question)
                                            @php
                                                $key = $santri->id . '-' . $question->id;
                                                $answer = $answerLogs->get($key)->first();
                                                if ($answer && $answer->is_correct) {
                                                    $totalCorrect++;
                                                }
                                            @endphp
                                            <td class="px-4 py-4 text-center">
                                                @if($answer)
                                                    @if($answer->is_correct)
                                                        <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-full">
                                                            <span class="text-2xl">✅</span>
                                                        </div>
                                                        <div class="text-xs text-green-700 font-medium mt-1">Benar</div>
                                                    @else
                                                        <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-full">
                                                            <span class="text-2xl">❌</span>
                                                        </div>
                                                        <div class="text-xs text-red-700 font-medium mt-1">Salah</div>
                                                    @endif
                                                    <!-- Tooltip untuk lihat jawaban -->
                                                    <div class="text-xs text-gray-500 mt-1" title="Jawaban: {{ $answer->user_answer }}">
                                                        <span class="cursor-help">💬</span>
                                                    </div>
                                                @else
                                                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full">
                                                        <span class="text-2xl">➖</span>
                                                    </div>
                                                    <div class="text-xs text-gray-500 font-medium mt-1">Tidak Dijawab</div>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="px-6 py-4 text-center sticky right-0 bg-white z-10 border-l-2 border-gray-200">
                                            @php
                                                $percentage = ($totalCorrect / $game->questions->count()) * 100;
                                            @endphp
                                            <div class="text-2xl font-bold 
                                                @if($percentage >= 80) text-green-600
                                                @elseif($percentage >= 60) text-blue-600
                                                @else text-purple-600
                                                @endif">
                                                {{ $totalCorrect }}/{{ $game->questions->count() }}
                                            </div>
                                            <div class="text-xs text-gray-600 mt-1">{{ number_format($percentage, 0) }}%</div>
                                            @if($percentage >= 80)
                                                <div class="text-xs text-green-600 font-semibold mt-1">🌟 Excellent</div>
                                            @elseif($percentage >= 60)
                                                <div class="text-xs text-blue-600 font-semibold mt-1">👍 Good</div>
                                            @else
                                                <div class="text-xs text-purple-600 font-semibold mt-1">💪 Keep Going</div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <!-- Summary Row -->
                            <tfoot class="bg-gray-100 font-bold">
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 sticky left-0 bg-gray-100 z-10">
                                        STATISTIK PER SOAL
                                    </td>
                                    @foreach($game->questions as $question)
                                        @php
                                            $correctCount = 0;
                                            foreach($santriList as $santri) {
                                                $key = $santri->id . '-' . $question->id;
                                                $answer = $answerLogs->get($key)->first();
                                                if ($answer && $answer->is_correct) {
                                                    $correctCount++;
                                                }
                                            }
                                            $questionPercentage = $santriList->count() > 0 ? ($correctCount / $santriList->count()) * 100 : 0;
                                        @endphp
                                        <td class="px-4 py-4 text-center text-sm">
                                            <div class="font-bold text-gray-900">{{ $correctCount }}/{{ $santriList->count() }}</div>
                                            <div class="text-xs 
                                                @if($questionPercentage >= 80) text-green-600
                                                @elseif($questionPercentage >= 60) text-blue-600
                                                @else text-red-600
                                                @endif">
                                                {{ number_format($questionPercentage, 0) }}% Benar
                                            </div>
                                        </td>
                                    @endforeach
                                    <td class="px-6 py-4 text-center text-sm sticky right-0 bg-gray-100 z-10">
                                        <div class="text-gray-900">RATA-RATA</div>
                                        @php
                                            $totalAnswers = 0;
                                            $totalCorrectAll = 0;
                                            foreach($santriList as $santri) {
                                                foreach($game->questions as $question) {
                                                    $key = $santri->id . '-' . $question->id;
                                                    $answer = $answerLogs->get($key)->first();
                                                    if ($answer) {
                                                        $totalAnswers++;
                                                        if ($answer->is_correct) {
                                                            $totalCorrectAll++;
                                                        }
                                                    }
                                                }
                                            }
                                            $overallPercentage = $totalAnswers > 0 ? ($totalCorrectAll / $totalAnswers) * 100 : 0;
                                        @endphp
                                        <div class="text-xs 
                                            @if($overallPercentage >= 80) text-green-600
                                            @elseif($overallPercentage >= 60) text-blue-600
                                            @else text-purple-600
                                            @endif">
                                            {{ number_format($overallPercentage, 1) }}%
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Legends -->
                <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📌 Keterangan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl">✅</span>
                            </div>
                            <div>
                                <div class="font-semibold text-green-700">Jawaban Benar</div>
                                <div class="text-xs text-gray-600">Santri menjawab dengan benar</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl">❌</span>
                            </div>
                            <div>
                                <div class="font-semibold text-red-700">Jawaban Salah</div>
                                <div class="text-xs text-gray-600">Santri menjawab tapi salah</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl">➖</span>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-700">Tidak Dijawab</div>
                                <div class="text-xs text-gray-600">Santri melewatkan soal ini</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                        <p class="text-sm text-blue-800">
                            💡 <strong>Tips:</strong> Hover mouse di icon 💬 untuk melihat jawaban detail santri. 
                            Statistik per soal di bagian bawah tabel membantu Ustadz mengidentifikasi soal yang sulit.
                        </p>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-lg p-16 text-center">
                    <div class="text-6xl mb-4">📊</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Matrix Review Belum Tersedia</h3>
                    @if($santriList->count() == 0)
                        <p class="text-gray-500 mb-6">Belum ada santri yang mengerjakan game ini</p>
                    @else
                        <p class="text-gray-500 mb-6">Game ini belum memiliki soal</p>
                    @endif
                    <a href="{{ route('ustadz.games.show', $game->id) }}" class="inline-block px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600 transition">
                        📝 Kelola Game Ini
                    </a>
                </div>
            @endif

        </div>
    </div>

@endsection