<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;

class TicketCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique('ticket_categories')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'description' => ['nullable', 'string'],
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            if (!$this->expectsJson()) {
                $ticketCategorySlug = $this->route('slug');
                $rules['name'] = ['required', 'max:255', 'string', Rule::unique('ticket_categories')->ignore($ticketCategorySlug, 'slug')];
            } else {
                $ticketCategoryId = $this->route('ticket_category');
                $rules['name'] = ['required', 'max:255', 'string', Rule::unique('ticket_categories')->ignore($ticketCategoryId, 'id')];
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori tidak boleh kosong',
            'name.unique' => 'Nama Kategori sudah terdaftar',
            'description.string' => 'Deskripsi kategori harus berupa teks',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $formattedError = '';
        foreach ($errors->keys() as $field) {
            $formattedError = $errors->first($field);
        }

        if ($this->expectsJson()) {
            throw new HttpResponseException(
                response()->json(
                    [
                        'status' => false,
                        'message' => $formattedError,
                    ],
                    422,
                ),
            );
        }
    }
}
