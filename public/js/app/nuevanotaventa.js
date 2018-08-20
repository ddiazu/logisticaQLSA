
    $(document).ready(function() {
        document.getElementById('idUsuarioEncargado').selectedIndex=-1;
    });        

    function datosCotizacion(){
        $("#btnDatosCotizacion").prop("disabled", true);

        $("#txtNombreCliente").val('');
        $("#txtFechaCotizacion").val('');
        $("#txtObra").val('');
        $("#idCliente").val('');
        $("#txtUsuarioCrea").val('');
        $("#txtUsuarioValida").val('');
        document.getElementById('idObra').selectedIndex=0;
        $("#txtNombreContacto").val('');
        $("#txtCorreoContacto").val('');
        $("#txtTelefono").val('');

        limpiarTabla('tablaDetalle');

        if( $("#txtNumeroCotizacion").val().trim()=='' || $("#txtAno").val().trim()=='') {
            $("#btnDatosCotizacion").prop("disabled", false);
            swal(
                {
                    title: 'Debe ingresar Nº Cotización y Año',
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
            return;            
        }


        var cadenaPlantas="<select class='form-control input-sm'>";
        var cadenaFormaEntrega="<select class='form-control input-sm'>";       

        $.ajax({
            async:false, 
            url: urlApp + 'datosCotizacion',
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { 
                    idCotizacion:  $("#txtNumeroCotizacion").val(),
                    ano: $("#txtAno").val()
                },
            success:function(dato){
                if(dato.length>0){
                    $("#txtNombreCliente").val(dato[0].emp_nombre);
                    $("#txtFechaCotizacion").val(dato[0].cot_fecha_creacion);
                    $("#txtObra").val(dato[0].cot_obra);
                    $("#idCliente").val( dato[0].emp_codigo );
                    $("#txtUsuarioCrea").val( dato[0].usuario_creacion );
                    $("#txtUsuarioValida").val( dato[0].usuario_validacion );
                }
            }
        }); 

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

        listarObras();

        $.ajax({
            async:false,
            url: urlApp + 'cotizacionProductos',
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { prod_codigo: $("#txtNumeroCotizacion").val(),
                    ano: $("#txtAno").val() },
            success:function(data){
                var cont=0;
                for(var x=0;x<data.length;x++){
                    cont++;
                    cadena="<tr>";
                    cadena+="<td>"+data[x].prod_codigo+"</td>";
                    if(data[x].requiere_diseno=="1"){
                       cadena+="<td>" + "<input class='form-control input-sm' type='text' maxlength='20'></td>"  
                   }else{
                       cadena+="<td>" + "<input class='form-control input-sm' type='text' maxlength='20' readonly></td>" 
                   }
                    

                    cadena+="<td>"+data[x].prod_nombre+"</td>";
                    cadena+="<td align='right' width='30px'><input class='form-control input-sm' value='"+data[x].cp_cantidad+"' maxlength='5' onkeypress='return isNumberKey(event)'></td>";
                    cadena+="<td>"+data[x].u_nombre+"</td>";
                    cadena+="<td align='right'>"+number_format(data[x].cp_precio,0)+"</td>";
                    cadena+="<td>"+data[x].cp_glosa_reajuste+"</td>";                 
                    cadena+="<td>" + cadenaPlantas + "</td>";
                    cadena+="<td>" + cadenaFormaEntrega + "</td>";
                    cadena+="</tr>";
                    $("#tablaDetalle").append(cadena);
                }


                if(cont==0){
                    swal(
                        {
                            title: 'No se encontró información del número y año de cotización solicitado',
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
            }
        }) 


        $("#btnDatosCotizacion").prop("disabled", false);       
    }

    function listarObras(){
        $("#idObra").empty();
        $("#idObra").append( '<option value="0"><b>SIN INFORMACION / RETIRA CLIENTE</b></option>');
        document.getElementById('idObra').selectIndex=0;
         $('#idTransaccion').prop('disabled', true); 
        var ruta= urlApp + "listarObras";
        $.ajax({
            async: false,
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

        if(document.getElementById('idObra').selectedIndex>0){
            var ruta= urlApp + "datosObra";
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
    }  


    function crearNotaVenta(){
        var cont=0;

        var tabla = document.getElementById('tablaDetalle');
        var cadena='[';
        var errorPlantaFormaEntrega=false;

        for (var i = 1; i < tabla.rows.length; i++){

            if (tabla.rows[i].cells[7].getElementsByTagName('select')[0].value=='0' || tabla.rows[i].cells[8].getElementsByTagName('select')[0].value=='0' ) {
                errorPlantaFormaEntrega=true;
                break;
            }



            cadena+='{';
            cadena+='"prod_codigo":"'+  tabla.rows[i].cells[0].innerHTML  + '", ';

            cadena+='"cantidad":"'+  tabla.rows[i].cells[3].getElementsByTagName('input')[0].value  + '", ';

            cadena+='"formula":"'+  tabla.rows[i].cells[1].getElementsByTagName('input')[0].value + '", ';
            cadena+='"u_codigo":"'+  tabla.rows[i].cells[4].innerHTML  + '", ';
            cadena+='"precio":"'+  tabla.rows[i].cells[5].innerHTML.replace('.','')  + '", ';
            cadena+='"idPlanta":"'+  tabla.rows[i].cells[7].getElementsByTagName('select')[0].value + '", ';
            cadena+='"idFormaEntrega":"'+  tabla.rows[i].cells[8].getElementsByTagName('select')[0].value + '"';
            cadena+='}, ';

        }

        if (errorPlantaFormaEntrega){
                swal(
                    {
                        title: 'Debe completar en todos las línea la Planta y Forma de Entrega',
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
                        return;
                    }
                )
                return;
        }
        
        cadena=cadena.slice(0,-2);
        cadena+=']';


        var ruta= urlApp + "grabarNuevaNotaVenta";
        $.ajax({
            url: ruta,
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { cot_numero: $("#txtNumeroCotizacion").val(),
                    cot_año: $("#txtAno").val(),
                    idObra: $("#idObra").val(),
                    observaciones: $("#txtObservaciones").val(),
                    contacto: $("#txtNombreContacto").val(),
                    correo: $("#txtCorreoContacto").val(),
                    telefono: $("#txtTelefono").val(),
                    ordenCompraCliente: $("#txtOrdenCompra").val(),
                    idUsuarioEncargado: $("#idUsuarioEncargado").val(),
                    detalle: cadena
                  },
            success:function(dato){
                    swal(
                        {
                            title: 'Se ha creado la Nota de Venta Nº ' + dato.identificador ,
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
                                location.href="listarNotasdeVenta";                               
                            }
                        }
                    )                   
            }
        })
    }