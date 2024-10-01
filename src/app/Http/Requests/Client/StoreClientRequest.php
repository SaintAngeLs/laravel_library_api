<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First Name is required.',
            'first_name.string' => 'First Name must be a string.',
            'first_name.max' => 'First Name may not be greater than 255 characters.',
            'last_name.required' => 'Last Name is required.',
            'last_name.string' => 'Last Name must be a string.',
            'last_name.max' => 'Last Name may not be greater than 255 characters.',
        ];
    }
}
