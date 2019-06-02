<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->date('fecha_entrega');
            $table->date('fecha_devolucion');
            $table->text('descripcion');
            $table->string('area',100);
            $table->enum('estado',['Pendiente','Preparado','Recogido','Entregado','Retrasado']);
            $table->integer('n_seguimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedido');
    }
}
