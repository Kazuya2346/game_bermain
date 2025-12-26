<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Exception;

/**
 * Model untuk Soal Listening (Updated - Clean Version)
 */
class ListeningQuestion extends Model
{
    use HasFactory;

    protected $table = 'listening_questions';

    protected $fillable = [
        'level', 'speaker', 'audio_data', 'audio_mime_type', 'audio_size',
        'word_count', 'question_text', 'correct_answer', 'answer_type',
        'option_a', 'option_b', 'option_c', 'option_d',
        'exp_reward', 'play_count_limit',
    ];

    protected $hidden = [
        'audio_data',
    ];

    protected $appends = [
        'audio_url',
        'difficulty_label',
    ];

    protected $casts = [
        'audio_size' => 'integer',
        'word_count' => 'integer',
        'exp_reward' => 'integer',
        'play_count_limit' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ==================== CONSTANTS ====================
    public const LEVEL_LOW = 'low';
    public const LEVEL_MEDIUM = 'medium';
    public const LEVEL_HARD = 'hard';

    public const SPEAKER_LATIFAH = 'latifah';
    public const SPEAKER_ROFI = 'rofi';
    public const SPEAKER_UNKNOWN = 'unknown';

    public const ANSWER_TYPE_MULTIPLE_CHOICE = 'multiple_choice';
    public const ANSWER_TYPE_DRAG_DROP_WORD = 'drag_drop_word';
    public const ANSWER_TYPE_DRAG_DROP_LETTER = 'drag_drop_letter';

    // ==================== RELATIONSHIPS ====================
    public function gameSessions()
    {
        return $this->morphMany(GameSession::class, 'questionable');
    }

    // ==================== ACCESSORS ====================
    public function getAudioUrlAttribute(): ?string
    {
        // Prioritas 1: Audio data base64
        if ($this->audio_data && $this->audio_mime_type) {
            return 'data:' . $this->audio_mime_type . ';base64,' . base64_encode($this->audio_data);
        }

        // Prioritas 2: Audio path dari storage
        if (!empty($this->audio_path) && Storage::exists($this->audio_path)) {
            return Storage::url($this->audio_path);
        }

        // Prioritas 3: URL eksternal (jika ada kolom audio_url)
        if (!empty($this->attributes['audio_url'] ?? null)) {
            return $this->attributes['audio_url'];
        }

        return null;
    }

    public function getDifficultyLabelAttribute(): string
    {
        return match($this->level) {
            self::LEVEL_LOW => 'Mudah',
            self::LEVEL_MEDIUM => 'Sedang',
            self::LEVEL_HARD => 'Sulit',
            default => $this->level,
        };
    }

    // ==================== METHODS ====================
    public function getOptions(): array
    {
        $options = [
            'a' => $this->option_a,
            'b' => $this->option_b, 
            'c' => $this->option_c,
            'd' => $this->option_d,
        ];

        $filtered = array_filter($options, function($value) {
            return !is_null($value) && $value !== '';
        });

        if (count($filtered) < 2) {
            throw new \Exception("Question #{$this->id} has insufficient options");
        }

        return $filtered;
    }

    public function isCorrectAnswer(string $answer): bool
    {
        return strtolower(trim($answer)) === strtolower(trim($this->correct_answer));
    }

    public function getReadableAudioSize(): string
    {
        if (!$this->audio_size) {
            return '0 B';
        }
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->audio_size;
        $unit = 0;
        
        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }
        
        return round($size, 2) . ' ' . $units[$unit];
    }

    public function setAudioFromFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new Exception("File tidak ditemukan: {$filePath}");
        }
        
        $this->audio_data = file_get_contents($filePath);
        $this->audio_mime_type = mime_content_type($filePath);
        $this->audio_size = filesize($filePath);
    }

    // ==================== SCOPES ====================
    public function scopeLevel($query, string $level)
    {
        return $query->where('level', $level);
    }

    public function scopeSpeaker($query, string $speaker)
    {
        return $query->where('speaker', $speaker);
    }

    public function scopeRandomQuestion($query, int $limit = 1)
    {
        return $query->inRandomOrder()->limit($limit);
    }

    public function scopeOrderByDifficulty($query, string $direction = 'asc')
    {
        return $query->orderByRaw(
            "FIELD(level, ?, ?, ?) {$direction}",
            [self::LEVEL_LOW, self::LEVEL_MEDIUM, self::LEVEL_HARD]
        );
    }

    // ==================== STATIC METHODS ====================
    public static function getStatistics(): array
    {
        return [
            'total' => self::count(),
            'by_level' => self::selectRaw('level, COUNT(*) as count')
                ->groupBy('level')
                ->pluck('count', 'level')
                ->toArray(),
            'by_speaker' => self::selectRaw('speaker, COUNT(*) as count')
                ->groupBy('speaker')
                ->pluck('count', 'speaker')
                ->toArray(),
            'total_play_count' => GameSession::where('questionable_type', self::class)->count(),
        ];
    }

    public static function getAvailableLevels(): array
    {
        return [
            self::LEVEL_LOW,
            self::LEVEL_MEDIUM,
            self::LEVEL_HARD,
        ];
    }

    public static function getAvailableSpeakers(): array
    {
        return [
            self::SPEAKER_LATIFAH,
            self::SPEAKER_ROFI,
            self::SPEAKER_UNKNOWN,
        ];
    }

    public static function getRandomByLevel(string $level, int $limit = 5)
    {
        return self::where('level', $level)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}