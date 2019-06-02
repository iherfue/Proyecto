@extends('layouts.master')

@section('content')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{url('css/timeline.css')}}">
        <div class="timeline-centered" style="margin-top: 1%">
            @foreach($estado as $e)
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
@stop