@extends('layouts.master')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4>Ocurrio un error, Revise que:</h4>
                <div class="alert alert-warning">
                    <strong><?php echo _('- La fecha de devolución no puede sobrepasar un máximo de 15 días')?></strong><br>
                    <!--<strong><?php echo _('- Solo puede pedir 5 unidades por producto')?></strong>-->
                </div>
                <input onClick="javascript:window.history.back();" type="button" name="Submit"  class="btn btn-primary" value="Volver" />
            </div>
        </div>
    </div>
@stop