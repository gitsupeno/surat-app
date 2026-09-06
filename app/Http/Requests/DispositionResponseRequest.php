<?php

namespace App\Http\Requests;

use App\Models\Disposition;
use Illuminate\Foundation\Http\FormRequest;

class DispositionResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        $disposition = $this->route('disposition');

        return $this->user()?->can('disposition.respond')
            && $disposition instanceof Disposition
            && $disposition->assigned_to === $this->user()->id;
    }

    public function rules(): array
    {
        return ['response' => ['required', 'string', 'max:5000']];
    }
}
