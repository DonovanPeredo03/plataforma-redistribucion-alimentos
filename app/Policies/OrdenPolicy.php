<?php

namespace App\Policies;

use App\Models\Orden;
use App\Models\Usuario;

class OrdenPolicy
{
    public function view(Usuario $usuario, Orden $orden): bool
    {
        return (int) $usuario->id_usuario === (int) $orden->id_usuario;
    }

    public function update(Usuario $usuario, Orden $orden): bool
    {
        return (int) $usuario->id_usuario === (int) $orden->id_usuario;
    }

    public function delete(Usuario $usuario, Orden $orden): bool
    {
        return (int) $usuario->id_usuario === (int) $orden->id_usuario
            && in_array($orden->estado, Orden::CANCELABLES, true);
    }
}