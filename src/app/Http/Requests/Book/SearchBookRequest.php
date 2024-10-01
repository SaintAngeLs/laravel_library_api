<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class SearchBookRequest extends FormRequest
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
            'title' => ['nullable', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'client' => ['nullable', 'string', 'max:255'],
            'perPage' => ['nullable', 'integer', 'min:1'],
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
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'author.string' => 'The author name must be a valid string.',
            'author.max' => 'The author name may not be greater than 255 characters.',
            'publisher.string' => 'The publisher name must be a valid string.',
            'publisher.max' => 'The publisher name may not be greater than 255 characters.',
            'client.string' => 'The client name must be a valid string.',
            'client.max' => 'The client name may not be greater than 255 characters.',
            'perPage.integer' => 'The perPage value must be a valid integer.',
            'perPage.min' => 'The perPage value must be at least 1.',
        ];
    }
}
