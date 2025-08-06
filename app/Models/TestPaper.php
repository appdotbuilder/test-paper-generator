<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\TestPaper
 *
 * @property int $id
 * @property string $title
 * @property string $grade_level
 * @property string $subject
 * @property int|null $duration_minutes
 * @property string|null $instructions
 * @property int $total_points
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper query()
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper whereDurationMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper whereGradeLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper whereInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper whereTotalPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestPaper whereUserId($value)
 * @method static \Database\Factories\TestPaperFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class TestPaper extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'grade_level',
        'subject',
        'duration_minutes',
        'instructions',
        'total_points',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duration_minutes' => 'integer',
        'total_points' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user (teacher) who created this test paper.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the questions included in this test paper.
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'test_paper_questions')
            ->withPivot('order')
            ->withTimestamps()
            ->orderBy('test_paper_questions.order');
    }

    /**
     * Calculate and update the total points for this test paper.
     */
    public function updateTotalPoints(): void
    {
        $totalPoints = $this->questions()->sum('points');
        $this->update(['total_points' => $totalPoints]);
    }
}