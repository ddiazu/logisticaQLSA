@extends('plantilla')      

@section('contenedorprincipal')

<div style="padding: 10px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Nota de Venta Nº {{ $notaventa[0]->idNotaVenta }}</b>
        </div>
        <div class="padding-md clearfix"> 

                <input type="hidden" id="idCliente">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                <div class="row">        
                    <div class="col-lg-1 col-md-1 col-sm-2" >
                        Cliente
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtNombreCliente" readonly value="{{ $notaventa[0]->emp_nombre }}">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        Fecha
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtFechaCotizacion" readonly value="{{ $notaventa[0]->fechahora_creacion }}">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        Cotización
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtAno" maxlength="4" value="{{ $notaventa[0]->cot_numero }} / {{ $notaventa[0]->cot_año }}" readonly>
                    </div>                    
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        Crea
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtUsuarioCrea" readonly value="{{ $notaventa[0]->usuario_creacion }}">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2" >
                        Aprueba
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtUsuarioValida" readonly value="{{ $notaventa[0]->usuario_validacion }}">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                       Ejecutivo&nbspQL
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtUsuarioEncargado" readonly value="{{ $notaventa[0]->usuario_encargado }}">
                    </div>                     
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-sm-2 col-md-1">
                        Obra/Planta
                    </div>
                    <div class="col-lg-3 col-sm-4 col-md-3">                        
                        <input id="idObra" class="form-control input-sm" readonly value="{{ $notaventa[0]->Obra }}">
                    </div>
                    <div class="col-lg-1 col-sm-2 col-md-1">
                        O.Compra
                    </div>
                    <div class="col-lg-3 col-sm-4 col-md-5">                        
                        <input id="txtOrdenCompra" class="form-control input-sm" readonly value="{{ $notaventa[0]->ordenCompraCliente }}">
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-sm-2 col-md-1">
                        Contacto
                    </div>
                    <div class="col-lg-3 col-sm-4 col-md-3">                        
                        <input id="txtNombreContacto" class="form-control input-sm" readonly value="{{ $notaventa[0]->nombreContacto }}">
                    </div> 
                    <div class="col-lg-1 col-sm-2 col-md-1">
                        Teléfono
                    </div>
                    <div class="col-lg-3 col-sm-4 col-md-5">                        
                        <input id="txtTelefonoContacto" class="form-control input-sm" readonly value="{{ $notaventa[0]->telefonoContacto }}">
                    </div>                    
                    <div class="col-lg-1 col-sm-2 col-md-1">
                        Email
                    </div>
                    <div class="col-lg-3 col-sm-4 col-md-3">                        
                        <input id="txtCorreoContacto" class="form-control input-sm" readonly value="{{ $notaventa[0]->correoContacto }}">
                    </div>         
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-md-2 col-sm-2">
                        Observaciones
                    </div>
                    <div class="col-lg-7 col-md-10 col-sm-10">                            
                        <input id="idObra" class="form-control input-sm" readonly value="{{ $notaventa[0]->observaciones }}">
                    </div>
                </div>
             
            </div>            
            <div style="padding: 20px">
                <table id="tablaDetalle" class="table table-hover table-condensed" style="width: 800px">
                    <thead>
                        <th style="width: 50px">Codigo</th>
                        <th style="width: 100px">Producto</th>
                        <th style="width: 50px;text-align:right;">Cantidad</th>
                        <th style="width: 50px">Unidad</th>
                        @if( Session::get('grupoUsuario')=='C' or Session::get('grupoUsuario')=='CL')
                            <th style="width: 50px;text-align:right;">Precio Base ($)</th>
                        @endif
                        <th style="width: 50px;text-align:right;">Saldo</th>
                        @if( Session::get('grupoUsuario')=='C' or Session::get('grupoUsuario')=='CL')
                            <th style="width: 150px">Glosa de Reajuste</th>
                        @endif
                        <th style="width: 50px">Planta</th>
                        <th style="width: 50px">Entrega</th>
                    </thead>
                
                    <tbody>
                        @foreach($notaventadetalle as $item)
                        <tr>
                            <td style="width: 50px"> {{ $item->prod_codigo }} </td>
                            <td style="width: 50px"> {{ $item->prod_nombre }} </td>
                            <td style="width: 50px;text-align:right;"> {{ $item->cantidad }} </td>
                            <td style="width: 50px"> {{ $item->u_nombre }} </td>
                            @if( Session::get('grupoUsuario')=='C' or Session::get('grupoUsuario')=='CL')
                                <td style="width: 50px;text-align:right;">{{ number_format( $item->precio, 0, ',', '.' ) }}</td>
                            @endif    
                            <td style="width: 50px;text-align:right;"> {{ $item->cantidad-$item->CantidadPedida }} </td>
                            @if( Session::get('grupoUsuario')=='C' or Session::get('grupoUsuario')=='CL')
                                <td style="width: 150px"> {{ $item->cp_glosa_reajuste }} </td>
                            @endif    
                            <td style="width: 50px"> {{ $item->nombrePlanta }} </td>
                            <td style="width: 50px"> {{ $item->nombreFormaEntrega }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 

            <div style="padding-top: 20px; padding-left: 20px">
                @if (count($pedidos)>0)
                    <div class="row" style="padding: 5px">
                        <b>Pedidos Asociados a esta Nota de Venta. ( * = pendiente de aprobación )</b>
                    </div>
                    <div class="row" style="padding-top: 5px; padding-left: 5px"">
                        @foreach($pedidos as $item)
                            @if( $item->idEstadoPedido==1 )
                                <a href="{{ asset('/') }}verpedido/{{ $item->idPedido }}/4/" class="btn btn-xs btn-info"> {{$item->idPedido}} *</a>
                            @else
                                <a href="{{ asset('/') }}verpedido/{{ $item->idPedido }}/4/" class="btn btn-xs btn-primary"> {{$item->idPedido}} </a>
                            @endif    
                        @endforeach 
                    </div>                      
                @else
                    <b>Esta Nota de Venta no tiene pedidos asociados.</b>    
                @endif

            </div>

            <div style="padding-top:18px; padding-bottom: 20px;padding-left: 15px">
                @if( Session::get('grupoUsuario')=='C' and $notaventa[0]->aprobada==0 )
                    <a href="{{ asset('/') }}aprobarnota/{{  $notaventa[0]->idNotaVenta }}/" class="btn btn-sm btn-primary" style="width:80px">Aprobar</a>
                @endif
                @if( Session::get('grupoUsuario')=='C' and $notaventa[0]->aprobada==1 and $notaventa[0]->TienePedidos==0)
                    <a href="{{ asset('/') }}Desaprobarnota/{{  $notaventa[0]->idNotaVenta }}/" class="btn btn-sm btn-primary" style="width:90px">Desaprobar</a>
                @endif
                @if ($accion=='1')
                    <a href="{{ asset('/') }}listarNotasdeVenta" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
                @elseif ($accion=='2')
                    <a href="{{ asset('/') }}listarNotasdeVenta" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
                @endif

            </div>              
        </body>
    </div>
</div>

@endsection

@section('javascript')
    <!-- Datepicker -->
    <script src="{{ asset('/') }}js/bootstrap-datepicker.min.js"></script>  

    <!-- Timepicker -->
    <script src="{{ asset('/') }}js/bootstrap-timepicker.min.js"></script>  

    <script src="{{ asset('/') }}js/app/funciones.js"></script>
    <script src="{{ asset('/') }}js/app/nuevanotaventa.js"></script>
    
@endsection