<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administrador extends Authenticatable
{
    use Notifiable, SoftDeletes;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    const DELETED_AT = 'fecha_eliminacion';

    protected $table = 'administradores';
    protected $primaryKey = 'id_administrador';

    protected $fillable = ['nombre', 'correo', 'contrasena', 'perfil', 'estado'];
    protected $hidden = ['contrasena', 'token_recordar'];

    protected function casts(): array
    {
        return ['contrasena' => 'hashed', 'estado' => 'boolean'];
    }

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function getAuthPasswordName()
    {
        return 'contrasena';
    }

    public function getRememberTokenName()
    {
        return 'token_recordar';
    }

    protected static function booted(): void
    {
        static::creating(fn ($m) => $m->creado_por = auth('admin')->id());
        static::updating(fn ($m) => $m->actualizado_por = auth('admin')->id());
    }

    public const PERMISOS = [
        'consultar'            => 'Consultar información',
        'crear'                => 'Crear registros',
        'editar'               => 'Editar registros',
        'eliminar'             => 'Eliminar registros',
        'restaurar'            => 'Restaurar registros',
        'administrar-usuarios' => 'Administrar usuarios y roles',
        'modulo-alimentos'     => 'Acceder al módulo de alimentos',
        'modulo-ordenes'       => 'Acceder a órdenes, carritos y listas de deseos',
        'modulo-logs'          => 'Acceder al módulo de logs',
    ];

    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'administrador_permiso', 'id_administrador', 'permiso_id');
    }

    public function tienePermiso(string $clave): bool
    {
        return $this->permisos->contains('clave', $clave);
    }
}