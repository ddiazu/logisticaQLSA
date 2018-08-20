var arrCamiones=new Array();
var arrConductores=new Array();



function cargarListas(idEmpresaTransporte, fila){
    var tabla=document.getElementById("tablaDetalle");
    var selConductor = tabla.rows[fila].cells[8].getElementsByTagName("select")[0];
    selConductor.length=0; 
    var selCamion = tabla.rows[fila].cells[7].getElementsByTagName("select")[0];
    selCamion.length=0; 

    empresaConductores(idEmpresaTransporte, fila, selConductor);
    empresaCamiones(idEmpresaTransporte, fila, selCamion);
  
}

function agregarNota(){
    if($("#txtNota").val().trim()==''){
        swal(
            {
                title: 'La nota no puede estar en blanco!' ,
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
                return
            }
        )          
        return;
    }
    $.ajax({
        url: urlApp + "agregarNota",
        headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
        type: 'POST',
        dataType: 'json',
        data: { idPedido: $("#idPedido").val(),
                nota: $("#txtNota").val()
              },
        success:function(dato){
            cadena="<tr>";
            cadena+="<td>" + dato[0].fechaHora + "</td>";
            cadena+="<td>" + dato[0].nombreUsuario + "</td>";
            cadena+="<td>" + $("#txtNota").val() + "</td>";
            cadena+="<td>" + "<button class='btn btn-warning btn-sm' onclick='eliminarNota(" + dato[0].idNota + ", this.parentNode.parentNode.rowIndex)'>Eliminar</button></td>";
            cadena+="</tr>";
            $("#tablaNotas").append(cadena);
            $("#txtNota").val('');
            $("#contNotas").html(document.getElementById('tablaNotas').rows.length-1);
        }
    })
}

function eliminarNota(idNota, fila){
    $.ajax({
        url: urlApp + "eliminarNota",
        headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
        type: 'POST',
        dataType: 'json',
        data: { idNota: idNota
              },
        success:function(dato){
            document.getElementById('tablaNotas').deleteRow(fila);
            swal(
                {
                    title: 'La nota ha sido eliminada!' ,
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
                    return
                }
            )
        }
    })    
}

function empresaConductores(idEmpresaTransporte, fila, selConductor){

    for(var x=0;x<arrConductores.length;x++){
        if(arrConductores[x][0]==idEmpresaTransporte){
            var opt = document.createElement('option');
            opt.value = arrConductores[x][1];
            opt.innerHTML = arrConductores[x][2]+' '+arrConductores[x][3]+' ' +arrConductores[x][4];
            if(idConductor==arrConductores[x][1]){
                opt.selected=true;
            }else{
                opt.selected=false;
            }
            selConductor.appendChild(opt);
        }
    } 
}

function empresaCamiones(idEmpresaTransporte, fila, selCamion){
    for(var x=0;x<arrCamiones.length;x++){
        if(arrCamiones[x][0]==idEmpresaTransporte){
            var opt = document.createElement('option');
            opt.value = arrCamiones[x][1];
            opt.innerHTML = arrCamiones[x][2];
            if(idCamion==arrCamiones[x][1]){
                opt.selected=true;
            }else{
                opt.selected=false;
            }                                
            selCamion.appendChild(opt);
        }
    }        
}


