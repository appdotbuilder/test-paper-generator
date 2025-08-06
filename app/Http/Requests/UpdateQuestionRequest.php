<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,descriptive,matching,fill_in_blank',
            'options' => 'nullable|array',
            'correct_answer' => 'required|string',
            'grade_level' => 'required|string|max:50',
            'textbook' => 'required|string|max:255',
            'chapter' => 'required|string|max:255',
            'source' => 'required|in:textbook,sample_exam,practice_sheet,custom',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'points' => 'required|integer|min:1|max:100',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'question_text.required' => 'Question text is required.',
            'question_type.required' => 'Please select a question type.',
            'question_type.in' => 'Invalid question type selected.',
            'correct_answer.required' => 'Correct answer is required.',
            'grade_level.required' => 'Grade level is required.',
            'textbook.required' => 'Textbook name is required.',
            'chapter.required' => 'Chapter name is required.',
            'source.required' => 'Source is required.',
            'source.in' => 'Invalid source selected.',
            'difficulty_level.required' => 'Difficulty level is required.',
            'difficulty_level.in' => 'Invalid difficulty level selected.',
            'points.required' => 'Points value is required.',
            'points.integer' => 'Points must be a number.',
            'points.min' => 'Points must be at least 1.',
            'points.max' => 'Points cannot exceed 100.',
        ];
    }
}