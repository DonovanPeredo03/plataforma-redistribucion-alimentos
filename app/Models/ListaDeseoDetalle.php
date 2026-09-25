<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListaDeseoDetalle extends Model
{
    protected $table = 'lista_deseos_detalles';

    protected $primaryKey = 'id_detalle_lista';

    public $timestamps = false;

    protected $fillable = [
    'id_detalle_lista',
    'id_lista',
    'id_alimento',
    'fecha_agregado',
];

    public function listaDeseo(): BelongsTo
    {
        return $this->belongsTo(ListaDeseo::class, 'id_lista', 'id_lista');
    }

    public function alimento(): BelongsTo
    {
        return $this->belongsTo(Alimento::class, 'id_alimento', 'id_alimento');
    }
}