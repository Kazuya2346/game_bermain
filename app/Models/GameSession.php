<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

/**
 * Model untuk Game Session (Updated - Compatible dengan Migration Existing)
 */
class GameSession extends Model
{
    use HasFactory;

    protected $table = 'game_sessions';

    /**
     * Nonaktifkan updated_at karena hanya menggunakan created_at
     */
    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'questionable_id', 
        'questionable_type',
        'level_type',
        'question_text',
        'user_answer',
        'is_correct',
        'attempts',
        'time_taken',
        'points_earned',
        'exp_earned',
        'used_hint',
        'streak_at_time',
    ];

    /**
     * Kosongkan appends - panggil manual saja untuk hindari overhead
     */
    protected $appends = [];

    protected $casts = [
        'user_id' => 'integer',
        'questionable_id' => 'integer',
        'is_correct' => 'boolean',
        'used_hint' => 'boolean',
        'attempts' => 'integer',
        'time_taken' => 'integer',
        'points_earned' => 'integer',
        'exp_earned' => 'integer',
        'streak_at_time' => 'integer',
        'created_at' => 'datetime',
    ];

    // ==================== CONSTANTS ====================
    public const LEVEL_LOW = 'low';
    public const LEVEL_MEDIUM = 'medium';
    public const LEVEL_HARD = 'hard';
    public const LEVEL_OTHER = 'other';

    public const RATING_EXCELLENT = 'excellent';
    public const RATING_GOOD = 'good';
    public const RATING_AVERAGE = 'average';
    public const RATING_POOR = 'poor';

    // ==================== RELATIONSHIPS ====================
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questionable(): MorphTo
    {
        return $this->morphTo();
    }

    // ==================== ACCESSORS ====================
    public function getAccuracyLabelAttribute(): string
    {
        if ($this->is_correct) {
            return $this->attempts === 1 ? 'Perfect' : 'Correct';
        }
        return 'Wrong';
    }

    public function getPerformanceRatingAttribute(): string
    {
        if (!$this->is_correct) {
            return self::RATING_POOR;
        }

        $score = 0;
        $timeLimit = $this->getTimeLimitForLevel();

        // Perfect answer (1 attempt)
        if ($this->attempts === 1) {
            $score += 40;
        } elseif ($this->attempts === 2) {
            $score += 20;
        }

        // Time efficiency
        if ($this->time_taken && $timeLimit) {
            $timeRatio = $this->time_taken / $timeLimit;
            
            if ($timeRatio <= 0.3) {
                $score += 30;
            } elseif ($timeRatio <= 0.6) {
                $score += 20;
            } elseif ($timeRatio <= 1.0) {
                $score += 10;
            }
        } else {
            $score += 15;
        }

        // Hint penalty
        if (!$this->used_hint) {
            $score += 30;
        }

        // Level difficulty bonus
        $levelBonus = match($this->level_type) {
            self::LEVEL_HARD => 10,
            self::LEVEL_MEDIUM => 5,
            default => 0,
        };
        $score += $levelBonus;

        return match (true) {
            $score >= 85 => self::RATING_EXCELLENT,
            $score >= 60 => self::RATING_GOOD,
            $score >= 40 => self::RATING_AVERAGE,
            default => self::RATING_POOR,
        };
    }

    public function getTimeTakenFormattedAttribute(): string
    {
        if (!$this->time_taken) {
            return 'N/A';
        }

        $minutes = floor($this->time_taken / 60);
        $seconds = $this->time_taken % 60;

        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }

        return "{$seconds}s";
    }

    public function getLevelLabelAttribute(): string
    {
        return match($this->level_type) {
            self::LEVEL_LOW => 'Mudah',
            self::LEVEL_MEDIUM => 'Sedang',
            self::LEVEL_HARD => 'Sulit',
            self::LEVEL_OTHER => 'Lainnya',
            default => ucfirst($this->level_type),
        };
    }

    // ==================== METHODS ====================
    public function isListeningQuestion(): bool
    {
        return $this->questionable_type === \App\Models\ListeningQuestion::class;
    }

    public function isRegularQuestion(): bool
    {
        return $this->questionable_type === \App\Models\Question::class;
    }

    public function getPerformanceDetails(): array
    {
        $timeLimit = $this->getTimeLimitForLevel();
        
        return [
            'is_correct' => $this->is_correct,
            'attempts' => $this->attempts,
            'time_taken' => $this->time_taken,
            'time_formatted' => $this->time_taken_formatted,
            'time_efficiency' => $timeLimit ? $this->calculateTimeEfficiency($timeLimit) : null,
            'used_hint' => $this->used_hint,
            'points_earned' => $this->points_earned,
            'exp_earned' => $this->exp_earned,
            'streak' => $this->streak_at_time,
            'rating' => $this->performance_rating,
            'accuracy' => $this->accuracy_label,
            'level_difficulty' => $this->level_type,
            'level_label' => $this->level_label,
        ];
    }

    public function calculateTimeEfficiency(?int $timeLimit = null): ?float
    {
        if (!$this->time_taken) {
            return null;
        }

        $limit = $timeLimit ?: $this->getTimeLimitForLevel();
        if (!$limit || $limit <= 0) {
            return null;
        }

        $efficiency = ($limit / $this->time_taken) * 100;
        return min(150, max(0, round($efficiency, 2)));
    }

    /**
     * ====================================================================
     * PERBAIKAN BUG #2: Menyamakan Timer dengan Service
     * ====================================================================
     */
    private function getTimeLimitForLevel(): ?int
    {
        return match($this->level_type) {
            self::LEVEL_LOW => 20,    // DIPERBAIKI (sebelumnya 30)
            self::LEVEL_MEDIUM => 30, // DIPERBAIKI (sebelumnya 45)
            self::LEVEL_HARD => 45,   // DIPERBAIKI (sebelumnya 60)
            default => 30,            // Diubah ke default yang lebih masuk akal
        };
    }

    // ==================== SCOPES ====================
    public function scopeCorrect(Builder $query): Builder
    {
        return $query->where('is_correct', true);
    }

    public function scopeIncorrect(Builder $query): Builder
    {
        return $query->where('is_correct', false);
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeLevel(Builder $query, string $level): Builder
    {
        return $query->where('level_type', $level);
    }

    public function scopeQuestionType(Builder $query, string $type): Builder
    {
        return $query->where('questionable_type', $type);
    }

    public function scopeListeningOnly(Builder $query): Builder
    {
        return $query->where('questionable_type', \App\Models\ListeningQuestion::class);
    }

    public function scopeRegularOnly(Builder $query): Builder
    {
        return $query->where('questionable_type', \App\Models\Question::class);
    }

    public function scopeUsedHint(Builder $query): Builder
    {
        return $query->where('used_hint', true);
    }

    public function scopeNoHint(Builder $query): Builder
    {
        return $query->where('used_hint', false);
    }

    public function scopePerfect(Builder $query): Builder
    {
        return $query->where('is_correct', true)
            ->where('attempts', 1)
            ->where('used_hint', false);
    }

    public function scopeInDateRange(Builder $query, Carbon $start, Carbon $end): Builder
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    public function scopeHighestPoints(Builder $query): Builder
    {
        return $query->orderByDesc('points_earned');
    }

    public function scopeHighestExp(Builder $query): Builder
    {
        return $query->orderByDesc('exp_earned');
    }

    public function scopeFastest(Builder $query): Builder
    {
        return $query->whereNotNull('time_taken')
            ->orderBy('time_taken', 'asc');
    }

    // ==================== STATIC METHODS ====================
    public static function getUserStatistics(int $userId): array
    {
        $stats = self::forUser($userId)
            ->selectRaw('
                COUNT(*) as total_sessions,
                SUM(CASE WHEN is_correct THEN 1 ELSE 0 END) as correct_answers,
                SUM(CASE WHEN is_correct = 0 THEN 1 ELSE 0 END) as incorrect_answers,
                SUM(points_earned) as total_points,
                SUM(exp_earned) as total_exp,
                SUM(CASE WHEN is_correct = 1 AND attempts = 1 AND used_hint = 0 THEN 1 ELSE 0 END) as perfect_answers,
                SUM(CASE WHEN used_hint = 1 THEN 1 ELSE 0 END) as hints_used,
                AVG(attempts) as average_attempts,
                AVG(time_taken) as average_time
            ')
            ->first();

        $total = $stats->total_sessions ?? 0;
        $correct = $stats->correct_answers ?? 0;

        $byLevel = self::forUser($userId)
            ->selectRaw('level_type, COUNT(*) as total, SUM(CASE WHEN is_correct THEN 1 ELSE 0 END) as correct')
            ->groupBy('level_type')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->level_type => [
                        'total' => $item->total,
                        'correct' => $item->correct,
                        'accuracy' => $item->total > 0 ? round(($item->correct / $item->total) * 100, 2) : 0,
                    ]
                ];
            })
            ->toArray();

        $byType = self::forUser($userId)
            ->selectRaw('questionable_type, COUNT(*) as count')
            ->groupBy('questionable_type')
            ->pluck('count', 'questionable_type')
            ->toArray();

        return [
            'total_sessions' => $total,
            'correct_answers' => $correct,
            'incorrect_answers' => $stats->incorrect_answers ?? 0,
            'accuracy_rate' => $total > 0 ? round(($correct / $total) * 100, 2) : 0,
            'total_points' => $stats->total_points ?? 0,
            'total_exp' => $stats->total_exp ?? 0,
            'perfect_answers' => $stats->perfect_answers ?? 0,
            'hints_used' => $stats->hints_used ?? 0,
            'average_attempts' => round($stats->average_attempts ?? 0, 2),
            'average_time' => round($stats->average_time ?? 0, 2),
            'by_level' => $byLevel,
            'by_type' => $byType,
            'current_streak' => self::calculateCurrentStreak($userId),
        ];
    }

    public static function getLeaderboard(int $limit = 10, ?string $period = 'all'): array
    {
        $query = self::query();

        match ($period) {
            'today' => $query->today(),
            'week' => $query->thisWeek(),
            'month' => $query->thisMonth(),
            default => null,
        };

        return $query->selectRaw('
                user_id,
                COUNT(*) as total_sessions,
                SUM(CASE WHEN is_correct THEN 1 ELSE 0 END) as correct_answers,
                SUM(points_earned) as total_points,
                SUM(exp_earned) as total_exp
            ')
            ->with('user:id,name,email')
            ->groupBy('user_id')
            ->orderByDesc('total_points')
            ->limit($limit)
            ->get()
            ->map(function ($item, $index) {
                return [
                    'rank' => $index + 1,
                    'user' => $item->user,
                    'total_sessions' => $item->total_sessions,
                    'correct_answers' => $item->correct_answers,
                    'accuracy' => $item->total_sessions > 0 
                        ? round(($item->correct_answers / $item->total_sessions) * 100, 2) 
                        : 0,
                    'total_points' => $item->total_points,
                    'total_exp' => $item->total_exp,
                ];
            })
            ->toArray();
    }

    public static function getRecentSessions(int $userId, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return self::forUser($userId)
            ->with('questionable')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public static function calculateCurrentStreak(int $userId): int
    {
        $recentSessions = self::forUser($userId)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get(['is_correct']);

        $streak = 0;
        foreach ($recentSessions as $session) {
            if ($session->is_correct) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }

    public static function getDailyPerformance(int $userId, int $days = 7): array
    {
        $start = now()->subDays($days)->startOfDay();
        $end = now()->endOfDay();

        return self::forUser($userId)
            ->inDateRange($start, $end)
            ->selectRaw('
                DATE(created_at) as date,
                COUNT(*) as total,
                SUM(CASE WHEN is_correct THEN 1 ELSE 0 END) as correct,
                SUM(points_earned) as points,
                SUM(exp_earned) as exp
            ')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'total' => $item->total,
                    'correct' => $item->correct,
                    'accuracy' => $item->total > 0 ? round(($item->correct / $item->total) * 100, 2) : 0,
                    'points' => $item->points,
                    'exp' => $item->exp,
                ];
            })
            ->toArray();
    }

    public static function getAvailableLevels(): array
    {
        return [
            self::LEVEL_LOW,
            self::LEVEL_MEDIUM,
            self::LEVEL_HARD,
            self::LEVEL_OTHER,
        ];
    }

    public static function getLevelLabels(): array
    {
        return [
            self::LEVEL_LOW => 'Mudah',
            self::LEVEL_MEDIUM => 'Sedang',
            self::LEVEL_HARD => 'Sulit',
            self::LEVEL_OTHER => 'Lainnya',
        ];
    }
}