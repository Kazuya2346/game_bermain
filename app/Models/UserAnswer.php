<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'game_session_id',
        'user_id',
        'question_id',
        'user_answer',
        'is_correct',
        'exp_earned',
        'audio_played_count',
        'time_taken',
        'answered_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'answered_at' => 'datetime',
    ];

    /**
     * Relationship: An answer belongs to a game session.
     */
    public function gameSession()
    {
        return $this->belongsTo(GameSession::class);
    }

    /**
     * Relationship: An answer belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: An answer belongs to a listening question.
     */
    public function listeningQuestion()
    {
        return $this->belongsTo(ListeningQuestion::class);
    }
}