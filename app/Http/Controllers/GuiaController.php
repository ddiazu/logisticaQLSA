<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class GuiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crearGuiaDespachoElectronica(Request $datos)
    {
        if($datos->ajax()){
            $detalle=$datos->input('detalle');
            $detalle= json_decode($detalle);
            $guia=DB::Select('call spGetNuevoNumeroGuia(?,?)', array( $datos->input('idPedido'), Session::get('idUsuario') ) );

            foreach ( $detalle as $item){
                DB::Select("call spInsGuiaDetalle(?,?,?,?,?,?)", array(   1,
                                                                        $guia[0]->nuevaGuia, 
                                                                        $datos->input('idPedido'), 
                                                                        $item->prod_codigo,
                                                                        $item->unidad, 
                                                                        $item->cantidad ) );
            }
            return response()->json([
                "nuevaGuia" => $guia[0]->nuevaGuia
            ]);
        }          

    }

    public function registroSalida(){
        $guias=DB::Select('call spGetGuiasParaDespacho()' );
        return view('registroSalida')->with('guias', $guias);
    }

    public function guiasEnProceso(){
        $guias=DB::Select('call spGetGuiasEnProceso()' );
        return view('guiasEnProceso')->with('guias', $guias);        
    }

    public function registrarSalidaDespacho(Request $datos){
        if($datos->ajax()){
            $guia=DB::Select('call spGetRegistrarSalidaDespacho(?,?, ?)', array( $datos->input('tipoGuia'), $datos->input('numeroGuia'), Session::get('idUsuario') ) );
            return response()->json([
                "numroGuia" => $guia[0]->numeroGuia
            ]);            
        }
    }

    public function generarArchivoGuiaDespacho(Request $datos){
        if($datos->ajax()){
            $guia=DB::Select('call spGetCompletarDatosGuiaDespacho(?,?,?,?,?,?,?,?)', array( $datos->input('tipoGuia'), $datos->input('numeroGuia'), $datos->input('nombreConductor'), $datos->input('patente'),
                $datos->input('sellos'), $datos->input('temperaturaCarga'), $datos->input('observaciones'), Session::get('idUsuario') ) );
            return response()->json([
                "numroGuia" => $guia[0]->numeroGuia
            ]);            
        }
    }

    public function datosGuiaDespacho(Request $datos){
        if($datos->ajax()){
            $guia=DB::Select('call spGetGuiaDespacho(?,?)', array( $datos->input('tipoGuia'), $datos->input('numeroGuia') ) );
            return $guia;      
        }        
    }

    public function subirCertificado(Request $data){
        $archivo=$data->file("miArchivo");
        $nombreArchivo= $data->input("codigoTipoGuia")."_".$data->input("numeroGuia")."_".$data->input("codigoProducto").".pdf";
        Storage::disk('certificados')->put($nombreArchivo, \File::get( $archivo) );

        DB::Select('call spUpdArchivoCertificado(?,?,?,?)', array( $data->input('codigoTipoGuia'), $data->input('numeroGuia'), $data->input("codigoProducto"), $nombreArchivo ) );

        return $nombreArchivo; 
    }

    public function bajarCertificado($file){
      $pathtoFile = public_path().'/certificados/'.$file;
   //   return $file;
      return response()->download($pathtoFile);
    }    
}
