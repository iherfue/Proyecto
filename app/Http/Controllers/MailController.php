<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
    public function basic_email($datos) {
        $data = array('nombre'=> $datos['nombre'], 'seguimiento' => $datos['n_seguimiento']);

        Mail::send(['text'=>'mail'], $data, function($message) {
            $message->to('iherfue@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
            $message->from('innovafuerteventura@cabildofuer.es','Virat Gandhi');
        });

        echo "Basic Email Sent. Check your inbox.";
    }

    //Notifica el estado del pedido
    public function html_email($datos) {

        $data = array('estado' => $datos['estado'], 'nombre'=> $datos['nombre']);
        $to = $datos['email'];

        //Pedido Preparado para recoger
        if($datos['estado'] == 'Preparado'){
            Mail::send('notifica_estados.PendienteRecogida', $data, function($message) use ($to) {
                $message->to($to, 'Nuevas Tecnologías')->subject
                ('Nuevas Tecnologías');
                $message->from('innovafuerteventura@cabildofuer.es','Nuevas Tecnologías');
            });
        }

        //Pedido Recogido
        if($datos['estado'] == 'Recogido'){
            Mail::send('notifica_estados.recogido', $data, function($message) use ($to) {
                $message->to($to, 'Nuevas Tecnologías')->subject
                ('Nuevas Tecnologías');
                $message->from('innovafuerteventura@cabildofuer.es','Nuevas Tecnologías');
            });
        }

        //Pedido Entregado
        if($datos['estado'] == 'Entregado'){
            Mail::send('notifica_estados.entregado', $data, function($message) use ($to) {
                $message->to($to, 'Nuevas Tecnologías')->subject
                ('Nuevas Tecnologías');
                $message->from('innovafuerteventura@cabildofuer.es','Nuevas Tecnologías');
            });
        }
    }
    public function attachment_email($datos) {

        $data = array('nombre'=> $datos['nombre'], 'seguimiento' => $datos['n_seguimiento']);
        $ruta = "/home/vagrant/code/PEDIDOSRC_N/public/pdf/".$datos['id_pedido'].'.pdf';
        $to = $datos['email'];

        Mail::send('mailo', $data, function($message)  use($ruta,$to){
            $message->to($to, 'NUEVAS TECNOLOGÍAS')->subject
            ('NUEVAS TECNOLOGÍAS');
            $message->attach($ruta);

            $message->from('innovafuerteventura@cabildofuer.es','NNTT');
        });
    }


}