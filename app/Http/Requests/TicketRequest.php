<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|unique:tickets',
            'description' => 'nullable',
            'price' => 'required|integer',
            'quota' => 'required|integer',
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'type' => 'required|in:Individu,Grup',
            'is_featured' => 'boolean',
        ];

        if($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $ticketSlug = $this->route('slug');
            $rules['name'] = ['required', Rule::unique('tickets')->ignore($ticketSlug, 'slug')];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'ticket_category_id.required' => 'Pilih kategori tiket terlebih dahulu',
            'ticket_category_id.exists' => 'Kategori tiket tidak valid',
            'status.in' => 'Status tiket tidak valid',
            'type.in' => 'Tipe tiket tidak valid',
            'is_featured.boolean' => 'Status tiket tidak valid',
            'quota.integer' => 'Kuota tiket harus berupa angka',
            'price.integer' => 'Harga tiket harus berupa angka',
            'name.required' => 'Masukkan nama tiket terlebih dahulu',
            'name.unique' => 'Tiket sudah terdaftar',
        ];
    }
}
