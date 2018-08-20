@extends('plantilla')      

@section('contenedorprincipal')


<div style="padding: 5px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-2">
                    <h5><b>Pedido Nº {{ $pedido[0]->idPedido }}</b></h5>
                </div>
            </div>             
        </div>
        <div class="padding-md clearfix">
        	<div>
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="idPedido" name="_token" value="{{ $pedido[0]->idPedido }}">
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
                    <div class="col-lg-1 col-md-2 col-sm-3">
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
        				<input class="form-control input-sm" readonly value="{{ $pedido[0]->estado }}">
        			</div>
                    <div class="col-lg-1 col-md-2 col-sm-2">
                        Observaciones
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-6">
                        <input class="form-control input-sm" readonly value="{{ $pedido[0]->observaciones }}">
                    </div>                          			     			
        		</div>
                                  		  		
        	</div>
            <div style="text-align: right;">
                    @if ($pedido[0]->noExcederCantidadSolicitada==1)
                            <h4><span class="label label-danger">NO EXCEDER LA CANTIDAD SOLICITADA</span></h4>
                    @endif
            </div>
        </div>

        <div style="padding-top: 0px; padding-left: 20px; padding-bottom: 5px; padding-right: 10px">
            <table id="tablaDetalle" class="table table-hover table-condensed" style="width: 100%">
                <thead>
                    <th style="display: none">Codigo</th>
                    <th style="width:70px">Producto</th>
                    <th style="width:30px">Cantidad<br>Solicitada</th>
                    <th style="width:40px">Unidad</th>
                    <th style="width:70px">Planta de Origen</th>
                    <th style="width:70px">Entrega</th>
                    <th style="width:70px">Transporte</th>
                    <th style="width:70px">Camion</th>
                    <th style="width:70px">Conductor</th>
                    <th style="width:70px">Fecha Carga</th>
                    <th style="width:70px">Hora Carga</th>
            
                    @if( Session::get('idPerfil')=='5' or Session::get('idPerfil')=='7' or Session::get('idPerfil')=='8')
                        <th style="width:50px">Cantidad<br>Real</th>
                    @else
                        <th style="display: none">Cantidad<br>Real</th>
                    @endif
                    <th style="width:110px">Select./<br>Guia</th> 

                </thead>
            
                <tbody>
                    <?php $productosSinGuia = 0; ?>
                    @foreach($listaDetallePedido as $item)
                    <tr>
                        <td style="display: none">
                            {{ $item->prod_codigo }}
                        </td>
                        <td style="width:70px" data-guia="{{ $item->numeroGuia }}">
                            {{ $item->prod_nombre }}
                            @if( $item->numeroGuia>0 )
                                <button class="btn btn-success btn-xs" style="width: 50px" onclick='abrirGuia({{ $item->tipoGuia }}, {{ $item->numeroGuia }}, this.parentNode.parentNode.rowIndex);'>{{ $item->numeroGuia }}</button>
                            @endif    
                            @if ( $item->cantidadReal > 0 )
                                <span><img src="{{ asset('/') }}img/iconos/cargacompleta.png" border="0"></span>
                            @endif
                            @if ( $item->certificado==1 )  
                                <span><img src="{{ asset('/') }}img/iconos/certificado.png" border="0"></span>
                            @endif
                            @if ( $item->salida==1 )
                            <span><img src="{{ asset('/') }}img/iconos/enTransporte.png" border="0" onclick="verUbicacionGmaps('{{ $item->Patente }}');" style="cursor:pointer; cursor: hand"></span>                                      
                            @endif                              
                        </td>
                        <td style="width:30px"> {{ $item->cantidad }} </td>
                        <td style="width:40px"> {{ $item->u_nombre }} </td>
                        <td style="width:70px"> {{ $item->nombrePlanta }} </td>
                        <td style="width:70px"> {{ $item->nombreFormaEntrega }} </td>

                        @if (  $item->numeroGuia==0 )
                            <?php $productosSinGuia+=1; ?>
                            <td style="width:70px">
                                @if ( $item->nombreFormaEntrega !='Retira' ) 
                                    <select id="idEmpresaTransporte" class="form-control input-sm" onchange="cargarListas(this.value, this.parentNode.parentNode.rowIndex);" @if (Session::get('idPerfil')=='7' or Session::get('idPerfil')=='8') disabled @endif >
                                      <option value="0"></option>  
                                      @foreach($emptransporte as $empresa)
                                        @if( $empresa->idEmpresaTransporte == $item->idEmpresaTransporte) then
                                            <option value="{{ $empresa->idEmpresaTransporte }}" selected>{{ $empresa->nombre }}</option>
                                        @else
                                            <option value="{{ $empresa->idEmpresaTransporte }}">{{ $empresa->nombre }}</option>
                                        @endif    
                                      @endforeach   
                                    </select>
                                @endif                              
                            </td>
                            <td style="width:70px">
                                @if ( $item->nombreFormaEntrega !='Retira' ) 
                                    <select id="idCamion" class="form-control input-sm" @if (Session::get('idPerfil')=='7' or Session::get('idPerfil')=='8') disabled @endif >
                                        <option value="{{ $item->idCamion }}" selected>{{ $item->patente }}</option>
                                    </select>
                                @endif                                 
                            </td>

                            <td style="width:70px">
                                @if ( $item->nombreFormaEntrega !='Retira' ) 
                                    <select id="idConductor" class="form-control input-sm" @if (Session::get('idPerfil')=='7' or Session::get('idPerfil')=='8') disabled @endif>
                                        <option value="{{ $item->idConductor }}" selected>{{ $item->nombreConductor }}</option>
                                    </select>
                                @endif                               
                            </td>

                            @if( Session::get('idPerfil')=='5' or Session::get('idPerfil')=='6'  )

                                <td style="width:70px">
                                    @if ( $item->nombreFormaEntrega !='Retira' ) 
                                        <input type="text" class="form-control input-sm date" id="fechaEntrega" value="{{ $item->fechaCarga }}">
                                    @endif   
                                </td>
                                <td style="width:70px">
                                    @if ( $item->nombreFormaEntrega !='Retira' ) 
                                        <input id="horaEntrega" type="text" class="form-control input-sm bootstrap-timepicker" value="{{ $item->horaCarga }}">
                                    @endif
                                </td>
                            @elseif ( Session::get('idPerfil')=='7' or Session::get('idPerfil')=='8' or Session::get('idPerfil')=='10'  )
                                <td style="width:70px">
                                    @if ( $item->nombreFormaEntrega !='Retira' ) 
                                        <input type="text" class="form-control input-sm" id="fechaEntrega" value="{{ $item->fechaCarga }}" readonly>
                                    @endif   
                                </td>
                                <td style="width:70px">
                                    @if ( $item->nombreFormaEntrega !='Retira' ) 
                                        <input id="horaEntrega" type="text" class="form-control input-sm" value="{{ $item->horaCarga }}" readonly>
                                    @endif
                                </td>                            
                            @else
                                <td style="display: none;">
                                    @if ( $item->nombreFormaEntrega !='Retira' ) 
                                        <input type="text" class="form-control input-sm date" id="fechaEntrega" value="{{ $item->fechaCarga }}">
                                    @endif   
                                </td>
                                <td style="display: none;">
                                    @if ( $item->nombreFormaEntrega !='Retira' ) 
                                        <input id="horaEntrega" type="text" class="form-control input-sm bootstrap-timepicker" value="{{ $item->horaCarga }}">
                                    @endif
                                </td>                        
                            @endif    


                            @if( Session::get('idPerfil')=='5' or Session::get('idPerfil')=='7' )
                                 <td style="width:50px">
                                    <input id="peso" type="text" class="form-control input-sm" value="{{ $item->cantidadReal }}" onkeypress="return isNumberKey(event)">
                                </td>                          
                            @elseif( Session::get('idPerfil')=='8')
                                 <td style="width:50px">
                                    <input id="peso" type="text" class="form-control input-sm" value="{{ $item->cantidadReal }}" readonly>
                                </td>
                            @else
                                <td style="display: none">
                                    <input id="peso" type="text" class="form-control input-sm" value="{{ $item->cantidadReal }}">
                                </td>                     
                            @endif
                            <td>
                                @if( $item->numeroGuia==0 )
                                    @if(Session::get('idPerfil')=='5' or Session::get('idPerfil')=='7')
                                        <label class="label-checkbox" style="display: inline;"><input type="checkbox"><span class="custom-checkbox"></span></label>
                                    @else
                                        <label class="label-checkbox" style="display: none;"><input type="checkbox"><span class="custom-checkbox"></span></label>    
                                    @endif
                                @endif                                
                            </td>

                        @else    

                            <td style="width:70px">{{ $item->nombreEmpresaTransporte }}</td>
                            <td style="width:70px">{{ $item->patente }}</td>
                            <td style="width:70px">{{ $item->nombreConductor }}</td>
                             @if( Session::get('idPerfil')=='5' or Session::get('idPerfil')=='6'  )
                                <td style="width:70px">{{ $item->fechaCarga }}</td>
                                <td style="width:70px">{{ $item->horaCarga }}</td>
                            @elseif ( Session::get('idPerfil')=='7' or Session::get('idPerfil')=='8' or Session::get('idPerfil')=='10'  )
                                <td style="width:70px">{{ $item->fechaCarga }}</td>
                                <td style="width:70px">{{ $item->horaCarga }}</td>                           
                            @else
                                <td style="display: none;">{{ $item->fechaCarga }}</td>
                                <td style="display: none;">{{ $item->horaCarga }}</td>                     
                            @endif    
                            @if( Session::get('idPerfil')=='5' or Session::get('idPerfil')=='7' )
                                 <td style="width:50px">{{ $item->cantidadReal }}</td>                       
                            @elseif( Session::get('idPerfil')=='8')
                                 <td style="width:50px">{{ $item->cantidadReal }}</td>
                            @else
                                <td style="display: none">{{ $item->cantidadReal }}</td>                 
                            @endif 
                            <td></td>
                        @endif    

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> 

        <div style="padding-top:10px; padding-bottom: 20px;padding-left: 20px">
            @if( Session::get('idPerfil')!='8' and $productosSinGuia>0 )
            <button class="btn btn-sm btn-primary" style="width:80px" onclick="guardarDatosProgramacion( {{ $pedido[0]->idPedido }} , 1);">Guardar</button>
            @endif
            <a href="{{ asset('/') }}programacion" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
            @if( (Session::get('idPerfil')=='5' or Session::get('idPerfil')=='7') and $productosSinGuia>0 )
            <button class="btn btn-sm btn-success" onclick="asignarFolio();">Asignar Guía a elementos seleccionados</button>
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



