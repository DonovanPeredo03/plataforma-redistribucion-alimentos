<?php

namespace App\Http\Requests\Api\V1\Client;


use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Orden;


class ClientResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         if ($this->isMethod('POST')) {
        return true;
    }
     $orden = Orden::findOrFail($this->route('id'));   
    return $this->user()->can('update', $orden);      
}
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $crear = $this->isMethod('POST');
        $req   = $crear ? 'required' : 'sometimes';
        
        return [
        'fecha_entrega'          => [$req, 'date', 'after_or_equal:today'],
        'observaciones'          => [$req, 'string', 'max:1000'],
        'detalles'               => [$crear ? 'required' : 'prohibited', 'array', 'min:1'],
        'detalles.*.id_alimento' => ['required', 'integer', 'exists:alimentos,id_alimento'],
        'detalles.*.cantidad'    => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
