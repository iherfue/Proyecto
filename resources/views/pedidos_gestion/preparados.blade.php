@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <div class="col-md-12">
            <div class="col-md-1"><h4><a href="{{url('/home')}}"><button class="btn btn-success">Volver</button></a></h4></div>
            <h3>PEDIDOS LISTOS PARA RECOGER</h3></br>
            <table class="table table-hover">
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Área</th>
                    <th>Fecha de Entrega</th>
                    <th>Fecha a Devolver</th>
                    <th>Ver detalles</th>
                </tr>
                @foreach($pedidos as $p)
                    <tr>
                        <td>{{$p->nombre}}</td>
                        <td>{{$p->telefono}}</td>
                        <td>{{$p->area}}</td>
                        <td>
                            <?php 
                                $fecha = ($p->fecha_entrega);
                                $arr1 = explode('-',$fecha);
                                $fecha_esp = ($arr1[2] . '-' . $arr1[1] . '-' . $arr1[0]);
                                print_r($fecha_esp);
                            ?>
                        </td>
                        <td>
                            <?php 
                                $fecha = ($p->fecha_devolucion);
                                $arr1 = explode('-',$fecha);
                                $fecha_esp = ($arr1[2] . '-' . $arr1[1] . '-' . $arr1[0]);
                                print_r($fecha_esp);
                            ?>
                        </td>
                        <td><a href="{{url('pedidos/estado/detalles/' . $p->id)}}">Detalles</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@stop
