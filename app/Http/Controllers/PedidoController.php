<?php

namespace App\Http\Controllers;
use App\EstadoPedido;
use App\Pedido;
use App\PedidoProducto;
use App\Producto;
use App\Persona;
use App\RealizaPedido;
use DB;
use App\Http\Controllers\MailController;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producto = Producto::all();

        $productos_no_disponibles = DB::select(DB::raw("select id from productos where unidades = 0"));

        $array_fechas = [];
        foreach ($productos_no_disponibles as $p) {

            $fecha_disponible = DB::select(DB::raw("select productos.nombre,pedidos.fecha_devolucion from pedidos,productos,productos_pedidos
                                     where productos.id = productos_pedidos.producto_id
                                     and pedidos.id = productos_pedidos.pedido_id and productos.id = '$p->id' and pedidos.estado = 'Recogido' 
                                     order by fecha_devolucion asc limit 1
            "));

            array_push($array_fechas,$fecha_disponible);
        }

        //print_r($array_fechas);

        return view('pedidos.crear', array('productos' => $producto,  'disponibilidad' => $array_fechas));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $unidades = $request->input('unidades');
        $id_producto = $request->input('id_producto');
        $productos_seleccionado = $request->input('seleccion');

    //Formulario
        $nombre = $request->input('nombre');
        $dni = $request->input('dni');
        $email = $request->input('email');
        $telefono = $request->input('telefono');
        $area = $request->input('area');
        $descripcion = $request->input('descripcion');
        $fecha_entrega = $request->input('fecha_entrega');
        $fecha_devolucion = $request->input('fecha_devolucion');
        $aula = $request->input('aula');

        if($aula != 'si'){ //Si no selecciona aula comprueba que tenga como maximo 3 unidades de cada producto

          /*  for($i = 0; $i < count($unidades); $i++){

                if($unidades[$i] > 3){

                    echo('No puede seleccionar más de 3 unidades');
                    return view('pedidos.error');
                };
            }*/
        }

        $dni_persona = Persona::where('dni', $dni)->first();

        //Comprueba si la persona ya ha realizado un pedido

       $id_persona = DB::select(DB::raw("select id from personas where dni = '$dni'"));

       /* if($id_persona){    //SI la consulta devuelve true el cliente esta en el sistema (ha realizado un pedido)

            return view('pedidos.existe');
        }*/

        //Compara las fechas

        $datetime1 = date_create($fecha_entrega);
        $datetime2 = date_create($fecha_devolucion);
        $interval = date_diff($datetime1, $datetime2);

            if($interval->days > 15){

              //  print_r('La Fecha de devolución no puede sobrepasar los 15 días');
                return view('pedidos.error');
            }


       //Se inserta primero el cliente
        $p = new Persona;
        $p->nombre = $nombre;
        $p->dni = $dni;
        $p->email = $email;
        $p->telefono = $telefono;
        $p->save();

        //Luego se añade seguidamente EL PEDIDO
        $pedido = new Pedido;
        $pedido->fecha_entrega = $fecha_entrega;
        $pedido->fecha_devolucion = $fecha_devolucion;
        $pedido->descripcion = $descripcion;
        $pedido->area = $area;
        $numero_seguimiento = rand(10000,99999);
        $pedido->n_seguimiento = $numero_seguimiento;
        $pedido->save();
        $id_persona = DB::select(DB::raw("select id from personas where dni = '$dni'"));

        //REALIZA EL PEDIDO
        $id_persona = $p->id; //RESCATAMOS EL ID DEL CLIENTE
        $id_pedido = $p->id; //RESCATAMOS EL ID DEL PEDIDO

        $rp = new RealizaPedido;
        $rp->persona_id =$id_persona;
        $rp->pedido_id = $id_pedido;
        $rp->save();

        //Se registra en la tabla estado_pedido, el ESTADO POR DEFECTO DEL MISMO
        $ep = new EstadoPedido;
        $ep->pedido_id = $id_pedido;
        $ep->estado_id = '1';  //Uno el estado es PENDIENTE
        $ep->save();

        //Inserta en la tabla de los productos pedidos
        for($i = 0; $i<count($id_producto); $i++){

            if($unidades[$i]> 0){
                DB::insert("insert into productos_pedidos(pedido_id,producto_id,cantidad,created_at,updated_at) values((select pedidos.id from pedidos,personas,pedido_realiza where pedidos.id = pedido_realiza.pedido_id and pedido_realiza.persona_id = personas.id and personas.dni = '$dni' order by id desc limit 1),'$id_producto[$i]','$unidades[$i]',current_timestamp(),current_timestamp() )");
                DB::statement("UPDATE productos set unidades = unidades - '$unidades[$i]' where id = '$id_producto[$i]'");
            }
        }

        return redirect('/pedido/detalles/' . $id_pedido);
    }

    public function error(){

        return view('pedidos.error',array('error' => 'Ha ocurrido un error'));
    }

    public function detalles($id){

        $informacion_pedido = DB::select(DB::raw("select productos.nombre,cantidad from productos_pedidos,pedidos,productos
         where productos.id = productos_pedidos.producto_id and pedidos.id = productos_pedidos.pedido_id and pedidos.id = '$id' 
        "));

        $numero_seguimiento = DB::select(DB::raw("select n_seguimiento from pedidos where pedidos.id = '$id'"));


        //GENERA PDF
        $informacion_pedido = DB::select(DB::raw("select productos.nombre,cantidad from productos_pedidos,pedidos,productos
         where productos.id = productos_pedidos.producto_id and pedidos.id = productos_pedidos.pedido_id and pedidos.id = '$id' 
        "));
        $pedido = Pedido::find($id);
        $persona = Persona::find($id);

        $array = array('id_pedido' => $pedido->id,'nombre' => $persona->nombre, 'dni' => $persona->dni, 'telefono' => $persona->telefono, 'seguimiento' => $pedido->n_seguimiento, 'area' => $pedido->area,
            'descripcion' => $pedido['descripcion'], 'fecha_entrega' => $pedido['fecha_entrega'], 'fecha_devolucion' => $pedido['fecha_devolucion'],
            'informacion' => $informacion_pedido
        );

        $pdf = new PdfController();
        $pdf->generaPDF($array);

        /**ENVIAMOS UN CORREO DE CONFIRMACIÓN**/
        $array_datos = array('email' => $persona->email, 'id_pedido' => $pedido->id, 'nombre' => $persona->nombre, 'n_seguimiento' => $pedido->n_seguimiento);
        $mail = new MailController();
        $mail->attachment_email($array_datos);

        return view('pedidos.detalles',array('informacion' => $informacion_pedido, 'n_seguimiento' => $numero_seguimiento, 'id_pedido' => $id));
    }

    /**SEGUIMIENTO DEL PEDIDO
    **/
    public function numero(){

        return view('pedidos.numero');
    }

    public function buscaNumero(Request $request){

        $numero = $request->input('numero');

        $estado = DB::select(DB::raw("select distinct estado.estado,estado_pedidos.created_at from pedidos,pedido_realiza,estado_pedidos,estado 
        where pedidos.id = estado_pedidos.pedido_id and estado.id = estado_pedidos.estado_id
        and pedidos.n_seguimiento = '$numero'"));

        return view('pedidos.seguimiento', array('estado' => $estado));
    }

    public function seguimiento($id){

        $estado = DB::select(DB::raw("select distinct estado.estado,estado_pedidos.created_at from pedidos,pedido_realiza,estado_pedidos,estado 
        where pedidos.id = estado_pedidos.pedido_id and estado.id = estado_pedidos.estado_id
        and pedidos.n_seguimiento = '$id'"));

        return view('pedidos.seguimiento', array('estado' => $estado));
    }

    /****PEDIDOS PENDIENTES*********/
    public function PedidosPendientes(){

        $pedidos = DB::select(DB::raw("select pedidos.id,nombre,telefono,area,pedidos.fecha_entrega,pedidos.fecha_devolucion from personas,pedidos,pedido_realiza
        where personas.id = pedido_realiza.persona_id and pedidos.id = pedido_realiza.pedido_id and pedidos.estado = 'Pendiente' order by fecha_entrega asc"));

        return view('pedidos_gestion.pendientes',array('pedidos' => $pedidos));
    }

    //PEDIDOS PENDIENTES DE RECOGER POR LA PERSONA

    public function PedidosPendientesRecoger(){

        $pedidos = DB::select(DB::raw("select pedidos.id,nombre,telefono,area,pedidos.fecha_entrega,pedidos.fecha_devolucion from personas,pedidos,pedido_realiza
        where personas.id = pedido_realiza.persona_id and pedidos.id = pedido_realiza.pedido_id and pedidos.estado = 'Preparado' order by fecha_entrega asc"));

        return view('pedidos_gestion.preparados',array('pedidos' => $pedidos));
    }

    //Mostrar PEDIDOS RECOGIDOS

    public function PedidoRecogido(){

        $pedidos = DB::select(DB::raw("select productos.id,productos.nombre,pedidos.fecha_devolucion,pedidos.id as pedido_id,estado.estado 
                                        from pedidos,productos,productos_pedidos,estado,estado_pedidos where 
                                        productos.id = productos_pedidos.producto_id 
                                        and pedidos.id = productos_pedidos.pedido_id and estado.id = estado_pedidos.estado_id
                                        and estado_pedidos.pedido_id = pedidos.id and estado.estado ='Recogido' order by productos.nombre"));

        return view('pedidos.recogidos',array('pedidos' => $pedidos));
    }

    /**PEDIDOS RETRASADOS**/

    public function PedidosRetrasados(){

        $pedidos = DB::select(DB::raw("select pedidos.id,nombre,telefono,area,pedidos.fecha_entrega,pedidos.fecha_devolucion from personas,pedidos,pedido_realiza
        where personas.id = pedido_realiza.persona_id and pedidos.id = pedido_realiza.pedido_id and pedidos.estado = 'Retrasado' order by fecha_entrega asc"));

        return view('pedidos_gestion.retrasados',array('pedidos' => $pedidos));
    }


    /**PEDIDOS QUE SE VAN A MARCAR COMO DEVUELTOS*/

    public function PedidosDevueltos(){

        $pedidos = DB::select(DB::raw("select pedidos.id,nombre,telefono,area,pedidos.fecha_entrega,pedidos.fecha_devolucion from personas,pedidos,pedido_realiza
        where personas.id = pedido_realiza.persona_id and pedidos.id = pedido_realiza.pedido_id and pedidos.estado = 'Recogido' order by fecha_entrega asc"));

        return view('pedidos_gestion.devueltos', array('pedidos' => $pedidos));
    }



     /* Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detalles_pedido = DB::select(DB::raw("select pedidos.id,productos.nombre,cantidad from productos_pedidos,pedidos,productos
         where productos.id = productos_pedidos.producto_id and pedidos.id = productos_pedidos.pedido_id 
         and pedidos.id = '$id'"));

        $detalles_persona = DB::select(DB::raw("select personas.nombre,personas.telefono,personas.dni,pedidos.fecha_entrega,pedidos.fecha_devolucion from personas,pedidos,pedido_realiza
          where pedidos.id = pedido_realiza.pedido_id and personas.id = pedido_realiza.persona_id 
          and pedidos.id = '$id'"));

        $n_seguimiento = DB::select(DB::raw("select n_seguimiento from pedidos where id = '$id'"));

        $numero_seguimiento = $n_seguimiento[0]->n_seguimiento;

        $estado = DB::select(DB::raw("select distinct estado.estado,estado_pedidos.created_at from pedidos,pedido_realiza,estado_pedidos,estado
        where pedidos.id = estado_pedidos.pedido_id and estado.id = estado_pedidos.estado_id
        and pedidos.n_seguimiento = '$numero_seguimiento'"));

      return view('pedidos_gestion.detalles', array('detalles_pedido' => $detalles_pedido, 'detalles_persona' => $detalles_persona, 'seguimiento' => $estado));
    }

    //CAMBIAR EL ESTADO DE UN PEDIDO O SOLICITUD

    public function CambiarEstado(Request $request){

        $estado = $request->input('estado');
        $id_pedido = $request->input('id_pedido');

        $id_estado = DB::select(DB::raw("select id from estado where estado = '$estado'"));
        $id = $id_estado[0]->id;

        $persona = DB::select(DB::raw("select nombre,email from personas,pedido_realiza where personas.id = pedido_realiza.persona_id and pedido_realiza.pedido_id = '$id_pedido'"));

        DB::insert("insert into estado_pedidos(pedido_id,estado_id,created_at,updated_at) values('$id_pedido','$id',current_date (),current_date())");
        DB::statement("UPDATE pedidos set estado = '$estado' where pedidos.id = '$id_pedido'");

        //Si se marca como entregado, redirije a la pantalla administracion
        if($estado == 'Entregado') {

            //Eliminar primero en la tabla PRODUCTOS PEDIDOS para activar el trigger
            DB::delete("delete from productos_pedidos where pedido_id = '$id_pedido'");
            //Elimina el PEDIDO
            DB::delete("delete from pedidos where estado = 'Entregado' and id = '$id_pedido'");
            DB::delete("delete from personas where id = '$id_pedido'");
            return redirect('/home');
        }

        //Enviar email con el cambio de estado
        $datos = array('estado' => $estado, 'nombre' => $persona[0]->nombre,'email' => $persona[0]->email);
        $estado = new MailController();
        $estado->html_email($datos);

        return redirect('/pedidos/estado/detalles/' . $id_pedido);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
