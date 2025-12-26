@extends('layouts.ustadz')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between gap-2">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight flex items-center gap-2 animate-fade-in">
                <span>🎮</span> <span class="hidden sm:inline">Kelola</span> Game
            </h2>
            <a href="{{ route('ustadz.games.create') }}" 
               class="px-3 py-2 sm:px-4 text-sm sm:text-base bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 whitespace-nowrap active:scale-95">
                ➕ <span class="hidden sm:inline">Buat</span> Game
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 sm:mb-6 bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 p-3 sm:p-4 rounded-xl shadow-md animate-slide-in" role="alert">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="text-2xl sm:text-3xl animate-bounce">✅</span>
                        <div>
                            <p class="font-bold text-sm sm:text-base text-emerald-800">Berhasil!</p>
                            <p class="text-xs sm:text-sm text-emerald-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 sm:mb-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-xl shadow-md animate-slide-in" role="alert">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="text-2xl sm:text-3xl animate-bounce">❌</span>
                        <div>
                            <p class="font-bold text-sm sm:text-base text-red-800">Error!</p>
                            <p class="text-xs sm:text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Games List -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-emerald-500 animate-fade-in-up">
                @if($games->count() > 0)
                    
                    <!-- MOBILE: Card View (< 768px) -->
                    <div class="block md:hidden">
                        <div class="bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 text-white px-4 py-3 relative overflow-hidden">
                            <div class="absolute top-0 right-0 opacity-10 animate-pulse">
                                <svg class="w-24 h-24" viewBox="0 0 200 200" fill="currentColor">
                                    <path d="M100,20 L110,50 L140,50 L115,70 L125,100 L100,80 L75,100 L85,70 L60,50 L90,50 Z"/>
                                </svg>
                            </div>
                            <h3 class="font-bold text-sm relative z-10">📚 Daftar Game ({{ $games->total() }})</h3>
                        </div>
                        
                        <div class="divide-y divide-gray-100">
                            @foreach($games as $index => $game)
                                <div class="p-4 hover:bg-gradient-to-r hover:from-gray-50 hover:to-emerald-50 transition-all duration-300 animate-slide-in" style="animation-delay: {{ 0.05 * $index }}s;">
                                    <!-- Game Info -->
                                    <div class="flex items-start gap-3 mb-3">
                                        <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-gradient-to-br from-teal-100 to-emerald-100 rounded-xl transform hover:scale-110 hover:rotate-6 transition-all duration-300">
                                            <span class="text-2xl">
                                                @if($game->type === 'tebak_gambar') 🖼️
                                                @elseif($game->type === 'kosakata_tempat') 🏫
                                                @elseif($game->type === 'pilihan_ganda') ✅
                                                @else 💬
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-900 text-sm mb-1 line-clamp-2">{{ $game->title }}</h4>
                                            <p class="text-xs text-gray-500 line-clamp-1">{{ $game->description }}</p>
                                        </div>
                                    </div>

                                    <!-- Type Badge -->
                                    <div class="mb-3">
                                        @if($game->type === 'tebak_gambar')
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-pink-100 to-rose-100 text-pink-800 transform hover:scale-105 transition-transform duration-300 inline-block">
                                                🖼️ Tebak Gambar
                                            </span>
                                        @elseif($game->type === 'kosakata_tempat')
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 transform hover:scale-105 transition-transform duration-300 inline-block">
                                                🏫 Kosakata
                                            </span>
                                        @elseif($game->type === 'pilihan_ganda')
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-800 transform hover:scale-105 transition-transform duration-300 inline-block">
                                                ✅ Pilihan Ganda
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-gradient-to-r from-amber-100 to-orange-100 text-amber-800 transform hover:scale-105 transition-transform duration-300 inline-block">
                                                💬 Percakapan
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Stats -->
                                    <div class="flex items-center gap-4 mb-3 text-xs">
                                        <div class="flex items-center gap-1">
                                            <span class="font-bold text-emerald-600">{{ $game->questions_count }}</span>
                                            <span class="text-gray-500">Soal</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="font-bold text-blue-600">{{ $game->scores_count }}</span>
                                            <span class="text-gray-500">Dimainkan</span>
                                        </div>
                                        <div>
                                            @if($game->status == 'published')
                                                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 inline-flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                                    Live
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-gray-200 text-gray-700 inline-flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                                                    Draft
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="grid grid-cols-3 gap-2">
                                        <form action="{{ route('ustadz.games.toggleStatus', $game->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengubah status?')">
                                            @csrf
                                            @if($game->status == 'published')
                                                <button type="submit" class="w-full px-2 py-1.5 bg-gray-400 hover:bg-gray-500 text-white text-xs font-semibold rounded-lg transition-all duration-300 hover:scale-105 active:scale-95">
                                                    📦 Draft
                                                </button>
                                            @else
                                                <button type="submit" class="w-full px-2 py-1.5 bg-gradient-to-r from-teal-500 to-emerald-500 text-white text-xs font-semibold rounded-lg hover:shadow-md transition-all duration-300 hover:scale-105 active:scale-95">
                                                    🚀 Publish
                                                </button>
                                            @endif
                                        </form>

                                        <a href="{{ route('ustadz.games.show', $game->id) }}" 
                                           class="px-2 py-1.5 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs font-semibold rounded-lg hover:shadow-md transition-all duration-300 text-center hover:scale-105 active:scale-95">
                                            👁️ Detail
                                        </a>
                                        
                                        <a href="{{ route('ustadz.games.questions.index', $game->id) }}" 
                                           class="px-2 py-1.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-semibold rounded-lg hover:shadow-md transition-all duration-300 text-center hover:scale-105 active:scale-95">
                                            📝 Soal
                                        </a>
                                    </div>

                                    <!-- Secondary Actions -->
                                    <div class="grid grid-cols-2 gap-2 mt-2">
                                        <a href="{{ route('ustadz.games.edit', $game->id) }}" 
                                           class="px-2 py-1.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-semibold rounded-lg hover:shadow-md transition-all duration-300 text-center hover:scale-105 active:scale-95">
                                            ✏️ Edit
                                        </a>
                                        
                                        <form action="{{ route('ustadz.games.destroy', $game->id) }}" method="POST" onsubmit="return confirm('Yakin hapus? Semua soal akan terhapus!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-2 py-1.5 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-semibold rounded-lg hover:shadow-md transition-all duration-300 hover:scale-105 active:scale-95">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- DESKTOP: Table View (≥ 768px) -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Game
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Tipe
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Pertanyaan
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Pengerjaan
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($games as $game)
                                    <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-emerald-50 transition-all duration-300">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-gradient-to-br from-teal-100 to-emerald-100 rounded-xl transform hover:scale-110 hover:rotate-6 transition-all duration-300">
                                                    <span class="text-2xl">
                                                        @if($game->type === 'tebak_gambar') 🖼️
                                                        @elseif($game->type === 'kosakata_tempat') 🏫
                                                        @elseif($game->type === 'pilihan_ganda') ✅
                                                        @else 💬
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="text-sm font-bold text-gray-900 truncate">{{ $game->title }}</div>
                                                    <div class="text-xs text-gray-500 truncate">{{ Str::limit($game->description, 50) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($game->type === 'tebak_gambar')
                                                <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-pink-100 to-rose-100 text-pink-800 border border-pink-200 transform hover:scale-105 transition-transform duration-300">
                                                    🖼️ Tebak Gambar
                                                </span>
                                            @elseif($game->type === 'kosakata_tempat')
                                                <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200 transform hover:scale-105 transition-transform duration-300">
                                                    🏫 Kosakata Tempat
                                                </span>
                                            @elseif($game->type === 'pilihan_ganda')
                                                <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-800 border border-emerald-200 transform hover:scale-105 transition-transform duration-300">
                                                    ✅ Pilihan Ganda
                                                </span>
                                            @else
                                                <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-amber-100 to-orange-100 text-amber-800 border border-amber-200 transform hover:scale-105 transition-transform duration-300">
                                                    💬 Percakapan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="w-10 h-10 flex items-center justify-center bg-emerald-100 rounded-lg transform hover:scale-110 transition-transform duration-300">
                                                    <span class="text-lg font-bold text-emerald-600">{{ $game->questions_count }}</span>
                                                </div>
                                                <div class="text-xs text-gray-500">Soal</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-lg transform hover:scale-110 transition-transform duration-300">
                                                    <span class="text-lg font-bold text-blue-600">{{ $game->scores_count }}</span>
                                                </div>
                                                <div class="text-xs text-gray-500">Kali</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($game->status == 'published')
                                                <span class="px-3 py-1.5 inline-flex items-center gap-1 text-xs leading-5 font-bold rounded-full bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-800 border border-emerald-300 transform hover:scale-105 transition-transform duration-300">
                                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                                    Published
                                                </span>
                                            @else
                                                <span class="px-3 py-1.5 inline-flex items-center gap-1 text-xs leading-5 font-bold rounded-full bg-gray-200 text-gray-700 border border-gray-300 transform hover:scale-105 transition-transform duration-300">
                                                    <span class="w-2 h-2 bg-gray-500 rounded-full"></span>
                                                    Draft
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-2 flex-wrap">
                                                
                                                <form action="{{ route('ustadz.games.toggleStatus', $game->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mengubah status game ini?')">
                                                    @csrf
                                                    @if($game->status == 'published')
                                                        <button type="submit" 
                                                                class="px-3 py-1.5 bg-gradient-to-r from-gray-400 to-gray-500 text-white text-xs font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 active:scale-95" 
                                                                title="Unpublish (Jadikan Draft)">
                                                            Draft
                                                        </button>
                                                    @else
                                                        <button type="submit" 
                                                                class="px-3 py-1.5 bg-gradient-to-r from-teal-500 to-emerald-500 text-white text-xs font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 active:scale-95" 
                                                                title="Publish (Tayangkan ke Santri)">
                                                            Publish
                                                        </button>
                                                    @endif
                                                </form>

                                                <a href="{{ route('ustadz.games.show', $game->id) }}" 
                                                   class="px-3 py-1.5 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 active:scale-95" 
                                                   title="Detail">
                                                    Detail
                                                </a>
                                                
                                                <a href="{{ route('ustadz.games.questions.index', $game->id) }}" 
                                                   class="px-3 py-1.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 active:scale-95" 
                                                   title="Kelola Soal">
                                                    Soal
                                                </a>
                                                
                                                <a href="{{ route('ustadz.games.edit', $game->id) }}" 
                                                   class="px-3 py-1.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 active:scale-95" 
                                                   title="Edit">
                                                    Edit
                                                </a>
                                                
                                                <form action="{{ route('ustadz.games.destroy', $game->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus game ini? Semua pertanyaan akan ikut terhapus!')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="px-3 py-1.5 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 active:scale-95" 
                                                            title="Hapus">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-gray-50 to-emerald-50 border-t border-gray-200">
                        {{ $games->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12 sm:py-16 px-4">
                        <div class="mb-4">
                            <span class="text-6xl sm:text-7xl animate-bounce-slow">🎮</span>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Belum Ada Game</h3>
                        <p class="text-sm sm:text-base text-gray-500 mb-6 max-w-md mx-auto">Mulai buat game pembelajaran pertama Anda dan bagikan ilmu kepada para santri!</p>
                        <a href="{{ route('ustadz.games.create') }}" 
                           class="inline-flex items-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm sm:text-base font-semibold rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 active:scale-95">
                            <span>➕</span>
                            <span>Buat Game Sekarang</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Info Card - Bonus -->
            <div class="mt-4 sm:mt-6 bg-gradient-to-br from-teal-50 to-emerald-50 rounded-2xl shadow-lg p-4 sm:p-6 border-2 border-emerald-200 hover:shadow-xl transition-shadow duration-300 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex items-start gap-3 sm:gap-4">
                    <span class="text-3xl sm:text-4xl animate-pulse">💡</span>
                    <div class="flex-1">
                        <h3 class="text-base sm:text-lg font-bold text-emerald-800 mb-2">Tips Kelola Game</h3>
                        <ul class="text-xs sm:text-sm text-gray-700 space-y-1">
                            <li>• <strong>Draft:</strong> Game tidak terlihat oleh santri</li>
                            <li>• <strong>Published:</strong> Game aktif dan bisa dimainkan</li>
                            <li>• Minimal 5 pertanyaan sebelum publish</li>
                            <li>• Klik 📝 untuk menambah/edit pertanyaan</li>
                        </ul>
                    </div>
                </div>
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