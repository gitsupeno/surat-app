<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OutgoingLetterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can($this->isMethod('POST') ? 'create outgoing_letter' : 'create outgoing_letter') ?? false;
    }

    public function rules(): array
    {
        return [
            'date_letter' => ['required', 'date'],
            'recipient' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'classification_id' => ['nullable', 'exists:letter_classifications,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'status' => ['required', Rule::in(['draft', 'approval'])],
        ];
    }
}
