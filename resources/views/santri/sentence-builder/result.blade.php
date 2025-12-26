@extends('layouts.santri')

@section('title', 'Hasil Sentence Builder')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-10" 
         x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 100)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-[-20px]">
        <div class="inline-block mb-4">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-indigo-400 rounded-3xl blur-xl opacity-50 animate-pulse"></div>
                <div class="relative bg-gradient-to-br from-purple-500 to-indigo-500 rounded-3xl p-6 shadow-2xl">
                    <span class="text-7xl">🧩</span>
                </div>
            </div>
        </div>
        <h1 class="text-4xl sm:text-5xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent mb-3">
            Permainan Selesai!
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Hebat! Kamu sudah menyelesaikan tantangan menyusun kalimat. Lihat hasilnya di bawah ini!
        </p>
    </div>

    <!-- Score Card -->
    <div class="max-w-md mx-auto mb-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 border-4 border-purple-200"
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 200)"
             x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="text-center mb-6">
                <div class="text-6xl mb-4">🏆</div>
                <h2 class="text-3xl font-bold mb-4">Skor Akhirmu</h2>
                <p class="text-6xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent mb-4">
                    {{ $scoreValue }}
                </p>
                <div class="text-gray-700 text-lg mb-2">
                    <span class="font-semibold">Jawaban Benar:</span> 
                    <span class="text-green-600 font-bold">{{ $correctAnswers }}</span> / {{ $totalQuestions }}
                </div>
                <div class="text-gray-600 text-sm">
                    <span class="font-semibold">Akurasi:</span> 
                    {{ $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 1) : 0 }}%
                </div>
            </div>

            <!-- XP & Level Info -->
            <div class="border-t-2 border-gray-200 pt-6 space-y-3">
                <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4 text-center">
                    <span class="text-blue-600 font-bold text-xl">⭐ +{{ $xpEarned }} XP</span>
                    <p class="text-blue-500 text-sm mt-1">Experience Points Earned</p>
                </div>
                <div class="bg-purple-50 border-2 border-purple-300 rounded-lg p-4 text-center">
                    <span class="text-purple-600 font-bold text-lg">💪 Level {{ $newLevel }}: {{ $levelName }}</span>
                    <p class="text-purple-500 text-sm mt-1">Current Level</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="text-center space-y-4"
         x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 400)"
         x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        
        <a href="{{ route('santri.games.index') }}"
           class="inline-flex items-center gap-3 bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white font-bold px-8 py-4 rounded-xl transition-all shadow-xl hover:shadow-2xl hover:scale-105 active:scale-95">
            <span class="text-2xl">🔄</span>
            <span class="text-lg">Main Lagi</span>
        </a>
        
        <br>
        
        <a href="{{ route('santri.games.index') }}"
           class="inline-flex items-center gap-3 bg-gray-500 hover:bg-gray-600 text-white font-bold px-8 py-4 rounded-xl transition-all shadow-xl hover:shadow-2xl hover:scale-105 active:scale-95">
            <span class="text-2xl">🎮</span>
            <span class="text-lg">Kembali ke Daftar Game</span>
        </a>
    </div>
</div>
@endsection