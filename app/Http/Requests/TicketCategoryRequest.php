<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

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
            'name' => ['required', 'max:255', 'string', 'unique:ticket_categories'],
            'description' => ['nullable', 'string'],
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $ticketCategorySlug = $this->route('slug');

            $rules['name'] = ['required', 'max:255', 'string', Rule::unique('ticket_categories')->ignore($ticketCategorySlug, 'slug')];
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
}
