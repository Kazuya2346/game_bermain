<?php

namespace App\Helpers;

class LevelSystem
{
    /**
     * Get level information based on experience points
     */
    public static function getLevelInfo($experiencePoints)
    {
        $levels = [
            1 => ['name' => 'Pemula', 'min_xp' => 0, 'max_xp' => 99, 'color' => 'gray'],
            2 => ['name' => 'Pelajar', 'min_xp' => 100, 'max_xp' => 299, 'color' => 'blue'],
            3 => ['name' => 'Mahir', 'min_xp' => 300, 'max_xp' => 599, 'color' => 'green'],
            4 => ['name' => 'Juara', 'min_xp' => 600, 'max_xp' => 999, 'color' => 'purple'],
            5 => ['name' => 'Master', 'min_xp' => 1000, 'max_xp' => 999999, 'color' => 'yellow'],
        ];

        foreach ($levels as $level => $info) {
            if ($experiencePoints >= $info['min_xp'] && $experiencePoints <= $info['max_xp']) {
                return [
                    'level' => $level,
                    'name' => $info['name'],
                    'color' => $info['color'],
                    'current_xp' => $experiencePoints,
                    'min_xp' => $info['min_xp'],
                    'max_xp' => $info['max_xp'],
                    'progress_percentage' => self::calculateProgressPercentage($experiencePoints, $info['min_xp'], $info['max_xp'])
                ];
            }
        }

        return [
            'level' => 5,
            'name' => 'Master',
            'color' => 'yellow',
            'current_xp' => $experiencePoints,
            'min_xp' => 1000,
            'max_xp' => 999999,
            'progress_percentage' => 100
        ];
    }

    /**
     * Calculate progress percentage for current level
     */
    private static function calculateProgressPercentage($currentXp, $minXp, $maxXp)
    {
        if ($maxXp == $minXp) return 100;
        
        $progress = (($currentXp - $minXp) / ($maxXp - $minXp)) * 100;
        return min(100, max(0, round($progress)));
    }

    /**
     * Calculate XP based on score percentage
     */
    public static function calculateXP($correctAnswers, $totalQuestions)
    {
        if ($totalQuestions == 0) return 0;
        
        $percentage = ($correctAnswers / $totalQuestions) * 100;
        
        if ($percentage == 100) return 20;
        if ($percentage >= 80) return 15;
        if ($percentage >= 60) return 10;
        return 5;
    }

    /**
     * Get badge based on games completed
     */
    public static function getBadge($gamesCompleted)
    {
        if ($gamesCompleted >= 100) {
            return ['name' => 'Diamond', 'emoji' => '💎', 'color' => 'cyan'];
        }
        if ($gamesCompleted >= 50) {
            return ['name' => 'Gold', 'emoji' => '🥇', 'color' => 'yellow'];
        }
        if ($gamesCompleted >= 25) {
            return ['name' => 'Silver', 'emoji' => '🥈', 'color' => 'gray'];
        }
        if ($gamesCompleted >= 10) {
            return ['name' => 'Bronze', 'emoji' => '🥉', 'color' => 'orange'];
        }
        
        return ['name' => 'Beginner', 'emoji' => '⭐', 'color' => 'blue'];
    }

    /**
     * Get next badge requirement
     */
    public static function getNextBadgeRequirement($gamesCompleted)
    {
        if ($gamesCompleted < 10) {
            return ['target' => 10, 'remaining' => 10 - $gamesCompleted];
        }
        if ($gamesCompleted < 25) {
            return ['target' => 25, 'remaining' => 25 - $gamesCompleted];
        }
        if ($gamesCompleted < 50) {
            return ['target' => 50, 'remaining' => 50 - $gamesCompleted];
        }
        if ($gamesCompleted < 100) {
            return ['target' => 100, 'remaining' => 100 - $gamesCompleted];
        }
        
        return ['target' => 100, 'remaining' => 0];
    }
}