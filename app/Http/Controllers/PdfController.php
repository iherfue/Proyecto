<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;

class PdfController extends Controller
{
    public function generaPDF($datos){

        $nombre = $datos['nombre'];
        $seguimiento = $datos['seguimiento'];
        $productos = $datos['informacion'];
        $dia = date('d');
        $mes = date('m');
        $anio = date('Y');
        $mes_e = '';
        switch ($mes){

            case '01':
                $mes_e = 'ENERO';
            break;

            case '02':
                $mes_e = 'FEBRERO';
            break;

            case '03':
                $mes_e = 'MARZO';
             break;

            case '04':
                $mes_e = 'ABRIL';
                break;

            case '05':
                $mes_e = 'MAYO';
                break;

            case '06':
                $mes_e = 'JUNIO';
                break;

            case '07':
                $mes_e = 'JULIO';
                break;

            case '08':
                $mes_e = 'AGOSTO';
                break;

            case '09':
                $mes_e = 'SEPTIEMBRE';
                break;

            case '10':
                $mes_e = 'OCTUBRE';
                break;

            case '11':
                $mes_e = 'NOVIEMBRE';
                break;

            case '12':
                $mes_e = 'DICIEMBRE';
                break;
        }

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML('<img src="/img/logo_cabildo.jpg" width="250" style="margin-left: -5%;">');
        $mpdf->WriteHTML('<img src="/img/fuerteventura_reserva.jpg" width="100" style="margin-left: 75%; margin-top: -17%">');
        $mpdf->WriteHTML('<h4>PRESTAMO DE MATERIAL</h4>');
        $mpdf->WriteHTML('<h4 style="margin-left: 55%;">Nº Seguimiento: ' . $seguimiento . '</h4>');
        $mpdf->WriteHTML('D/DÑA: ' . $nombre);
        $mpdf->WriteHtml('<br>');
        $mpdf->WriteHTML('DNI: ' . $datos['dni']);
        $mpdf->WriteHtml('<br>');
        $mpdf->WriteHTML('Del área de: ' . $datos['area']);
        $mpdf->WriteHtml('<br>');
        $mpdf->WriteHTML('AL OBJETO DE: ' . $datos['descripcion']);
        $mpdf->WriteHtml('<br>');
        $mpdf->WriteHtml('EL SOLICITANTE SE COMPROMETE A USAR EL MATERIAL SOLICITADO DE MANERA RESPONSABLE DESDE EL DÍA ' . $datos['fecha_entrega']. ' HASTA EL DÍA ' . $datos['fecha_devolucion']);
        $mpdf->WriteHtml('<br>');
        $mpdf->WriteHtml('SOLICITA EL PRÉSTAMO DE: ');
        $mpdf->WriteHtml('<br>');

        foreach ($productos as $p){

            $mpdf->WriteHtml('<ul><li>' . $p->nombre . ' <b>Unidades: </b> ' . $p->cantidad . '</li></ul>');

        }

        $mpdf->WriteHtml('<p style="margin-left: 20%; margin-top: 30%;">EN PUERTO DEL ROSARIO, A ' . $dia . ' DE ' . $mes_e . ' DEL ' . $anio . '</p>');
        $mpdf->WriteHTML('
            <div>
                <table style="margin-left: 10%; margin-top: 9%; text-align: center">
                    <tr>
                        <td>RECIBÍ:</td>
                    </tr>
                    
                    <tr>
                        <td>Fdo. Nuevas Tecnologías</td>
                    </tr>
                </table>
                <table style="margin-left: 60%; margin-top: -6%; text-align: center">
                    <tr>
                        <td>ENTREGADO A:</td>
                    </tr>
                    
                    <tr>
                        <td>Fdo. Solicitante</td>
                    </tr>
                </table>
            </div>
        ');

        $mpdf->Output('pdf/'.$datos['id_pedido'].'.pdf', \Mpdf\Output\Destination::FILE);
    }
}
