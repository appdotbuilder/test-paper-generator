<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $question_text
 * @property string $question_type
 * @property array|null $options
 * @property string|null $correct_answer
 * @property string $grade_level
 * @property string $textbook
 * @property string $chapter
 * @property string $source
 * @property string $difficulty_level
 * @property int $points
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestPaper> $testPapers
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereChapter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCorrectAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDifficultyLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereGradeLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestionText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereTextbook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUserId($value)
 * @method static \Database\Factories\QuestionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'question_text',
        'question_type',
        'options',
        'correct_answer',
        'grade_level',
        'textbook',
        'chapter',
        'source',
        'difficulty_level',
        'points',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
        'points' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user (teacher) who created this question.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the test papers that include this question.
     */
    public function testPapers(): BelongsToMany
    {
        return $this->belongsToMany(TestPaper::class, 'test_paper_questions')
            ->withPivot('order')
            ->withTimestamps();
    }

    /**
     * Scope a query to filter by grade level.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $gradeLevel
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByGradeLevel($query, $gradeLevel)
    {
        return $query->where('grade_level', $gradeLevel);
    }

    /**
     * Scope a query to filter by difficulty level.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $difficulty
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty_level', $difficulty);
    }

    /**
     * Scope a query to filter by question type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByType($query, $type)
    {
        return $query->where('question_type', $type);
    }

    /**
     * Scope a query to filter by textbook and chapter.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $textbook
     * @param  string|null  $chapter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByTextbook($query, $textbook, $chapter = null)
    {
        $query = $query->where('textbook', $textbook);
        
        if ($chapter) {
            $query = $query->where('chapter', $chapter);
        }
        
        return $query;
    }
}