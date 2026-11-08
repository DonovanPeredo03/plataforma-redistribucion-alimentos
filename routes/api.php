<?php

use App\Http\Controllers\Api\V1\Admin\UsuarioController;
use App\Http\Controllers\Api\V1\Admin\RecursoController;
use App\Http\Controllers\Api\V1\Admin\ReporteController;
use App\Http\Controllers\Api\V1\Admin\AuthController;

// CONTROLADORES DE CLIENTE (NUEVA ESTRUCTURA V1 CLIENT)
use App\Http\Controllers\Api\V1\Client\ClientAuthController;
use App\Http\Controllers\Api\V1\Client\ClientCatalogoController;
use App\Http\Controllers\Api\V1\Client\ClientPerfilController;
use App\Http\Controllers\Api\V1\Client\ClientRegistroController;

// OTROS CONTROLADORES
use App\Http\Controllers\Api\V1\ClienteAuthController;
use App\Http\Controllers\Api\V1\AlimentoController;
use App\Http\Controllers\Api\V1\OrdenController;
use App\Http\Controllers\Api\V1\ListaDeseoController;
use App\Http\Controllers\Api\V1\AlimentoApiController;
use App\Http\Controllers\Api\V1\OrdenApiController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==========================================
// VERSIONAMIENTO DE LA API
// ==========================================

Route::prefix('v1')->group(function () {

    // ==========================================
    // NUEVAS RUTAS CLIENT
    // ==========================================
    
    
    Route::prefix('client')->group(function () {

        // Públicas
        Route::post('register', [ClientAuthController::class, 'register']);
        Route::post('login',    [ClientAuthController::class, 'login']);
        Route::get('catalogo',      [ClientCatalogoController::class, 'index']);
        Route::get('catalogo/{id}', [ClientCatalogoController::class, 'show']);

        // Protegidas
        Route::middleware(['auth:sanctum', 'verificar.tipo:cliente'])->group(function () {
            Route::post('logout', [ClientAuthController::class, 'logout']);

            Route::get('perfil', [ClientPerfilController::class, 'show']);
            Route::match(['put', 'patch'], 'perfil', [ClientPerfilController::class, 'update']);

            Route::get('mis-registros',         [ClientRegistroController::class, 'index']);
            Route::post('mis-registros',        [ClientRegistroController::class, 'store']);
            Route::get('mis-registros/{id}',    [ClientRegistroController::class, 'show']);
            Route::match(['put', 'patch'], 'mis-registros/{id}', [ClientRegistroController::class, 'update']);
            Route::delete('mis-registros/{id}', [ClientRegistroController::class, 'destroy']);
        });
    });

    // ==========================================
    // ACTIVIDAD 4.2 - API REST
    // ==========================================
    Route::prefix('actividad-4-2')->group(function () {
        Route::apiResource('alimentos', AlimentoApiController::class);
        Route::apiResource('ordenes', OrdenApiController::class);
    });

    // ==========================================
    // AUTENTICACION ANTERIOR
    // ==========================================
    Route::post('cliente/login', [ClienteAuthController::class, 'iniciarSesion']);
    Route::post('admin/login', [AuthController::class, 'login']);

    // ==========================================
    // ALIMENTOS - CONSULTAS PUBLICAS
    // ==========================================
    Route::get('alimentos', [AlimentoController::class, 'index']);
    Route::get('alimentos/{id}', [AlimentoController::class, 'show']);

    // ==========================================
    // RUTAS DEL CLIENTE - ACTIVIDAD 4.1
    // ==========================================
    Route::middleware(['auth:sanctum', 'verificar.tipo:cliente'])
        ->prefix('cliente')
        ->group(function () {
            Route::get('perfil', fn(Request $request) => response()->json(['mensaje' => 'Perfil del cliente.', 'usuario' => $request->user()]));
            Route::post('logout', function (Request $request) {
                $request->user()->currentAccessToken()->delete();
                return response()->json(['mensaje' => 'Sesion cerrada correctamente.']);
            });

            Route::post('alimentos', [AlimentoController::class, 'store']);
            Route::get('ordenes', [OrdenController::class, 'index']);
            Route::get('ordenes/{id}', [OrdenController::class, 'show']);
            Route::post('ordenes', [OrdenController::class, 'store']);
            Route::get('lista-deseos', [ListaDeseoController::class, 'index']);
            Route::post('lista-deseos', [ListaDeseoController::class, 'store']);
            Route::delete('lista-deseos/{id}', [ListaDeseoController::class, 'destroy']);
        });

    // ==========================================
    // RUTAS ADMINISTRATIVAS - ACTIVIDAD 4.3
    // ==========================================
    Route::middleware(['auth:sanctum', 'verificar.tipo:admin'])
        ->prefix('admin')
        ->group(function () {
            Route::get('usuarios', [UsuarioController::class, 'index']);
            Route::patch('usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado']);
            Route::get('recursos', [RecursoController::class, 'index']);
            Route::get('recursos/{id}', [RecursoController::class, 'show']);
            Route::post('recursos', [RecursoController::class, 'store']);
            Route::match(['put', 'patch'], 'recursos/{id}', [RecursoController::class, 'update']);
            Route::delete('recursos/{id}', [RecursoController::class, 'destroy']);
            Route::get('reportes', [ReporteController::class, 'index']);
            Route::get('perfil', fn(Request $request) => response()->json(['mensaje' => 'Perfil del administrador.', 'administrador' => $request->user()]));
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('alimentos', [AlimentoController::class, 'index']);
            Route::get('alimentos/{id}', [AlimentoController::class, 'show']);
            Route::put('alimentos/{id}', [AlimentoController::class, 'update']);
            Route::delete('alimentos/{id}', [AlimentoController::class, 'destroy']);
            Route::get('ordenes', [OrdenController::class, 'adminIndex']);
            Route::get('ordenes/{id}', [OrdenController::class, 'adminShow']);
            Route::patch('ordenes/{id}/estado', [OrdenController::class, 'updateEstado']);
        });

});