<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleMantenimiento extends Model
{
    protected $table='detalle_mantenimientos';
    protected $fillable=[
        'idmantenimiento',
        'idinsumo',
        'cantidad'
    ];

    public $timestamps=false;
}
