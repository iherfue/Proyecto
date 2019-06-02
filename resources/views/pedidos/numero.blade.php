@extends('layouts.master')

@section('content')

        <h4>Número de seguimiento</h4>
        <form method="POST">
            @csrf
        <input type="text" name="numero" id="numero">

        <button class="btn btn-success" type="submit" name="envia">Buscar</button>
        </form>

@stop