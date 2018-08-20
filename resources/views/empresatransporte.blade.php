@extends('plantilla')      
@section('contenedorprincipal')


<div style="padding: 20px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Datos Empresa de Transporte</b>
        </div>
		<div style="padding: 20px">
        	<div class="row" style="padding-top: 5px">
                <input id="idEmpresaTransporte" type="hidden" value="{{ $idEmpresaTransporte}}">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        		<div class="col-sm-2">
        			Nombre Empresa
        		</div>
        		<div class="col-sm-3">
        			<input id="nombre" class="form-control input-sm" value="@isset( $empresa[0]->nombre ) {{ $empresa[0]->nombre }} @endisset">
        		</div>
        		<div class="col-sm-2">
        			Rut
        		</div>
        		<div class="col-sm-2">
        			<input id="rut" class="form-control input-sm" value="@isset( $empresa[0]->rut ) {{ $empresa[0]->rut }} @endisset">
        		</div>        		 		
        	</div>
        	<div class="row" style="padding-top: 5px">
        		<div class="col-sm-2">
        			Email
        		</div>
        		<div class="col-sm-3">
        			<input id="email" class="form-control input-sm" value="@isset( $empresa[0]->email ) {{ $empresa[0]->email }} @endisset">
        		</div>
        		<div class="col-sm-2">
        			Telefono
        		</div>
        		<div class="col-sm-3">
        			<input id="telefono" class="form-control  input-sm" value="@isset( $empresa[0]->telefono ) {{ $empresa[0]->telefono }} @endisset">
        		</div>        		
        	</div>
        	<div class="row" style="padding-top: 5px">
        		<div class="col-sm-2">
        			Nombre Contacto
        		</div>
        		<div class="col-sm-3">
        			<input id="nombreContacto" class="form-control input-sm" value="@isset( $empresa[0]->nombreContacto ) {{ $empresa[0]->nombreContacto }} @endisset">
        		</div>
      		
        	</div>        	
        </div>          	        	
        <div style="padding-bottom: 15px; padding-left: 15px">  
            <button class="btn btn-sm btn-success" onclick="guardarDatos();">Guardar</button>
        </div>        	
    </div>

    <div id="divCamiones" class="panel panel-default table-responsive" style="display: @if( $idEmpresaTransporte=="0") none @else block @endif">
        <div class="panel-heading">
            <b>Camiones</b>
        </div>
        <div style="padding: 20px">
            <div style="padding-bottom: 15px">  
                <a href="#" class="btn btn-sm btn-primary" onclick="formCamion();">Nuevo Camión</a>
            </div>        	
            <table id="tabla" class="table table-hover table-condensed table-responsive">
                <thead>
                    <th>Identificador</th>
                    <th>Patente</th>
                    <th>Capac.Máx.</th>
                    <th>Tipo Rampla</th>
                    <th>Peso</th>
                    <th>Disponible</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($camiones as $item)
                       <tr>
                           <td> {{ $item->idCamion }} </td>
                           <td> {{ $item->patente }} </td>
                           <td> {{ $item->capacidadMaxima }} </td>
                           <td> {{ $item->tipoRampla }} </td>
                           <td> {{ $item->peso }} </td>
                           <td> 
                               @if ($item->disponible==1)
                                    SI
                               @else
                                    NO
                               @endif 
                           </td>
                           <td></td>
                       </tr>
                    @endforeach                    
                </tbody>
            </table>
        </div>
    </div>
    <div id="divConductores" class="panel panel-default table-responsive" style="display: @if( $idEmpresaTransporte=="0") none @else block @endif">
        <div class="panel-heading">
            <b>Conductores</b>
        </div>
        <div style="padding: 20px">
            <div style="padding-bottom: 15px">  
                <a href="#" class="btn btn-sm btn-primary" onclick="formConductor();">Nuevo Conductor</a>
            </div>        	
            <table id="tabla" class="table table-hover table-condensed table-responsive">
                <thead>
                    <th>Identificador</th>
                    <th>Nombre</th>
                    <th>Ap.Paterno</th>
                    <th>Ap.Materno</th>
                    <th>Rut</th>
                    <th>Teléfono</th>
                    <th>email</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($conductores as $item)
                       <tr>
                           <td> {{ $item->idConductor }} </td>
                           <td> {{ $item->nombre }} </td>
                           <td> {{ $item->apellidoPaterno }} </td>
                           <td> {{ $item->apellidoMaterno }} </td>
                           <td> {{ $item->rut }} </td>
                           <td> {{ $item->telefono }} </td>
                           <td> {{ $item->email }} </td>
                           <td></td>
                       </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>

    </div> 
    <div style="padding-top:18px; padding-bottom: 20px;padding-left: 20px">
        <a href="{{ asset('/') }}listaEmpresasTransporte" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
    </div>   
</div>
<div class="modal fade" id="modCamion">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5>Datos del Camión</h5>
            </div>
            <div class="modal-body">
                <div class="row" style="padding:10px">
                    <div class="col-sm-2">
                        Patente
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm" maxlength="50" id="patente">
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-success btn-sm" style="width: 80px" onclick="agregarNuevoInvestigador();" style="width:70px">Guardar</a>
                    </div>                                
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modConductor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5>Datos del Conductor</h5>
            </div>
            <div class="modal-body">
                <div class="row" style="padding:10px">
                    <div class="col-sm-2">
                        Nombre
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm" maxlength="50" id="nombreConductor">
                    </div>
                </div>
                <div class="row" style="padding:10px">
                    <div class="col-sm-2">
                        Rut
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm" maxlength="50" id="rut">
                    </div>
                </div>
                <div class="row" style="padding:10px">
                    <div class="col-sm-2">
                        Telefono
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm" maxlength="50" id="telefono">
                    </div>                            
                </div>
                <div class="row" style="padding:10px">                     
                    <div class="col-sm-2">
                        Email
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm" maxlength="50" id="email">
                    </div>                    
                </div>

            </div>
            <div class="col-sm-2">
                <button class="btn btn-success btn-sm" style="width: 80px" onclick="agregarNuevoInvestigador();" style="width:70px">Guardar</a>
            </div>  
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
    <!-- Datatable -->
    <script src="{{ asset('/') }}js/jquery.dataTables.min.js"></script>
	<script>
		function formCamion(){
			$("#modCamion").modal("show");
		}
		function cerrar_formCamion(){
			$("#modCamion").modal("hide");
		}

		function formConductor(){
			$("#modConductor").modal("show");
		}
		function cerrar_formConductor(){
			$("#modConductor").modal("hide");
		}	

        function guardarDatos(){
            $.ajax({
                url: urlApp + "agregarEmpresaTransporte",
                headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
                type: 'POST',
                dataType: 'json',
                data: { 
                        idEmpresaTransporte: $("#idEmpresaTransporte").val(),
                        nombre: $("#nombre").val(),
                        rut: $("#rut").val(),
                        email: $("#email").val(),
                        telefono: $("#telefono").val(),
                        nombreContacto: $("#nombreContacto").val()
                      },
                success:function(dato){
                    edicion=false;
                    if( $("#idEmpresaTransporte").val() != "0" ){
                        edicion=true;
                    }

                    $("#idEmpresaTransporte").val( dato.identificador );
                    document.getElementById('divCamiones').style.display="block";
                    document.getElementById('divConductores').style.display="block";
                    if(edicion){
                        swal(
                            {
                                title: 'Los datos han sido actualizados!',
                                text: '',
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                cancelButtonText: '',
                                closeOnConfirm: true,
                                closeOnCancel: false
                            }
                        )                        
                    }
                }
            })              

        }

	</script>    
@endsection
