<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - TPQ Arabic Learning</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-arabic { font-family: 'Amiri', serif; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-10px) rotate(1deg); }
            50% { transform: translateY(-15px) rotate(0deg); }
            75% { transform: translateY(-10px) rotate(-1deg); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        .animate-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }

        .arabic-text {
            font-family: 'Amiri', serif;
            direction: rtl;
        }
    </style>
    @stack('styles') {{-- Tambahkan ini untuk style per halaman --}}
</head>
<body class="bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 min-h-screen overflow-x-hidden">

    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-20 left-10 w-64 h-64 bg-emerald-300/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 bg-teal-300/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/3 w-72 h-72 bg-cyan-300/20 rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>
    </div>

    <nav x-data="{ open: false, userMenuOpen: false }" class="relative bg-white/90 backdrop-blur-md shadow-lg z-20 sticky top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('santri.dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-2xl">🕌</span>
                    </div>
                    <span class="text-lg sm:text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                        TPQ Arabic
                    </span>
                </a>

                <div class="hidden lg:flex items-center space-x-2">
                    <a href="{{ route('santri.dashboard') }}" 
                       class="px-4 py-2 rounded-lg font-medium transition-all
                              {{ request()->routeIs('santri.dashboard') 
                                  ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg' 
                                  : 'text-gray-600 hover:text-emerald-600 hover:bg-emerald-50' }}">
                        🏠 Dashboard
                    </a>

                    <a href="{{ route('santri.games.index') }}" 
                       class="px-4 py-2 rounded-lg font-medium transition-all
                              {{ request()->routeIs('santri.games*') || request()->routeIs('santri.listening*')
                                  ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg' 
                                  : 'text-gray-600 hover:text-emerald-600 hover:bg-emerald-50' }}">
                        🎮 Games
                    </a>

                    <a href="{{ route('santri.scores') }}" 
                       class="px-4 py-2 rounded-lg font-medium transition-all
                              {{ request()->routeIs('santri.scores') 
                                  ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg' 
                                  : 'text-gray-600 hover:text-emerald-600 hover:bg-emerald-50' }}">
                        📊 Scores
                    </a>

                    <a href="{{ route('santri.profile') }}" 
                       class="px-4 py-2 rounded-lg font-medium transition-all
                              {{ request()->routeIs('santri.profile') 
                                  ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg' 
                                  : 'text-gray-600 hover:text-emerald-600 hover:bg-emerald-50' }}">
                        👤 Profile
                    </a>

                    <a href="{{ route('santri.leaderboard') }}" 
                       class="px-4 py-2 rounded-lg font-medium transition-all
                              {{ request()->routeIs('santri.leaderboard') 
                                  ? 'bg-gradient-to-r from-yellow-400 to-orange-500 text-white shadow-lg' 
                                  : 'text-gray-600 hover:text-yellow-600 hover:bg-yellow-50' }}">
                        🏆 Peringkat
                    </a>
                </div>

                <div class="hidden lg:flex items-center">
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-emerald-50 transition-colors group">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                     alt="Avatar" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-emerald-300 group-hover:border-emerald-500 transition-colors">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-xl border-2 border-emerald-300 group-hover:border-emerald-500 transition-colors">
                                    {{ auth()->user()->role == 'santri_putra' ? '👦' : '👧' }}
                                </div>
                            @endif
                            <span class="font-semibold text-gray-700 group-hover:text-emerald-600 transition-colors">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-600 group-hover:text-emerald-600 transition-colors" :class="{'rotate-180': userMenuOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="userMenuOpen" 
                             @click.away="userMenuOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl py-2 z-50 border-2 border-emerald-200"
                             style="display: none;">

                            <div class="px-4 py-3 border-b border-emerald-100">
                                <p class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-emerald-600 font-medium mt-1">Level {{ auth()->user()->level ?? 1 }} • {{ auth()->user()->experience_points ?? 0 }} XP</p>
                            </div>

                            <a href="{{ route('santri.profile') }}" 
                               class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors font-medium">
                                <span>👤</span> My Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="border-t border-emerald-100 mt-2 pt-2">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 transition-colors font-medium">
                                    <span>🚪</span> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="lg:hidden flex items-center">
                    <button @click="open = !open" class="p-2 rounded-lg text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden bg-white/95 backdrop-blur-md shadow-lg border-t border-gray-100">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('santri.dashboard') }}" 
                   class="block px-4 py-2 rounded-lg font-medium transition-colors
                          {{ request()->routeIs('santri.dashboard') 
                              ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg' 
                              : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    🏠 Dashboard
                </a>

                <a href="{{ route('santri.games.index') }}" 
                   class="block px-4 py-2 rounded-lg font-medium transition-colors
                          {{ request()->routeIs('santri.games*') || request()->routeIs('santri.listening*')
                              ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg' 
                              : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    🎮 Games
                </a>

                <a href="{{ route('santri.scores') }}" 
                   class="block px-4 py-2 rounded-lg font-medium transition-colors
                          {{ request()->routeIs('santri.scores') 
                              ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg' 
                              : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    📊 Scores
                </a>
                <a href="{{ route('santri.profile') }}" 
                   class="block px-4 py-2 rounded-lg font-medium transition-colors
                          {{ request()->routeIs('santri.profile') 
                              ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg' 
                              : 'text-gray-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                    👤 Profile
                </a>
                <a href="{{ route('santri.leaderboard') }}" 
                   class="block px-4 py-2 rounded-lg font-medium transition-colors
                          {{ request()->routeIs('santri.leaderboard') 
                              ? 'bg-gradient-to-r from-yellow-400 to-orange-500 text-white shadow-lg' 
                              : 'text-gray-600 hover:text-yellow-50 hover:text-yellow-600' }}">
                    🏆 Peringkat
                </a>
            </div>

            <div class="pt-4 pb-4 border-t border-gray-200 px-4">
                <div class="flex items-center gap-3 mb-3 px-4">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                             alt="Avatar" 
                             class="w-12 h-12 rounded-full object-cover border-2 border-emerald-300">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-2xl border-2 border-emerald-300">
                            {{ auth()->user()->role == 'santri_putra' ? '👦' : '👧' }}
                        </div>
                    @endif
                    <div>
                        <div class="font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-emerald-600 font-medium">Level {{ auth()->user()->level ?? 1 }} • {{ auth()->user()->experience_points ?? 0 }} XP</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-red-600 bg-red-50 hover:bg-red-100 font-medium transition-colors">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 z-10">
            <div class="bg-gradient-to-r from-green-100 to-emerald-100 border-2 border-green-400 text-green-700 px-5 py-4 rounded-2xl shadow-lg flex items-center gap-3" role="alert">
                <span class="text-2xl">✅</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 z-10">
            <div class="bg-gradient-to-r from-red-100 to-rose-100 border-2 border-red-400 text-red-700 px-5 py-4 rounded-2xl shadow-lg flex items-center gap-3" role="alert">
                <span class="text-2xl">❌</span>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <main class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 z-10">
        @yield('content')
    </main>

    <footer class="relative bg-white/80 backdrop-blur-sm border-t-2 border-emerald-200 mt-12 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center">
            <p class="text-gray-600 font-medium">© {{ date('Y') }} TPQ Arabic Learning. Made with ❤️ for better learning.</p>
            <p class="text-sm text-gray-500 mt-1">بارك الله فيكم</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>