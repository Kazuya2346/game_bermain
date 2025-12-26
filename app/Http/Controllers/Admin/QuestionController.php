<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('game')->latest()->paginate(10);
        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $games = Game::all();
        return view('admin.questions.create', compact('games'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'question_text' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'correct_answer' => 'required|string',
            'options' => 'nullable|array',
            'location_name' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('questions', 'public');
            $validated['image_path'] = $imagePath;
        }

        Question::create($validated);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Soal berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        $question->load('game');
        return view('admin.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $games = Game::all();
        return view('admin.questions.edit', compact('question', 'games'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'question_text' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'correct_answer' => 'required|string',
            'options' => 'nullable|array',
            'location_name' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image_path')) {
            // Delete old image if exists
            if ($question->image_path) {
                Storage::disk('public')->delete($question->image_path);
            }
            $imagePath = $request->file('image_path')->store('questions', 'public');
            $validated['image_path'] = $imagePath;
        }

        $question->update($validated);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Soal berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        // Delete image if exists
        if ($question->image_path) {
            Storage::disk('public')->delete($question->image_path);
        }

        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', 'Soal berhasil dihapus!');
    }
}