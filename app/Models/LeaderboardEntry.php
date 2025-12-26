<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class LeaderboardEntry extends Model
{
    use HasFactory;

    protected $table = 'leaderboard';

    protected $fillable = [
        'user_id',
        'rank',
        'total_points',
        'total_exp',
        'last_updated',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'rank' => 'integer',
        'total_points' => 'integer',
        'total_exp' => 'integer',
        'last_updated' => 'datetime',
    ];

    protected $appends = [
        'formatted_rank',
        'formatted_points'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeTopRanked(Builder $query, int $limit = 10): Builder
    {
        return $query->orderBy('rank')->limit($limit);
    }

    public function scopeByPoints(Builder $query): Builder
    {
        return $query->orderByDesc('total_points');
    }

    public function scopeByExp(Builder $query): Builder
    {
        return $query->orderByDesc('total_exp');
    }

    public function scopeUpdatedToday(Builder $query): Builder
    {
        return $query->whereDate('last_updated', today());
    }

    // Accessors
    public function getFormattedRankAttribute(): string
    {
        return '#' . $this->rank;
    }

    public function getFormattedPointsAttribute(): string
    {
        return number_format($this->total_points);
    }

    // Business Logic
    public static function updateRanks(): void
    {
        $entries = self::orderByDesc('total_points')
                      ->orderByDesc('total_exp')
                      ->get();

        \DB::transaction(function () use ($entries) {
            foreach ($entries as $index => $entry) {
                $entry->update([
                    'rank' => $index + 1,
                    'last_updated' => now(),
                ]);
            }
        });
    }

    // Model Events
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if (!$model->isDirty('last_updated')) {
                $model->last_updated = now();
            }
        });
    }
}