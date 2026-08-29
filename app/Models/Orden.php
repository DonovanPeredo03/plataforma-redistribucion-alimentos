<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orden extends Model
{
    protected $table = 'ordenes';

    protected $primaryKey = 'id_orden';

    public $timestamps = false;

    protected $fillable = [
    'id_orden',
    'id_usuario',
    'fecha_orden',
    'estado',
    'fecha_entrega',
    'observaciones',
];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(OrdenDetalle::class, 'id_orden', 'id_orden');
    }
}