@extends('layouts.santri')

@section('title', 'Dashboard Santri')

@push('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
        50% { box-shadow: 0 0 40px rgba(16, 185, 129, 0.6); }
    }

    .float-animation {
        animation: float 3s ease-in-out infinite;
    }

    .shimmer-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: shimmer 3s infinite;
    }

    .glass-morphism {
        backdrop-filter: blur(16px) saturate(180%);
        background: rgba(255, 255, 255, 0.75);
        border: 1px solid rgba(209, 213, 219, 0.3);
    }
</style>
@endpush

@section('content')
@php
    $user = $user ?? auth()->user();
    $levelInfo = $levelInfo ?? \App\Helpers\LevelSystem::getLevelInfo($user->experience_points ?? 0);
    $badge = $badge ?? \App\Helpers\LevelSystem::getBadge($user->total_games_completed ?? 0);
    $nextBadge = $nextBadge ?? \App\Helpers\LevelSystem::getNextBadgeRequirement($user->total_games_completed ?? 0);
    $recentScores = $recentScores ?? collect();
    $averageScore = $averageScore ?? 0;
@endphp

{{-- Hero Welcome Section --}}
<div class="relative bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-3xl shadow-2xl p-8 sm:p-10 mb-8 text-white overflow-hidden">
    {{-- Decorative Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-white rounded-full translate-y-1/2 -translate-x-1/2"></div>
    </div>

    <div class="relative">
        <div class="flex items-start justify-between gap-6">
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full mb-4">
                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    <span class="text-sm font-semibold">Online Sekarang</span>
                </div>
                
                <h1 class="text-3xl sm:text-5xl font-bold mb-3 flex items-center gap-3">
                    <span class="drop-shadow-lg">السلام عليكم</span>
                    <span class="text-4xl sm:text-5xl float-animation">📚</span>
                </h1>
                
                <p class="text-2xl sm:text-3xl font-bold mb-2 drop-shadow">{{ $user->name }}</p>
                <p class="text-lg sm:text-xl opacity-95 font-medium">Mari belajar bahasa Arab dengan semangat!</p>
            </div>
            
            <div class="hidden sm:flex flex-col items-center gap-3">
                <div class="relative">
                    <div class="absolute inset-0 bg-white/30 rounded-3xl blur-xl"></div>
                    <div class="relative text-7xl float-animation" style="animation-delay: 0.5s;">🕌</div>
                </div>
                <div class="bg-white/30 backdrop-blur-sm px-5 py-2 rounded-full border-2 border-white/50">
                    <p class="text-xs font-semibold opacity-90">Level</p>
                    <p class="text-2xl font-bold">{{ $levelInfo['level'] ?? 1 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Statistics Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    {{-- Level & XP Card --}}
    <div class="group relative bg-white rounded-3xl shadow-xl p-6 border-t-4 border-emerald-500 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl">⭐</span>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Level</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ $levelInfo['level'] ?? 1 }}</p>
                </div>
            </div>
            
            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $levelInfo['name'] ?? 'Pemula' }}</h3>
            
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="font-medium text-gray-600">Progress XP</span>
                    <span class="font-bold text-emerald-600">{{ $levelInfo['current_xp'] ?? 0 }} / {{ $levelInfo['xp_needed'] ?? 100 }}</span>
                </div>
                <div class="relative h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-emerald-600 rounded-full transition-all duration-1000 ease-out shadow-inner" 
                         style="width: {{ $levelInfo['progress_percentage'] ?? 0 }}%"></div>
                    <div class="absolute inset-0 shimmer-bg"></div>
                </div>
                <p class="text-xs text-gray-500 text-right font-medium">{{ number_format($levelInfo['progress_percentage'] ?? 0, 1) }}% menuju level berikutnya</p>
            </div>
        </div>
    </div>

    {{-- Badge Card --}}
    <div class="group relative bg-white rounded-3xl shadow-xl p-6 border-t-4 border-amber-500 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl">🏆</span>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Badge</p>
                    <p class="text-2xl font-bold text-amber-600">{{ $badge['emoji'] ?? '🌟' }}</p>
                </div>
            </div>
            
            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $badge['name'] ?? 'Pemula' }}</h3>
            <p class="text-sm text-gray-600 mb-3">{{ $badge['description'] ?? 'Mulai perjalanan belajar' }}</p>
            
            @if($nextBadge)
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3">
                <p class="text-xs font-semibold text-amber-700 mb-1">🎯 Target Berikutnya:</p>
                <p class="text-sm font-bold text-amber-900">{{ $nextBadge['name'] ?? 'Badge Berikutnya' }}</p>
                <p class="text-xs text-amber-600 mt-1">Selesaikan {{ $nextBadge['required'] ?? 5 }} game lagi</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Average Score Card --}}
    <div class="group relative bg-white rounded-3xl shadow-xl p-6 border-t-4 border-blue-500 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 sm:col-span-2 lg:col-span-1 overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <span class="text-3xl">📊</span>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Rata-rata</p>
                    <p class="text-3xl font-bold text-blue-600">{{ number_format($averageScore, 1) }}</p>
                </div>
            </div>
            
            <h3 class="text-lg font-bold text-gray-800 mb-2">Skor Rata-rata</h3>
            <p class="text-sm text-gray-600">Dari {{ $recentScores->count() }} game terakhir</p>
            
            @if($averageScore >= 80)
            <div class="mt-3 bg-green-50 border border-green-200 rounded-xl p-3 flex items-center gap-2">
                <span class="text-2xl">🌟</span>
                <p class="text-sm font-semibold text-green-700">Luar biasa! Pertahankan!</p>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Recent Scores --}}
