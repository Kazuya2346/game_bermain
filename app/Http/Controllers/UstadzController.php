<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Question;
use App\Models\Score;
use App\Models\User;
use App\Models\AnswerLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UstadzController extends Controller
{
    /**
     * Dashboard Ustadz
     */
    public function dashboard()
    {
        $user = Auth::user();

        $totalGames = Game::where('created_by', $user->id)->count();
        $totalQuestions = Question::whereHas('game', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })->count();

        $totalScores = Score::whereHas('game', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })->count();

        $averageScore = Score::whereHas('game', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })->avg('score') ?? 0;

        $recentGames = Game::where('created_by', $user->id)
            ->withCount('questions')
            ->latest()
            ->take(5)
            ->get();

        return view('ustadz.dashboard', compact(
            'totalGames', 
            'totalQuestions', 
            'totalScores', 
            'averageScore',
            'recentGames'
        ));
    }

    /**
     * List semua game yang dibuat oleh ustadz
     */
    public function games()
    {
        $games = Game::where('created_by', Auth::id())
            ->withCount('questions')
            ->withCount('scores')
            ->latest()
            ->paginate(10);

        return view('ustadz.games.index', compact('games'));
    }

    /**
     * Show form create game
     */
    public function createGame()
    {
        $gameTypes = [
            'tebak_gambar' => 'Tebak Kosakata dari Gambar 🖼️',
            'kosakata_tempat' => 'Kosakata di 30 Tempat 🏠', 
            'pilihan_ganda' => 'Pilihan Ganda Melengkapi Kalimat ✅',
            'percakapan' => 'Percakapan di 20 Tempat 💬'
        ];

        return view('ustadz.games.create', compact('gameTypes'));
    }

    /**
     * Store new game
     */
    public function storeGame(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:tebak_gambar,kosakata_tempat,pilihan_ganda,percakapan',
            'description' => 'nullable|string'
        ]);

        try {
            $validated['created_by'] = Auth::id();
            Game::create($validated);

            return redirect()->route('ustadz.games.index')
                ->with('success', 'Game berhasil dibuat! Silakan tambahkan pertanyaan.');

        } catch (\Exception $e) {
            \Log::error('Failed to create game: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat game. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Show form edit game
     */
    public function editGame($id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($id);
        $gameTypes = [
            'tebak_gambar' => 'Tebak Kosakata dari Gambar 🖼️',
            'kosakata_tempat' => 'Kosakata di 30 Tempat 🏠',
            'pilihan_ganda' => 'Pilihan Ganda Melengkapi Kalimat ✅',
            'percakapan' => 'Percakapan di 20 Tempat 💬'
        ];

        return view('ustadz.games.edit', compact('game', 'gameTypes'));
    }

    /**
     * Update game
     */
    public function updateGame(Request $request, $id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:tebak_gambar,kosakata_tempat,pilihan_ganda,percakapan',
            'description' => 'nullable|string'
        ]);

        try {
            $game->update($validated);

            return redirect()->route('ustadz.games.index')
                ->with('success', 'Game berhasil diupdate!');

        } catch (\Exception $e) {
            \Log::error('Failed to update game: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengupdate game. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Delete game
     */
    public function destroyGame($id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($id);

        try {
            // Delete semua gambar dari questions
            $questions = $game->questions;
            foreach ($questions as $question) {
                if ($question->image_path && Storage::disk('public')->exists($question->image_path)) {
                    Storage::disk('public')->delete($question->image_path);
                }
            }

            $game->delete();
            
            return redirect()->route('ustadz.games.index')
                ->with('success', 'Game berhasil dihapus!');

        } catch (\Exception $e) {
            \Log::error('Failed to delete game: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus game. Silakan coba lagi.');
        }
    }

    /**
     * Publish/Unpublish Game
     */
    public function toggleStatus($id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($id);

        // Validasi: Game tidak bisa di-publish jika tidak ada soal
        if ($game->status == 'draft' && $game->questions()->count() == 0) {
            return back()->with('error', 'Game tidak bisa di-publish karena belum memiliki soal.');
        }

        try {
            // Toggle status
            $newStatus = $game->status == 'draft' ? 'published' : 'draft';
            $message = $newStatus == 'published' 
                ? 'Game berhasil di-publish!' 
                : 'Game berhasil di-unpublish (disimpan sebagai draft).';

            $game->update(['status' => $newStatus]);

            return redirect()->route('ustadz.games.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            \Log::error('Failed to toggle game status: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengubah status game. Silakan coba lagi.');
        }
    }

    /**
     * Show game detail
     */
    public function showGame($id)
    {
        $game = Game::where('created_by', Auth::id())
            ->withCount('questions')
            ->withCount('scores')
            ->findOrFail($id);

        $questions = $game->questions()->latest()->paginate(10);

        return view('ustadz.games.show', compact('game', 'questions'));
    }

    /**
     * List questions untuk game tertentu
     */
    public function questions($game_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        $questions = $game->questions()->latest()->paginate(10);

        return view('ustadz.questions.index', compact('game', 'questions'));
    }

    /**
     * Show form create question
     */
    public function createQuestion($game_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);

        $locationOptions = [
            'Masjid', 'Rumah', 'Sekolah', 'Pasar', 'Kantor', 'Restoran',
            'Taman', 'Perpustakaan', 'Klinik', 'Stasiun', 'Bandara', 'Pelabuhan',
            'Hotel', 'Mall', 'Bioskop', 'Lapangan', 'Kantin', 'Laboratorium',
            'Workshop', 'Kelas', 'Musholla', 'Kamar Mandi', 'Dapur',
            'Kamar Tidur', 'Ruang Tamu', 'Teras', 'Kebun', 'Garasi', 'Ruang Meeting'
        ];

        return view('ustadz.questions.create', compact('game', 'locationOptions'));
    }

    /**
     * Store Question (BULK & FLEXIBLE TYPE) - FIXED VERSION
     */
    public function storeQuestion(Request $request, $game_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);

        // Validasi input
        $rules = [
            'questions' => 'required|array|min:1',
            'questions.*.answer_type' => 'required|in:multiple_choice,essay',
            'questions.*.question_text' => 'required|string',
            'questions.*.correct_answer' => 'required|string|max:255',
            'questions.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'questions.*.options' => 'required_if:questions.*.answer_type,multiple_choice|array',
            'questions.*.options.*' => 'nullable|string|max:255',
            'questions.*.location_name' => 'nullable|string|max:255',
        ];

        $messages = [
            'questions.*.question_text.required' => 'Teks pertanyaan wajib diisi.',
            'questions.*.correct_answer.required' => 'Jawaban benar wajib diisi.',
            'questions.*.image.image' => 'File harus berupa gambar.',
            'questions.*.image.max' => 'Ukuran gambar maksimal 2MB.',
            'questions.*.answer_type.required' => 'Tipe jawaban wajib dipilih.',
            'questions.*.options.required_if' => 'Pilihan jawaban wajib diisi untuk soal pilihan ganda.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // Set attribute names untuk error yang lebih jelas
        $attributeNames = [];
        if ($request->has('questions')) {
            foreach ($request->questions as $index => $item) {
                $label = 'Soal ' . ($index + 1);
                $attributeNames["questions.{$index}.question_text"] = $label;
                $attributeNames["questions.{$index}.correct_answer"] = $label;
                $attributeNames["questions.{$index}.image"] = $label;
                $attributeNames["questions.{$index}.options"] = $label;
                $attributeNames["questions.{$index}.answer_type"] = $label;
                $attributeNames["questions.{$index}.location_name"] = $label;
            }
        }
        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $allQuestionsData = $request->questions;
        $questionCount = 0;
        $uploadedImages = [];

        DB::beginTransaction();
        try {
            foreach ($allQuestionsData as $index => $questionData) {
                $imagePath = null;

                // Upload gambar jika ada
                if ($request->hasFile("questions.{$index}.image")) {
                    $file = $request->file("questions.{$index}.image");
                    $imagePath = $file->store('questions', 'public');
                    $uploadedImages[] = $imagePath;
                }

                // Proses options untuk multiple choice
                $options = null;
                if ($questionData['answer_type'] === 'multiple_choice' && isset($questionData['options'])) {
                    $filteredOptions = array_filter(
                        $questionData['options'], 
                        fn($value) => !empty(trim($value ?? ''))
                    );
                    
                    if (count($filteredOptions) >= 2) {
                        $options = json_encode(array_values($filteredOptions));
                    } else {
                        throw new \Exception("Soal pilihan ganda harus memiliki minimal 2 pilihan jawaban.");
                    }
                }

                // Simpan ke database
                Question::create([
                    'game_id' => $game->id,
                    'answer_type' => $questionData['answer_type'],
                    'question_text' => trim($questionData['question_text']),
                    'correct_answer' => trim($questionData['correct_answer']),
                    'image_path' => $imagePath,
                    'options' => $options,
                    'location_name' => !empty($questionData['location_name']) 
                        ? trim($questionData['location_name']) 
                        : null
                ]);

                $questionCount++;
            }

            DB::commit();

            return redirect()->route('ustadz.games.questions.index', $game->id)
                ->with('success', "$questionCount pertanyaan berhasil ditambahkan!");

        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus semua gambar yang sudah diupload
            foreach ($uploadedImages as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            \Log::error('Failed to store questions: ' . $e->getMessage());
            return back()
                ->with('error', 'Gagal menyimpan pertanyaan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function editQuestion($game_id, $question_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        $question = $game->questions()->findOrFail($question_id);

        $locationOptions = [
            'Masjid', 'Rumah', 'Sekolah', 'Pasar', 'Kantor', 'Restoran',
            'Taman', 'Perpustakaan', 'Klinik', 'Stasiun', 'Bandara', 'Pelabuhan',
            'Hotel', 'Mall', 'Bioskop', 'Lapangan', 'Kantin', 'Laboratorium',
            'Workshop', 'Kelas', 'Musholla', 'Kamar Mandi', 'Dapur',
            'Kamar Tidur', 'Ruang Tamu', 'Teras', 'Kebun', 'Garasi', 'Ruang Meeting'
        ];

        $options = [];
        if ($question->options) {
            $decodedOptions = json_decode($question->options, true);
            $options = is_array($decodedOptions) ? $decodedOptions : [];
        }

        return view('ustadz.questions.edit', compact('game', 'question', 'locationOptions', 'options'));
    }

    /**
     * Update Question (FLEXIBLE TYPE) - FIXED VERSION
     */
    public function updateQuestion(Request $request, $game_id, $question_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        $question = $game->questions()->findOrFail($question_id);

        $validated = $request->validate([
            'answer_type' => 'required|in:multiple_choice,essay',
            'question_text' => 'required|string',
            'correct_answer' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'location_name' => 'nullable|string|max:255',
            'options' => 'required_if:answer_type,multiple_choice|array',
            'options.*' => 'nullable|string|max:255',
            'remove_image' => 'nullable|boolean'
        ]);

        try {
            $imagePath = $question->image_path;

            // Handle image removal
            if ($request->boolean('remove_image') && $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = null;
            }

            // Handle new image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file('image')->store('questions', 'public');
            }

            // Process options untuk multiple choice
            $options = null;
            if ($validated['answer_type'] === 'multiple_choice' && $request->filled('options')) {
                $filteredOptions = array_filter(
                    $request->options, 
                    fn($value) => !empty(trim($value ?? ''))
                );
                
                if (count($filteredOptions) >= 2) {
                    $options = json_encode(array_values($filteredOptions));
                } else {
                    return back()
                        ->with('error', 'Soal pilihan ganda harus memiliki minimal 2 pilihan jawaban.')
                        ->withInput();
                }
            }

            $question->update([
                'answer_type' => $validated['answer_type'],
                'question_text' => trim($validated['question_text']),
                'correct_answer' => trim($validated['correct_answer']),
                'image_path' => $imagePath,
                'options' => $options,
                'location_name' => !empty($validated['location_name']) 
                    ? trim($validated['location_name']) 
                    : null
            ]);

            return redirect()->route('ustadz.games.questions.index', $game->id)
                ->with('success', 'Pertanyaan berhasil diupdate!');

        } catch (\Exception $e) {
            \Log::error('Failed to update question: ' . $e->getMessage());
            return back()
                ->with('error', 'Gagal mengupdate pertanyaan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Delete question
     */
    public function destroyQuestion($game_id, $question_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        $question = $game->questions()->findOrFail($question_id);

        try {
            // Delete image if exists
            if ($question->image_path && Storage::disk('public')->exists($question->image_path)) {
                Storage::disk('public')->delete($question->image_path);
            }

            $question->delete();

            return redirect()->route('ustadz.games.questions.index', $game->id)
                ->with('success', 'Pertanyaan berhasil dihapus!');

        } catch (\Exception $e) {
            \Log::error('Failed to delete question: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus pertanyaan. Silakan coba lagi.');
        }
    }

    /**
     * View scores untuk semua game ustadz
     */
    public function scores()
    {
        $user = Auth::user();
        $scores = Score::whereHas('game', function($query) use ($user) {
            $query->where('created_by', $user->id);
        })
        ->with(['user', 'game'])
        ->latest()
        ->paginate(15);

        $games = Game::where('created_by', $user->id)->get();

        return view('ustadz.scores.index', compact('scores', 'games'));
    }

    /**
     * View scores untuk game tertentu
     */
    public function gameScores($game_id)
    {
        $game = Game::where('created_by', Auth::id())->findOrFail($game_id);
        $scores = $game->scores()
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('ustadz.scores.game', compact('game', 'scores'));
    }

    /**
     * View detail jawaban santri
     */
    public function scoreDetail($score_id)
    {
        $score = Score::with(['user', 'game', 'answerLogs.question'])
            ->whereHas('game', function($query) {
                $query->where('created_by', Auth::id());
            })
            ->findOrFail($score_id);

        $answerLogs = $score->answerLogs()
            ->with('question')
            ->orderBy('question_id')
            ->get();

        return view('ustadz.scores.detail', compact('score', 'answerLogs'));
    }

    /**
     * Matrix Review - FIXED VERSION
     */
    public function reviewMatrix($game_id)
    {
        $game = Game::where('created_by', Auth::id())
            ->with('questions')
            ->findOrFail($game_id);

        // Ambil santri yang pernah mengerjakan game ini
        $santriList = User::whereHas('scores', function($q) use ($game_id) {
            $q->where('game_id', $game_id);
        })
        ->whereIn('role', ['santri_putra', 'santri_putri'])
        ->orderBy('name')
        ->get();

        // Ambil semua answer logs untuk game ini
        $answerLogsCollection = AnswerLog::where('game_id', $game_id)
            ->whereIn('user_id', $santriList->pluck('id'))
            ->get();

        // Group by kombinasi user_id dan question_id
        $answerLogs = $answerLogsCollection->mapToGroups(function ($item) {
            return [$item->user_id . '-' . $item->question_id => $item];
        });

        return view('ustadz.scores.matrix', compact('game', 'santriList', 'answerLogs'));
    }
}