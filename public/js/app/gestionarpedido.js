    

    $(document).ready(function() {
        // Datepicker      
        $('.date').datepicker({
            todayHighlight: true,
            format: "dd/mm/yyyy",
            weekStart: 1,
            language: "es",
            autoclose: true,
            startDate: '+0d'
        }) 

        document.getElementById('tipoCarga').selectedIndex=-1;
        document.getElementById('tipoTransporte').selectedIndex=-1;
        document.getElementById('listaPlantas').selectedIndex=-1;
        document.getElementById('listaFormaEntrega').selectedIndex=-1;

        var tabla=document.getElementById('tablaDetallePedidoGranel'); 
        for(var x=1; x<tabla.rows.length; x++){
            tabla.rows[x].style.display='none';
        }
    });    

    function verificarCantidad(valor){
        if ($("#tipoCarga").val()=='1'){
           var tabla=document.getElementById('tablaDetallePedidoGranel'); 
        }else{
            var tabla=document.getElementById('tablaDetallePedidoNormal'); 
        } 
        var fila=valor.parentNode.parentNode.rowIndex;
        
        if( valor.value!=''){
            if( parseInt(tabla.rows[fila].cells[7].innerHTML) < parseInt(valor.value) ){
                swal(
                    {
                        title: 'Corrija el valor ingresado, es mayor al Saldo.' ,
                        text: '',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        cancelButtonText: '',
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                    function(isConfirm)
                    {
                        if(isConfirm){
                            valor.value='';                           
                        }
                    }
                )                 
            }
        }

    }

    function selTipoCarga(){
        if ($("#tipoCarga").val()=='1'){
            var lista=document.getElementById('listaProductos');
            if( lista.length==0){
                swal(
                    {
                        title: 'Este pedido no tiene productos con formato GRANEL' ,
                        text: '',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        cancelButtonText: '',
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                    function(isConfirm)
                    {
                        if(isConfirm){
                            return;                         
                        }
                    }
                )
                return;                  
            }else{
                document.getElementById('tipoTransporte').selectedIndex=-1;
                document.getElementById("divPedidoProductosaGranel").style.display="block";
                document.getElementById("divPedidoProductosporUnidad").style.display="none";
                document.getElementById("divPiePedido").style.display="block"; 
                document.getElementById("opciones").style.display = "block";                 
            }
          
        }else{
            var tabla=document.getElementById('tablaDetallePedidoNormal');
            if(tabla.rows.length==0){            
                document.getElementById('tipoTransporte').selectedIndex=0;
                document.getElementById("divPedidoProductosaGranel").style.display="none";
                document.getElementById("divPedidoProductosporUnidad").style.display="block";
                document.getElementById("divPiePedido").style.display="block";
                document.getElementById("opciones").style.display = "none";
            }else{
                swal(
                    {
                        title: 'Este pedido no tiene productos con formato OTROS' ,
                        text: '',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        cancelButtonText: '',
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                    function(isConfirm)
                    {
                        if(isConfirm){
                            return;                         
                        }
                    }
                )
                return;                  
            }                           
        }
    }

    function selTipoTransporte(){
        if ($("#tipoTransporte").val()=='1'){
            $("#notaMaxProducto").html('<div class="alert alert-danger">Puede agregar solo 1 producto a este pedido.</div>')
        }else{
            $("#notaMaxProducto").html('<div class="alert alert-danger">Puede agregar solo 2 productos a este pedido.</div>')
        }
    }


    function nuevaObra(){
        $("#txtDescripcionObra").val( $("#txtObra").val() );
        $("#txtCliente").val( $("#txtNombreCliente").val() );
        $("#txtNombreContacto").val('');
        $("#txtCorreoContactoObra").val('');
        $("#txtTelefonoObra").val('');
        $("#mdNuevaObra").modal("show"); 
        $("#txtNombreObra").focus();
    }

    function cerrarNuevaObra(){
        $("#mdNuevaObra").modal("hide");
    }


    function listarObras(){
        $("#idObra").empty();
        var ruta="listarObras";
        $.ajax({
            url: ruta,
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { 
                    emp_codigo: $("#idCliente").val()
                  },
            success:function(dato){
                for(var x=0;x<dato.length;x++){
                    $("#idObra").append( "<option value=" + dato[x].idObra + ">" + dato[x].nombre +"</option>" );
                }
            }
        })        
    }

    function datosObra(){

        var ruta="datosObra";
        $.ajax({
            url: ruta,
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { 
                    idObra: $("#idObra").val()
                  },
            success:function(dato){

                    $("#txtNombreContacto").val( dato[0].nombreContacto );
                    $("#txtCorreoContacto").val( dato[0].correoContacto );
                    $("#txtTelefono").val( dato[0].telefonoContacto );

            }
        })        
    }  

    function agregarProducto(){
        var tabla=document.getElementById('tablaDetallePedidoGranel'); 
        var cont=0;
        var maximo=1;

        if($("#tipoTransporte").val()=='1'){
            maximo=1;
        }else{
            maximo=2;
        }

        for(var x=1; x<tabla.rows.length; x++){
            if(tabla.rows[x].style.display==''){
                cont++;
            }
        }

        if(cont==maximo){
            if(maximo==1){
                swal(
                    {
                        title: 'Solo puede solicitar un producto en un pedido a granel con transporte Normal',
                        text: '',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'Cerrar',
                        cancelButtonText: '',
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                    function(isConfirm)
                    {
                        if(isConfirm){
                            return;
                            
                        }
                    }
                )                  
            }else{
                swal(
                    {
                        title: 'Solo puede solicitar dos productos en un pedido a granel con transporte Mixto',
                        text: '',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'Cerrar',
                        cancelButtonText: '',
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                    function(isConfirm)
                    {
                        if(isConfirm){
                            return;
                            
                        }
                    }
                )                 
            }

            return;
        }

        for(var x=1; x<tabla.rows.length; x++){
            if(tabla.rows[x].cells[0].innerHTML==$("#listaProductos").val()){
                tabla.rows[x].style.display='';
                break;
            }
        }
    }

    function ocultarFila(fila){
        var tabla=document.getElementById('tablaDetallePedidoGranel');
        tabla.rows[fila].style.display='none';
    }


    function crearPedido(Origen){

        if($("#txtFechaEntrega").val().trim()=='' ){
            swal(
                {
                    title: 'Debe ingresar la Fecha de Entrega (*).',
                    text: '',
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'Cerrar',
                    cancelButtonText: '',
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                function(isConfirm)
                {
                    if(isConfirm){
                        return;
                        
                    }
                }
            )  
            return
        }       

        if ($("#tipoCarga").val()=='1'){
            var tabla=document.getElementById('tablaDetallePedidoGranel');

            if(document.getElementById('listaPlantas').selectedIndex<0 || document.getElementById('listaFormaEntrega').selectedIndex<0){
                swal(
                    {
                        title: 'Debe ingresar Planta y Forma de Entrega!' ,
                        text: '',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        cancelButtonText: '',
                        closeOnConfirm: true,
                        closeOnCancel: false
                    }
                )
                return;                   
            }               
        }else{
            var tabla=document.getElementById('tablaDetallePedidoNormal'); 
        }     
        
        var cont=0;
        var total=0;
        var toneladas=0;
        var productos=0;
        for(var x=1; x<tabla.rows.length; x++){
            if(tabla.rows[x].cells[7].getElementsByTagName('input')[0].value.trim()=="" ||  tabla.rows[x].cells[7].getElementsByTagName('input')[0].value.trim()=="0"  ){
                cont++
            }else{
                total+= ( parseInt(tabla.rows[x].cells[3].innerHTML.replace('.','')) * parseInt( tabla.rows[x].cells[7].getElementsByTagName('input')[0].value ) );
                if(tabla.rows[x].cells[5].innerHTML.trim()=='tonelada'){
                    if ($("#tipoCarga").val()=='1'){
                        toneladas+=parseInt( tabla.rows[x].cells[7].getElementsByTagName('input')[0].value )
                    }

                    productos++;
                }

            }
        }

        if(cont==tabla.rows.length-1){
            swal(
                {
                    title: 'No ha ingresado una cantidad para generar el pedido' ,
                    text: '',
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                    cancelButtonText: '',
                    closeOnConfirm: true,
                    closeOnCancel: false
                }
            )
            return;             
        }

        if( toneladas > parseInt($("#maxToneladas").val()) ){
            swal(
                {
                    title: 'La cantidad de toneladas excede el máximo permitido por pedido (máx. ' + $("#maxToneladas").val() +')!!' ,
                    text: '',
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                    cancelButtonText: '',
                    closeOnConfirm: true,
                    closeOnCancel: false
                }
            )
            return;                 
        }

        //Si tipo de carga es A Granel
        if( $("#tipoCarga").val()=='1' ){
            var maxProd=1;
            if( $("#tipoTransporte").val()=='2'){
                maxProd=2;
            }

            if( productos > maxProd ){
                swal(
                    {
                        title: 'La cantidad de productos excede el máximo permitido por pedido (máx. ' + maxProd +')!!' ,
                        text: '',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                        cancelButtonText: '',
                        closeOnConfirm: true,
                        closeOnCancel: false
                    }
                )
                return;                 
            }
        }


        var cont=0;
        var cadena='[';

        for (var i = 1; i < tabla.rows.length; i++){
            if(tabla.rows[i].cells[7].getElementsByTagName('input')[0].value!=""){
                cadena+='{';
                cadena+='"idNotaVenta":"'+  $("#txtNumeroNotaVenta").val()  + '", ';
                cadena+='"prod_codigo":"'+  tabla.rows[i].cells[0].innerHTML  + '", ';
                cadena+='"u_codigo":"'+  tabla.rows[i].cells[5].innerHTML  + '", ';
                cadena+='"cantidad":"'+  tabla.rows[i].cells[7].getElementsByTagName('input')[0].value.replace(",", ".") + '", ';
                cadena+='"precio":"'+  tabla.rows[i].cells[3].innerHTML.replace('.','')  + '", ';

                if($("#tipoCarga").val()=='1'){
                    cadena+='"idPlanta":"'+  $("#listaPlantas").val() + '",';
                    cadena+='"idFormaEntrega":"'+  $("#listaFormaEntrega").val() + '"';    
                }else{
                    cadena+='"idPlanta":"'+  tabla.rows[i].cells[8].getElementsByTagName('select')[0].value  + '",';
                    cadena+='"idFormaEntrega":"'+  tabla.rows[i].cells[9].getElementsByTagName('select')[0].value  + '"';                    
                }



                cadena+='}, ';                
            }


        }

        cadena=cadena.slice(0,-2);
        cadena+=']';

        var noExceder=0;

        if(document.getElementById('noExcederCantidad').checked){
            noExceder=1;
        }

        var ruta= urlApp + "grabarNuevoPedido";
        $.ajax({
            url: ruta,
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { idNotaVenta: $("#txtNumeroNotaVenta").val(),
                    fechaEntrega: fechaAtexto( $("#txtFechaEntrega").val() ),
                    observaciones: $("#txtObservaciones").val(),
                    idPlanta: $("#idPlanta").val(),
                    idFormaEntrega: $("#idTransaccion").val(),
                    horarioEntrega: $("#horario option:selected").html() ,
                    idEstadoPedido: '1',
                    usu_codigo_estado: $("#idUsuarioSession").val() ,
                    totalNeto: total,
                    contacto: $("#txtNombreContacto").val(),
                    telefono: $("#txtTelefono").val(),
                    email: $("#txtCorreoContacto").val(),
                    detalle: cadena,
                    noExcederCantidad: noExceder,
                    tipoCarga: $("#tipoCarga").val(),
                    tipoTransporte: $("#tipoTransporte").val()
                  },
            success:function(dato){
                    swal(
                        {
                            title: 'Se ha creado el Pedido Nº ' + dato.identificador +" ¿Desea crear otro pedido para la misma nota de venta?",
                            text: '',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'SI',
                            cancelButtonText: 'NO',
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function(isConfirm)
                        {
                            if(isConfirm){
                                if(Origen=='QL'){
                                    //location.href= urlApp + "gestionarpedido/"+ $("#txtNumeroNotaVenta").val() + "/"; 
                                    actualizarDetalleNotaVenta();

                                }else{
                                    location.href= urlApp + "clienteGestionarPedido/"+ $("#txtNumeroNotaVenta").val() + "/"; 
                                }
                            }else{
                                if(Origen=='QL'){
                                    location.href= urlApp + "listarPedidos";
                                }else{
                                    location.href= urlApp + "clientePedidos";
                                }
                            }
                        }
                    )                   
            }
        })


    }

    function actualizarDetalleNotaVenta(){

        var cadenaPlantas="<select class='form-control input-sm'>";
        var cadenaFormaEntrega="<select class='form-control input-sm'>";
        $.ajax({
            async:false, 
            url: urlApp + 'apiPlantas',
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: {},
            success:function(dato){
                cadenaPlantas+="<option value='0'></option>";
                for(var x=0;x<dato.length;x++){
                     cadenaPlantas+="<option value='" + dato[x].idPlanta+ "'>" + dato[x].nombre + "</option>";
                }
            }
        }); 
        cadenaPlantas+="</select>";

        $.ajax({
            async:false,
            url: urlApp + 'apiFormadeEntrega',
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: {},
            success:function(dato){
                cadenaFormaEntrega+="<option value='0'></option>";
                for(var x=0;x<dato.length;x++){
                    cadenaFormaEntrega+="<option value='" + dato[x].idFormaEntrega+ "'>" + dato[x].nombre + "</option>";
                }             
            }
        }) 
        cadenaFormaEntrega+="</select>";       

        $.ajax({
            url: urlApp + "detalleNotaVenta",
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { idNotaVenta: $("#txtNumeroNotaVenta").val()
                  },
            success:function(dato){

                $("#tablaDetallePedidoNormal tbody tr").remove();
                $("#tablaDetallePedidoGranel tbody tr").remove();

                for(var x=0;x<dato.length;x++){
                    cadena="<tr>";
                    cadena+="<td style='display: none'>" +dato[x].prod_codigo + "</td>";
                    cadena+="<td>" +dato[x].prod_nombre + "</td>";
                    cadena+="<td>" +dato[x].formula + "</td>";
                    if(dato[x].cp_tipo_reajuste=='Con reajuste'){
                        cadena+="<td align='right'>" +number_format(dato[x].precioActual,0) + "</td>";
                    }else{
                        cadena+="<td align='right'>" +number_format(dato[x].precio,0) + "</td>";
                    }
                    cadena+="<td  align='right'>" +dato[x].cantidad + "</td>";
                    cadena+="<td>" +dato[x].u_nombre + "</td>";
                    cadena+="<td align='right'>" +dato[x].Saldo + "</td>";
                    cadena+="<td aling='right'><input class='form-control input-sm' onblur='verificarCantidad(this);'' onkeypress='return isNumberKey(event)'></td>";
                    cadena+="<td>" + cadenaPlantas + "</td>";
                    cadena+="<td>" + cadenaFormaEntrega + "</td>";
                    cadena+="</tr>";
                    $("#tablaDetallePedidoNormal").append(cadena);

                    cadena="<tr>";
                    cadena+="<td style='display: none'>" +dato[x].prod_codigo + "</td>";
                    cadena+="<td style='width:150px'>" +dato[x].prod_nombre + "</td>";
                    cadena+="<td style='width:80px'>" +dato[x].formula + "</td>";
                    if(dato[x].cp_tipo_reajuste=='Con reajuste'){
                        cadena+="<td align='right' style='width:80px'>" +dato[x].precioActual + "</td>";
                    }else{
                        cadena+="<td align='right' style='width:80px'>" +dato[x].precio + "</td>";
                    }
                    cadena+="<td align='right' style='width:80px'>" +dato[x].cantidad + "</td>";
                    cadena+="<td style='width:80px'>" +dato[x].u_nombre + "</td>";
                    cadena+="<td align='right' style='width:80px'>" +dato[x].Saldo + "</td>";
                    cadena+="<td aling='right'><input class='form-control input-sm' onblur='verificarCantidad(this);'' onkeypress='return isNumberKey(event)'></td>";
                    cadena+="<td style='width:80px'>";
                    cadena+="<button class='btn btn-warning btn-sm' onclick='ocultarFila(this.parentNode.parentNode.rowIndex);'>";
                    cadena+="<span class='glyphicon glyphicon-remove-circle' aria-hidden='true'></span>";
                    cadena+="</button>";
                    cadena+="</td>";
                    cadena+="</tr>";
                    $("#tablaDetallePedidoGranel").append(cadena);
                }
                var tabla=document.getElementById('tablaDetallePedidoGranel'); 
                for(var x=1; x<tabla.rows.length; x++){
                    tabla.rows[x].style.display='none';
                }                
            }
        })        
    }

    function verNotaVenta(){
        $("#mdNotaVenta").modal('show');
    }

    function cerrarDetalleNotaVenta(){
        $("#mdNotaVenta").modal('hide');   
    }
    function agregarNuevoPedido(){

        var tabla = document.getElementById('tablaDetalle');
        var cadena='[';

        for (var i = 1; i < tabla.rows.length; i++){
             if(tabla.rows[i].cells[6].getElementsByTagName('input')[0].value!=""){
                cadena+='{';
                cadena+="'prod_codigo':'"+  tabla.rows[i].cells[0].innerHTML  + "', ";
                cadena+="'cantidad':'"+  tabla.rows[i].cells[3].innerHTML.trim()  + "', ";
                cadena+="'formula':'"+  tabla.rows[i].cells[1].innerHTML  + "', ";
                cadena+="'u_codigo':'"+  tabla.rows[i].cells[4].innerHTML  + "'";
                cadena+='}, ';
            }
        }

        cadena=cadena.slice(0,-2);
        cadena+=']';

        var ruta="agregarObra";

        $.ajax({
            url: ruta,
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { numeroNotaVenta: $("#txtNumeroCotizacion").val(),
                    detalle: cadena
                  },
            success:function(dato){
                $("#txtNombreContacto").val( $("#txtNombreContactoObra").val() );
                $("#txtCorreoContacto").val( $("#txtCorreoContactoObra").val() );
                $("#txtTelefono").val( $("#txtTelefonoObra").val() );
                cerrarNuevaObra();
            }
        })
    }