@if($recentScores->count() > 0)
<div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 mb-8 border-l-4 border-teal-500">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-12 h-12 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl flex items-center justify-center">
            <span class="text-2xl">📈</span>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Progres Terakhir</h2>
            <p class="text-sm text-gray-500">Pantau perkembangan belajarmu</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($recentScores->take(3) as $score)
        <div class="group bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-5 hover:shadow-lg transition-all duration-300 border border-gray-200">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <h4 class="font-bold text-gray-800 mb-1 group-hover:text-teal-600 transition-colors">{{ $score->game_name ?? 'Game' }}</h4>
                    <p class="text-xs text-gray-500">{{ $score->created_at->diffForHumans() }}</p>
                </div>
                <div class="text-2xl font-bold {{ $score->score >= 80 ? 'text-green-500' : ($score->score >= 60 ? 'text-yellow-500' : 'text-red-500') }}">
                    {{ $score->score }}
                </div>
            </div>
            
            <div class="relative h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r {{ $score->score >= 80 ? 'from-green-400 to-green-600' : ($score->score >= 60 ? 'from-yellow-400 to-yellow-600' : 'from-red-400 to-red-600') }} rounded-full transition-all duration-500" 
                     style="width: {{ $score->score }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Quick Access Section --}}
<div class="mb-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center shadow-lg">
            <span class="text-2xl">⚡</span>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Akses Cepat</h2>
            <p class="text-sm text-gray-500">Menu favorit untuk pembelajaran</p>
        </div>
    </div>
    
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Leaderboard Card --}}
        <a href="{{ route('santri.leaderboard') }}" 
           class="group relative bg-gradient-to-br from-yellow-400 via-orange-400 to-red-500 rounded-3xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden">
            <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
            <div class="relative text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300 group-hover:scale-110">
                    <span class="text-5xl float-animation">🏆</span>
                </div>
                <h3 class="text-lg font-bold mb-1 drop-shadow">Leaderboard</h3>
                <p class="text-sm opacity-90 font-medium">Peringkat global</p>
            </div>
        </a>

        {{-- Scores Card --}}
        <a href="{{ route('santri.scores') }}" 
           class="group relative bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden">
            <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
            <div class="relative text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300 group-hover:scale-110">
                    <span class="text-5xl float-animation" style="animation-delay: 0.2s;">📊</span>
                </div>
                <h3 class="text-lg font-bold mb-1 drop-shadow">Riwayat Skor</h3>
                <p class="text-sm opacity-90 font-medium">Lihat progres</p>
            </div>
        </a>

        {{-- Profile Card --}}
        <a href="{{ route('santri.profile') }}" 
           class="group relative bg-gradient-to-br from-cyan-500 to-blue-500 rounded-3xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden">
            <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
            <div class="relative text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300 group-hover:scale-110">
                    <span class="text-5xl float-animation" style="animation-delay: 0.4s;">👤</span>
                </div>
                <h3 class="text-lg font-bold mb-1 drop-shadow">Profil Saya</h3>
                <p class="text-sm opacity-90 font-medium">Edit profil</p>
            </div>
        </a>

        {{-- All Games Card --}}
        <a href="{{ route('santri.games.index') }}" 
           class="group relative bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden">
            <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
            <div class="relative text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300 group-hover:scale-110">
                    <span class="text-5xl float-animation" style="animation-delay: 0.6s;">🎮</span>
                </div>
                <h3 class="text-lg font-bold mb-1 drop-shadow">Semua Game</h3>
                <p class="text-sm opacity-90 font-medium">Main sekarang</p>
            </div>
        </a>
    </div>
