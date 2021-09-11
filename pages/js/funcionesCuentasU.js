 function cargaCategorias(){
        $.post("pruebas.php",function(data){
        
                $("#formArbol").html(data);
              
               
            });
    }
	 function onGuardar(){

   
   
      
 var formData = new FormData(document.getElementById("formulario"));
            //formData.append("dato", "valor");
            //formData.append(f.attr("name"), $(this)[0].files[0]);

                  var nombre=document.getElementById("nombre").value;
            var clave=document.getElementById("clave").value;
            var clave1=document.getElementById("clave1").value;
            var fotop=document.getElementById("fotop").value;
          

         
            if(nombre=="" || clave=="" || clave1=="" || fotop==null ){
              mostrarMensaje("Debe Completar Todos Los Campos","error",1500);
            }else{
                if(clave1!=clave){
                  mostrarMensaje("Las Contraseñas No Coinciden","error",1500);
                   }else{
               $.ajax({
                url: "operaciones/operacionesCuentasUsuario.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
       processData: false
            })
                .done(function(res){
                  
                     if(res==1){
                        mostrarMensaje("Exito","success",1000);
                        $("#miModalNuevoR").modal("hide");
                        actualizaTabla();
                     }else{
                      mostrarMensaje("Ocurrio un Erro Inesperado","error",1500);
                     }
                });

               }
            }

          
        }
      
       function onModificar(){

   
   
      
 var formData = new FormData(document.getElementById("formula"));
            //formData.append("dato", "valor");
            //formData.append(f.attr("name"), $(this)[0].files[0]);

                  var nombre=document.getElementById("nombre").value;
            var clave=document.getElementById("clave").value;
            var clave1=document.getElementById("clave1").value;
            var fotop=document.getElementById("fotop").value;
          
          
          
            if(nombre=="" || clave=="" || clave1=="" || fotop==null ){
              mostrarMensaje("Debe Completar Todos Los Campos","error",1500);
            }else{
                if(clave1!=clave){
                  mostrarMensaje("Las Contraseñas No Coinciden","error",1500);
                   }else{
               $.ajax({
                url: "operaciones/operacionesCuentasUsuario.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
       processData: false
            })
                .done(function(res){
              
                     if(res==1){
                        mostrarMensaje("Exito","success",1000);
                        $("#miModalDetalles").modal("hide");
                        actualizaTabla();
                     }else{
                      mostrarMensaje("Ocurrio un Erro Inesperado","error",1500);
                     }
                });

               }
            }

          
        }
        function onReemplazar(cuentaAntigua,cuentaNueva){
          $.ajax({
            
            type:"POST",
        dataType:"html",
        contentType:false,
        processData:false,
        cache:false,
            url:"operaciones/operacionesCrud.php?opcion=eliminar&cuentaAntigua='"+cuentaAntigua+"'&cuentaNueva='"+cuentaNueva+"'",
            success:function(r)
            {
              
                 if(r==1)
                    {
                      actualizaTabla();
                      $("#miModalCarga").modal("hide");
                      mostrarMensaje("Exitos","success",2000);

                                
                    }
                    else{
                       mostrarMensaje("Error","success",2000);

                    }
                
            }
        });


        }
		function generaNivel(opcion){

            if(opcion=="padre"){//si la opcion es padre significa que se esta creando un
              //registro desde 
              var codigo=document.getElementById('codigo').value.split("");
            var nivel=document.getElementById('codigo').value.split("");
            var tamCodigoPadre=0;
          }else{
            //sino significa que se esta creando una subcuenta por lo que el valor 
            //calculado dependera de otro input
            
            var codigo=document.getElementById('subcodigo').value.split("");
            var nivel=document.getElementById('subcodigo').value.split("");
            var codigoA=document.getElementById('codigo').value.split("");
            var tamCodigoPadre=0;
            //se calcula el nivel de la cuenta padre para poder sumarselo al nivel de 
            // la cuenta hija posteriormente
            for(var i=0;i < codigoA.length ;i++){
                if(codigoA[i]==='0'){
                    tamCodigoPadre--;
                }
                tamCodigoPadre++;
            }

          }
            
            var cadena="";
            //indice funciona como bandera para determinar si un elemento del codigo debe eliminarse por ejemplo espacion o cualquier otro caracter no valido

             var indice=-1;
            var cont=0;
            if(opcion=="padre"){// si la opcion es padre se seleeciona un tipo automaticamente dependiendo el primer caracter del codigo en el caso de 
            //las hijas el tipo esta definido por el de la clase padre 
              if(codigo.length>0){
              switch(codigo[0]){
                case '1':$("#tipo option").eq(1).prop("selected",true);break;
                case '2':$("#tipo option").eq(2).prop("selected",true);break;
                case '3':$("#tipo option").eq(3).prop("selected",true);break;
                case '4':$("#tipo option").eq(4).prop("selected",true);break;
                case '5':$("#tipo option").eq(5).prop("selected",true);break;
                case '6':$("#tipo option").eq(6).prop("selected",true);break;
                
              }
            }else{
              $("#tipo option").eq(0).prop("selected",true);
            }

            //si la primera posicion del codigo padre es cero se debe eliminar
             if(nivel[0]==='0'){
              indice=0;
            }
            }

            // se calcula el nivel de la cuenta padre o la clase hija esto depende de la condicion del inicio
            for(var i=0;i < nivel.length ;i++){
                if(nivel[i]==='0'){
                    cont--;
                }
                cont++;
            }

            //este for recorre el vector en busca de caractenes no permitidos
            for(var i=0;i < nivel.length ;i++){
                
                  if(isNaN(nivel[i]) || nivel[i]===' '){
                    cont--;
                    mostrarMensaje("El Codigo debe tener solo numeros","error",1500);
                    indice=i;
                }
                //si indice es mayor a -1 significa que se encontro un elemento que debe eliminarse
                if(indice>-1){
                 for(var i=0;i < nivel.length ;i++){
                    if(i!=indice){
                      cadena+=nivel[i];
                    }
                  }
              if(opcion=="padre"){//este if sirve para asignar la cadena ya validad al input de codigo o al de subcodigo 
                                document.getElementById('codigo').value=cadena;
                              }else{
                                
                                document.getElementById('subcodigo').value=cadena;
                              }

                }

                
                
            }

            //este if sirve para validar que solo se ingresen dos elementos como maximo en caso que se este creando una sub cuenta
            
            if(nivel.length>2 && opcion=="hija"){
              cadena="";
              cont--;
              //este for sirve para limpiar los elementos sobrantes
              for(var i=0;i <2 ;i++){
                   
                      cadena+=nivel[i];
                    
                  }
                   document.getElementById('subcodigo').value=cadena;
                  //este if sirve para garantizar la integridad del nivel
                   if(nivel[0]=='0'){
                    cont=1;
                   }else{
                    cont=2;
                   }
            }
            
           //se asigna el nivel calculado  a su respectivo input
           if(cont==0){
            
                  document.getElementById('nivel').value="";
           }else{
            //el tamcodigoPadre se inicializa en cero por lo que si se esta creando una cuenta
            //padre no afecta el calculo del nivel solo cambia su valor cuando se crea una subcuenta
            cont+=tamCodigoPadre;
              document.getElementById('nivel').value=cont;
              
           }
               
        
      
		}
        
