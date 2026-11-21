<?php

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActualizarRecursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'sometimes',
                'required',
                'string',
                'min:2',
                'max:150',
            ],

            'descripcion' => [
                'sometimes',
                'required',
                'string',
                'min:5',
                'max:1000',
            ],

            'categoria' => [
                'sometimes',
                'required',
                Rule::in([
                    'Frutas y Verduras',
                    'Abarrotes y Enlatados',
                    'Panadería y Cereales',
                    'Lácteos y Refrigerados',
                ]),
            ],

            'cantidad' => [
                'sometimes',
                'required',
                'numeric',
                'min:0.01',
                'max:99999999.99',
            ],

            'unidad' => [
                'sometimes',
                'required',
                Rule::in([
                    'Unidades',
                    'Kilogramos',
                    'Gramos',
                    'Litros',
                ]),
            ],

            'fecha_caducidad' => [
                'sometimes',
                'required',
                'date',
            ],

            'estado' => [
                'sometimes',
                'required',
                'string',
                'max:20',
            ],
        ];
    }
}
