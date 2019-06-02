<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    public function pedidos(){

        return $this->hasOne('App\Pedido');
    }
}
