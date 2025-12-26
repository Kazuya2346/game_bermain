@extends('layouts.santri')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto px-2 sm:px-3 py-2 sm:py-4">
    
    <!-- Profile Header - Enhanced Islamic Theme - Mobile Optimized -->
    <div class="bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl p-3 sm:p-6 text-white mb-3 sm:mb-4 relative overflow-hidden transform hover:scale-[1.005] transition-all duration-500">
        
        <!-- Animated Decorative Islamic Patterns - Reduced size for mobile -->
        <div class="absolute top-0 right-0 opacity-10 animate-pulse">
            <svg class="w-20 h-20 sm:w-48 sm:h-48" viewBox="0 0 200 200" fill="currentColor">
                <path d="M100,20 L110,50 L140,50 L115,70 L125,100 L100,80 L75,100 L85,70 L60,50 L90,50 Z"/>
                <circle cx="100" cy="100" r="30" fill="none" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div class="absolute bottom-0 left-0 opacity-10 animate-pulse" style="animation-delay: 1.5s;">
            <svg class="w-16 h-16 sm:w-36 sm:h-36" viewBox="0 0 200 200" fill="currentColor">
                <path d="M100,20 L110,50 L140,50 L115,70 L125,100 L100,80 L75,100 L85,70 L60,50 L90,50 Z"/>
                <circle cx="100" cy="100" r="25" fill="none" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        
        <!-- Enhanced Floating particles with glow effect - Reduced number for mobile -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-1.5 h-1.5 sm:w-2 sm:h-2 bg-white rounded-full opacity-40 animate-float shadow-glow" style="top: 15%; left: 8%; animation-delay: 0s;"></div>
            <div class="absolute w-1 h-1 sm:w-1.5 sm:h-1.5 bg-yellow-200 rounded-full opacity-50 animate-float shadow-glow" style="top: 65%; left: 85%; animation-delay: 2s;"></div>
            <div class="absolute w-1 h-1 sm:w-2 sm:h-2 bg-pink-200 rounded-full opacity-45 animate-float shadow-glow" style="top: 35%; left: 25%; animation-delay: 4s;"></div>
        </div>

        <!-- Gradient Overlay Animation -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-10 animate-shimmer-slow"></div>
        
        <div class="relative flex flex-col items-center space-y-3 sm:space-y-0">
            
            <!-- Avatar dengan Upload - Mobile Optimized -->
            <div class="relative group flex-shrink-0">
                <!-- Triple Glow Ring Effect - Reduced for mobile -->
                <div class="absolute -inset-0.5 sm:-inset-1.5 bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400 rounded-full blur-md sm:blur opacity-75 group-hover:opacity-100 transition duration-500 animate-pulse-slow"></div>
                <div class="absolute -inset-0.5 sm:-inset-1 bg-gradient-to-r from-yellow-300 via-pink-300 to-purple-300 rounded-full blur opacity-60 group-hover:opacity-90 transition duration-500"></div>
                
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                         alt="Profile Photo" 
                         class="relative w-16 h-16 sm:w-28 sm:h-28 rounded-full object-cover border-3 border-white shadow-lg sm:shadow-xl transform group-hover:scale-105 group-hover:rotate-3 transition-all duration-500">
                @else
                    <div class="relative w-16 h-16 sm:w-28 sm:h-28 bg-gradient-to-br from-white to-gray-50 rounded-full flex items-center justify-center text-3xl sm:text-5xl border-3 border-white shadow-lg sm:shadow-xl transform group-hover:scale-105 group-hover:rotate-3 transition-all duration-500">
                        {{ $user->role == 'santri_putra' ? '👦' : '👧' }}
                    </div>
                @endif
                
                <!-- Upload Button Overlay - Enhanced with Ripple Effect -->
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 bg-opacity-95 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 backdrop-blur-sm"
                     x-data="{ showModal: false }">
                    <button @click.prevent="showModal = true" type="button" class="relative text-white text-xs font-bold px-2 py-1.5 sm:px-3 sm:py-2 bg-white bg-opacity-20 rounded-lg sm:rounded-lg hover:bg-opacity-30 transform hover:scale-105 active:scale-95 transition-all duration-200 shadow-md sm:shadow border border-white/30">
                        <span class="flex items-center gap-1 sm:gap-1.5">
                            📸 <span class="font-bold text-xs">Ubah</span>
                        </span>
                    </button>
                    
                    <!-- Modal Upload Photo - Ultra Enhanced - Mobile Optimized -->
                    <template x-teleport="body">
                        <div x-show="showModal" 
                             @click.self="showModal = false"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-[9999] p-2 sm:p-3 backdrop-blur-md"
                             style="display: none;">
                            <div x-show="showModal"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-90"
                                 @click.stop 
                                 class="bg-gradient-to-br from-white to-gray-50 rounded-lg sm:rounded-2xl p-3 sm:p-6 max-w-md w-full transform shadow-xl border-3 border-emerald-200 max-h-[85vh] overflow-y-auto">
                                <div class="text-center mb-3 sm:mb-4">
                                    <div class="inline-block p-2 sm:p-3 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full mb-2 sm:mb-3 animate-bounce-slow">
                                        <span class="text-3xl sm:text-4xl">📸</span>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                        Upload Foto Profil
                                    </h3>
                                    <p class="text-gray-600 text-xs sm:text-sm mt-1">Tampilkan identitasmu yang terbaik! ✨</p>
                                </div>
                                
                                <form action="{{ route('profile.photo.update') }}"
                                      method="POST" 
                                      enctype="multipart/form-data"
                                      class="space-y-3 sm:space-y-4">
                                    @csrf
                                    
                                    <div class="relative">
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5 sm:mb-2 flex items-center gap-1">
                                            <span class="text-base">🖼️</span> Pilih Foto Terbaikmu
                                        </label>
                                        <div class="relative group">
                                            <input type="file" 
                                                   name="profile_photo" 
                                                   accept="image/*"
                                                   required
                                                   class="block w-full text-xs text-gray-600
                                                          file:mr-1.5 sm:file:mr-3 file:py-1.5 sm:file:py-2.5 file:px-2.5 sm:file:px-4
                                                          file:rounded-lg file:border-0
                                                          file:text-xs file:font-bold
                                                          file:bg-gradient-to-r file:from-emerald-500 file:to-teal-500 file:text-white
                                                          hover:file:from-emerald-600 hover:file:to-teal-600 file:cursor-pointer
                                                          file:shadow hover:file:shadow-md file:transition-all file:duration-300
                                                          cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-2 sm:p-3
                                                          hover:border-emerald-400 transition-all">
                                        </div>
                                        <div class="mt-1.5 sm:mt-2 p-1.5 sm:p-2 bg-blue-50 rounded border border-blue-200">
                                            <p class="text-xs text-blue-800 font-semibold flex items-center gap-1">
                                                <span>ℹ️</span> 
                                                <span class="text-xs">Format: JPG, PNG, GIF • Maks: 2MB</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col sm:flex-row gap-1.5 sm:gap-2">
                                        <button type="submit" 
                                                class="flex-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 hover:from-emerald-600 hover:via-teal-600 hover:to-cyan-600 text-white font-bold py-2.5 sm:py-3 px-3 rounded-lg transition-all duration-300 active:scale-95 shadow hover:shadow-md transform hover:-translate-y-0.5 flex items-center justify-center gap-1">
                                            <span class="text-base sm:text-lg">✨</span>
                                            <span class="text-xs sm:text-sm">Upload Sekarang</span>
                                        </button>
                                        <button type="button" 
                                                @click="showModal = false"
                                                class="flex-1 bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-700 font-bold py-2.5 sm:py-3 px-3 rounded-lg transition-all duration-300 active:scale-95 shadow">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                                
                                @if($user->profile_photo)
                                    <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-200">
                                        <form action="{{ route('profile.photo.update') }}" 
                                              method="POST" 
                                              onsubmit="return confirm('⚠️ Yakin ingin menghapus foto profil?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-2.5 sm:py-3 px-3 rounded-lg transition-all duration-300 active:scale-95 shadow hover:shadow-md flex items-center justify-center gap-1 transform hover:-translate-y-0.5">
                                                <span class="text-base sm:text-lg">🗑️</span>
                                                <span class="text-xs sm:text-sm">Hapus Foto Profil</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Status Badge on Avatar -->
                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-green-400 to-emerald-500 text-white text-xs font-bold px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full shadow border-1.5 border-white flex items-center gap-0.5 animate-bounce-subtle">
                    <span class="w-1 h-1 sm:w-1.5 sm:h-1.5 bg-white rounded-full animate-pulse"></span>
                    <span class="text-xs">Online</span>
                </div>
            </div>
            
            <!-- User Info - Enhanced - Mobile Optimized -->
            <div class="flex-1 text-center space-y-1.5 sm:space-y-2 w-full">
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold mb-0.5 sm:mb-1 drop-shadow flex items-center justify-center gap-1.5 sm:gap-2">
                        <span class="truncate max-w-[150px] sm:max-w-none">{{ $user->name }}</span>
                        <span class="text-lg sm:text-xl animate-wave">👋</span>
                    </h1>
                    <p class="text-xs sm:text-sm opacity-90 flex items-center justify-center gap-1 bg-white/10 backdrop-blur-sm px-2 py-1 sm:px-3 sm:py-1.5 rounded-full inline-flex max-w-full">
                        <span class="text-xs">✉️</span> 
                        <span class="truncate max-w-[150px] sm:max-w-none">{{ $user->email }}</span>
                    </p>
                </div>
                
                <div class="flex flex-wrap gap-1.5 sm:gap-2 items-center justify-center">
                    <div class="inline-flex items-center gap-1 bg-white/20 backdrop-blur-md px-2 py-1 sm:px-3 sm:py-1.5 rounded-full text-xs shadow border-1.5 border-white/30 hover:bg-white/30 transition-all transform hover:scale-105">
                        <span class="text-sm sm:text-base">{{ $user->role == 'santri_putra' ? '👨‍🎓' : '👩‍🎓' }}</span>
                        <span class="font-bold">{{ $user->role == 'santri_putra' ? 'Santri Putra' : 'Santri Putri' }}</span>
                    </div>
                    @if($user->class_id)
                        <div class="inline-flex items-center gap-1 bg-gradient-to-r from-yellow-400 to-orange-400 px-2 py-1 sm:px-3 sm:py-1.5 rounded-full text-xs shadow border-1.5 border-white hover:from-yellow-500 hover:to-orange-500 transition-all transform hover:scale-105">
                            <span class="text-sm sm:text-base">📚</span>
                            <span class="font-bold text-white">Kelas {{ $user->class_id }}</span>
                        </div>
                    @endif
                </div>

                <!-- Quick Stats Mini - Mobile Optimized -->
                <div class="flex gap-1.5 sm:gap-2 justify-center pt-1 sm:pt-1.5">
                    <div class="bg-white/15 backdrop-blur-sm px-2 py-1 sm:px-3 sm:py-1.5 rounded-lg border border-white/20 hover:bg-white/25 transition-all">
                        <div class="text-xs text-white/80">Bergabung</div>
                        <div class="text-xs font-bold">{{ Auth::user()->created_at ? Auth::user()->created_at->diffForHumans() : 'Baru saja' }}</div>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm px-2 py-1 sm:px-3 sm:py-1.5 rounded-lg border border-white/20 hover:bg-white/25 transition-all">
                        <div class="text-xs text-white/80">Terakhir Aktif</div>
                        <div class="text-xs font-bold">{{ Auth::user()->updated_at ? Auth::user()->updated_at->diffForHumans() : 'Sekarang' }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Level Badge - Ultra Enhanced - Mobile Optimized -->
            <div class="text-center bg-gradient-to-br from-white/15 to-white/5 backdrop-blur-lg rounded-xl sm:rounded-2xl p-3 sm:p-4 border-1.5 border-white/30 shadow-lg transform hover:scale-105 hover:rotate-3 transition-all duration-500 relative overflow-hidden group w-full max-w-[140px] sm:max-w-none">
                <!-- Sparkle Effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-500 animate-shimmer"></div>
                
                <div class="text-2xl sm:text-4xl mb-1 sm:mb-2 animate-bounce-slow relative">
                    @php
                        $levelEmoji = ['🌱', '📚', '⭐', '🏆', '👑'];
                        echo $levelEmoji[min($user->level - 1, 4)] ?? '🌱';
                    @endphp
                    <!-- Glow effect behind emoji -->
                    <div class="absolute inset-0 blur opacity-50 scale-150 bg-gradient-to-br from-yellow-400 to-orange-400"></div>
                </div>
                <div class="text-lg sm:text-xl font-extrabold drop-shadow mb-0.5">Level {{ $user->level }}</div>
                <div class="text-xs font-bold opacity-90 bg-white/20 px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full inline-block">
                    @php
                        $levelNames = ['Pemula', 'Pelajar', 'Mahir', 'Juara', 'Master'];
                        echo $levelNames[min($user->level - 1, 4)] ?? 'Pemula';
                    @endphp
                </div>
                
                <!-- Level Progress Ring -->
                <div class="mt-1.5 sm:mt-2">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto transform -rotate-90">
                        <circle cx="20" cy="20" r="16" stroke="rgba(255,255,255,0.2)" stroke-width="2.5" fill="none"/>
                        <circle cx="20" cy="20" r="16" stroke="white" stroke-width="2.5" fill="none" 
                                stroke-dasharray="100" stroke-dashoffset="25" 
                                class="transition-all duration-1000"
                                stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Grid - Ultra Enhanced with 3D Cards - Mobile Optimized -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-3 mb-3 sm:mb-4">
        
        <!-- Total XP Card -->
        <div class="group bg-gradient-to-br from-white to-amber-50 rounded-lg sm:rounded-xl shadow-md sm:shadow p-3 sm:p-4 text-center border-t-3 border-amber-400 hover:shadow-lg sm:hover:shadow transition-all duration-500 active:scale-95 cursor-pointer relative overflow-hidden transform hover:-translate-y-0.5 sm:hover:-translate-y-1">
            <!-- Animated Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-amber-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-30 animate-shimmer"></div>
            
            <div class="relative">
                <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 sm:mb-3 bg-gradient-to-br from-amber-400 to-orange-400 rounded-lg flex items-center justify-center shadow group-hover:scale-105 group-hover:rotate-12 transition-all duration-500 relative">
                    <span class="text-xl sm:text-2xl animate-pulse-slow">⚡</span>
                    <!-- Glow effect -->
                    <div class="absolute inset-0 bg-amber-400 rounded-lg blur opacity-50 group-hover:opacity-75 transition-opacity"></div>
                </div>
                <div class="text-lg sm:text-2xl font-extrabold bg-gradient-to-r from-amber-600 via-orange-500 to-amber-600 bg-clip-text text-transparent mb-0.5 sm:mb-1 group-hover:scale-105 transition-transform">
                    {{ number_format($user->experience_points) }}
                </div>
                <div class="text-xs font-bold text-gray-700 uppercase tracking-wide">Total XP</div>
                <div class="mt-1.5 sm:mt-2 text-xs font-semibold text-amber-600 bg-amber-100 py-0.5 px-1.5 sm:px-2 rounded-full inline-block">
                    🎯 Terus kumpulkan!
                </div>
            </div>
        </div>

        <!-- Games Completed Card -->
        <div class="group bg-gradient-to-br from-white to-blue-50 rounded-lg sm:rounded-xl shadow-md sm:shadow p-3 sm:p-4 text-center border-t-3 border-blue-400 hover:shadow-lg sm:hover:shadow transition-all duration-500 active:scale-95 cursor-pointer relative overflow-hidden transform hover:-translate-y-0.5 sm:hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-30 animate-shimmer"></div>
            
            <div class="relative">
                <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 sm:mb-3 bg-gradient-to-br from-blue-400 to-cyan-400 rounded-lg flex items-center justify-center shadow group-hover:scale-105 group-hover:rotate-12 transition-all duration-500 relative">
                    <span class="text-xl sm:text-2xl">🎮</span>
                    <div class="absolute inset-0 bg-blue-400 rounded-lg blur opacity-50 group-hover:opacity-75 transition-opacity"></div>
                </div>
                <div class="text-lg sm:text-2xl font-extrabold bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-600 bg-clip-text text-transparent mb-0.5 sm:mb-1 group-hover:scale-105 transition-transform">
                    {{ $user->total_games_completed }}
                </div>
                <div class="text-xs font-bold text-gray-700 uppercase tracking-wide">Games Selesai</div>
                <div class="mt-1.5 sm:mt-2 text-xs font-semibold text-blue-600 bg-blue-100 py-0.5 px-1.5 sm:px-2 rounded-full inline-block">
                    🚀 Lanjutkan!
                </div>
            </div>
        </div>

        <!-- Current Badge Card -->
        <div class="group bg-gradient-to-br from-white to-purple-50 rounded-lg sm:rounded-xl shadow-md sm:shadow p-3 sm:p-4 text-center border-t-3 border-purple-400 hover:shadow-lg sm:hover:shadow transition-all duration-500 active:scale-95 cursor-pointer relative overflow-hidden transform hover:-translate-y-0.5 sm:hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-30 animate-shimmer"></div>
            
            <div class="relative">
                <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-2 sm:mb-3 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center shadow group-hover:scale-105 group-hover:rotate-12 transition-all duration-500 relative">
                    <span class="text-xl sm:text-2xl group-hover:animate-spin-slow">
                        @if($user->current_badge == 'bronze') 🥉
                        @elseif($user->current_badge == 'silver') 🥈
                        @elseif($user->current_badge == 'gold') 🥇
                        @elseif($user->current_badge == 'diamond') 💎
                        @else 🎖️
                        @endif
                    </span>
                    <div class="absolute inset-0 bg-purple-400 rounded-lg blur opacity-50 group-hover:opacity-75 transition-opacity"></div>
                </div>
                <div class="text-base sm:text-xl font-extrabold bg-gradient-to-r from-purple-600 via-pink-500 to-purple-600 bg-clip-text text-transparent mb-0.5 sm:mb-1 group-hover:scale-105 transition-transform">
                    {{ ucfirst($user->current_badge ?? 'None') }}
                </div>
                <div class="text-xs font-bold text-gray-700 uppercase tracking-wide">Badge Saat Ini</div>
                <div class="mt-1.5 sm:mt-2 text-xs font-semibold text-purple-600 bg-purple-100 py-0.5 px-1.5 sm:px-2 rounded-full inline-block">
                    👑 Raih tertinggi!
                </div>
            </div>
        </div>
    </div>

    <!-- Progress to Next Level - Ultra Enhanced - Mobile Optimized -->
    <div class="bg-gradient-to-br from-white to-emerald-50 rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl p-3 sm:p-6 mb-3 sm:mb-4 border-l-3 border-emerald-500 hover:shadow-xl sm:hover:shadow transition-all duration-500 relative overflow-hidden group">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 right-0 w-24 h-24 sm:w-48 sm:h-48 bg-gradient-to-br from-emerald-200 to-transparent rounded-full -mr-12 sm:-mr-24 -mt-12 sm:-mt-24 opacity-30 group-hover:opacity-50 transition-opacity"></div>
        <div class="absolute bottom-0 left-0 w-20 h-20 sm:w-36 sm:h-36 bg-gradient-to-tr from-teal-200 to-transparent rounded-full -ml-10 sm:-ml-18 -mb-10 sm:-mb-18 opacity-30 group-hover:opacity-50 transition-opacity"></div>
        
        <h2 class="text-lg sm:text-xl font-extrabold mb-3 sm:mb-4 text-gray-800 flex items-center gap-1.5 sm:gap-2 relative">
            <span class="text-xl sm:text-2xl animate-bounce-slow">📈</span> 
            <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                Progress ke Level Berikutnya
            </span>
        </h2>
        
        @php
            $currentXP = $user->experience_points;
            $levelThresholds = [0, 100, 300, 600, 1000];
            $currentLevel = $user->level;
            
            if ($currentLevel < 5) {
                $currentLevelXP = $levelThresholds[$currentLevel - 1];
                $nextLevelXP = $levelThresholds[$currentLevel];
                $xpInLevel = $currentXP - $currentLevelXP;
                $xpNeeded = $nextLevelXP - $currentLevelXP;
                $percentage = ($xpInLevel / $xpNeeded) * 100;
            } else {
                $percentage = 100;
                $xpInLevel = $currentXP;
                $xpNeeded = $currentXP;
            }
        @endphp

        @if($currentLevel < 5)
            <div class="relative">
                <div class="flex justify-between text-xs font-bold text-gray-700 mb-1.5 sm:mb-2">
                    <span class="flex items-center gap-1 bg-emerald-100 px-1.5 py-0.5 sm:px-3 sm:py-1 rounded-full">
                        <span class="text-xs">🎯</span> Level {{ $currentLevel }}
                    </span>
                    <span class="flex items-center gap-1 bg-teal-100 px-1.5 py-0.5 sm:px-3 sm:py-1 rounded-full">
                        Level {{ $currentLevel + 1 }} <span class="text-xs">🎯</span>
                    </span>
                </div>
                
                <!-- Enhanced Progress Bar with Animation -->
                <div class="relative w-full bg-gray-200 rounded-full h-6 sm:h-8 overflow-hidden shadow-inner">
                    <!-- Shimmer overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-40 animate-shimmer"></div>
                    
                    <!-- Main progress bar -->
                    <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-500 h-6 sm:h-8 rounded-full flex items-center justify-center text-white text-xs font-extrabold transition-all duration-1000 shadow relative overflow-hidden group/bar"
                         style="width: {{ $percentage }}%">
                        <!-- Animated gradient -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-shimmer"></div>
                        <!-- Pulse effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-400 animate-pulse-slow opacity-50"></div>
                        
                        <span class="relative z-10 flex items-center gap-0.5 drop-shadow">
                            <span class="text-xs sm:text-sm">🔥</span>
                            {{ number_format($percentage, 1) }}%
                        </span>
                    </div>
                </div>
                
                <!-- Progress Info -->
                <div class="mt-2 sm:mt-3 flex flex-col sm:flex-row gap-1.5 sm:gap-0 items-stretch sm:items-center justify-between">
                    <div class="bg-gradient-to-r from-emerald-100 to-teal-100 rounded-lg sm:rounded py-1.5 px-2 sm:py-2 sm:px-3 flex-1 sm:mr-2">
                        <div class="text-xs text-gray-600 font-semibold">Progress Saat Ini</div>
                        <div class="text-sm font-extrabold text-emerald-700">
                            {{ $xpInLevel }} / {{ $xpNeeded }} XP
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-orange-100 to-amber-100 rounded-lg sm:rounded py-1.5 px-2 sm:py-2 sm:px-3 flex-1">
                        <div class="text-xs text-gray-600 font-semibold">XP Dibutuhkan</div>
                        <div class="text-sm font-extrabold text-orange-600 flex items-center gap-0.5">
                            <span class="text-xs">🎯</span>
                            {{ $nextLevelXP - $currentXP }} XP
                        </div>
                    </div>
                </div>

                <!-- Motivational Message -->
                <div class="mt-2 sm:mt-3 text-center">
                    <div class="inline-flex items-center gap-1 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold py-1 px-3 sm:py-1.5 sm:px-4 rounded-full shadow animate-pulse-slow text-xs">
                        <span>💪</span>
                        <span>Kamu hampir sampai! Terus semangat!</span>
                        <span>✨</span>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-4 sm:py-6 bg-gradient-to-br from-amber-100 via-yellow-100 to-orange-100 rounded-lg sm:rounded-xl shadow-inner relative overflow-hidden">
                <!-- Celebration Confetti Effect -->
                <div class="absolute inset-0">
                    <div class="absolute top-3 sm:top-4 left-3 sm:left-4 text-lg sm:text-xl animate-bounce" style="animation-delay: 0s;">🎉</div>
                    <div class="absolute top-4 sm:top-6 right-4 sm:right-6 text-base sm:text-lg animate-bounce" style="animation-delay: 0.2s;">⭐</div>
                    <div class="absolute bottom-3 sm:bottom-4 left-4 sm:left-6 text-base sm:text-lg animate-bounce" style="animation-delay: 0.4s;">🌟</div>
                    <div class="absolute bottom-4 sm:bottom-6 right-3 sm:right-4 text-lg sm:text-xl animate-bounce" style="animation-delay: 0.6s;">✨</div>
                </div>
                
                <div class="relative">
                    <div class="text-4xl sm:text-5xl mb-2 sm:mb-3 animate-bounce-slow">👑</div>
                    <div class="text-lg sm:text-xl font-extrabold bg-gradient-to-r from-amber-600 via-yellow-600 to-orange-600 bg-clip-text text-transparent mb-1.5 sm:mb-2">
                        Level Maksimal Tercapai!
                    </div>
                    <div class="text-sm text-gray-700 font-bold mb-2 sm:mb-3">
                        Selamat! Kamu adalah seorang Master! 🏆
                    </div>
                    <div class="inline-flex items-center gap-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold py-1.5 px-4 sm:py-2 sm:px-5 rounded-full shadow text-xs">
                        <span>🌟</span>
                        <span>Terus bermain untuk mempertahankan status!</span>
                        <span>🌟</span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Achievements & Badges - Ultra Enhanced - Mobile Optimized -->
    <div class="bg-gradient-to-br from-white to-amber-50 rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl p-3 sm:p-6 mb-3 sm:mb-4 border-l-3 border-amber-500 hover:shadow-xl sm:hover:shadow transition-all duration-500 relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 text-4xl sm:text-6xl opacity-5 animate-pulse">🏆</div>
        
        <h2 class="text-lg sm:text-xl font-extrabold mb-3 sm:mb-4 text-gray-800 flex items-center gap-1.5 sm:gap-2 relative">
            <span class="text-xl sm:text-2xl animate-bounce-slow">🏆</span> 
            <span class="bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                Pencapaian & Badge
            </span>
        </h2>
        
        <div class="grid grid-cols-2 gap-2 sm:gap-3">
            
            <!-- Bronze Badge - Enhanced - Mobile Optimized -->
            <div class="text-center p-2 sm:p-3 rounded-lg sm:rounded-xl transform hover:scale-105 hover:-rotate-3 transition-all duration-500 active:scale-95 cursor-pointer relative overflow-hidden shadow
                        {{ $user->total_games_completed >= 10 ? 'bg-gradient-to-br from-orange-200 via-orange-100 to-orange-50 border-3 border-orange-400' : 'bg-gradient-to-br from-gray-200 to-gray-100 border-3 border-gray-300 opacity-50' }}">
                @if($user->total_games_completed >= 10)
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-40 animate-shimmer"></div>
                    <div class="absolute -top-0.5 -right-0.5 sm:-top-1 sm:-right-1 bg-green-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full shadow animate-pulse">
                        ✓
                    </div>
                @else
                    <div class="absolute inset-0 bg-gray-900 opacity-20"></div>
                @endif
                
                <div class="relative">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-1.5 sm:mb-2 flex items-center justify-center bg-white rounded-full shadow relative
                                {{ $user->total_games_completed >= 10 ? 'animate-bounce-slow' : '' }}">
                        <span class="text-2xl sm:text-3xl">🥉</span>
                        @if($user->total_games_completed >= 10)
                            <div class="absolute inset-0 bg-orange-400 rounded-full blur opacity-50 animate-pulse"></div>
                        @endif
                    </div>
                    <div class="font-extrabold text-base sm:text-lg text-gray-800 mb-0.5">Bronze</div>
                    <div class="text-xs text-gray-700 mb-0.5 font-bold bg-white/50 py-0.5 px-1.5 rounded-full inline-block">
                        🎮 10 Games
                    </div>
                    @if($user->total_games_completed >= 10)
                        <div class="text-xs font-extrabold text-green-700 bg-green-100 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded border border-green-300 shadow-inner">
                            ✓ Terbuka!
                        </div>
                    @else
                        <div class="text-xs text-gray-600 font-bold bg-white/70 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded">
                            🔒 {{ 10 - $user->total_games_completed }} lagi
                        </div>
                    @endif
                </div>
            </div>

            <!-- Silver Badge - Enhanced - Mobile Optimized -->
            <div class="text-center p-2 sm:p-3 rounded-lg sm:rounded-xl transform hover:scale-105 hover:rotate-3 transition-all duration-500 active:scale-95 cursor-pointer relative overflow-hidden shadow
                        {{ $user->total_games_completed >= 25 ? 'bg-gradient-to-br from-gray-300 via-gray-200 to-gray-100 border-3 border-gray-500' : 'bg-gradient-to-br from-gray-200 to-gray-100 border-3 border-gray-300 opacity-50' }}">
                @if($user->total_games_completed >= 25)
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-50 animate-shimmer"></div>
                    <div class="absolute -top-0.5 -right-0.5 sm:-top-1 sm:-right-1 bg-green-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full shadow animate-pulse">
                        ✓
                    </div>
                @else
                    <div class="absolute inset-0 bg-gray-900 opacity-20"></div>
                @endif
                
                <div class="relative">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-1.5 sm:mb-2 flex items-center justify-center bg-white rounded-full shadow relative
                                {{ $user->total_games_completed >= 25 ? 'animate-bounce-slow' : '' }}">
                        <span class="text-2xl sm:text-3xl">🥈</span>
                        @if($user->total_games_completed >= 25)
                            <div class="absolute inset-0 bg-gray-500 rounded-full blur opacity-50 animate-pulse"></div>
                        @endif
                    </div>
                    <div class="font-extrabold text-base sm:text-lg text-gray-800 mb-0.5">Silver</div>
                    <div class="text-xs text-gray-700 mb-0.5 font-bold bg-white/50 py-0.5 px-1.5 rounded-full inline-block">
                        🎮 25 Games
                    </div>
                    @if($user->total_games_completed >= 25)
                        <div class="text-xs font-extrabold text-green-700 bg-green-100 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded border border-green-300 shadow-inner">
                            ✓ Terbuka!
                        </div>
                    @else
                        <div class="text-xs text-gray-600 font-bold bg-white/70 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded">
                            🔒 {{ 25 - $user->total_games_completed }} lagi
                        </div>
                    @endif
                </div>
            </div>

            <!-- Gold Badge - Enhanced - Mobile Optimized -->
            <div class="text-center p-2 sm:p-3 rounded-lg sm:rounded-xl transform hover:scale-105 hover:-rotate-3 transition-all duration-500 active:scale-95 cursor-pointer relative overflow-hidden shadow
                        {{ $user->total_games_completed >= 50 ? 'bg-gradient-to-br from-yellow-300 via-yellow-200 to-yellow-100 border-3 border-yellow-500' : 'bg-gradient-to-br from-gray-200 to-gray-100 border-3 border-gray-300 opacity-50' }}">
                @if($user->total_games_completed >= 50)
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-40 animate-shimmer"></div>
                    <div class="absolute -top-0.5 -right-0.5 sm:-top-1 sm:-right-1 bg-green-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full shadow animate-pulse">
                        ✓
                    </div>
                @else
                    <div class="absolute inset-0 bg-gray-900 opacity-20"></div>
                @endif
                
                <div class="relative">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-1.5 sm:mb-2 flex items-center justify-center bg-white rounded-full shadow relative
                                {{ $user->total_games_completed >= 50 ? 'animate-bounce-slow' : '' }}">
                        <span class="text-2xl sm:text-3xl">🥇</span>
                        @if($user->total_games_completed >= 50)
                            <div class="absolute inset-0 bg-yellow-500 rounded-full blur opacity-50 animate-pulse"></div>
                        @endif
                    </div>
                    <div class="font-extrabold text-base sm:text-lg text-gray-800 mb-0.5">Gold</div>
                    <div class="text-xs text-gray-700 mb-0.5 font-bold bg-white/50 py-0.5 px-1.5 rounded-full inline-block">
                        🎮 50 Games
                    </div>
                    @if($user->total_games_completed >= 50)
                        <div class="text-xs font-extrabold text-green-700 bg-green-100 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded border border-green-300 shadow-inner">
                            ✓ Terbuka!
                        </div>
                    @else
                        <div class="text-xs text-gray-600 font-bold bg-white/70 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded">
                            🔒 {{ 50 - $user->total_games_completed }} lagi
                        </div>
                    @endif
                </div>
            </div>

            <!-- Diamond Badge - Enhanced - Mobile Optimized -->
            <div class="text-center p-2 sm:p-3 rounded-lg sm:rounded-xl transform hover:scale-105 hover:rotate-3 transition-all duration-500 active:scale-95 cursor-pointer relative overflow-hidden shadow
                        {{ $user->total_games_completed >= 100 ? 'bg-gradient-to-br from-blue-300 via-cyan-200 to-blue-100 border-3 border-blue-500' : 'bg-gradient-to-br from-gray-200 to-gray-100 border-3 border-gray-300 opacity-50' }}">
                @if($user->total_games_completed >= 100)
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-40 animate-shimmer"></div>
                    <div class="absolute -top-0.5 -right-0.5 sm:-top-1 sm:-right-1 bg-green-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full shadow animate-pulse">
                        ✓
                    </div>
                @else
                    <div class="absolute inset-0 bg-gray-900 opacity-20"></div>
                @endif
                
                <div class="relative">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-1.5 sm:mb-2 flex items-center justify-center bg-white rounded-full shadow relative
                                {{ $user->total_games_completed >= 100 ? 'animate-bounce-slow' : '' }}">
                        <span class="text-2xl sm:text-3xl {{ $user->total_games_completed >= 100 ? 'animate-spin-slow' : '' }}">💎</span>
                        @if($user->total_games_completed >= 100)
                            <div class="absolute inset-0 bg-blue-500 rounded-full blur opacity-50 animate-pulse"></div>
                        @endif
                    </div>
                    <div class="font-extrabold text-base sm:text-lg text-gray-800 mb-0.5">Diamond</div>
                    <div class="text-xs text-gray-700 mb-0.5 font-bold bg-white/50 py-0.5 px-1.5 rounded-full inline-block">
                        🎮 100 Games
                    </div>
                    @if($user->total_games_completed >= 100)
                        <div class="text-xs font-extrabold text-green-700 bg-green-100 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded border border-green-300 shadow-inner">
                            ✓ Terbuka!
                        </div>
                    @else
                        <div class="text-xs text-gray-600 font-bold bg-white/70 py-0.5 px-1.5 sm:py-1 sm:px-2 rounded">
                            🔒 {{ 100 - $user->total_games_completed }} lagi
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Achievement Progress Summary -->
        <div class="mt-3 sm:mt-4 p-2 sm:p-3 bg-gradient-to-r from-amber-100 to-orange-100 rounded-lg sm:rounded-xl border border-amber-300">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold text-gray-700">Total Badge Terkumpul</div>
                    <div class="text-xl sm:text-2xl font-extrabold text-amber-700">
                        @php
                            $badgeCount = 0;
                            if ($user->total_games_completed >= 10) $badgeCount++;
                            if ($user->total_games_completed >= 25) $badgeCount++;
                            if ($user->total_games_completed >= 50) $badgeCount++;
                            if ($user->total_games_completed >= 100) $badgeCount++;
                        @endphp
                        {{ $badgeCount }} / 4
                    </div>
                </div>
                <div class="text-3xl sm:text-4xl animate-bounce-slow">
                    @if($user->total_games_completed >= 100) 🎉
                    @elseif($user->total_games_completed >= 50) 🌟
                    @elseif($user->total_games_completed >= 25) ⭐
                    @elseif($user->total_games_completed >= 10) ✨
                    @else 🎯
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity - Ultra Enhanced - Mobile Optimized -->
    <div class="bg-gradient-to-br from-white to-teal-50 rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl p-3 sm:p-6 mb-3 sm:mb-4 border-l-3 border-teal-500 hover:shadow-xl sm:hover:shadow transition-all duration-500">
        <h2 class="text-lg sm:text-xl font-extrabold mb-3 sm:mb-4 text-gray-800 flex items-center gap-1.5 sm:gap-2">
            <span class="text-xl sm:text-2xl animate-bounce-slow">📅</span> 
            <span class="bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                Aktivitas Terakhir
            </span>
        </h2>
        
        @if($recentScores->count() > 0)
            <div class="space-y-2 sm:space-y-3">
                @foreach($recentScores as $index => $score)
                    <div class="group flex items-center justify-between p-2.5 sm:p-4 bg-gradient-to-r from-white to-teal-50 border border-teal-100 rounded-lg sm:rounded-xl hover:shadow hover:border-teal-300 transition-all duration-300 active:scale-[0.98] cursor-pointer relative overflow-hidden transform hover:-translate-y-0.5"
                         style="animation: slideIn 0.5s ease-out {{ $index * 0.1 }}s both;">
                        <!-- Hover gradient overlay -->
                        <div class="absolute inset-0 bg-gradient-to-r from-teal-100 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0 relative z-10">
                            <!-- Icon with badge -->
                            <div class="relative flex-shrink-0">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center bg-gradient-to-br from-teal-400 to-cyan-400 rounded-lg group-hover:scale-105 group-hover:rotate-12 transition-all duration-300 shadow">
                                    <span class="text-base sm:text-lg">
                                        @if($score->game->type == 'tebak_gambar') 🖼️
                                        @elseif($score->game->type == 'kosakata_tempat') 🏫
                                        @elseif($score->game->type == 'pilihan_ganda') ✅
                                        @else 💬
                                        @endif
                                    </span>
                                </div>
                                <!-- Rank badge -->
                                <div class="absolute -top-0.5 -right-0.5 sm:-top-1 sm:-right-1 w-4 h-4 sm:w-5 sm:h-5 bg-gradient-to-br from-amber-400 to-orange-400 rounded-full flex items-center justify-center text-xs font-bold text-white shadow">
                                    {{ $index + 1 }}
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-gray-800 text-xs sm:text-sm truncate group-hover:text-teal-700 transition-colors mb-0.5">
                                    {{ $score->game->title }}
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-0.5 sm:gap-2 text-xs text-gray-600">
                                    <span class="flex items-center gap-0.5 bg-gray-100 px-1.5 py-0.5 rounded-full">
                                        <span class="text-xs">⏰</span> {{ $score->completed_at->diffForHumans() }}
                                    </span>
                                    <span class="flex items-center gap-0.5 bg-blue-100 px-1.5 py-0.5 rounded-full text-blue-700 font-semibold">
                                        <span class="text-xs">⚡</span> +{{ $score->experience_points ?? 0 }} XP
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-right flex-shrink-0 ml-1.5 sm:ml-3 relative z-10">
                            <div class="text-base sm:text-lg font-extrabold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent mb-0.5">
                                {{ $score->score }}%
                            </div>
                            <div class="text-xs font-bold text-gray-600 bg-gray-100 py-0.5 px-1.5 sm:px-2 rounded-full">
                                {{ $score->correct_answers }}/{{ $score->total_questions }} ✓
                            </div>
                            @if($score->score >= 80)
                                <div class="mt-0.5 text-xs font-bold text-green-600">🏆 Excellent!</div>
                            @elseif($score->score >= 60)
                                <div class="mt-0.5 text-xs font-bold text-blue-600">👍 Good!</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-3 sm:mt-4">
                <a href="{{ route('santri.scores') }}" 
                   class="inline-flex items-center gap-1.5 sm:gap-2 text-teal-700 hover:text-teal-800 font-bold text-xs sm:text-sm px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg hover:bg-teal-100 transition-all duration-300 active:scale-95 border-2 border-teal-300 hover:border-teal-400 shadow hover:shadow-md transform hover:-translate-y-0.5">
                    <span class="text-base sm:text-lg">📊</span> 
                    <span>Lihat Semua Nilai</span>
                    <span class="text-base sm:text-lg">→</span>
                </a>
            </div>
        @else
            <div class="text-center py-8 sm:py-10 relative">
                <div class="absolute inset-0 bg-gradient-to-br from-teal-100 via-cyan-50 to-emerald-100 rounded-lg sm:rounded-xl opacity-50"></div>
                <div class="relative">
                    <div class="text-5xl sm:text-6xl mb-3 sm:mb-4 animate-bounce-slow">🎮</div>
                    <h3 class="text-lg sm:text-xl font-extrabold text-gray-800 mb-1.5 sm:mb-2">Belum Ada Aktivitas</h3>
                    <p class="text-gray-600 mb-4 sm:mb-5 text-sm">Mulai petualangan belajarmu sekarang!</p>
                    <a href="{{ route('santri.games.index') }}"
                       class="inline-flex items-center gap-1.5 sm:gap-2 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 text-white font-extrabold px-5 py-2.5 sm:px-6 sm:py-3 rounded-lg hover:shadow hover:scale-105 transition-all duration-300 active:scale-95 shadow text-sm">
                        <span class="text-base sm:text-lg">🎮</span> 
                        <span>Mulai Bermain Sekarang!</span>
                        <span class="text-base sm:text-lg">✨</span>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Motivational Quote - Ultra Enhanced Islamic Theme - Mobile Optimized -->
    <div class="bg-gradient-to-br from-teal-100 via-emerald-100 to-cyan-100 rounded-xl sm:rounded-2xl shadow-lg sm:shadow-xl p-4 sm:p-6 text-center border-3 border-emerald-300 hover:shadow-xl sm:hover:shadow transition-all duration-500 relative overflow-hidden group">
        <!-- Decorative Islamic Corners - Enhanced - Mobile Optimized -->
        <div class="absolute top-0 left-0 w-12 h-12 sm:w-20 sm:h-20 border-t-3 sm:border-t-4 border-l-3 sm:border-l-4 border-emerald-400 rounded-tl-lg sm:rounded-tl-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
        <div class="absolute top-0 right-0 w-12 h-12 sm:w-20 sm:h-20 border-t-3 sm:border-t-4 border-r-3 sm:border-r-4 border-emerald-400 rounded-tr-lg sm:rounded-tr-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
        <div class="absolute bottom-0 left-0 w-12 h-12 sm:w-20 sm:h-20 border-b-3 sm:border-b-4 border-l-3 sm:border-l-4 border-emerald-400 rounded-bl-lg sm:rounded-bl-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
        <div class="absolute bottom-0 right-0 w-12 h-12 sm:w-20 sm:h-20 border-b-3 sm:border-b-4 border-r-3 sm:border-r-4 border-emerald-400 rounded-br-lg sm:rounded-br-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
        
        <!-- Islamic Pattern Background -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0 bg-repeat" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9InBhdHRlcm4iIHg9IjAiIHk9IjAiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTTMwIDE1TDQwIDI1TDMwIDM1TDIwIDI1WiIgZmlsbD0iY3VycmVudENvbG9yIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');"></div>
        </div>
        
        <div class="relative">
            <div class="mb-3 sm:mb-4 animate-pulse-slow">
                <div class="inline-block p-3 sm:p-4 bg-gradient-to-br from-emerald-200 to-teal-200 rounded-full shadow">
                    <span class="text-3xl sm:text-4xl drop-shadow">📖</span>
                </div>
            </div>
            
            <!-- Arabic Text with Enhanced Styling -->
            <div class="mb-3 sm:mb-4 bg-white/70 backdrop-blur-md rounded-lg sm:rounded-xl py-2 px-3 sm:py-3 sm:px-5 inline-block shadow border-2 border-emerald-300">
                <p class="text-xl sm:text-2xl font-extrabold bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-800 bg-clip-text text-transparent" style="font-family: 'Traditional Arabic', 'Arabic Typesetting', 'Amiri', serif;">
                    من جدّ وجد
                </p>
            </div>
            
            <!-- Indonesian Translation -->
            <p class="text-base sm:text-lg text-gray-800 font-bold mb-3 sm:mb-4 drop-shadow">
                "Barangsiapa bersungguh-sungguh, pasti berhasil."
            </p>
            
            <!-- Motivational Badge -->
            <div class="inline-flex items-center gap-1.5 sm:gap-2 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-full border-2 sm:border-3 border-white shadow transform hover:scale-105 transition-all duration-300">
                <span class="text-lg sm:text-xl animate-bounce-slow">💪</span>
                <p class="text-xs sm:text-sm font-extrabold">
                    Terus semangat dalam belajar!
                </p>
                <span class="text-lg sm:text-xl animate-pulse">✨</span>
            </div>

            <!-- Additional Quote -->
            <div class="mt-3 sm:mt-4 text-xs text-gray-700 italic font-semibold">
                "Ilmu adalah cahaya yang menerangi jalan kehidupan" 🌟
            </div>
        </div>
    </div>

</div>

<style>
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) translateX(0px);
        }
        25% {
            transform: translateY(-10px) translateX(5px);
        }
        50% {
            transform: translateY(-8px) translateX(-5px);
        }
        75% {
            transform: translateY(-12px) translateX(3px);
        }
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }

    @keyframes shimmer-slow {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(200%);
        }
    }

    @keyframes wave {
        0%, 100% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(15deg);
        }
        75% {
            transform: rotate(-15deg);
        }
    }

    @keyframes bounce-subtle {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-3px);
        }
    }

    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-8px);
        }
    }

    @keyframes pulse-slow {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-15px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-float {
        animation: float 4s ease-in-out infinite;
    }

    .animate-shimmer {
        animation: shimmer 2s infinite;
    }

    .animate-shimmer-slow {
        animation: shimmer-slow 6s infinite;
    }

    .animate-wave {
        animation: wave 1.5s ease-in-out infinite;
    }

    .animate-bounce-subtle {
        animation: bounce-subtle 1.5s ease-in-out infinite;
    }

    .animate-bounce-slow {
        animation: bounce-slow 2s ease-in-out infinite;
    }

    .animate-pulse-slow {
        animation: pulse-slow 2s ease-in-out infinite;
    }

    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }

    .shadow-glow {
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: linear-gradient(to bottom, #f0fdfa, #ecfdf5);
        border-radius: 8px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #14b8a6, #10b981);
        border-radius: 8px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #0f766e, #047857);
    }

    /* Border gradient animation */
    @keyframes border-gradient {
        0% {
            border-color: #10b981;
        }
        33% {
            border-color: #14b8a6;
        }
        66% {
            border-color: #06b6d4;
        }
        100% {
            border-color: #10b981;
        }
    }

    .animate-border-gradient {
        animation: border-gradient 2s ease infinite;
    }

    /* Glow pulse effect */
    @keyframes glow-pulse {
        0%, 100% {
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.3);
        }
        50% {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
        }
    }

    .animate-glow-pulse {
        animation: glow-pulse 1.5s ease-in-out infinite;
    }

    /* Smooth transitions */
    * {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Custom focus styles for accessibility */
    *:focus-visible {
        outline: 2px solid #10b981;
        outline-offset: 2px;
        border-radius: 0.25rem;
    }

    /* High contrast mode */
    @media (prefers-contrast: high) {
        .shadow-glow,
        .animate-glow-pulse {
            box-shadow: none;
        }
    }

    /* Loading skeleton animation */
    @keyframes skeleton-loading {
        0% {
            background-position: -200px 0;
        }
        100% {
            background-position: calc(200px + 100%) 0;
        }
    }

    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 0px, #e0e0e0 40px, #f0f0f0 80px);
        background-size: 200px 100%;
        animation: skeleton-loading 1.5s infinite;
    }
</style>

@endsection