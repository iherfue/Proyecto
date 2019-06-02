@extends('layouts.app')

@section('content')
    <div class="container container-fluid">
        <div class="col-md-1"><h4><a href="{{url('/productos')}}"><button class="btn btn-success">Volver</button></a></h4></div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-3">
                <form method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="unidades">Unidades</label>
                        <input type="number" class="form-control" id="unidades" name="unidades">
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
@stop
