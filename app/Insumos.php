<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumos extends Model
{
    protected $fillable = ['nombre','existencia','ubicacion','precioventa','preciocompra','status'];
}
