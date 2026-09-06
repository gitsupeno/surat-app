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
            'jenis_surat_id' => ['required', 'exists:jenis_surat,id'],
            'sifat' => ['required', Rule::in(['biasa', 'penting', 'segera', 'rahasia'])],
            'lampiran' => ['nullable', 'string', 'max:255'],
            'recipient' => ['required', 'string', 'max:255'],
            'recipient_position' => ['nullable', 'string', 'max:255'],
            'recipient_address' => ['nullable', 'string', 'max:1000'],
            'recipient_email' => ['nullable', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'opening' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'closing' => ['nullable', 'string'],
            'signer_name' => ['required', 'string', 'max:255'],
            'signer_nip' => ['nullable', 'string', 'max:50'],
            'signer_position' => ['required', 'string', 'max:255'],
            'use_letterhead' => ['nullable', 'boolean'],
            'classification_id' => ['nullable', 'exists:letter_classifications,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'status' => ['nullable', Rule::in(['draft', 'menunggu_verifikasi'])],
        ];
    }
}
