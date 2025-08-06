<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestPaperRequest;
use App\Models\Question;
use App\Models\TestPaper;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TestPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testPapers = TestPaper::with('user')
            ->where('user_id', auth()->id())
            ->withCount('questions')
            ->latest()
            ->paginate(12);

        return Inertia::render('test-papers/index', [
            'testPapers' => $testPapers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Get available questions for selection
        $questions = Question::where('user_id', auth()->id())
            ->latest()
            ->get()
            ->groupBy('textbook');

        // Get filter options for random selection
        $filterOptions = $this->getFilterOptions();

        return Inertia::render('test-papers/create', [
            'questions' => $questions,
            'filterOptions' => $filterOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestPaperRequest $request)
    {
        $validated = $request->validated();
        
        // Create the test paper
        $testPaper = TestPaper::create([
            'title' => $validated['title'],
            'grade_level' => $validated['grade_level'],
            'subject' => $validated['subject'],
            'duration_minutes' => $validated['duration_minutes'],
            'instructions' => $validated['instructions'],
            'user_id' => auth()->id(),
        ]);

        // Attach questions with order
        $questionIds = $validated['question_ids'];
        foreach ($questionIds as $index => $questionId) {
            $testPaper->questions()->attach($questionId, ['order' => $index + 1]);
        }

        // Update total points
        $testPaper->updateTotalPoints();

        return redirect()->route('test-papers.show', $testPaper)
            ->with('success', 'Test paper created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TestPaper $testPaper)
    {
        // Ensure user can only view their own test papers
        if ($testPaper->user_id !== auth()->id()) {
            abort(403);
        }

        $testPaper->load(['questions' => function ($query) {
            $query->orderBy('test_paper_questions.order');
        }, 'user']);

        return Inertia::render('test-papers/show', [
            'testPaper' => $testPaper,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TestPaper $testPaper)
    {
        // Ensure user can only edit their own test papers
        if ($testPaper->user_id !== auth()->id()) {
            abort(403);
        }

        $testPaper->load(['questions' => function ($query) {
            $query->orderBy('test_paper_questions.order');
        }]);

        // Get available questions for selection
        $questions = Question::where('user_id', auth()->id())
            ->latest()
            ->get()
            ->groupBy('textbook');

        // Get filter options for random selection
        $filterOptions = $this->getFilterOptions();

        return Inertia::render('test-papers/edit', [
            'testPaper' => $testPaper,
            'questions' => $questions,
            'filterOptions' => $filterOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTestPaperRequest $request, TestPaper $testPaper)
    {
        // Ensure user can only update their own test papers
        if ($testPaper->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validated();

        // Update test paper details
        $testPaper->update([
            'title' => $validated['title'],
            'grade_level' => $validated['grade_level'],
            'subject' => $validated['subject'],
            'duration_minutes' => $validated['duration_minutes'],
            'instructions' => $validated['instructions'],
        ]);

        // Sync questions with new order
        $testPaper->questions()->detach();
        $questionIds = $validated['question_ids'];
        foreach ($questionIds as $index => $questionId) {
            $testPaper->questions()->attach($questionId, ['order' => $index + 1]);
        }

        // Update total points
        $testPaper->updateTotalPoints();

        return redirect()->route('test-papers.show', $testPaper)
            ->with('success', 'Test paper updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestPaper $testPaper)
    {
        // Ensure user can only delete their own test papers
        if ($testPaper->user_id !== auth()->id()) {
            abort(403);
        }

        $testPaper->delete();

        return redirect()->route('test-papers.index')
            ->with('success', 'Test paper deleted successfully.');
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