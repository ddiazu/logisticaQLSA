@extends('plantilla')      

@section('contenedorprincipal')

<div style="padding: 10px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Nueva Nota de Venta</b>
        </div>
        <div class="padding-md clearfix"> 
                <input type="hidden" id="idCliente">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-lg-1 col-sm-2">
                        Cotización (*)
                    </div>
                    <div class="col-lg-1 col-sm-2">
                        <input class="form-control input-sm" id="txtNumeroCotizacion" style="width:80px" maxlength="9" onkeypress="return isNumberKey(event)">
                    </div>
                    <div class="col-lg-1 col-sm-1">
                        Año (*)
                    </div>
                    <div class="col-lg-1 col-sm-2">
                        <input class="form-control input-sm" id="txtAno" maxlength="4" onkeypress="return isNumberKey(event)">
                    </div>            
                    <div class="col-lg-1 col-sm-2">
                        <button id="btnDatosCotizacion" class="btn btn-sm btn-success" onclick="datosCotizacion();">Traer</button>
                    </div> 
                    <div class="col-lg-1 col-sm-1">
                        Fecha
                    </div>
                    <div class="col-lg-2 col-sm-2">
                        <input class="form-control input-sm" id="txtFechaCotizacion" readonly value="">
                    </div>
                </div>

                <div class="row" style="padding-top: 10px">
                    <div class="col-lg-1 col-sm-2" >
                        Cliente
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <input class="form-control input-sm" id="txtNombreCliente" readonly>
                    </div>
                    <div class="col-lg-2 col-sm-3 col-xs-1" >
                        Orden de Compra Nº
                    </div>
                    <div class="col-lg-3 col-sm-3">
                        <input class="form-control input-sm" id="txtOrdenCompra" maxlength="20">
                    </div>                    
                </div>
                <div class="row" style="padding-top: 10px">
                    <div class="col-lg-1 col-sm-2">
                        Creada por
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <input class="form-control input-sm" id="txtUsuarioCrea" readonly>
                    </div>
                    <div class="col-lg-2 col-sm-2" >
                        Validada por
                    </div>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <input class="form-control input-sm" id="txtUsuarioValida" readonly>
                    </div> 
                </div>
                <div class="row" style="padding-top: 10px">
                    <div class="col-sm-2 col-lg-1">
                        Obra/Planta
                    </div>
                    <div class="col-lg-8 col-sm-8">                
                        <textarea id="txtObra" class="form-control input-sm" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div style="padding: 20px">
                <table id="tablaDetalle" class="table table-hover table-condensed table-responsive">
                    <thead>
                        <th width="5%">Codigo</th>
                        <th width="10%">Nº de Diseño</th>
                        <th width="15%">Producto</th>
                        <th width="5%">Cantidad</th>
                        <th width="5%">Unidad</th>
                        <th width="7%" style="text-align: right;">Precio Base ($)</th>
                        <th width="17%">Glosa de Reajuste</th>
                        <th width="15%">Planta de Origen</th>
                        <th width="20%">Forma de Entrega</th>                        
                    </thead>
                </table>
                <tbody></tbody>
            </div> 
            <div style="padding: 20px">
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-3 col-sm-4">
                        Nombre corto de Obra/Planta
                        <select id="idObra" class="form-control input-sm" onchange="datosObra();"></select>
                    </div>
                    <div class="col-lg-1 col-sm-1" style="padding-top:18px">
                        <button class="btn btn-warning btn-sm" onclick="nuevaObra();">Nueva</button>
                    </div>
                    <div class="col-lg-2 col-sm-3">
                        Contacto
                        <input id="txtNombreContacto" class="form-control input-sm" maxlength="50">
                    </div> 
                    <div class="col-lg-2 col-sm-3">
                        Email
                        <input id="txtCorreoContacto" class="form-control input-sm" maxlength="50">
                    </div>
                    <div class="col-lg-2 col-sm-3">
                        Telefono/Móvil
                        <input id="txtTelefono" class="form-control input-sm" maxlength="30">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        Observaciones
                        <input id="txtObservaciones" class="form-control input-sm" maxlength="100">
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        Ejecutivo QL
                        <select id="idUsuarioEncargado" class="form-control input-sm">
                            @foreach($usuarios as $item)

                               <option value="{{ $item->usu_codigo }}">{{ $item->usu_apellido }} {{ $item->usu_nombre }}</option>

                            @endforeach                             
                        </select>
                    </div>                    
                </div>
             
            </div>
            <div style="padding-top:18px; padding-bottom: 20px;padding-left: 20px">
                <button class="btn btn-success btn-sm" onclick="crearNotaVenta();">Crear Nota de Venta</button>
                <a href="{{ asset('/') }}listarNotasdeVenta" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
            </div>              
        </body>

        @include('formularioObra')

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
    <script src="{{ asset('/') }}js/app/formularioObra.js"></script>
    <!-- Datatable -->
    <script src="{{ asset('/') }}js/jquery.dataTables.min.js"></script>
    
@endsection