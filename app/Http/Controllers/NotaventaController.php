<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NotaventaController extends Controller
{
    //
    public function index()
    {
        //
        $plantas=DB::table('plantas')->select('nombre', 'idPlanta')->get();
        $formaEntrega=DB::table('formasdeentrega')->select('idFormaEntrega', 'nombre')->get();
        $usuarios=DB::Select('call spGetUsuarioPorGrupo(?)', array( 'C' ));     
        return view('nuevanventa')->with('Plantas', $plantas)->with('formaEntrega', $formaEntrega)->with('usuarios', $usuarios);
    }

    public function grabarNuevaNotaVenta(Request $datos){
    	if($datos->ajax()){

            //$detalle = json_decode($datos->input('detalle'));
            $detalle=$datos->input('detalle');
            $detalle= json_decode($detalle);
            $idnotaventa=DB::Select('call spInsNotaVenta(?,?,?,?,?,?,?,?,?,?)', array($datos->input('cot_numero'),
                            $datos->input('cot_año'),
                            $datos->input('idObra'),
                            $datos->input('observaciones'),
                            $datos->input('contacto'),
                            $datos->input('correo'),
                            $datos->input('telefono'),
                            $datos->input('ordenCompraCliente'),
                            $datos->input('idUsuarioEncargado'),
                            Session::get('idUsuario')
                            ) 
                        );  


            foreach ( $detalle as $item){
                DB::Select("call spInsNotaVentaDetalle(?,?,?,?,?,?,?,?)", array( $idnotaventa[0]->idNotaVenta, $item->prod_codigo, $item->formula, $item->cantidad, $item->u_codigo, $item->precio, $item->idPlanta, $item->idFormaEntrega ) );
            }

            return response()->json([
                "identificador" => $idnotaventa[0]->idNotaVenta
            ]);
        }
    }

    public function listarNotasdeVenta(){

		$listaNotasdeVenta=DB::Select('call spGetNotasdeVentas(?)', array(0) );       	
    	return view('listanotaventa')->with('listaNotasdeVenta', $listaNotasdeVenta);
    }

    public function clienteNotasdeVenta(){
        $listaNotasdeVenta=DB::Select('call spGetNotasdeVentas(?)', array( Session::get('empresaUsuario' ) ) );           
        return view('cliente_notasdeventa')->with('listaNotasdeVenta', $listaNotasdeVenta);
    }    

    public function historicoNotasdeVenta(){

        $listaNotasdeVenta=DB::Select('call spGetHistoricoNotasdeVentas');           
        return view('historicoNotasdeVenta')->with('listaNotasdeVenta', $listaNotasdeVenta);
    }


    public function aprobarnota($idNotaVenta){
        $notaventa=DB::Select('call spUpdAprobarNotaVenta(?,?)', array( $idNotaVenta, Session::get('idUsuario') ) );      
        $listaNotasdeVenta=DB::Select('call spGetNotasdeVentas(?)', array(0) );   
        return redirect('listarNotasdeVenta');
    }

    public function Desaprobarnota($idNotaVenta){
        $notaventa=DB::Select('call spUpdDesaprobarNotaVenta(?,?)', array( $idNotaVenta, Session::get('idUsuario')  ) );      
        return redirect('listarNotasdeVenta');
    }

    public function AprobarNotasdeVenta(){

        $listaNotasdeVenta=DB::Select('call spGetAprobarNotasdeVentas');           
        return view('aprobarnotaventa')->with('listaNotasdeVenta', $listaNotasdeVenta);
    }


    public function datosNotaVenta($id){
     //   return DB::table('cotizaciones')->join('empresas','empresas.emp_codigo', '=', 'cotizaciones.emp_codigo')->
     //   select('cotizaciones.cot_fecha_creacion', 'cotizaciones.cot_obra', 'empresas.emp_codigo',  'empresas.emp_razon_social', 'cotizaciones.cot_año')->where('cotizaciones.cot_numero', //$id)->get();        

     return DB::Select('call spGetNotaVenta(?)', array($id));   
    }

    public function vernotaventa($id, $accion){

        $notaventa=DB::Select('call spGetNotaVenta(?)', array($id));
        $notaventadetalle=DB::Select('call spGetNotaVentaDetalle(?)', array($id) );
        $pedidos=DB::Select('call spGetNotaVentaPedidos(?)', array($id) );
        return view('vernotaventa')->with('notaventa', $notaventa)
                                   ->with('notaventadetalle', $notaventadetalle)
                                   ->with('accion', $accion)
                                   ->with('pedidos', $pedidos);
    }

}
