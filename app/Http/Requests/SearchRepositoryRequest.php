<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Form request for validating repository search input.
 */

class SearchRepositoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool True if authorized.
     */

    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules for the request.
     *
     * @return array The array of validation rules.
     */

    public function rules(): array
    {
        return [
            'q' => 'required|string|max:256',
        ];
    }
     /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator The validator instance.
     * @throws HttpResponseException Exception with a 400 response.
     */

    protected function failedValidation(Validator $validator)
    {
        // Throw an exception with a 400 Bad Request status code
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 400)
        );
    }
}
