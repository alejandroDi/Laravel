<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    protected $table='devoluciones';
    protected $fillable=[
        'fecha',
        'idservicio',
        'idusuario',
        'observaciones',    
        
        'status'
        
    ];
}