//funcion que solicita mediante jquery los registros de las cuentas a un documento externo
        function actualizaTabla(){
          //cargaCategorias();
            $.post("operaciones/operacionesCuentasUsuario.php",{opcion:"impresion"},function(data){
                $("#tablaCuenta").html(data);
            });

        }

function cargaDato(str,codigoC,componet){

    if(componet=="formC"){
            $.post("operaciones/operacionesCuentasUsuario.php",{opcion:str,idusuario:codigoC},function(data){
                $("#formNuevo").html(data);


            });

        }else{

          if(str==0 && componet==0){
     
       $.post("operaciones/operacionesCuentasUsuario.php",{opcion:"mostrar",idusuario:codigoC},function(data){
                $("#formDetalle").html(data);
            });
    }else{
         $.post("operaciones/operacionesCuentasUsuario.php",{opcion:str,idusuario:codigoC},function(data){
                $("#formDetalle").html(data);
            });

    }

        }
}
function cargaDatoSubCuenta(codigoC){
   
document.getElementById("formNuevo").innerHTML="";
document.getElementById("formDetalle").innerHTML="";

            $.post("cargaDatosCuenta.php",{opcion:"subcuenta",codigo:codigoC},function(data){
                $("#formSubCuenta").html(data);


            });
 
}
function onPreparaSubCuenta(){
  var codigo=document.getElementById('codigo').value.split("");
  var subcodigo=document.getElementById('subcodigo').value.split("");
  var codi="";
  for(var i=0;i<codigo.length;i++){
    codi+=codigo[i];
  }
  for(var i=0;i<subcodigo.length;i++){
    codi+=subcodigo[i];
  }

  onGuardar(codi);
}
function cargaSelect(acceso){
      switch(acceso){

        case "0":$("#acceso option").eq(1).prop("selected",true);break;
               // case 'ACTIVO':$("#tipo option").eq(1).prop("selected",true);break;
                case "1":$("#acceso option").eq(2).prop("selected",true);break;
               
              }

             
      }


      function cargaCuentas(str){
        
  var text=document.getElementById("busq").value;
      
            $.post("operaciones/operacionesCuentasUsuario.php",{busqueda:text,pagina:str,opcion:"impresion"},function(data){
                $("#tablaCuenta").html(data);
            });

        
      }




      function busquedaCuentas(){
        var str=document.getElementById("busq").value;
      
            $.post("operaciones/operacionesCuentasUsuario.php",{busqueda:str,pagina:1,opcion:"impresion"},function(data){
                $("#tablaCuenta").html(data);
            });

        
      }

       function busquedaCuentaSelect(){
        var str=document.getElementById("busq1").value;
      
            $.post("actualizaTabla.php",{busqueda:str,pagina:1},function(data){
                $("#formCarga").html(data);
            });

        
      }
         function onDelete(){
            
            document.getElementById("band").value="eliminar";
           
          var formData = new FormData(document.getElementById("formula"));
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
            
           url: "operaciones/operacionesCuentasUsuario.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
       processData: false,
            success:function(r)
            {
           
             if(r==1)
                    {
                      actualizaTabla();
                      $("#miModalDetalles").modal("hide");
                      mostrarMensaje("Exitos","success",2000);

                                
                    }else{
                       mostrarMensaje("Ocurrio un error inesperado","error",2000);

                    }
                
            }
        });
              }
            })

              

        
        }
 