function guardarDatosProgramacion(idPedido, origen){
    var tabla = document.getElementById('tablaDetalle');
    var cadena='[';

    for (var i = 1; i < tabla.rows.length; i++){
        fechaCarga='';
        horaCarga='';
        peso="0";
        idTransporte='0';
        idCamion="0";
        idConductor="0";

        if( tabla.rows[i].cells[5].innerHTML.trim()!="Retira"  ){
            idTransporte=tabla.rows[i].cells[6].getElementsByTagName('select')[0].value;
            idCamion=tabla.rows[i].cells[7].getElementsByTagName('select')[0].value;
            idConductor=tabla.rows[i].cells[8].getElementsByTagName('select')[0].value;
            if(tabla.rows[i].cells[9].getElementsByTagName('input')[0].value.trim() !='' ){
                fechaCarga=fechaAtexto(  tabla.rows[i].cells[9].getElementsByTagName('input')[0].value );
            }
            if(tabla.rows[i].cells[10].getElementsByTagName('input')[0].value.trim()!=''){
                horaCarga=tabla.rows[i].cells[10].getElementsByTagName('input')[0].value;  
            }

        }
 
        if(tabla.rows[i].cells[11].getElementsByTagName('input')[0].value!=''){
            peso=tabla.rows[i].cells[11].getElementsByTagName('input')[0].value.replace(",", ".");
        }

        cadena+='{';
        cadena+='"prod_codigo":"'+  tabla.rows[i].cells[0].innerHTML.trim()  + '", ';
        cadena+='"idEmpresaTransporte":"'+ idTransporte + '", ';
        cadena+='"idCamion":"'+ idCamion + '", ';
        cadena+='"idConductor":"'+  idConductor + '", ';
        cadena+='"peso":"'+  peso + '", ';
        cadena+='"fechaCarga":"'+ fechaCarga  + '", ';
        cadena+='"horaCarga":"'+ horaCarga + '"';
        cadena+='}, ';

    }  
    cadena=cadena.slice(0,-2);
    cadena+=']';

    var ruta= urlApp + "guardarDatosProgramacion";
    $.ajax({
        async: false, 
        url: ruta,
        headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
        type: 'POST',
        dataType: 'json',
        data: { idPedido: idPedido,
                detalle: cadena
              },
        success:function(dato){
            if(origen==1){
                swal(
                    {
                        title: 'Se han guardado los datos de Programación' ,
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
                            location.href=urlApp+"programacion";                               
                        }
                    }
                )
            }                   
        }
    })

}

function asignarFolio(){

    guardarDatosProgramacion( $("#idPedido").val() , 2);


    var tabla=document.getElementById('tablaDetalle');

    var retira=false;
    var enObra=false;
    var cantidadRealVacia=false;
    var chequeaDatosTransporte='';
    var cont=0;
    var compara='';
    console.log(10);
    for (var i = 1; i < tabla.rows.length; i++){
        if(tabla.rows[i].cells[12].getElementsByTagName('input')[0].checked){
            compara = tabla.rows[i].cells[6].getElementsByTagName('select')[0].value.trim()+"|"+
                      tabla.rows[i].cells[7].getElementsByTagName('select')[0].value.trim()+"|"+
                      tabla.rows[i].cells[8].getElementsByTagName('select')[0].value.trim();
            if( chequeaDatosTransporte!=compara){
                chequeaDatosTransporte=compara;
                cont+=1;
            }

            if(tabla.rows[i].cells[6].getElementsByTagName('select')[0].selectedIndex<0 || tabla.rows[i].cells[7].getElementsByTagName('select')[0].selectedIndex<0 ||
                tabla.rows[i].cells[8].getElementsByTagName('select')[0].selectedIndex<0 ){
                alert('Los productos seleccionados deben tener los datos de transporte completo.');
                return
            }

            if(tabla.rows[i].cells[5].innerHTML.trim()=='Retira'){
                retira=true;
            }else{
                enObra=true;
            }
            if(tabla.rows[i].cells[11].getElementsByTagName('input')[0].value.trim()=='' || parseFloat(tabla.rows[i].cells[11].getElementsByTagName('input')[0].value.trim())==0){
                cantidadRealVacia=true;
            }
        } 
    }

    if(cont>1){
        alert('Los productos seleccionados para incluir en la guía deben tener los mismos datos de transporte.');
        return;
    }else if(cont==0){
        alert('No hay productos seleccionados para generar la guía.');
        return;        
    }

    if(retira && enObra){
        alert('No puede emitir una guía con productos retirados por cliente y otros entregados en obra');
        return;
    }

    if(cantidadRealVacia){
        alert('Falta la cantidad real en uno de los productos seleccionados para incluir en la guía');
        return;
    }

    var cadena='[';

    for (var i = 1; i < tabla.rows.length; i++){
        if(tabla.rows[i].cells[11].getElementsByTagName('input')[0].value!=""){

            if(parseFloat(tabla.rows[i].cells[11].getElementsByTagName('input')[0].value)>0){
                cadena+='{';
                cadena+='"idPedido":"'+  $("#idPedido").val()  + '", ';
                cadena+='"prod_codigo":"'+  tabla.rows[i].cells[0].innerHTML.trim()  + '", ';
                cadena+='"unidad":"'+  tabla.rows[i].cells[3].innerHTML.trim()  + '", ';
                cadena+='"cantidad":"'+  tabla.rows[i].cells[11].getElementsByTagName('input')[0].value.replace(",", ".") + '"';
                cadena+='}, ';                
            }
                
        }
    }

    cadena=cadena.slice(0,-2);
    cadena+=']';

    $.ajax({
        url: urlApp + "crearGuiaDespachoElectronica",
        headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
        type: 'POST',
        dataType: 'json',
        data: { idPedido: $("#idPedido").val() ,
                detalle: cadena
              },
        success:function(dato){
                for (var i = 1; i < tabla.rows.length; i++){
                    if(tabla.rows[i].cells[12].getElementsByTagName('input')[0].checked){

                       tabla.rows[i].cells[12].innerHTML="<button class='btn btn-success btn-xs' onclick='abrirGuia(1001);'>" + dato.nuevaGuia +"</button>"; 

                    } 
                }        
                    
                swal(
                    {
                        title: 'Se ha creado la Guía º ' + dato.nuevaGuia + ', debe completar los datos necesarios antes de ser enviada definitivamente al Cliente.' ,
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
                            return                            
                        }
                    }
                )                   
        }
    })



}

