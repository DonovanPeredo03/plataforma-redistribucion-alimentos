<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminSesionController;
use App\Http\Controllers\{AlimentoController, CarritoController, ListaDeseoController,
    OrdenController, UsuarioController, RolController, LogController};

Route::redirect('/', '/admin/iniciar-sesion');

// Solo visitantes
Route::middleware('guest:admin')->group(function () {
    Route::get('admin/iniciar-sesion', [AdminSesionController::class, 'mostrarFormulario'])->name('admin.iniciar_sesion');
    Route::post('admin/iniciar-sesion', [AdminSesionController::class, 'iniciarSesion'])->name('admin.iniciar_sesion.enviar');
});

// Protege un recurso por módulo y por acción
$recurso = function (string $uri, string $controlador, string $modulo) {
    Route::middleware("can:$modulo")->group(function () use ($uri, $controlador) {
        Route::resource($uri, $controlador)->only(['create', 'store'])->middleware('can:crear');
        Route::resource($uri, $controlador)->only(['edit', 'update'])->middleware('can:editar');
        Route::resource($uri, $controlador)->only(['destroy'])->middleware('can:eliminar');
        Route::resource($uri, $controlador)->only(['index', 'show'])->middleware('can:consultar');
    });
};

// Solo administradores autenticados
Route::middleware('auth:admin')->group(function () use ($recurso) {
    Route::post('admin/cerrar-sesion', [AdminSesionController::class, 'cerrarSesion'])->name('admin.cerrar_sesion');
    Route::view('admin/panel', 'admin.panel')->name('admin.panel');

    $recurso('alimentos',    AlimentoController::class,   'modulo-alimentos');
    $recurso('carritos',     CarritoController::class,    'modulo-ordenes');
    $recurso('lista_deseos', ListaDeseoController::class, 'modulo-ordenes');
    $recurso('ordenes',      OrdenController::class,      'modulo-ordenes');
    $recurso('logs',         LogController::class,        'modulo-logs');

    Route::middleware('can:administrar-usuarios')->group(function () {
        Route::post('/usuarios/activar', [UsuarioController::class, 'activar'])
            ->middleware('can:restaurar')->name('usuarios.activar');
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('roles', RolController::class);
    });
});