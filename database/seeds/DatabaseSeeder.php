<?php

use Illuminate\Database\Seeder;
use App\Persona;
use App\Pedido;
use App\PedidoProducto;
use App\Producto;
use App\User;
use App\RealizaPedido;
use App\Estado;
use App\EstadoPedido;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    private $arrayClientes = array(
        array(
            'nombre' => 'Ivan',
            'dni' => '76541567Y',
            'email' => 'iherfue@gmail.com',
            'telefono' => '676565677'
        ),
        array(
            'nombre' => 'javier',
            'dni' => '67154134R',
            'email' => 'iherfue@gmail.com',
            'telefono' => '681276155'
        ),
        array(
            'nombre' => 'jose',
            'dni' => '76567167U',
            'email' => 'iherfue@gmail.com',
            'telefono' => '678261541',
        )
    );

    private $arrayPedidos = array(

        array(

            'fecha_entrega' => '2019-04-08',
            'fecha_devolucion' => '2019-04-12',
            'descripcion' => 'pppp',
            'area' => 'Prueba',
            'estado' => 'Pendiente',
            'n_seguimiento' => '120192'
        ),

        array(

            'fecha_entrega' => '2019-04-09',
            'fecha_devolucion' => '2019-04-18',
            'descripcion' => 'ss',
            'area' => 'Prueba',
            'estado' => 'Pendiente',
            'n_seguimiento' => '221729'
        ),

        array(

            'fecha_entrega' => '2019-04-10',
            'fecha_devolucion' => '2019-04-12',
            'descripcion' => 'pppp',
            'area' => 'Prueba',
            'estado' => 'Pendiente',
            'n_seguimiento' => '676154'
        ),

    );


    private $arrayRealizaPedidos = array(

        array(
            
            'persona_id' => '1',
            'pedido_id' => '1'
        ),

        array(

            'persona_id' => '2',
            'pedido_id' => '2'
        ),

        array(

            'persona_id' => '3',
            'pedido_id' => '3'
        ),
    );

    private $arrayProductos = array(

        array(

            'nombre' => 'Teclado',
            'unidades' => '10'
        ),

        array(

            'nombre' => 'Raton',
            'unidades' => '13'
        ),

        array(

            'nombre' => 'Portátil',
            'unidades' => '20'
        ),

        array(

            'nombre' => 'Proyector',
            'unidades' => '40'
        ),

    );

    private $arrayPedidoProductos = array(

        array(

            'pedido_id' => '1',
            'producto_id' => '1',
            'cantidad' => '2'
        ),

        array(

            'pedido_id' => '1',
            'producto_id' => '2',
            'cantidad' => '4'
        ),

        array(

            'pedido_id' => '1',
            'producto_id' => '4',
            'cantidad' => '1'
        ),

        array(

            'pedido_id' => '2',
            'producto_id' => '2',
            'cantidad' => '6'
        ),

        array(

            'pedido_id' => '3',
            'producto_id' => '4',
            'cantidad' => '2'
        ),
    );

    private $arrayEstado = array(

        array(

            'id' => '1',
            'estado' => 'Pendiente'
        ),

        array(

            'id' => '2',
            'estado' => 'Preparado'
        ),

        array(

            'id' => '3',
            'estado' => 'Recogido'
        ),

        array(

            'id' => '4',
            'estado' => 'Entregado'
        ),

        array(

            'id' => '5',
            'estado' => 'Retrasado'
        ),
    );

    private $arrayEstadoPedido = array(

        array(

            'pedido_id' => '1',
            'estado_id' => '1'
        ),


        array(

            'pedido_id' => '2',
            'estado_id' => '1'
        ),

        array(

            'pedido_id' => '3',
            'estado_id' => '1'
        ),

    );

    private $arrayUsers = array(

        array(
            'name' => 'Javier',
            'email' => 'jfranco@cabildofuer.es',
            'password' => '123456'
        )
    );


    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        self::seedUsers();
        $this->command->info('Tabla Usuarios inicializada con datos!');

        self::seedPersona();
        $this->command->info('Tabla Clientes inicializada con datos!');

        self::seedPedidos();
        $this->command->info('Tabla Pedidos inicializada con datos!');

        self::seedRealizaPedidos();
        $this->command->info('Tabla realiza pedidos con datos');

        self::seedProductos();
        $this->command->info('Tabla Productos inicializada con datos!');

        self::seedPedidoProductos();
        $this->command->info('Tabla Pedido Producto inicializada con datos!');

        self::seedEstado();
        $this->command->info('Tabla estado inicializada con datos');

        self::seedEstadoPedido();
        $this->command->info('Tabla Estado - Pedido inicializada con datos');
    }

    private function seedUsers(){

      foreach( $this->arrayUsers as $user ) {
          $c = new User;
          $c->name = $user['name'];
          $c->email = $user['email'];
          $c->password = bcrypt($user['password']);
          $c->save();
        }
    }

    private function seedPersona(){

        foreach($this->arrayClientes as $persona){

            $c = new Persona;
            $c->nombre = $persona['nombre'];
            $c->dni = $persona['dni'];
            $c->email = $persona['email'];
            $c->telefono = $persona['telefono'];
            $c->save();
        }
    }

    private function seedPedidos(){

        foreach($this->arrayPedidos as $pedido){

            $p = new Pedido;
            $p->fecha_entrega = $pedido['fecha_entrega'];
            $p->fecha_devolucion = $pedido['fecha_devolucion'];
            $p->descripcion = $pedido['descripcion'];
            $p->area = $pedido['area'];
            $p->estado = $pedido['estado'];
            $p->n_seguimiento = $pedido['n_seguimiento'];
            $p->save();
        }
    }

    private function seedRealizaPedidos(){

        foreach ($this->arrayRealizaPedidos as $arrayRealizaPedido){

            $r = new RealizaPedido;
            $r->persona_id = $arrayRealizaPedido['persona_id'];
            $r->pedido_id = $arrayRealizaPedido['pedido_id'];

            $r->save();
        }
    }

    private function seedProductos(){

        foreach($this->arrayProductos as $producto){

            $p = new Producto;
            $p->nombre = $producto['nombre'];
            $p->unidades = $producto['unidades'];

            $p->save();
        }
    }
    private function seedPedidoProductos(){

        foreach($this->arrayPedidoProductos as $pedidoProducto){

            $p = new PedidoProducto;
            $p->pedido_id = $pedidoProducto['pedido_id'];
            $p->producto_id = $pedidoProducto['producto_id'];
            $p->cantidad = $pedidoProducto['cantidad'];
            $p->save();
        }
    }

    private function seedEstado(){

        foreach($this->arrayEstado as $estado){

            $e = new Estado;
            $e->id = $estado['id'];
            $e->estado = $estado['estado'];
            $e->save();
        }
    }

    private function seedEstadoPedido(){

        foreach($this->arrayEstadoPedido as $item){

            $p = new EstadoPedido;
            $p->pedido_id = $item['pedido_id'];
            $p->estado_id = $item['estado_id'];
            $p->save();
        }
    }
}
