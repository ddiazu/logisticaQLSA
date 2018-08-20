@extends('plantilla')      

@section('contenedorprincipal')

<div style="padding: 20px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Empresas de Transporte</b>
            <span class="badge badge-info pull-right">{{ $listaEmpresas->count() }} Clientes</span>
        </div>
        <div class="padding-md clearfix">
            <div style="padding-bottom: 15px">  
                <a href="{{ asset('/') }}datosEmpresaTransporte/0/" class="btn btn-sm btn btn-primary">Nueva Empresa</a>
            </div>
            <table id="tabla" class="table table-hover table-condensed table-responsive">
                <thead>
                    <th>Identificador</th>
                    <th>Nombre</th>
                    <th>Rut</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Nombre Contacto</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($listaEmpresas as $item)
                        <tr>
                            <td>{{ $item->idEmpresaTransporte }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->rut }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->telefono }}</td>
                            <td>{{ $item->nombreContacto }}</td>
                            <td>
                                <a href="{{ asset('/') }}datosEmpresaTransporte/{{ $item->idEmpresaTransporte }}/" class="btn btn-xs btn btn-warning" style="width:80px">Editar</a>
                            </td>                                
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th>Identificador</th>
                    <th>Nombre</th>
                    <th>Rut</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Nombre Contacto</th>
                    <th></th>
                </tfoot>                
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

    <!-- Timepicker -->
    <script src="{{ asset('/') }}js/bootstrap-timepicker.min.js"></script>  

    <script src="{{ asset('/') }}js/app/funciones.js"></script>
    <script>

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
