<?php

namespace App\Providers;

use App\Models\Administrador;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Models\Orden;
use App\Models\Usuario;
use App\Policies\OrdenPolicy;

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
    Gate::policy(Orden::class, OrdenPolicy::class);

Gate::define('manage-own-resource', function (Usuario $usuario, Orden $orden) {
    return (int) $usuario->id_usuario === (int) $orden->id_usuario;
});
    // /alimentos/create → /alimentos/crear ; /alimentos/1/edit → /alimentos/1/editar
    Route::resourceVerbs(['create' => 'crear', 'edit' => 'editar']);

    foreach (array_keys(Administrador::PERMISOS) as $clave) {
        Gate::define($clave, fn (Administrador $administrador) => $administrador->tienePermiso($clave));
    }
    Gate::define('access-admin', function ($user) {
        return $user->role === 'admin';
    });
}
}
