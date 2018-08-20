      

<?php $__env->startSection('contenedorprincipal'); ?>

<div style="padding: 5px">
    <div class="panel panel-default table-responsive">
        <div class="panel-heading">
            <b>Nuevo Pedido</b>
        </div>
        <div> 
            <div style="padding: 10px" class="panel panel-default panel-stat2"> 
                <input type="hidden" id="idCliente">
                <input type="hidden" id="_token" name="_token" value="<?php echo e(csrf_token()); ?>">
                <div class="row">
                    <div class="col-sm-1 col-lg-1">
                        Nota de Venta
                    </div>
                    <div class="col-sm-1 col-lg-1">
                        <input type="hidden" id="txtNumeroNotaVenta" value="<?php echo e($NotadeVenta[0]->idNotaVenta); ?>">
                        <button class="btn btn-success btn-sm" style="width: 100%" onclick="verNotaVenta();"><?php echo e($NotadeVenta[0]->idNotaVenta); ?></button>
                    </div>
                 
                    <div class="col-sm-1 col-lg-1">
                        Cliente
                    </div>
                    <div class="col-sm-3 col-lg-3">
                        <input class="form-control input-sm" id="txtNombreCliente" readonly  value="<?php echo e($NotadeVenta[0]->emp_nombre); ?>">
                    </div>
                    <div class="col-sm-1 col-lg-1">
                        Fecha
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        <input class="form-control input-sm" id="txtFechaCotizacion" readonly value="<?php echo e($NotadeVenta[0]->fechahora_creacion); ?>">
                    </div>
                    <div class="col-sm-1 col-lg-1">
                        Cotización
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-2">
                        <input class="form-control input-sm" id="txtAno" readonly value="<?php echo e($NotadeVenta[0]->cot_numero); ?> / <?php echo e($NotadeVenta[0]->cot_año); ?>">
                    </div>
                </div>
                <div class="row" style="padding-top: 10px">
                    <div class="col-sm-1 col-lg-1">
                        Obra
                    </div>
                    <div class="col-sm-3 col-lg-3">
                        <input class="form-control input-sm" id="txtUsuarioValida" readonly value="<?php echo e($NotadeVenta[0]->Obra); ?>">
                    </div>                 
                    <div class="col-sm-1 col-lg-1">
                        Ejecutivo QL
                    </div>
                    <div class="col-sm-3 col-lg-3">
                        <input class="form-control input-sm" id="txtUsuarioCrea" readonly value="<?php echo e($NotadeVenta[0]->usuario_encargado); ?>">
                    </div>
                    <div class="col-sm-1 col-lg-1">
                        Aprueba
                    </div>
                    <div class="col-sm-3 col-lg-3">
                        <input class="form-control input-sm" id="txtUsuarioValida" readonly value="<?php echo e($NotadeVenta[0]->usuario_validacion); ?>">
                    </div> 
                </div>
                <div class="row" style="padding-top: 20px; padding-bottom: 20px">
                    <div class="col-md-1">
                        Formato 
                    </div>
                     <div class="col-md-2">
                        <select id="tipoCarga" class="form-control input-sm" onchange="selTipoCarga();">
                            <option selected value="1">Granel</option>
                            <option value="2">Otros</option>
                        </select>
                    </div> 
                 
                    <div id="opciones" style="display: none">
                        <div class="col-md-1">
                            Tipo Transporte
                        </div>
                        <div class="col-md-2">
                            <select id="tipoTransporte" class="form-control input-sm" onchange="selTipoTransporte();">
                                <option selected value="1">Normal</option>
                                <option value="2">Mixto</option>
                            </select>
                        </div>                                    
                        <div class="col-md-1">
                            Planta 
                        </div>
                        <div class="col-md-2">
                            <select id="listaPlantas" class="form-control input-sm">
                                <?php $__currentLoopData = $Plantas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $planta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($planta->idPlanta); ?>"><?php echo e($planta->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            </select>
                        </div>
                        <div class="col-md-1">
                            Forma de Entrega 
                        </div>
                        <div class="col-md-2">
                            <select  id="listaFormaEntrega" class="form-control input-sm">
                                <?php $__currentLoopData = $FormasdeEntrega; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formaEntrega): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($formaEntrega->idFormaEntrega); ?>"><?php echo e($formaEntrega->nombre); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            </select>  
                        </div>

                    </div>
                </div>                   
            </div>

            <div style="padding-top: 5px; display: none" id="divPedidoProductosporUnidad">
                <table id="tablaDetallePedidoNormal" class="table table-condensed table-hover table-responsive">
                    <thead>
                        <th style="display: none">Codigo</th>
                        <th width="15%">Producto</th>
                        <th width="5%">Diseño</th>
                        <th width="10%">Precio</th>
                        <th width="5%">Cantidad</th>
                        <th width="5%">Unidad</th>
                        <th width="5%">Saldo</th>
                        <th width="5%">Cantidad<br>Solicitada</th>
                        <th width="15%">Planta de Origen</th>
                        <th width="20%">Forma de Entrega</th>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $NotadeVentaDetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item->u_nombre !='tonelada'): ?>
                                <tr>
                                    <td style="display: none"><?php echo e($item->prod_codigo); ?></td>
                                    <td><?php echo e($item->prod_nombre); ?></td>
                                    <td><?php echo e($item->formula); ?></td>
                                    <?php if($item->cp_tipo_reajuste=='Con reajuste'): ?>
                                        <td align="right"><?php echo e(number_format( $item->precioActual, 0, ',', '.' )); ?></td>
                                    <?php else: ?>
                                        <td align="right"><?php echo e(number_format( $item->precio, 0, ',', '.' )); ?></td>
                                    <?php endif; ?>    

                                    <td align="right"><?php echo e($item->cantidad); ?></td>
                                    <td><?php echo e($item->u_nombre); ?></td>
                                    <td align="right"><?php echo e($item->Saldo); ?></td>
                                    <td aling="right"><input class="form-control input-sm" onblur="verificarCantidad(this);" onkeypress="return isNumberKey(event)" ></td>
                                    <td>
                                        <select class="form-control input-sm">
                                            <?php $__currentLoopData = $Plantas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $planta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if( $item->idPlanta==$planta->idPlanta ): ?>
                                                    <option value="<?php echo e($planta->idPlanta); ?>" selected><?php echo e($planta->nombre); ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo e($planta->idPlanta); ?>"><?php echo e($planta->nombre); ?></option>
                                                <?php endif; ?>    
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                        </select>                                    
                                    </td>
                                    <td>
                                        <select class="form-control input-sm">
                                            <?php $__currentLoopData = $FormasdeEntrega; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formaEntrega): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if( $item->idFormaEntrega==$formaEntrega->idFormaEntrega ): ?>
                                                    <option value="<?php echo e($formaEntrega->idFormaEntrega); ?>" selected><?php echo e($formaEntrega->nombre); ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo e($formaEntrega->idFormaEntrega); ?>"><?php echo e($formaEntrega->nombre); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                        </select>                                    
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>            
                    </tbody>
                </table>
            </div> 

            <div style="padding-top: 5px; display: none" id="divPedidoProductosaGranel">
                <div class="row" style="padding-left: 10px">
                    <div class="col-md-2">
                        Seleccione Producto
                    </div>
                    <div class="col-md-3">
                        <select id="listaProductos" class="form-control input-sm">
                        <?php $__currentLoopData = $NotadeVentaDetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item->u_nombre =='tonelada'): ?>
                                <option value="<?php echo e($item->prod_codigo); ?>"> <?php echo e($item->prod_nombre); ?> </option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select> 
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-success btn-sm" onclick="agregarProducto();">Agregar</button>
                    </div>
                    <div id="notaMaxProducto" class="col-md-6" style="text-align: center;">
                    </div>
                </div>
                <div style="padding-top: 5px; padding-left: 10px; padding-right: 10px; padding-bottom: 5px">
                    <table id="tablaDetallePedidoGranel" class="table table-hover table-condensed  table-responsive" style="width: 100%">
                        <thead>
                            <th style="display: none">Codigo</th>
                            <th style="width:150px">Producto</th>
                            <th style="width:80">Diseño</th>
                            <th style="width:80px">Precio</th>
                            <th style="width:80px">Cantidad</th>
                            <th style="width:80px">Unidad</th>
                            <th style="width:80px">Saldo</th>
                            <th style="width:80px">Cantidad<br>Solicitada</th>
                            <th style="width:80px"></th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $NotadeVentaDetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($item->u_nombre =='tonelada'): ?>
                                    <tr>
                                        <td style="display: none"><?php echo e($item->prod_codigo); ?></td>
                                        <td style="width:150px"><?php echo e($item->prod_nombre); ?></td>
                                        <td style="width:80px"><?php echo e($item->formula); ?></td>
                                        <?php if($item->cp_tipo_reajuste=='Con reajuste'): ?>
                                            <td align="right" style="width:80px"><?php echo e(number_format( $item->precioActual, 0, ',', '.' )); ?></td>
                                        <?php else: ?>
                                            <td align="right" style="width:80px"><?php echo e(number_format( $item->precio, 0, ',', '.' )); ?></td>
                                        <?php endif; ?>    

                                        <td align="right" style="width:80px"><?php echo e($item->cantidad); ?></td>
                                        <td style="width:80px"><?php echo e($item->u_nombre); ?></td>
                                        <td align="right" style="width:80px"><?php echo e($item->Saldo); ?></td>
                                        <td aling="right" style="width:80px">
                                            <input class="form-control input-sm" onblur="verificarCantidad(this);" onkeypress="return isNumberKey(event)" >
                                        </td>
                                        <td style="width:80px">
                                            <button class="btn btn-warning btn-sm" onclick="ocultarFila(this.parentNode.parentNode.rowIndex);">
                                                <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>            
                        </tbody>
                    </table>
                </div>
            </div> 

            <div id="divPiePedido" style="display: none" class="panel panel-default panel-stat2">
                <div style="padding: 10px">
                    <div class="row">
                        <div class="col-sm-2 col-md-2">
                            Contacto
                            <input id="txtNombreContacto" class="form-control input-sm" value="<?php echo e($NotadeVenta[0]->nombreContacto); ?>">
                        </div> 
                        <div class="col-sm-2 col-md-2">
                            Correo
                            <input id="txtCorreoContacto" class="form-control input-sm" value="<?php echo e($NotadeVenta[0]->correoContacto); ?>">
                        </div>
                        <div class="col-sm-2 col-md-2">
                            Telefono/Móvil
                            <input id="txtTelefono" class="form-control input-sm" value="<?php echo e($NotadeVenta[0]->telefonoContacto); ?>">
                        </div>
                        <div class="col-sm-2 col-md-2">
                            Fecha de Entrega (*)
                            <div class="input-group date" id="divFechaEntrega">
                                <input type="text" class="form-control input-sm" id="txtFechaEntrega">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>                        
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-1">
                            Horario
                            <select id="horario" class="form-control input-sm">
                                <option>AM</option>
                                <option>PM</option>
                            </select> 
                        </div>            
                     
                    </div>
                    <div class="row" style="padding-top: 10px">
                        <div class="col-sm-4 col-md-4">
                            Observaciones
                            <input id="txtObservaciones" class="form-control input-sm">
                        </div>
                        <div class="col-sm-4 col-md-3" style="padding-top: 20px">  
                            <label class="label-checkbox"><input type="checkbox" id="noExcederCantidad"><span class="custom-checkbox"></span>No exceder la cantidad solicitada</label>                 
                        </div>
                        <div class="col-sm-4 col-md-3" style="padding-top: 20px"> 
                            <h5><b> (*) Dato Obligatorio</b></h5>
                        </div>                        
                    </div>

                </div>

                <div style="padding:18px">
                    <button class="btn btn-success btn-sm" onclick="crearPedido('QL');">Crear Pedido</button>
                    <a href="<?php echo e(asset('/')); ?>listarNotasdeVenta" class="btn btn-sm btn-warning" style="width:80px">Atrás</a>
                </div> 

                <div style="padding:18px">
                    <b>Consideraciones para despachos a granel:</b>
                    <div class="row" style="padding-top: 15px; padding-left: 30px">
                        <ul>
                            <li><?php echo e($parametros[0]->notaPedido1); ?></li>
                            <li><?php echo e($parametros[0]->notaPedido2); ?></li>
                        </ul>
                    </div>
                </div> 
            </div>       
        </div>
    </div>
