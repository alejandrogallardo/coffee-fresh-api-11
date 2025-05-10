<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegistroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // se cambia a true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRules::min(6)/*->letters()->symbols()->numbers()*/],
        ];
    }
    public function messages()
    {
        return [
          'name' => 'El Nombre es obligatorio',
          'email.required' => 'El Email es obligatorio',
          'email.email' => 'El email no es válido',
          'email.unique' => 'El email ya esta registrado',
          'password' => 'El Password es obligatorio',
        ];
    }
}
