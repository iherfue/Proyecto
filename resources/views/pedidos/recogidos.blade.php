@extends('layouts.app')

@section('content')
 <div class="container container-fluid text-center">
      <div class="col-md-11">
          <div class="col-md-1"><h4><a href="{{url('/home')}}"><button class="btn btn-success">Volver</button></a></h4></div>
          <h3>Productos Recogidos</h3></br>
        <table class="table table-hover">
            <tr>
                <th>PRODUCTO</th>
                <th>FECHA A DEVOLVER</th>
                <th>DETALLES</th>
            </tr>
            @foreach($pedidos as $p)
            <tr>
                <td>{{$p->nombre}}</td>
                <td>
                    <?php 
                    $fecha = ($p->fecha_devolucion);
                    $arr1 = explode('-',$fecha);
                    $fecha_esp = ($arr1[2] . '-' . $arr1[1] . '-' . $arr1[0]);
                     print_r($fecha_esp);
                    ?>
                </td>
                <td><a href="{{url('pedidos/estado/detalles/' . $p->pedido_id)}}">Detalles</a></td>
            </tr>
            @endforeach
        </table>
        </div>
 </div>
@stop
