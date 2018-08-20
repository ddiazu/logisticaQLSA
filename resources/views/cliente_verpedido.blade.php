@extends('plantilla')      

@section('contenedorprincipal')

<div style="padding: 5px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <h5><b>Pedido Nº {{ $pedido[0]->idPedido }}</b></h5>
        </div>
        <div class="padding-md clearfix">
        	<div>
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        		<div class="row" style="padding-top: 5px">
        			<div class="col-sm-2 col-md-2 col-lg-1">
        				Cliente
        			</div>
         			<div class="col-sm-5 col-md-4 col-lg-3">
        				<input class="form-control input-sm" readonly value="{{ $pedido[0]->emp_nombre }}">
        			</div>
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        Fecha Creación
                    </div>
                    <div class="col-sm-3 col-md-2 col-lg-2">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->fechahora_creacion }}">
                    </div> 
                    <div class="col-sm-2 col-md-2 col-lg-1">
                        N.Venta Nº
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        <a href="{{ asset('/') }}vernotaventa/{{ $pedido[0]->idNotaVenta }}/1/" class="btn btn-xs btn-info">{{ $pedido[0]->idNotaVenta }}</a>
                    </div>                          			
        		</div>
        		<div class="row" style="padding-top: 5px">
                    <div class="col-sm-2 col-md-1 col-lg-1">
                        Obra
                    </div>
                    <div class="col-sm-4 col-md-5 col-lg-5">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->Obra }}">
                    </div>                      
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        Fecha Entrega
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->fechaEntrega }}">
                    </div>                    
        			<div class="col-sm-1 col-md-1 col-lg-1">
        				Horario
        			</div>
         			<div class="col-sm-1 col-md-2 col-lg-1">
        				<input class="form-control input-sm" readonly style="width: 40px" value="{{ $pedido[0]->horarioEntrega }}">
        			</div>      			
        		</div>
        		<div class="row" style="padding-top: 5px">
        			<div class="col-sm-2 col-md-1 col-lg-1">
        				Estado
        			</div>
         			<div class="col-sm-4 col-md-2 col-lg-2">
        				<input class="form-control input-sm" readonly value="{{ $pedido[0]->estado }}">
        			</div>         			     			
        		</div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-sm-2 col-md-2 col-lg-1">
                        Observaciones
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->observaciones }}">
                    </div>
                    @if ($pedido[0]->noExcederCantidadSolicitada==1)
                        <div class="col-sm-5 col-md-5 col-lg-4">
                            <h4><span class="label label-danger">NO EXCEDER LA CANTIDAD SOLICITADA</span></h4>
                        </div>
                    @endif                     
                </div>                      		  		
        	</div>

        </div>
        <div style="padding: 20px">
            <table id="tablaDetalle" class="table table-hover table-condensed table-responsive">
                <thead>
                    <th style="display: none">Codigo</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    @if( Session::get('idPerfil')=='2' || Session::get('idPerfil')=='11' )   
                        <th>Precio</th>
                        <th>Total</th>
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
                        <td> {{ $item->cantidad }} </td>
                        <td> {{ $item->u_nombre }} </td>
                        @if( Session::get('idPerfil')=='2' || Session::get('idPerfil')=='11' )   
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
                    @if( Session::get('idPerfil')=='2' || Session::get('idPerfil')=='11' )   
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
                        </tr> 
                    @endif                     
                </tfoot>
            </table>
        </div> 

        <div style="padding-top:18px; padding-bottom: 20px;padding-left: 20px">
            <a href="{{ asset('/') }}clientePedidos" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>                                    
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