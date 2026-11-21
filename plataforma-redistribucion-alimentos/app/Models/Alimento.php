<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alimento extends Model
{
    protected $table = 'alimentos';

    protected $primaryKey = 'id_alimento';

    public $timestamps = false;

    protected $fillable = [
    'id_alimento',
    'id_usuario',
    'nombre',
    'descripcion',
    'categoria',
    'cantidad',
    'unidad',
    'fecha_publicacion',
    'fecha_caducidad',
    'estado',
    'ruta_imagen',
];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function carritoDetalles(): HasMany
    {
        return $this->hasMany(CarritoDetalle::class, 'id_alimento', 'id_alimento');
    }

    public function listaDeseoDetalles(): HasMany
    {
        return $this->hasMany(ListaDeseoDetalle::class, 'id_alimento', 'id_alimento');
    }

    public function ordenDetalles(): HasMany
    {
        return $this->hasMany(OrdenDetalle::class, 'id_alimento', 'id_alimento');
    }
}