    var urlApp='http://localhost/';

    //var urlServicio='http://200.27.214.154:8080/';
    //var urlSitioAsp='http://200.27.214.154:8080/';
//Creamos la variable para detectar el navegador
    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
        // Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';
        // At least Safari 3+: "[object HTMLElementConstructor]"
    var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
        // Internet Explorer 6-11
    var isIE = /*@cc_on!@*/false || !!document.documentMode;
        // Edge 20+
    var isEdge = !isIE && !!window.StyleMedia;
        // Chrome 1+
    var isChrome = !!window.chrome && !!window.chrome.webstore;
        // Blink engine detection
    var isBlink = (isChrome || isOpera) && !!window.CSS;

    if(isIE || isEdge){
        console.log("Explorer");
    }else{
        console.log("otros navegadores");
    } 


  function number_format_currency(amount, decimals) {

      amount += ''; // por si pasan un numero en vez de un string
      amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

      decimals = decimals || 0; // por si la variable no fue fue pasada

      // si no es un numero o es igual a cero retorno el mismo cero
      if (isNaN(amount) || amount === 0) 
          return parseFloat(0).toFixed(decimals);

      // si es mayor o menor que cero retorno el valor formateado como numero
      amount = '' + amount.toFixed(decimals);

      var amount_parts = amount.split('.'),
          regexp = /(\d+)(\d{3})/;

      while (regexp.test(amount_parts[0]))
          amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');
      
      var numeroFormateado= '$ ' + amount_parts.join(',');
      

      return numeroFormateado;
  }

  function limpiarTabla(nombreTabla){
    $('#' + nombreTabla + ' tbody tr').remove();
  }

  function number_format(amount, decimals) {

      amount += ''; // por si pasan un numero en vez de un string
      amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

      decimals = decimals || 0; // por si la variable no fue fue pasada

      // si no es un numero o es igual a cero retorno el mismo cero
      if (isNaN(amount) || amount === 0) 
          return parseFloat(0).toFixed(decimals);

      // si es mayor o menor que cero retorno el valor formateado como numero
      amount = '' + amount.toFixed(decimals);

      var amount_parts = amount.split('.'),
          regexp = /(\d+)(\d{3})/;

      while (regexp.test(amount_parts[0]))
          amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');
      
      var numeroFormateado= amount_parts.join(',');
      

      return numeroFormateado;
  }

    function Validar(){
        var valido=false;
        $.ajax({
            url : urlServicio + "idkservicio/capaservicio.asmx/validarUsuario",
            data: { usuario: $("#Correo").val(),
                    clave: $("#contra").val()
                    }, 
            dataType: "json",
            method: "post",        
            success: function(dato){
                $(dato).each(function (idx, esp) {
                  valido=true;
                  sessionStorage.setItem('ctrProd_idUsuario', esp.idUsuario);
                  sessionStorage.setItem('ctrProd_idPerfil', esp.idPerfilUsuario);
                  sessionStorage.setItem('ctrProd_nombreUsuario', esp.nombreCompleto);
                  if(esp.areasAsignadas=='1'){
                    if(esp.idArea=='5'){
                      location.href="vistas/consultaOPenFabricacion.html?idArea=5";
                    }else if(esp.idArea=='7'){
                      location.href="vistas/listaOrdenesInstalacion.html";
                    }else{
                      location.href="vistas/consultaOrdenesProduccionPorArea.html?idArea="+ esp.idArea;
                    }
                    
                  }else{
                    location.href="menu.html";   
                  }
                     

                });
                if(!valido){
                  alert("Acceso Incorrecto");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                 alert("Acceso Incorrecto");
                }
        })

    }

    function home(){
        location.href="../menu.html";
    }    

    function usuarioAreas(idUsuario){
        if(sessionStorage.getItem('ctrProd_idPerfil')=='2'){
            document.getElementById("m1_3").style.display = "none";
            document.getElementById("m1_4").style.display = "none";
            document.getElementById("m2_1").style.display = "none";
            document.getElementById("m2_5").style.display = "none";
            document.getElementById("m2_6").style.display = "none";
        }
        if(sessionStorage.getItem('ctrProd_idPerfil')=='3'){
            document.getElementById("menuGerencia").style.display = "none";
            document.getElementById("menuInventario").style.display = "none";
            document.getElementById("menuInformes").style.display = "none";
        }  
        $.ajax({
            url : urlServicio + "idkservicio/capaservicio.asmx/UsuarioAreas",
            data: { idUsuario: idUsuario
                    }, 
            dataType: "json",
            method: "post",        
            success: function(dato){
                $(dato).each(function (idx, esp) {
                    if(esp.idAreaProduccion==7){
                        $("#procesos").append("<li>" + "<a href='vistas/listaOrdenesInstalacion.html'>" + esp.nombre +"</a>" + "</li>");
                    }else{
                      if(esp.idAreaProduccion==5){
                        $("#procesos").append("<li>" + "<a href='vistas/consultaOPenFabricacion.html?idArea="+ esp.idAreaProduccion + "'>" + esp.nombre +"</a>" + "</li>");
                      }else{
                        $("#procesos").append("<li>" + "<a href='vistas/consultaOrdenesProduccionPorArea.html?idArea="+ esp.idAreaProduccion + "'>" + esp.nombre +"</a>" + "</li>");
                      }                      
                    }


                    
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                 alert("Acceso Incorrecto");
                }
        })
     
    }

    function cerrarSesion(){
      sessionStorage.setItem("ctrProd_idUsuario","");
      sessionStorage.removeItem("ctrProd_idUsuario");
      location.href="index.html";
    }


    function isNumberKey(evt)
        {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if ( (charCode > 31 && (charCode < 48 || charCode > 57) ) && charCode!= 44 )
            return false;
 
         return true;
    }    

    function CerrarApp(){
      close();
    }

    function validarPatron(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8) return true; // 3
         if (tecla==9) return true; // 3
         if (tecla==11) return true; // 3
        patron = /[a-zA-Z0-9_+-]/; // 4
     
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
    }    

    function validarPatronFecha(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8) return true; // 3
         if (tecla==9) return true; // 3
         if (tecla==11) return true; // 3
        patron = /[0-9/-]/; // 4
     
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
    }    
    
    function formatoFecha(fechatexto){
       return fechatexto.substr(6,2) +"/"+fechatexto.substr(4,2) + "/" +fechatexto.substr(0,4);
    }

    function ImprimirDetalle(nombreDiv, titulo, subtitulo){
      var ficha = document.getElementById(nombreDiv);
      ventimp=window.open(' ','popimpr');
      var varHtml='';   
      varHtml = varHtml + "<h3>" + titulo + "</h3><h5>" + subtitulo + "</h5>";
      varHtml = varHtml + ficha.innerHTML;
      ventimp.document.write(varHtml);
      ventimp.document.close();
      ventimp.print();
      ventimp.close();   
    }

    function exportarExcel(tabla){
 
        window.open('data:application/vnd.ms-excel,base64,' + escape($(tabla).html()));
 
    }

    function exportarCsv(tabla, nombreArchivo){
        var tablehtml = document.getElementById(tabla).innerHTML;
        var datos="";
        var tablaPaso = document.getElementById(tabla);
        if ( isIE || isEdge){

            for (var i=0; i<tablaPaso.rows.length; i++) { 
              var tableRow = tablaPaso.rows[i]; var rowData = {}; 
              for (var j=0; j<tableRow.cells.length; j++) { 
                  datos = datos + tableRow.cells[j].innerHTML + ","; 
              } 
              datos.slice(0, datos.length - 1)       
              datos = datos + "\r\n"; 
            }             

        }else{
            datos = tablehtml.replace(/<thead>/g, '')
                             .replace(/<\/thead>/g, '')
                             .replace(/<tbody>/g, '')
                             .replace(/<\/tbody>/g, '')
                             .replace(/<tr>/g, '')
                             .replace(/<\/tr>/g, '\r\n')
                             .replace(/<th>/g, '')
                             .replace(/<\/th>/g, ';')
                             .replace(/<td>/g, '')
                             .replace(/<\/td>/g, ';')
                             .replace(/\t/g,'')
                             .replace(/\n/g, '');
            
        }      
     
        downloadCSV(datos, nombreArchivo);                                       
    }

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    
    
    if ( isIE || isEdge ){
          csv= "sep=,\r\n" + csv;
          csvFile = new Blob([csv]);
          navigator.msSaveOrOpenBlob(csvFile, filename + ".csv");
    }else{
        csvFile = new Blob([csv]); 
        // Download link
        downloadLink = document.createElement("a");

        // File name
        downloadLink.download = filename+".csv";

        // Create a link to the file
        downloadLink.href = window.URL.createObjectURL(csvFile);

        // Hide download link
        downloadLink.style.display = "none";

        // Add the link to DOM
        document.body.appendChild(downloadLink);

        // Click download link
        downloadLink.click();  
        document.body.removeChild(downloadLink);
    }


}    


    function exportarTabla(tabla, nombreArchivo){
          tabla.table2excel({
          // exclude CSS class
          exclude: ".noExl",
          name: "Worksheet Name",
          fileext: ".csv",
          filename: nombreArchivo //do not include extension
          });
    }

    function exportarTablaCSV(tabla, nombreArchivo){
        var tablehtml = document.getElementById(tabla).innerHTML;
        var datos="";
        var tablaPaso = document.getElementById(tabla);
        if ( isIE || isEdge){

            for (var i=0; i<tablaPaso.rows.length; i++) { 
              var tableRow = tablaPaso.rows[i]; var rowData = {}; 
              for (var j=0; j<tableRow.cells.length; j++) { 
                  datos = datos + tableRow.cells[j].innerHTML + ","; 
              } 
              datos.slice(0, datos.length - 1)       
              datos = datos + "\r\n"; 
            }             

        }else{
            datos = tablehtml.replace(/<thead>/g, '')
                             .replace(/<\/thead>/g, '')
                             .replace(/<tbody>/g, '')
                             .replace(/<\/tbody>/g, '')
                             .replace(/<tr>/g, '')
                             .replace(/<\/tr>/g, '\r\n')
                             .replace(/<th>/g, '')
                             .replace(/<\/th>/g, ';')
                             .replace(/<td>/g, '')
                             .replace(/<\/td>/g, ';')
                             .replace(/\t/g,'')
                             .replace(/\n/g, '');
            
        }      
     
        downloadCSV(datos, nombreArchivo);                                       
    }

    function tableToJson(table) { 
        var data = []; // first row needs to be headers var headers = []; 
        for (var i=0; i<table.rows[0].cells.length; i++) {
         headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi,''); 
        } 
        // go through cells 
        for (var i=1; i<table.rows.length; i++) { 
          var tableRow = table.rows[i]; var rowData = {}; 
          for (var j=0; j<tableRow.cells.length; j++) { 
             rowData[ headers[j] ] = tableRow.cells[j].innerHTML; 
          } 
          data.push(rowData); 
        } 
        return data; 
    }

    function borrarFila(){
        $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
        });
    }

    function $_GET(param)
    {
        /* Obtener la url completa */
        url = document.URL;
        /* Buscar a partir del signo de interrogación ? */
        url = String(url.match(/\?+.+/));
        /* limpiar la cadena quitándole el signo ? */
        url = url.replace("?", "");
        /* Crear un array con parametro=valor */
        url = url.split("&");

        /* 
        Recorrer el array url
        obtener el valor y dividirlo en dos partes a través del signo = 
        0 = parametro
        1 = valor
        Si el parámetro existe devolver su valor
        */
        x = 0;
        while (x < url.length)
        {
            p = url[x].split("=");
            if (p[0] == param)
                {
                return decodeURIComponent(p[1]);
                }
            x++;
        }
    }

    function volverAtras(){
      history.back();
    }


function validaCorreos(stringCorreos){
  var arrayCorreos=stringCorreos.split(";");
  expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
  var errores=0;
  for (var j=0; j<arrayCorreos.length; j++) {
    if(!expr.test( arrayCorreos[j].trim() )){
      errores+=1;
    } 
  } 
  if(errores>0){
    return false;
  }else{
    return true;
  }
}