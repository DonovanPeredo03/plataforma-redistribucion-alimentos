<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlimentoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ListaDeseoController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\LogController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('alimentos', AlimentoController::class);
Route::resource('carritos', CarritoController::class);
Route::resource('lista_deseos', ListaDeseoController::class);
Route::resource('ordenes', OrdenController::class);
Route::post('/usuarios/activar', [UsuarioController::class, 'activar'])->name('usuarios.activar');
Route::resource('usuarios', UsuarioController::class);
Route::resource('roles', RolController::class);
Route::resource('logs', LogController::class);