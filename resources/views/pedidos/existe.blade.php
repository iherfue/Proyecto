@extends('layouts.master')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4>Ocurrio el Siguiente error:</h4>
                <div class="alert alert-warning">
                    <strong><?php echo _('Usted ya tiene un pedido en curso.')?></strong>
                </div>
                <a href="{{url('/')}}"><button type="btn btn-success " class="btn btn-success">Volver</button></a>
            </div>
        </div>
    </div>
@stop