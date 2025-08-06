<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Question::with('user')->where('user_id', auth()->id());

        // Apply filters
        if ($request->filled('grade_level')) {
            $query->byGradeLevel($request->grade_level);
        }

        if ($request->filled('difficulty')) {
            $query->byDifficulty($request->difficulty);
        }

        if ($request->filled('question_type')) {
            $query->byType($request->question_type);
        }

        if ($request->filled('textbook')) {
            $query->byTextbook($request->textbook, $request->chapter);
        }

        if ($request->filled('search')) {
            $query->where('question_text', 'like', '%' . $request->search . '%');
        }

        $questions = $query->latest()->paginate(15)->withQueryString();

        // Get filter options
        $filterOptions = $this->getFilterOptions();

        return Inertia::render('questions/index', [
            'questions' => $questions,
            'filters' => $request->only(['grade_level', 'difficulty', 'question_type', 'textbook', 'chapter', 'search']),
            'filterOptions' => $filterOptions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('questions/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create(
            array_merge($request->validated(), ['user_id' => auth()->id()])
        );

        return redirect()->route('questions.show', $question)
            ->with('success', 'Question created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        // Ensure user can only view their own questions
        if ($question->user_id !== auth()->id()) {
            abort(403);
        }

        $question->load('user');

        return Inertia::render('questions/show', [
            'question' => $question,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        // Ensure user can only edit their own questions
        if ($question->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('questions/edit', [
            'question' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        // Ensure user can only update their own questions
        if ($question->user_id !== auth()->id()) {
            abort(403);
        }

        $question->update($request->validated());

        return redirect()->route('questions.show', $question)
            ->with('success', 'Question updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        // Ensure user can only delete their own questions
        if ($question->user_id !== auth()->id()) {
            abort(403);
        }

        $question->delete();

        return redirect()->route('questions.index')
            ->with('success', 'Question deleted successfully.');
    }



    /**
     * Get filter options for questions.
     */
    protected function getFilterOptions(): array
    {
        $userId = auth()->id();

        return [
            'gradeLevels' => Question::where('user_id', $userId)
                ->distinct()
                ->pluck('grade_level')
                ->sort()
                ->values(),
            'difficulties' => ['easy', 'medium', 'hard'],
            'questionTypes' => [
                'multiple_choice' => 'Multiple Choice',
                'true_false' => 'True/False',
                'descriptive' => 'Descriptive',
                'matching' => 'Matching',
                'fill_in_blank' => 'Fill in the Blank',
            ],
            'textbooks' => Question::where('user_id', $userId)
                ->distinct()
                ->pluck('textbook')
                ->sort()
                ->values(),
            'sources' => [
                'textbook' => 'Textbook',
                'sample_exam' => 'Sample Exam',
                'practice_sheet' => 'Practice Sheet',
                'custom' => 'Custom',
            ],
        ];
    }
}