<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperScore
 */
class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'question_id',
        'score',
        'total_questions',
        'correct_answers',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'score' => 'float',
    ];

    /**
     * Relationship: Score belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Score belongs to game
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Relationship: Score belongs to question (optional)
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relationship: Score has many answer logs
     */
    public function answerLogs()
    {
        return $this->hasMany(AnswerLog::class);
    }
}