<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientPerfilRequest extends FormRequest
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
        'nombre'    => ['sometimes', 'required', 'string', 'max:100'],
        'apellido'  => ['sometimes', 'required', 'string', 'max:100'],
        'email'     => ['sometimes', 'required', 'email', 'max:150',
            Rule::unique('usuarios', 'email')->ignore($this->user()->id_usuario, 'id_usuario')],
        'telefono'  => ['sometimes', 'required', 'string', 'max:20'],
        'direccion' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }
}
