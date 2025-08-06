import React, { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { AppContent } from '@/components/app-content';
import { AppSidebar } from '@/components/app-sidebar';
import { AppHeader } from '@/components/app-header';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

interface Question {
    id: number;
    question_text: string;
    question_type: string;
    grade_level: string;
    textbook: string;
    chapter: string;
    source: string;
    difficulty_level: string;
    points: number;
    created_at: string;
    user: {
        name: string;
    };
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface QuestionsData {
    data: Question[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: PaginationLink[];
}

interface FilterOptions {
    gradeLevels: string[];
    difficulties: string[];
    questionTypes: Record<string, string>;
    textbooks: string[];
    sources: Record<string, string>;
}

interface Filters {
    grade_level?: string;
    difficulty?: string;
    question_type?: string;
    textbook?: string;
    chapter?: string;
    search?: string;
}

interface Props {
    questions: QuestionsData;
    filters: Filters;
    filterOptions: FilterOptions;
    [key: string]: unknown;
}

export default function QuestionsIndex({ questions, filters, filterOptions }: Props) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');

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
            case 'easy': return 'bg-green-100 text-green-800 border-green-200';
            case 'medium': return 'bg-yellow-100 text-yellow-800 border-yellow-200';
            case 'hard': return 'bg-red-100 text-red-800 border-red-200';
            default: return 'bg-gray-100 text-gray-800 border-gray-200';
        }
    };

    const formatDate = (dateString: string): string => {
        return new Date(dateString).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    };

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get('/questions', {
            ...filters,
            search: searchTerm,
        });
    };

    const handleFilterChange = (key: string, value: string) => {
        router.get('/questions', {
            ...filters,
            [key]: value || undefined,
        });
    };

    const clearFilters = () => {
        router.get('/questions');
    };

    const truncateText = (text: string, maxLength: number = 120): string => {
        return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
    };

    return (
        <AppShell variant="sidebar">
            <AppSidebar />
            <AppContent variant="sidebar" className="p-6">
                <AppHeader />
                <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">📝 Question Bank</h1>
                        <p className="text-gray-600">
                            Manage your collection of {questions.total} questions
                        </p>
                    </div>
                    <Button asChild>
                        <Link href="/questions/create">➕ Add New Question</Link>
                    </Button>
                </div>

                {/* Filters */}
                <Card>
                    <CardHeader>
                        <CardTitle className="text-lg">🔍 Filter Questions</CardTitle>
                        <CardDescription>Find the perfect questions for your needs</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            {/* Search */}
                            <form onSubmit={handleSearch} className="flex gap-2">
                                <Input
                                    placeholder="Search questions..."
                                    value={searchTerm}
                                    onChange={(e) => setSearchTerm(e.target.value)}
                                    className="flex-1"
                                />
                                <Button type="submit">Search</Button>
                            </form>

                            {/* Filter Dropdowns */}
                            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                <div>
                                    <label className="block text-sm font-medium mb-1">Grade Level</label>
                                    <Select
                                        value={filters.grade_level || ''}
                                        onValueChange={(value) => handleFilterChange('grade_level', value)}
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Any grade" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="">Any grade</SelectItem>
                                            {filterOptions.gradeLevels.map(level => (
                                                <SelectItem key={level} value={level}>
                                                    {level}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium mb-1">Difficulty</label>
                                    <Select
                                        value={filters.difficulty || ''}
                                        onValueChange={(value) => handleFilterChange('difficulty', value)}
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Any difficulty" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="">Any difficulty</SelectItem>
                                            {filterOptions.difficulties.map(difficulty => (
                                                <SelectItem key={difficulty} value={difficulty}>
                                                    {formatDifficulty(difficulty)}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium mb-1">Type</label>
                                    <Select
                                        value={filters.question_type || ''}
                                        onValueChange={(value) => handleFilterChange('question_type', value)}
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Any type" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="">Any type</SelectItem>
                                            {Object.entries(filterOptions.questionTypes).map(([key, label]) => (
                                                <SelectItem key={key} value={key}>
                                                    {label}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div>
                                    <label className="block text-sm font-medium mb-1">Textbook</label>
                                    <Select
                                        value={filters.textbook || ''}
                                        onValueChange={(value) => handleFilterChange('textbook', value)}
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Any textbook" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="">Any textbook</SelectItem>
                                            {filterOptions.textbooks.map(textbook => (
                                                <SelectItem key={textbook} value={textbook}>
                                                    {textbook}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div className="flex items-end">
                                    <Button variant="outline" onClick={clearFilters} className="w-full">
                                        Clear Filters
                                    </Button>
                                </div>
                            </div>

                            {/* Active Filters */}
                            {Object.values(filters).some(value => value) && (
                                <div className="flex flex-wrap gap-2">
                                    <span className="text-sm text-gray-600">Active filters:</span>
                                    {filters.search && (
                                        <Badge variant="secondary">
                                            Search: "{filters.search}"
                                        </Badge>
                                    )}
                                    {filters.grade_level && (
                                        <Badge variant="secondary">
                                            Grade: {filters.grade_level}
                                        </Badge>
                                    )}
                                    {filters.difficulty && (
                                        <Badge variant="secondary">
                                            {formatDifficulty(filters.difficulty)}
                                        </Badge>
                                    )}
                                    {filters.question_type && (
                                        <Badge variant="secondary">
                                            {formatQuestionType(filters.question_type)}
                                        </Badge>
                                    )}
                                    {filters.textbook && (
                                        <Badge variant="secondary">
                                            {filters.textbook}
                                        </Badge>
                                    )}
                                </div>
                            )}
                        </div>
                    </CardContent>
                </Card>

                {/* Questions List */}
                <div className="space-y-4">
                    {questions.data.length > 0 ? (
                        questions.data.map((question) => (
                            <Card key={question.id} className="hover:shadow-md transition-shadow">
                                <CardContent className="pt-6">
                                    <div className="flex items-start justify-between gap-4">
                                        <div className="flex-1 min-w-0">
                                            <h3 className="text-lg font-medium text-gray-900 mb-2">
                                                {truncateText(question.question_text)}
                                            </h3>
                                            
                                            <div className="flex flex-wrap gap-2 mb-3">
                                                <Badge variant="outline">
                                                    {formatQuestionType(question.question_type)}
                                                </Badge>
                                                <Badge className={getDifficultyColor(question.difficulty_level)}>
                                                    {formatDifficulty(question.difficulty_level)}
                                                </Badge>
                                                <Badge variant="secondary">
                                                    {question.grade_level}
                                                </Badge>
                                                <Badge variant="outline">
                                                    {question.points} pt{question.points !== 1 ? 's' : ''}
                                                </Badge>
                                            </div>

                                            <div className="text-sm text-gray-600 space-y-1">
                                                <p>
                                                    📚 <strong>{question.textbook}</strong> • {question.chapter}
                                                </p>
                                                <p className="flex items-center gap-4">
                                                    <span>🗓️ {formatDate(question.created_at)}</span>
                                                    <span>📖 {filterOptions.sources[question.source] || question.source}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <div className="flex flex-col gap-2 shrink-0">
                                            <Button variant="outline" size="sm" asChild>
                                                <Link href={`/questions/${question.id}`}>
                                                    👁️ View
                                                </Link>
                                            </Button>
                                            <Button variant="outline" size="sm" asChild>
                                                <Link href={`/questions/${question.id}/edit`}>
                                                    ✏️ Edit
                                                </Link>
                                            </Button>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        ))
                    ) : (
                        <Card>
                            <CardContent className="text-center py-12">
                                <div className="text-6xl mb-4">📝</div>
                                <h3 className="text-lg font-medium text-gray-900 mb-2">No questions found</h3>
                                <p className="text-gray-600 mb-6">
                                    {Object.values(filters).some(value => value)
                                        ? "Try adjusting your filters or search terms."
                                        : "Start building your question bank by creating your first question."}
                                </p>
                                <div className="flex justify-center gap-3">
                                    <Button asChild>
                                        <Link href="/questions/create">Create First Question</Link>
                                    </Button>
                                    {Object.values(filters).some(value => value) && (
                                        <Button variant="outline" onClick={clearFilters}>
                                            Clear All Filters
                                        </Button>
                                    )}
                                </div>
                            </CardContent>
                        </Card>
                    )}
                </div>

                {/* Pagination */}
                {questions.last_page > 1 && (
                    <div className="flex items-center justify-between">
                        <p className="text-sm text-gray-600">
                            Showing {((questions.current_page - 1) * questions.per_page) + 1} to{' '}
                            {Math.min(questions.current_page * questions.per_page, questions.total)} of{' '}
                            {questions.total} questions
                        </p>
                        <div className="flex gap-2">
                            {questions.links.map((link, index) => (
                                link.url ? (
                                    <Button
                                        key={index}
                                        variant={link.active ? "default" : "outline"}
                                        size="sm"
                                        onClick={() => router.get(link.url!)}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                ) : (
                                    <Button
                                        key={index}
                                        variant="outline"
                                        size="sm"
                                        disabled
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                )
                            ))}
                        </div>
                    </div>
                )}
                </div>
            </AppContent>
        </AppShell>
    );
}