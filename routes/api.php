<?php

use App\Http\Controllers\Api\V1\Admin\UsuarioController;
use App\Http\Controllers\Api\V1\Admin\RecursoController;
use App\Http\Controllers\Api\V1\Admin\ReporteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==========================================
// CONTROLADORES DE AUTENTICACION
// ==========================================

use App\Http\Controllers\Api\V1\ClienteAuthController;

// ==========================================
// CONTROLADORES DEL SISTEMA
// ==========================================

use App\Http\Controllers\Api\V1\AlimentoController;
use App\Http\Controllers\Api\V1\OrdenController;
use App\Http\Controllers\Api\V1\ListaDeseoController;

// ==========================================
// CONTROLADORES ACTIVIDAD 4.2
// ==========================================

use App\Http\Controllers\Api\V1\AlimentoApiController;
use App\Http\Controllers\Api\V1\OrdenApiController;

// ==========================================
// CONTROLADOR ACTIVIDAD 4.3
// ==========================================

use App\Http\Controllers\Api\V1\Admin\AuthController;

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

    // Login cliente - Actividad 4.1
    Route::post('cliente/login', [
        ClienteAuthController::class,
        'iniciarSesion'
    ]);

    // Login administrador - Actividad 4.3
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
    // RUTAS DEL CLIENTE - ACTIVIDAD 4.1
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

            // Cerrar sesion del cliente
            Route::post('logout', function (Request $request) {

                $request->user()->currentAccessToken()->delete();

                return response()->json([
                    'mensaje' => 'Sesion cerrada correctamente.',
                ], 200);

            });

            // Publicacion de alimentos
            Route::post('alimentos', [
                AlimentoController::class,
                'store'
            ]);

            // Ordenes del cliente
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

            // Lista de deseos
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
    // RUTAS ADMINISTRATIVAS - ACTIVIDAD 4.3
    // ==========================================

    Route::middleware(['auth:sanctum', 'verificar.tipo:admin'])
        ->prefix('admin')
        ->group(function () {

        
// ==========================================
// GESTION DE USUARIOS - ACTIVIDAD 4.3
// ==========================================

// Listar clientes y administradores
Route::get('usuarios', [
    UsuarioController::class,
    'index'
]);

// Activar o desactivar una cuenta
Route::patch('usuarios/{id}/estado', [
    UsuarioController::class,
    'cambiarEstado'
]);


        
// ==========================================
// CRUD DE RECURSOS - ACTIVIDAD 4.3
// ==========================================

// Consultar todos los recursos
Route::get('recursos', [
    RecursoController::class,
    'index'
]);

// Consultar un recurso por ID
Route::get('recursos/{id}', [
    RecursoController::class,
    'show'
]);

// Crear un nuevo recurso
Route::post('recursos', [
    RecursoController::class,
    'store'
]);

// Actualizar un recurso
Route::match(['put', 'patch'], 'recursos/{id}', [
    RecursoController::class,
    'update'
]);

// Desactivar un recurso
Route::delete('recursos/{id}', [
    RecursoController::class,
    'destroy'
]);


            // ==========================================
// REPORTES GLOBALES - ACTIVIDAD 4.3
// ==========================================

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

            // Logout administrador - Actividad 4.3
            Route::post('logout', [
                AuthController::class,
                'logout'
            ]);

            // ==========================================
            // GESTION ADMINISTRATIVA DE ALIMENTOS
            // ==========================================

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

            // ==========================================
            // GESTION ADMINISTRATIVA DE ORDENES
            // ==========================================

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
