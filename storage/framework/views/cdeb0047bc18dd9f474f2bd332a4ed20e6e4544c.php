      

<?php $__env->startSection('contenedorprincipal'); ?>

<div style="padding: 20px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Plantas</b>
            <span class="badge badge-info pull-right"><?php echo e($listaPlantas->count()); ?> Plantas</span>
        </div>
        <div class="padding-md clearfix"> 
            <div style="padding-bottom: 15px">  
                <a href="#" class="btn btn-sm btn-primary">Nueva Planta</a>
            </div>
            <table id="tabla" class="table table-hover table-condensed table-responsive">
                <thead>
                    <th>Identificador</th>
                    <th>Nombre</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $listaPlantas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->idPlanta); ?></td>
                            <td><?php echo e($item->nombre); ?></td>
                            <td>
                                <button class="btn btn-xs btn btn-warning">Editar</button>
                                <button class="btn btn-xs btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            var tabla=document.getElementById('tabla');
            var filaFooter= tabla.rows.length-1;
            for(var x=0;x<tabla.rows[0].cells.length-1;x++){
                tabla.rows[filaFooter].cells[x].innerHTML='<input type="text" class="form-control input-sm">';
            }

            // DataTable
            $('#tabla').DataTable({
                language:{url: "<?php echo e(asset('/')); ?>locales/datatables_ES.json"},
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
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>