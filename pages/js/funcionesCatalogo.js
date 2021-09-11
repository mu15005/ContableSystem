 function cargaCategorias(){
        $.post("pruebas.php",function(data){
        
                $("#formArbol").html(data);
              
               
            });
    }
	 function onGuardar(codi){



    if(codi==0){
      var codigo=document.getElementById('codigo').value;
      var nombre=document.getElementById('nombre').value;
    }else{
      var codigo=codi;
      var nombre=document.getElementById('nombr').value;
    }

        var nivel=document.getElementById('nivel').value;
        
        
        var saldo=document.getElementById('saldo').value;
        var tipo=document.getElementById('tipo').value;

       
        if(nivel=="" || codigo=="" || nombre==""  || saldo=="SELECCIONE" ||  tipo=="SELECCIONE"){
             mostrarMensaje("Debe Llenar todos los campos","warning",2000);
          }else{
               $.ajax({
            
            type:"POST",
        dataType:"html",
        contentType:false,
        processData:false,
        cache:false,
            url:"operaciones/operacionesCrud.php?opcion=guardar&nivel='"+nivel+"'&codigo='"+codigo+"'&nombre='"+nombre+"'&saldo='"+saldo+"'&tipo='"+tipo+"'",
            success:function(r)
            {
              
                if(r==1)

                    {

                      actualizaTabla("mostrar");
                     mostrarMensaje("Exito de registros","success",1000);
                      if(codi==0){
                     
                      $("#miModalNuevoR").modal("hide");
                      
                    }else{
                      $("#miModalSub").modal("hide");
                    }
                                
                    }else if(r==3){
                      mostrarMensaje("Ya existe una cuenta con el mismo Codigo","success",2000);

                    }
                    else{
                       mostrarMensaje("Errorsito","success",2000);

                    } 
                
            }
        });
          
        }
      }
        function onEditar(){
             var nivel=document.getElementById('nivel').value;
        var codigo=document.getElementById('codigo').value;
        var nombre=document.getElementById('nombre').value;
        var saldo=document.getElementById('saldo').value;
        var tipo=document.getElementById('tipo').value;


        if(nivel=="" || codigo=="" || nombre==""  || saldo=="SELECCIONE" ||  tipo=="SELECCIONE"){
             mostrarMensaje("Debe Llenar todos los campos","warning",3000);
          }else{
               $.ajax({
            
            type:"POST",
        dataType:"html",
        contentType:false,
        processData:false,
        cache:false,
            url:"operaciones/operacionesCrud.php?opcion=edit&nivel='"+nivel+"'&codigo='"+codigo+"'&nombre='"+nombre+"'&saldo='"+saldo+"'&tipo='"+tipo+"'",
            success:function(r)
            {
              
                if(r==1)
                    {
                      actualizaTabla("mostrar");
                      
                      mostrarMensaje("Registros Actualizado Con Exito","success",2000);
                      $("#miModalDetalles").modal("hide");
                                
                    }else if(r==3){
                      mostrarMensaje("Ya existe una cuenta con el mismo nombre","success",2000);

                    }
                    else{
                       mostrarMensaje("Ocurrio un Error","success",2000);

                    } 
                
            }
        });
          
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
                      actualizaTabla("mostrar");
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
        function actualizaTabla(str){
          cargaCategorias();
            $.post("actualizatabla.php",{opcion:str},function(data){
                $("#tablaCuenta").html(data);
            });

        }

function cargaDato(str,codigoC,componet){

    if(componet=="formC"){
     
            $.post("cargaDatosCuenta.php",{opcion:str,codigo:codigoC},function(data){
                $("#formNuevo").html(data);
                $("#miModalNuevoR").modal("show");

            });

        }else{
          if(str==0 && componet==0){
      
       $.post("cargaDatosCuenta.php",{opcion:"mostrar",codigo:codigoC},function(data){
                $("#formDetalle").html(data);
            });
    }else{
      
         $.post("cargaDatosCuenta.php",{opcion:str,codigo:codigoC},function(data){
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
function cargaSelect(tipo,saldo){
      switch(tipo){

        case "ACTIVO":$("#tipo option").eq(1).prop("selected",true);break;
               // case 'ACTIVO':$("#tipo option").eq(1).prop("selected",true);break;
                case "PASIVO":$("#tipo option").eq(2).prop("selected",true);break;
                case "PATRIMONIO Y RESERVAS":$("#tipo option").eq(3).prop("selected",true);break;
                case "CUENTAS DE RESULTADO DEUDOR":$("#tipo option").eq(4).prop("selected",true);break;
                case "CUENTAS DE RESULTADO ACREEDOR":$("#tipo option").eq(5).prop("selected",true);break;
                case "CUENTAS LIQUIDADORAS":$("#tipo option").eq(6).prop("selected",true);break;
              }

              switch(saldo){
                case 'Deudor':$("#saldo option[value=Deudor]").attr("selected",true);break;
                case 'Acreedor': $("#saldo option[value=Acreedor]").attr("selected",true);break;
                
              }
      }


      function cargaCuentas(str){
        
  var text=document.getElementById("busq").value;
      
            $.post("actualizaTabla.php",{busqueda:text,pagina:str,opcion:"mostrar"},function(data){
                $("#tablaCuenta").html(data);
            });

        
      }




      function busquedaCuentas(){
        var str=document.getElementById("busq").value;
      
            $.post("actualizaTabla.php",{busqueda:str,pagina:1,opcion:"mostrar"},function(data){
                $("#tablaCuenta").html(data);
            });

        
      }

       function busquedaCuentaSelect(){
        var str=document.getElementById("busq1").value;
      
            $.post("actualizaTabla.php",{busqueda:str,pagina:1},function(data){
                $("#formCarga").html(data);
            });

        
      }
         function onDelete(str){
            
            var dato = str;


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
            url:"operaciones/operacionesCrud.php?opcion=eliminar&codigo='"+str+"'",
            success:function(r)
            {
             if(r==1)
                    {
                      actualizaTabla("mostrar");
                      $("#miModalDetalles").modal("hide");
                      mostrarMensaje("Exitos","success",2000);

                                
                    }

                    else if(r==3)
                    {
                       $.post("actualizatabla.php",{opcion:"mostrarOnDelete",codigo:str},function(data){
                     $("#formCarga").html(data);
                        });
                      $("#miModalDetalles").modal("hide");
                       $("#miModalCarga").modal("show");
                       
                    }else if(r==4){
                         mostrarMensaje("No se pueden Eliminar Cuentas Padre","success",2000);
                    }else{
                       mostrarMensaje("Ocurrio un error inesperado","success",2000);

                    }
                
            }
        });
              }
            })

              

        
        }
        function cargaCuentaSelect(str,cod){
  var text=document.getElementById("busq1").value;
      
            $.post("actualizaTabla.php",{busqueda:text,pagina:str,opcion:"mostrarOnDelete",codigo:cod},function(data){
                $("#formCarga").html(data);
            });

        
      }

      function verArbol(){

       cargaCategorias();
       $("#miModalArbol").modal("show");

      }