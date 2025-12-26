<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $game_id
 * @property int $score_id
 * @property int $question_id
 * @property string $user_answer
 * @property string $correct_answer
 * @property bool $is_correct
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\Question $question
 * @property-read \App\Models\Score $score
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog whereCorrectAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog whereIsCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog whereScoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog whereUserAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnswerLog whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAnswerLog {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string|null $description
 * @property string $status
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnswerLog> $answerLogs
 * @property-read int|null $answer_logs_count
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Score> $scores
 * @property-read int|null $scores_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGame {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $game_id
 * @property string $question_text
 * @property string|null $image_path
 * @property string $correct_answer
 * @property array<array-key, mixed>|null $options
 * @property string|null $location_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnswerLog> $answerLogs
 * @property-read int|null $answer_logs_count
 * @property-read \App\Models\Game $game
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereCorrectAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereQuestionText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Question whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperQuestion {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $game_id
 * @property int|null $question_id
 * @property float $score
 * @property int $total_questions
 * @property int $correct_answers
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnswerLog> $answerLogs
 * @property-read int|null $answer_logs_count
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\Question|null $question
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score whereCorrectAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score whereTotalQuestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Score whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperScore {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property int $level
 * @property int $experience_points
 * @property int $total_games_completed
 * @property int $total_score
 * @property string|null $current_badge
 * @property string|null $profile_photo
 * @property string|null $class_id
 * @property string|null $no_telepon
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Game> $gamesCreated
 * @property-read int|null $games_created_count
 * @property-read mixed $avatar
 * @property-read mixed $profile_photo_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Score> $scores
 * @property-read int|null $scores_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentBadge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereExperiencePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNoTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTotalGamesCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTotalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

