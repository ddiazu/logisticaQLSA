      

<?php $__env->startSection('contenedorprincipal'); ?>

<div style="padding: 5px">

    <div class="panel panel-default" id="contenedor3">

        <div class="panel-body">
            <h5><b>LISTADO DE GUIAS DE DESPACHO</b> ( <b>Importante</b>: Para los certificados sólo se permiten subir archivos de tipo PDF. )</h5>
            <input type="hidden" id="_token" name="_token" value="<?php echo e(csrf_token()); ?>">
            <div class="table-responsive">
                <table id="tablaAprobados" class="table table-condensed" style="width: 100%">
                    <thead>                      
                        <th style="width:100px">Guia º</th>
                        <th style="width:200px">Cliente</th>
                        <th style="width:200px">Obra</th>
                        <th style="width:150px">Producto</th>
                        <th style="width:80px">Cantidad</th>
                        <th style="width:50px">Unidad</th>
                        <th style="width:100px">Diseño</th>
                        <th style="width:80px"></th>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $guias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>                                    
                                <td style="width:100px"><?php echo e($item->numeroGuia); ?></td>
                                <td style="width:200px"><?php echo e($item->emp_nombre); ?></td>
                                <td style="width:200px"><?php echo e($item->obra); ?></td>
                                <td style="width:150px"><?php echo e($item->prod_nombre); ?></td>
                                <td style="width:80px"><?php echo e($item->cantidadDespachada); ?></td>
                                <td style="width:50px"><?php echo e($item->unidad); ?></td>
                                <td style="width:100px"><?php echo e($item->formula); ?></td>
                                <td style="width:80px">
                                    <?php if( $item->certificado=='' ): ?>
                                        <button class="btn btn-warning btn-sm" onclick="abrirModalSubirArchivo(this.parentNode.parentNode.rowIndex, 1, <?php echo e($item->prod_codigo); ?> );"><span class="glyphicon glyphicon-arrow-up"></span></button>
                                    <?php else: ?>
                                        <a href="<?php echo e(asset('/')); ?>bajarCertificado/<?php echo e($item->certificado); ?>">
                                            <img src="<?php echo e(asset('/')); ?>img/iconos/certificado.png" border="0">
                                        </a>
                                        <button type="button" class="btn btn-danger btn-xs">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button> 
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>            
                </table>
            </div>
        </div>
    </div>
   
</div>


<div id="modSubirArchivo" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <input type="hidden" id="filaTabla" name="filaTabla">
            <h5><b>Subir Certificado</b></h5>
        </div>
        <div id="bodyProducto" class="modal-body">
            <form id="datos" name="datos" enctype="multipart/form-data">
                <input type="hidden" id="codigoTipoGuia" name="codigoTipoGuia">
                <input type="hidden" id="codigoProducto" name="codigoProducto">
                <div class="row" style="padding-top: 5px">
                    <div class="col-md-3">
                        Guia Nº
                    </div>
                    <div class="col-md-4">
                        <input class="form-control input-sm" id="numeroGuia" name="numeroGuia" readonly>
                    </div>
                </div>            
                <div class="row" style="padding-top: 5px">
                    <div class="col-md-3">
                        Producto
                    </div>
                    <div class="col-md-7">
                        <input class="form-control input-sm" id="nombreProducto" data-codigo="0" readonly>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <input type="file" class="form-control input-sm" id="miArchivo" name="miArchivo" accept=".pdf" required>
                </div>
                <div class="col-md-offset-8" style="padding-top: 20px; padding-bottom: 20px">
                   <button type="submit" class="btn btn-success btn-sm" style="width: 80px">Subir</button>
                   <button type="button" class="btn btn-danger data-dismiss=modal btn-sm" onclick="cerrarModalSubirArchivo()" style="width: 80px">Salir</button>
                </div>                   
            </form>     
        </div>
     
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

    <script src="<?php echo e(asset('/')); ?>js/app/funciones.js"></script>
    
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.5/js/dataTables.fixedColumns.min.js"></script>

    <script>

        function abrirModalSubirArchivo(fila, tipoGuia, codProducto){
            var tabla=document.getElementById('tablaAprobados');
            $("#filaTabla").val(fila);
            $("#numeroGuia").val(tabla.rows[fila].cells[0].innerHTML.trim() );
            $("#codigoTipoGuia").val(tipoGuia);
            $("#nombreProducto").val(tabla.rows[fila].cells[3].innerHTML.trim() );
            $("#codigoProducto").val(codProducto);
            $("#modSubirArchivo").modal('show');
        }


        function cerrarModalSubirArchivo(){
            $("#modSubirArchivo").modal("hide");
        }
        
        $('#datos').on('submit', function(e) {
          // evito que propague el submit
          e.preventDefault();
          // agrego la data del form a formData
          var formData = new FormData( $("#datos")[0]);
          $.ajax({
              url: urlApp + "subirCertificado",
              headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
              type:'POST',
              data:formData,
              cache:false,
              contentType: false,
              processData: false,
              success:function(data){
                  var tabla=document.getElementById('tablaAprobados');
                  var fila= $("#filaTabla").val();
                  cerrarModalSubirArchivo();
                  tabla.rows[fila].cells[7].innerHTML="<a href='"+ urlApp + "bajarCertificado/" + data + "'><img src='<?php echo e(asset('/')); ?>img/iconos/certificado.png' border='0'></a><button class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span></button>";  
              },
              error: function(jqXHR, text, error){
                  alert('Error!, No se pudo Añadir los datos');
              }
          });
        });


        $(document).ready(function() {
            // Setup - add a text input to each footer cell

            // DataTable

            // Setup - add a text input to each footer cell
            $('#tablaAprobados thead tr').clone(true).appendTo( '#tablaAprobados thead' );
            $('#tablaAprobados thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                if( title!=''){
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

                        
            var table=$('#tablaAprobados').DataTable({
                 orderCellsTop: true,
                 fixedHeader: true,         
                "lengthMenu": [[6, 12, 20, -1], ["6", "12", "20", "Todos"]],
                dom: 'Bfrtip',
                "scrollX": true,
                buttons: [
                    'pageLength'
                ],                  
                "order": [[ 0, "desc" ]],                        
                language:{url: "<?php echo e(asset('/')); ?>locales/datatables_ES.json"}

            });         

        } );



    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>