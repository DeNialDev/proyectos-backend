<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:150',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|string|in:todo,in_progress,in_review,done',
            'priority' => 'sometimes|required|string|in:low,medium,high,urgent',
            'due_date' => 'nullable|date|date_format:Y-m-d',
            'project_id' => 'sometimes|required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id'
        ];
    }
}