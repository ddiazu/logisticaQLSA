      

<?php $__env->startSection('contenedorprincipal'); ?>

<div style="padding: 5px">
    <div class="panel panel-default">
        <input type="hidden" id="_token" name="_token" value="<?php echo e(csrf_token()); ?>">
        <input type="hidden" id="idPerfil" value="<?php echo e(Session::get('idPerfil')); ?>">
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
                        <?php $__currentLoopData = $guias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="width:80px"><button class="btn btn-success btn-sm" style="width: 80px" onclick="registrarSalida(<?php echo e($item->tipoGuia); ?>, <?php echo e($item->numeroGuia); ?>, this.parentNode.parentNode.rowIndex)"><?php echo e($item->numeroGuia); ?></button></td>
                                <?php if($item->tipoGuia=='1'): ?>
                                    <td style="width: 70px">Electrónica</td>
                                <?php else: ?>
                                    <td style="width: 70px">Manual</td>
                                <?php endif; ?>    
                                <td style="width: 120px"><?php echo e($item->fechaHoraCreacion); ?></td>
                                <td style="width: 70px"><?php echo e($item->idPedido); ?></td>
                                <td style="width: 70px"><?php echo e($item->patente); ?></td>
                                <td style="width: 150px"><?php echo e($item->nombreConductor); ?></td>
                                <td style="width: 150px"><?php echo e($item->empresa); ?></td>                               
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>            
                </table>   

            </div>
        </div>
    </div>
 
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <!-- Datepicker -->
    <script src="<?php echo e(asset('/')); ?>js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo e(asset('/')); ?>locales/bootstrap-datepicker.es.min.js"></script>

    <!-- Timepicker -->
    <script src="<?php echo e(asset('/')); ?>js/bootstrap-timepicker.min.js"></script>  

    <script src="<?php echo e(asset('/')); ?>js/app/funciones.js"></script>
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
                language:{url: "<?php echo e(asset('/')); ?>locales/datatables_ES.json"}                
            });

            document.getElementById('btnRefresh').style.display="block";

        } );

    </script>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>