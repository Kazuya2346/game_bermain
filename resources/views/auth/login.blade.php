<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'TPQ Arabic') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient-bg {
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        .animate-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 min-h-screen overflow-x-hidden">

    <!-- Decorative Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-20 left-10 w-64 h-64 bg-emerald-300/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 bg-teal-300/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/3 w-72 h-72 bg-cyan-300/20 rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>
    </div>

    <!-- Navigation Bar -->
    <nav class="relative bg-white/90 backdrop-blur-md shadow-lg z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-18">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <span class="text-2xl">🕌</span>
                    </div>
                    <span class="text-lg sm:text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                        TPQ Arabic
                    </span>
                </a>
                
                <!-- Back to Home -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-emerald-600 font-medium transition-colors rounded-lg hover:bg-emerald-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali ke Beranda</span>
                    <span class="sm:hidden">Beranda</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="relative py-8 sm:py-12 px-4 sm:px-6 lg:px-8 z-10">
        <div class="max-w-md mx-auto">
            
            <!-- Header with Animation -->
            <div class="text-center mb-8" 
                 x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 100)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 translate-y-[-20px]">
                <div class="inline-block p-5 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl shadow-2xl mb-4 relative overflow-hidden">
                    <div class="absolute inset-0 animate-shimmer"></div>
                    <span class="text-6xl relative z-10">🔐</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-2">
                    مرحبا بك
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 font-semibold mb-1">
                    Selamat Datang Kembali!
                </p>
                <p class="text-sm text-gray-500">
                    Masuk ke akun TPQ Arabic Learning
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 border-4 border-emerald-200"
                 x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 300)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-95">
                
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">✅</span>
                            <p class="text-green-700 font-medium">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Success Message -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-xl">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">✅</span>
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            📧 Email
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all @error('email') border-red-500 @enderror"
                            placeholder="contoh@email.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <span>⚠️</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            🔒 Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                :type="showPassword ? 'text' : 'password'"
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="w-full px-4 py-3 pr-12 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all @error('password') border-red-500 @enderror"
                                placeholder="Masukkan password"
                            >
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-emerald-600 transition-colors"
                            >
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <span>⚠️</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                            >
                            <label for="remember_me" class="ml-2 text-sm text-gray-600">
                                Ingat saya
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium hover:underline">
                            Lupa password?
                        </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button 
                            type="submit"
                            class="w-full px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all active:scale-95 flex items-center justify-center gap-2"
                        >
                            <span>🔐</span>
                            <span>Login Sekarang</span>
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t-2 border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">Belum punya akun?</span>
                        </div>
                    </div>

                    <!-- Register Links -->
                    <div class="space-y-3">
                        <!-- Daftar Santri Baru -->
                        <a href="{{ route('register.santri') }}" class="block w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all active:scale-95 text-center">
                            <span class="flex items-center justify-center gap-2">
                                <span>🎓</span>
                                <span>Daftar Santri Baru</span>
                            </span>
                        </a>
                        
                        
                    </div>
                </form>

            </div>

            <!-- Motivational Quote -->
            <div class="mt-8 text-center">
                <div class="inline-block bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border-2 border-emerald-200">
                    <p class="text-xl font-arabic text-emerald-600 font-bold mb-2">
                        طلب العلم فريضة على كل مسلم
                    </p>
                    <p class="text-sm text-gray-600">
                        "Menuntut ilmu adalah kewajiban bagi setiap muslim"
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="relative py-8 text-center text-gray-600 z-10">
        <p class="text-sm">© {{ date('Y') }} TPQ Arabic Learning. All rights reserved.</p>
    </footer>

</body>
</html>