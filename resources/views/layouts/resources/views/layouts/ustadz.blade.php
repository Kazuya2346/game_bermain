<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ustadz Panel - TPQ Arabic Learning</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
        }
        
        /* Dropdown Hover Effect */
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        
        /* Mobile Menu Animation */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .mobile-menu-open {
            animation: slideDown 0.3s ease-out;
        }

        /* Prevent FOUC */
        [x-cloak] { 
            display: none !important; 
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #4F46E5;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #4338CA;
        }

        /* Fade in animation for notifications */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 border-b-4 border-emerald-400" x-data="{ mobileMenuOpen: false, profileDropdown: false }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Left Section: Logo & Desktop Menu -->
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-white text-xl font-bold">🏫 TPQ Arabic</span>
                        </div>
                        
                        <!-- Desktop Navigation Menu -->
                        <div class="hidden md:ml-6 md:flex md:space-x-2">
                            <!-- Dashboard -->
                            <a href="{{ route('ustadz.dashboard') }}" 
                               class="{{ request()->routeIs('ustadz.dashboard') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-all duration-200">
                                🏠 Dashboard
                            </a>
                            
                            <!-- Games Dropdown -->
                            <div class="relative dropdown">
                                <button type="button" class="{{ request()->routeIs('ustadz.games.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center gap-1">
                                    🎮 Game
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <!-- Dropdown Menu -->
                                <div class="dropdown-menu hidden absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <a href="{{ route('ustadz.games.index') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                            📚 Semua Game
                                        </a>
                                        <a href="{{ route('ustadz.games.create') }}" 
                                           class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                            ➕ Buat Game Baru
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Scores -->
                            <a href="{{ route('ustadz.scores.index') }}" 
                               class="{{ request()->routeIs('ustadz.scores.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-all duration-200">
                                📊 Skor Santri
                            </a>
                        </div>
                    </div>
                    
                    <!-- Right Section: User Menu -->
                    <div class="flex items-center">
                        <!-- Desktop User Menu -->
                        <div class="hidden md:flex items-center space-x-3">
                            <span class="text-emerald-100 text-sm font-medium">👨‍🏫 {{ Auth::user()->name }}</span>
                            
                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button @click="profileDropdown = !profileDropdown" 
                                        type="button"
                                        class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white/20 backdrop-blur-sm text-white hover:bg-white/30 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': profileDropdown}" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="profileDropdown" 
                                     @click.away="profileDropdown = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden z-50"
                                     style="display: none;"
                                     x-cloak>
                                    <a href="{{ route('profile.edit') }}" 
                                       class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Profile
                                    </a>
                                    <div class="border-t border-gray-200"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mobile Menu Button -->
                        <div class="md:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                                    type="button" 
                                    class="inline-flex items-center justify-center p-2 rounded-md text-emerald-100 hover:text-white hover:bg-emerald-700 transition-all duration-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="mobile-menu-open"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="md:hidden bg-emerald-700 border-t border-emerald-500"
                 style="display: none;"
                 x-cloak>
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('ustadz.dashboard') }}" 
                       class="{{ request()->routeIs('ustadz.dashboard') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                        🏠 Dashboard
                    </a>
                    
                    <!-- Divider -->
                    <div class="border-t border-emerald-500 my-2"></div>
                    
                    <!-- Game Section -->
                    <div class="px-3 py-2 text-xs font-semibold text-emerald-200 uppercase tracking-wider">
                        Game Management
                    </div>
                    <a href="{{ route('ustadz.games.index') }}" 
                       class="{{ request()->routeIs('ustadz.games.index') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                        📚 Semua Game
                    </a>
                    <a href="{{ route('ustadz.games.create') }}" 
                       class="{{ request()->routeIs('ustadz.games.create') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                        ➕ Buat Game Baru
                    </a>
                    
                    <!-- Divider -->
                    <div class="border-t border-emerald-500 my-2"></div>
                    
                    <!-- Scores -->
                    <a href="{{ route('ustadz.scores.index') }}" 
                       class="{{ request()->routeIs('ustadz.scores.*') ? 'bg-emerald-800 text-white' : 'text-emerald-100 hover:bg-emerald-600 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                        📊 Skor Santri
                    </a>
                    
                    <!-- Divider -->
                    <div class="border-t border-emerald-500 my-2"></div>
                    
                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}" 
                       class="text-emerald-100 hover:bg-emerald-600 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                        👤 Profile
                    </a>
                    
                    <!-- User Info & Logout -->
                    <div class="px-3 py-2">
                        <div class="text-sm font-medium text-emerald-100 mb-2">
                            👨‍🏫 {{ Auth::user()->name }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Notifications -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-lg animate-fade-in" role="alert">
                    <div class="flex items-start">
                        <span class="text-2xl mr-3">✅</span>
                        <div>
                            <p class="font-bold">Sukses!</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-lg animate-fade-in" role="alert">
                    <div class="flex items-start">
                        <span class="text-2xl mr-3">❌</span>
                        <div>
                            <p class="font-bold">Error!</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 text-sm">
                    © 2024 TPQ Arabic Learning System. Kelola dengan ❤️ oleh Ustadz/Ustadzah
                </p>
            </div>
        </footer>
    </div>
</body>
</html>