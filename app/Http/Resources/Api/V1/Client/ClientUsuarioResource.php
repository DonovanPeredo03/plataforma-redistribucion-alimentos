<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientUsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
    'id_usuario'     => $this->id_usuario,
    'nombre'         => $this->nombre,
    'apellido'       => $this->apellido,
    'email'          => $this->email,
    'telefono'       => $this->{'teléfono'},
    'direccion'      => $this->direccion,
    'fecha_registro' => $this->fecha_registro,
    ];
    }
}
