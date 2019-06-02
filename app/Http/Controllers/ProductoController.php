<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Producto;

class ProductoController extends Controller
{
    public function index(){

        $productos = DB::select(DB::raw("select * from productos"));

        return view('productos.index',array('productos' => $productos));
    }

    public function get($id){

        $producto = DB::select(DB::raw("select * from productos where id = '$id'"));

        return view('productos.edit',array('producto' => $producto));
    }

    public function edit(Request $request){

        $nombre = $request->input('nombre');
        $unidades = $request->input('unidades');
        $id = $request->input('id');


        DB::statement("UPDATE productos set nombre = '$nombre', unidades = '$unidades', updated_at = current_timestamp where id = '$id'");

        return redirect('/productos');
    }

    public function vistaNuevo(){

        return view('productos.add');
    }

    public function add(Request $request){

        $nombre = $request->input('nombre');
        $unidades = $request->input('unidades');

        $producto = new Producto;
        $producto->nombre = $nombre;
        $producto->unidades = $unidades;
        $producto->save();

        return redirect('/productos');
    }

    public function delete($id){

        
        $producto = DB::select(DB::raw("select id,nombre from productos where id = '$id'"));

        return view('productos.delete' , array('producto' => $producto));

    }

    public function deleteConfirm(Request $request){

        $id = $request->input('id_producto');

        DB::statement("delete from productos where id = '$id'");

        return redirect('/home');
    }
}