</div>

{{-- Featured Games Section --}}
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-rose-500 rounded-2xl flex items-center justify-center shadow-lg">
                <span class="text-2xl">🎮</span>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Game Pilihan</h2>
                <p class="text-sm text-gray-500">Mulai belajar sekarang</p>
            </div>
        </div>
        <a href="{{ route('santri.games.index') }}" 
           class="group flex items-center gap-2 text-sm font-bold text-emerald-600 hover:text-emerald-700 px-5 py-2.5 rounded-xl hover:bg-emerald-50 transition-all duration-300 border-2 border-transparent hover:border-emerald-200">
            <span>Semua Game</span>
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Tebak Gambar --}}
        <a href="{{ route('santri.games.index') }}" 
           class="group relative bg-gradient-to-br from-pink-500 to-rose-500 rounded-3xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:rotate-1 overflow-hidden">
            <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
            <div class="relative text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                    <span class="text-5xl">🖼️</span>
                </div>
                <h3 class="text-lg font-bold mb-1 drop-shadow">Tebak Gambar</h3>
                <p class="text-sm opacity-90 font-medium">Tebak kosakata</p>
            </div>
        </a>

        {{-- Kosakata Tempat --}}
        <a href="{{ route('santri.games.index') }}" 
           class="group relative bg-gradient-to-br from-blue-500 to-indigo-500 rounded-3xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:rotate-1 overflow-hidden">
            <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
            <div class="relative text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                    <span class="text-5xl">🏫</span>
                </div>
                <h3 class="text-lg font-bold mb-1 drop-shadow">Kosakata Tempat</h3>
                <p class="text-sm opacity-90 font-medium">30 tempat</p>
            </div>
        </a>

        {{-- Game 3 --}}
        <a href="{{ route('santri.games.index') }}" 
           class="group relative bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:rotate-1 overflow-hidden">
            <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
            <div class="relative text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                    <span class="text-5xl">✏️</span>
                </div>
                <h3 class="text-lg font-bold mb-1 drop-shadow">Kuis Cepat</h3>
                <p class="text-sm opacity-90 font-medium">Uji kemampuan</p>
            </div>
        </a>

        {{-- Game 4 --}}
        <a href="{{ route('santri.games.index') }}" 
           class="group relative bg-gradient-to-br from-amber-500 to-orange-500 rounded-3xl shadow-xl p-6 text-white hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:rotate-1 overflow-hidden">
            <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
            <div class="relative text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300 group-hover:scale-110 group-hover:rotate-12">
                    <span class="text-5xl">🎯</span>
                </div>
                <h3 class="text-lg font-bold mb-1 drop-shadow">Tantangan Harian</h3>
                <p class="text-sm opacity-90 font-medium">Bonus XP</p>
            </div>
        </a>
    </div>
</div>

{{-- Motivation Card --}}
<div class="relative bg-gradient-to-br from-teal-50 via-emerald-50 to-cyan-50 rounded-3xl shadow-xl p-8 sm:p-10 text-center border-2 border-emerald-200 overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-10 left-10 w-40 h-40 bg-emerald-400 rounded-full"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-teal-400 rounded-full"></div>
    </div>
    
    <div class="relative">
        <div class="text-6xl mb-4 float-animation">🌟</div>
        <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3">Tetap Semangat Belajar!</h3>
        <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto mb-6">
            Setiap hari adalah kesempatan baru untuk belajar. Konsistensi adalah kunci kesuksesan!
        </p>
        <div class="flex items-center justify-center gap-4 flex-wrap">
            <div class="bg-white rounded-2xl px-6 py-3 shadow-lg border border-emerald-200">
                <p class="text-sm font-semibold text-gray-500 mb-1">Hari ini</p>
                <p class="text-2xl font-bold text-emerald-600">{{ now()->format('d M Y') }}</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 to-teal-500 text-white rounded-2xl px-6 py-3 shadow-lg">
                <p class="text-sm font-semibold opacity-90 mb-1">Target Harian</p>
                <p class="text-2xl font-bold">3 Game ✨</p>
            </div>
        </div>
    </div>
</div>
@endsection