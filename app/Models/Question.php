<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperQuestion
 */
class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'category',
        'question_text',
        'image_path',
        'correct_answer',
        'options',
        'location_name',
        'answer_type',
    ];

    protected $casts = [
        'options' => 'array'
    ];

    /**
     * Relationship: Question belongs to game
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Relationship: Question has many answer logs
     */
    public function answerLogs()
    {
        return $this->hasMany(AnswerLog::class);
    }
}