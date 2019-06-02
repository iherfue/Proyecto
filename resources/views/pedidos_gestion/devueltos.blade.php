@extends('layouts.app')

@section('content')
    <div class="container container-fluid text-center">
        <div class="col-md-11">
            <div class="col-md-1"><h4><a href="{{url('/home')}}"><button class="btn btn-success">Volver</button></a></h4></div>
            <h3>PEDIDOS A DEVOLVER</h3></br>
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
                        <td></td>
                        <td>{{$p->fecha_entrega}}</td>
                        <td>{{$p->fecha_devolucion}}</td>
                        <td><a href="{{url('pedidos/estado/detalles/' . $p->id)}}">Detalles</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@stop

