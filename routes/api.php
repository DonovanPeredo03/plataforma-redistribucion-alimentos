
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\ClienteAuthController;
use App\Http\Controllers\Api\V1\AdminAuthController;
use App\Http\Controllers\Api\V1\AlimentoController;
use App\Http\Controllers\Api\V1\OrdenController;
use App\Http\Controllers\Api\V1\ListaDeseoController;

// Controladores de la actividad 4.2
use App\Http\Controllers\Api\V1\AlimentoApiController;
use App\Http\Controllers\Api\V1\OrdenApiController;


Route::prefix('v1')->group(function () {

    // ==========================================
    // ACTIVIDAD 4.2 - API REST SIN AUTENTICACIÓN
    // ==========================================

    Route::prefix('actividad-4-2')->group(function () {

        // CRUD de alimentos
        Route::apiResource('alimentos', AlimentoApiController::class);

        // CRUD de órdenes
        Route::apiResource('ordenes', OrdenApiController::class);

    });


    // ==========================================
    // AUTENTICACIÓN - ACTIVIDAD 4.1
    // ==========================================

    Route::post('cliente/login', [ClienteAuthController::class, 'iniciarSesion']);
    Route::post('admin/login', [AdminAuthController::class, 'iniciarSesion']);


    // ==========================================
    // ALIMENTOS - CONSULTAS PÚBLICAS
    // ==========================================

    Route::get('alimentos', [AlimentoController::class, 'index']);
    Route::get('alimentos/{id}', [AlimentoController::class, 'show']);


    // ==========================================
    // RUTAS DEL CLIENTE
    // ==========================================

    Route::middleware(['auth:sanctum', 'verificar.tipo:cliente'])
        ->prefix('cliente')
        ->group(function () {

            // Perfil del cliente
            Route::get('perfil', function (Request $request) {
                return response()->json([
                    'mensaje' => 'Perfil del cliente.',
                    'usuario' => $request->user(),
                ], 200);
            });

            // Cerrar sesión
            Route::post('logout', function (Request $request) {
                $request->user()->currentAccessToken()->delete();

                return response()->json([
                    'mensaje' => 'Sesión cerrada correctamente.',
                ], 200);
            });

            // Publicación de alimentos
            Route::post('alimentos', [AlimentoController::class, 'store']);

            // Órdenes del cliente
            Route::get('ordenes', [OrdenController::class, 'index']);
            Route::get('ordenes/{id}', [OrdenController::class, 'show']);
            Route::post('ordenes', [OrdenController::class, 'store']);

            // Lista de deseos
            Route::get('lista-deseos', [ListaDeseoController::class, 'index']);
            Route::post('lista-deseos', [ListaDeseoController::class, 'store']);
            Route::delete('lista-deseos/{id}', [ListaDeseoController::class, 'destroy']);
        });


    // ==========================================
    // RUTAS DEL ADMINISTRADOR
    // ==========================================

    Route::middleware(['auth:sanctum', 'verificar.tipo:admin'])
        ->prefix('admin')
        ->group(function () {

            // Perfil del administrador
            Route::get('perfil', function (Request $request) {
                return response()->json([
                    'mensaje' => 'Perfil del administrador.',
                    'administrador' => $request->user(),
                ], 200);
            });

            // Cerrar sesión
            Route::post('logout', function (Request $request) {
                $request->user()->currentAccessToken()->delete();

                return response()->json([
                    'mensaje' => 'Sesión cerrada correctamente.',
                ], 200);
            });

            // Gestión administrativa de alimentos
            Route::get('alimentos', [AlimentoController::class, 'index']);
            Route::get('alimentos/{id}', [AlimentoController::class, 'show']);
            Route::put('alimentos/{id}', [AlimentoController::class, 'update']);
            Route::delete('alimentos/{id}', [AlimentoController::class, 'destroy']);

            // Gestión administrativa de órdenes
            Route::get('ordenes', [OrdenController::class, 'adminIndex']);
            Route::get('ordenes/{id}', [OrdenController::class, 'adminShow']);
            Route::patch('ordenes/{id}/estado', [OrdenController::class, 'updateEstado']);
        });

});
