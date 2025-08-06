<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\TestPaper;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the application dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get statistics
        $stats = [
            'totalQuestions' => Question::where('user_id', $user->id)->count(),
            'totalTestPapers' => TestPaper::where('user_id', $user->id)->count(),
            'questionsByType' => Question::where('user_id', $user->id)
                ->select('question_type')
                ->selectRaw('count(*) as count')
                ->groupBy('question_type')
                ->pluck('count', 'question_type'),
            'questionsByDifficulty' => Question::where('user_id', $user->id)
                ->select('difficulty_level')
                ->selectRaw('count(*) as count')
                ->groupBy('difficulty_level')
                ->pluck('count', 'difficulty_level'),
        ];

        // Get recent questions
        $recentQuestions = Question::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Get recent test papers
        $recentTestPapers = TestPaper::where('user_id', $user->id)
            ->withCount('questions')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'recentQuestions' => $recentQuestions,
            'recentTestPapers' => $recentTestPapers,
        ]);
    }
}