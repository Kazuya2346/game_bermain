<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hubungi Admin - {{ config('app.name', 'TPQ Arabic') }}</title>
    
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

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 0 30px rgba(16, 185, 129, 0.6); }
        }
        .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
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
                    <span class="text-6xl relative z-10">📞</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-2">
                    Hubungi Admin
                </h1>
                <p class="text-base sm:text-lg text-gray-600">
                    Untuk mengatur ulang kata sandi Anda, silakan hubungi admin kami.
                </p>
            </div>

            <!-- Contact Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 border-4 border-emerald-200"
                 x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 300)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-95">
                
                <!-- Admin Contact Info -->
                <div class="rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 p-6 border-l-4 border-emerald-500 shadow-lg">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="relative">
                                <img class="h-20 w-20 sm:h-24 sm:w-24 rounded-full object-cover border-4 border-emerald-300 shadow-xl" src="https://placehold.co/96x96/D1FAE5/10B981?text=UA" alt="Admin Ustadz ARIF">
                                <div class="absolute -bottom-1 -right-1 bg-emerald-500 rounded-full p-2 shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <p class="text-sm font-medium text-gray-600 mb-2">
                                Silakan hubungi Admin untuk mengatur ulang kata sandi Anda:
                            </p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center justify-center sm:justify-start gap-2">
                                <span>🤴</span>
                                <span>Tuan ARIF</span>
                            </p>
                            <div class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-white rounded-xl border-2 border-emerald-300 shadow-md">
                                <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                <p class="text-lg font-bold text-emerald-600">
                                    081391023867
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Button -->
                <div class="mt-6">
                    <a 
                        href="https://wa.me/6281391023867?text=Assalamu%27alaikum%20Ustadz%2C%20saya%20ingin%20reset%20password%20akun%20TPQ%20Arabic%20Learning" 
                        target="_blank"
                        class="block w-full px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all active:scale-95 flex items-center justify-center gap-3 animate-pulse-glow"
                    >
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                </div>

                <!-- Additional Info -->
                <div class="mt-6 p-4 bg-amber-50 border-2 border-amber-200 rounded-xl">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">💡</span>
                        <div>
                            <p class="text-sm font-semibold text-amber-800 mb-1">Tips:</p>
                            <p class="text-xs text-amber-700">
                                Siapkan informasi akun Anda (email terdaftar) saat menghubungi admin untuk mempercepat proses reset password.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="relative py-4 mt-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t-2 border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500 font-medium">Ingat password Anda?</span>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-emerald-500 text-emerald-600 rounded-xl font-semibold shadow-lg hover:bg-emerald-50 hover:shadow-xl hover:scale-105 transition-all active:scale-95">
                        <span>🔐</span>
                        <span>Kembali ke Login</span>
                    </a>
                </div>
            </div>

            <!-- Motivational Quote -->
            <div class="mt-8 text-center">
                <div class="inline-block bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-6 border-2 border-emerald-200">
                    <p class="text-xl font-arabic text-emerald-600 font-bold mb-2">
                        وَاسْتَعِينُوا بِالصَّبْرِ وَالصَّلَاةِ
                    </p>
                    <p class="text-sm text-gray-600">
                        "Mohonlah pertolongan dengan sabar dan shalat"
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