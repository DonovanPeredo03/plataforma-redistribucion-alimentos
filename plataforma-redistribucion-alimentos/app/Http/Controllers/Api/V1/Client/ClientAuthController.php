<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Requests\Api\V1\Client\ClientLoginRequest;
use App\Http\Requests\Api\V1\Client\ClientRegisterRequest;
use App\Http\Resources\Api\V1\Client\ClientUsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends ClientController
{
   public function register(ClientRegisterRequest $request)
{
    $d = $request->validated();   // el rol NO viene del payload

    $usuario = DB::transaction(fn () => Usuario::create([
        'id_usuario'     => (Usuario::max('id_usuario') ?? 0) + 1,
        'id_rol'         => Usuario::ROL_CLIENTE,
        'nombre'         => $d['nombre'],
        'apellido'       => $d['apellido'],
        'email'          => $d['email'],
        'password'       => Hash::make($d['password']),
        'teléfono'       => $d['telefono'],
        'direccion'      => $d['direccion'],
        'tipo_login'     => 'local',
        'fecha_registro' => now(),
        'estado'         => 1,
    ]));

    return $this->ok('Cliente registrado correctamente.', new ClientUsuarioResource($usuario), 201);
}

public function login(ClientLoginRequest $request)
{
    $d = $request->validated();
    $usuario = Usuario::where('email', $d['email'])->first();

    if (! $usuario || ! Hash::check($d['password'], $usuario->password) || ! $usuario->estado) {
        return response()->json([
            'success' => false,
            'message' => 'Credenciales incorrectas o cuenta deshabilitada.',
            'data' => null, 'errors' => null,
        ], 401);
    }

    return $this->ok('Inicio de sesión exitoso.', [
        'token'      => $usuario->createToken('client-token')->plainTextToken,
        'token_type' => 'Bearer',
        'cliente'    => (new ClientUsuarioResource($usuario))->resolve($request),
    ]);
}

public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();
    return $this->ok('Sesión cerrada correctamente.');
}
}
