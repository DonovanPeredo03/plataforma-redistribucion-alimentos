<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\CambiarEstadoUsuarioRequest;
use App\Http\Resources\Api\V1\Admin\UsuarioResource;
use App\Http\Resources\Api\V1\Admin\AdministradorResource;
use App\Models\Usuario;
use App\Models\Administrador;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // GET /api/v1/admin/usuarios
    public function index(Request $request)
    {
        $clientes = Usuario::orderBy('id_usuario')->get();

        $administradores = Administrador::orderBy(
            'id_administrador'
        )->get();

        return response()->json([
            'success' => true,
            'message' => 'Usuarios consultados correctamente.',
            'data' => [
                'clientes' => UsuarioResource::collection(
                    $clientes
                )->resolve($request),

                'administradores' => AdministradorResource::collection(
                    $administradores
                )->resolve($request),
            ],
            'errors' => null,
        ], 200);
    }

    // PATCH /api/v1/admin/usuarios/{id}/estado
    public function cambiarEstado(
        CambiarEstadoUsuarioRequest $request,
        $id
    ) {
        $datos = $request->validated();

        if ($datos['tipo'] === 'cliente') {
            $usuario = Usuario::find($id);
        } else {
            $usuario = Administrador::find($id);
        }

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado.',
                'data' => null,
                'errors' => null,
            ], 404);
        }

        // Evitar que el administrador cierre su propio acceso.
        if (
            $datos['tipo'] === 'admin' &&
            (int) $request->user()->getKey() ===
                (int) $usuario->getKey() &&
            $datos['estado'] === false
        ) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes desactivar tu propia cuenta administrativa.',
                'data' => null,
                'errors' => null,
            ], 403);
        }

        $usuario->estado = $datos['estado'];
        $usuario->save();

        // Si la cuenta se desactiva, revocar sus tokens.
        if (!$usuario->estado) {
            $usuario->tokens()->delete();
        }

        $recurso = $datos['tipo'] === 'cliente'
            ? new UsuarioResource($usuario)
            : new AdministradorResource($usuario);

        return response()->json([
            'success' => true,
            'message' => 'Estado del usuario actualizado correctamente.',
            'data' => $recurso->resolve($request),
            'errors' => null,
        ], 200);
    }
}
