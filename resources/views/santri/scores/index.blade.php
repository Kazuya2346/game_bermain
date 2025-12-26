@extends('layouts.santri')

@section('title', 'Riwayat Skor')

@section('content')
@php
    // Safe variable defaults
    $paginatedScores = $paginatedScores ?? collect();
    $totalGamesPlayed = $totalGamesPlayed ?? 0;
    $averageScore = $averageScore ?? 0;
    $totalPoints = auth()->user()->total_accumulated_points ?? 0;
@endphp

<!-- Header with Animation -->
<div class="mb-10" 
     x-data="{ show: false }" 
     x-init="setTimeout(() => show = true, 100)"
     x-show="show"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-[-20px]">
    <div class="text-center">
        <div class="inline-block mb-6 relative">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 via-teal-400 to-cyan-400 rounded-3xl blur-2xl opacity-60 animate-pulse"></div>
            <div class="relative bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-3xl p-8 shadow-2xl transform hover:scale-105 transition-transform">
                <span class="text-8xl filter drop-shadow-lg">📊</span>
            </div>
        </div>
        <h1 class="text-5xl sm:text-6xl font-extrabold bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent mb-4 tracking-tight">
            Riwayat Skor
        </h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto font-medium">
            Pantau perjalanan belajarmu dan raih prestasi terbaik! 🚀
        </p>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    
    <!-- Total Games -->
    <div x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 300)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-90">
        <div class="group relative overflow-hidden bg-white rounded-3xl shadow-xl hover:shadow-2xl p-8 border-2 border-purple-200 hover:border-purple-400 transition-all duration-300 hover:scale-105">
            <!-- Gradient Background Effect -->
            <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide">Total Game</h3>
                    <div class="text-5xl transform group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                        🎮
                    </div>
                </div>
                <div class="text-6xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                    {{ $totalGamesPlayed }}
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 font-semibold">
                    <span class="w-2 h-2 bg-purple-500 rounded-full animate-pulse"></span>
                    Game dimainkan
                </div>
            </div>
            
            <!-- Decorative Elements -->
            <div class="absolute -bottom-2 -right-2 w-24 h-24 bg-purple-200 rounded-full blur-2xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
        </div>
    </div>

    <!-- Average Score -->
    <div x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 400)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-90">
        <div class="group relative overflow-hidden bg-white rounded-3xl shadow-xl hover:shadow-2xl p-8 border-2 border-blue-200 hover:border-blue-400 transition-all duration-300 hover:scale-105">
            <!-- Gradient Background Effect -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-cyan-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide">Rata-rata Skor</h3>
                    <div class="text-5xl transform group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                        📈
                    </div>
                </div>
                <div class="text-6xl font-black bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                    {{ number_format($averageScore, 1) }}%
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 font-semibold">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    Performa kamu
                </div>
            </div>
            
            <!-- Decorative Elements -->
            <div class="absolute -bottom-2 -right-2 w-24 h-24 bg-blue-200 rounded-full blur-2xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
        </div>
    </div>

    <!-- Total Accumulated Points -->
    <div x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 500)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-90">
        <div class="group relative overflow-hidden bg-white rounded-3xl shadow-xl hover:shadow-2xl p-8 border-2 border-yellow-200 hover:border-yellow-400 transition-all duration-300 hover:scale-105">
            <!-- Gradient Background Effect -->
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-50 to-orange-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            
            <!-- Sparkle Animation -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-4 right-8 w-1 h-1 bg-yellow-400 rounded-full animate-ping"></div>
                <div class="absolute top-8 right-12 w-1 h-1 bg-orange-400 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
                <div class="absolute top-12 right-6 w-1 h-1 bg-yellow-400 rounded-full animate-ping" style="animation-delay: 1s;"></div>
            </div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide">Total Semua Point</h3>
                    <div class="text-5xl transform group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">
                        🏆
                    </div>
                </div>
                <div class="text-6xl font-black bg-gradient-to-r from-yellow-600 via-orange-600 to-red-600 bg-clip-text text-transparent mb-2">
                    {{ number_format($totalPoints, 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 font-semibold">
                    <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                    Poin terkumpul
                </div>
            </div>
            
            <!-- Decorative Elements -->
            <div class="absolute -bottom-2 -right-2 w-24 h-24 bg-yellow-200 rounded-full blur-2xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
        </div>
    </div>

</div>

<!-- Score History Table -->
<div x-data="{ show: false }" 
     x-init="setTimeout(() => show = true, 600)"
     x-show="show"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 scale-95">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-2 border-gray-200">
        
        <!-- Table Header -->
        <div class="relative bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 px-8 py-6 overflow-hidden">
            <div class="absolute inset-0" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); background-size: 1000px 100%; animation: shimmer 2s infinite;"></div>
            <div class="relative flex items-center justify-between">
                <h2 class="text-3xl font-black text-white drop-shadow-lg flex items-center gap-3">
                    <span class="text-4xl">📋</span>
                    <span>Riwayat Lengkap</span>
                </h2>
                <div class="hidden sm:flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <span class="text-white font-bold text-sm">{{ $paginatedScores->total() }} Games</span>
                </div>
            </div>
        </div>

        @if($paginatedScores->count() > 0)
        
        <!-- Table Content (Desktop) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-100 to-gray-50 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-black text-gray-700 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-8 py-5 text-left text-xs font-black text-gray-700 uppercase tracking-wider">
                            Game
                        </th>
                        <th class="px-8 py-5 text-center text-xs font-black text-gray-700 uppercase tracking-wider">
                            Skor
                        </th>
                        <th class="px-8 py-5 text-center text-xs font-black text-gray-700 uppercase tracking-wider">
                            Benar/Total
                        </th>
                        <th class="px-8 py-5 text-center text-xs font-black text-gray-700 uppercase tracking-wider">
                            Tanggal
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($paginatedScores as $index => $score)
                    <tr class="hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50 transition-all duration-200 group">
                        
                        <!-- Number -->
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 text-sm font-black text-emerald-700 group-hover:scale-110 group-hover:shadow-md transition-all">
                                {{ ($paginatedScores->currentPage() - 1) * $paginatedScores->perPage() + $index + 1 }}
                            </span>
                        </td>

                        <!-- Game Info -->
                        <td class="px-8 py-5">
                            <div class="flex items-center space-x-4">
                                @if(is_array($score) || is_object($score))
                                    @php
                                        $scoreType = is_array($score) ? $score['type'] : $score->type;
                                        $gameTitle = is_array($score) ? $score['game_title'] : $score->game_title;
                                    @endphp
                                    
                                    <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br 
                                        @if($scoreType == 'listening') from-purple-400 to-indigo-500
                                        @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'tebak_gambar') from-pink-400 to-red-500
                                        @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'kosakata_tempat') from-blue-400 to-indigo-500
                                        @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'pilihan_ganda') from-emerald-400 to-teal-500
                                        @else from-amber-400 to-orange-500
                                        @endif
                                        flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 group-hover:shadow-xl transition-all">
                                        @if($scoreType == 'listening')
                                            🎧
                                        @elseif($scoreType == 'regular' && isset($score->game))
                                            @if($score->game->type == 'tebak_gambar')
                                                🖼️
                                            @elseif($score->game->type == 'kosakata_tempat')
                                                🏫
                                            @elseif($score->game->type == 'pilihan_ganda')
                                                ✅
                                            @else
                                                💬
                                            @endif
                                        @else
                                            🎮
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-base font-bold text-gray-900 mb-1">
                                            {{ $gameTitle }}
                                        </div>
                                        <div class="text-xs text-gray-500 font-semibold uppercase tracking-wide">
                                            @if($scoreType == 'listening')
                                                Listening Game
                                            @elseif($scoreType == 'regular' && isset($score->game))
                                                {{ ucfirst(str_replace('_', ' ', $score->game->type)) }}
                                            @else
                                                Game
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- Score -->
                        <td class="px-8 py-5 text-center">
                            @php
                                $scorePercentage = is_array($score) ? $score['score_percentage'] : $score->score_percentage;
                            @endphp
                            <span class="inline-flex items-center px-6 py-2.5 rounded-xl text-base font-black shadow-lg group-hover:shadow-xl transition-all
                                @if($scorePercentage >= 80) bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border-2 border-green-300
                                @elseif($scorePercentage >= 60) bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 border-2 border-blue-300
                                @else bg-gradient-to-r from-orange-100 to-red-100 text-orange-700 border-2 border-orange-300
                                @endif
                            ">
                                {{ number_format($scorePercentage, 0) }}%
                            </span>
                        </td>

                        <!-- Correct/Total -->
                        <td class="px-8 py-5 text-center">
                            @php
                                $correctAnswers = is_array($score) ? $score['correct_answers'] : $score->correct_answers;
                                $totalQuestions = is_array($score) ? $score['total_questions'] : $score->total_questions;
                            @endphp
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-xl group-hover:bg-gray-100 transition-colors">
                                <span class="text-lg font-black text-emerald-600">{{ $correctAnswers }}</span>
                                <span class="text-gray-400 font-bold">/</span>
                                <span class="text-lg font-black text-gray-600">{{ $totalQuestions }}</span>
                            </div>
                        </td>

                        <!-- Date -->
                        <td class="px-8 py-5 text-center">
                            @php
                                $completedAt = is_array($score) ? $score['completed_at'] : $score->completed_at;
                            @endphp
                            <div class="inline-flex flex-col items-center gap-1 px-4 py-2 bg-gray-50 rounded-xl group-hover:bg-gray-100 transition-colors">
                                <div class="text-sm font-black text-gray-900">
                                    {{ $completedAt->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500 font-bold">
                                    {{ $completedAt->format('H:i') }} WIB
                                </div>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Card View (Mobile) -->
        <div class="md:hidden p-6 space-y-5">
            @foreach($paginatedScores as $index => $score)
            @php
                $scoreType = is_array($score) ? $score['type'] : $score->type;
                $gameTitle = is_array($score) ? $score['game_title'] : $score->game_title;
                $scorePercentage = is_array($score) ? $score['score_percentage'] : $score->score_percentage;
                $correctAnswers = is_array($score) ? $score['correct_answers'] : $score->correct_answers;
                $totalQuestions = is_array($score) ? $score['total_questions'] : $score->total_questions;
                $completedAt = is_array($score) ? $score['completed_at'] : $score->completed_at;
            @endphp
            <div class="relative bg-gradient-to-br from-white to-gray-50 rounded-2xl p-6 shadow-xl border-2 border-gray-200 hover:border-emerald-300 hover:shadow-2xl transition-all duration-300">
                <!-- Number Badge -->
                <div class="absolute -top-3 -right-3 w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white text-sm font-black shadow-lg">
                    {{ ($paginatedScores->currentPage() - 1) * $paginatedScores->perPage() + $index + 1 }}
                </div>

                <!-- Header -->
                <div class="flex items-start gap-4 mb-5">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br 
                        @if($scoreType == 'listening') from-purple-400 to-indigo-500
                        @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'tebak_gambar') from-pink-400 to-red-500
                        @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'kosakata_tempat') from-blue-400 to-indigo-500
                        @elseif($scoreType == 'regular' && isset($score->game) && $score->game->type == 'pilihan_ganda') from-emerald-400 to-teal-500
                        @else from-amber-400 to-orange-500
                        @endif
                        flex items-center justify-center text-3xl shadow-lg">
                        @if($scoreType == 'listening')
                            🎧
                        @elseif($scoreType == 'regular' && isset($score->game))
                            @if($score->game->type == 'tebak_gambar')
                                🖼️
                            @elseif($score->game->type == 'kosakata_tempat')
                                🏫
                            @elseif($score->game->type == 'pilihan_ganda')
                                ✅
                            @else
                                💬
                            @endif
                        @else
                            🎮
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="font-black text-gray-900 text-lg mb-1">{{ $gameTitle }}</div>
                        <div class="text-xs text-gray-500 font-bold uppercase tracking-wide">
                            @if($scoreType == 'listening')
                                Listening Game
                            @elseif($scoreType == 'regular' && isset($score->game))
                                {{ ucfirst(str_replace('_', ' ', $score->game->type)) }}
                            @else
                                Game
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="text-center p-3 bg-white rounded-xl border-2 border-gray-100">
                        <div class="text-xs text-gray-500 font-bold mb-2 uppercase">Skor</div>
                        <div class="px-3 py-2 rounded-lg text-base font-black
                            @if($scorePercentage >= 80) bg-gradient-to-r from-green-100 to-emerald-100 text-green-700
                            @elseif($scorePercentage >= 60) bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700
                            @else bg-gradient-to-r from-orange-100 to-red-100 text-orange-700
                            @endif
                        ">
                            {{ number_format($scorePercentage, 0) }}%
                        </div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-xl border-2 border-gray-100">
                        <div class="text-xs text-gray-500 font-bold mb-2 uppercase">Benar</div>
                        <div class="text-xl font-black text-emerald-600">{{ $correctAnswers }}<span class="text-sm text-gray-400">/{{ $totalQuestions }}</span></div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-xl border-2 border-gray-100">
                        <div class="text-xs text-gray-500 font-bold mb-2 uppercase">Tanggal</div>
                        <div class="text-sm font-black text-gray-900">{{ $completedAt->format('d M') }}</div>
                        <div class="text-xs font-semibold text-gray-500">{{ $completedAt->format('H:i') }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-5 border-t-2 border-gray-200">
            {{ $paginatedScores->links() }}
        </div>

        @else
        
        <!-- Empty State -->
        <div class="p-16 text-center">
            <div class="inline-block mb-8">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-300 to-teal-300 rounded-full blur-3xl opacity-40 animate-pulse"></div>
                    <div class="relative text-9xl animate-bounce">📊</div>
                </div>
            </div>
            <h3 class="text-4xl font-black text-gray-800 mb-4">Belum Ada Riwayat</h3>
            <p class="text-xl text-gray-600 mb-10 max-w-md mx-auto font-medium">
                Kamu belum memainkan game apapun. Ayo mulai bermain dan raih skor terbaikmu! 🎯
            </p>
            <a href="{{ route('santri.games.index') }}"
               class="inline-flex items-center gap-4 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-600 hover:via-teal-600 hover:to-cyan-600 text-white font-black px-10 py-5 rounded-2xl transition-all shadow-2xl hover:shadow-3xl hover:scale-105 active:scale-95 text-lg">
                <span class="text-3xl">🎮</span>
                <span>Lihat Semua Game</span>
            </a>
        </div>

        @endif

    </div>
</div>

<!-- Tips Section -->
@if($paginatedScores->count() > 0)
<div class="mt-10 relative overflow-hidden bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-3xl shadow-2xl p-10">
    <!-- Decorative Background -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative z-10 flex flex-col sm:flex-row items-center justify-center gap-6">
        <div class="text-6xl animate-bounce">💡</div>
        <div class="text-center sm:text-left">
            <h3 class="text-3xl font-black text-white mb-2 drop-shadow-lg">Tips Meningkatkan Skor</h3>
            <p class="text-lg text-emerald-50 font-medium">Mainkan game secara rutin dan pelajari dari kesalahan untuk meningkatkan performamu!</p>
        </div>
    </div>
</div>
@endif

<style>
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}
</style>

@endsection