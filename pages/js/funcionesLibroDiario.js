//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------
//                           Estas funciones son del archivo diario.php
//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------




//Funcion Ajax que busca la cuenta por el codigo y lo muestra en el input text
        function buscarCuentaCodigo(str){

          if (str=="") {
            str=document.getElementById("codigo").value;
          }

          if (str==""){
            document.getElementById("inputcuenta").innerHTML="";
            return;
          }
          if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
        }else  {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("inputcuenta").innerHTML=xmlhttp.responseText;
          }
        }

              xmlhttp.open("GET","buscaCuenta.php?opcion=partida&codigo="+str,true);
              xmlhttp.send();


        }

        function limpiaCodigo(){
        	document.getElementById("codigo").value="";

        }


        function carga(){

           $.ajax({
            
            type:"POST",
        dataType:"html",
        contentType:false,
        processData:false,
        cache:false,
            url:"operaciones/operacionesPartida.php?opcion=cancelar",
            success:function(r)
            {
              
            }
        });
        }

        function agregarCuentaPartida(str,id){
            cargaCuentas("1");
          if (str==""){
            document.getElementById("tablaPartida").innerHTML="";
            return;
          }
          if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
        }else  {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("tablaPartida").innerHTML=xmlhttp.responseText;
          }
        }
          if (str=="agregar") {

           

            var codigoCuenta=document.getElementById("codigo").value;
            if(codigoCuenta==""){
              mostrarMensaje("Debe Seleccione una Cuenta","error",1000);
            }else{

               if (document.getElementById("idCuenta").value!="") {
              var bandera=document.getElementById("idCuenta").value;
             
            }else {
                var bandera=document.getElementById("bandera").value;
            }
            var nombreCuenta=document.getElementById("cuenta").value;
            var montoPartida=document.getElementById("monto").value;
            var opciones=document.getElementsByName("movimiento");
            var accion="";
            for (var i = 0; i < opciones.length; i++) {
              if (opciones[i].checked==true) {
                accion=opciones[i].value;
              }
            }

            if (codigoCuenta=="" || nombreCuenta==""|| montoPartida=="" || bandera=="" ) {
              mostrarMensaje("Por Favor Llene todos los datos.","warning",1500);
            }else {
              if (montoPartida <=0) {
                mostrarMensaje("Por Favor utilice numeros positivos.","warning",1500);
                document.getElementById("montoPartida").value="";
              }else {
                xmlhttp.open("GET","operaciones/operacionesPartida.php?codigo="+codigoCuenta+"&concepto="+nombreCuenta+"&monto="+montoPartida+"&movimiento="+accion+"&id="+bandera+"&opcion=agregar",true);
                xmlhttp.send();
                document.getElementById("codigo").value="";
                document.getElementById("cuenta").value="";
                document.getElementById("monto").value="";
                document.getElementById("bandera").value="";
              }
            }
          }
        }
          if (str=="quitar") {
              xmlhttp.open("GET","operaciones/operacionesPartida.php?id="+id+"&opcion="+str,true);
        xmlhttp.send();
          }
          if (str=="procesar") {
           
              xmlhttp.open("GET","operaciones/operacionesPartida.php?id="+id+"&opcion="+str,true);
        xmlhttp.send();
          }
          if (str=="mostrar") {
              xmlhttp.open("GET","operaciones/operacionesPartida.php?id="+id+"&opcion="+str,true);
        xmlhttp.send();
          }
        }



        function llenarDatos(codigo,id)
      {
        document.getElementById("codigo").value=codigo;
        document.getElementById("bandera").value=id;
      
        buscarCuentaCodigo(codigo);
      }

      function procPartida(){
        var concepto=document.getElementById("conceptoPartida").value;
        var fecha=document.getElementById("fechaPartida").value;
            if (fecha=="" || concepto=="" ) {
              mostrarMensaje("Debe Completar los campos","warning",1500);
             
            }
             else{
                  
                  $.ajax({
            
            type:"POST",
        dataType:"html",
        contentType:false,
        processData:false,
        cache:false,
            url:"operaciones/operacionesPartida.php?opcion=procesar&fecha='"+fecha+"'&concepto='"+concepto+"'",
            success:function(r)
            {
            
              
                if(r==1)
                    {
                     mostrarMensaje("La Partida se Guardo con exito","success",1500);
                     $("#myModal").modal("hide");
                     agregarCuentaPartida('mostrar',0);
                     //document.location.href="diario.php";

                    }else if(r==3){
                     mostrarMensaje("Error El Debe Es distinto Al Haber","error",2500);
                     $("#myModal").modal("hide");
                    }
                    else{
                        mostrarMensaje("Ocurrio un Error Al intentar Guardar la partida","error",1500);
                    } 
                
            }
        });
              }
           }
      function cancelarPartida(){
         $.ajax({
            
            type:"POST",
        dataType:"html",
        contentType:false,
        processData:false,
        cache:false,
            url:"operaciones/operacionesPartida.php?opcion=cancelar",
            success:function(r)
            {
              
                if(r==1)
                    {
                     /* $.post("operaciones/operacionesPartida.php",{opcion:"mostrar"},function(data){
                     $("#tablaPartida").html(data);
                        });
                        */

                       location.href='diario.php';
                    }
                
            }
        });
      }

 function cargaCuentas(str){
  var text=document.getElementById("busq").value;
      
            $.post("tablaCuenta.php",{busqueda:text,pagina:str},function(data){
                $("#tablaCuentas").html(data);
            });

        
      }

      function busquedaCuentas(){
        var str=document.getElementById("busq").value;
      
            $.post("tablaCuenta.php",{busqueda:str,pagina:1},function(data){
                $("#tablaCuentas").html(data);
            });

        
      }

    


