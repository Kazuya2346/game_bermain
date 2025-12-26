@extends('layouts.admin')

@section('title', 'Game Detail')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ $game->title }}</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.games.edit', $game) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Game
                </a>
                <a href="{{ route('admin.games.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Game Info -->
        <div class="mb-6 bg-gray-50 p-4 rounded">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Game Type:</p>
                    <p class="font-semibold">{{ ucfirst(str_replace('_', ' ', $game->type)) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Created By:</p>
                    <p class="font-semibold">{{ $game->creator->name }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Description:</p>
                    <p class="font-semibold">{{ $game->description ?? 'No description' }}</p>
                </div>
            </div>
        </div>

        <!-- Questions List -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Questions ({{ $game->questions->count() }})</h3>
                <a href="{{ route('admin.questions.create', ['game_id' => $game->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Add Question
                </a>
            </div>

            @if($game->questions->count() > 0)
                <div class="space-y-4">
                    @foreach($game->questions as $question)
                        <div class="border rounded p-4 bg-white">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $question->question_text }}</p>
                                    <p class="text-sm text-green-600 mt-2">✓ Correct Answer: {{ $question->correct_answer }}</p>
                                    @if($question->location_name)
                                        <p class="text-sm text-gray-500 mt-1">📍 Location: {{ $question->location_name }}</p>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.questions.edit', $question) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Delete this question?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No questions yet. Add your first question!</p>
            @endif
        </div>
    </div>
</div>
@endsection
