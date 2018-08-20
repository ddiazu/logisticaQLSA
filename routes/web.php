<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::post('verificarusuario', 'UsuarioController@verificarusuario');
Route::post('cargarPerfil', 'UsuarioController@cargarPerfil');
Route::post('validarUsuario', 'UsuarioController@validarUsuario');
Route::post('agregarObra', 'ObraController@agregarObra');
Route::post('listarObras', 'ObraController@listarObras');
Route::post('datosObra', 'ObraController@datosObra');
Route::post('datosNotaVenta', 'NotaventaController@datosNotaVenta');
Route::post('grabarNuevaNotaVenta', 'NotaventaController@grabarNuevaNotaVenta');
Route::post('grabarNuevoPedido',  'PedidoController@grabarNuevoPedido');
Route::post('aprobarPedido',  'PedidoController@aprobarPedido');
Route::post('aprobarPedidoCliente',  'PedidoController@aprobarPedidoCliente');
Route::post('guardarDatosProgramacion',  'PedidoController@guardarDatosProgramacion');
Route::post('agregarEmpresaTransporte',  'EmpresaTransporteController@agregarEmpresaTransporte');
Route::post('apiPlantas', 'PlantaController@apiPlantas');
Route::post('apiFormadeEntrega', 'FormadeentregaController@apiFormadeEntrega');
Route::post('datosCotizacion', 'CotizacionController@datosCotizacion');
Route::post('EmpresaConductores',  'EmpresaTransporteController@EmpresaConductores');
Route::post('EmpresaCamiones',  'EmpresaTransporteController@EmpresaCamiones');
Route::post('listaCamiones',  'CamionController@listaCamiones');
Route::post('listaConductores',  'ConductorController@listaConductores');
Route::post('cotizacionProductos', 'CotizacionController@cotizacionProductos');
Route::post('detalleNotaVenta', 'PedidoController@detalleNotaVenta');
Route::post('actualizarPedido', 'PedidoController@actualizarPedido');
Route::post('guardarDatosCliente', 'EmpresaController@guardarDatosCliente');
Route::post('guardarDatosProducto', 'ProductoController@guardarDatosProducto');
Route::post('agregarNota', 'PedidoController@agregarNota');
Route::post('eliminarNota', 'PedidoController@eliminarNota');
Route::post('crearGuiaDespachoElectronica', 'GuiaController@crearGuiaDespachoElectronica');
Route::post('registrarSalidaDespacho', 'GuiaController@registrarSalidaDespacho');
Route::post('generarArchivoGuiaDespacho', 'GuiaController@generarArchivoGuiaDespacho');
Route::post('datosGuiaDespacho', 'GuiaController@datosGuiaDespacho');
Route::post('subirCertificado', 'GuiaController@subirCertificado');
Route::post('solicitarSessionIDSitrack', 'SitrackController@solicitarSessionIDSitrack');

Route::get('aprobarnota/{idNotaVenta}/', 'NotaventaController@aprobarnota');
Route::get('Desaprobarnota/{idNotaVenta}/', 'NotaventaController@Desaprobarnota');
Route::get('desaprobarPedido/{idPedido}/', 'PedidoController@desaprobarPedido');
Route::get('suspenderPedido/{idPedido}/', 'PedidoController@suspenderPedido');
Route::get('cerrarPedido/{idPedido}/', 'PedidoController@cerrarPedido');
Route::get('clienteNotasdeVenta', 'NotaventaController@clienteNotasdeVenta');
Route::get('guiasEnProceso', 'GuiaController@guiasEnProceso');
Route::get('bajarCertificado/{file}/', 'GuiaController@bajarCertificado');

Route::get('aprobarnotaventa', 'NotaventaController@AprobarNotasdeVenta');
Route::get('aprobarpedidos', 'PedidoController@AprobarPedidos');
Route::get('listarNotasdeVenta', 'NotaventaController@listarNotasdeVenta');
Route::get('historicoNotasdeVenta', 'NotaventaController@historicoNotasdeVenta');
Route::get('vernotaventa/{id}/{accion}', 'NotaventaController@vernotaventa');
Route::get('listarPedidos', 'PedidoController@listaPedidos');
Route::get('clientePedidos', 'PedidoController@clientePedidos');
Route::get('historicoPedidos', 'PedidoController@historicoPedidos');
Route::get('editarPedido/{idPedido}/', 'PedidoController@editarPedido');

Route::get('listaIngresosClienteporAprobar', 'PedidoController@listaIngresosClienteporAprobar');

Route::get('programacion', 'PedidoController@programacion');
Route::get('dashboard', 'Controller@dashboard');
Route::get('volver', 'Controller@volver');
Route::get('terminarSesion', 'UsuarioController@terminarSesion');
Route::get('listaEmpresas', 'EmpresaController@listaEmpresas');
Route::get('listaPlantas', 'PlantaController@listaPlantas');
Route::get('listaProductos', 'ProductoController@listaProductos');
Route::get('listaUsuarios', 'UsuarioController@listaUsuarios');
Route::get('listadeObras', 'ObraController@listadeObras');
Route::get('listaEmpresasTransporte', 'EmpresaTransporteController@listaEmpresas');
Route::get('verpedido/{idPedido}/{accion}/', 'PedidoController@verpedido');
Route::get('clienteVerPedido/{idPedido}/{accion}/', 'PedidoController@clienteVerPedido');
Route::get('programarpedido/{idPedido}/{accion}/', 'PedidoController@programarpedido');
Route::get('datosEmpresaTransporte/{id}/', 'EmpresaTransporteController@datosEmpresaTransporte');
Route::get('registroSalida', 'GuiaController@registroSalida');
Route::get('sendemail', function () {
	$data = array('name'=> 'Curso Laravel');

	Mail::send('email', $data, function ( $message) {
		$message->from('daviddiaz1402@gmail.com', 'Curso Laravel');
		$message->to('daviddiaz1402@gmail.com')->subject('test email Curso Laravel');
	});

	return 'Tu email ha sido enviado correctamente';
});


Route::get('clienteGestionarPedido/{idNotaVenta}/','PedidoController@clienteGestionarPedido');

Route::resource('nuevanotaventa', 'NotaventaController', ['except' => 'show']);
Route::resource('gestionarpedido/{idNotaVenta}', 'PedidoController', ['except' => 'show']);


