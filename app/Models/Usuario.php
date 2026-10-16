<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_rol',
        'nombre',
        'apellido',
        'email',
        'password',
        'teléfono',
        'direccion',
        'tipo_login',
        'fecha_registro',
        'estado',
    ];

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'id_rol', 'id_rol');
    }

    public function alimentos(): HasMany
    {
        return $this->hasMany(Alimento::class, 'id_usuario', 'id_usuario');
    }

    public function carritos(): HasMany
    {
        return $this->hasMany(Carrito::class, 'id_usuario', 'id_usuario');
    }

    public function listaDeseos(): HasMany
    {
        return $this->hasMany(ListaDeseo::class, 'id_usuario', 'id_usuario');
    }

    public function ordenes(): HasMany
    {
        return $this->hasMany(Orden::class, 'id_usuario', 'id_usuario');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(Log::class, 'id_usuario', 'id_usuario');
    }
}