<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|numeric',
            'role' => ['required', 'string', 'max:255', Rule::in(['Admin', 'Manager', 'Staff'])],
        ];

        if($this->isMethod('POST')) {
            $rules['password'] = ['required', 'max:255', 'min:5'];
        }

        if($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $userSlug = $this->route('slug');

            $rules['email'] = ['required', 'email', 'max:255', Rule::unique('users')->ignore($userSlug, 'slug')];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'name.string' => 'Format harus berupa string',
            'name.max' => 'Maksimal 255 karakter',
            'email.required' => 'Email user tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Maksimal 255 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.max' => 'Maksimal 255 karakter',
            'password.min' => 'Password minimal 5 karakter',
            'role.required' => 'Role tidak boleh kosong',
            'role.string' => 'Format harus berupa string',
            'role.in' => 'Role user tidak valid',
            'phone.numeric' => 'Format telepon tidak valid, harus berupa angka',
            'phone.max' => 'Panjang maksimal nomor telepon 15 karakter'
        ];
    }
}
