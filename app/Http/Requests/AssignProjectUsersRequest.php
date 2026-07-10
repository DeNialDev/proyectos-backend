<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignProjectUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        // El control de autorización por dueño lo hacemos en el controlador o política
        return true;
    }

    public function rules(): array
    {
        return [
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|integer|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'user_ids.required' => 'Es obligatorio enviar una lista de usuarios.',
            'user_ids.array' => 'Los usuarios deben venir en formato de arreglo.',
            'user_ids.*.exists' => 'Uno o más de los usuarios seleccionados no existen en el sistema.',
        ];
    }
}