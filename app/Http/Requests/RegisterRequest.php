<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'nama' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,except,id'],
            'hp' => ['required', 'unique:users,hp,except,id'],
            'alamat' => ['required', 'string'],
            'password' => ['required', 'min:8'],
            'konfirmasi_password' => ['same:password'],
        ];
    }
}
