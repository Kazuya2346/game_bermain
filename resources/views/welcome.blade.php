<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TPQ Arabic Learning') }} - Belajar Bahasa Arab Jadi Mudah</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-arabic { font-family: 'Amiri', serif; }
        html { scroll-behavior: smooth; }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient-bg {
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-15px) rotate(2deg); }
            50% { transform: translateY(-25px) rotate(0deg); }
            75% { transform: translateY(-15px) rotate(-2deg); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
        
        @keyframes pulseScale {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .animate-pulse-scale { animation: pulseScale 2s ease-in-out infinite; }
        
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        .animate-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }
        
        @keyframes bounceSmooth {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-smooth { animation: bounceSmooth 2s ease-in-out infinite; }
        
        @keyframes rotateSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-rotate-slow { animation: rotateSlow 20s linear infinite; }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 min-h-screen overflow-x-hidden">
    
    <!-- Background Decorations -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute top-40 right-20 w-96 h-96 bg-teal-300/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-pink-300/20 rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>
    </div>
    
    <!-- Navigation -->
    <nav x-data="{ open: false, scrolled: false }" 
         @scroll.window="scrolled = window.pageYOffset > 50"
         :class="scrolled ? 'bg-white/95 shadow-lg' : 'bg-white/80'"
         class="fixed top-0 left-0 right-0 z-50 backdrop-blur-md transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-18">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-2xl">🕌</span>
                    </div>
                    <span class="text-lg sm:text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                        TPQ Arabic
                    </span>
                </a>
                
                @if (Route::has('login'))
                <div class="hidden sm:flex items-center space-x-3">
                    <a href="#features" class="px-4 py-2 text-gray-700 hover:text-emerald-600 font-medium transition-colors rounded-lg hover:bg-emerald-50">Fitur</a>
                    <a href="#games" class="px-4 py-2 text-gray-700 hover:text-emerald-600 font-medium transition-colors rounded-lg hover:bg-emerald-50">Games</a>
                    
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 text-gray-700 hover:text-emerald-600 font-medium transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 text-gray-700 hover:text-emerald-600 font-medium transition-colors">Login</a>
                        
                        @if (Route::has('register.santri'))
                        <a href="{{ route('register.santri') }}" class="px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all active:scale-95">
                            Daftar Sekarang
                        </a>
                        @endif
                    @endauth
                </div>
                @endif

                <button @click="open = !open" class="sm:hidden p-2 rounded-lg text-gray-600 hover:text-emerald-600 hover:bg-emerald-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        @if (Route::has('login'))
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:leave="transition ease-in duration-150"
             class="sm:hidden bg-white shadow-lg border-t border-gray-100">
            <div class="px-4 py-3 space-y-1">
                <a href="#features" class="block px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-lg font-medium">Fitur</a>
                <a href="#games" class="block px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-lg font-medium">Games</a>
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="block px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-lg font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-lg font-medium">Login</a>
                    
                    @if (Route::has('register.santri'))
                    <a href="{{ route('register.santri') }}" class="block px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-semibold text-center shadow-md">Daftar Sekarang</a>
                    @endif
                @endauth
            </div>
        </div>
        @endif
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-24 sm:pt-32 pb-16 sm:pb-20 px-4 sm:px-6 lg:px-8 z-10">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                
                <div class="space-y-6 sm:space-y-8" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-x-[-50px]">
                    
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full border-2 border-emerald-200 animate-pulse-scale">
                        <span class="text-2xl">🎮</span>
                        <span class="text-emerald-700 font-semibold text-sm">Belajar dengan Gamifikasi</span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight">
                        <span class="block bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent animate-gradient-bg">Belajar Bahasa Arab</span>
                        <span class="block text-gray-800 mt-2">Jadi Lebih Mudah!</span>
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-gray-600 leading-relaxed">
                        Platform pembelajaran bahasa Arab interaktif dengan sistem level, badge, dan games yang pasti menyenangkan. Ayokk bergabung !! 
                        <span class="inline-block text-2xl animate-bounce-smooth">🕌✨</span>
                    </p>
                    
                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                        <div class="flex items-center gap-3 p-3 bg-white/80 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center">
                                <span class="text-xl">🎯</span>
                            </div>
                            <span class="font-semibold text-gray-700 text-sm sm:text-base">Banyak Jenis Games</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-white/80 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-lg flex items-center justify-center">
                                <span class="text-xl">⭐</span>
                            </div>
                            <span class="font-semibold text-gray-700 text-sm sm:text-base">Sistem Level</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-white/80 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-lg flex items-center justify-center">
                                <span class="text-xl">📊</span>
                            </div>
                            <span class="font-semibold text-gray-700 text-sm sm:text-base">Track Progress</span>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-white/80 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-rose-500 rounded-lg flex items-center justify-center">
                                <span class="text-xl">🏆</span>
                            </div>
                            <span class="font-semibold text-gray-700 text-sm sm:text-base">Leaderboard</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        @guest
                            @if (Route::has('register.santri'))
                            <a href="{{ route('register.santri') }}" class="group px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-2xl font-bold text-base sm:text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <span>🎓 Daftar Santri Baru</span>
                                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                            @endif
                            
                            <a href="{{ route('login') }}" class="px-8 py-4 bg-white border-2 border-emerald-500 text-emerald-600 rounded-2xl font-bold text-base sm:text-lg shadow-lg hover:shadow-xl hover:bg-emerald-50 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <span>🔐 Login</span>
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="group px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-2xl font-bold text-base sm:text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all active:scale-95 flex items-center justify-center gap-3">
                                <span>Dashboard</span>
                                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @endguest
                    </div>
                </div>
                
                <div class="relative lg:ml-8" x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" x-show="show" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 translate-x-[50px]">
                    
                    <div class="relative z-10 bg-white rounded-3xl shadow-2xl p-6 sm:p-8 border-4 border-emerald-200 animate-float">
                        <div class="text-center space-y-6">
                            <div class="inline-block p-6 sm:p-8 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl shadow-xl relative overflow-hidden">
                                <div class="absolute inset-0 animate-shimmer"></div>
                                <span class="text-6xl sm:text-8xl relative z-10">📚</span>
                            </div>
                            
                            <h3 class="text-2xl sm:text-3xl font-bold text-gray-800">Mulai Belajar Sekarang!</h3>
                            
                            <p class="text-xl sm:text-2xl font-arabic text-emerald-600 font-bold">من جدّ وجد</p>
                            <p class="text-sm text-gray-600">"Siapa bersungguh-sungguh, pasti berhasil"</p>
                            
                            <div class="grid grid-cols-3 gap-3 sm:gap-4 pt-4">
                                <div class="bg-gradient-to-br from-green-100 to-emerald-200 rounded-2xl p-4 hover:scale-105 transition-transform">
                                    <div class="text-3xl font-bold text-green-700">4</div>
                                    <div class="text-xs sm:text-sm text-green-600 font-medium">Games</div>
                                </div>
                                <div class="bg-gradient-to-br from-blue-100 to-cyan-200 rounded-2xl p-4 hover:scale-105 transition-transform">
                                    <div class="text-3xl font-bold text-blue-700">5</div>
                                    <div class="text-xs sm:text-sm text-blue-600 font-medium">Levels</div>
                                </div>
                                <div class="bg-gradient-to-br from-yellow-100 to-amber-200 rounded-2xl p-4 hover:scale-105 transition-transform">
                                    <div class="text-3xl font-bold text-yellow-700">5</div>
                                    <div class="text-xs sm:text-sm text-yellow-600 font-medium">Badges</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute top-0 right-0 -mr-4 -mt-4 w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center shadow-xl animate-float" style="animation-delay: 0.5s; animation-duration: 3s;">
                        <span class="text-2xl sm:text-3xl">⭐</span>
                    </div>
                    <div class="absolute bottom-0 left-0 -ml-4 -mb-4 w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-pink-400 to-rose-500 rounded-full flex items-center justify-center shadow-xl animate-float" style="animation-delay: 1s; animation-duration: 3.5s;">
                        <span class="text-xl sm:text-2xl">🏆</span>
                    </div>
                    <div class="absolute top-1/2 left-0 -ml-6 sm:-ml-8 w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full flex items-center justify-center shadow-xl animate-float" style="animation-delay: 1.5s; animation-duration: 4s;">
                        <span class="text-lg sm:text-xl">💎</span>
                    </div>
                    
                    <div class="absolute -top-8 -right-8 w-24 h-24 opacity-20">
                        <div class="w-full h-full border-4 border-emerald-400 rounded-full animate-rotate-slow"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Games Section -->
    <section id="games" class="relative py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-white/50 z-10">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12" x-data="{ show: false }" x-intersect="show = true" x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-10">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                    🎮 <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">4 Games Seru</span> untuk Belajar
                </h2>
                <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">Pilih game favoritmu dan mulai petualangan belajar bahasa Arab!</p>
            </div>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Game 1 -->
                <div class="group bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl shadow-xl p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer"
                     x-data="{ show: false }" x-intersect="show = true" x-show="show" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-10">
                    <div class="text-center text-white">
                        <div class="w-16 h-16 mx-auto mb-4 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <span class="text-4xl">🖼️</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Tebak Gambar</h3>
                        <p class="text-sm opacity-90">Tebak kosakata dari gambar yang ditampilkan</p>
                    </div>
                </div>

                <!-- Game 2 -->
                <div class="group bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl shadow-xl p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer"
                     x-data="{ show: false }" x-intersect="show = true" x-show="show" x-transition:enter="transition ease-out duration-500 delay-100" x-transition:enter-start="opacity-0 translate-y-10">
                    <div class="text-center text-white">
                        <div class="w-16 h-16 mx-auto mb-4 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <span class="text-4xl">🏫</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Kosakata Tempat</h3>
                        <p class="text-sm opacity-90">Belajar kosakata di 30 tempat berbeda</p>
                    </div>
                </div>

                <!-- Game 3 -->
                <div class="group bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl shadow-xl p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer"
                     x-data="{ show: false }" x-intersect="show = true" x-show="show" x-transition:enter="transition ease-out duration-500 delay-200" x-transition:enter-start="opacity-0 translate-y-10">
                    <div class="text-center text-white">
                        <div class="w-16 h-16 mx-auto mb-4 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <span class="text-4xl">✅</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Pilihan Ganda</h3>
                        <p class="text-sm opacity-90">Lengkapi kalimat dengan jawaban tepat</p>
                    </div>
                </div>

                <!-- Game 4 -->
                <div class="group bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl shadow-xl p-6 hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer"
                     x-data="{ show: false }" x-intersect="show = true" x-show="show" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-10">
                    <div class="text-center text-white">
                        <div class="w-16 h-16 mx-auto mb-4 bg-white/20 rounded-2xl flex items-center justify-center group-hover:bg-white/30 transition-colors">
                            <span class="text-4xl">💬</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Percakapan</h3>
                        <p class="text-sm opacity-90">Praktik dialog di 20 situasi berbeda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative py-16 sm:py-20 px-4 sm:px-6 lg:px-8 z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-3xl shadow-2xl p-8 sm:p-12 animate-gradient-bg relative overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-4 right-4 text-6xl animate-float">🕌</div>
                    <div class="absolute bottom-4 left-4 text-5xl animate-float" style="animation-delay: 1s;">📚</div>
                    <div class="absolute top-1/2 left-1/4 text-4xl animate-float" style="animation-delay: 2s;">✨</div>
                </div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Siap Mulai Belajar?</h2>
                    <p class="text-lg sm:text-xl text-white/90 mb-8">
                        Bergabunglah dengan santri lainnya yang sudah belajar bahasa Arab dengan cara yang menyenangkan!
                    </p>
                    @guest
                        @if (Route::has('register.santri'))
                        <a href="{{ route('register.santri') }}" class="inline-block px-10 sm:px-12 py-4 sm:py-5 bg-white text-emerald-600 rounded-2xl font-bold text-base sm:text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all active:scale-95">
                            🚀 Ayok Daftar Sekarang!
                        </a>
                        @endif
                    @else
                        <a href="{{ url('/dashboard') }}" class="inline-block px-10 sm:px-12 py-4 sm:py-5 bg-white text-emerald-600 rounded-2xl font-bold text-base sm:text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all active:scale-95">
                            Ke Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8 z-10">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex items-center justify-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-2xl">🕌</span>
                </div>
                <span class="text-2xl font-bold">TPQ Arabic Learning</span>
            </div>
            <p class="text-gray-400 mb-4">Platform Pembelajaran Bahasa Arab Interaktif</p>
            <p class="text-sm text-gray-500">© {{ date('Y') }} TPQ Arabic Learning. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
