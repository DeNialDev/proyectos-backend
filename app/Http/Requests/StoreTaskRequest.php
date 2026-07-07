<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:todo,in_progress,in_review,done',
            'priority' => 'nullable|string|in:low,medium,high,urgent',
            'due_date' => 'nullable|date|date_format:Y-m-d',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id'
        ];
    }
}