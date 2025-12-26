@extends('layouts.ustadz')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between gap-2">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight flex items-center gap-2 animate-fade-in">
                <span>📊</span> Skor Santri
            </h2>
            <a href="{{ route('ustadz.dashboard') }}" 
               class="px-3 py-2 sm:px-4 bg-gradient-to-r from-gray-400 to-gray-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 text-sm sm:text-base whitespace-nowrap active:scale-95">
                ← <span class="hidden sm:inline">Dashboard</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filter by Game -->
            <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-6 mb-4 sm:mb-6 border-t-4 border-emerald-500 animate-fade-in-up">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-3 sm:mb-4 flex items-center gap-2">
                    <span class="animate-pulse">🎮</span> Filter Game
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2 sm:gap-3">
                    <a href="{{ route('ustadz.scores.index') }}" 
                       class="px-3 py-2.5 sm:px-4 sm:py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl hover:shadow-lg hover:scale-105 transition-all text-center group">
                        <div class="text-2xl sm:text-3xl mb-1 group-hover:scale-110 transition-transform duration-300">📊</div>
                        <div class="text-xs sm:text-sm font-bold">Semua</div>
                    </a>
                    @foreach($games as $index => $game)
                        <a href="{{ route('ustadz.scores.game', $game->id) }}" 
                           class="px-3 py-2.5 sm:px-4 sm:py-3 border-2 border-gray-300 rounded-xl hover:border-emerald-500 hover:bg-gradient-to-br hover:from-emerald-50 hover:to-teal-50 hover:scale-105 transition-all text-center group animate-slide-in" 
                           style="animation-delay: {{ 0.05 * $index }}s;">
                            <div class="text-2xl sm:text-3xl mb-1 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                                @if($game->type === 'tebak_gambar') 🖼️
                                @elseif($game->type === 'kosakata_tempat') 🏫
                                @elseif($game->type === 'pilihan_ganda') ✅
                                @else 💬
                                @endif
                            </div>
                            <div class="text-xs font-medium text-gray-800 group-hover:text-emerald-700 line-clamp-2">
                                {{ Str::limit($game->title, 20) }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Scores List -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-teal-500 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 p-4 sm:p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 opacity-10 animate-pulse">
                        <svg class="w-32 h-32" viewBox="0 0 200 200" fill="currentColor">
                            <path d="M100,20 L110,50 L140,50 L115,70 L125,100 L100,80 L75,100 L85,70 L60,50 L90,50 Z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center gap-2 relative z-10">
                        <span>📈</span> Semua Skor
                    </h2>
                    <p class="text-white text-xs sm:text-sm opacity-90 mt-1 relative z-10">Total: {{ $scores->total() }} pengerjaan</p>
                </div>

                @if($scores->count() > 0)
                    
                    <!-- MOBILE: Card View -->
                    <div class="block lg:hidden divide-y divide-gray-100">
                        @foreach($scores as $index => $score)
                            <div class="p-4 hover:bg-gradient-to-r hover:from-gray-50 hover:to-teal-50 transition-all duration-300 animate-slide-in" style="animation-delay: {{ 0.05 * $index }}s;">
                                <!-- Santri Info -->
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-gradient-to-br from-teal-100 to-emerald-100 rounded-xl transform hover:scale-110 hover:rotate-6 transition-all duration-300">
                                        <span class="text-2xl">
                                            @if($score->user->role === 'santri_putra') 👨‍🎓
                                            @else 👩‍🎓
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-gray-900 text-sm truncate">{{ $score->user->name }}</h4>
                                        <p class="text-xs text-gray-500 truncate">{{ $score->user->email }}</p>
                                    </div>
                                </div>

                                <!-- Game Info -->
                                <div class="flex items-center gap-2 mb-3 p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                                    <span class="text-2xl">
                                        @if($score->game->type === 'tebak_gambar') 🖼️
                                        @elseif($score->game->type === 'kosakata_tempat') 🏫
                                        @elseif($score->game->type === 'pilihan_ganda') ✅
                                        @else 💬
                                        @endif
                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $score->game->title }}</p>
                                        <p class="text-xs text-gray-500">
                                            @if($score->game->type === 'tebak_gambar') Tebak Gambar
                                            @elseif($score->game->type === 'kosakata_tempat') Kosakata
                                            @elseif($score->game->type === 'pilihan_ganda') Pilihan Ganda
                                            @else Percakapan
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Score & Stats -->
                                <div class="grid grid-cols-3 gap-2 mb-3">
                                    @php
                                        $scoreValue = ($score->correct_answers / $score->total_questions) * 100;
                                    @endphp
                                    <div class="text-center p-2 rounded-lg @if($scoreValue >= 80) bg-gradient-to-br from-emerald-100 to-teal-100 @elseif($scoreValue >= 60) bg-gradient-to-br from-blue-100 to-indigo-100 @else bg-gradient-to-br from-purple-100 to-pink-100 @endif transform hover:scale-105 transition-transform duration-300">
                                        <div class="text-2xl font-bold @if($scoreValue >= 80) text-emerald-600 @elseif($scoreValue >= 60) text-blue-600 @else text-purple-600 @endif">
                                            {{ number_format($scoreValue, 0) }}
                                        </div>
                                        <div class="text-xs text-gray-600 font-medium">Skor</div>
                                    </div>
                                    <div class="text-center p-2 bg-gray-100 rounded-lg transform hover:scale-105 transition-transform duration-300">
                                        <div class="text-lg font-bold text-gray-800">{{ $score->correct_answers }}/{{ $score->total_questions }}</div>
                                        <div class="text-xs text-gray-600">Benar</div>
                                    </div>
                                    <div class="text-center p-2 bg-gray-100 rounded-lg transform hover:scale-105 transition-transform duration-300">
                                        <div class="text-xs font-bold text-gray-800">{{ $score->completed_at->format('d M') }}</div>
                                        <div class="text-xs text-gray-600">{{ $score->completed_at->format('H:i') }}</div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('ustadz.scores.detail', $score->id) }}" 
                                   class="block w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 text-center active:scale-95">
                                    👁️ Lihat Detail
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- DESKTOP: Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-100 to-emerald-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        👨‍🎓 Santri
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        🎮 Game
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        📊 Skor
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        ✅ Benar/Total
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        🕐 Waktu
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        ⚙️ Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($scores as $score)
                                    <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-emerald-50 transition-all duration-300">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-gradient-to-br from-teal-100 to-emerald-100 rounded-xl transform hover:scale-110 hover:rotate-6 transition-all duration-300">
                                                    <span class="text-2xl">
                                                        @if($score->user->role === 'santri_putra') 👨‍🎓
                                                        @else 👩‍🎓
                                                        @endif
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900">{{ $score->user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $score->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <span class="text-2xl transform hover:scale-125 hover:rotate-12 transition-all duration-300">
                                                    @if($score->game->type === 'tebak_gambar') 🖼️
                                                    @elseif($score->game->type === 'kosakata_tempat') 🏫
                                                    @elseif($score->game->type === 'pilihan_ganda') ✅
                                                    @else 💬
                                                    @endif
                                                </span>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $score->game->title }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        @if($score->game->type === 'tebak_gambar') Tebak Gambar
                                                        @elseif($score->game->type === 'kosakata_tempat') Kosakata
                                                        @elseif($score->game->type === 'pilihan_ganda') Pilihan Ganda
                                                        @else Percakapan
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $scoreValue = ($score->correct_answers / $score->total_questions) * 100;
                                            @endphp
                                            @if($scoreValue >= 80)
                                                <span class="px-4 py-2 inline-flex text-lg leading-5 font-bold rounded-full bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-800 border border-emerald-300 transform hover:scale-110 transition-transform duration-300">
                                                    {{ number_format($scoreValue, 0) }}
                                                </span>
                                            @elseif($scoreValue >= 60)
                                                <span class="px-4 py-2 inline-flex text-lg leading-5 font-bold rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-300 transform hover:scale-110 transition-transform duration-300">
                                                    {{ number_format($scoreValue, 0) }}
                                                </span>
                                            @else
                                                <span class="px-4 py-2 inline-flex text-lg leading-5 font-bold rounded-full bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 border border-purple-300 transform hover:scale-110 transition-transform duration-300">
                                                    {{ number_format($scoreValue, 0) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="text-sm font-bold text-gray-900">
                                                {{ $score->correct_answers }}/{{ $score->total_questions }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ number_format(($score->correct_answers / $score->total_questions) * 100, 1) }}%
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <div class="font-medium">{{ $score->completed_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $score->completed_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('ustadz.scores.detail', $score->id) }}" 
                                               class="inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 text-sm font-semibold active:scale-95">
                                                👁️ Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-gray-50 to-emerald-50 border-t border-gray-200">
                        {{ $scores->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12 sm:py-16 px-4">
                        <div class="mb-4">
                            <span class="text-6xl sm:text-7xl animate-bounce-slow">📊</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Belum Ada Skor</h3>
                        <p class="text-sm sm:text-base text-gray-500">Belum ada santri yang mengerjakan game Anda</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounceSlow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .animate-slide-in {
            animation: slideIn 0.4s ease-out;
            animation-fill-mode: both;
        }

        .animate-bounce-slow {
            animation: bounceSlow 3s ease-in-out infinite;
        }
    </style>
@endsection