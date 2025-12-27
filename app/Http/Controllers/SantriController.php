<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Question;
use App\Models\Score;
use App\Models\AnswerLog;
use App\Models\SurvivalHighScore;
use App\Models\GameSession;
use App\Models\ListeningQuestion;
use App\Helpers\LevelSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SantriController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        /** @var \App\Models\User $user */

        $levelInfo = LevelSystem::getLevelInfo($user->experience_points ?? 0);
        $badge = LevelSystem::getBadge($user->total_games_completed ?? 0);
        $nextBadge = LevelSystem::getNextBadgeRequirement($user->total_games_completed ?? 0);
        
        $recentScores = Score::where('user_id', $user->id)
            ->with('game')
            ->orderBy('completed_at', 'desc')
            ->take(5)
            ->get();
        
        $totalGames = Game::where('status', 'published')->count();
        $averageScore = Score::where('user_id', $user->id)->count() > 0
            ? Score::where('user_id', $user->id)->avg(DB::raw('(correct_answers / total_questions) * 100'))
            : 0;
        
        return view('santri.dashboard', compact(
            'user', 'levelInfo', 'badge', 'nextBadge', 
            'recentScores', 'totalGames', 'averageScore'
        ));
    }
 
    public function games()
    {
        $user = Auth::user();
        /** @var \App\Models\User $user */
        
        // Ambil game-game biasa yang dibuat Ustadz
        $games = Game::where('status', 'published')
            ->where('type', '!=', 'survival')
            ->where('type', '!=', 'sentence_builder')
            ->withCount('questions')
            ->get();
        
        foreach ($games as $game) {
            $game->completed = Score::where('user_id', $user->id)
                ->where('game_id', $game->id)
                ->exists();
            
            $game->best_score = Score::where('user_id', $user->id)
                ->where('game_id', $game->id)
                ->max('score');
        }
        
        // Ambil game Sentence Builder
        $sentenceBuilderGame = Game::where('type', 'sentence_builder')->first();

        // TAMBAHAN: Ambil data game Listening Comprehension
        $listeningComprehensionGame = (object) [
            'id' => 'listening-comprehension', // ID unik untuk routing
            'title' => 'Mendengarkan dan Bermain',
            'description' => 'Dengarkan dan pilih arti kalimat yang benar!',
            'type' => 'listening_comprehension',
            'completed' => true, // Selalu tampilkan, karena tidak ada skornya di tabel `scores`
        ];

        return view('santri.games.index', compact('games', 'sentenceBuilderGame', 'listeningComprehensionGame'));
    }

    public function playGame($id)
    {
        $game = Game::where('status', 'published')
            ->with('questions')
            ->findOrFail($id);
        
        if ($game->questions->count() == 0) {
            return redirect()->route('santri.games.index')
                ->with('error', 'Game ini belum memiliki soal.');
        }
        
        $questions = $game->questions->shuffle();
        return view('santri.games.play', compact('game', 'questions'));
    }

    public function submitGame(Request $request, $id)
    {
        try {
            $game = Game::where('status', 'published')
                ->with('questions')
                ->findOrFail($id);
            $user = Auth::user();
            /** @var \App\Models\User $user */
            
            $answers = $request->input('answers', []);
            $correctAnswers = 0;
            $totalQuestions = $game->questions->count();
            
            if ($totalQuestions == 0) {
                return redirect()->route('santri.games.index')
                    ->with('error', 'Game tidak memiliki soal.');
            }
            
            foreach ($game->questions as $question) {
                $userAnswer = $answers[$question->id] ?? null;
                if ($userAnswer && strtolower(trim($userAnswer)) == strtolower(trim($question->correct_answer))) {
                    $correctAnswers++;
                }
            }
            
            $scorePercentage = round(($correctAnswers / $totalQuestions) * 100, 2);
            $xpEarned = LevelSystem::calculateXP($correctAnswers, $totalQuestions);

            $isFirstTime = !Score::where('user_id', $user->id)
                                ->where('game_id', $game->id)
                                ->exists();
            
            // Hitung skor mentah (jawaban benar x 10)
            $rawPoints = $correctAnswers * 10;
            
            $user->experience_points = ($user->experience_points ?? 0) + $xpEarned;
            $user->total_score = ($user->total_score ?? 0) + $scorePercentage;
            
            if ($isFirstTime) {
                $user->total_games_completed = ($user->total_games_completed ?? 0) + 1;
            }
            
            $levelInfo = LevelSystem::getLevelInfo($user->experience_points);
            $user->level = $levelInfo['level'];
            $user->save();
            
            // Increment total accumulated points SETELAH save()
            $user->increment('total_accumulated_points', $rawPoints);
            
            $score = Score::create([
                'user_id' => $user->id,
                'game_id' => $game->id,
                'score' => $scorePercentage,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'completed_at' => now()
            ]);
            
            foreach ($game->questions as $question) {
                $userAnswer = $answers[$question->id] ?? '';
                $isCorrect = strtolower(trim($userAnswer)) == strtolower(trim($question->correct_answer));
                
                AnswerLog::create([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'score_id' => $score->id,
                    'question_id' => $question->id,
                    'user_answer' => $userAnswer,
                    'correct_answer' => $question->correct_answer,
                    'is_correct' => $isCorrect
                ]);
            }
            
            return redirect()->route('santri.games.result', $game->id)
                ->with([
                    'scoreValue' => $scorePercentage,
                    'correctAnswers' => $correctAnswers,
                    'totalQuestions' => $totalQuestions,
                    'xpEarned' => $xpEarned,
                    'newLevel' => $levelInfo['level'],
                    'levelName' => $levelInfo['name']
                ]);
                
        } catch (\Exception $e) {
            return redirect()->route('santri.games.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function gameResult($id)
    {
        $game = Game::where('status', 'published')->findOrFail($id);
        $user = Auth::user();
        /** @var \App\Models\User $user */
        
        $scoreValue = session('scoreValue', 0);
        $correctAnswers = session('correctAnswers', 0);
        $totalQuestions = session('totalQuestions', 1);
        $xpEarned = session('xpEarned', 0);
        $newLevel = session('newLevel', $user->level ?? 1);
        $levelName = session('levelName', 'Pemula');
        
        $levelInfo = LevelSystem::getLevelInfo($user->experience_points ?? 0);
        $badge = LevelSystem::getBadge($user->total_games_completed ?? 0);
        
        return view('santri.games.result', compact(
            'game', 'scoreValue', 'correctAnswers', 'totalQuestions',
            'xpEarned', 'newLevel', 'levelName', 'levelInfo', 'badge'
        ));
    }

    public function scores()
    {
        $user = Auth::user();
        /** @var \App\Models\User $user */
        
        // ✅ GABUNGKAN: Score dari tabel `scores` + GameSession dari tabel `game_sessions`
        $scores = Score::where('user_id', $user->id)
            ->with('game')
            ->orderBy('completed_at', 'desc')
            ->get()
            ->map(function($score) {
                return [
                    'type' => 'regular',
                    'game_title' => $score->game->title ?? 'Unknown Game',
                    'score_percentage' => $score->score,
                    'correct_answers' => $score->correct_answers,
                    'total_questions' => $score->total_questions,
                    'completed_at' => $score->completed_at,
                ];
            });
        
        // ✅ TAMBAH: Ambil data Listening Game dari tabel `game_sessions`
        $listeningSessions = GameSession::where('user_id', $user->id)
            ->where('questionable_type', ListeningQuestion::class)
            ->select(
                DB::raw('DATE(created_at) as session_date'),
                DB::raw('SUM(points_earned) as total_points'),
                DB::raw('SUM(CASE WHEN is_correct = true THEN 1 ELSE 0 END) as correct_answers'),
                DB::raw('COUNT(*) as total_questions')
            )
            ->groupBy('session_date')
            ->orderBy('session_date', 'desc')
            ->get()
            ->map(function($session) {
                $scorePercentage = $session->total_questions > 0 
                    ? round(($session->correct_answers / $session->total_questions) * 100, 2) 
                    : 0;
                
                return [
                    'type' => 'listening',
                    'game_title' => 'Listening Game',
                    'score_percentage' => $scorePercentage,
                    'correct_answers' => $session->correct_answers,
                    'total_questions' => $session->total_questions,
                    'completed_at' => \Carbon\Carbon::parse($session->session_date),
                ];
            });
        
        // ✅ GABUNGKAN & SORT by date
        $allScores = $scores->concat($listeningSessions)
            ->sortByDesc('completed_at')
            ->values();
        
        // ✅ PAGINATE manual (karena sudah di-merge)
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $paginatedScores = new \Illuminate\Pagination\LengthAwarePaginator(
            $allScores->forPage($currentPage, $perPage),
            $allScores->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        $survivalHighScore = SurvivalHighScore::where('user_id', $user->id)->first();
        
        // ✅ HITUNG statistik (gabungan)
        $totalGamesPlayed = $allScores->count();
        $averageScore = $allScores->count() > 0
            ? $allScores->avg('score_percentage')
            : 0;
        $bestScore = $allScores->max('score_percentage') ?? 0;
        
        return view('santri.scores.index', compact(
            'paginatedScores',
            'totalGamesPlayed', 
            'averageScore', 
            'bestScore',
            'survivalHighScore'
        ));
    }

    /**
     * Menampilkan halaman profile santri dengan data yang lengkap
     */
    public function profile()
    {
        $user = Auth::user();
        /** @var \App\Models\User $user */
        
        // Hitung total games completed berdasarkan scores
        $totalGamesCompleted = Score::where('user_id', $user->id)->count();
        
        // Hitung current badge berdasarkan total games completed
        $currentBadge = $this->calculateBadge($totalGamesCompleted);
        
        // Siapkan data user untuk view dengan semua field yang diperlukan
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'class_id' => $user->class_id,
            'profile_photo' => $user->profile_photo,
            'level' => $user->level ?? 1,
            'experience_points' => $user->experience_points ?? 0,
            'total_games_completed' => $totalGamesCompleted,
            'current_badge' => $currentBadge
        ];

        // Ambil recent scores untuk aktivitas terakhir
        $recentScores = Score::where('user_id', $user->id)
            ->with('game')
            ->orderBy('completed_at', 'desc')
            ->take(5)
            ->get();

        return view('santri.profile', [
            'user' => (object)$userData, // Convert array to object untuk kompatibilitas dengan view
            'recentScores' => $recentScores
        ]);
    }

    /**
     * Calculate badge based on total games completed
     */
    private function calculateBadge($totalGames)
    {
        if ($totalGames >= 100) return 'diamond';
        if ($totalGames >= 50) return 'gold';
        if ($totalGames >= 25) return 'silver';
        if ($totalGames >= 10) return 'bronze';
        return 'none';
    }

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $user = Auth::user();
            /** @var \App\Models\User $user */

            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
            $user->save();

            return redirect()->route('santri.profile')
                ->with('success', 'Foto profil berhasil diupdate!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }

    public function deleteProfilePhoto()
    {
        try {
            $user = Auth::user();
            /** @var \App\Models\User $user */

            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->profile_photo = null;
            $user->save();

            return redirect()->route('santri.profile')
                ->with('success', 'Foto profil berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }

    public function leaderboard()
    {
        $topPutra = User::where('role', 'santri_putra')
            ->orderBy('experience_points', 'DESC')
            ->take(10)
            ->get();

        $topPutri = User::where('role', 'santri_putri')
            ->orderBy('experience_points', 'DESC')
            ->take(10)
            ->get();
            
        $currentUser = Auth::user();
        /** @var \App\Models\User $currentUser */

        $topOverall = User::whereIn('role', ['santri_putra', 'santri_putri'])
            ->orderBy('experience_points', 'DESC')
            ->take(5)
            ->get();

        return view('santri.leaderboard.index', compact(
            'topPutra', 
            'topPutri', 
            'topOverall',
            'currentUser'
        ));
    }

    // ============================================
    // SURVIVAL QUIZ METHODS
    // ============================================

    public function survivalGamePlay()
    {
        $questions = Question::where('category', 'survival')
            ->inRandomOrder()
            ->get()
            ->map(function ($q) {
                return [
                    'id' => $q->id,
                    'question_text' => $q->question_text,
                    'options' => json_decode($q->options),
                    'correct_answer' => $q->correct_answer,
                ];
            });

        if ($questions->count() == 0) {
            return redirect()->route('santri.dashboard')
                ->with('error', 'Belum ada soal Survival Quiz tersedia.');
        }

        $highScore = SurvivalHighScore::where('user_id', auth()->id())->first();

        return view('santri.survival.play', [
            'questions' => $questions,
            'highScore' => $highScore ? $highScore->score : 0,
        ]);
    }

    public function survivalGameSubmit(Request $request)
    {
        $request->validate([
            'score' => 'required|integer|min:0',
            'total_questions' => 'required|integer|min:1',
            'correct_answers' => 'required|integer|min:0',
        ]);
        
        $userId = auth()->id();
        $user = auth()->user();
        /** @var \App\Models\User $user */
        
        $correctAnswers = $request->correct_answers;
        $totalQuestions = $request->total_questions;
        $newScore = $request->score;
        
        $existingHighScore = SurvivalHighScore::where('user_id', $userId)->first();
        $isNewRecord = false;
        
        if (!$existingHighScore || $newScore > $existingHighScore->score) {
            SurvivalHighScore::updateOrCreate(
                ['user_id' => $userId],
                ['score' => $newScore]
            );
            $isNewRecord = true;
        }
        
        $xpEarned = LevelSystem::calculateXP($correctAnswers, $totalQuestions);
        
        $user->experience_points = ($user->experience_points ?? 0) + $xpEarned;
        $user->total_score = ($user->total_score ?? 0) + $newScore;
        
        $levelInfo = LevelSystem::getLevelInfo($user->experience_points);
        $user->level = $levelInfo['level'];
        $user->save();
        
        // Increment total accumulated points SETELAH save()
        $user->increment('total_accumulated_points', $newScore);
        
        $survivalGame = Game::where('type', 'survival')->first();
        if ($survivalGame) {
            $scorePercentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

            Score::create([
                'user_id' => $user->id,
                'game_id' => $survivalGame->id,
                'score' => $scorePercentage,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'completed_at' => now()
            ]);
        }
        
        $finalHighScore = SurvivalHighScore::where('user_id', $userId)->first();
        
        return response()->json([
            'success' => true,
            'current_score' => $newScore,
            'high_score' => $finalHighScore->score,
            'is_new_record' => $isNewRecord,
            'xp_earned' => $xpEarned,
            'new_level' => $levelInfo['level'],
            'level_name' => $levelInfo['name'],
            'total_xp' => $user->experience_points,
        ]);
    }

    // ============================================
    // SENTENCE BUILDER METHODS (FIXED VERSION)
    // ============================================

    /**
     * Halaman permainan Sentence Builder
     */
    public function playSentenceBuilder()
    {
        $game = Game::where('type', 'sentence_builder')->firstOrFail();
        
        $questions = Question::where('category', 'sentence_builder')
            ->inRandomOrder()
            ->get()
            ->map(function ($q) {
                $scrambledWords = json_decode($q->options);

                if (!is_array($scrambledWords)) {
                    $scrambledWords = [];
                }

                return [
                    'correct' => $q->question_text,
                    'scrambled' => $scrambledWords,
                    'translation' => $q->correct_answer,
                ];
            });

        return view('santri.sentence-builder.play', [
            'game' => $game,
            'questions' => $questions,
        ]);
    }

    /**
     * Submit jawaban Sentence Builder & simpan skor
     */
    public function submitSentenceBuilder(Request $request)
    {
        try {
            // Validasi data yang dikirim dari JavaScript
            $request->validate([
                'score' => 'required|integer|min:0',
                'correct_answers' => 'required|integer|min:0',
                'total_questions' => 'required|integer|min:0',
            ]);

            $user = auth()->user();
            /** @var \App\Models\User $user */
            
            $score = $request->score; // Skor mentah (misal: 20, 40, 60, dst)
            $correctAnswers = $request->correct_answers;
            $totalQuestions = $request->total_questions;
            
            // Hitung skor persentase untuk konsistensi dengan game lain
            $scorePercentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;
            
            // Hitung XP berdasarkan jawaban benar
            $xpEarned = LevelSystem::calculateXP($correctAnswers, $totalQuestions);
            
            // Update user XP & level
            $user->experience_points = ($user->experience_points ?? 0) + $xpEarned;
            $user->total_score = ($user->total_score ?? 0) + $score;
            
            $levelInfo = LevelSystem::getLevelInfo($user->experience_points);
            $user->level = $levelInfo['level'];
            $user->save();
            
            // Increment total accumulated points SETELAH save()
            $user->increment('total_accumulated_points', $score);
            
            // Simpan ke tabel scores (dengan game dummy sentence_builder)
            $sentenceBuilderGame = Game::where('type', 'sentence_builder')->first();
            
            if ($sentenceBuilderGame) {
                Score::create([
                    'user_id' => $user->id,
                    'game_id' => $sentenceBuilderGame->id,
                    'score' => $scorePercentage,
                    'total_questions' => $totalQuestions,
                    'correct_answers' => $correctAnswers,
                    'completed_at' => now()
                ]);
            }
            
           
            session([
                'sentence_builder_score' => $score,
                'sentence_builder_correct' => $correctAnswers,
                'sentence_builder_total' => $totalQuestions,
                'sentence_builder_xp' => $xpEarned,
                'sentence_builder_level' => $levelInfo['level'],
                'sentence_builder_level_name' => $levelInfo['name'],
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Hasil berhasil disimpan!',
                'data' => [
                    'score' => $score,
                    'correct_answers' => $correctAnswers,
                    'total_questions' => $totalQuestions,
                    'xp_earned' => $xpEarned,
                    'new_level' => $levelInfo['level'],
                    'level_name' => $levelInfo['name'],
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Sentence Builder Submit Error: ' . $e->getMessage());
            \Log::error('Request data: ' . json_encode($request->all()));
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan halaman hasil Sentence Builder
     */
    public function resultSentenceBuilder()
    {
        $user = auth()->user();
        /** @var \App\Models\User $user */
        
        // Ambil data dari session
        $scoreValue = session('sentence_builder_score', 0);
        $correctAnswers = session('sentence_builder_correct', 0);
        $totalQuestions = session('sentence_builder_total', 0);
        $xpEarned = session('sentence_builder_xp', 0);

        $newLevel = session('sentence_builder_level', $user->level ?? 1);
        $levelName = session('sentence_builder_level_name', 'Pemula');
        
        // Redirect jika tidak ada data session
        if (!session()->has('sentence_builder_score')) {
            return redirect()->route('santri.games.index')
                ->with('error', 'Data hasil tidak ditemukan.');
        }
        
        $levelInfo = LevelSystem::getLevelInfo($user->experience_points ?? 0);
        $badge = LevelSystem::getBadge($user->total_games_completed ?? 0);
        
        return view('santri.sentence-builder.result', compact(
            'scoreValue', 'correctAnswers', 'totalQuestions',
            'xpEarned', 'newLevel', 'levelName', 'levelInfo', 'badge'
        ));
    }
}