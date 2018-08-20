@extends('plantilla')      

@section('contenedorprincipal')

<div style="padding: 5px">
    <div class="panel panel-default" id="contenedor3">
        <div class="panel-heading">
            <div class="panel-tab clearfix">
                <ul class="tab-bar">
                    <li class="active"><a href="#tabAprobados" data-toggle="tab"><b>Pedidos Aprobados</b></a></li>
                    <li><a href="#tabPendientes" data-toggle="tab"><b>Pedidos Pendientes de Aprobación</b></a></li>       
                </ul>
            </div>
        </div> 
        <div class="panel-body">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="idPerfil" value="{{ Session::get('idPerfil') }}">            
            <div class="tab-content clearfix">
                <div class="tab-pane active" id="tabAprobados" style="padding-top: 5px;">

                    <table id="tablaAprobados" class="table table-condensed" style="width:1600px">
                        <thead>
                            <th style="width:150px">Pedido</th>
                            <th style="width:50px">Estado</th>
                            <th style="width:150px">Cliente</th>
                            <th style="width:150px">Obra/Planta</th>

                            @if( Session::get('idPerfil')=='10' )
                                <th style="width:100px">Fecha Carga</th>
                                <th style="width:150px">Transporte</th>
                                <th style="width:50px">Planta Origen</th>
                                <th style="width:70px">Fecha Entrega</th>
                                <th style="width:100px">Producto</th>
                                <th style="width:50px">Cantidad</th>
                                <th style="width:50px">Unidad</th>
                            @else
                                <th style="width:100px">Producto</th>
                                <th style="width:50px">Cantidad</th>
                                <th style="width:50px">Unidad</th>
                                <th style="width:50px">Planta Origen</th>
                                <th style="width:70px">Fecha Entrega</th>
                                <th style="width:50px">Forma Entrega</th>
                                <th style="width:100px">Fecha Carga</th>
                                <th style="width:150px">Transporte</th>
                            @endif
                            <th style="width:100px">Fecha Creación</th>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $item)
                                @if (   ($item->idEstadoPedido!='1' and $item->idEstadoPedido!='6') and 
                                        ( ( Session::get('idPerfil')=='10' and $item->idFormaEntrega=='1') or Session::get('idPerfil')!='10' ) 
                                    )
                                    @if ( $item->idEstadoPedido=='0' )
                                        <tr style="background-color: #A93226; color: #FDFEFE">
                                    @else
                                        @if ( $item->modificado>0)
                                            <tr style="background-color: #F5CBA7">
                                        @else
                                            <tr>
                                        @endif
                                    @endif  
                                        <td style="width:150px">
                                            @if ( $item->idEstadoPedido=='0' )
                                                <a href="{{ asset('/') }}verpedido/{{ $item->idPedido }}/3/" class="btn btn-xs btn-success">{{ $item->idPedido }}</a>
                                            @else
                                                <a href="{{ asset('/') }}programarpedido/{{ $item->idPedido }}/3/" class="btn btn-xs btn-success">{{ $item->idPedido }}</a>
                                            @endif
                                            @if ( $item->cantidadReal>0 )
                                                <span><img src="{{ asset('/') }}img/iconos/cargacompleta.png" border="0"></span>
                                            @endif
                                            @if ( $item->numeroGuia>0 )
                                                <span><img src="{{ asset('/') }}img/iconos/guiaDespacho2.png" border="0" onclick="abrirModalGuia('{{ $item->numeroGuia }}');" style="cursor:pointer; cursor: hand"></span>
                                            @endif    
                                            @if ( $item->certificado==1 )  
                                                <span><img src="{{ asset('/') }}img/iconos/certificado.png" border="0"></span>
                                            @endif
                                            @if ( $item->salida==1 )
                                            <span><img src="{{ asset('/') }}img/iconos/enTransporte.png" border="0" onclick="verUbicacionGmaps('{{ $item->Patente }}');" style="cursor:pointer; cursor: hand"></span>                                      
                                            @endif    
                                        </td>                                        
                                        <td style="width:50px">{{ $item->estadoPedido }}</td>
                                        <td style="width:150px">{{ $item->nombreCliente }}</td>
                                        <td style="width:150px">
                                            {{ $item->nombreObra }}
                                        </td>

                                        @if( Session::get('idPerfil')=='10' )
                                            <td style="width:100px">{{ $item->fechaCarga }} {{ $item->horaCarga }} </td>
                                            <td style="width:150px">{{ $item->apellidoConductor }} / {{ $item->empresaTransporte }}</td>
                                            <td style="width:50px">{{ $item->plantaOrigen }}</td>
                                            <td style="width:70px">{{ $item->fechaEntrega }} {{ $item->horarioEntrega }}</td>
                                            <td style="width:100px">
                                                {{ $item->prod_nombre }}
                                                @if ($item->tipoTransporte==2)
                                                    <span class="badge badge-danger">M</span>
                                                @endif                                            
                                            </td>                                            
                                            <td style="width:50px">{{ $item->cantidad }}</td>
                                            <td style="width:50px">{{ $item->u_abre }}</td>
                                        @else
                                            <td style="width:100px">
                                                {{ $item->prod_nombre }}
                                                @if ($item->tipoTransporte==2)
                                                    <span class="badge badge-danger">M</span>
                                                @endif                                            
                                            </td>
                                            <td style="width:50px">{{ $item->cantidad }}</td>
                                            <td style="width:50px">{{ $item->u_abre }}</td>
                                            <td style="width:50px">{{ $item->plantaOrigen }}</td>
                                            
                                            <td style="width:70px">{{ $item->fechaEntrega }} {{ $item->horarioEntrega }}</td>
                                            <td style="width:50px">{{ $item->formaEntrega }}</td>
                                            <td style="width:100px">{{ $item->fechaCarga }} {{ $item->horaCarga }} </td>
                                            <td style="width:150px">{{ $item->apellidoConductor }} / {{ $item->empresaTransporte }}</td>
                                        @endif
                                        <td style="width:100px">{{ $item->fechahora_creacion }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>            
                    </table>
                </div>
                <div class="tab-pane" id="tabPendientes" style="padding-top: 5px">
                    <table id="tablaPendientes" class="pedidos table table-hover table-condensed">
                        <thead>
                            <th>Pedido</th>
                            <th>Estado</th>
                            <th>Fecha Creación</th>
                            <th>Cliente</th>
                            <th>Obra/Planta</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Planta Origen</th>
                            <th>Forma Entrega</th>
                            <th>Fecha Entrega</th>
                            <th>Horario</th>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $item)
                                @if( $item->idEstadoPedido == '1' )
                                    <tr>
                                        <td><a href="{{ asset('/') }}verpedido/{{ $item->idPedido }}/3/" class="btn btn-xs btn-success">{{ $item->idPedido }}</a></td>
                                        <td></td>
                                        <td>{{ $item->fechahora_creacion }}</td>
                                        <td>{{ $item->nombreCliente }}</td>
                                        <td>{{ $item->nombreObra }}</td>
                                        <td>{{ $item->prod_nombre }}</td>
                                        <td>{{ $item->cantidad }}</td>
                                        <td>{{ $item->plantaOrigen }}</td>
                                        <td>{{ $item->formaEntrega }}</td>
                                        <td>{{ $item->fechaEntrega }}</td>
                                        <td>{{ $item->horarioEntrega }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>              
                    </table>      
                </div>
            </div>
        </div>
    </div>
   
</div>


<div id="modUbicacion" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5><b>Datos de Ubicación</b></h5>
            </div>
            <div id="bodyProducto" class="modal-body">
                <input class="hidden" id="fila">
                <div class="row" style="padding-top: 5px">
                    <div class="col-md-2">
                        Patente 
                    </div>
                    <div class="col-md-2">
                        <input class="form-control input-sm" id="nombre" value="CFHK83" readonly>
                    </div>
                    <div class="col-md-2">
                        Fecha/Hora Reporte:
                    </div>
                    <div class="col-md-3">
                        <input class="form-control input-sm" value="2018-08-03T12:20:06-04:00" readonly>
                    </div>                
                </div>            
                <div class="row" style="padding-top: 5px">
                    <div class="col-md-2">
                        Localización
                    </div>
                    <div class="col-md-10">
                        <input class="form-control input-sm" id="descripcion" value="A 198 mts (SE) La Montana y 5.81 km Chicureo, Colina,Chacabuco,Chile." readonly>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-md-2">
                        Latitud
                    </div>
                    <div class="col-md-2">
                        <input class="form-control input-sm" value="-33.313198" readonly>
                    </div>
                    <div class="col-md-2">
                        Longitud
                    </div>
                    <div class="col-md-2">
                        <input class="form-control input-sm" value="-70.718941" readonly>
                    </div>
                    <div class="col-md-2">
                        Velocidad
                    </div>
                    <div class="col-md-2">
                        <input class="form-control input-sm" value="0.0" readonly>
                    </div>
                </div>
                   
            </div>
            <div id="map" style="height: 400px">
                 <img src="{{ asset('/') }}img/mapa.jpg" border="0" style="width:100%; height:100%">
            </div>
            <div class="col-md-offset-8" style="padding-top: 20px; padding-bottom: 20px">
               <button type="button" class="btn btn-danger data-dismiss=modal btn-sm" onclick="cerrarModal()" style="width: 80px">Salir</button>
            </div>        
        </div>
    </div>
</div>

<div id="modalGuia" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5><b>Datos de la Guia</b></h5>
            </div>
            <div id="bodyModal" class="modal-body">
                <div class="row">
                    <div class="col-sm-3">
                        Número
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="txtNumeroGuia" class="form-control input-sm" readonly>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-sm-3">
                        Sellos
                    </div>
                    <div class="col-sm-3">
                        <input type="text" id="txtSellos" class="form-control input-sm" readonly>
                    </div>
                    <div class="col-sm-3">
                        Temperatura
                    </div>
                    <div class="col-sm-3">
                        <input type="text" id="txtTemperatura" class="form-control input-sm" readonly>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-sm-3">
                        Observaciones
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="txtObservaciones" class="form-control input-sm" readonly>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-sm-3">
                        Fecha/Hora Salida
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="txtFechaHoraSalida" class="form-control input-sm" readonly>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-sm-3">
                        Retirado Por
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="txtRetira" class="form-control input-sm" readonly>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-sm-3">
                        Patente
                    </div>
                    <div class="col-sm-9">
                        <input type="text" id="txtPatente" class="form-control input-sm" readonly>
                    </div>
                </div>                                                         
            </div>        
            <div style="padding-left: 15px; padding-top: 5px">
                <h5><b> (*) Dato Obligatorio</b></h5>
            </div>
            <div class="col-md-offset-8" style="padding-top: 20px; padding-bottom: 20px">
               <button id="btnVerGuia" type="button" class="btn btn-warning btn-sm" style="width: 100px" disabled>Ver Guia Elec.</button>
               <button id="btnCerrar" type="button" class="btn btn-danger data-dismiss=modal btn-sm" onclick="cerrarModalGuia()" style="width: 80px">Salir</button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('javascript')

    
    
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.5/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('/') }}js/app/funciones.js"></script>

    <script>
        
        function abrirModal(patente){
            $("#modUbicacion").modal("show");
        }

        function cerrarModal(){
            $("#modUbicacion").modal("hide");
        }  

        function abrirModalGuia(numeroGuia){
            $("#txtNumeroGuia").val(numeroGuia);
            $.ajax({
                url: urlApp + "datosGuiaDespacho",
                headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
                type: 'POST',
                dataType: 'json',
                data: { tipoGuia: 1 ,
                        numeroGuia: numeroGuia
                      },
                success:function(dato){
                    $("#txtSellos").val(dato[0].sellos);
                    $("#txtTemperatura").val(dato[0].temperaturaCarga);
                    $("#txtObservaciones").val(dato[0].observaciones);
                    $("#txtFechaHoraSalida").val(dato[0].fechaHoraSalida);
                    $("#txtRetira").val(dato[0].retiradoPor);
                    $("#txtPatente").val(dato[0].patenteCamionDespacho);

                    $("#mdGuia").modal("show");      
                }
            }) 



            $("#modalGuia").modal("show");
        }

        function cerrarModalGuia(){
            $("#modalGuia").modal("hide");
        }         


        $(document).ready(function() {
            // Setup - add a text input to each footer cell

            // DataTable

            // Setup - add a text input to each footer cell
            $('#tablaAprobados thead tr').clone(true).appendTo( '#tablaAprobados thead' );
            $('#tablaAprobados thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();

                if(title.trim()!='' && title.trim()=='Obra/Planta' ){
                    $(this).html( '<select id="selObra" class="form-control input-sm"></select>' );
                }else if(title.trim()!='' && title.trim()=='Cliente' ){
                    $(this).html( '<select id="selCliente" class="form-control input-sm"></select>' );
                }else if(title.trim()!='' && title.trim()=='Estado' ){
                    $(this).html( '<select id="selEstado" class="form-control input-sm"></select>' );
                }else if(title.trim()!='' && title.trim()=='Forma Entrega' ){
                    $(this).html( '<select id="selFormaEntrega" class="form-control input-sm"></select>' );
                }else if(title.trim()!='' && title.trim()=='Planta Origen' ){
                    $(this).html( '<select id="selPlanta" class="form-control input-sm"></select>' );                    
                }else{
                    $(this).html( '<input type="text" class="form-control input-sm" placeholder="Buscar..." />' );
                    $( 'input', this ).on( 'keyup change', function () {
                        if ( table.column(i).search() !== this.value ) {
                            table
                                .column(i)
                                .search( this.value )
                                .draw();
                        }
                    } );                    
                }
             
            } );

                        
            var table=$('#tablaAprobados').DataTable({
                 orderCellsTop: true,
                 fixedHeader: true,         
                "lengthMenu": [[6, 12, 20, -1], ["6", "12", "20", "Todos"]],
                dom: 'Bfrtip',
                "scrollX": true,
                buttons: [
                    'pageLength',
                    {
                        extend: 'excelHtml5',
                        title: 'Notas de Venta Vigentes',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 ]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Notas de Venta Vigentes',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Notas de Venta Vigentes',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4 ]
                        }
                    }
                ],                  
                "order": [[ 0, "desc" ]],                        
                language:{url: "{{ asset('/') }}locales/datatables_ES.json"},
                initComplete: function () {
                    this.api().columns(3).every( function () {
                        var column = this;
                        var select = $("#selObra" ).empty().append( '<option value=""></option>' )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
         
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );
         
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );

                    this.api().columns(1).every( function () {
                        var column = this;
                        var select = $("#selEstado" ).empty().append( '<option value=""></option>' )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
         
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );
         
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );

                    this.api().columns(2).every( function () {
                        var column = this;
                        var select = $("#selCliente" ).empty().append( '<option value=""></option>' )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
         
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );
         
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );

                    if( $("#idPerfil").val()!='10' ){
                    
                        this.api().columns(9).every( function () {
                            var column = this;
                            var select = $("#selFormaEntrega" ).empty().append( '<option value=""></option>' )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
             
                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );
             
                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        } ); 
                     }   

                    if( $("#idPerfil").val()=='10' ){
                        columna=6;
                    }else{
                        columna=7;
                    }
                    this.api().columns(columna).every( function () {
                        var column = this;
                        var select = $("#selPlanta" ).empty().append( '<option value=""></option>' )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
         
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );
         
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );                                               

                }

            });         

        } );


    </script>

@endsection