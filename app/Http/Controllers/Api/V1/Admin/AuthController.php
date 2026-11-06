<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Iniciar sesión del administrador.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => ['required', 'email'],
            'contrasena' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Los datos proporcionados no son válidos.',
                'data' => null,
                'errors' => $validator->errors(),
            ], 422);
        }

        $datos = $validator->validated();

        $administrador = Administrador::where(
            'correo',
            $datos['correo']
        )->first();

        if (
            ! $administrador ||
            ! Hash::check(
                $datos['contrasena'],
                $administrador->contrasena
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas.',
                'data' => null,
                'errors' => null,
            ], 401);
        }

        if (! $administrador->estado) {
            return response()->json([
                'success' => false,
                'message' => 'La cuenta del administrador está deshabilitada.',
                'data' => null,
                'errors' => null,
            ], 403);
        }

        $token = $administrador
            ->createToken('admin-token')
            ->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso.',
            'data' => [
                'administrador' => [
                    'id_administrador' => $administrador->id_administrador,
                    'nombre' => $administrador->nombre,
                    'correo' => $administrador->correo,
                    'perfil' => $administrador->perfil,
                ],
                'token' => $token,
                'tipo' => 'Bearer',
            ],
            'errors' => null,
        ], 200);
    }

    /**
     * Cerrar sesión del administrador.
     */
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        if (! $token) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró un token activo.',
                'data' => null,
                'errors' => null,
            ], 401);
        }

        $token->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.',
            'data' => null,
            'errors' => null,
        ], 200);
    }
}
