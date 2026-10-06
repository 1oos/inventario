<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteInventario extends Model
{
    protected $fillable = [
        'id_articulo',
        'nombre_articulo',
        'fecha_registro',
    ];
}

?>