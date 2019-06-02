@extends('layouts.app')

@section('content')

<div class="container">
<form method="POST">
@csrf
    <div class="card">
        <div class="card-header">
            Confirmar Eliminación
        </div>
        <div class="card-body">
            <h5 class="card-title">¿Está seguro de que desea eliminar el siguiente producto?</h5>
            <h4 class="card-text"><?php print_r($producto[0]->nombre)?></h4>
            <input type="hidden" name="id_producto" value=<?php print_r($producto[0]->id)?>>
            <input type="submit" class="btn btn-primary" value="Eliminar">
        </div>
    </div>
</form>
</div>

@stop