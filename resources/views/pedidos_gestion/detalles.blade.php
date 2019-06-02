@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('css/timeline.css')}}">
 <div class="container">
     <div class="col-md-1"><h4><a href="{{url('/home/')}}"><button class="btn btn-success">Volver</button></a></h4></div>
    <div class="row">
        <div class="col-md-6">
            <h3>Datos de la Persona</h3><br>
            <table class="table table-striped">
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>DNI</th>
                    <th>Fecha Entrega</th>
                    <th>Fecha a Devolver</th>
                </tr>
                @foreach($detalles_persona as $d)
                    <tr>
                        <td>{{$d->nombre}}</td>
                        <td>{{$d->telefono}}</td>
                        <td>{{$d->dni}}</td>
                        <td>
                            <?php 
                                $fecha = ($d->fecha_entrega);
                                $arr1 = explode('-',$fecha);
                                $fecha_esp = ($arr1[2] . '-' . $arr1[1] . '-' . $arr1[0]);
                                print_r($fecha_esp);
                            ?>
                        </td>
                        <td>
                            <?php 
                                $fecha = ($d->fecha_devolucion);
                                $arr1 = explode('-',$fecha);
                                $fecha_esp = ($arr1[2] . '-' . $arr1[1] . '-' . $arr1[0]);
                                print_r($fecha_esp);
                            ?>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="col-md-12">
                <h3>Detalles del Pedido</h3>
                <br>
                <table class="table table-striped text-center">
                    <tr>
                        <th>Producto</th>
                        <th>Unidades</th>
                    </tr>
                    @foreach($detalles_pedido as $d)
                        <tr>
                            <td>{{$d->nombre}}</td>
                            <td>{{$d->cantidad}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
         </div>

        <!--SEGUIMIENTO DEL PEDIDO-->
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <h3>Estado del pedido <button type="btn"  data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">Cambiar</button></h3><br>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cambiar estado del Pedido</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST">
                            @csrf
                        <div class="modal-body">

                                <h4>Seleccione el estado</h4>
                                <select name="estado">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Preparado">Preparado</option>
                                    <option value="Recogido">Recogido</option>
                                    <option value="Entregado">Entregado</option>
                                    <input type="hidden" name="id_pedido" value="{{$detalles_pedido[0]->id}}">
                                </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="timeline-centered" style="margin-top: 1%">
            @foreach($seguimiento as $e)
                <article class="timeline-entry left-aligned">
                    <?php $fecha = str_split($e->created_at,10);?>
                    <div class="timeline-entry-inner">
                        <time class="timeline-time" datetime="2014-01-10T03:45"><span>{{$fecha[0]}}</span> <span></span></time>
                            <div class="timeline-icon bg-success">
                                <i class="entypo-feather"></i>
                            </div>
                        @if($e->estado == 'Pendiente')
                            <div class="timeline-label">
                                <h2><a href="#">{{$e->estado}}</a></h2>
                                <p>Hemos recibido su pedido y está pendiente de preparación</p>
                            </div>
                        @endif
                        @if($e->estado == 'Preparado')
                            <div class="timeline-label">
                                <h2><a href="#">{{$e->estado}}</a></h2>
                                <p>Su Pedido está listo para que pueda pasar a recogerlo</p>
                            </div>
                        @endif
                        @if($e->estado == 'Recogido')
                            <div class="timeline-label">
                                <h2><a href="#">{{$e->estado}}</a></h2>
                                <p>Ha recogido su pedido</p>
                            </div>
                        @endif
                        @if($e->estado == 'Entregado')
                            <div class="timeline-label">
                                <h2><a href="#">{{$e->estado}}</a></h2>
                                <p>El pedido ha sido entregado</p>
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
        </div>
    </div>
</div>
@stop
