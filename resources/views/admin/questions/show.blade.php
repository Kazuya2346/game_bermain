@extends('layouts.admin')

@section('title', 'Question Detail')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Question Detail</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.questions.edit', $question) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Question
                </a>
                <a href="{{ route('admin.questions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Question Info -->
        <div class="space-y-6">
            <!-- Game -->
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-600">Game:</p>
                <a href="{{ route('admin.games.show', $question->game) }}" class="text-lg font-semibold text-blue-600 hover:text-blue-900">
                    {{ $question->game->title }}
                </a>
                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                    {{ ucfirst(str_replace('_', ' ', $question->game->type)) }}
                </span>
            </div>

            <!-- Question Text -->
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-sm text-gray-600">Question:</p>
                <p class="text-lg font-semibold text-gray-900">{{ $question->question_text }}</p>
            </div>

            <!-- Image -->
            @if($question->image_path)
                <div class="bg-gray-50 p-4 rounded">
                    <p class="text-sm text-gray-600 mb-2">Image:</p>
                    <img src="{{ asset('storage/' . $question->image_path) }}" alt="Question Image" class="rounded shadow-lg max-w-md">
                </div>
            @endif

            <!-- Correct Answer -->
            <div class="bg-green-50 p-4 rounded">
                <p class="text-sm text-gray-600">Correct Answer:</p>
                <p class="text-lg font-bold text-green-700">{{ $question->correct_answer }}</p>
            </div>

            <!-- Options -->
            @if($question->options)
                <div class="bg-gray-50 p-4 rounded">
                    <p class="text-sm text-gray-600 mb-2">Answer Options:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($question->options as $option)
                            <li class="text-gray-900 {{ $option == $question->correct_answer ? 'font-bold text-green-600' : '' }}">
                                {{ $option }}
                                @if($option == $question->correct_answer)
                                    <span class="text-xs">(Correct)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Location -->
            @if($question->location_name)
                <div class="bg-gray-50 p-4 rounded">
                    <p class="text-sm text-gray-600">Location:</p>
                    <p class="text-lg font-semibold text-gray-900">📍 {{ $question->location_name }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection