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
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->idNotaVenta }}">
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
                        <div class="input-group date" id="divFechaEntrega">
                            <input type="text" class="form-control input-sm" id="txtFechaEntrega" value="{{ $pedido[0]->fechaEntrega }}">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>                         
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-1">
                        <select id="horario" class="form-control input-sm">
                            @if ( $pedido[0]->horarioEntrega=='PM')
                                <option >AM</option>
                                <option selected>PM</option>
                            @else
                                <option selected>AM</option>
                                <option>PM</option>                           
                            @endif    
                        </select> 
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
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->estado }}">
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-2">
                        Observaciones
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-6">
                        <input id="txtObservaciones" class="form-control input-sm" value="{{ $pedido[0]->observaciones }}">
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
                        <td style="width: 60px">
                            <input class="form-control input-sm" value="{{ $item->cantidad }}">
                        </td>   
                        <td> {{ $item->u_nombre }} </td>
                        @if( Session::get('grupoUsuario')=='C' )   
                            <td align="right">{{ number_format( $item->cp_precio, 0, ',', '.' ) }}</td>
                            <td align="right">{{ number_format( $item->cp_precio * $item->cantidad , 0, ',', '.' ) }}</td>
                        @endif


                        <td> 
                            <select id="listaPlantas" class="form-control input-sm">
                                @foreach($plantas as $planta)
                                    @if($planta->nombre==$item->nombrePlanta )
                                        <option value="{{ $planta->idPlanta }}" selected> {{ $planta->nombre }} </option>
                                    @else
                                        <option value="{{ $planta->idPlanta }}"> {{ $planta->nombre }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control input-sm">
                                @foreach($formasdeentrega as $forma)
                                    @if($forma->nombre==$item->nombreFormaEntrega )
                                        <option value="{{ $forma->idFormaEntrega }}" selected> {{ $forma->nombre }} </option>
                                    @else
                                        <option value="{{ $forma->idFormaEntrega }}"> {{ $forma->nombre }} </option>
                                    @endif                            
                                @endforeach
                            </select>
                        </td>

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
            Indique el motivo de la modificación de este pedido (máx.150 letras):
            <input id="motivo" class="form-control input-sm" maxlength="150" style="width: 80%">
            <div style="padding-top:18px; padding-bottom: 20px">
                <button class="btn btn-sm btn-success" style="width:80px" onclick="guardarCambios();">Guardar</button>         
                <a href="{{ asset('/') }}listarPedidos" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>                                                  
            </div>
        </div>        

        <div style="width: 850px;padding-left: 20px">
            <b>Registro de acciones sobre este Pedido</b>
            <table id="tablaLog" class="table table-hover table-condensed table-responsive">
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

        function guardarCambios(){

            if($("#motivo").val().trim()=='' ){
                swal(
                    {
                        title: 'Debe indicar el motivo por el cual modificó este pedido!!' ,
                        text: '',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        cancelButtonText: '',
                        closeOnConfirm: true,
                        closeOnCancel: false
                    }
                )
                return;             
            }


            var tabla=document.getElementById('tablaDetalle');

            if($("#txtFechaEntrega").val().trim()=='' ){
                swal(
                    {
                        title: 'Debe ingresar la Fecha de Entrega (*).',
                        text: '',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'Cerrar',
                        cancelButtonText: '',
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                    function(isConfirm)
                    {
                        if(isConfirm){
                            return;
                            
                        }
                    }
                )  
                return
            }
            var cont=0;
            var total=0;
            var toneladas=0;
            var productos=0;

            for(var x=1; x<(tabla.rows.length-3); x++){
                if(tabla.rows[x].cells[2].getElementsByTagName('input')[0].value.trim()=="" ){
                    cont++
                }
            }

            if(cont>0){
                swal(
                    {
                        title: 'No es permitido dejar una cantidad vacía.' ,
                        text: '',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        cancelButtonText: '',
                        closeOnConfirm: true,
                        closeOnCancel: false
                    }
                )
                return;             
            }

            var cont=0;
            var cadena='[';

            for (var i = 1; i <(tabla.rows.length-3); i++){
                if(tabla.rows[i].cells[2].getElementsByTagName('input')[0].value!=""){
                    cadena+='{';
                    cadena+='"prod_codigo":"'+  tabla.rows[i].cells[0].innerHTML  + '", ';
                    cadena+='"cantidad":"'+  tabla.rows[i].cells[2].getElementsByTagName('input')[0].value + '", ';
                    cadena+='"idPlanta":"'+  tabla.rows[i].cells[6].getElementsByTagName('select')[0].value  + '",';
                    cadena+='"idFormaEntrega":"'+  tabla.rows[i].cells[7].getElementsByTagName('select')[0].value  + '"';                    
                    cadena+='}, ';   
                    total+= ( parseInt(tabla.rows[i].cells[4].innerHTML.replace('.','')) * parseInt( tabla.rows[i].cells[2].getElementsByTagName('input')[0].value ) );             
                }
            }

            cadena=cadena.slice(0,-2);
            cadena+=']';

            var ruta= urlApp + "actualizarPedido";
            $.ajax({
                url: ruta,
                headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
                type: 'POST',
                dataType: 'json',
                data: { 
                        idPedido: $("#idPedido").val(),
                        fechaEntrega: fechaAtexto( $("#txtFechaEntrega").val() ),
                        observaciones: $("#txtObservaciones").val(),
                        horarioEntrega: $("#horario option:selected").html() ,
                        totalNeto: total,
                        detalle: cadena,
                        motivo: $("#motivo").val()
                      },
                success:function(dato){
                        swal(
                            {
                                title: 'Se han guardado los cambios realizados al pedido!!',
                                text: '',
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                cancelButtonText: '',
                                closeOnConfirm: true,
                                closeOnCancel: false
                            },
                            function(isConfirm)
                            {
                                if(isConfirm){
                                    return;
                                }
                            }
                        )
                        
                        location.href=urlApp + "listarPedidos";                  
                }
            })


        }

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