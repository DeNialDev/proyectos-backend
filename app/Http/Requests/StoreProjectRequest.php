<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:planning,active,paused,completed,cancelled',
            'priority' => 'nullable|string|in:low,medium,high,critical',
            'start_date' => 'nullable|date|date_format:Y-m-d',
            'due_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:start_date',
            'owner_id' => 'required|exists:users,id' // El dueño debe existir en la tabla users
        ];
    }
}