@extends('plantilla')      

@section('contenedorprincipal')

<div style="padding: 5px">
    <div class="panel panel-default">
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="idPerfil" value="{{ Session::get('idPerfil') }}">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-3">
                    <b>Registro de Salida</b>
                </div>
                <div class="col-md-3">
                    <button id="btnRefresh" class="btn btn-sm btn-success" onclick="reFresh();" style="display: none;">Actualizar</button>
                </div>
            </div>

        </div>
        <div class="panel-body">
            <div class="padding-md clearfix">
                <table id="tablaDetalle" class="table table-hover table-condensed" style="width: 100%">
                    <thead>
                        <th style="width: 80px">Nº Guía</th>
                        <th style="width: 70px">Tipo Guía</th>
                        <th style="width: 120px">Fecha Creación</th>
                        <th style="width: 70px">Nº Pedido</th>
                        <th style="width: 70px">Patente</th>
                        <th style="width: 150px">Nombre Conductor</th>
                        <th style="width: 150px">Empresa</th>
                    </thead>
                    <tbody>
                        @foreach($guias as $item)
                            <tr>
                                <td style="width:80px"><button class="btn btn-success btn-sm" style="width: 80px" onclick="registrarSalida({{ $item->tipoGuia }}, {{ $item->numeroGuia }}, this.parentNode.parentNode.rowIndex)">{{ $item->numeroGuia }}</button></td>
                                @if ($item->tipoGuia=='1')
                                    <td style="width: 70px">Electrónica</td>
                                @else
                                    <td style="width: 70px">Manual</td>
                                @endif    
                                <td style="width: 120px">{{ $item->fechaHoraCreacion }}</td>
                                <td style="width: 70px">{{ $item->idPedido }}</td>
                                <td style="width: 70px">{{ $item->patente }}</td>
                                <td style="width: 150px">{{ $item->nombreConductor }}</td>
                                <td style="width: 150px">{{ $item->empresa }}</td>                               
                            </tr>
                        @endforeach
                    </tbody>            
                </table>   

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
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.5/js/dataTables.fixedColumns.min.js"></script>

    <script>
        function reFresh(){ 
            location.reload(true)
            $("#btnRefresh").attr("disabled", true);
        }

        function registrarSalida(tipo, numero, fila){
            $.ajax({
                url: urlApp + "registrarSalidaDespacho",
                headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
                type: 'POST',
                dataType: 'json',
                data: { tipoGuia: tipo,
                        numeroGuia: numero
                      },
                success:function(dato){
                    document.getElementById('tablaDetalle').deleteRow(fila);
                }
            })            
        }        

        $(document).ready(function() {
            // Setup - add a text input to each footer cell

            $('#tablaDetalle thead tr').clone(true).appendTo( '#tablaDetalle thead' );
            $('#tablaDetalle thead tr:eq(1) th').each( function (i) {
                    var title = $(this).text();
                    if(title.trim()!=''){
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
            var table=$('#tablaDetalle').DataTable({
                 orderCellsTop: true,
                 fixedHeader: true,         
                "scrollX": true,
                "order": [[ 0, "desc" ]],
                "searching": false,
                "paging": false,             
                language:{url: "{{ asset('/') }}locales/datatables_ES.json"}                
            });

            document.getElementById('btnRefresh').style.display="block";

        } );

    </script>
    
@endsection
