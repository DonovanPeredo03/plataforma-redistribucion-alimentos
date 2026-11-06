<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(
            fn (Request $r) => route('admin.iniciar_sesion')
        );

        $middleware->redirectUsersTo(
            fn (Request $r) => route('admin.panel')
        );

        $middleware->alias([
            'verificar.tipo' => \App\Http\Middleware\VerificarTipoUsuarioApi::class,
        ]);

        // Validar el JSON recibido en las solicitudes de la API.
        $middleware->appendToGroup(
            'api',
            \App\Http\Middleware\ValidateApiJson::class
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Reconocer las solicitudes de la API como solicitudes JSON.
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request, \Throwable $e) =>
                $request->is('api/*') || $request->expectsJson()
        );

        // Estandarizar los errores de la API.
        $exceptions->render(function (\Throwable $e, Request $request) {

            if ($request->is('api/*')) {

                $status = 500;
                $message = 'Ocurrió un error interno al procesar la solicitud';
                $errors = null;

                // Errores de validación.
                if ($e instanceof ValidationException) {
                    $status = 422;
                    $message = 'Los datos enviados no son válidos';
                    $errors = $e->errors();
                }

                // Token ausente, incorrecto o revocado.
elseif ($e instanceof AuthenticationException) {
    $status = 401;
    $message = 'No autenticado. Debes enviar un token válido.';
}

                // Registros inexistentes.
                elseif ($e instanceof ModelNotFoundException) {
                    $status = 404;
                    $message = 'El recurso solicitado no existe';
                }

                // Otros errores HTTP.
                elseif ($e instanceof HttpExceptionInterface) {
                    $status = $e->getStatusCode();

                    $message = match ($status) {
                        400 => 'La solicitud enviada es incorrecta',
                        401 => 'No se ha autorizado la solicitud',
                        403 => 'No tienes permiso para realizar esta operación',
                        404 => 'El recurso solicitado no existe',
                        405 => 'El método HTTP no está permitido para este endpoint',
                        409 => 'No se puede completar la operación por un conflicto con el recurso',
                        413 => 'El archivo o la solicitud supera el tamaño permitido',
                        415 => 'El tipo de contenido enviado no es compatible',
                        422 => 'Los datos enviados no son válidos',
                        default => 'No fue posible procesar la solicitud',
                    };
                }

                if ($status === 500) {
    \Illuminate\Support\Facades\Log::error(
        'Error interno en la API',
        [
            'ruta' => $request->path(),
            'metodo' => $request->method(),
            'mensaje' => $e->getMessage(),
            'archivo' => $e->getFile(),
            'linea' => $e->getLine(),
        ]
    );
}
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'data' => null,
                    'errors' => $errors,
                ], $status);
            }

            // Conservar el comportamiento de la sección web
            // cuando un administrador recibe un error 403.
            if (
                $e instanceof HttpExceptionInterface &&
                $e->getStatusCode() === 403 &&
                auth('admin')->check()
            ) {
                return redirect()->route('admin.panel')
                    ->with(
                        'acceso_denegado',
                        'No tienes permiso para realizar esta acción.'
                    );
            }

            // Permitir que Laravel gestione normalmente
            // las excepciones de las rutas web.
            return null;
        });

    })
    ->create();
