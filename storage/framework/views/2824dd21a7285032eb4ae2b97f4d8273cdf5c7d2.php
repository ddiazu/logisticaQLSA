  

<?php $__env->startSection('contenedorprincipal'); ?>

<div style="padding: 5px">
    <input type="hidden" id="_token" name="_token" value="<?php echo e(csrf_token()); ?>">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Clientes</b>
            <span class="badge badge-info pull-right"><?php echo e($listaEmpresas->count()); ?> Clientes</span>
        </div>
        <div class="padding-md clearfix">           
            <table id="tabla" class="table table-hover table-condensed table-responsive" style="width: 100%">
                <thead>
                    <th style="display: none">Codigo</th>
                    <th>Nombre</th>
                    <th>Razón Social</th>
                    <th>Dirección</th>
                    <th style="text-align: center">Solicita OC</th>
                    <th style="text-align: center">Cód. Softland</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $listaEmpresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="display: none"><?php echo e($item->emp_codigo); ?></td>
                            <td><?php echo e($item->emp_nombre); ?></td>
                            <td><?php echo e($item->emp_razon_social); ?></td>
                            <td><?php echo e($item->emp_direccion); ?></td>
                            <td style="text-align: center">
                                <?php if( $item->emp_solicitaOC==1): ?>
                                    SI
                                <?php else: ?>
                                    NO
                                <?php endif; ?>    
                            </td>
                            <td style="text-align: center"><?php echo e($item->emp_codigoSoftland); ?></td>
                            <td>
                                <button class="btn btn-xs btn btn-warning" onclick="verDatosCliente( this.parentNode.parentNode.rowIndex );">Editar</button>
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

<div id="modCliente" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h5><b>Datos Cliente</b></h5>
        </div>
        <div id="bodyCliente" class="modal-body">
            <input class="hidden" id="fila">
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Nombre
                </div>
                <div class="col-md-4">
                    <input class="form-control input-sm" id="nombre">
                </div>
            </div>            
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Razón Social
                </div>
                <div class="col-md-7">
                    <input class="form-control input-sm" id="razonSocial">
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Dirección
                </div>
                <div class="col-md-7">
                    <input class="form-control input-sm" id="direccion">
                </div>
            </div>
            <div class="row" style="padding-top: 5px">
                <div class="col-md-3">
                    Solicita OC
                </div>
                <div class="col-md-3">
                    <select class="form-control input-sm" id="solicitaOC">
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
                    <input class="form-control input-sm" id="codigoSoftland">
                </div>
            </div>        
        </div>
        <div class="col-md-offset-8" style="padding-top: 20px; padding-bottom: 20px">
           <button id="btnEliminarBodega" type="button" class="btn btn-success btn-sm" onclick="guardarDatosCliente();" style="width: 80px">Guardar</button>
           <button id="btnCerrarCajaBodega" type="button" class="btn btn-danger data-dismiss=modal btn-sm" onclick="cerrarModCliente()" style="width: 80px">Salir</button>
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



    <script>

        function verDatosCliente(fila){
            var tabla=document.getElementById('tabla');
            $("#fila").val(fila);
            $("#nombre").val( tabla.rows[fila].cells[1].innerHTML.trim() );
            $("#razonSocial").val( tabla.rows[fila].cells[2].innerHTML.trim() );
            $("#direccion").val( tabla.rows[fila].cells[3].innerHTML.trim() );
            $("#codigoSoftland").val( tabla.rows[fila].cells[5].innerHTML.trim() );

            if( tabla.rows[fila].cells[4].innerHTML.trim()=='NO' ){
                document.getElementById('solicitaOC').selectedIndex=1;
            }else{
                document.getElementById('solicitaOC').selectedIndex=0;
            }
            $("#modCliente").modal("show");
        }

        function cerrarModCliente(){
           $("#modCliente").modal("hide"); 
        }

        function guardarDatosCliente(){
            var tabla=document.getElementById('tabla');
            var fila=$("#fila").val();

            $.ajax({
                url: urlApp + "guardarDatosCliente",
                headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
                type: 'POST',
                dataType: 'json',
                data: { 
                        emp_codigo: tabla.rows[fila].cells[0].innerHTML.trim(),
                        razonSocial: $("#razonSocial").val(),
                        nombre: $("#nombre").val(),
                        direccion: $("#direccion").val(),
                        solicitaOC: $("#solicitaOC").val(),
                        codigoSoftland: $("#codigoSoftland").val()
                      },
                success:function(dato){
                    tabla.rows[fila].cells[1].innerHTML=$("#nombre").val();
                    tabla.rows[fila].cells[2].innerHTML=$("#razonSocial").val();
                    tabla.rows[fila].cells[3].innerHTML=$("#direccion").val();
                    tabla.rows[fila].cells[4].innerHTML=$("#solicitaOC option:selected").html();
                    tabla.rows[fila].cells[5].innerHTML=$("#codigoSoftland").val();

                    cerrarModCliente();

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
                "order": [[ 1, "asc" ]],
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