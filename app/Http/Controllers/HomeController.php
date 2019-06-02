<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EstadoPedido;
use App\Pedido;
use App\PedidoProducto;
use App\Producto;
use App\Persona;
use App\RealizaPedido;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Consultar pedidos Pendientes
        $pedidos_pendientes = DB::select(DB::raw("select count(*) as Pendientes from pedidos where estado = 'Pendiente'"));
        $pedidos_pendientes_recoger = DB::select(DB::raw("select count(*) as Preparado from pedidos where estado = 'Preparado'"));
        $pedidos_recogidos = DB::select(DB::raw("select count(*) as Recogido from pedidos where estado = 'Recogido'"));
        $pedidos_retrasados = DB::select(DB::raw("select count(*) as Retrasado from pedidos where estado = 'Retrasado'"));

        //Pedidos que estan pendientes de entregar y lo buscan al dia siguiente
        $pedidos_dia_siguiente = DB::select(DB::raw("SELECT count(*) as pedido from pedidos where DATEDIFF(fecha_entrega,current_date()) = 1 and pedidos.estado = 'Pendiente'"));

        $array = [0];
        //Estadisticas
        for($i = 1; $i <=12; $i++){

            $cantidad = DB::select(DB::raw("select sum(cantidad) as cantidad from historico where month(created_at) = '$i' and year(created_at) = year(current_date())"));

            if($cantidad[0]->cantidad == ''){
                $cantidad[0]->cantidad = 0;
            }
            array_push($array,$cantidad);

        }
        $porcentaje = DB::select(DB::raw("select nombre,sum(cantidad) as cantidad from productos,historico where productos.id = historico.id_producto 
                                            and month(historico.created_at) = (select Month(current_date())) group by id_producto"));


        return view('home', array('pendientes' => $pedidos_pendientes, 'recogidos' => $pedidos_recogidos, 'retrasados' => $pedidos_retrasados,
         'pedidos_dia_siguiente' => $pedidos_dia_siguiente, 'pendientes_recoger' =>$pedidos_pendientes_recoger,'cantidad' => $cantidad,
            'cantidad_mes' => $array, 'porcentaje' => $porcentaje));
    }
}
