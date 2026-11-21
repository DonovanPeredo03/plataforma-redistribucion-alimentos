<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'nombre'    => ['required', 'string', 'max:100'],
        'apellido'  => ['required', 'string', 'max:100'],
        'email'     => ['required', 'email', 'max:150', 'unique:usuarios,email'],
        'password'  => ['required', 'string', 'min:8', 'confirmed'],
        'telefono'  => ['required', 'string', 'max:20'],
        'direccion' => ['required', 'string', 'max:255'],
        ];
    }
}
