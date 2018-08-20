<?php

namespace App\Http\Controllers;

use App\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObraController extends Controller
{

    public function agregarObra(Request $datos)
    {
        //
        if($datos->ajax()){
            $obra=DB::Select("call spInsObra(?,?,?,?,?,?,?,?,?,?,?)", array( $datos->input('idObra'), 
                                                                        $datos->input('nombre'),
                                                                        $datos->input('descripcion'),
                                                                        $datos->input('nombreContacto'),
                                                                        $datos->input('correoContacto'),
                                                                        $datos->input('telefonoContacto'),
                                                                        $datos->input('emp_codigo'),
                                                                        $datos->input('distancia'),
                                                                        $datos->input('tiempo'),
                                                                        $datos->input('costoFlete'),
                                                                        $datos->input('codigoSoftland')
                                                                    ));
            return response()->json([
                "idObra" => $obra[0]->idObra
            ]);
        }
        
    }

    public function listarObras(Request $datos)
    {
        //
        if($datos->ajax()){
            return DB::table('obras')->select('idObra', 'nombre')->where('emp_codigo', $datos->input('emp_codigo') )->get();
        }
    }    

    public function listadeObras(){
        $obras=DB::Select('call spGetObras()');
        $clientes=DB::table('empresas')->select('emp_codigo', 'emp_nombre')->orderBy('emp_nombre')->get();
        return view('listadeObras')->with('listaObras', $obras)->with('clientes', $clientes);
    }

    public function datosObra(Request $datos)
    {
        if($datos->ajax()){
            return DB::table('obras')->select('nombre', 'nombreContacto', 'correoContacto', 'telefonoContacto', 'emp_codigo', 'descripcion', 'distancia', 'tiempo', 'costoFlete', 'codigoSoftland')->where('obras.idObra', $datos->idObra)->get();
        }
    }    



}
