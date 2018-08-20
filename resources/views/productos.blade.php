@extends('plantilla')      

@section('contenedorprincipal')

<div style="padding: 20px">
    <div class="panel panel-default table-responsive">
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <div class="panel-heading">
            <b>Productos</b>
            <span class="badge badge-info pull-right">{{ $listaProductos->count() }} Productos</span>
        </div>
        <div class="padding-md clearfix">           
            <table id="tabla" class="table table-hover table-condensed table-responsive"  style="width: 100%">
                <thead>
                    <th style="display: none">Codigo</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th style="text-align: center;">Visible</th>
                    <th style="text-align: right;">Precio Ref. ($)</th>
                    <th style="text-align: center;">Requiere Diseño</th>
                    <th>Cód.Softland</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($listaProductos as $item)
                        <tr>
                            <td style="display: none">{{ $item->prod_codigo }}</td>
                            <td>{{ $item->prod_nombre }}</td>
                            <td>{{ $item->prod_descripcion }}</td>
                            <td>{{ $item->prod_estado }}</td>
                            <td style="text-align: center;">
                                @if($item->prod_visible==1)
                                    SI
                                @else
                                    NO
                                @endif
                            </td>
                            <td style="text-align: right;">{{ number_format( $item->precio_referencia, 0, ',', '.' ) }}</td>
                            <td style="text-align: center;">
                                @if($item->requiere_diseno==1)
                                    SI
                                @else
                                    NO
                                @endif
                            </td>
                            <td>{{ $item->codigoSoftland }}</td>
                            <td>
                                <button class="btn btn-xs btn btn-warning" onclick="verDatosProducto( this.parentNode.parentNode.rowIndex );">Editar</button>
                            </td>                            
                        </tr>
                    @endforeach
                </tbody>              
            </table>      
        </div>
    </div>
    <div style="padding-top:18px; padding-bottom: 20px;padding-left: 20px">
        <a href="{{ asset('/') }}dashboard" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
    </div>    
</div>

<div id="modProducto" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h5><b>Datos Producto</b></h5>
        </div>
        <div id="bodyProducto" class="modal-body">
            <input class="hidden" id="fila">
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Nombre (*)
                </div>
                <div class="col-md-4">
                    <input class="form-control input-sm" id="nombre">
                </div>
            </div>            
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Descripción (*)
                </div>
                <div class="col-md-7">
                    <input class="form-control input-sm" id="descripcion">
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Precio Referencia (*)
                </div>
                <div class="col-md-7">
                    <input class="form-control input-sm" id="precioReferencia" onkeypress='return isNumberKey(event)'>
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Requiere Diseño
                </div>
                <div class="col-md-3">
                    <select class="form-control input-sm" id="requiereDiseno">
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                    </select>
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Código Softland
                </div>
                <div class="col-md-2">
                    <input class="form-control input-sm" id="codigoSoftland" maxlength="10">
                </div>
            </div>        
        </div>
        <div class="col-md-offset-8" style="padding-top: 20px; padding-bottom: 20px">
           <button type="button" class="btn btn-success btn-sm" onclick="guardarDatosProducto();" style="width: 80px">Guardar</button>
           <button type="button" class="btn btn-danger data-dismiss=modal btn-sm" onclick="cerrarModProducto()" style="width: 80px">Salir</button>
        </div>        
    </div>
</div>


@endsection

@section('javascript')
    <!-- Datepicker -->
    <script src="{{ asset('/') }}js/bootstrap-datepicker.min.js"></script>  

    <!-- Timepicker -->
    <script src="{{ asset('/') }}js/bootstrap-timepicker.min.js"></script>  

    <script src="{{ asset('/') }}js/app/funciones.js"></script>
    <script>

        function verDatosProducto(fila){
            var tabla=document.getElementById('tabla');
            $("#fila").val(fila);
            $("#nombre").val( tabla.rows[fila].cells[1].innerHTML.trim() );
            $("#descripcion").val( tabla.rows[fila].cells[2].innerHTML.trim() );
            $("#precioReferencia").val( tabla.rows[fila].cells[5].innerHTML.trim().replace('.','') );
            $("#codigoSoftland").val( tabla.rows[fila].cells[7].innerHTML.trim() );

            if( tabla.rows[fila].cells[6].innerHTML.trim()=='NO' ){
                document.getElementById('requiereDiseno').selectedIndex=1;
            }else{
                document.getElementById('requiereDiseno').selectedIndex=0;
            }
            $("#modProducto").modal("show");
        }

        function cerrarModProducto(){
           $("#modProducto").modal("hide"); 
        }

        function guardarDatosProducto(){
            var tabla=document.getElementById('tabla');
            var fila=$("#fila").val();

            $.ajax({
                url: urlApp + "guardarDatosProducto",
                headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
                type: 'POST',
                dataType: 'json',
                data: { 
                        prod_codigo: tabla.rows[fila].cells[0].innerHTML.trim(),
                        nombre: $("#nombre").val(),
                        descripcion: $("#descripcion").val(),
                        precioReferencia: $("#precioReferencia").val(),
                        requiereDiseno: $("#requiereDiseno").val(),
                        codigoSoftland: $("#codigoSoftland").val()
                      },
                success:function(dato){
                    tabla.rows[fila].cells[1].innerHTML=$("#nombre").val();
                    tabla.rows[fila].cells[2].innerHTML=$("#descripcion").val();
                    tabla.rows[fila].cells[5].innerHTML=$("#precioReferencia").val();
                    tabla.rows[fila].cells[6].innerHTML=$("#requiereDiseno option:selected").html();
                    tabla.rows[fila].cells[7].innerHTML=$("#codigoSoftland").val();

                    cerrarModProducto();

                }

            })

        }

        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#tabla thead tr').clone(true).appendTo( '#tabla thead' );
            $('#tabla thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();

                if(title.trim()!='' ){
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


            // DataTable
            var table=$('#tabla').DataTable({
                orderCellsTop: true,
                fixedHeader: true,  
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Listado de Clientes',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Listado de Clientes',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Listado de Clientes',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    }
                ],                  
                language:{url: "{{ asset('/') }}locales/datatables_ES.json"}
            });

        } );

    </script>
    
@endsection
