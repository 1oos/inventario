<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resguardos extends Model
{
    protected $fillable = [
        'id_empleado',
        'id_articulo',
        'fecha_registro',
        'observaciones',
    ];

    public function articulo(): BelongsTo
    {
        return $this->belongsTo(Articulo::class, 'id_articulo', 'id_articulo');
    }
}
