<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcedimientosEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::unprepared("DROP procedure IF EXISTS estado_pedidos");
        DB::unprepared("
        create procedure pedidosrc.estado_pedidos()
        begin
            declare idpedido int;
            declare idestado int;
            declare fin BOOL default 0;
            declare idp cursor for select id from pedidos where datediff(current_date(),fecha_devolucion) > 1;
            DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = 1;
            
            open idp;
            estadoPedido:LOOP
            
            fetch idp into idpedido;
            if fin = 1 then leave estadoPedido; end if;
            
            insert into estado_pedidos(pedido_id,estado_id,created_at) values(idpedido,5,current_timestamp());
            end loop;
            close idp;
        end
       ");

        DB::unprepared("
                SET GLOBAL event_scheduler= ON;
                SET SQL_SAFE_UPDATES = 0;
                drop event if exists pedidos_retrasados;
                create event pedidos_retrasados
                on schedule every 1 minute STARTS '2019-04-25 20:19:50'  ENABLE
                DO
                BEGIN
                    update pedidos set estado = 'Retrasado' where datediff(current_date(),fecha_devolucion) >= 1 and pedidos.estado != 'Retrasado';
                    call estado_pedidos();
                END;$$
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
