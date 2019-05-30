<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vehiculo extends Model
{
    protected $table ='vehiculos';
    protected $fillable=['placas','marca','kilometraje','color','capacidad','costorenta','status'];
   

    public function chofers(){
        return $this->hasMany('App\Chofer');
    }
}
