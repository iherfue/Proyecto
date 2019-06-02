<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{

    public function producto(){

        return $this->belongsToMany("App\Producto");
    }
}
