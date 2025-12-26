<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun Baru - {{ config('app.name', 'TPQ Arabic') }}</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen">

    <!-- Navigation Bar (Konsisten dengan Registrasi) -->
    <nav class="bg-white/90 backdrop-blur-md shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl">🕌</span>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        TPQ Arabic
                    </span>
                </a>
                
                <!-- Back to Home -->
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-purple-600 font-medium transition-colors">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-block p-4 bg-gradient-to-br from-blue-500 to-purple-500 rounded-3xl shadow-xl mb-4">
                    <span class="text-6xl">👤</span>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">
                    Daftar Akun Santri
                </h1>
                <p class="text-lg text-gray-600">
                    Isi Kolom Dibawah Ini Dengan Benar ! 
                </p>
            </div>

            <!-- Form Card (Menggunakan style yang sama dengan Registrasi) -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 border-4 border-purple-200">
                
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 rounded-lg">
                        <p class="text-red-700 font-semibold mb-2">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Registration Form (HTML Murni, BUKAN Blade Component) -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            autocomplete="name"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring focus:ring-purple-200 transition-colors @error('name') border-red-500 @enderror"
                            placeholder="Contoh: Admin Utama"
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            autocomplete="username"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring focus:ring-purple-200 transition-colors @error('email') border-red-500 @enderror"
                            placeholder="contoh@email.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            autocomplete="new-password"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring focus:ring-purple-200 transition-colors @error('password') border-red-500 @enderror"
                            placeholder="Minimal 8 karakter"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Minimal 8 karakter</p>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required
                            autocomplete="new-password"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-purple-500 focus:ring focus:ring-purple-200 transition-colors"
                            placeholder="Ketik ulang password"
                        >
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button 
                            type="submit"
                            class="w-full px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all"
                        >
                            Daftar
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center pt-4 border-t-2 border-gray-200">
                        <p class="text-gray-600">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="font-semibold text-purple-600 hover:text-purple-700 underline">
                                Login disini
                            </a>
                        </p>
                    </div>
                </form>

            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="py-8 text-center text-gray-600">
        <p>© {{ date('Y') }} TPQ Arabic Learning. All rights reserved.</p>
    </footer>

</body>
</html>