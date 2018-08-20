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
                    idObra: "0",
                    nombre: $("#txtNombreObra").val(), 
                    emp_codigo: $("#idCliente").val(),
                    nombreContacto: $("#txtNombreContactoObra").val(),
                    correoContacto: $("#txtCorreoContactoObra").val(),
                    telefonoContacto: $("#txtTelefonoObra").val(),
                    descripcion: $("#txtDescripcionObra").val(),
                    distancia: distancia.split(",").join("."),
                    tiempo: tiempo.split(",").join("."),
                    costoFlete: costoFlete.split(",").join(".")
                  },
            success:function(dato){
                $("#txtNombreContacto").val( $("#txtNombreContactoObra").val() );
                $("#txtCorreoContacto").val( $("#txtCorreoContactoObra").val() );
                $("#txtTelefono").val( $("#txtTelefonoObra").val() );
                $("#idObra").append("<option value='"  + dato.idObra + "'>" + $("#txtNombreObra").val() + "</option>");


                document.getElementById('idObra').selectedIndex=document.getElementById('idObra').length-1;

                cerrarNuevaObra();
            }
        })
    }