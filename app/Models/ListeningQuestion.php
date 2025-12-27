<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Exception;

/**
 * Model untuk Soal Listening (Updated - File-based Audio System)
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

    // Audio data sekarang berisi nama file, jadi tidak perlu disembunyikan
    protected $hidden = [
        // 'audio_data', // Dikomentari karena sekarang hanya nama file, bukan BLOB
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
    /**
     * PERUBAHAN PENTING: Audio URL untuk file-based storage
     * 
     * Sekarang audio_data hanya berisi nama file (string)
     * Mengembalikan URL lengkap menggunakan asset() helper
     */
    public function getAudioUrlAttribute(): ?string
    {
        // PERUBAHAN: Sekarang audio_data berisi nama file, bukan BLOB
        if (!empty($this->audio_data) && is_string($this->audio_data)) {
            // Kembalikan URL ke file di folder publik
            return asset('audio/listening_audios/' . $this->audio_data);
        }

        return null;
    }

    /**
     * Accessor untuk path lengkap file audio (untuk keperluan internal)
     */
    public function getAudioFilePathAttribute(): ?string
    {
        if (!empty($this->audio_data) && is_string($this->audio_data)) {
            return public_path('audio/listening_audios/' . $this->audio_data);
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

    /**
     * PERUBAHAN: Metode untuk mengelola file audio
     * Sekarang menyimpan file ke folder publik dan menyimpan nama file
     */
    public function setAudioFromFile(string $filePath, string $fileName = null): void
    {
        if (!file_exists($filePath)) {
            throw new Exception("File tidak ditemukan: {$filePath}");
        }
        
        // Tentukan nama file
        if (!$fileName) {
            $fileName = basename($filePath);
        }
        
        // Pastikan folder tujuan ada
        $destinationDir = public_path('audio/listening_audios');
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }
        
        $destinationPath = $destinationDir . '/' . $fileName;
        
        // Salin file ke folder publik
        if (copy($filePath, $destinationPath)) {
            // Simpan nama file, bukan konten BLOB
            $this->audio_data = $fileName;
            $this->audio_mime_type = mime_content_type($filePath);
            $this->audio_size = filesize($filePath);
        } else {
            throw new Exception("Gagal menyalin file ke folder publik: {$destinationPath}");
        }
    }

    /**
     * Hapus file audio terkait dari storage
     */
    public function deleteAudioFile(): bool
    {
        if (!empty($this->audio_data) && is_string($this->audio_data)) {
            $filePath = public_path('audio/listening_audios/' . $this->audio_data);
            if (file_exists($filePath)) {
                return unlink($filePath);
            }
        }
        return false;
    }

    /**
     * PERUBAHAN: Untuk kompatibilitas dengan PostgreSQL
     * Mengembalikan array shuffled items untuk drag & drop
     */
    public function getShuffledItems(): array
    {
        if ($this->answer_type === self::ANSWER_TYPE_DRAG_DROP_WORD || 
            $this->answer_type === self::ANSWER_TYPE_DRAG_DROP_LETTER) {
            
            // Split correct answer menjadi item-item
            $items = preg_split('/\s+/', $this->correct_answer);
            
            // Filter item yang kosong
            $items = array_filter($items, function($item) {
                return !empty(trim($item));
            });
            
            // Acak urutan item
            shuffle($items);
            
            return $items;
        }
        
        return [];
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
    // PERBAIKAN: Gunakan CASE untuk kompatibilitas PostgreSQL
    return $query->orderByRaw(
        "CASE level 
            WHEN ? THEN 1 
            WHEN ? THEN 2 
            WHEN ? THEN 3 
        END {$direction}",
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

    /**
     * Model events untuk menghapus file audio ketika model dihapus
     */
    protected static function boot()
    {
        parent::boot();

        // Hapus file audio ketika model dihapus
        static::deleting(function ($question) {
            $question->deleteAudioFile();
        });
    }
}