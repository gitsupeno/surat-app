<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IncomingLetterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can($this->isMethod('POST') ? 'create incoming_letter' : 'update incoming_letter') ?? false;
    }

    public function rules(): array
    {
        return [
            'mail_number' => ['nullable', 'string', 'max:255'],
            'date_letter' => ['nullable', 'date'],
            'date_received' => ['nullable', 'date'],
            'sender' => ['nullable', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'sifat_id' => ['nullable', 'exists:jenis_surat,id'],
            'classification_id' => ['nullable', 'exists:letter_classifications,id'],
            'unit_id' => ['nullable', 'exists:units,id'],
            'status' => ['required', Rule::in(['baru', 'didisposisikan', 'selesai'])],
            'notes' => ['nullable', 'string'],
            'document' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
        ];
    }
}
