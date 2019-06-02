<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Pedido;
use App\Persona;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/solicitar','PedidoController@index');
Route::post('/solicitar/add','PedidoController@add');

//ERROR EN EL PEDIDO
Route::get('/solicitar/error','PedidoController@error');

//Detalles del pedido
Route::get('/pedido/detalles/{id}/','PedidoController@detalles');

//Localizador del Pedido
Route::get('pedido/localizador/','PedidoController@numero');

Route::post('pedido/localizador/','PedidoController@buscaNumero');

Route::get('pedido/localizador/{id}','PedidoController@seguimiento');


//Area de gestion

Route::get('/pedidos/recogidos','PedidoController@PedidoRecogido')->middleware('auth');
Route::get('pedidos/estado/detalles/{id}','PedidoController@show')->middleware('auth');
Route::post('pedidos/estado/detalles/{id}','PedidoController@CambiarEstado')->middleware('auth');
Route::get('pedidos/pendientes/','PedidoController@PedidosPendientes')->middleware('auth');

Route::get('pedidos/pendientes/recoger','PedidoController@PedidosPendientesRecoger')->middleware('auth');
Route::get('pedidos/retrasados','PedidoController@PedidosRetrasados')->middleware('auth');

//Marcar pedidos como entregados
Route::get('/pedidos','PedidoController@PedidosDevueltos')->middleware('auth');

//GESTIONAR LOS PRODUCTOS
Route::get('/productos','ProductoController@index')->middleware('auth');
Route::get('/producto/{id}','ProductoController@get')->middleware('auth');
Route::post('/producto/{id}','ProductoController@edit')->middleware('auth');
Route::get('/productos/add','ProductoController@vistaNuevo')->middleware('auth');
Route::post('/productos/add','ProductoController@add')->middleware('auth');
Route::get('/producto/eliminar/{id}','ProductoController@delete')->middleware('auth');
Route::post('/producto/eliminar/{id}','ProductoController@deleteConfirm')->middleware('auth');

//HOME NUEVO PRUEBAS
Route::get('/prueba',function(){

    return view('home_nuevo');
});

/*Pedidos del Usuario (id_usuario)
Route::get('/pedidos',function(){

    $pedidos = Persona::find(4)->pedidos;

    foreach ($pedidos as $pedido){

        print_r($pedido);
    }
});*/

Route::get('/pedido/{id}/productos', function($id){

    $pedido = Pedido::find($id);

    foreach ($pedido->producto as $p){

        return $p;
    }
});

Route::get('sendbasicemail','MailController@basic_email');
Route::get('sendhtmlemail','MailController@html_email');
Route::get('sendattachmentemail','MailController@attachment_email');

Auth::routes(['resgister' => false]);

Route::get('/home', 'HomeController@index')->name('home');
