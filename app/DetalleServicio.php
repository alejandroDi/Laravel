<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleServicio extends Model
{
    protected $table='detalle_servicios';
    protected $fillable=[
        'idservicio',
        'idinsumo',
        'cantidad',
        'precioventa',
        'descuento'
    ];

    public $timestamps=false;
}
