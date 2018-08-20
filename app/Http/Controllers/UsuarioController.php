<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listaUsuarios()
    {
        //
        $listaUsuarios=Usuario::All();
        return view('usuarios')->with('listaUsuarios', $listaUsuarios);
    }


    public function verificarusuario(Request $datos)
    {
        //
        if($datos->ajax()){
           $usuario=DB::Select('call validarUsuario(?, ?)', array($datos->input("email"), $datos->input("password")) );
           if($usuario[0]->usu_codigo!='-1'){
               $perfiles=DB::Select('call spGetUsuarioPerfiles(?)', array($usuario[0]->usu_codigo) );
               Session::put('idUsuario', $usuario[0]->usu_codigo);
               Session::put('nombreUsuario', $usuario[0]->nombreUsuario);
               Session::put('correoUsuario', $usuario[0]->usu_correo);
               Session::put('grupoUsuario', $usuario[0]->grupo);
               Session::put('empresaUsuario', $usuario[0]->emp_codigo);
               Session::put('empresaNombre', $usuario[0]->emp_nombre); 
               return $perfiles;           
           }else{
                return $usuario;   
           }

           
        }
    }

    public function cargarPerfil(Request $datos){
        if($datos->ajax()){
            Session::put('idPerfil', $datos->input("idPerfil") );
            Session::put('nombrePerfil', $datos->input("nombrePerfil") );
            Session::put('grupoUsuario', $datos->input("grupo") );
            return response()->json([
                "dato" => "1"
            ]);         
        }
    }


       
    public function validarUsuario(Request $datos)
    {
        //
        if($datos->ajax()){ 
           $usuario=DB::Select('call validarUsuario(?, ?)', array($datos->email, $datos->password) );
           return $usuario;
        }
    }


    public function terminarSesion(){
        Session::flush();
        return redirect('/');
    }


}
