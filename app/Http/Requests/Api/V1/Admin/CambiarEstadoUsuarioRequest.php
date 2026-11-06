<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CambiarEstadoUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo' => [
                'required',
                'string',
                Rule::in(['cliente', 'admin']),
            ],

            'estado' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required' => 'Debes indicar el tipo de usuario.',
            'tipo.in' => 'El tipo debe ser cliente o admin.',
            'estado.required' => 'Debes indicar el estado.',
            'estado.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
