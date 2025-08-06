<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestPaperRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'grade_level' => 'required|string|max:50',
            'subject' => 'required|string|max:255',
            'duration_minutes' => 'nullable|integer|min:10|max:600',
            'instructions' => 'nullable|string',
            'question_ids' => 'required|array|min:1',
            'question_ids.*' => 'exists:questions,id',
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
            'title.required' => 'Test title is required.',
            'title.max' => 'Test title cannot exceed 255 characters.',
            'grade_level.required' => 'Grade level is required.',
            'subject.required' => 'Subject is required.',
            'duration_minutes.integer' => 'Duration must be a number in minutes.',
            'duration_minutes.min' => 'Test duration must be at least 10 minutes.',
            'duration_minutes.max' => 'Test duration cannot exceed 600 minutes (10 hours).',
            'question_ids.required' => 'At least one question must be selected.',
            'question_ids.array' => 'Invalid question selection format.',
            'question_ids.min' => 'At least one question must be selected.',
            'question_ids.*.exists' => 'One or more selected questions do not exist.',
        ];
    }
}