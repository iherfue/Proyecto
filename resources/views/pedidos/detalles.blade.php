@extends('layouts.master')

@section('content')

    <div class="col-md-12">
        <div class="card" style="margin-top: 20px">
            <div class="card-body">
                <div class="alert alert-success">
                    <h4>Pedido realizado Correctamente</h4>
                    <strong>El Nº de Seguimiento del Pedido es: <?php print_r($n_seguimiento[0]->n_seguimiento); ?></strong><br>
                    <strong>Hemos envíado un correo con los detalles del pedido</strong>
                </div>
                <div class="alert alert-info" role="alert">
                    <p><strong>Para consultar el estado de su pedido pulse <a target="_blank" href="{{url('/pedido/localizador/' . $n_seguimiento[0]->n_seguimiento)}}">aquí</a></strong></p>
                </div>
                <h5>Detalles de su Pedido</h5>
                <a href="{{url('/pdf/'. $id_pedido. '.pdf')}}" target="_blank"><p>Comprobante</p></a>
                <table class="table table-striped text-center">
                    <tr>
                        <th>Producto</th>
                        <th>Unidades</th>
                    </tr>

                        @foreach($informacion as $i)
                        <tr>
                            <td>{{$i->nombre}}</td>
                            <td>{{$i->cantidad}}</td>
                        </tr>
                        @endforeach

                </table>
            </div>
        </div>
    </div>


    @stop
