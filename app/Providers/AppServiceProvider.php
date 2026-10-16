<?php

namespace App\Providers;

use App\Models\Administrador;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    // /alimentos/create → /alimentos/crear ; /alimentos/1/edit → /alimentos/1/editar
    Route::resourceVerbs(['create' => 'crear', 'edit' => 'editar']);

    foreach (array_keys(Administrador::PERMISOS) as $clave) {
        Gate::define($clave, fn (Administrador $administrador) => $administrador->tienePermiso($clave));
    }
}
}
