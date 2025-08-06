import React from 'react';
import { Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { AppContent } from '@/components/app-content';
import { AppSidebar } from '@/components/app-sidebar';
import { AppHeader } from '@/components/app-header';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

interface Question {
    id: number;
    question_text: string;
    question_type: string;
    grade_level: string;
    textbook: string;
    difficulty_level: string;
    points: number;
    created_at: string;
}

interface TestPaper {
    id: number;
    title: string;
    grade_level: string;
    subject: string;
    total_points: number;
    questions_count: number;
    created_at: string;
}

interface Stats {
    totalQuestions: number;
    totalTestPapers: number;
    questionsByType: Record<string, number>;
    questionsByDifficulty: Record<string, number>;
}

interface Props {
    stats: Stats;
    recentQuestions: Question[];
    recentTestPapers: TestPaper[];
    [key: string]: unknown;
}

export default function Dashboard({ stats, recentQuestions, recentTestPapers }: Props) {
    const formatQuestionType = (type: string): string => {
        const types: Record<string, string> = {
            'multiple_choice': 'Multiple Choice',
            'true_false': 'True/False',
            'descriptive': 'Descriptive',
            'matching': 'Matching',
            'fill_in_blank': 'Fill in Blank'
        };
        return types[type] || type;
    };

    const formatDifficulty = (difficulty: string): string => {
        return difficulty.charAt(0).toUpperCase() + difficulty.slice(1);
    };

    const getDifficultyColor = (difficulty: string): string => {
        switch (difficulty) {
            case 'easy': return 'bg-green-100 text-green-800';
            case 'medium': return 'bg-yellow-100 text-yellow-800';
            case 'hard': return 'bg-red-100 text-red-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    };

    const formatDate = (dateString: string): string => {
        return new Date(dateString).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    };

    return (
        <AppShell variant="sidebar">
            <AppSidebar />
            <AppContent variant="sidebar" className="p-6">
                <AppHeader />
                <div className="space-y-6">
                {/* Welcome Section */}
                <div className="bg-gradient-to-r from-blue-500 to-green-500 rounded-lg p-6 text-white">
                    <h1 className="text-2xl font-bold mb-2">📚 Welcome to TestCraft!</h1>
                    <p className="text-blue-100 mb-4">
                        Create professional test papers and manage your question bank with ease.
                    </p>
                    <div className="flex gap-3">
                        <Button variant="secondary" asChild>
                            <Link href="/questions/create">➕ Add Question</Link>
                        </Button>
                        <Button variant="outline" className="border-white text-white hover:bg-white hover:text-blue-600" asChild>
                            <Link href="/test-papers/create">📋 Create Test</Link>
                        </Button>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600">Total Questions</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-blue-600">{stats.totalQuestions}</div>
                            <p className="text-xs text-gray-500">Questions in your bank</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600">Test Papers</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-green-600">{stats.totalTestPapers}</div>
                            <p className="text-xs text-gray-500">Tests created</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600">Question Types</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-purple-600">
                                {Object.keys(stats.questionsByType).length}
                            </div>
                            <p className="text-xs text-gray-500">Different formats</p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-600">Avg. Difficulty</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-orange-600">
                                {stats.questionsByDifficulty.medium > 0 ? 'Medium' : 
                                 stats.questionsByDifficulty.easy > 0 ? 'Easy' : 'Mixed'}
                            </div>
                            <p className="text-xs text-gray-500">Overall complexity</p>
                        </CardContent>
                    </Card>
                </div>

                {/* Quick Actions */}
                <Card>
                    <CardHeader>
                        <CardTitle>⚡ Quick Actions</CardTitle>
                        <CardDescription>Common tasks to get you started</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <Button variant="outline" className="h-20 flex-col" asChild>
                                <Link href="/questions">
                                    <div className="text-2xl mb-1">📝</div>
                                    <div>Browse Questions</div>
                                </Link>
                            </Button>
                            <Button variant="outline" className="h-20 flex-col" asChild>
                                <Link href="/questions/create">
                                    <div className="text-2xl mb-1">➕</div>
                                    <div>Add New Question</div>
                                </Link>
                            </Button>
                            <Button variant="outline" className="h-20 flex-col" asChild>
                                <Link href="/test-papers/create">
                                    <div className="text-2xl mb-1">🎲</div>
                                    <div>Generate Random Test</div>
                                </Link>
                            </Button>
                            <Button variant="outline" className="h-20 flex-col" asChild>
                                <Link href="/test-papers">
                                    <div className="text-2xl mb-1">📋</div>
                                    <div>View Test Papers</div>
                                </Link>
                            </Button>
                            <Button variant="outline" className="h-20 flex-col" asChild>
                                <Link href="/questions?difficulty=hard">
                                    <div className="text-2xl mb-1">🔥</div>
                                    <div>Hard Questions</div>
                                </Link>
                            </Button>
                            <Button variant="outline" className="h-20 flex-col" asChild>
                                <Link href="/questions?question_type=multiple_choice">
                                    <div className="text-2xl mb-1">🎯</div>
                                    <div>Multiple Choice</div>
                                </Link>
                            </Button>
                        </div>
                    </CardContent>
                </Card>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Recent Questions */}
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between">
                            <div>
                                <CardTitle>📝 Recent Questions</CardTitle>
                                <CardDescription>Your latest questions</CardDescription>
                            </div>
                            <Button variant="outline" size="sm" asChild>
                                <Link href="/questions">View All</Link>
                            </Button>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {recentQuestions.length > 0 ? (
                                    recentQuestions.map((question) => (
                                        <div key={question.id} className="flex items-start justify-between p-3 bg-gray-50 rounded-lg">
                                            <div className="flex-1">
                                                <p className="text-sm font-medium text-gray-900 line-clamp-2">
                                                    {question.question_text}
                                                </p>
                                                <div className="flex items-center gap-2 mt-2">
                                                    <Badge variant="secondary" className="text-xs">
                                                        {formatQuestionType(question.question_type)}
                                                    </Badge>
                                                    <Badge className={`text-xs ${getDifficultyColor(question.difficulty_level)}`}>
                                                        {formatDifficulty(question.difficulty_level)}
                                                    </Badge>
                                                    <span className="text-xs text-gray-500">
                                                        {question.grade_level} • {question.points}pt
                                                    </span>
                                                </div>
                                            </div>
                                            <div className="text-xs text-gray-400 ml-3">
                                                {formatDate(question.created_at)}
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <div className="text-center py-8 text-gray-500">
                                        <div className="text-4xl mb-2">📝</div>
                                        <p>No questions yet</p>
                                        <Button variant="link" asChild>
                                            <Link href="/questions/create">Create your first question</Link>
                                        </Button>
                                    </div>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Recent Test Papers */}
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between">
                            <div>
                                <CardTitle>📋 Recent Test Papers</CardTitle>
                                <CardDescription>Your latest test papers</CardDescription>
                            </div>
                            <Button variant="outline" size="sm" asChild>
                                <Link href="/test-papers">View All</Link>
                            </Button>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {recentTestPapers.length > 0 ? (
                                    recentTestPapers.map((paper) => (
                                        <div key={paper.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div className="flex-1">
                                                <p className="text-sm font-medium text-gray-900">
                                                    {paper.title}
                                                </p>
                                                <div className="flex items-center gap-2 mt-1">
                                                    <span className="text-xs text-gray-500">
                                                        {paper.grade_level} • {paper.subject}
                                                    </span>
                                                    <Badge variant="outline" className="text-xs">
                                                        {paper.questions_count} Questions
                                                    </Badge>
                                                    <Badge variant="secondary" className="text-xs">
                                                        {paper.total_points} Points
                                                    </Badge>
                                                </div>
                                            </div>
                                            <div className="text-xs text-gray-400">
                                                {formatDate(paper.created_at)}
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <div className="text-center py-8 text-gray-500">
                                        <div className="text-4xl mb-2">📋</div>
                                        <p>No test papers yet</p>
                                        <Button variant="link" asChild>
                                            <Link href="/test-papers/create">Create your first test</Link>
                                        </Button>
                                    </div>
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Question Distribution Charts */}
                {stats.totalQuestions > 0 && (
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>📊 Questions by Type</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="space-y-3">
                                    {Object.entries(stats.questionsByType).map(([type, count]) => (
                                        <div key={type} className="flex items-center justify-between">
                                            <span className="text-sm text-gray-600">
                                                {formatQuestionType(type)}
                                            </span>
                                            <div className="flex items-center gap-2">
                                                <div className="w-24 bg-gray-200 rounded-full h-2">
                                                    <div 
                                                        className="bg-blue-500 h-2 rounded-full"
                                                        style={{ 
                                                            width: `${(count / stats.totalQuestions) * 100}%` 
                                                        }}
                                                    />
                                                </div>
                                                <span className="text-sm font-medium text-gray-900 w-8">
                                                    {count}
                                                </span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>🎯 Questions by Difficulty</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="space-y-3">
                                    {Object.entries(stats.questionsByDifficulty).map(([difficulty, count]) => (
                                        <div key={difficulty} className="flex items-center justify-between">
                                            <span className="text-sm text-gray-600">
                                                {formatDifficulty(difficulty)}
                                            </span>
                                            <div className="flex items-center gap-2">
                                                <div className="w-24 bg-gray-200 rounded-full h-2">
                                                    <div 
                                                        className={`h-2 rounded-full ${
                                                            difficulty === 'easy' ? 'bg-green-500' :
                                                            difficulty === 'medium' ? 'bg-yellow-500' :
                                                            'bg-red-500'
                                                        }`}
                                                        style={{ 
                                                            width: `${(count / stats.totalQuestions) * 100}%` 
                                                        }}
                                                    />
                                                </div>
                                                <span className="text-sm font-medium text-gray-900 w-8">
                                                    {count}
                                                </span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                )}
                </div>
            </AppContent>
        </AppShell>
    );
}