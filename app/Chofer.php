<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chofer extends Model
{
    protected $fillable = [
        'id', 'idvehiculo'
    ];
    public function vehiculo(){
        return $this->belongsTo('App\vehiculo');
    }

    public function persona(){
        return $this->belongsTo('App\Persona');
    }
}
