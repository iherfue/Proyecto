<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico', function (Blueprint $table) {
            $table->Integer('id_producto');
            $table->Integer('cantidad');
            $table->timestamps();
        });

        DB::unprepared('
                create trigger historico_mes after insert on productos_pedidos for each row
                 begin
                 insert into historico(id_producto,cantidad,created_at,updated_at) values(new.producto_id,new.cantidad,current_timestamp(),current_timestamp());
                 END
            ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico');
    }
}
