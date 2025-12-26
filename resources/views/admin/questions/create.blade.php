@extends('layouts.admin')

@section('title', 'Add New Question')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Question</h2>
            <a href="{{ route('admin.questions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Back
            </a>
        </div>

        <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Game Selection -->
            <div>
                <label for="game_id" class="block text-sm font-medium text-gray-700">Select Game</label>
                <select name="game_id" id="game_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Choose a game...</option>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}" {{ old('game_id', request('game_id')) == $game->id ? 'selected' : '' }}>
                            {{ $game->title }} ({{ ucfirst(str_replace('_', ' ', $game->type)) }})
                        </option>
                    @endforeach
                </select>
                @error('game_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Question Text -->
            <div>
                <label for="question_text" class="block text-sm font-medium text-gray-700">Question Text</label>
                <textarea name="question_text" id="question_text" rows="3" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Enter your question here...">{{ old('question_text') }}</textarea>
                @error('question_text')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload (for Tebak Gambar) -->
            <div>
                <label for="image_path" class="block text-sm font-medium text-gray-700">Image (Optional - for Tebak Gambar)</label>
                <input type="file" name="image_path" id="image_path" accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100">
                @error('image_path')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Correct Answer -->
            <div>
                <label for="correct_answer" class="block text-sm font-medium text-gray-700">Correct Answer</label>
                <input type="text" name="correct_answer" id="correct_answer" value="{{ old('correct_answer') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Enter the correct answer">
                @error('correct_answer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Options (for Pilihan Ganda) -->
            <div x-data="{ showOptions: false }">
                <div class="flex items-center mb-2">
                    <input type="checkbox" id="has_options" x-model="showOptions" class="rounded">
                    <label for="has_options" class="ml-2 text-sm font-medium text-gray-700">This is a multiple choice question</label>
                </div>
                
                <div x-show="showOptions" class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Answer Options (one per line)</label>
                    <input type="text" name="options[]" placeholder="Option 1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="text" name="options[]" placeholder="Option 2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="text" name="options[]" placeholder="Option 3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="text" name="options[]" placeholder="Option 4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                @error('options')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location Name (for Kosakata Tempat & Percakapan) -->
            <div>
                <label for="location_name" class="block text-sm font-medium text-gray-700">Location Name (Optional)</label>
                <input type="text" name="location_name" id="location_name" value="{{ old('location_name') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="e.g., Di Masjid, Di Sekolah, Di Pasar">
                @error('location_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Create Question
                </button>
            </div>
        </form>
    </div>
</div>
@endsection