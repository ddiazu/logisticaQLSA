@extends('plantilla')      

@section('contenedorprincipal')

<div style="padding: 20px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Obras</b>
            <span class="badge badge-info pull-right">{{ $listaObras->count() }} Obras</span>
        </div>
        <div class="padding-md clearfix"> 
            <div style="padding-bottom: 15px">  
                <a href="#" class="btn btn-sm btn-primary">Nueva Obra</a>
            </div>
            <table id="tabla" class="table table-hover table-condensed table-responsive">
                <thead>
                    <th>Nombre Obra</th>
                    <th>Cliente</th>
                    <th>Distancia</th>
                    <th>Tiempo</th>
                    <th>Costo Flete</th>
                    <th>Nombre Contacto</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($listaObras as $item)
                        <tr>
                            <td>{{ $item->nombreObra }}</td>
                            <td>{{ $item->nombreCliente }}</td>
                            <td>{{ $item->distancia }}</td>
                            <td>{{ $item->tiempo }}</td>
                            <td>{{ $item->costoFlete }}</td>
                            <td>{{ $item->nombreContacto }}</td>
                            <td>
                                <button class="btn btn-xs btn btn-warning">Editar</button>
                                <button class="btn btn-xs btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th>Identificador</th>
                    <th>Nombre</th>
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
            var tabla=document.getElementById('tabla');
            var filaFooter= tabla.rows.length-1;
            for(var x=0;x<tabla.rows[0].cells.length-1;x++){
                tabla.rows[filaFooter].cells[x].innerHTML='<input type="text" class="form-control input-sm">';
            }

            // DataTable
            $('#tabla').DataTable({
                language:{url: "{{ asset('/') }}locales/datatables_ES.json"},
                initComplete: function () {
                    var table = $('#tabla').DataTable();

                    // Apply the search
                    table.columns().every( function () {
                        var that = this;
                 
                        $( 'input', this.footer() ).on( 'keyup change', function () {
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );
                    } );                    
                }
            });

        } );

    </script>
    
@endsection