function abrirGuia(tipoGuia, numeroGuia, fila){
    var tabla=document.getElementById('tablaDetalle');
    if( tipoGuia==1){
        $("#tipoGuia").val('Electronica');
    }else{
        $("#tipoGuia").val('Manual');
    }
    $("#numeroGuia").val(numeroGuia);
    $("#guiaPatente").val( tabla.rows[fila].cells[7].innerHTML );
    $("#guiaNombreConductor").val( tabla.rows[fila].cells[8].innerHTML );

    $.ajax({
        url: urlApp + "datosGuiaDespacho",
        headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
        type: 'POST',
        dataType: 'json',
        data: { tipoGuia: tipoGuia ,
                numeroGuia: numeroGuia
              },
        success:function(dato){
            $("#sellos").val(dato[0].sellos);
            $("#temperatura").val(dato[0].temperaturaCarga);
            $("#observacionDespacho").val(dato[0].observaciones);
            $("#mdGuia").modal("show");      
        }
    }) 
}

function cerrarCajaGuia(){
    $("#mdGuia").modal("hide");
}

function generarArchivoGuiaDespacho(){
    var tipo='';
    if( $("#tipoGuia").val()=='Electronica') {
        tipo="1";
    }else{
        tipo="2";
    }
    $.ajax({
        url: urlApp + "generarArchivoGuiaDespacho",
        headers: { 'X-CSRF-TOKEN' : $("#_token").val() },
        type: 'POST',
        dataType: 'json',
        data: { tipoGuia: tipo ,
                numeroGuia: $("#numeroGuia").val(),
                sellos: $("#sellos").val(),
                temperaturaCarga: $("#temperatura").val(),
                patente: $("#guiaPatente").val(),
                nombreConductor: $("#guiaNombreConductor").val(),
                observaciones: $("#observacionDespacho").val()
              },
        success:function(dato){
   
                    
                swal(
                    {
                        title: 'Se ha enviado la Guía Electronica.' ,
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
                            cerrarCajaGuia();
                            return                            
                        }
                    }
                )                   
        }
    })    
}