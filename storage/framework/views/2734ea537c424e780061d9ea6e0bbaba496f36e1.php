      

<?php $__env->startSection('contenedorprincipal'); ?>

<div style="padding: 20px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Empresas de Transporte</b>
            <span class="badge badge-info pull-right"><?php echo e($listaEmpresas->count()); ?> Clientes</span>
        </div>
        <div class="padding-md clearfix">
            <div style="padding-bottom: 15px">  
                <a href="<?php echo e(asset('/')); ?>datosEmpresaTransporte/0/" class="btn btn-sm btn btn-primary">Nueva Empresa</a>
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
                    <?php $__currentLoopData = $listaEmpresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->idEmpresaTransporte); ?></td>
                            <td><?php echo e($item->nombre); ?></td>
                            <td><?php echo e($item->rut); ?></td>
                            <td><?php echo e($item->email); ?></td>
                            <td><?php echo e($item->telefono); ?></td>
                            <td><?php echo e($item->nombreContacto); ?></td>
                            <td>
                                <a href="<?php echo e(asset('/')); ?>datosEmpresaTransporte/<?php echo e($item->idEmpresaTransporte); ?>/" class="btn btn-xs btn btn-warning" style="width:80px">Editar</a>
                            </td>                                
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <a href="<?php echo e(asset('/')); ?>dashboard" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
    </div>    
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <!-- Datepicker -->
    <script src="<?php echo e(asset('/')); ?>js/bootstrap-datepicker.min.js"></script>  

    <!-- Timepicker -->
    <script src="<?php echo e(asset('/')); ?>js/bootstrap-timepicker.min.js"></script>  

    <script src="<?php echo e(asset('/')); ?>js/app/funciones.js"></script>
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