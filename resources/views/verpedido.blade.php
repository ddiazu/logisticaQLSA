@extends('plantilla')      

@section('contenedorprincipal')

<div style="padding: 5px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <h5><b>Pedido Nº {{ $pedido[0]->idPedido }}</b></h5>
        </div>
        <div class="padding-md clearfix">
        	<div>
                <input type="hidden" id="idPedido" value="{{ $pedido[0]->idPedido }}">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-md-1 col-sm-1">
                        Cliente
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-5">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->emp_nombre }}">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        Creación
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->fechahora_creacion }}">
                    </div> 
                    <div class="col-lg-1 col-md-1 col-sm-1">
                        N.Venta 
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        <a class="btn btn-success btn-sm" style="width: 100%" href="{{ asset('/') }}vernotaventa/{{ $pedido[0]->idNotaVenta }}/2/">{{ $pedido[0]->idNotaVenta }}</a>
                    </div>                                      
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-md-1 col-sm-1">
                        Obra
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-5">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->Obra }}">
                    </div>                      
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        Fecha&nbspEntrega
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->fechaEntrega }} {{ $pedido[0]->horarioEntrega }}">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        Ejecutivo&nbspQL
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->usuario_encargado }}">
                    </div>                       
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-md-1 col-sm-1">
                        Estado
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3">
                       <b><input class="form-control input-sm" readonly value="{{ $pedido[0]->estado }}"></b>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-2">
                        Observaciones
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-6">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->observaciones }}">
                    </div>                                                      
                </div>
                @if ($pedido[0]->noExcederCantidadSolicitada==1)
        		    <div class="row" style="padding-top: 5px">
                        <div class="col-md-12" style="text-align: right;">
                            <h4><span class="label label-danger">NO EXCEDER LA CANTIDAD SOLICITADA</span></h4>
                        </div>          
                    </div>
                @endif                      		  		
        	</div>

        </div>
        <div style="padding: 10px">
            <table id="tablaDetalle" class="table table-hover table-condensed table-responsive">
                <thead>
                    <th style="display: none">Codigo</th>
                    <th>Producto</th>
                    <th style="width: 60px">Cantidad</th>
                    <th>Unidad</th>
                    @if( Session::get('grupoUsuario')=='C' )   
                        <th>Precio ($)</th>
                        <th>Total ($)</th>
                    @endif
                    <th>Planta de Origen</th>
                    <th>Entrega</th>
                    <th>Transporte</th>
                    <th>Camion</th>
                    <th>Conductor</th>
                    <th>Fecha Carga</th>
                    <th>Hora Carga</th>
                </thead>
            
                <tbody>
                    @foreach($listaDetallePedido as $item)
                    <tr>
                        <td style="display: none"> {{ $item->prod_codigo }} </td>
                        <td> {{ $item->prod_nombre }} </td>
                        <td style="width: 60px">
                                {{ $item->cantidad }}
                        </td>   
                        <td> {{ $item->u_nombre }} </td>
                        @if( Session::get('grupoUsuario')=='C' )   
                            <td align="right">{{ number_format( $item->cp_precio, 0, ',', '.' ) }}</td>
                            <td align="right">{{ number_format( $item->cp_precio * $item->cantidad , 0, ',', '.' ) }}</td>
                        @endif    
                        <td> {{ $item->nombrePlanta }} </td>
                        <td> {{ $item->nombreFormaEntrega }} </td>
                        <td> {{ $item->nombreEmpresaTransporte }} </td>
                        <td> {{ $item->patente }} </td>
                        <td> {{ $item->nombreConductor }} </td>
                        <td> {{ $item->fechaCarga }} </td>
                        <td> {{ $item->horaCarga }} </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot> 
                    @if( Session::get('grupoUsuario')=='C' )   
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right"><b>Neto $</b></td>
                            <td align="right"><b>{{ number_format( $pedido[0]->totalNeto, 0, ',', '.' ) }} </b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>                     
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right"><b>Iva $</b></td>
                            <td align="right"><b>{{ number_format( $pedido[0]->montoIva, 0, ',', '.' ) }} </b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>                          
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right"><b>Total $</b></td>
                            <td align="right"><b>{{ number_format( $pedido[0]->totalNeto + $pedido[0]->montoIva, 0, ',', '.' ) }} </b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>                        
                        </tr> 
                    @endif                     
                </tfoot>
            </table>
        </div> 

        <div style="padding-top:18px; padding-bottom: 20px;padding-left: 20px">
            @if (Session::get('grupoUsuario')=='C' and $pedido[0]->idEstadoPedido >0 )
                <a href="{{ asset('/') }}editarPedido/{{ $pedido[0]->idPedido }}/" class="btn btn-sm btn-success" style="width:100px">Modificar</a>
            @endif
            @if ($accion=='1')
                @if (Session::get('grupoUsuario')=='C' and (Session::get('idPerfil')=='2' or Session::get('idPerfil')=='11') )
                    @if ($pedido[0]->idEstadoPedido==2 and $pedido[0]->idTransporte==0 )
                        <a href="{{ asset('/') }}desaprobarPedido/{{ $pedido[0]->idPedido }}/" class="btn btn-sm btn-primary" style="width:100px">Desaprobar</a>
                    @endif
                @endif    
                <a href="{{ asset('/') }}listarPedidos" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
                @if (Session::get('grupoUsuario')=='C' and (Session::get('idPerfil')=='2' or Session::get('idPerfil')=='11') )
                    @if ( $pedido[0]->idEstadoPedido>0 and $pedido[0]->idEstadoPedido < 5 ) 
                        <a href="{{ asset('/') }}suspenderPedido/{{ $pedido[0]->idPedido }}/" class="btn btn-sm btn-danger" style="width:100px">Suspender</a>
                    @endif
                @endif                 
            @elseif ($accion=='3')
                <a href="{{ asset('/') }}programacion" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
                @if ( $pedido[0]->idEstadoPedido=='0' and Session::get('idPerfil')=='5' )
                    <a href="{{ asset('/') }}cerrarPedido/{{ $pedido[0]->idPedido }}/" class="btn btn-sm btn-danger">Pasar a Histórico</a>
                @endif

            @elseif ($accion=='4')
                <a href="{{ asset('/') }}vernotaventa/{{ $pedido[0]->idNotaVenta }}/1/" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
            @elseif ($accion=='5')
                <a href="{{ asset('/') }}historicoPedidos" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
            @elseif ($accion=='6')
                <button class="btn btn-sm btn-primary" style="width:100px" onclick="aprobarPedidoCliente();">Aprobar</button>
                <a href="{{ asset('/') }}listaIngresosClienteporAprobar" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
            @elseif ($accion=='7')
                <a href="{{ asset('/') }}clientePedidos" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>                                                  
            @endif  
        </div>
        
        <div class="panel panel-default" id="contenedor3">
            <div class="panel-heading">
                <div class="panel-tab clearfix">
                    <ul class="tab-bar">
                        <li class="active"><a href="#tabLogAcciones" data-toggle="tab"><b>Registro de acciones sobre este Pedido</b></a></li>
                        <li><a href="#tabNotas" data-toggle="tab"><b>Notas</b>
                            @if (count($notas)>0)  
                                &nbsp&nbsp<span class="label label-danger" id="contNotas">{{ count($notas) }}</span>
                            @endif    
                        </a></li>                        
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="tabLogAcciones" style="padding-top: 5px">
                        <table id="tablaLog" class="table table-hover table-condensed table-responsive" style="width: 850px">
                            <thead>
                                <th style="width:200px">Fecha/Hora</th>
                                <th style="width:200px">Usuario</th>
                                <th style="width:100px">Acción</th>
                                <th style="width:350px">Motivo</th>
                            </thead>
                            <tbody>
                                @foreach($log as $item)
                                <tr>
                                    <td style="width:200px"> {{ $item->fechaHora }} </td>
                                    <td style="width:200px"> {{ $item->nombreUsuario }} </td>
                                    <td style="width:100px"> {{ $item->accion }} </td>
                                    <td style="width:350px"> {{ $item->motivo }} </td>
                                </tr>
                                @endforeach  
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tabNotas" style="padding-top: 5px">
                        <div style="padding: 10px">
                            <div class="col-md-1">
                                Nota
                            </div>
                            <div class="col-md-6">
                                <input id="txtNota" class="form-control input-sm" maxlength="255">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success btn-sm" onclick="agregarNota();">Agregar</button>
                            </div>                                                         
                        </div>
                        <div style="padding-left: 20px;padding-top: 40px;">
                            <table id="tablaNotas" class="table table-hover table-condensed table-responsive" style="width: 900px">
                                <thead>
                                    <th style="width:150px">Fecha/Hora</th>
                                    <th style="width:150px">Usuario</th>
                                    <th style="width:600px">Nota</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                @foreach($notas as $item)
                                <tr>
                                    <td style="width:200px"> {{ $item->fechaHora }} </td>
                                    <td style="width:200px" data-idUsuario="{{ $item->idUsuario }}"> {{ $item->nombreUsuario }} </td>
                                    <td style="width:100px"> {{ $item->nota }} </td>
                                    <td>
                                        @if( Session::get('idUsuario')==$item->idUsuario )
                                        <button class="btn btn-warning btn-sm" onclick="eliminarNota({{ $item->idNota }}, this.parentNode.parentNode.rowIndex)">Eliminar</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach                                      
                                </tbody>
                            </table>
                        </div>
                    </div>                
                </div>
            </div>                 
        </div>


        
    </div>
</div>

@endsection

@section('javascript')
    <!-- Datepicker -->
    <script src="{{ asset('/') }}js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('/') }}locales/bootstrap-datepicker.es.min.js"></script>  

    <!-- Timepicker -->
    <script src="{{ asset('/') }}js/bootstrap-timepicker.min.js"></script>  

    <script src="{{ asset('/') }}js/app/funciones.js"></script>
    <script src="{{ asset('/') }}js/app/verpedido.js"></script>
    <!-- Datatable -->
    <script src="{{ asset('/') }}js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Datepicker      
            $('.date').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1,
                language: "es",
                autoclose: true,
                startDate: '+0d'
            }) 
            cargarListas();
        });         
    </script>
       
@endsection