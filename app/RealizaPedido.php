<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealizaPedido extends Model
{
    protected $table = "pedido_realiza";
    protected $primaryKey = "pedido_id";

    public function persona(){

        return $this->hasOne('App\Persona');
    }
}
