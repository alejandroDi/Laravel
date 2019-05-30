<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleDevolucion extends Model
{
    protected $table='detalle_devoluciones';
    protected $fillable=[
        'iddevolucion',
        'idinsumo',
        'cantidad'
    ];
    public $timestamps=false;
}
