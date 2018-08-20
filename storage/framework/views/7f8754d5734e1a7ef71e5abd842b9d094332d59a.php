      

<?php $__env->startSection('contenedorprincipal'); ?>

<div style="padding: 20px">
    <input type="hidden" id="_token" name="_token" value="<?php echo e(csrf_token()); ?>">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Obras</b>
            <span class="badge badge-info pull-right"><?php echo e(count($listaObras)); ?> Obras</span>
        </div>
        <div class="padding-md clearfix"> 
            <div class="row" style="padding-bottom: 10px">
                <div class="col-lg-1 col-sm-1">
                    <button class="btn btn-primary btn-sm" onclick="nuevaObra(1);">Nueva Obra</button>
                </div>
            </div>
            <table id="tabla" class="table table-hover table-condensed table-responsive" style="width:100%">
                <thead>
                    <th>Nombre Obra</th>
                    <th>Cliente</th>
                    <th>Distancia</th>
                    <th>Tiempo</th>
                    <th>Costo Flete</th>
                    <th>Nombre Contacto</th>
                    <th>Cód.Softland</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $listaObras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->nombreObra); ?></td>
                            <td><?php echo e($item->nombreCliente); ?></td>
                            <td><?php echo e($item->distancia); ?></td>
                            <td><?php echo e($item->tiempo); ?></td>
                            <td><?php echo e($item->costoFlete); ?></td>
                            <td><?php echo e($item->nombreContacto); ?></td>
                            <td><?php echo e($item->codigoSoftland); ?></td>
                            <td>
                                <button class="btn btn-xs btn btn-warning" onclick="editarObra( <?php echo e($item->idObra); ?>, this.parentNode.parentNode.rowIndex )">Editar</button>
                                <button class="btn btn-xs btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>            
            </table>      
        </div>
    </div>
    <div style="padding-top:18px; padding-bottom: 20px;padding-left: 20px">
        <a href="<?php echo e(asset('/')); ?>dashboard" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
    </div>    
</div>


        <div id="mdNuevaObra" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5><b>Nueva Obra</b></h5>
                </div>
                <div id="bodyCajaEliminaBodega" class="modal-body">
                    <input type="hidden" id="idObra">
                    <input type="hidden" id="filaObra">         
                    <div class="row" style="padding-top: 5px">

                        <div class="col-sm-3">
                            Nombre corto de Obra/Planta (*)
                        </div>
                        <div class="col-sm-6">
                            <input type="text" id="txtNombreObra" class="form-control input-sm" maxlength="50">
                        </div>
                    </div>
                    <div class="row" style="padding-top: 5px">
                        <div class="col-sm-3">
                            Cliente
                        </div>
                        <div class="col-sm-9">
                            <select id="idCliente" class="form-control input-sm">
                                <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->emp_codigo); ?>"><?php echo e($item->emp_nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>                      
                    <div class="row" style="padding-top: 5px">
                        <div class="col-sm-3">
                            Nombre Contacto (*)
                        </div>
                        <div class="col-sm-6">
                            <input type="text" id="txtNombreContactoObra" class="form-control input-sm" maxlength="50">
                        </div>
                    </div>
                    <div class="row" style="padding-top: 5px">
                        <div class="col-sm-3">
                            Correo
                        </div>
                        <div class="col-sm-6">
                            <input type="text" id="txtCorreoContactoObra" class="form-control input-sm" maxlength="80">
                        </div>
                    </div>
                    <div class="row" style="padding-top: 5px">
                        <div class="col-sm-3">
                            Teléfono/Movil (*)
                        </div>
                        <div class="col-sm-6">
                            <input type="text" id="txtTelefonoObra" class="form-control input-sm" maxlength="30">
                        </div>
                    </div>  
                    <div class="row" style="padding-top: 5px">
                        <div class="col-sm-3">
                            Código Softland
                        </div>
                        <div class="col-sm-3">
                            <input type="text" id="codigoSoftland" class="form-control input-sm" maxlength="10">
                        </div>
                    </div>                                   
                    <div class="row" style="padding-top: 5px">
                        <div class="col-sm-3">
                            Descripción
                        </div>
                        <div class="col-sm-9">
                            <textarea id="txtDescripcionObra" class="form-control input-sm" maxlength="300" rows="3"></textarea>
                        </div>
                    </div> 
                    <div class="row" style="padding-top: 15px">
                        <div class="col-sm-2">
                            Distancia (km)
                        </div>
                        <div class="col-sm-2">
                            <input id="txtDistancia" class="form-control input-sm" maxlength="4" onkeypress='return isNumberKey(event)'>                            
                        </div>
                        <div class="col-sm-1">
                            Tiempo (hr)
                        </div>
                        <div class="col-sm-2">
                            <input id="txtTiempo" class="form-control input-sm" maxlength="5" onkeypress='return isNumberKey(event)'>                           
                        </div>
                        <div class="col-sm-2">
                            Costo Flete ($/ton)
                        </div>
                        <div class="col-sm-3">
                            <input id="txtCostoFlete" class="form-control input-sm" maxlength="10" onkeypress='return isNumberKey(event)'>                            
                        </div>                                                                      
                    </div> 
                </div>        
                <div style="padding-left: 15px; padding-top: 5px">
                    <h5><b> (*) Dato Obligatorio</b></h5>
                </div>              
                <div class="col-md-offset-8" style="padding-top: 20px; padding-bottom: 20px">
                   <button id="btnEliminarBodega" type="button" class="btn btn-success btn-sm" onclick="agregarNuevaObra();" style="width: 80px">Guardar</button>
                   <button id="btnCerrarCajaBodega" type="button" class="btn btn-danger data-dismiss=modal btn-sm" onclick="cerrarNuevaObra()" style="width: 80px">Salir</button>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <!-- Datepicker -->
    <script src="<?php echo e(asset('/')); ?>js/bootstrap-datepicker.min.js"></script>  

    <!-- Timepicker -->
    <script src="<?php echo e(asset('/')); ?>js/bootstrap-timepicker.min.js"></script>  

    <script src="<?php echo e(asset('/')); ?>js/app/funciones.js"></script>
    <script src="<?php echo e(asset('/')); ?>js/app/listadeObras.js"></script>
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
                language:{url: "<?php echo e(asset('/')); ?>locales/datatables_ES.json"}
            });

        } );

    </script>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>