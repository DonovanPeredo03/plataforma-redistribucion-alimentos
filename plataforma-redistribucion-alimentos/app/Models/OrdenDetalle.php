<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenDetalle extends Model
{
    protected $table = 'orden_detalle';

    protected $primaryKey = 'id_detalle_orden';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'id_detalle_orden',
        'id_alimento',
        'id_orden',
        'cantidad',
    ];

    // Relación con alimento
    public function alimento(): BelongsTo
    {
        return $this->belongsTo(
            Alimento::class,
            'id_alimento',
            'id_alimento'
        );
    }

    // Relación con orden
    public function orden(): BelongsTo
    {
        return $this->belongsTo(
            Orden::class,
            'id_orden',
            'id_orden'
        );
    }
}
