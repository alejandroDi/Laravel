<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $fillable=[
        'fecha',
        'idvheiculo',
        'idusuario',
        'falla',
        'diagnostico',
        'observaciones',
        'status'
        
    ];
}
