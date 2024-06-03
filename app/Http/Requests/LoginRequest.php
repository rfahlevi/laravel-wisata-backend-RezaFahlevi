<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6|max:255',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $formattedError = "";
        foreach ($errors->keys() as $field)
        {
            $formattedError = $errors->first($field);
        }

        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => $formattedError,
            ], 422)
        );
    }
}
