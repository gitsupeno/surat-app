<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DispositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('disposition.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'assigned_to' => ['required', 'exists:users,id'],
            'instruction' => ['required', 'string', 'max:5000'],
            'due_date' => ['nullable', 'date'],
        ];
    }
}
