@extends('plantilla')      

@section('contenedorprincipal')

<script>
    function aprobarPedido(idPedido, fila){
        $.ajax({
            url: urlApp + "aprobarPedido",
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { idPedido: idPedido
                  },
            success:function(dato){
                var tabla=document.getElementById('tablaDetalle');
                for(var x=0;x<tabla.rows.length;x++){
                    if(tabla.rows[x].cells[0].dataset.pedido==idPedido){
                        tabla.rows[x].cells[tabla.rows[x].cells.length-2].innerHTML="Aprobado";
                        tabla.rows[x].cells[tabla.rows[x].cells.length-1].getElementsByTagName('button')[0].style.visibility = 'hidden';                        
                    }
                }
            }
        })
    }
</script>


<div style="padding: 5px">
    <div class="panel panel-default">
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="idPerfil" value="{{ Session::get('idPerfil') }}">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-3">
                    <b>Pedidos en Proceso</b>
                </div>
                <div class="col-md-9" style="text-align: right;">
                    @if ($cantidadIngresoCliente>0)
                         <a href="{{ asset('/') }}listaIngresosClienteporAprobar" class="btn btn-danger btn-sm">EXISTEN {{ $cantidadIngresoCliente }} PEDIDOS INGRESADOS POR CLIENTE EN ESPERA DE APROBACION</a>
                    @endif
                </div>
            </div>       
        </div>
        <div class="panel-body">
            <div class="padding-md clearfix">
                <div style="padding-bottom: 15px">  
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{ asset('/') }}listarNotasdeVenta" class="btn btn-sm btn-primary">Nuevo Pedido</a>
                        </div>
                        <div class="col-md-2">
                            Filtrar por Fecha de Entrega
                        </div>
                        <div class="col-md-2">
                            <div class="input-group date" id="divFechaMin">
                                <input type="text" class="form-control input-sm" id="min">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group date" id="divFechaMax">
                                <input type="text" class="form-control input-sm" id="max">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 

                @if( Session::get('idPerfil')=='11' ) <!-- Ejecutivo de Crédito -->

                <table id="tablaDetalle" class="table table-hover table-condensed" style="width: 100%">
                    <thead>
                        <th style="width: 50px">Pedido Nº</th>
                        <th style="width: 100px">Fecha Creación</th>
                        <th style="width: 150px">Cliente</th>
                        <th style="width: 150px">Obra/Planta</th>
                        <th style="width: 100px"><b>Total c/IVA</b></th>
                        <th style="width: 100px">Fecha Entrega</th>
                        <th style="width: 70px">Estado</th>
                        <th style="width: 70px"></th>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $item)
                            <tr>
                                <td style="width: 50px" data-pedido='{{ $item->idPedido }}'>
                                    <a href="{{ asset('/') }}verpedido/{{ $item->idPedido }}/1/" class="btn btn-xs btn-success">{{ $item->idPedido }}</a>                                  
                                </td>
                                <td style="width: 100px">{{ $item->fechahora_creacion }}</td>
                                <td style="width: 150px">{{ $item->nombreCliente }}</td>
                                <td style="width: 150px">{{ $item->nombreObra }}</td>
                                <td style="width: 100px; text-align: right;"><b>$ {{ number_format( $item->totalNeto + $item->montoIva, 0, ',', '.' ) }}</b></td>
                                <td style="width: 100px">{{ $item->fechaEntrega }} {{ $item->horarioEntrega }}</td>
                                <td style="width: 70px">{{ $item->estado }}</td>
                                <td style="width: 70px">
                                    @if( Session::get('grupoUsuario')=='C' and $item->idEstadoPedido==1 )
                                        <button class="btn btn-sm btn-primary"x" onclick="aprobarPedido({{ $item->idPedido }}, this.parentNode.parentNode.rowIndex)"><span class="glyphicon glyphicon-ok"></span></button>
                                    @endif    
                                    <a href="{{ asset('/') }}verpedido/{{ $item->idPedido }}/1/" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-zoom-in"></span></a>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>            
                </table>   
            @else
                <table id="tablaDetalle" class="table table-hover table-condensed" style="width:1200px">
                    <thead>
                        <th style="width: 120px;text-align: center;">Pedido</th>
                        <th style="width: 50px">Estado</th>
                        <th style="width: 150px">Cliente</th>
                        <th style="width: 150px">Obra/Planta</th>
                        <th style="width: 100px">Producto</th>
                        <th style="width: 50px;text-align: right;">Cantidad</th>
                        <th style="width: 100px">Unidad</th>
                        <th style="width: 100px">Fecha Entrega</th>
                        <th style="width: 70px">Forma Entrega</th>
                        <th style="width: 70px">Planta Origen</th>
                        <th style="width: 100px">Fecha Carga</th>
                        <th style="width: 150px">Transporte</th>
                        <th style="width: 50px;text-align: right;">Fecha Creación</th>
                        <th style="width: 50px;text-align: right;"></th>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $item)
                            @if ( $item->idEstadoPedido=='0' )
                                <tr style="background-color: #A93226; color: #FDFEFE">
                            @else
                                @if ( $item->modificado>0)
                                    <tr style="background-color: #F5CBA7">
                                @else
                                    <tr>
                                @endif
                            @endif    
                                <td data-pedido='{{ $item->idPedido }}' style="width: 120px;">
                                    <a href="{{ asset('/') }}verpedido/{{ $item->idPedido }}/1/" class="btn btn-xs btn-success">{{ $item->idPedido }}</a>
                                    @if ( $item->cantidadReal>0 )
                                        <span><img src="{{ asset('/') }}img/iconos/cargacompleta.png" border="0"></span>
                                    @endif
                                    @if ( $item->numeroGuia>0 )
                                        <span><img src="{{ asset('/') }}img/iconos/guiaDespacho2.png" border="0"></span>
                                    @endif
                                    @if ( $item->certificado!='' )  
                                        <a href="{{ asset('/') }}bajarCertificado/{{ $item->certificado }}">
                                            <img src="{{ asset('/') }}img/iconos/certificado.png" border="0">
                                        </a>
                                    @endif
                                    @if ( $item->salida==1 )
                                    <span><img src="{{ asset('/') }}img/iconos/enTransporte.png" border="0" onclick="verUbicacionGmaps('{{ $item->Patente }}');" style="cursor:pointer; cursor: hand"></span>                                      
                                    @endif
                                </td>                                        
                                <td style="width: 50px">{{ $item->estadoPedido }}</td>
                                <td style="width: 150px">{{ $item->nombreCliente }}</td>
                                <td style="width: 150px">{{ $item->nombreObra }}</td>
                                <td style="width: 100px">
                                    {{ $item->prod_nombre }}
                                    @if ($item->tipoTransporte==2)
                                        <span class="badge badge-danger">M</span>
                                    @endif                                     
                                </td>
                                <td style="width: 50px;text-align: right;">{{ $item->cantidad }}</td>
                                <td style="width: 70px">{{ $item->u_abre }}</td>
                                <td style="width: 100px">{{ $item->fechaEntrega }} {{ $item->horarioEntrega }}</td>
                                <td style="width: 70px">{{ $item->formaEntrega }}</td>
                                <td style="width: 70px">{{ $item->plantaOrigen }}</td>
                                <td style="width: 100px">{{ $item->fechaCarga }} {{ $item->horaCarga }} </td>
                                <td style="width: 150px">{{ $item->apellidoConductor }} / {{ $item->empresaTransporte }}</td>
                                <td style="width: 50px;text-align: right;">{{ $item->fechahora_creacion }}</td>
                                <td style="width: 50px;text-align: right;">
                                    @if( Session::get('grupoUsuario')=='C' and (Session::get('idPerfil')=='2' or Session::get('idPerfil')=='11') and $item->idEstadoPedido==1 )
                                        <button class="btn btn-sm btn-primary"x" onclick="aprobarPedido({{ $item->idPedido }}, this.parentNode.parentNode.rowIndex)"><span class="glyphicon glyphicon-ok"></span></button>
                                    @endif    
                                </td>                                               
                            </tr>
                        @endforeach
                    </tbody>            
                </table>            

               @endif 
            </div>
        </div>
    </div>
    <div style="padding-top:18px; padding-bottom: 20px;padding-left: 20px">
        <a href="{{ asset('/') }}dashboard" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
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

    <script>

        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#tablaDetalle thead tr').clone(true).appendTo( '#tablaDetalle thead' );
            $('#tablaDetalle thead tr:eq(1) th').each( function (i) {
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
                }else if(title.trim()!='' ){
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


            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = fechaIngles( $('#min').val().trim() );
                    var max = fechaIngles( $('#max').val().trim() );

                    if ( document.getElementById('tablaDetalle').rows[1].cells.length==8 ){
                        var startDate=data[5].substr(0,10);
                    }else{
                        var startDate=data[7].substr(0,10);
                    }   

                    if (min == '' && max == '') { return true; }
                    if (min == '' && startDate <= max) { return true;}
                    if(max == '' && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );


            // DataTable
            var table=$('#tablaDetalle').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                lengthMenu: [[6, 12, 20, -1], ["6", "12", "20", "Todos"]],                
                dom: 'Bfrtip',
                "scrollX": true,
                buttons: [
                    'pageLength',  
                    {
                        extend: 'excelHtml5',
                        title: 'Pedidos en Proceso',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Pedidos en Proceso',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Pedidos en Proceso',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        }
                    }
                ],                
                "order": [[ 0, "desc" ]],             
                language:{url: "{{ asset('/') }}locales/datatables_ES.json"},
                initComplete: function () {
                    if( $("#idPerfil").val() == '11' ){
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
                        this.api().columns(6).every( function () {
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
                    }else{
                        this.api().columns(4).every( function () {
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

                        this.api().columns(3).every( function () {
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

                        this.api().columns(6).every( function () {
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

                        this.api().columns(7).every( function () {
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

                        this.api().columns(11).every( function () {
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
                    }
                                  

                }                  
            });

            $('.date').datepicker({
                todayHighlight: true,
                format: "dd/mm/yyyy",
                weekStart: 1,
                language: "es",
                autoclose: true
            }) 


            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });            

        } );

    </script>
    
@endsection
