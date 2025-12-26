<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAnswerLog
 */
class AnswerLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'score_id',
        'question_id',
        'user_answer',
        'correct_answer',
        'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean'
    ];

    /**
     * Relationship ke User (Santri)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship ke Game
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Relationship ke Score
     */
    public function score()
    {
        return $this->belongsTo(Score::class);
    }

    /**
     * Relationship ke Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}