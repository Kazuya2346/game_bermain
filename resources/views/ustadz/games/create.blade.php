@extends('layouts.ustadz')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buat Game Baru
            </h2>
            <a href="{{ route('ustadz.games.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Error!</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Error!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Informasi Game</h3>
                    <p class="text-gray-600">Isi form di bawah untuk membuat game pembelajaran baru</p>
                </div>

                <form action="{{ route('ustadz.games.store') }}" method="POST">
                    @csrf

                    <!-- Judul Game -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">
                            Judul Game <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            value="{{ old('title') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                            placeholder="Contoh: Belajar Kosakata Rumah"
                            required
                        >
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipe Game -->
                    <div class="mb-6">
                        <label for="type" class="block text-sm font-bold text-gray-700 mb-2">
                            Tipe Game <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="type" 
                            id="type" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                            required
                        >
                            <option value="">-- Pilih Tipe Game --</option>
                            @foreach($gameTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                            Deskripsi Game
                        </label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="4"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-purple-500 focus:ring focus:ring-purple-200 transition"
                            placeholder="Jelaskan tujuan dan materi dari game ini..."
                        >{{ old('description') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Opsional - Jelaskan materi yang akan dipelajari</p>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                        <div class="flex items-start">
                            <div class="text-2xl mr-3">💡</div>
                            <div>
                                <p class="font-bold text-blue-800 mb-1">Tips:</p>
                                <ul class="text-sm text-blue-700 list-disc list-inside space-y-1">
                                    <li>Gunakan judul yang jelas dan menarik</li>
                                    <li>Pilih tipe game sesuai dengan materi pembelajaran</li>
                                    <li>Setelah membuat game, jangan lupa tambahkan pertanyaan!</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('ustadz.games.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600 transition font-medium">
                            ✅ Simpan Game
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
 @endsection