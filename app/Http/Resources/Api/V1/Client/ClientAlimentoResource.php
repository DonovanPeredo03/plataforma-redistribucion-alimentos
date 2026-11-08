<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientAlimentoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
    'id_alimento'       => $this->id_alimento,
    'nombre'            => $this->nombre,
    'descripcion'       => $this->descripcion,
    'categoria'         => $this->categoria,
    'cantidad'          => $this->cantidad,
    'unidad'            => $this->unidad,
    'fecha_caducidad'   => $this->fecha_caducidad,
    'estado'            => $this->estado,
    'ruta_imagen'       => $this->ruta_imagen,
    ];
    }
}
