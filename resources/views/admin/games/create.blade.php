@extends('layouts.admin')

@section('title', 'Add New Game')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Game</h2>
            <a href="{{ route('admin.games.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Back
            </a>
        </div>

        <form action="{{ route('admin.games.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Game Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="e.g., Belajar Kosakata Hewan">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Game Type</label>
                <select name="type" id="type" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Select Game Type</option>
                    <option value="tebak_gambar" {{ old('type') == 'tebak_gambar' ? 'selected' : '' }}>Tebak Kosakata dari Gambar</option>
                    <option value="kosakata_tempat" {{ old('type') == 'kosakata_tempat' ? 'selected' : '' }}>Kosakata di 30 Tempat</option>
                    <option value="pilihan_ganda" {{ old('type') == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda Melengkapi Kalimat</option>
                    <option value="percakapan" {{ old('type') == 'percakapan' ? 'selected' : '' }}>Percakapan di 20 Tempat</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Describe what this game is about...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Create Game
                </button>
            </div>
        </form>
    </div>
</div>
@endsection