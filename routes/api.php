<?php

use App\Http\Controllers\Api\V1\Admin\UsuarioController;
use App\Http\Controllers\Api\V1\Admin\RecursoController;
use App\Http\Controllers\Api\V1\Admin\ReporteController;
use App\Http\Controllers\Api\V1\Admin\AuthController;
use App\Http\Controllers\Api\V1\ClienteAuthController;
use App\Http\Controllers\Api\V1\AlimentoController;
use App\Http\Controllers\Api\V1\OrdenController;
use App\Http\Controllers\Api\V1\ListaDeseoController;
use App\Http\Controllers\Api\V1\AlimentoApiController;
use App\Http\Controllers\Api\V1\OrdenApiController;
use App\Http\Controllers\Api\V1\Client\CatalogoPublicoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==========================================
// VERSIONAMIENTO DE LA API
// ==========================================

Route::prefix('v1')->group(function () {

    // ==========================================
    // ACTIVIDAD 4.2 - API REST
    // ==========================================

    Route::prefix('actividad-4-2')->group(function () {

        Route::apiResource('alimentos', AlimentoApiController::class);
        Route::apiResource('ordenes', OrdenApiController::class);

    });

    // ==========================================
    // AUTENTICACION
    // ==========================================

    Route::post('cliente/login', [
        ClienteAuthController::class,
        'iniciarSesion'
    ]);

    Route::post('admin/login', [
        AuthController::class,
        'login'
    ]);

    // ==========================================
    // ALIMENTOS - CONSULTAS PUBLICAS
    // ==========================================

    Route::get('alimentos', [
        AlimentoController::class,
        'index'
    ]);

    Route::get('alimentos/{id}', [
        AlimentoController::class,
        'show'
    ]);

    // ==========================================
    // ACTIVIDAD 5.3 - CLIENTE FINAL PUBLICO
    // SIN AUTENTICACION NI TOKENS
    // ==========================================

    Route::prefix('client')->group(function () {

        Route::get('catalogo', [
            CatalogoPublicoController::class,
            'index'
        ]);

        Route::get('catalogo/{id}', [
            CatalogoPublicoController::class,
            'show'
        ])->whereNumber('id');

        Route::get('informacion', [
            CatalogoPublicoController::class,
            'informacion'
        ]);

    });

    // ==========================================
    // RUTAS DEL CLIENTE - ACTIVIDAD 4.1
    // ==========================================

    Route::middleware(['auth:sanctum', 'verificar.tipo:cliente'])
        ->prefix('cliente')
        ->group(function () {

            Route::get('perfil', function (Request $request) {

                return response()->json([
                    'mensaje' => 'Perfil del cliente.',
                    'usuario' => $request->user(),
                ], 200);

            });

            Route::post('logout', function (Request $request) {

                $request->user()->currentAccessToken()->delete();

                return response()->json([
                    'mensaje' => 'Sesion cerrada correctamente.',
                ], 200);

            });

            Route::post('alimentos', [
                AlimentoController::class,
                'store'
            ]);

            Route::get('ordenes', [
                OrdenController::class,
                'index'
            ]);

            Route::get('ordenes/{id}', [
                OrdenController::class,
                'show'
            ]);

            Route::post('ordenes', [
                OrdenController::class,
                'store'
            ]);

            Route::get('lista-deseos', [
                ListaDeseoController::class,
                'index'
            ]);

            Route::post('lista-deseos', [
                ListaDeseoController::class,
                'store'
            ]);

            Route::delete('lista-deseos/{id}', [
                ListaDeseoController::class,
                'destroy'
            ]);

        });

    // ==========================================
    // RUTAS ADMINISTRATIVAS
    // ==========================================

    Route::middleware(['auth:sanctum', 'verificar.tipo:admin'])
        ->prefix('admin')
        ->group(function () {

            // Gestion de usuarios

            Route::get('usuarios', [
                UsuarioController::class,
                'index'
            ]);

            Route::patch('usuarios/{id}/estado', [
                UsuarioController::class,
                'cambiarEstado'
            ]);

            // Gestion de recursos

            Route::get('recursos', [
                RecursoController::class,
                'index'
            ]);

            Route::get('recursos/{id}', [
                RecursoController::class,
                'show'
            ]);

            Route::post('recursos', [
                RecursoController::class,
                'store'
            ]);

            Route::match(['put', 'patch'], 'recursos/{id}', [
                RecursoController::class,
                'update'
            ]);

            Route::delete('recursos/{id}', [
                RecursoController::class,
                'destroy'
            ]);

            // Reportes globales

            Route::get('reportes', [
                ReporteController::class,
                'index'
            ]);

            // Perfil del administrador

            Route::get('perfil', function (Request $request) {

                return response()->json([
                    'mensaje' => 'Perfil del administrador.',
                    'administrador' => $request->user(),
                ], 200);

            });

            // Logout administrador

            Route::post('logout', [
                AuthController::class,
                'logout'
            ]);

            // Gestion administrativa de alimentos

            Route::get('alimentos', [
                AlimentoController::class,
                'index'
            ]);

            Route::get('alimentos/{id}', [
                AlimentoController::class,
                'show'
            ]);

            Route::put('alimentos/{id}', [
                AlimentoController::class,
                'update'
            ]);

            Route::delete('alimentos/{id}', [
                AlimentoController::class,
                'destroy'
            ]);

            // Gestion administrativa de ordenes

            Route::get('ordenes', [
                OrdenController::class,
                'adminIndex'
            ]);

            Route::get('ordenes/{id}', [
                OrdenController::class,
                'adminShow'
            ]);

            Route::patch('ordenes/{id}/estado', [
                OrdenController::class,
                'updateEstado'
            ]);

        });

});
