<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    //

    public function listaProductos()
    {
        //
        $listaProductos=Producto::All();
        return view('productos')->with('listaProductos', $listaProductos);
    }

    public function guardarDatosProducto(Request $datos){
        if($datos->ajax()){
            $producto=DB::Select('call spUpdProducto(?,?,?,?,?,?)', array(
                            $datos->input('prod_codigo'),
                            $datos->input('nombre'),
                            $datos->input('descripcion'),
                            $datos->input('precioReferencia'),
                            $datos->input('requiereDiseno'),
                            $datos->input('codigoSoftland')
                            ) 
                        );  

            return response()->json([
                "identificador" =>  $producto[0]->prod_codigo
            ]);
        }   
    }

}    