</div>

        <div id="mdNotaVenta" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5><b>Detalle Nota de Venta</b></h5>
                </div>
                <div id="bodyNotaVenta" class="modal-body">
                    <table id="tablaDetalleNotaVenta" class="table table-hover table-condensed table-responsive">
                        <thead>
                            <th style="width:100px">Producto</th>
                            <th style="width:50px">Cantidad</th>
                            <th style="width:50px">Unidad</th>
                            <th style="text-align: right;width:80px">Precio Base ($)</th>
                            <th style="width:150px">Glosa de Reajuste</th>
                            <th style="width:50px">Valor Pitch</th>
                            <th style="width:50px">% Pitch</th>
                            <th style="width:50px">Valor IPC</th>
                            <th style="width:50px">% IPC</th>                                           
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $NotadeVentaDetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="width:100px"><?php echo e($item->prod_nombre); ?></td>
                                <td style="text-align: right;width:50px"><?php echo e($item->cantidad); ?></td>
                                <td style="width:50px"><?php echo e($item->u_nombre); ?></td>
                                <td style="text-align: right;width:80px"><?php echo e(number_format( $item->precio, 0, ',', '.' )); ?></td>
                                <td style="width:150px"><?php echo e($item->cp_glosa_reajuste); ?></td>
                                <td style="width:50px"><?php echo e($item->cp_valor_pitch); ?></td>
                                <td style="width:50px"><?php echo e($item->cp_pitch); ?></td>
                                <td style="width:50px"><?php echo e($item->cp_valor_ipc); ?></td>
                                <td style="width:50px"><?php echo e($item->cp_ipc); ?></td>                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                              
                        </tbody>
                    </table>
                </div> 

                <div class="col-md-offset-11" style="padding-top: 20px; padding-bottom: 20px">
                    <button class="btn btn-warning btn-sm" onclick="cerrarDetalleNotaVenta();">Cerrar</button>
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
    
    <script src="<?php echo e(asset('/')); ?>js/app/gestionarpedido.js"></script>
    <!-- Datatable -->
    <script src="<?php echo e(asset('/')); ?>js/jquery.dataTables.min.js"></script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantilla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>