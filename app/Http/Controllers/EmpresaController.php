<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listaEmpresas()
    {
        //
        $listaEmpresas=Empresa::orderBy('emp_nombre')->get();
        return view('clientes')->with('listaEmpresas', $listaEmpresas);
    }

    public function guardarDatosCliente(Request $datos){
        if($datos->ajax()){
            $empresa=DB::Select('call spUpdEmpresa(?,?,?,?,?,?)', array(
                            $datos->input('emp_codigo'),
                            $datos->input('razonSocial'),
                            $datos->input('nombre'),
                            $datos->input('direccion'),
                            $datos->input('solicitaOC'),
                            $datos->input('codigoSoftland'),
                            ) 
                        );  

            return response()->json([
                "identificador" =>  $empresa[0]->emp_codigo
            ]);
        }             
    }

}
