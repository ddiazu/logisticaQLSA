@extends('plantilla')      

@section('contenedorprincipal')


<div style="padding: 5px">
    <div class="panel panel-default table-responsive">
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <div class="panel-heading">
            <b>Histórico de Pedidos</b>
        </div>
        <div class="padding-md clearfix">
            <div style="padding-bottom: 15px">  
                <div class="row">
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

            <table id="tablaDetalle" class="table table-hover table-condensed table-responsive">
                <thead>
                    <th>Pedido Nº</th>
                    <th>Fecha Creación</th>
                    <th>Cliente</th>
                    <th>Obra/Planta</th>
                    <th><b>Total c/IVA</b></th>
                    <th>Fecha Entrega</th>
                    <th>Estado</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($pedidos as $item)
                        <tr>
                            <td>{{ $item->idPedido }}</td>
                            <td>{{ $item->fechahora_creacion }}</td>
                            <td>{{ $item->nombreCliente }}</td>
                            <td>{{ $item->nombreObra }}</td>
                            <td align="right"><b>$ {{ number_format( $item->totalNeto + $item->montoIva, 0, ',', '.' ) }}</b></td>
                            <td>{{ $item->fechaEntrega }}</td>
                            <td>{{ $item->estado }}</td>
                            <td>
                                <a href="{{ asset('/') }}verpedido/{{ $item->idPedido }}/5/" class="btn btn-sm btn-success">Ver</a>
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

                if(title.trim()!='' && title.trim()!='Estado' ){
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
                    var min = $('#min').val().trim();
                    var max = $('#max').val().trim();

                    if(min!=''){min=fechaAtexto(min);}
                    if(max!=''){max=fechaAtexto(max);}

                    var startDate=fechaAtexto(data[5]);

                    if (min == '' && max == '') { return true; }
                    if (min == '' && startDate <= max) { return true;}
                    if(max == '' && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );



            // DataTable
            var table=$('#tablaDetalle').DataTable({
                autoWidth: false,
                orderCellsTop: true,
                fixedHeader: true,                
                dom: 'Bfrtip',
                buttons: [
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
                columnDefs: [
                    { width: 75, targets: 0 },
                    { width: 100, targets: 1 },
                    { width: 200, targets: 2 },
                    { width: 100, targets: 4 },
                    { width: 100, targets: 5 }
                ],                
                language:{url: "{{ asset('/') }}locales/datatables_ES.json"},
                initComplete: function () {
                    this.api().columns(6).every( function () {
                        var column = this;

                        var select = $('<select class="form-control input-sm" style="width:100px"><option value=""></option></select>')
                            .appendTo( $( '#tablaDetalle thead tr:eq(1) th:eq(6)' ).empty() )
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
