<?php

namespace App\Http\Middleware;

use App\Models\Administrador;
use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarTipoUsuarioApi
{
    public function handle(Request $request, Closure $next, string $tipo): Response
    {
        $usuario = $request->user();

        if ($tipo === 'admin' && ! ($usuario instanceof Administrador)) {
            return response()->json([
                'mensaje' => 'No tienes autorización para acceder a esta área.',
            ], 403);
        }

        if ($tipo === 'cliente' && ! ($usuario instanceof Usuario)) {
            return response()->json([
                'mensaje' => 'No tienes autorización para acceder a esta área.',
            ], 403);
        }

        return $next($request);
    }
}