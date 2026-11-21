<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientOrdenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
    'id_orden'      => $this->id_orden,
    'fecha_orden'   => $this->fecha_orden,
    'estado'        => $this->estado,
    'fecha_entrega' => $this->fecha_entrega,
    'observaciones' => $this->observaciones,
    'detalles'      => $this->whenLoaded('detalles', fn () =>
        $this->detalles->map(fn ($d) => [
            'id_alimento' => $d->id_alimento,
            'alimento'    => $d->alimento?->nombre,
            'cantidad'    => $d->cantidad,
        ])
    ),
    ];
    }
}
