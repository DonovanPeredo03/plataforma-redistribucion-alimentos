<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function iniciarSesion(Request $request)
    {
        $datos = $request->validate([
            'correo' => ['required', 'email'],
            'contrasena' => ['required', 'string'],
        ]);

        $administrador = Administrador::where(
            'correo',
            $datos['correo']
        )->first();

        if (
            ! $administrador ||
            ! Hash::check($datos['contrasena'], $administrador->contrasena) ||
            ! $administrador->estado
        ) {
            throw ValidationException::withMessages([
                'correo' => [
                    'Las credenciales son incorrectas o la cuenta está deshabilitada.',
                ],
            ]);
        }

        $token = $administrador->createToken('api-administrador')->plainTextToken;

        return response()->json([
            'mensaje' => 'Inicio de sesión exitoso.',
            'token' => $token,
            'tipo' => 'Bearer',
            'administrador' => [
                'id_administrador' => $administrador->id_administrador,
                'nombre' => $administrador->nombre,
                'correo' => $administrador->correo,
                'perfil' => $administrador->perfil,
            ],
        ], 200);
    }
}