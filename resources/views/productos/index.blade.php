@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-11"><h4><a href="{{url('/home')}}" style="float:left">
            <button class="btn btn-success">Volver</button></a></h4>
            <a href="{{url('/productos/add')}}"><button class="btn btn-primary" style="margin-left: 5%">Añadir Producto</button></a></h4>
        </div>
        </br>
        <h3>Productos</h3>
        <table class="table table-hover text-center">
            <tr>
                <th>Nombre</th>
                <th>Unidades</th>
                <th>Acción</th>
                <th>Acción</th>
            </tr>

            @foreach($productos as $p)
                <tr>
                    <td>{{$p->nombre}}</td>
                    <td>{{$p->unidades}}</td>
                    <td><a href="{{url('/producto/' .$p->id)}}"><button class="btn btn-success">Editar</button></a></td>
                    <td><a href="{{url('/producto/eliminar/' . $p->id)}}"><button class="btn btn-danger">Eliminar</button></a></td>
                </tr>
            @endforeach

        </table>
    </div>
@stop
