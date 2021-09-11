

 function mostrarMensaje(titulo, tipo, tiempo){
                swal({
                    position: 'top-end',
                    type: tipo,
                    title: titulo,
                    showConfirmButton: false,
                    timer: tiempo
                })
            }


            function onNoCierre(){
              mostrarMensaje("Existen Periodos Anteriores Con Cambios No Guardados<br>Guardelos Antes De Continuar","warning",2000);
            }
      function onCierre(){

           swal.fire({
                title: "Se procedera a realizar el Cierre del Ejercicio",
                text:"¿Desea Continuar?",
                type:"warning",
                showCancelButton: true,
                cancelButtonText:"No",
                confirmButtonText:"Si",
               


            }).then((result)=>{
              if(result.value){
                
                 swal({
              title: "Inventario Final",
        input: "text",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        inputValidator: nombre => {
            // Si el valor es válido, debes regresar undefined. Si no, una cadena
            if (!nombre || isNaN(nombre)) {
                return "Por Favor Ingresar Un Monto Valido";
            } else {
                return undefined;
            }
        }


            })
    .then(resultado => {
        if (resultado.value) {
            let nombre = resultado.value;
            $.post("CierreCorregido.php",{if:nombre},function(data){
              
               if(data==1){
              
                mostrarMensaje("Exitoss","success",1000);
                document.location.href="verLibroDiario.php";

               }else{
                mostrarMensaje("Ocurrio un Error inesperado","error",1000);
               }
            });
        }
    });
              }
            })

      }  
      function onProcesar(){
        if(document.getElementById('if').value==""){
            mostrarMensaje("El Inventario Final No puede Estar Vacio","error",1000);
        }else{
             $("#miModalInventario").modal("hide");




                 $.ajax({
            
            type:"POST",
        dataType:"html",
        contentType:false,
        processData:false,
        cache:false,
            url:"CierreCorregido.php",
            success:function(r)
            {
             if(r==1)
                    {
                      
                      mostrarMensaje("Exitos","success",1.5);

                                
                    }

                    else if(r==3)
                    {
                        mostrarMensaje("El catalogo de cuentas esta Incompleto ","error",2000);
                       
                    }else{
                       mostrarMensaje("Ocurrio un error inesperado","error",2000);

                    }
                
            }
        });
        }
      } 

      function pideIF(opcion,Pcierre){
        
        if(opcion=="estado"){
            if(Pcierre=="0"){

               swal({
              title: "Inventario Final",
        input: "text",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        inputValidator: nombre => {
            // Si el valor es válido, debes regresar undefined. Si no, una cadena
            if (!nombre || isNaN(nombre)) {
                return "Por Favor Ingresar Un Monto Valido";
            } else {
                return undefined;
            }
        }


            })
    .then(resultado => {
        if (resultado.value) {
            let nombre = resultado.value;
            document.location.href="estado.php?if="+nombre;
        }
    });
        
  }else{
    document.location.href="estado.php";
  }

        }else if(opcion=="balance"){
             if(Pcierre=="0"){
               swal({
              title: "Inventario Final",
        input: "text",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        inputValidator: nombre => {
            // Si el valor es válido, debes regresar undefined. Si no, una cadena
            if (!nombre || isNaN(nombre)) {
                return "Por Favor Ingresar Un Monto Valido";
            } else {
                return undefined;
            }
        }


            })
    .then(resultado => {
        if (resultado.value) {
            let nombre = resultado.value;
            document.location.href="balanza.php?if="+nombre;
        }
    });
  }else{
     document.location.href="balanza.php";
  }
        

        }
      }

      function onBalance(){
        if(document.getElementById('ifB').value==""){
            mostrarMensaje("El Inventario Final No puede Estar Vacio","error",1000);
        }else{
             $("#miModalInventarioB").modal("hide");
              document.location.href="balanza.php?if="+document.getElementById("ifB").value;


        }
      }

      function onEstado(){
        if(document.getElementById('ifE').value==""){
            mostrarMensaje("El Inventario Final No puede Estar Vacio","error",1000);
        }else{
             $("#miModalInventarioE").modal("hide");
            document.location.href="estado.php?if="+document.getElementById("ifE").value;



                
        }
      }
function configuraLoading(screen){
  $(document).ajaxStart(function(){
    screen.fadeIn();
  }).ajaxStop(function(){
    screen.fadeOut();
  });
}

$(document).ready(function(){
  var screen=$("#loading-screen");
  configuraLoading(screen);

})
            

            function onSalir(){
     
     
         $.post("opcionesRegistro.php",{opcion:"salir"},function(data){
               if(data==1){
                document.location.href="index.php";
              
               }
            });
      
    }   


     function actualizaTabla(str){
          cargaCategorias();
            $.post("actualizatabla.php",{opcion:str},function(data){
                $("#tablaCuenta").html(data);
            });

        }


    //--------------------------------------------------------------------------------------------------------------
    //funciones de la vista periodo
    //--------------------------------------------------------------------------------------------------------
    