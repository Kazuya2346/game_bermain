<?php

namespace App\Services;

use App\Models\User;
use App\Models\GameSession;
use App\Models\ListeningQuestion;
use App\Models\LeaderboardEntry;
use App\Enums\GameLevel;
use App\DTOs\GameSessionData;
use App\DTOs\ScoreBreakdown;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ListeningGameService
{
    /**
     * Konfigurasi level game (TANPA 'MASTER')
     */
    private const GAME_CONFIG = [
        'low' => [
            'name' => 'مُبْتَدِئ',
            'type' => 'multiple_choice',
            'base_points' => 10,
            'time_limit' => 20,
            'max_attempts' => 3,
            'question_count' => 10,
        ],
        'medium' => [
            'name' => 'مُتَوَسِّط',
            'type' => 'multiple_choice',
            'base_points' => 20,
            'time_limit' => 30,
            'max_attempts' => 3,
            'question_count' => 10,
        ],
        'hard' => [
            'name' => 'صَعْب',
            'type' => 'multiple_choice', 
            'base_points' => 40,
            'time_limit' => 45,
            'max_attempts' => 3,
            'question_count' => 10,
        ],
    ];

    private const ATTEMPT_MULTIPLIERS = [1 => 2.0, 2 => 1.5, 3 => 1.0];
    private const STREAK_BONUSES = [20 => 100, 10 => 50, 5 => 25, 3 => 10];
    private const SPEED_BONUS_PERCENTAGE = 0.25;
    private const SPEED_THRESHOLD_PERCENTAGE = 0.5;
    private const HARAKAT_BONUS = 5;
    private const HINT_PENALTY = 5;
    private const SESSION_TTL = 3600; // 1 jam

    public function startNewGame(string $level): array
    {
        $this->validateLevel($level);
        $user = Auth::user();
        $config = self::GAME_CONFIG[$level];

        DB::beginTransaction();
        try {
            $questions = $this->getRandomQuestions($level, $config['question_count']);
            if ($questions->isEmpty()) {
                throw new \Exception("Maaf, stok soal untuk level '{$level}' sedang kosong.");
            }

            $sessionData = $this->initializeSession($user, $level, $questions);
            $this->saveSession($user->id, $sessionData);
            DB::commit();

            return [
                'status' => 'started',
                'session' => [
                    'level' => $level,
                    'level_name' => $config['name'],
                    'total_questions' => $questions->count(),
                    'time_limit' => $config['time_limit'],
                ],
                'question' => $this->prepareQuestionData($questions->first(), $level),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getNextQuestion(): array
    {
        $user = Auth::user();
        $session = $this->getSession($user->id);
        
        $session['current_index']++;
        if ($session['current_index'] >= count($session['question_ids'])) {
            return $this->completeGame($user, $session);
        }

        $nextQuestionId = $session['question_ids'][$session['current_index']];
        $session = $this->resetQuestionState($session, $nextQuestionId);
        $this->saveSession($user->id, $session);

        // Tentukan kolom yang diperlukan
        $columnsToSelect = [
            'id', 'level', 'question_text', 'correct_answer', 'answer_type',
            'option_a', 'option_b', 'option_c', 'option_d', 'exp_reward', 'word_count',
            'audio_data', // Sekarang berisi nama file, bukan BLOB
        ];
        
        $question = ListeningQuestion::select($columnsToSelect)
            ->findOrFail($nextQuestionId);
        
        return [
            'status' => 'next_question',
            'progress' => [
                'current' => $session['current_index'] + 1,
                'total' => count($session['question_ids']),
                'percentage' => round(($session['current_index'] + 1) / count($session['question_ids']) * 100),
            ],
            'question' => $this->prepareQuestionData($question, $session['level']),
        ];
    }

    public function submitAnswer($userAnswer, bool $timeUp = false): array
    {
        $user = Auth::user();
        $session = $this->getSession($user->id);

        // Cek jika jawaban "TIME_UP" dari frontend atau time_up flag
        if ($userAnswer === "TIME_UP" || $timeUp) {
            $question = ListeningQuestion::find($session['current_question_id']);
            if (!$question) {
                $question = new ListeningQuestion([
                    'id' => $session['current_question_id'],
                    'question_text' => 'Unknown (Time Up)',
                    'exp_reward' => 0
                ]);
            }
            return $this->handleIncorrectAnswer($user, $session, $question, "TIME_UP", true);
        }
        
        if ($session['attempts_left'] <= 0) {
            return $this->handleNoAttemptsLeft($session);
        }

        $question = ListeningQuestion::findOrFail($session['current_question_id']);
        $isCorrect = $this->validateAnswer($question, $userAnswer);

        if ($isCorrect) {
            return $this->handleCorrectAnswer($user, $session, $question, $userAnswer);
        } else {
            return $this->handleIncorrectAnswer($user, $session, $question, $userAnswer);
        }
    }

    public function getHint(): array
    {
        $user = Auth::user();
        $session = $this->getSession($user->id);
        $question = ListeningQuestion::findOrFail($session['current_question_id']);
        
        $session['used_hint'] = true;
        $this->saveSession($user->id, $session);

        $hint = $this->generateHint($question);
        return [
            'status' => 'success',
            'hint' => $hint,
            'penalty' => self::HINT_PENALTY,
        ];
    }

    public function cancelGame(): array
    {
        $user = Auth::user();
        Cache::forget($this->getSessionKey($user->id));
        
        return [
            'status' => 'cancelled',
            'message' => 'Game berhasil dibatalkan',
        ];
    }

    public function pauseGame(): array
    {
        $user = Auth::user();
        $session = $this->getSession($user->id);
        
        return [
            'status' => 'paused',
            'message' => 'Game berhasil di-pause',
            'session' => [
                'current_index' => $session['current_index'],
                'score' => $session['score'],
                'streak' => $session['current_streak'],
            ]
        ];
    }

    public function resumeGame(): array
    {
        $user = Auth::user();
        $session = $this->getSession($user->id);
        
        // Ambil soal saat ini
        $currentQuestionId = $session['current_question_id'];
        $question = ListeningQuestion::findOrFail($currentQuestionId);
        
        return [
            'status' => 'resumed',
            'message' => 'Game berhasil dilanjutkan',
            'session' => [
                'level' => $session['level'],
                'current_index' => $session['current_index'],
                'total_questions' => count($session['question_ids']),
                'score' => $session['score'],
                'streak' => $session['current_streak'],
            ],
            'question' => $this->prepareQuestionData($question, $session['level']),
        ];
    }

    // ================================================================
    // PRIVATE METHODS - Session Management
    // ================================================================

    private function initializeSession(User $user, string $level, Collection $questions): array
    {
        return [
            'user_id' => $user->id,
            'level' => $level,
            'question_ids' => $questions->pluck('id')->toArray(),
            'current_index' => 0,
            'current_question_id' => $questions->first()->id,
            'attempts_left' => self::GAME_CONFIG[$level]['max_attempts'],
            'used_hint' => false,
            'score' => 0,
            'correct_answers' => 0,
            'current_streak' => 0,
            'max_streak' => 0,
            'start_time' => now()->toISOString(),
            'answers' => [],
            'question_start_time' => now()->toISOString(),
        ];
    }

    private function resetQuestionState(array $session, int $questionId): array
    {
        $session['current_question_id'] = $questionId;
        $session['attempts_left'] = self::GAME_CONFIG[$session['level']]['max_attempts'];
        $session['used_hint'] = false;
        $session['question_start_time'] = now()->toISOString();
        
        return $session;
    }

    private function saveSession(int $userId, array $data): void
    {
        Cache::put($this->getSessionKey($userId), $data, self::SESSION_TTL);
    }

    private function getSession(int $userId): array
    {
        $session = Cache::get($this->getSessionKey($userId));
        
        if (!$session) {
            throw new \Exception('Sesi game tidak ditemukan. Silakan mulai game baru.');
        }
        
        return $session;
    }

    private function getSessionKey(int $userId): string
    {
        return "listening_game_session:{$userId}";
    }

    // ================================================================
    // PRIVATE METHODS - Question & Answer Logic
    // ================================================================

    private function getRandomQuestions(string $level, int $maxCount): Collection
    {
        $allQuestionIds = ListeningQuestion::where('level', $level)->pluck('id');
        
        if ($allQuestionIds->isEmpty()) {
            return collect();
        }
    
        $shuffledIds = $allQuestionIds->shuffle();
        $countToTake = min($shuffledIds->count(), $maxCount);
        $finalQuestionIds = $shuffledIds->take($countToTake)->all();
    
        $columnsToSelect = [
            'id', 'level', 'question_text', 'correct_answer', 'answer_type',
            'option_a', 'option_b', 'option_c', 'option_d', 'exp_reward', 'word_count',
            'audio_data',
        ];
    
        // PERBAIKAN: PostgreSQL tidak mendukung FIELD(). Gunakan CASE untuk mengurutkan ID.
        $orderRaw = "CASE id ";
        foreach ($finalQuestionIds as $index => $id) {
            $orderRaw .= "WHEN {$id} THEN {$index} ";
        }
        $orderRaw .= "END";
    
        return ListeningQuestion::whereIn('id', $finalQuestionIds)
            ->select($columnsToSelect)
            ->orderByRaw($orderRaw)
            ->get();
    }

    /**
     * PERUBAHAN PENTING: Audio URL untuk file-based storage
     * Sekarang audio_data hanya berisi nama file
     */
    private function prepareQuestionData(ListeningQuestion $question, string $level): array
    {
        $config = self::GAME_CONFIG[$level];
        $wordCount = $question->word_count ?? $this->countWords($question->correct_answer);
        
        // Baca tipe soal langsung dari database
        $questionType = $question->answer_type;

        // PERUBAHAN: Gunakan audio_url dari model (sudah di-generate oleh accessor)
        $data = [
            'id' => $question->id,
            'audio_url' => $question->audio_url, // URL lengkap ke file audio
            'question_text' => $question->question_text,
            'type' => $questionType,
            'time_limit' => $config['time_limit'],
            'word_count' => $wordCount,
        ];

        // Add question-specific data based on type
        switch ($questionType) {
            case 'multiple_choice':
                $data['options'] = $this->generateMultipleChoiceOptions($question);
                break;
            case 'drag_drop_word':
                $data['shuffled_items'] = $this->generateDragDropWords($question);
                break;
            case 'drag_drop_letter':
                $data['shuffled_items'] = $this->generateDragDropLetters($question);
                break;
        }

        return $data;
    }

    private function countWords(string $text): int
    {
        $words = preg_split('/\s+/u', trim($text));
        return count(array_filter($words, function($word) {
            return $word !== '';
        }));
    }

    private function generateMultipleChoiceOptions(ListeningQuestion $question): array
    {
        $options = [
            $question->correct_answer,
            $question->option_a,
            $question->option_b,
            $question->option_c,
            $question->option_d, 
        ];
        
        $filteredOptions = array_filter($options, function($value) {
            return $value !== null && $value !== '';
        });

        $uniqueOptions = array_unique($filteredOptions);

        if (!in_array($question->correct_answer, $uniqueOptions)) {
             $uniqueOptions[] = $question->correct_answer;
        }

        shuffle($uniqueOptions);
        
        // Ambil 4
        return array_slice($uniqueOptions, 0, 4);
    }

    private function generateDragDropWords(ListeningQuestion $question): array
    {
        $words = $this->splitToWords($question->correct_answer);
        shuffle($words);
        return $words;
    }

    private function generateDragDropLetters(ListeningQuestion $question): array
    {
        $letters = $this->splitToLetters($question->correct_answer);
        shuffle($letters);
        return $letters;
    }

    private function generateHint(ListeningQuestion $question): array
    {
        $questionType = $question->answer_type;

        switch ($questionType) {
            case 'multiple_choice':
                return [
                    'type' => 'first_letter',
                    'text' => 'Jawaban dimulai dengan: ' . mb_substr($question->correct_answer, 0, 1)
                ];
            case 'drag_drop_word':
                $words = $this->splitToWords($question->correct_answer);
                return [
                    'type' => 'first_word',
                    'text' => 'Kata pertama: ' . ($words[0] ?? '?')
                ];
            case 'drag_drop_letter':
                $letters = $this->splitToLetters($question->correct_answer);
                return [
                    'type' => 'first_letters',
                    'text' => 'Dua huruf pertama: ' . implode('', array_slice($letters, 0, 2))
                ];
            default:
                return [
                    'type' => 'general',
                    'text' => 'Dengarkan audio dengan seksama'
                ];
        }
    }

    private function validateAnswer(ListeningQuestion $question, $userAnswer): bool
    {
        $questionType = $question->answer_type;

        switch ($questionType) {
            case 'multiple_choice':
                return $this->validateMultipleChoice($userAnswer, $question->correct_answer);
            case 'drag_drop_word':
                return $this->validateDragDropWords($userAnswer, $question->correct_answer);
            case 'drag_drop_letter':
                return $this->validateDragDropLetters($userAnswer, $question->correct_answer);
            default:
                return false;
        }
    }

    private function validateMultipleChoice($userAnswer, string $correctAnswer): bool
    {
        return is_string($userAnswer) && trim($userAnswer) === trim($correctAnswer);
    }

    private function validateDragDropWords($userAnswer, string $correctAnswer): bool
    {
        if (!is_array($userAnswer)) {
            return false;
        }
        
        $userAnswerString = implode(' ', $userAnswer);
        $correctWords = $this->splitToWords($correctAnswer);
        $correctAnswerString = implode(' ', $correctWords);
        
        return trim($userAnswerString) === trim($correctAnswerString);
    }

    private function validateDragDropLetters($userAnswer, string $correctAnswer): bool
    {
        if (!is_array($userAnswer)) {
            return false;
        }

        $userAnswerString = implode('', $userAnswer);
        $correctLetters = $this->splitToLetters($correctAnswer);
        $correctAnswerString = implode('', $correctLetters);
        
        return trim($userAnswerString) === trim($correctAnswerString);
    }

    // ================================================================
    // PRIVATE METHODS - Answer Handling & Scoring
    // ================================================================

    private function handleCorrectAnswer(User $user, array $session, ListeningQuestion $question, $userAnswer): array
    {
        $timeElapsed = $this->calculateTimeElapsed($session['question_start_time'] ?? now()->toISOString());
        $session['attempts_left']--; 
        $session['correct_answers']++;
        $session['current_streak']++;
        $session['max_streak'] = max($session['max_streak'], $session['current_streak']);
        
        $attemptNumber = self::GAME_CONFIG[$session['level']]['max_attempts'] - $session['attempts_left'];

        $scoreData = $this->calculateScore(
            $session['level'],
            $attemptNumber, 
            $timeElapsed,
            $session['current_streak'],
            $session['used_hint'] ?? false
        );

        $session['score'] += $scoreData['points'];

        $this->saveGameSession($user, $session, $question, $userAnswer, true, $timeElapsed, $scoreData);
        $this->saveSession($user->id, $session);

        return [
            'status' => 'correct',
            'message' => 'Jawaban benar! 🎉',
            'score' => $scoreData, 
            'breakdown' => $scoreData['breakdown'], 
            'attempts_left' => $session['attempts_left'],
            'correct_answer' => $this->getCorrectAnswerDisplay($question, $session['level']),
            'progress' => [
                'current' => $session['current_index'] + 1,
                'total' => count($session['question_ids']),
            ],
            'total_score' => $session['score'],
            'streak' => $session['current_streak'],
        ];
    }

    private function handleIncorrectAnswer(User $user, array $session, ListeningQuestion $question, $userAnswer, bool $isTimeUp = false): array
    {
        $session['attempts_left']--;
        $session['current_streak'] = 0;
        
        $timeElapsed = $isTimeUp ? 0 : $this->calculateTimeElapsed($session['question_start_time'] ?? now()->toISOString());
        
        $this->saveGameSession($user, $session, $question, $userAnswer, false, $timeElapsed);

        if ($session['attempts_left'] > 0 && !$isTimeUp) { 
            $this->saveSession($user->id, $session);
            
            return [
                'status' => 'incorrect',
                'message' => 'Jawaban salah. Coba lagi!',
                'attempts_left' => $session['attempts_left'],
                'streak' => $session['current_streak'],
                'total_score' => $session['score'],
            ];
        }

        // No attempts left or time is up
        $this->saveSession($user->id, $session);
        
        return [
            'status' => 'no_attempts',
            'message' => $isTimeUp ? 'Waktu Habis!' : 'Kesempatan habis. Lanjut ke soal berikutnya.',
            'correct_answer' => $this->getCorrectAnswerDisplay($question, $session['level']),
            'streak' => $session['current_streak'],
            'attempts_left' => 0,
            'total_score' => $session['score'],
        ];
    }

    private function handleNoAttemptsLeft(array $session): array
    {
        return [
            'status' => 'no_attempts',
            'message' => 'Tidak ada kesempatan lagi untuk soal ini.',
        ];
    }

    private function calculateScore(string $level, int $attemptNumber, int $timeElapsed, int $currentStreak, bool $usedHint): array
    {
        $config = self::GAME_CONFIG[$level];
        $basePoints = $config['base_points'];
        
        $breakdown = [];
        $totalPoints = 0; 

        $multiplier = self::ATTEMPT_MULTIPLIERS[$attemptNumber] ?? 1.0;
        
        $attemptPoints = $basePoints * $multiplier;
        $breakdown['base_points'] = $basePoints;
        $breakdown['attempt_bonus'] = $attemptPoints - $basePoints; 
        $totalPoints += $attemptPoints;

        $speedBonus = $this->calculateSpeedBonus($timeElapsed, $config['time_limit'], $basePoints);
        if ($speedBonus > 0) {
            $breakdown['speed_bonus'] = $speedBonus;
            $totalPoints += $speedBonus;
        }

        $streakBonus = $this->calculateStreakBonus($currentStreak);
        if ($streakBonus > 0) {
            $breakdown['streak_bonus'] = $streakBonus;
            $totalPoints += $streakBonus;
        }

        if ($usedHint) {
            $hintPenalty = self::HINT_PENALTY;
            $breakdown['hint_penalty'] = -$hintPenalty;
            $totalPoints -= $hintPenalty;
        }

        $finalPoints = max(5, (int) round($totalPoints)); 
        $breakdown['total'] = $finalPoints;

        return [
            'points' => $finalPoints,
            'breakdown' => $breakdown,
        ];
    }

    private function calculateSpeedBonus(int $timeElapsed, int $timeLimit, int $basePoints): int
    {
        if ($timeLimit <= 0) return 0;
        
        $timeRatio = $timeElapsed / $timeLimit;
        if ($timeRatio <= self::SPEED_THRESHOLD_PERCENTAGE) {
            return (int) round($basePoints * self::SPEED_BONUS_PERCENTAGE);
        }
        return 0;
    }

    private function calculateStreakBonus(int $streak): int
    {
        // Langsung cek dari terbesar ke terkecil
        if ($streak >= 20) return 100;
        if ($streak >= 10) return 50;
        if ($streak >= 5) return 25;
        if ($streak >= 3) return 10;
        
        return 0;
    }

    // ================================================================
    // PRIVATE METHODS - Utilities
    // ================================================================

    private function calculateTimeElapsed(string $startTime): int
    {
        return now()->diffInSeconds(\Carbon\Carbon::parse($startTime));
    }

    private function splitToWords(string $text): array
    {
        $words = preg_split('/\s+/u', trim($text));
        return array_filter($words, function($word) {
            return $word !== '';
        });
    }

    private function splitToLetters(string $text): array
    {
        $textWithoutSpaces = preg_replace('/\s+/u', '', $text);
        $letters = preg_split('//u', $textWithoutSpaces, -1, PREG_SPLIT_NO_EMPTY);
        return array_filter($letters, function($letter) {
            return $letter !== '';
        });
    }

    private function getCorrectAnswerDisplay(ListeningQuestion $question, string $level): string|array
    {
        $questionType = $question->answer_type;

        switch ($questionType) {
            case 'multiple_choice':
                return $question->correct_answer;
            case 'drag_drop_word':
                return $this->splitToWords($question->correct_answer);
            case 'drag_drop_letter':
                return $this->splitToLetters($question->correct_answer);
            default:
                return $question->correct_answer;
        }
    }

    private function validateLevel(string $level): void
    {
        if (!array_key_exists($level, self::GAME_CONFIG)) {
            throw new \InvalidArgumentException('Level permainan tidak valid.');
        }
    }

    private function saveGameSession(User $user, array $session, ListeningQuestion $question, $userAnswer, bool $isCorrect, int $timeElapsed, ?array $scoreData = null): void
    {
        $expEarned = $isCorrect ? ($question->exp_reward ?? 10) : 0;
        
        // Perbaikan: Cek jika $session['level'] ada, jika tidak, gunakan $question->level
        $level = $session['level'] ?? $question->level;
        $maxAttempts = self::GAME_CONFIG[$level]['max_attempts'] ?? 3;
        
        $attemptNumber = $maxAttempts - $session['attempts_left'];

        GameSession::create([
            'user_id'           => $user->id,
            'questionable_id'   => $question->id,
            'questionable_type' => \App\Models\ListeningQuestion::class,
            'level_type'        => $level, 
            'question_text'     => $question->question_text,
            'user_answer'       => is_array($userAnswer) ? implode(' ', $userAnswer) : $userAnswer, 
            'is_correct'        => $isCorrect, // PostgreSQL akan menerima boolean langsung
            'attempts'          => $attemptNumber,
            'time_taken'        => $timeElapsed,
            'points_earned'     => $scoreData['points'] ?? 0,
            'exp_earned'        => $expEarned,
            'used_hint'         => $session['used_hint'] ?? false, // Boolean untuk PostgreSQL
            'streak_at_time'    => $session['current_streak'] ?? 0,
        ]);
    }

    private function completeGame(User $user, array $session): array
    {
        $this->updateUserStatistics($user, $session);
        
        // Increment total accumulated points
        $user->increment('total_accumulated_points', $session['score']);
        
        $this->updateLeaderboard($user);
        
        $updatedUser = $user->fresh();
        
        $totalExpGained = GameSession::where('user_id', $user->id)
            ->whereIn('questionable_id', $session['question_ids'])
            ->where('questionable_type', \App\Models\ListeningQuestion::class)
            ->sum('exp_earned');

        $levelInfo = \App\Helpers\LevelSystem::getLevelInfo($updatedUser->experience_points ?? 0);
        $oldLevelInfo = \App\Helpers\LevelSystem::getLevelInfo(($updatedUser->experience_points ?? 0) - $totalExpGained);
        
        // PERUBAHAN: Gunakan perbandingan boolean yang benar untuk PostgreSQL
        $levelUp = $levelInfo['level'] > $oldLevelInfo['level'];

        $summary = [
            'level_name' => self::GAME_CONFIG[$session['level']]['name'] ?? $session['level'],
            'total_score' => $session['score'],
            'correct_answers' => $session['correct_answers'],
            'total_questions' => count($session['question_ids']),
            'accuracy' => $this->calculateAccuracy($session),
            'max_streak' => $session['max_streak'],
        ];

        $rewards = [
            'points' => $session['score'],
            'exp' => $totalExpGained,
            'new_level' => $levelInfo['level'],
            // PERUBAHAN: Kirim boolean langsung, bukan integer
            'level_up' => $levelUp
        ];
        
        Cache::forget($this->getSessionKey($user->id));

        return [
            'status' => 'completed',
            'summary' => $summary,
            'rewards' => $rewards,
        ];
    }

    private function updateUserStatistics(User $user, array $session): void
    {
        $user->refresh();

        $sessionStats = GameSession::where('user_id', $user->id)
            ->whereIn('questionable_id', $session['question_ids'])
            ->where('questionable_type', \App\Models\ListeningQuestion::class)
            ->selectRaw('SUM(exp_earned) as total_exp, COUNT(id) as total_questions')
            ->first();

        $user->total_score = ($user->total_score ?? 0) + $session['score'];
        $user->experience_points = ($user->experience_points ?? 0) + ($sessionStats->total_exp ?? 0);
        
        // Kolom ini ADA di migrasi
        $user->total_questions = ($user->total_questions ?? 0) + ($sessionStats->total_questions ?? 0);
        $user->correct_answers = ($user->correct_answers ?? 0) + $session['correct_answers'];
        
        $user->last_played = now(); 

        if ($session['max_streak'] > ($user->longest_streak ?? 0)) {
            $user->longest_streak = $session['max_streak'];
        }
        
        $user->current_streak = \App\Models\GameSession::calculateCurrentStreak($user->id);
        
        $user->save();
    }

    private function updateLeaderboard(User $user): void
    {
        $freshUser = $user->fresh();
        DB::table('leaderboard')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'total_points' => $freshUser->total_score,
                'total_exp' => $freshUser->experience_points,
                'last_updated' => now(),
            ]
        );
    }

    private function calculateAccuracy(array $session): float
    {
        if (count($session['question_ids']) === 0) {
            return 0.0;
        }
        
        return round(($session['correct_answers'] / count($session['question_ids'])) * 100, 2);
    }
}