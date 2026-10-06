<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Articulo extends Model
{
    protected $primaryKey = 'id_articulo';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id_articulo',
        'nombre_articulo',
        'color',
        'estado',
        'marca',
        'modelo',
        'codigo_barras',
        'imagen',
        'fecha_alta',
        'serie',
        'categoria',
        'subcategoria',
        'ubicacion',
        'observaciones',
        'numero_factura',
    ];

    public function resguardos(): HasMany
    {
        return $this->hasMany(Resguardos::class, 'id_articulo', 'id_articulo');
    }
}