<div id="mdGuia" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h5><b>Datos de la Guía</b></h5>
        </div>
        <div id="bodyGuia" class="modal-body">
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Tipo Guía
                </div>
                <div class="col-md-6">
                    <input class="form-control input-sm" id="tipoGuia" readonly="">
                </div>
            </div>            
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Número Guía
                </div>
                <div class="col-md-6">
                    <input class="form-control input-sm" id="numeroGuia" readonly="">
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Estado Guía
                </div>
                <div class="col-md-6">
                    <input class="form-control input-sm" id="estadoGuia" value="Folio Asignado / Guía sin Emitir" readonly>
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Patente
                </div>
                <div class="col-md-6">
                    <input class="form-control input-sm" id="guiaPatente" maxlength="50">
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Nombre de quién Retira
                </div>
                <div class="col-md-6">
                    <input class="form-control input-sm" id="guiaNombreConductor" maxlength="50">
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Sellos
                </div>
                <div class="col-md-6">
                    <input class="form-control input-sm" id="sellos" maxlength="50">
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Temperatura Carga
                </div>
                <div class="col-md-6">
                    <input class="form-control input-sm" id="temperatura" maxlength="50">
                </div>
            </div>
            <div class="row" style="padding-top: 5px">   
                <div class="col-md-3">
                    Observaciones
                </div>
                <div class="col-md-9">
                    <textarea class="form-control input-sm" id="observacionDespacho" maxlength="255" rows="3"></textarea> 
                </div>
            </div>

        </div>
        <div class="col-md-offset-8" style="padding-top: 20px; padding-bottom: 20px">
           <button id="btnGuardarDatosGuia" type="button" class="btn btn-success btn-sm" onclick="generarArchivoGuiaDespacho( )">Emitir Guía</button>
           <button id="btnCerrarCajaGuia" type="button" class="btn btn-danger data-dismiss=modal btn-sm" onclick="cerrarCajaGuia()" style="width: 80px">Salir</button>
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
    <script src="{{ asset('/') }}js/app/programacionPedido.js"></script>
    <script>
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            // DataTable
         //   var table=$('#tablaDetalle').DataTable({            
         //       language:{url: "{{ asset('/') }}locales/datatables_ES.json"}
         //   });
            
            $('.date').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1,
                language: "es",
                autoclose: true,
                startDate: '+0d'
            })

            $('.bootstrap-timepicker').timepicker({
                showMeridian: false,
                defaultTime: false
            });        

            var table=$('#tablaDetalle').DataTable({         
                language:{url: "{{ asset('/') }}locales/datatables_ES.json"},
                "scrollX": true,
                "paging":   false,
                "searching": false
            });


            $.ajax({
                async: true,
                url: urlApp + "listaCamiones",
                headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
                type: 'POST',
                dataType: 'json',
                data: {},
                success:function(dato){
                    for(var x=0;x<dato.length;x++){
                        var camion = new Array(dato[x].idEmpresaTransporte, dato[x].idCamion, dato[x].patente);
                        arrCamiones.push(camion);
                    }

                    var tabla=document.getElementById('tablaDetalle');

                    for (var i = 1; i < tabla.rows.length; i++){
                        if(tabla.rows[i].cells[1].dataset.guia=='0'){

                            if(tabla.rows[i].cells[5].innerHTML.trim()!='Retira'  && !tabla.rows[i].cells[12].getElementsByTagName('button')[0] ){
                                idEmpresa=tabla.rows[i].cells[6].getElementsByTagName('select')[0].value;
                                selCamion=tabla.rows[i].cells[7].getElementsByTagName('select')[0];
                                idCamion=0;
                                if(selCamion.selectedIndex>=0){
                                    idCamion=selCamion.value;
                                }                        
                                selCamion.length=0; 
                                var opt = document.createElement('option');
                                opt.value = "0";
                                opt.innerHTML = "";
                                selCamion.appendChild(opt);

                                for(var x=0;x<arrCamiones.length;x++){
                                    if(arrCamiones[x][0]==idEmpresa){
                                        var opt = document.createElement('option');
                                        opt.value = arrCamiones[x][1];
                                        opt.innerHTML = arrCamiones[x][2];
                                        if(idCamion==arrCamiones[x][1]){
                                            opt.selected=true;
                                        }else{
                                            opt.selected=false;
                                        }                                
                                        selCamion.appendChild(opt);
                                    }
                                }                
                            }
                        }    
                    }

                }
            })

            $.ajax({
                async: true,
                url: urlApp + "listaConductores",
                headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
                type: 'POST',
                dataType: 'json',
                data: {},
                success:function(dato){
                    for(var x=0;x<dato.length;x++){
                        var conductor = new Array(dato[x].idEmpresaTransporte, dato[x].idConductor, dato[x].nombre, dato[x].apellidoPaterno, dato[x].apellidoMaterno);
                        arrConductores.push(conductor);
                    }

                    var tabla=document.getElementById('tablaDetalle');

                    for (var i = 1; i < tabla.rows.length; i++){
                        if(tabla.rows[i].cells[1].dataset.guia=='0'){
                            if(tabla.rows[i].cells[5].innerHTML.trim()!='Retira' && !tabla.rows[i].cells[12].getElementsByTagName('button')[0] ){
                                idEmpresa=tabla.rows[i].cells[6].getElementsByTagName('select')[0].value;
                                selConductor=tabla.rows[i].cells[8].getElementsByTagName('select')[0];
                                idConductor=0;
                                if(selConductor.selectedIndex>=0){
                                    idConductor=selConductor.value;
                                }
                                selConductor.length=0; 
                                var opt = document.createElement('option');
                                opt.value = "0";
                                opt.innerHTML = "";
                                selConductor.appendChild(opt);

                                for(var x=0;x<arrConductores.length;x++){
                                    if(arrConductores[x][0]==idEmpresa){
                                        var opt = document.createElement('option');
                                        opt.value = arrConductores[x][1];
                                        opt.innerHTML = arrConductores[x][2]+' '+arrConductores[x][3]+' ' +arrConductores[x][4];
                                        if(idConductor==arrConductores[x][1]){
                                            opt.selected=true;
                                        }else{
                                            opt.selected=false;
                                        }
                                        selConductor.appendChild(opt);
                                    }
                                }
                            }               
                        }
                    }                    
                }
            })


        });


    </script>
       
@endsection