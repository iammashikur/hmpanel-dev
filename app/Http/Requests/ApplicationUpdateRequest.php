<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationUpdateRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'technology_id' => ['required'],
            'technology_version_id' => ['required'],
            'domain' => ['required', 'string'],
            'directory' => ['required', 'string'],
            'database_id' => ['required'],
            'user_id' => ['required'],
        ];
    }
}