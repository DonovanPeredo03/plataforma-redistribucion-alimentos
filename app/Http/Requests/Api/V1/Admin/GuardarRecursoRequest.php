<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuardarRecursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_usuario' => [
                'required',
                'integer',
                Rule::exists('usuarios', 'id_usuario'),
            ],

            'nombre' => [
                'required',
                'string',
                'min:2',
                'max:150',
            ],

            'descripcion' => [
                'required',
                'string',
                'min:5',
                'max:1000',
            ],

            'categoria' => [
                'required',
                Rule::in([
                    'Frutas y Verduras',
                    'Abarrotes y Enlatados',
                    'Panadería y Cereales',
                    'Lácteos y Refrigerados',
                ]),
            ],

            'cantidad' => [
                'required',
                'numeric',
                'min:0.01',
                'max:99999999.99',
            ],

            'unidad' => [
                'required',
                Rule::in([
                    'Unidades',
                    'Kilogramos',
                    'Gramos',
                    'Litros',
                ]),
            ],

            'fecha_caducidad' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'estado' => [
                'sometimes',
                'required',
                'string',
                'max:20',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario.required' => 'Debes indicar el usuario propietario.',
            'id_usuario.exists' => 'El usuario indicado no existe.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'categoria.in' => 'La categoría seleccionada no es válida.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.min' => 'La cantidad debe ser mayor que cero.',
            'unidad.in' => 'La unidad seleccionada no es válida.',
            'fecha_caducidad.required' => 'La fecha de caducidad es obligatoria.',
        ];
    }
}
