@extends('layouts.master')

@section('content')

    <div class="jumbotron">
        <h4 class="display-6">Bienvenido al Panel de Agilización de Solicitudes del Cabildo Insular de Fuerteventura</h4>
        <hr class="my-4">

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Solicitud de Material Informático</h5>
                <p class="card-text">Tenemos a su disposición material informático, rellene la siguiente solicitud para obtener dicho material.</p>
                <a href="{{url('/solicitar')}}" class="btn btn-primary"><strong>Solicitar</strong></a>
            </div>
        </div>
    </div>

@stop


