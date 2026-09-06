<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage school settings') ?? false;
    }

    public function rules(): array
    {
        return [
            'government_name' => ['required', 'string', 'max:255'],
            'department_name' => ['required', 'string', 'max:255'],
            'branch_department_name' => ['nullable', 'string', 'max:255'],
            'school_name' => ['required', 'string', 'max:255'],
            'principal_name' => ['required', 'string', 'max:255'],
            'principal_nip' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:1000'],
            'website' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'province_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg', 'max:5120'],
            'school_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg', 'max:5120'],
        ];
    }
}
