<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Requests\Api\V1\Client\ClientPerfilRequest;
use App\Http\Resources\Api\V1\Client\ClientUsuarioResource;
use Illuminate\Http\Request;

class ClientPerfilController extends ClientController
{
    public function show(Request $request)
    {
        return $this->ok(
            'Perfil consultado correctamente.',
            new ClientUsuarioResource($request->user())
        );
    }

    public function update(ClientPerfilRequest $request)
    {
        $datos = $request->validated();

        if (array_key_exists('telefono', $datos)) {
            $datos['teléfono'] = $datos['telefono'];
            unset($datos['telefono']);
        }

        $usuario = $request->user();
        $usuario->update($datos);

        return $this->ok(
            'Perfil actualizado correctamente.',
            new ClientUsuarioResource($usuario)
        );
    }
}