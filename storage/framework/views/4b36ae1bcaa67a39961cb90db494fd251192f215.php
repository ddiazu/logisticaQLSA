      

<?php $__env->startSection('contenedorprincipal'); ?>

<div style="padding: 10px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Nota de Venta Nº <?php echo e($notaventa[0]->idNotaVenta); ?></b>
        </div>
        <div class="padding-md clearfix"> 

                <input type="hidden" id="idCliente">
                <input type="hidden" id="_token" name="_token" value="<?php echo e(csrf_token()); ?>">
                <div class="row">        
                    <div class="col-lg-1 col-md-1 col-sm-2" >
                        Cliente
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtNombreCliente" readonly value="<?php echo e($notaventa[0]->emp_nombre); ?>">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        Fecha
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtFechaCotizacion" readonly value="<?php echo e($notaventa[0]->fechahora_creacion); ?>">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        Cotización
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtAno" maxlength="4" value="<?php echo e($notaventa[0]->cot_numero); ?> / <?php echo e($notaventa[0]->cot_año); ?>" readonly>
                    </div>                    
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-md-1 col-sm-2">
                        Crea
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtUsuarioCrea" readonly value="<?php echo e($notaventa[0]->usuario_creacion); ?>">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2" >
                        Aprueba
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtUsuarioValida" readonly value="<?php echo e($notaventa[0]->usuario_validacion); ?>">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2">
                       Ejecutivo&nbspQL
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4">
                        <input class="form-control input-sm" id="txtUsuarioEncargado" readonly value="<?php echo e($notaventa[0]->usuario_encargado); ?>">
                    </div>                     
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-sm-2 col-md-1">
                        Obra/Planta
                    </div>
                    <div class="col-lg-3 col-sm-4 col-md-3">                        
                        <input id="idObra" class="form-control input-sm" readonly value="<?php echo e($notaventa[0]->Obra); ?>">
                    </div>
                    <div class="col-lg-1 col-sm-2 col-md-1">
                        O.Compra
                    </div>
                    <div class="col-lg-3 col-sm-4 col-md-5">                        
                        <input id="txtOrdenCompra" class="form-control input-sm" readonly value="<?php echo e($notaventa[0]->ordenCompraCliente); ?>">
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-sm-2 col-md-1">
                        Contacto
                    </div>
                    <div class="col-lg-3 col-sm-4 col-md-3">                        
                        <input id="txtNombreContacto" class="form-control input-sm" readonly value="<?php echo e($notaventa[0]->nombreContacto); ?>">
                    </div> 
                    <div class="col-lg-1 col-sm-2 col-md-1">
                        Teléfono
                    </div>
                    <div class="col-lg-3 col-sm-4 col-md-5">                        
                        <input id="txtTelefonoContacto" class="form-control input-sm" readonly value="<?php echo e($notaventa[0]->telefonoContacto); ?>">
                    </div>                    
                    <div class="col-lg-1 col-sm-2 col-md-1">
                        Email
                    </div>
                    <div class="col-lg-3 col-sm-4 col-md-3">                        
                        <input id="txtCorreoContacto" class="form-control input-sm" readonly value="<?php echo e($notaventa[0]->correoContacto); ?>">
                    </div>         
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-lg-1 col-md-2 col-sm-2">
                        Observaciones
                    </div>
                    <div class="col-lg-7 col-md-10 col-sm-10">                            
                        <input id="idObra" class="form-control input-sm" readonly value="<?php echo e($notaventa[0]->observaciones); ?>">
                    </div>
                </div>
             
            </div>            
            <div style="padding: 20px">
                <table id="tablaDetalle" class="table table-hover table-condensed" style="width: 800px">
                    <thead>
                        <th style="width: 50px">Codigo</th>
                        <th style="width: 100px">Producto</th>
                        <th style="width: 50px;text-align:right;">Cantidad</th>
                        <th style="width: 50px">Unidad</th>
                        <?php if( Session::get('grupoUsuario')=='C' or Session::get('grupoUsuario')=='CL'): ?>
                            <th style="width: 50px;text-align:right;">Precio Base ($)</th>
                        <?php endif; ?>
                        <th style="width: 50px;text-align:right;">Saldo</th>
                        <?php if( Session::get('grupoUsuario')=='C' or Session::get('grupoUsuario')=='CL'): ?>
                            <th style="width: 150px">Glosa de Reajuste</th>
                        <?php endif; ?>
                        <th style="width: 50px">Planta</th>
                        <th style="width: 50px">Entrega</th>
                    </thead>
                
                    <tbody>
                        <?php $__currentLoopData = $notaventadetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="width: 50px"> <?php echo e($item->prod_codigo); ?> </td>
                            <td style="width: 50px"> <?php echo e($item->prod_nombre); ?> </td>
                            <td style="width: 50px;text-align:right;"> <?php echo e($item->cantidad); ?> </td>
                            <td style="width: 50px"> <?php echo e($item->u_nombre); ?> </td>
                            <?php if( Session::get('grupoUsuario')=='C' or Session::get('grupoUsuario')=='CL'): ?>
                                <td style="width: 50px;text-align:right;"><?php echo e(number_format( $item->precio, 0, ',', '.' )); ?></td>
                            <?php endif; ?>    
                            <td style="width: 50px;text-align:right;"> <?php echo e($item->cantidad-$item->CantidadPedida); ?> </td>
                            <?php if( Session::get('grupoUsuario')=='C' or Session::get('grupoUsuario')=='CL'): ?>
                                <td style="width: 150px"> <?php echo e($item->cp_glosa_reajuste); ?> </td>
                            <?php endif; ?>    
                            <td style="width: 50px"> <?php echo e($item->nombrePlanta); ?> </td>
                            <td style="width: 50px"> <?php echo e($item->nombreFormaEntrega); ?> </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div> 

            <div style="padding-top: 20px; padding-left: 20px">
                <?php if(count($pedidos)>0): ?>
                    <div class="row" style="padding: 5px">
                        <b>Pedidos Asociados a esta Nota de Venta. ( * = pendiente de aprobación )</b>
                    </div>
                    <div class="row" style="padding-top: 5px; padding-left: 5px"">
                        <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if( $item->idEstadoPedido==1 ): ?>
                                <a href="<?php echo e(asset('/')); ?>verpedido/<?php echo e($item->idPedido); ?>/4/" class="btn btn-xs btn-info"> <?php echo e($item->idPedido); ?> *</a>
                            <?php else: ?>
                                <a href="<?php echo e(asset('/')); ?>verpedido/<?php echo e($item->idPedido); ?>/4/" class="btn btn-xs btn-primary"> <?php echo e($item->idPedido); ?> </a>
                            <?php endif; ?>    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    </div>                      
                <?php else: ?>
                    <b>Esta Nota de Venta no tiene pedidos asociados.</b>    
                <?php endif; ?>

            </div>

            <div style="padding-top:18px; padding-bottom: 20px;padding-left: 15px">
                <?php if( Session::get('grupoUsuario')=='C' and $notaventa[0]->aprobada==0 ): ?>
                    <a href="<?php echo e(asset('/')); ?>aprobarnota/<?php echo e($notaventa[0]->idNotaVenta); ?>/" class="btn btn-sm btn-primary" style="width:80px">Aprobar</a>
                <?php endif; ?>
                <?php if( Session::get('grupoUsuario')=='C' and $notaventa[0]->aprobada==1 and $notaventa[0]->TienePedidos==0): ?>
                    <a href="<?php echo e(asset('/')); ?>Desaprobarnota/<?php echo e($notaventa[0]->idNotaVenta); ?>/" class="btn btn-sm btn-primary" style="width:90px">Desaprobar</a>
                <?php endif; ?>
                <?php if($accion=='1'): ?>
                    <a href="<?php echo e(asset('/')); ?>listarNotasdeVenta" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
                <?php elseif($accion=='2'): ?>
                    <a href="<?php echo e(asset('/')); ?>listarNotasdeVenta" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
                <?php endif; ?>

            </div>              
        </body>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <!-- Datepicker -->
    <script src="<?php echo e(asset('/')); ?>js/bootstrap-datepicker.min.js"></script>  

    <!-- Timepicker -->
    <script src="<?php echo e(asset('/')); ?>js/bootstrap-timepicker.min.js"></script>  

    <script src="<?php echo e(asset('/')); ?>js/app/funciones.js"></script>
    <script src="<?php echo e(asset('/')); ?>js/app/nuevanotaventa.js"></script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>