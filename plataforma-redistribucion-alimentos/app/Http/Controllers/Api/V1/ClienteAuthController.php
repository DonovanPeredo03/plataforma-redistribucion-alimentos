<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ClienteAuthController extends Controller
{
    /**
     * Iniciar sesión de un cliente y generar un token de acceso.
     */
    public function iniciarSesion(Request $request)
    {
        $datos = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $usuario = Usuario::where('email', $datos['email'])->first();

        if (
            ! $usuario ||
            ! Hash::check($datos['password'], $usuario->password) ||
            ! $usuario->estado
        ) {
            throw ValidationException::withMessages([
                'email' => [
                    'Las credenciales son incorrectas o la cuenta está deshabilitada.',
                ],
            ]);
        }

        $token = $usuario->createToken('api-cliente')->plainTextToken;

        return response()->json([
            'mensaje' => 'Inicio de sesión exitoso.',
            'token' => $token,
            'tipo' => 'Bearer',
            'cliente' => [
                'id_usuario' => $usuario->id_usuario,
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'email' => $usuario->email,
            ],
        ], 200);
    }
}