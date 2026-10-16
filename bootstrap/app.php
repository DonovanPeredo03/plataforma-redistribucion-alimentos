<?php

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->redirectGuestsTo(fn (Request $r) => route('admin.iniciar_sesion'));
    $middleware->redirectUsersTo(fn (Request $r) => route('admin.panel'));
})
    ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (HttpException $e, Request $request) {
        if ($e->getStatusCode() === 403 && auth('admin')->check()) {
            return redirect()->route('admin.panel')
                ->with('acceso_denegado', 'No tienes permiso para realizar esta acción.');
        }
    });
})->create();
