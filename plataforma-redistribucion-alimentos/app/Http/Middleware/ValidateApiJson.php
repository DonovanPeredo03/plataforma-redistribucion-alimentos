<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiJson
{
    public function handle(Request $request, Closure $next): Response
    {
        // Aplicar esta validación solamente a la actividad 4.2.
        if ($request->is('api/v1/actividad-4-2/*')) {

            $metodosConContenido = ['POST', 'PUT', 'PATCH'];

            if (
                in_array($request->method(), $metodosConContenido) &&
                $request->getContent() !== ''
            ) {
                $tipoContenido = $request->header('Content-Type', '');

                // Aceptar JSON y formularios multipart para imágenes.
                $esJson = $request->isJson();

                $esFormulario = str_starts_with(
                    strtolower($tipoContenido),
                    'multipart/form-data'
                );

                if (!$esJson && !$esFormulario) {
                    return response()->json([
                        'success' => false,
                        'message' => 'El tipo de contenido enviado no es compatible.',
                        'data' => null,
                        'errors' => null
                    ], 415);
                }

                // Comprobar que el JSON tenga una estructura válida.
                if ($esJson) {
                    json_decode($request->getContent());

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        return response()->json([
                            'success' => false,
                            'message' => 'La estructura JSON enviada no es válida.',
                            'data' => null,
                            'errors' => null
                        ], 400);
                    }
                }
            }
        }

        return $next($request);
    }
}
