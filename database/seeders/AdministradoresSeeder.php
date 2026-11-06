<?php

namespace Database\Seeders;

use App\Models\{Administrador, Permiso};
use Illuminate\Database\Seeder;

class AdministradoresSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Administrador::PERMISOS as $clave => $descripcion) {
            Permiso::firstOrCreate(['clave' => $clave], ['descripcion' => $descripcion]);
        }

        $administradores = [
            ['super@demo.com',    'Super Admin',   'super_admin', true,  array_keys(Administrador::PERMISOS)],
            ['editor@demo.com',   'Editor',        'editor',      true,  ['consultar','crear','editar','modulo-alimentos','modulo-ordenes']],
            ['consulta@demo.com', 'Consulta',      'consulta',    true,  ['consultar','modulo-alimentos']],
            ['baja@demo.com',     'Deshabilitado', 'consulta',    false, ['consultar','modulo-alimentos']],
        ];

        foreach ($administradores as [$correo, $nombre, $perfil, $estado, $claves]) {
            $administrador = Administrador::updateOrCreate(
                ['correo' => $correo],
                ['nombre' => $nombre, 'contrasena' => 'Admin12345', 'perfil' => $perfil, 'estado' => $estado]
            );
            $administrador->permisos()->sync(Permiso::whereIn('clave', $claves)->pluck('id'));
        }
    }
}