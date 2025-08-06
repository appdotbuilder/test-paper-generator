import React from 'react';
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';


interface Props {
    auth?: {
        user?: {
            id: number;
            name: string;
            email: string;
        };
    };
    [key: string]: unknown;
}

export default function Welcome({ auth }: Props) {
    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50">
            {/* Header */}
            <header className="container mx-auto px-6 py-6">
                <nav className="flex items-center justify-between">
                    <div className="flex items-center gap-2">
                        <div className="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span className="text-white font-bold text-sm">📚</span>
                        </div>
                        <span className="text-xl font-bold text-gray-900">TestCraft</span>
                    </div>
                    
                    <div className="flex items-center gap-4">
                        {auth?.user ? (
                            <div className="flex items-center gap-4">
                                <span className="text-sm text-gray-600">
                                    Welcome back, {auth.user.name}!
                                </span>
                                <Button asChild>
                                    <Link href="/dashboard">Dashboard</Link>
                                </Button>
                            </div>
                        ) : (
                            <div className="flex items-center gap-3">
                                <Button variant="ghost" asChild>
                                    <Link href="/login">Sign In</Link>
                                </Button>
                                <Button asChild>
                                    <Link href="/register">Get Started</Link>
                                </Button>
                            </div>
                        )}
                    </div>
                </nav>
            </header>

            {/* Hero Section */}
            <section className="container mx-auto px-6 py-16 text-center">
                <div className="max-w-4xl mx-auto">
                    <h1 className="text-5xl font-bold text-gray-900 mb-6">
                        📚 TestCraft for Teachers
                    </h1>
                    <p className="text-xl text-gray-600 mb-8 leading-relaxed">
                        Build comprehensive question banks and generate professional test papers with ease. 
                        Designed specifically for educators to create, organize, and print assessments efficiently.
                    </p>
                    <div className="flex justify-center gap-4 mb-12">
                        {!auth?.user && (
                            <>
                                <Button size="lg" asChild>
                                    <Link href="/register">Start Creating Tests 🚀</Link>
                                </Button>
                                <Button variant="outline" size="lg" asChild>
                                    <Link href="/login">Sign In</Link>
                                </Button>
                            </>
                        )}
                        {auth?.user && (
                            <Button size="lg" asChild>
                                <Link href="/dashboard">Go to Dashboard 📊</Link>
                            </Button>
                        )}
                    </div>
                </div>
            </section>

            {/* Features Grid */}
            <section className="container mx-auto px-6 py-16">
                <h2 className="text-3xl font-bold text-center text-gray-900 mb-12">
                    ✨ Powerful Features for Modern Teachers
                </h2>
                
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <Card className="p-6 hover:shadow-lg transition-shadow">
                        <div className="text-3xl mb-4">📝</div>
                        <h3 className="text-xl font-semibold mb-3">Smart Question Bank</h3>
                        <p className="text-gray-600 mb-4">
                            Store questions with detailed metadata: grade level, textbook chapters, 
                            difficulty levels, and question types (Multiple Choice, True/False, Descriptive).
                        </p>
                        <div className="flex flex-wrap gap-2">
                            <Badge variant="secondary">Multiple Choice</Badge>
                            <Badge variant="secondary">Fill in Blank</Badge>
                            <Badge variant="secondary">Descriptive</Badge>
                        </div>
                    </Card>

                    <Card className="p-6 hover:shadow-lg transition-shadow">
                        <div className="text-3xl mb-4">🎲</div>
                        <h3 className="text-xl font-semibold mb-3">Random Test Generation</h3>
                        <p className="text-gray-600 mb-4">
                            Generate tests automatically based on your criteria - grade level, 
                            difficulty, textbook chapters, or question types. Save hours of manual selection.
                        </p>
                        <div className="flex flex-wrap gap-2">
                            <Badge variant="outline">Easy</Badge>
                            <Badge variant="outline">Medium</Badge>
                            <Badge variant="outline">Hard</Badge>
                        </div>
                    </Card>

                    <Card className="p-6 hover:shadow-lg transition-shadow">
                        <div className="text-3xl mb-4">📋</div>
                        <h3 className="text-xl font-semibold mb-3">Manual Test Design</h3>
                        <p className="text-gray-600 mb-4">
                            Browse and handpick specific questions for your tests. 
                            Drag and drop to reorder, and see total points calculated automatically.
                        </p>
                        <div className="flex flex-wrap gap-2">
                            <Badge variant="secondary">Drag & Drop</Badge>
                            <Badge variant="secondary">Auto Points</Badge>
                        </div>
                    </Card>

                    <Card className="p-6 hover:shadow-lg transition-shadow">
                        <div className="text-3xl mb-4">🖨️</div>
                        <h3 className="text-xl font-semibold mb-3">Professional Printing</h3>
                        <p className="text-gray-600 mb-4">
                            Generate clean, printable test papers with proper formatting, 
                            answer sheets, and instructions. Perfect for classroom distribution.
                        </p>
                        <div className="flex flex-wrap gap-2">
                            <Badge variant="secondary">Clean Layout</Badge>
                            <Badge variant="secondary">Answer Keys</Badge>
                        </div>
                    </Card>

                    <Card className="p-6 hover:shadow-lg transition-shadow">
                        <div className="text-3xl mb-4">📚</div>
                        <h3 className="text-xl font-semibold mb-3">Textbook Organization</h3>
                        <p className="text-gray-600 mb-4">
                            Organize questions by textbooks and chapters. Easily filter by 
                            source material to create focused assessments for specific lessons.
                        </p>
                        <div className="flex flex-wrap gap-2">
                            <Badge variant="outline">Textbook</Badge>
                            <Badge variant="outline">Sample Exam</Badge>
                            <Badge variant="outline">Custom</Badge>
                        </div>
                    </Card>

                    <Card className="p-6 hover:shadow-lg transition-shadow">
                        <div className="text-3xl mb-4">⚡</div>
                        <h3 className="text-xl font-semibold mb-3">Time-Saving Tools</h3>
                        <p className="text-gray-600 mb-4">
                            Advanced filtering, bulk operations, and smart defaults help you 
                            create comprehensive tests in minutes instead of hours.
                        </p>
                        <div className="flex flex-wrap gap-2">
                            <Badge variant="secondary">Smart Filters</Badge>
                            <Badge variant="secondary">Bulk Actions</Badge>
                        </div>
                    </Card>
                </div>
            </section>

            {/* Stats Section */}
            <section className="bg-gray-50 py-16">
                <div className="container mx-auto px-6 text-center">
                    <h2 className="text-3xl font-bold text-gray-900 mb-12">
                        📊 Built for Educational Excellence
                    </h2>
                    <div className="grid md:grid-cols-3 gap-8 max-w-2xl mx-auto">
                        <div>
                            <div className="text-3xl font-bold text-blue-600 mb-2">5+</div>
                            <div className="text-gray-600">Question Types</div>
                        </div>
                        <div>
                            <div className="text-3xl font-bold text-green-600 mb-2">∞</div>
                            <div className="text-gray-600">Question Storage</div>
                        </div>
                        <div>
                            <div className="text-3xl font-bold text-purple-600 mb-2">1-Click</div>
                            <div className="text-gray-600">Print Ready Tests</div>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section className="container mx-auto px-6 py-16 text-center">
                <div className="max-w-2xl mx-auto">
                    <h2 className="text-3xl font-bold text-gray-900 mb-6">
                        Ready to Transform Your Testing? 🌟
                    </h2>
                    <p className="text-lg text-gray-600 mb-8">
                        Join thousands of teachers who have simplified their test creation process. 
                        Start building your question bank today!
                    </p>
                    {!auth?.user ? (
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Button size="lg" asChild>
                                <Link href="/register">Create Free Account</Link>
                            </Button>
                            <Button variant="outline" size="lg" asChild>
                                <Link href="/login">Sign In to Continue</Link>
                            </Button>
                        </div>
                    ) : (
                        <Button size="lg" asChild>
                            <Link href="/questions">Browse Your Questions 📝</Link>
                        </Button>
                    )}
                </div>
            </section>

            {/* Footer */}
            <footer className="bg-gray-900 text-white py-8">
                <div className="container mx-auto px-6 text-center">
                    <div className="flex items-center justify-center gap-2 mb-4">
                        <div className="h-6 w-6 bg-white rounded flex items-center justify-center">
                            <span className="text-gray-900 font-bold text-xs">📚</span>
                        </div>
                        <span className="text-lg font-semibold">TestCraft</span>
                    </div>
                    <p className="text-gray-400">
                        Empowering teachers with professional test creation tools.
                    </p>
                </div>
            </footer>
        </div>
    );
}