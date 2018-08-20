    function nuevaObra(){
        $("#idObra").val("0");
        $("#filaObra").val("0");
        $("#txtNombreObra").val('');
        $("#txtDescripcionObra").val('');
        $("#txtNombreContactoObra").val('');
        $("#txtCorreoContactoObra").val('');
        $("#txtTelefonoObra").val('');
        $("#txtDistancia").val('');
        $("#txtTiempo").val('');
        $("#txtCostoFlete").val('');
        $("#codigoSoftland").val('');
        $("#mdNuevaObra").modal("show"); 
        document.getElementById('idCliente').selectedIndex=-1;
        $("#txtNombreObra").focus();
    }

    function editarObra(idObra, fila){
        $("#idObra").val(idObra);
        $("#filaObra").val(fila);
        $.ajax({
            url: urlApp + "datosObra",
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { 
                    idObra: idObra
                  },
            success:function(dato){
                $("#txtNombreObra").val(dato[0].nombre);
                $("#txtDescripcionObra").val(dato[0].descripcion);
                $("#txtNombreContactoObra").val(dato[0].nombreContacto);
                $("#txtCorreoContactoObra").val(dato[0].correoContacto);
                $("#txtTelefonoObra").val(dato[0].telefonoContacto);
                $("#txtDistancia").val(dato[0].distancia);
                $("#txtTiempo").val(dato[0].tiempo);
                $("#txtCostoFlete").val(dato[0].costoFlete);
                $("#codigoSoftland").val(dato[0].codigoSoftland)
                var sel=document.getElementById("idCliente");

                for(var x=0; x<sel.length; x++){
                    if(sel.options[x].value==dato[0].emp_codigo){
                        sel.selectedIndex=x;
                        break;
                    }
                }

                $("#mdNuevaObra").modal("show"); 
                $("#txtNombreObra").focus();
            }
        })         


    }


    function cerrarNuevaObra(){
        $("#mdNuevaObra").modal("hide");
    }

    function agregarNuevaObra(){

        if($("#txtNombreObra").val().trim()=='' || $("#txtNombreContactoObra").val().trim()=='' || $("#txtTelefonoObra").val().trim()=='' ){
            swal(
                {
                    title: 'Debe ingresar todos los datos exigidos (*).',
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


        var ruta= urlApp + "agregarObra";

        var distancia=$("#txtDistancia").val().trim();
        var tiempo=$("#txtTiempo").val().trim();
        var costoFlete=$("#txtCostoFlete").val().trim();

        if (distancia==''){ distancia="0";};
        if (tiempo==''){ tiempo="0";};
        if (costoFlete==''){ costoFlete="0";};


        $.ajax({
            url: ruta,
            headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
            type: 'POST',
            dataType: 'json',
            data: { 
                    idObra: $("#idObra").val(),
                    nombre: $("#txtNombreObra").val(), 
                    emp_codigo: $("#idCliente").val(),
                    nombreContacto: $("#txtNombreContactoObra").val(),
                    correoContacto: $("#txtCorreoContactoObra").val(),
                    telefonoContacto: $("#txtTelefonoObra").val(),
                    descripcion: $("#txtDescripcionObra").val(),
                    distancia: distancia.split(",").join("."),
                    tiempo: tiempo.split(",").join("."),
                    costoFlete: costoFlete.split(",").join("."),
                    codigoSoftland: $("#codigoSoftland").val()
                  },
            success:function(dato){
                    if($("#idObra").val()=="0"){
                        //nueva obra

                        var cadena="";

                        cadena+="<tr>";
                        cadena+="<td>"+$("#txtNombreObra").val()+"</td>";
                        cadena+="<td>"+$("#idCliente option:selected").html()+"</td>";
                        cadena+="<td>"+$("#txtDistancia").val()+"</td>";
                        cadena+="<td>"+$("#txtTiempo").val()+"</td>";
                        cadena+="<td>"+$("#txtCostoFlete").val()+"</td>";
                        cadena+="<td>"+$("#txtNombreContactoObra").val()+"</td>";
                        cadena+="<td>"+$("#codigoSoftland").val()+"</td>";
                        cadena+="<td>";
                        cadena+="<button class='btn btn-xs btn btn-warning' onclick='editarObra(" + dato.idObra +  ", this.parentNode.parentNode.rowIndex )'>Editar</button>";
                        cadena+="<button class='btn btn-xs btn btn-danger'>Eliminar</button>";
                        cadena+="</td>";                        
                        cadena+="</tr>";

                        $("#tabla").append(cadena);

                    }else{
                        //obra editada

                        var tabla=document.getElementById('tabla');
                        var fila=$("#filaObra").val();
                        tabla.rows[fila].cells[0].innerHTML=$("#txtNombreObra").val();
                        tabla.rows[fila].cells[1].innerHTML=$("#idCliente option:selected").html();
                        tabla.rows[fila].cells[2].innerHTML=$("#txtDistancia").val();
                        tabla.rows[fila].cells[3].innerHTML=$("#txtTiempo").val();
                        tabla.rows[fila].cells[4].innerHTML=$("#txtCostoFlete").val();
                        tabla.rows[fila].cells[5].innerHTML=$("#txtNombreContactoObra").val();
                        tabla.rows[fila].cells[6].innerHTML=$("#codigoSoftland").val();
                    }


                    cerrarNuevaObra();
            }
        })
    }