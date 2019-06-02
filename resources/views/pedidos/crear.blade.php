@extends('layouts.master')

@section('content')
    <div class="jumbotron">
        <h4 class="display-6">Solicitud de Material Informático  Servicio de Nuevas Tecnologías</h4>
        <hr class="my-4">

    <form method="POST" action="{{url('solicitar/add')}}">
        @csrf
        <div class="row">
            <div class="col-4">
                <label for="nombre">Nombre y Apellidos</label>
                <input type="text" name="nombre" id="nombre" required class="form-control"></br>
            </div>

            <div class="col-4">
                <label for="dni">DNI</label>
                <input type="text" name="dni" id="dni" maxlength="9" required class="form-control">
            </div>
            <div class="col-4">
                <label for="dni">EMAIL</label>
                <input type="text" name="email" id="email" required class="form-control">
            </div>
            <div class="col-4">
                <label for="telefono">Teléfono</label>
                <input type="tel" name="telefono" maxlength="9" id="telefono" class="form-control">
            </div>

            <div class="col-4">
                <label for="area">Área - Gestión</label>
                <input type="text" name="area" id="area" class="form-control"></br>
            </div>

            <div class="col-10">
                <label for="descripcion">Con Objeto de:</label>
                <textarea type="text" name="descripcion" id="descripcion" class="form-control"></textarea><br/>
            </div>

            <div class="col-4">
                <label for="fecha_entrega">Fecha Entrega</label>
                <input type="date" name="fecha_entrega" class="form-control">
            </div>

            <div class="col-4">
                <label for="fecha_devolucion">Fecha Devolución <strong>Máximo (15 días)</strong></label>
                <input type="date" name="fecha_devolucion" class="form-control"></br>
            </div>
                <div class="form-control">
                    <input type="checkbox" name="aula" value="si"> <strong>Solicito el material para Aula de formación</strong>
                </div>
        </div>
    <br>
        <h5>*Indique la Cantidad y Seleccione el producto</h5>
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Disponibles</th>
                </tr>
            </thead>

                @foreach ($productos as $p)
                <tr>
                    <td>{{$p->nombre}}</td>
                    <td><input type="number" name="unidades[]" max="{{$p->unidades}}" value="0" min="0"></td>
                    <input type="hidden" name="id_producto[]" value="{{$p->id}}">
                        <td>{{$p->unidades}}</td>
                </tr>
                  @endforeach
        </table>
        <input type="submit" value="Enviar" name="envia"> </br></br>
    </form>

        @if( !empty($disponibilidad))
                <h6>*Los Productos no disponibles estarán disponibles en las siguientes fechas:</h6>
                <div class="col-md-4">
                    <table class="table table-info text-center">
                        <tr>
                            <th>Producto</th>
                            <th>Fecha</th>
                        </tr>

                    @foreach($disponibilidad as $d)
                        @foreach($d as $i)
                        <tr>
                            <td>{{$i->nombre}}</td>
                        <td>
                            <?php 
                                $fecha = ($i->fecha_devolucion);
                                $arr1 = explode('-',$fecha);
                                $fecha_esp = ($arr1[2] . '-' . $arr1[1] . '-' . $arr1[0]);
                                print_r($fecha_esp);
                            ?>
                        </td>
                        @endforeach
                    @endforeach
                        </tr>
                    </table>
                </div>
            @endif
    </div>
@stop
