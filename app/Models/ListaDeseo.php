<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListaDeseo extends Model
{
    protected $table = 'lista_deseos';

    protected $primaryKey = 'id_lista';

    public $timestamps = false;

    protected $fillable = [
    'id_lista',
    'id_usuario',
    'fecha_creacion',
];
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(ListaDeseoDetalle::class, 'id_lista', 'id_lista');
    }
}