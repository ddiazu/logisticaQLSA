<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dashboard(){
    	$datos=DB::Select('call spGetDashBoard');
    	$nombreUsuario= explode(" ", Session::get('nombreUsuario'));


    	$pedidos=DB::Select('call spGetProductosconPedidoPendiente(?)', array( Session::get('empresaUsuario' ) ) );

        return view('dashboard')->with('datos', $datos)->with('nombreUsuario', $nombreUsuario[0])->with('pedidos', $pedidos);
    }

    public function volver(){
    	return redirect(redirect()->getUrlGenerator()->previous());
    }

}
