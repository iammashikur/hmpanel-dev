<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConnectionUpdateRequest extends FormRequest
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
            'username' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:6'],
            'access_token' => ['nullable', 'string'],
            'ip' => ['nullable'],
            'port' => ['nullable'],
            'connection_type_id' => ['required'],
            'application_id' => ['required'],
            'user_id' => ['required'],
        ];
    }
}
