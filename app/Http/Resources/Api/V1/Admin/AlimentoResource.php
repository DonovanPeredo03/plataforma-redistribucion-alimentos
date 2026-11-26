<?php

namespace App\Http\Resources\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlimentoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_alimento' => $this->id_alimento,
            'id_usuario' => $this->id_usuario,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'categoria' => $this->categoria,
            'cantidad' => $this->cantidad,
            'unidad' => $this->unidad,
            'fecha_publicacion' => $this->fecha_publicacion,
            'fecha_caducidad' => $this->fecha_caducidad,
            'estado' => $this->estado,
            'ruta_imagen' => $this->ruta_imagen,
        ];
    }
}
