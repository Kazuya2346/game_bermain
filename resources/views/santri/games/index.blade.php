@extends('layouts.santri')

@section('title', 'Pilih Game')

@section('content')
<!-- Header with Animation -->
<div class="mb-10" 
     x-data="{ show: false }" 
     x-init="setTimeout(() => show = true, 100)"
     x-show="show"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-[-20px]">
    <div class="text-center">
        <div class="inline-block mb-4">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-3xl blur-xl opacity-50 animate-pulse"></div>
                <div class="relative bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl p-6 shadow-2xl">
                    <span class="text-7xl">🎮</span>
                </div>
            </div>
        </div>
        <h1 class="text-4xl sm:text-5xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-3">
            Pilih Game Favoritmu!
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Tingkatkan kemampuan bahasa Arabmu dengan bermain game yang seru dan menyenangkan! 🌟
        </p>
    </div>
</div>

<!-- Games Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
    
    <!-- ========================================== -->
    <!-- GAME LISTENING COMPREHENSION (BARU) -->
    <!-- ========================================== -->
    <div class="group"
         x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 150)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-95">
        
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-105 border-2 border-teal-200 h-full flex flex-col">
            
            <!-- Listening Comprehension Header -->
            <div class="relative bg-gradient-to-br from-teal-500 via-cyan-500 to-blue-500 p-8 text-center text-white overflow-hidden">
                
                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                
                <!-- Badge "Game Bawaan" -->
                <div class="absolute top-4 right-4 bg-yellow-400 text-purple-700 px-3 py-1 rounded-full text-xs font-bold shadow-lg animate-pulse">
                    ⭐ BUILT-IN
                </div>
                
                <!-- Icon with animation -->
                <div class="relative text-7xl mb-4 transform group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">
                    🎧
                </div>
                
                <!-- Title -->
                <h3 class="relative text-2xl font-bold mb-2 drop-shadow-lg">{{ $listeningComprehensionGame->title }}</h3>
                
                <!-- Description -->
                <p class="relative text-sm opacity-95 leading-relaxed min-h-[2.5rem]">
                    {{ $listeningComprehensionGame->description }}
                </p>

                <!-- Shine effect on hover -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            </div>

            <!-- Listening Comprehension Body -->
            <div class="p-6 flex-1 flex flex-col">
                
                <!-- Stats with Icons -->
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl p-4 text-center border-2 border-teal-200 transform group-hover:scale-105 transition-transform">
                        <div class="text-3xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                            310
                        </div>
                        <div class="text-xs text-gray-600 font-semibold mt-1 flex items-center justify-center gap-1">
                            <span>🎧</span>
                            <span>Audio</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 text-center border-2 border-blue-200 transform group-hover:scale-105 transition-transform">
                        <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            <span>⏱️</span>
                        </div>
                        <div class="text-xs text-gray-600 font-semibold mt-1 flex items-center justify-center gap-1">
                            <span>⚡</span>
                            <span>timer mode</span>
                        </div>
                    </div>
                </div>

                <!-- Feature Badges -->
                <div class="mb-5 flex flex-col gap-2">
                    <div class="flex items-center gap-2 bg-gradient-to-r from-teal-50 to-cyan-50 px-4 py-2 rounded-lg border-2 border-teal-200">
                        <span class="text-lg">🎧</span>
                        <span class="text-xs font-bold text-gray-700">Pilihan Ganda</span>
                    </div>
                    <div class="flex items-center gap-2 bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-2 rounded-lg border-2 border-blue-200">
                        <span class="text-lg">🧩🧩</span>
                        <span class="text-xs font-bold text-gray-700">Susun Kata</span>
                    </div>
                    <div class="flex items-center gap-2 bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-2 rounded-lg border-2 border-blue-200">
                        <span class="text-lg">🏆</span>
                        <span class="text-xs font-bold text-gray-700">Sistem Skor</span>
                    </div>
                </div>

                <!-- Play Button -->
                <div class="mt-auto">
                    <a href="{{ route('santri.listening.index') }}" 
                       class="block w-full bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white text-center font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 relative overflow-hidden group/btn">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <span class="text-lg">🎧</span>
                            <span>Main Sekarang</span>
                        </span>
                        <!-- Shine effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                    </a>
                </div>

            </div>

        </div>

    </div>
    
    <!-- ========================================== -->
    <!-- GAME BAWAAN: SURVIVAL QUIZ -->
    <!-- ========================================== -->
    <div class="group"
         x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 200)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-95">
        
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-105 border-2 border-red-200 h-full flex flex-col">
            
            <!-- Survival Quiz Header -->
            <div class="relative bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 p-8 text-center text-white overflow-hidden">
                
                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                
                <!-- Badge "Game Bawaan" -->
                <div class="absolute top-4 right-4 bg-yellow-400 text-red-700 px-3 py-1 rounded-full text-xs font-bold shadow-lg animate-pulse">
                    ⭐ BUILT-IN
                </div>
                
                <!-- Icon with animation -->
                <div class="relative text-7xl mb-4 transform group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">
                    ⚡
                </div>
                
                <!-- Title -->
                <h3 class="relative text-2xl font-bold mb-2 drop-shadow-lg">Survival Quiz</h3>
                
                <!-- Description -->
                <p class="relative text-sm opacity-95 leading-relaxed min-h-[2.5rem]">
                    Jawab sebanyak mungkin dalam waktu terbatas! +5 detik tiap jawaban benar!
                </p>

                <!-- Shine effect on hover -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            </div>

            <!-- Survival Quiz Body -->
            <div class="p-6 flex-1 flex flex-col">
                
                <!-- Stats with Icons -->
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-xl p-4 text-center border-2 border-red-200 transform group-hover:scale-105 transition-transform">
                        <div class="text-3xl font-bold bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">
                            500
                        </div>
                        <div class="text-xs text-gray-600 font-semibold mt-1 flex items-center justify-center gap-1">
                            <span>📝</span>
                            <span>Soal</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl p-4 text-center border-2 border-yellow-200 transform group-hover:scale-105 transition-transform">
                        <div class="text-3xl font-bold bg-gradient-to-r from-yellow-600 to-amber-600 bg-clip-text text-transparent">
                            ⏱️
                        </div>
                        <div class="text-xs text-gray-600 font-semibold mt-1 flex items-center justify-center gap-1">
                            <span>⚡</span>
                            <span>Timer Mode</span>
                        </div>
                    </div>
                </div>

                <!-- Feature Badges -->
                <div class="mb-5 flex flex-col gap-2">
                    <div class="flex items-center gap-2 bg-gradient-to-r from-red-50 to-orange-50 px-4 py-2 rounded-lg border-2 border-red-200">
                        <span class="text-lg">🏆</span>
                        <span class="text-xs font-bold text-gray-700">High Score System</span>
                    </div>
                    <div class="flex items-center gap-2 bg-gradient-to-r from-yellow-50 to-amber-50 px-4 py-2 rounded-lg border-2 border-yellow-200">
                        <span class="text-lg">⚡</span>
                        <span class="text-xs font-bold text-gray-700">10 Soal Random per Game</span>
                    </div>
                </div>

                <!-- Play Button -->
                <div class="mt-auto">
                    <a href="{{ route('santri.survival.play') }}" 
                       class="block w-full bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white text-center font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 relative overflow-hidden group/btn">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <span class="text-lg">⚡</span>
                            <span>Main Sekarang</span>
                        </span>
                        <!-- Shine effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                    </a>
                </div>

            </div>

        </div>

    </div>

    <!-- ========================================== -->
    <!-- GAME BAWAAN: ARABIC SENTENCE BUILDER -->
    <!-- ========================================== -->
    @if($sentenceBuilderGame)
    <div class="group"
         x-data="{ show: false }" 
         x-init="setTimeout(() => show = true, 250)"
         x-show="show"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-95">
        
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-105 border-2 border-purple-200 h-full flex flex-col">
            
            <!-- Sentence Builder Header -->
            <div class="relative bg-gradient-to-br from-purple-500 via-indigo-500 to-blue-500 p-8 text-center text-white overflow-hidden">
                
                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                
                <!-- Badge "Game Bawaan" -->
                <div class="absolute top-4 right-4 bg-yellow-400 text-purple-700 px-3 py-1 rounded-full text-xs font-bold shadow-lg animate-pulse">
                    ⭐ BUILT-IN
                </div>
                
                <!-- Icon with animation -->
                <div class="relative text-7xl mb-4 transform group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">
                    🧩
                </div>
                
                <!-- Title -->
                <h3 class="relative text-2xl font-bold mb-2 drop-shadow-lg">Arabic Sentence Builder</h3>
                
                <!-- Description -->
                <p class="relative text-sm opacity-95 leading-relaxed min-h-[2.5rem]">
                    Susun kata-kata menjadi kalimat bahasa Arab yang benar! Drag & Drop yang seru!
                </p>

                <!-- Shine effect on hover -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            </div>

            <!-- Sentence Builder Body -->
            <div class="p-6 flex-1 flex flex-col">
                
                <!-- Stats with Icons -->
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-4 text-center border-2 border-purple-200 transform group-hover:scale-105 transition-transform">
                        <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                            50
                        </div>
                        <div class="text-xs text-gray-600 font-semibold mt-1 flex items-center justify-center gap-1">
                            <span>📝</span>
                            <span>Soal</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 text-center border-2 border-blue-200 transform group-hover:scale-105 transition-transform">
                        <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                            10⏱️
                        </div>
                        <div class="text-xs text-gray-600 font-semibold mt-1 flex items-center justify-center gap-1">
                            <span>⏰</span>
                            <span>Menit</span>
                        </div>
                    </div>
                </div>

                <!-- Feature Badges -->
                <div class="mb-5 flex flex-col gap-2">
                    <div class="flex items-center gap-2 bg-gradient-to-r from-purple-50 to-indigo-50 px-4 py-2 rounded-lg border-2 border-purple-200">
                        <span class="text-lg">🎯</span>
                        <span class="text-xs font-bold text-gray-700">Jumlah Ismiyah & Filiyyah</span>
                    </div>
                    <div class="flex items-center gap-2 bg-gradient-to-r from-blue-50 to-cyan-50 px-4 py-2 rounded-lg border-2 border-blue-200">
                        <span class="text-lg">🖱️</span>
                        <span class="text-xs font-bold text-gray-700">Drag & Drop Interface</span>
                    </div>
                </div>

                <!-- Play Button -->
                <div class="mt-auto">
                    <a href="{{ route('santri.sentence-builder.play') }}" 
                       class="block w-full bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white text-center font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 relative overflow-hidden group/btn">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <span class="text-lg">🧩</span>
                            <span>Main Sekarang</span>
                        </span>
                        <!-- Shine effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                    </a>
                </div>

            </div>

        </div>

    </div>
    @endif

    <!-- ========================================== -->
    <!-- GAME KUSTOM DARI DATABASE -->
    <!-- ========================================== -->
    @forelse($games as $index => $game)
        @php
            // Skip game survival quiz support (misalnya dengan title tertentu atau ID tertentu)
            $isHiddenSupportGame = (stripos($game->title, 'Survival Quiz') !== false && $index >= 1);
        @endphp
        
        @if(!$isHiddenSupportGame)
        <div class="group"
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, {{ 300 + ($index * 100) }})"
             x-show="show"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 scale-95">
            
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:scale-105 border-2 border-gray-100 h-full flex flex-col">
                
                <!-- Game Header (Colorful with Pattern) -->
                <div class="relative
                    @if($game->type == 'tebak_gambar') bg-gradient-to-br from-pink-400 via-rose-400 to-red-500
                    @elseif($game->type == 'kosakata_tempat') bg-gradient-to-br from-blue-400 via-indigo-400 to-purple-500
                    @elseif($game->type == 'pilihan_ganda') bg-gradient-to-br from-emerald-400 via-teal-400 to-cyan-500
                    @else bg-gradient-to-br from-amber-400 via-orange-400 to-red-500
                    @endif
                    p-8 text-center text-white overflow-hidden
                ">
                    <!-- Decorative circles -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                    
                    <!-- Icon with animation -->
                    <div class="relative text-7xl mb-4 transform group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">
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
                    
                    <!-- Title -->
                    <h3 class="relative text-2xl font-bold mb-2 drop-shadow-lg">{{ $game->title }}</h3>
                    
                    <!-- Description -->
                    <p class="relative text-sm opacity-95 leading-relaxed min-h-[2.5rem]">
                        {{ Str::limit($game->description, 60) }}
                    </p>

                    <!-- Shine effect on hover -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                </div>

                <!-- Game Body -->
                <div class="p-6 flex-1 flex flex-col">
                    
                    <!-- Stats with Icons -->
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 text-center border-2 border-purple-200 transform group-hover:scale-105 transition-transform">
                            <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                {{ $game->questions_count }}
                            </div>
                            <div class="text-xs text-gray-600 font-semibold mt-1 flex items-center justify-center gap-1">
                                <span>📝</span>
                                <span>Soal</span>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 text-center border-2 border-blue-200 transform group-hover:scale-105 transition-transform">
                            <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                                {{ $game->best_score ? number_format($game->best_score, 0) . '%' : '-' }}
                            </div>
                            <div class="text-xs text-gray-600 font-semibold mt-1 flex items-center justify-center gap-1">
                                <span>🏆</span>
                                <span>Best Score</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="mb-5 flex justify-center">
                        @if($game->completed)
                        <span class="inline-flex items-center gap-2 bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 px-5 py-2 rounded-full text-sm font-bold border-2 border-green-300 shadow-md">
                            <span class="text-base">✓</span>
                            <span>Sudah Dimainkan</span>
                        </span>
                        @else
                        <span class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-700 px-5 py-2 rounded-full text-sm font-bold border-2 border-amber-300 shadow-md">
                            <span class="text-base">🆕</span>
                            <span>Belum Dimainkan</span>
                        </span>
                        @endif
                    </div>

                    <!-- Play Button -->
                    <div class="mt-auto">
                        @if($game->questions_count > 0)
                        <a href="{{ route('santri.games.play', $game->id) }}" 
                           class="block w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white text-center font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 relative overflow-hidden group/btn">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <span class="text-lg">{{ $game->completed ? '🔄' : '🎮' }}</span>
                                <span>{{ $game->completed ? 'Main Lagi' : 'Main Sekarang' }}</span>
                            </span>
                            <!-- Shine effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent transform -skew-x-12 -translate-x-full group-hover/btn:translate-x-full transition-transform duration-700"></div>
                        </a>
                        @else
                        <div class="block w-full bg-gradient-to-r from-gray-300 to-gray-400 text-gray-600 text-center font-bold py-4 rounded-xl cursor-not-allowed shadow-inner flex items-center justify-center gap-2">
                            <span class="text-lg">🔒</span>
                            <span>Belum Ada Soal</span>
                        </div>
                        @endif
                    </div>

                </div>

            </div>

        </div>
        @endif
    @empty
    
    <!-- Empty State (Hanya muncul jika tidak ada game kustom) -->
    <div class="col-span-full">
        <div class="bg-white rounded-3xl shadow-2xl p-12 sm:p-16 text-center border-4 border-emerald-200 relative overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-teal-50 opacity-50"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-300/20 rounded-full blur-3xl -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-300/20 rounded-full blur-3xl -ml-32 -mb-32"></div>
            
            <!-- Content -->
            <div class="relative z-10">
                <div class="inline-block mb-6 animate-bounce">
                    <div class="text-9xl drop-shadow-lg">🎮</div>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-3">Belum Ada Game Kustom</h3>
                <p class="text-lg text-gray-600 max-w-md mx-auto mb-6">
                    Admin atau Ustadz belum membuat game kustom. Tapi kamu masih bisa main <strong>Survival Quiz</strong> dan <strong>Arabic Sentence Builder</strong>! 😊
                </p>
                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 px-6 py-3 rounded-full text-sm font-bold border-2 border-emerald-300">
                    <span>💡</span>
                    <span>Nantikan game seru lainnya!</span>
                </div>
            </div>
        </div>
    </div>
    @endforelse

</div>

<!-- Additional Info Section -->
@if($games->count() > 0 || $sentenceBuilderGame)
<div class="mt-12 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-3xl shadow-2xl p-8 text-white text-center">
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <div class="text-5xl">🌟</div>
        <div class="text-left">
            <h3 class="text-2xl font-bold mb-1">Tips Bermain</h3>
            <p class="text-emerald-50">Mainkan game secara rutin untuk meningkatkan skor dan kemampuan bahasa Arabmu!</p>
        </div>
    </div>
</div>
@endif

<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
</style>
@endsection