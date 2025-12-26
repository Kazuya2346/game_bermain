<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'type',
        'title',
        'description',
        'created_by',
        'status', // <--- PENTING: Tambahkan ini agar status bisa disimpan
    ];

    // --- RELASI (Biarkan tetap sama) ---
    public function questions() { return $this->hasMany(Question::class); }
    public function listeningQuestions() { return $this->hasMany(ListeningQuestion::class); }
    public function scores() { return $this->hasMany(Score::class); }
    public function answerLogs() { return $this->hasMany(AnswerLog::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}