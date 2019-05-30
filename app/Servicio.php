<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable=[
        'fecha',
        'idcliente',
        'idusuario',
        'idvheiculo',
        'metodopago',
        'horasservicio',
        'total',
        'fechaservicio',
        'impuesto',
        'status'
        
    ];
}
