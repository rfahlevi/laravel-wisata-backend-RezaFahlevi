<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TicketRequest extends FormRequest
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
            'image' => 'nullable',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|integer',
            'quota' => 'required|integer',
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'status' => ['required', Rule::in(['Tersedia', 'Tidak Tersedia'])],
            'type' => ['required', Rule::in(['Domestik', 'Mancanegara'])],
            'is_featured' => 'boolean|in:0,1',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'ticket_category_id.required' => 'Pilih kategori tiket terlebih dahulu',
            'ticket_category_id.exists' => 'Kategori tiket tidak valid',
            'status.in' => 'Status tiket tidak valid',
            'type.required' => 'Pilih tipe tiket terlebih dahulu',
            'type.in' => 'Tipe tiket tidak valid',
            'is_featured.*' => 'Produk unggulan tidak valid',
            'quota.integer' => 'Kuota tiket harus berupa angka',
            'quota.required' => 'Kuota tiket harus diisi',
            'price.required' => 'Harga tiket harus diisi',
            'price.integer' => 'Harga tiket harus berupa angka',
            'name.required' => 'Masukkan nama tiket terlebih dahulu',
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
