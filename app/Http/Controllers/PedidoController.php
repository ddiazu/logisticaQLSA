<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PedidoController extends Controller
{
    //

    public function index($idNotaVenta)
    {
        //
        $NotadeVenta=DB::Select('call spGetNotaVenta(?)', array($idNotaVenta) );
        $NotadeVentaDetalle=DB::Select('call spGetNotaVentaDetalle(?)', array($idNotaVenta) );
        $plantas=DB::table('plantas')->select('idPlanta', 'nombre')->get();
        $formaEntrega=DB::table('formasdeentrega')->select('idFormaEntrega', 'nombre')->get();
        $parametros=DB::table('parametros')->select('iva', 'maximo_toneladas_por_pedido', 'maximo_productos_por_pedido', 'notaPedido1', 'notaPedido2')->get();
        return view('gestionarpedido')->with('NotadeVenta', $NotadeVenta)
                                      ->with('NotadeVentaDetalle', $NotadeVentaDetalle)
                                      ->with('FormasdeEntrega', $formaEntrega)
                                      ->with('Plantas', $plantas)
                                      ->with('parametros', $parametros);
    }


    public function detalleNotaVenta(Request $datos){
        if($datos->ajax()){
            $NotadeVentaDetalle=DB::Select('call spGetNotaVentaDetalle(?)', array($datos->input('idNotaVenta')) );
            return $NotadeVentaDetalle;
        }
    }

    public function clienteGestionarPedido($idNotaVenta)
    {
        //
        $NotadeVenta=DB::Select('call spGetNotaVenta(?)', array($idNotaVenta) );
        $NotadeVentaDetalle=DB::Select('call spGetNotaVentaDetalle(?)', array($idNotaVenta) );
        $plantas=DB::table('plantas')->select('idPlanta', 'nombre')->get();
        $formaEntrega=DB::table('formasdeentrega')->select('idFormaEntrega', 'nombre')->get();
        $parametros=DB::table('parametros')->select('iva', 'maximo_toneladas_por_pedido', 'maximo_productos_por_pedido', 'notaPedido1', 'notaPedido2')->get();
        return view('cliente_gestionarpedido')->with('NotadeVenta', $NotadeVenta)
                                      ->with('NotadeVentaDetalle', $NotadeVentaDetalle)
                                      ->with('FormasdeEntrega', $formaEntrega)
                                      ->with('Plantas', $plantas)
                                      ->with('parametros', $parametros);
    }

    // Vista por pedido para los usuarios Ejecutivos de Crédito    
    public function listaPedidos(){
        if( Session::get('idPerfil')=='11' ){
            $pedidos=DB::Select('call spGetPedidos');
        }else{
            $pedidos=DB::Select('call spGetProductosconPedidoPendiente(?)', array(0) );
        }
        
        $pedidosIngresoCliente=DB::Select('call spGetpedidosIngresadosporClientesSinAprobar');
        $cantidadIngresoCliente=count($pedidosIngresoCliente);


        return view('listaPedidos')->with('pedidos', $pedidos)->with('cantidadIngresoCliente', $cantidadIngresoCliente);    	
    }

    // Vista para Pre Aprobar pedidos ingresados por Clientes  
    public function listaIngresosClienteporAprobar(){
        $pedidos=DB::Select('call spGetpedidosIngresadosporClientesSinAprobar');
        return view('listaIngresosClienteporAprobar')->with('pedidos', $pedidos);          
    }

    public function listaPedidosDetallado(){
        $pedidos=DB::Select('call spGetProductosconPedidoPendiente(?)', array(0) );
        $pedidosIngresoCliente=DB::Select('call spGetpedidosIngresadosporClientesSinAprobar');
        $cantidadIngresoCliente=count($pedidosIngresoCliente);        
        return view('listaPedidos')->with('pedidos', $pedidos)->with('cantidadIngresoCliente', $cantidadIngresoCliente);      
    }    


    // Vista para Aprobar pedidos por Usuarios Comerciales  
    public function clientePedidos(){
        $pedidos=DB::Select('call spGetProductosconPedidoPendiente(?)', array( Session::get('empresaUsuario' ) ) );
        return view('cliente_pedidos')->with('pedidos', $pedidos);  
    }    

    public function historicoPedidos(){
        $pedidos=DB::Select('call spGetPedidosHistorico');
        return view('historicoPedidos')->with('pedidos', $pedidos);     
    }


    public function programacion(){
        $pedidos=DB::Select('call spGetProductosconPedidoPendiente(?)', array(0) );
        return view('programacion')->with('pedidos', $pedidos);     
    }    

    public function pedidosEnProceso(){
        $pedidos=DB::Select('call spGetProductosconPedidoPendiente(?)', array(0) );
        return view('pedidosEnProceso')->with('pedidos', $pedidos);     
    }    


    public function AprobarPedidos(){
        $listaPedidos=DB::Select('call spGetAprobarPedidos');           
        return view('aprobarpedidos')->with('pedidos', $listaPedidos);
    } 

     public function aprobarPedidoCliente(Request $datos){
        if($datos->ajax()){
            $pedido=DB::Select("call spUpdAprobarPedidoCliente(?, ?)", array( $datos->input('idPedido'), Session::get('idUsuario') ) );
            return response()->json([
                "identificador" => $pedido[0]->idPedido
            ]);
        }
    }    


    public function aprobarPedido(Request $datos){
        if($datos->ajax()){
            $pedido=DB::Select("call spUpdAprobarPedido(?,?)", array( $datos->input('idPedido'), Session::get('idUsuario')  ));
            return response()->json([
                "identificador" => $pedido[0]->idPedido
            ]);
        }
    }

    public function desaprobarPedido($idPedido){
        $pedido=DB::Select('call spUpdDesaprobarPedido(?,?)', array( $idPedido, Session::get('idUsuario') ) );      
        return redirect('listarPedidos');
    }

    public function suspenderPedido($idPedido){
        $pedido=DB::Select('call spUpdSuspenderPedido(?,?)', array( $idPedido, Session::get('idUsuario') ) );      
        return redirect('listarPedidos');
    }

    public function cerrarPedido($idPedido){
        $pedido=DB::Select('call spUpdCerrarPedido(?,?)', array( $idPedido, Session::get('idUsuario') ) );
        dd(Session::get('grupoUsuario'));
        if (Session::get('grupoUsuario')=='P'){
            return redirect('programacion');
        }else{
            return redirect('listarPedidos');
        }
        
    }      

    public function editarPedido($idPedido){
        $pedido=DB::Select('call spGetPedido(?)', array($idPedido) );
        $listaDetallePedido=DB::Select('call spGetPedidoDetalle(?)', array($idPedido) );
        $log = DB::Select('call spGetPedidoLog(?)', array($idPedido) );
        $emptransporte = DB::table('empresastransporte')->select('idEmpresaTransporte','nombre')->get();
        $plantas=DB::table('plantas')->select('idPlanta', 'nombre')->get();
        $formasdeentrega=DB::table('formasdeentrega')->select('idFormaEntrega', 'nombre')->get();
        return view('editarpedido')->with('pedido', $pedido)
                                ->with('listaDetallePedido', $listaDetallePedido)
                                ->with('emptransporte', $emptransporte)
                                ->with('log', $log)
                                ->with('plantas', $plantas)
                                ->with('formasdeentrega', $formasdeentrega);
    }      

    public function verpedido($idPedido, $accion){
        $pedido=DB::Select('call spGetPedido(?)', array($idPedido) );
        $listaDetallePedido=DB::Select('call spGetPedidoDetalle(?)', array($idPedido) );
        $log = DB::Select('call spGetPedidoLog(?)', array($idPedido) );
        $notas = DB::Select('call spGetPedidoNotas(?)', array($idPedido) );
        $emptransporte = DB::table('empresastransporte')->select('idEmpresaTransporte','nombre')->get();
        return view('verpedido')->with('pedido', $pedido)
                                ->with('listaDetallePedido', $listaDetallePedido)
                                ->with('accion', $accion)
                                ->with('emptransporte', $emptransporte)
                                ->with('log', $log)
                                ->with('notas', $notas);
    }

    public function clienteVerPedido($idPedido, $accion){
        $pedido=DB::Select('call spGetPedido(?)', array($idPedido) );
        $listaDetallePedido=DB::Select('call spGetPedidoDetalle(?)', array($idPedido) );
        $emptransporte = DB::table('empresastransporte')->select('idEmpresaTransporte','nombre')->get();
        return view('cliente_verpedido')->with('pedido', $pedido)
                                ->with('listaDetallePedido', $listaDetallePedido)
                                ->with('accion', $accion)
                                ->with('emptransporte', $emptransporte);
    }
    public function programarpedido($idPedido){
        $pedido=DB::Select('call spGetPedido(?)', array($idPedido) );
        $listaDetallePedido=DB::Select('call spGetPedidoDetalle(?)', array($idPedido) );
        $log = DB::Select('call spGetPedidoLog(?)', array($idPedido) );
        $notas = DB::Select('call spGetPedidoNotas(?)', array($idPedido) );
        $emptransporte = DB::table('empresastransporte')->select('idEmpresaTransporte','nombre')->get();
        return view('programacionPedido')->with('pedido', $pedido)
                                ->with('listaDetallePedido', $listaDetallePedido)
                                ->with('emptransporte', $emptransporte)
                                ->with('log', $log)
                                ->with('notas', $notas);
    }    

    public function grabarNuevoPedido(Request $datos){
        if($datos->ajax()){

            //$detalle = json_decode($datos->input('detalle'));
            $detalle=$datos->input('detalle');
            $detalle= json_decode($detalle);
            
            $idPedido=DB::Select('call spInsPedido(?,?,?,?,?,?,?,?,?,?,?,?,?,? )', array(
                            $datos->input('idNotaVenta'),
                            $datos->input('fechaEntrega'),
                            $datos->input('observaciones'),
                            $datos->input('horarioEntrega'),
                            $datos->input('idEstadoPedido'),
                            $datos->input('usu_codigo_estado'),
                            $datos->input('totalNeto'),
                            $datos->input('contacto'),
                            $datos->input('telefono'),
                            $datos->input('email'),
                            $datos->input('noExcederCantidad'),
                            $datos->input('tipoCarga'),
                            $datos->input('tipoTransporte'),
                            Session::get('empresaUsuario')
                            ) 
                        );  

            foreach ( $detalle as $item){
                DB::Select("call spInsPedidoDetalle(?,?,?,?,?,?,?,?)", array( $idPedido[0]->idPedido, $item->idNotaVenta, $item->prod_codigo, $item->u_codigo, $item->cantidad, $item->precio, $item->idPlanta, $item->idFormaEntrega ) );
            }

            return response()->json([
                "identificador" => $idPedido[0]->idPedido
            ]);
        }
    }

    public function actualizarPedido(Request $datos){
        if($datos->ajax()){
            $detalle=$datos->input('detalle');
            $detalle= json_decode($detalle);
            
            $idPedido=DB::Select('call spUpdPedido(?,?,?,?,?,?,?)', array(
                            $datos->input('idPedido'),
                            $datos->input('fechaEntrega'),
                            $datos->input('horarioEntrega'),
                            $datos->input('observaciones'),
                            $datos->input('totalNeto'),
                            Session::get('idUsuario'),
                            $datos->input('motivo'),
                            ) 
                        );  

            foreach ( $detalle as $item){
                DB::Select("call spUpdPedidoDetalle(?,?,?,?,?)", array( $idPedido[0]->idPedido, $item->prod_codigo,  $item->cantidad, $item->idPlanta, $item->idFormaEntrega ) );
            }

            return response()->json([
                "identificador" => $idPedido[0]->idPedido
            ]);
        }
    }

    public function agregarNota(Request $datos){
        if($datos->ajax()){
            
            $nota=DB::Select('call spInsPedidoNota(?,?,?)', array(
                            $datos->input('idPedido'),
                            $datos->input('nota'),
                            Session::get('idUsuario')
                            ) 
                        );  

            return $nota;
        }
    }

    public function eliminarNota(Request $datos){
        if($datos->ajax()){
            $nota=DB::Select('call spDelPedidoNota(?)', array(
                            $datos->input('idNota')
                            ) 
                        );  
            return $nota;
        }
    }


    public function guardarDatosProgramacion(Request $datos){
        if($datos->ajax()){

            $detalle=$datos->input('detalle');
            $detalle= json_decode($detalle);           
            foreach ( $detalle as $item){
                DB::Select("call spUpdPedidoProgramacion(?,?,?,?,?,?,?,?)", array( $datos->input('idPedido'),
                 $item->prod_codigo, 
                 $item->idEmpresaTransporte, 
                 $item->idCamion, 
                 $item->idConductor, 
                 $item->fechaCarga, 
                 $item->horaCarga,
                 $item->peso ) );
            }

            return response()->json([
                "identificador" =>  $datos->input('idPedido')
            ]);
        } 

    }

}
