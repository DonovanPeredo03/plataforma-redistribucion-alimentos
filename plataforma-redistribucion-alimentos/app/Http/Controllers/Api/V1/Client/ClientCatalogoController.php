<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Resources\Api\V1\Client\ClientAlimentoResource;
use App\Models\Alimento;
use Illuminate\Http\Request;

class ClientCatalogoController extends ClientController
{
    public function index()
    {
        return $this->ok(
            'Catálogo consultado correctamente.',
            ClientAlimentoResource::collection(Alimento::orderByDesc('id_alimento')->get())
        );
    }

    public function show($id)
    {
        $alimento = Alimento::findOrFail($id);

        return $this->ok(
            'Alimento encontrado.',
            new ClientAlimentoResource($alimento)
        );
    }
}
