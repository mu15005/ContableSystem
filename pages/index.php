<?php 
  session_start();
 ?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Registration Form</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">

   <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/funciones.js"></script>
    <script src="sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="sweetalert/sweetalert2.min.css">

    <script type="text/javascript">
        
  function cargaDatos(){
     $.post("opcionesRegistro.php",function(data){
                $("#contenido").html(data);
            });
  }
    function onLogin(){
     
      var nom=document.getElementById("nombre").value;
      var cla=document.getElementById("clave").value;
      if(nom=="" || cla==""){
        mostrarMensaje("Debe Completar Los Campos","error",1000);
      }else{
         $.post("opcionesRegistro.php",{opcion:"login",nombre:nom,clave:cla},function(data){
               if(data==1){
                document.location.href="inicio.php";
               
               }else{
                mostrarMensaje("Usuario O Contraseña Invalidos","error",1000);
                var nom=document.getElementById("nombre").value="";
      var cla=document.getElementById("clave").value="";
               }
            });
      }

    }       
          
          function onGuardar(){
           var formData = new FormData(document.getElementById("formulario"));
            //formData.append("dato", "valor");
            //formData.append(f.attr("name"), $(this)[0].files[0]);

                  var nombre=document.getElementById("nombre").value;
            var clave=document.getElementById("clave").value;
            var clave1=document.getElementById("clave1").value;
            var fotop=document.getElementById("fotop").value;
            var moneda=document.getElementById("moneda").value;
            var nombreempresa=document.getElementById("nombreempresa").value;
            var fotoe=document.getElementById("fotoe").value;
            var anio=document.getElementById("anio").value;
            if(nombre=="" || clave=="" || clave1=="" || fotop==null || moneda=="Seleccione" || nombreempresa=="" || fotoe==null){
              mostrarMensaje("Debe Completar Todos Los Campos","error",1500);
            }else{
               if(clave.length>7){
                 if(clave1!=clave){
                  mostrarMensaje("Las Contraseñas No Coinciden","error",1500);
                }else{
                   $.ajax({
                url: "opcionesRegistro.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
       processData: false
            })
                .done(function(res){
                 
                     if(res=="1"){
                        
                        document.location.href="inicio.php";

                     }else{
                      mostrarMensaje("Ocurrio un Erro Inesperado","error",1500);
                     }
                });
                }
              }else{
                mostrarMensaje("La clave debe contener mas de 8 caracteres","error",1500)
              }
            }



          }


    </script>

</head>

<body onload="cargaDatos();">
 <?php 
 include "config/conexion.php";
$totalFilas=0;
  $result=$conexion->query("SELECT * FROM ajustes");
  if($result){
  $totalFilas=$result->num_rows;
}


  ?>
  <div class="limiter">
    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
      <div class="<?php if($totalFilas==0){echo 'wrap-login1001';}else{echo 'wrap-login100';} ?> p-t-30 p-b-50">
        <span class="login100-form-title p-b-41">
         Bienvenido
        </span>
        <form class="login100-form validate-form p-b-33 p-t-5" id="formulario" method="POST" action="procesarImg.php" enctype="multipart/form-data">
          <div class="frm">
            <h1 class="text-center"></h1>
           
<div id="contenido">
      
  </div>

<br>


                 

   

                
            </div>
        
            </form>
          </div>
        </div>
      </div>




  <div id="dropDownSelect1"></div>
  
<!--===============================================================================================-->
  <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/bootstrap/js/popper.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
  <script src="vendor/daterangepicker/moment.min.js"></script>
  <script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
  <script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
  <script src="js/main.js"></script>
    
</body>

</html>
