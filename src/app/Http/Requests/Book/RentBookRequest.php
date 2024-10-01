<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class RentBookRequest extends FormRequest
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
            'client_id' => ['required', 'exists:clients,id'],
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
            'client_id.required' => 'The client selection is required to rent a book.',
            'client_id.exists' => 'The selected client does not exist in our records. Please choose a valid client.',
        ];
    }
}
