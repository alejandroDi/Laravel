<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable =['rfc','nombre','direccion','telefono','status'];  

    public function user(){
        return $this->hasOne('App\User');
    }

    public function chofer(){
        return $this->hasOne('App\Chofer');
    }
}

