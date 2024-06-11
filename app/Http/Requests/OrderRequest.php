<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
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
        return [
            'cashier_id' => 'required|exists:users,id',
            'order_items' => 'required|array|min:1',
            'total_item' => 'required|integer|min:1',
            'total_price' => 'required|integer',
            'payment_method' => 'required|in:QRIS,Cash',
        ];
    }

    public function messages(): array
    {
        return [
            'cashier_id.*' => 'Kasir tidak ditemukan',
            'total_item.*' => 'Total item minimal 1',
            'total_price.*' => 'Total harga tidak valid',
            'payment_method.*' => 'Metode pembayaran tidak valid',
            'order_items.*' => 'Item pesanan tidak valid (Minimal 1 tiket)',
        ];
    }

    protected function failedValidation(Validator $validator)
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
