<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Santri Baru - {{ config('app.name', 'TPQ Arabic') }}</title>
    
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
        <div class="max-w-2xl mx-auto">
            
            <!-- Header with Animation -->
            <div class="text-center mb-8" 
                 x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 100)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 translate-y-[-20px]">
                <div class="inline-block p-5 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-3xl shadow-2xl mb-4 relative overflow-hidden">
                    <div class="absolute inset-0 animate-shimmer"></div>
                    <span class="text-6xl relative z-10">🎓</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-2">
                    Daftar Santri Baru
                </h1>
                <p class="text-base sm:text-lg text-gray-600">
                    Isi formulir di bawah untuk bergabung dengan TPQ Arabic Learning
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 border-4 border-emerald-200"
                 x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 300)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-95">
                
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl">
                        <div class="flex items-start gap-2">
                            <span class="text-xl">⚠️</span>
                            <div>
                                <p class="text-red-700 font-semibold mb-2">Terjadi kesalahan:</p>
                                <ul class="list-disc list-inside text-red-600 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register.santri.store') }}" class="space-y-5">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            👤 Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all @error('name') border-red-500 @enderror"
                            placeholder="Contoh: Ahmad Abdullah"
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <span>⚠️</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            📧 Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
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
                            🔒 Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                :type="showPassword ? 'text' : 'password'"
                                name="password" 
                                required
                                class="w-full px-4 py-3 pr-12 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all @error('password') border-red-500 @enderror"
                                placeholder="Minimal 8 karakter"
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
                        <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                            <span>ℹ️</span> Minimal 8 karakter
                        </p>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div x-data="{ showPasswordConfirm: false }">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            🔐 Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                id="password_confirmation" 
                                :type="showPasswordConfirm ? 'text' : 'password'"
                                name="password_confirmation" 
                                required
                                class="w-full px-4 py-3 pr-12 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all"
                                placeholder="Ketik ulang password"
                            >
                            <button 
                                type="button"
                                @click="showPasswordConfirm = !showPasswordConfirm"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-emerald-600 transition-colors"
                            >
                                <svg x-show="!showPasswordConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPasswordConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            👥 Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Putra -->
                            <label class="relative flex items-center justify-center p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-emerald-500 hover:bg-emerald-50/50 transition-all group @error('role') border-red-500 @enderror">
                                <input 
                                    type="radio" 
                                    name="role" 
                                    value="santri_putra" 
                                    {{ old('role') == 'santri_putra' ? 'checked' : '' }}
                                    required
                                    class="sr-only peer"
                                >
                                <div class="text-center peer-checked:font-bold">
                                    <div class="text-4xl mb-2 group-hover:scale-110 transition-transform">👨‍🎓</div>
                                    <div class="text-gray-700 peer-checked:text-emerald-600">Putra</div>
                                </div>
                                <div class="absolute top-2 right-2 w-5 h-5 border-2 border-gray-400 rounded-full peer-checked:bg-emerald-600 peer-checked:border-emerald-600 flex items-center justify-center transition-all">
                                    <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </label>

                            <!-- Putri -->
                            <label class="relative flex items-center justify-center p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-teal-500 hover:bg-teal-50/50 transition-all group @error('role') border-red-500 @enderror">
                                <input 
                                    type="radio" 
                                    name="role" 
                                    value="santri_putri" 
                                    {{ old('role') == 'santri_putri' ? 'checked' : '' }}
                                    required
                                    class="sr-only peer"
                                >
                                <div class="text-center peer-checked:font-bold">
                                    <div class="text-4xl mb-2 group-hover:scale-110 transition-transform">👩‍🎓</div>
                                    <div class="text-gray-700 peer-checked:text-teal-600">Putri</div>
                                </div>
                                <div class="absolute top-2 right-2 w-5 h-5 border-2 border-gray-400 rounded-full peer-checked:bg-teal-600 peer-checked:border-teal-600 flex items-center justify-center transition-all">
                                    <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </label>
                        </div>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <span>⚠️</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label for="class_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            📚 Kelas <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="class_id" 
                            name="class_id" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all @error('class_id') border-red-500 @enderror"
                        >
                            <option value="">-- Pilih Kelas --</option>
                            <option value="Kelas 1" {{ old('class_id') == 'Kelas 1' ? 'selected' : '' }}>Kelas 1</option>
                            <option value="Kelas 2" {{ old('class_id') == 'Kelas 2' ? 'selected' : '' }}>Kelas 2</option>
                            <option value="Kelas 3" {{ old('class_id') == 'Kelas 3' ? 'selected' : '' }}>Kelas 3</option>
                            <option value="Kelas 4" {{ old('class_id') == 'Kelas 4' ? 'selected' : '' }}>Kelas 4</option>
                            <option value="Kelas 5" {{ old('class_id') == 'Kelas 5' ? 'selected' : '' }}>Kelas 5</option>
                            <option value="Kelas 6" {{ old('class_id') == 'Kelas 6' ? 'selected' : '' }}>Kelas 6</option>
                        </select>
                        @error('class_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <span>⚠️</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon/WA -->
                    <div>
                        <label for="no_telepon" class="block text-sm font-semibold text-gray-700 mb-2">
                            📱 Nomor Telepon/WhatsApp <span class="text-gray-400">(Opsional)</span>
                        </label>
                        <input 
                            id="no_telepon" 
                            type="text" 
                            name="no_telepon" 
                            value="{{ old('no_telepon') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all @error('no_telepon') border-red-500 @enderror"
                            placeholder="Contoh: 08123456789"
                        >
                        @error('no_telepon')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <span>⚠️</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button 
                            type="submit"
                            class="w-full px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all active:scale-95 flex items-center justify-center gap-2"
                        >
                            <span>🎉</span>
                            <span>Daftar Sekarang</span>
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t-2 border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">Sudah punya akun?</span>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-emerald-500 text-emerald-600 rounded-xl font-semibold shadow-lg hover:bg-emerald-50 hover:shadow-xl hover:scale-105 transition-all active:scale-95">
                            <span>🔐</span>
                            <span>Login disini</span>
                        </a>
                    </div>
                </form>

            </div>

            <!-- Motivational Quote -->
            <div class="mt-8 text-center">
                <div class="inline-block bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border-2 border-emerald-200">
                    <p class="text-xl font-arabic text-emerald-600 font-bold mb-2">
                        بارك الله فيكم
                    </p>
                    <p class="text-sm text-gray-600">
                        "Semoga Allah memberkahi kalian"
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