//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------
//                           Estas funciones son del archivo verLibroDiario.php
//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------


//funcion que solicita mediante jquery los registros de las partidas a un documento externo
        function actualizaTabla(str){
        cargaCuentas("1");
            $.post("actualizatablaPartidas.php",{opcion:str},function(data){
                $("#tablapartidas").html(data);
            });

        }
function paginacion(str){
  var text=document.getElementById("busq").value;
      
            $.post("actualizatablaPartidas.php",{busqueda:text,pagina:str,opcion:"mostrar"},function(data){
                $("#tablapartidas").html(data);
            });

        
      }


      function cargaDetalles(str,idp){
       
         $.post("actualizatablaPartidas.php",{opcion:str,idpartida:idp},function(data){
                $("#formDetalle").html(data);
                 $("#miModalDetalle").modal("show");
            });

      }
function modificarPartida(idp){
 
          $.post("operaciones/operacionesPartida.php",{opcion:"cargaModifi",idpartida:idp},function(data){
                $("#tablaPartida").html(data);
            });

           $.post("operaciones/operacionesPartida.php",{opcion:"cargaDatosP",idpartida:idp},function(dat){
                
                $("#datosP").html(dat);
              

            });

          
          $("#miModalModificar").modal("show");

         

}

      function deletePartida(idp,tipo,num){

       if(num==1 && tipo==1){
            mostrarMensaje("No se puede eliminar la partida de inicio","warning",1500);
            
          }else{
              
               swal.fire({
                title: "Si continua se eliminara la cuenta",
                text:"¿Desea Continuar?",
                type:"warning",
                showCancelButton: true,
                cancelButtonText:"No",
                confirmButtonText:"Si",
               


            }).then((result)=>{
              if(result.value){
                

                 $.ajax({
            
            type:"POST",
        dataType:"html",
        contentType:false,
        processData:false,
        cache:false,
             url:"actualizaTablaPartidas.php?opcion=eliminar&idpartida='"+idp+"'",
            success:function(r)
            {
             if(r==1){
                       mostrarMensaje("Exito","success",1500);
                       $.post("actualizaTablaPartidas.php",{opcion:"detalle",idpartida:idp},function(data){
                       $("#formDetalle").html(data);
                 
                       });
                                
                    }else{
                       mostrarMensaje("Ocurrio un error inesperado","error",1500);

                    }
                
            }
        });
              }
            })

              

       
     }
   }

  



 function cancelarPartidaM(){
         $.ajax({
            
            type:"POST",
        dataType:"html",
        contentType:false,
        processData:false,
        cache:false,
            url:"operaciones/operacionesPartida.php?opcion=cancelar",
            success:function(r)
            {
              
                if(r==1)
                    {
                     /* $.post("operaciones/operacionesPartida.php",{opcion:"mostrar"},function(data){
                     $("#tablaPartida").html(data);
                        });
                        */

                          $.post("operaciones/operacionesPartida.php",{opcion:"mostrar",id:0},function(data){
                $("#tablaPartida").html(data);
            });
         

                       
                    }
                
            }
        });
      }

        function agregarCuentaPartidaM(str,id){
            cargaCuentas("1");
          if (str==""){
            document.getElementById("tablaPartida").innerHTML="";
            return;
          }
          if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
        }else  {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
          if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("tablaPartida").innerHTML=xmlhttp.responseText;
          }
        }
          if (str=="agregar") {

           

            var codigoCuenta=document.getElementById("codigo").value;
            if(codigoCuenta==""){
              mostrarMensaje("Debe Seleccione una Cuenta","error",1000);
            }else{

               if (document.getElementById("idCuenta").value!="") {
              var bandera=document.getElementById("idCuenta").value;
             
            }else {
                var bandera=document.getElementById("bandera").value;
            }
            var nombreCuenta=document.getElementById("cuenta").value;
            var montoPartida=document.getElementById("monto").value;
            var opciones=document.getElementsByName("movimiento");
            var accion="";
            for (var i = 0; i < opciones.length; i++) {
              if (opciones[i].checked==true) {
                accion=opciones[i].value;
              }
            }

            if (codigoCuenta=="" || nombreCuenta==""|| montoPartida=="" || bandera=="" ) {
              mostrarMensaje("Por Favor Llene todos los datos.","warning",1500);
            }else {
              if (montoPartida <=0) {
                mostrarMensaje("Por Favor utilice numeros positivos.","warning",1500);
                document.getElementById("montoPartida").value="";
              }else {
                xmlhttp.open("GET","operaciones/operacionesPartida.php?codigo="+codigoCuenta+"&concepto="+nombreCuenta+"&monto="+montoPartida+"&movimiento="+accion+"&id="+bandera+"&opcion=agregar",true);
                xmlhttp.send();
                document.getElementById("codigo").value="";
                document.getElementById("cuenta").value="";
                document.getElementById("monto").value="";
                document.getElementById("bandera").value="";
              }
            }
          }
        }
          if (str=="quitar") {
              xmlhttp.open("GET","operaciones/operacionesPartida.php?id="+id+"&opcion="+str,true);
        xmlhttp.send();
          }
          if (str=="procesar") {
           
              xmlhttp.open("GET","operaciones/operacionesPartida.php?id="+id+"&opcion="+str,true);
        xmlhttp.send();
          }
          if (str=="mostrar") {
              xmlhttp.open("GET","operaciones/operacionesPartida.php?id="+id+"&opcion="+str,true);
        xmlhttp.send();
          }
        }


 function modifiPartida(){
        var concepto=document.getElementById("conceptoPartida").value;
        var fecha=document.getElementById("fechaPartida").value;
            if (fecha=="" || concepto=="" ) {
              mostrarMensaje("Debe Completar los campos","warning",1500);
             
            }
             else{
                  
                  $.ajax({
            
            type:"POST",
        dataType:"html",
        contentType:false,
        processData:false,
        cache:false,
            url:"operaciones/operacionesPartida.php?opcion=modificar&fecha='"+fecha+"'&concepto='"+concepto+"'",
            success:function(r)
            {
          
              
                if(r==1)
                    {
                     mostrarMensaje("La Partida se Modifico con exito","success",1500);
                     $("#myModal").modal("hide");
                     agregarCuentaPartida('mostrar',0);
                     //document.location.href="diario.php";

                    }else if(r==3){
                     mostrarMensaje("Error El Debe Es distinto Al Haber","error",2500);
                     $("#myModal").modal("hide");
                    }
                    else{
                        mostrarMensaje("Ocurrio un Error Al intentar Guardar la partida","error",1500);
                    } 
                
            }
        });
              }
           }



  