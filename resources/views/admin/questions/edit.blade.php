@extends('layouts.admin')

@section('title', 'Edit Question')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Question</h2>
            <a href="{{ route('admin.questions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Back
            </a>
        </div>

        <form action="{{ route('admin.questions.update', $question) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Game Selection -->
            <div>
                <label for="game_id" class="block text-sm font-medium text-gray-700">Select Game</label>
                <select name="game_id" id="game_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Choose a game...</option>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}" {{ old('game_id', $question->game_id) == $game->id ? 'selected' : '' }}>
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
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('question_text', $question->question_text) }}</textarea>
                @error('question_text')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image -->
            @if($question->image_path)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Current Image</label>
                    <img src="{{ asset('storage/' . $question->image_path) }}" alt="Question Image" class="mt-2 h-32 rounded">
                </div>
            @endif

            <!-- Image Upload -->
            <div>
                <label for="image_path" class="block text-sm font-medium text-gray-700">Change Image (Optional)</label>
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
                <input type="text" name="correct_answer" id="correct_answer" value="{{ old('correct_answer', $question->correct_answer) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('correct_answer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Options (for Pilihan Ganda) -->
            <div x-data="{ showOptions: {{ $question->options ? 'true' : 'false' }} }">
                <div class="flex items-center mb-2">
                    <input type="checkbox" id="has_options" x-model="showOptions" class="rounded" {{ $question->options ? 'checked' : '' }}>
                    <label for="has_options" class="ml-2 text-sm font-medium text-gray-700">This is a multiple choice question</label>
                </div>
                
                <div x-show="showOptions" class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Answer Options</label>
                    @if($question->options)
                        @foreach($question->options as $index => $option)
                            <input type="text" name="options[]" value="{{ $option }}" placeholder="Option {{ $index + 1 }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @endforeach
                    @else
                        <input type="text" name="options[]" placeholder="Option 1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <input type="text" name="options[]" placeholder="Option 2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <input type="text" name="options[]" placeholder="Option 3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <input type="text" name="options[]" placeholder="Option 4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @endif
                </div>
                @error('options')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location Name -->
            <div>
                <label for="location_name" class="block text-sm font-medium text-gray-700">Location Name (Optional)</label>
                <input type="text" name="location_name" id="location_name" value="{{ old('location_name', $question->location_name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="e.g., Di Masjid, Di Sekolah, Di Pasar">
                @error('location_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Update Question
                </button>
            </div>
        </form>
    </div>
</div>
@endsection