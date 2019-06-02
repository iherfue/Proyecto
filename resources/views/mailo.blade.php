<h1>Nuevas Tecnologías</h1>

<p>Hola {{$nombre}} hemos recibido tu solictud de material informático, el número de seguimiento del pedido es el siguiente:</p>
<p>Número de Seguimiento: {{$seguimiento}}</p>

<p>Le informamos que puede saber el estado de su pedido pinchando <a href="{{url('/pedido/localizador/' . $seguimiento)}}">aquí</a></p>