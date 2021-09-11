<?php
session_start();
include "config/conexion.php";
$idusuario="";
if(isset($_SESSION["cuenta"])){
  $idusuario=$_SESSION["cuenta"];
}

 
    if(!isset( $_SESSION["usuario"])){
        header("location:index.php");
    }

 
$usuario=$_SESSION["usuario"];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>ContableSystem 2000</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/archivo.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
  

   
    
    <link rel="stylesheet" type="text/css" href="css/datatables.bootstrap.min.css"/>


    <link href="sweetalert/sweetalert2.min.css" rel="stylesheet" />

   
    <link rel="stylesheet" type="text/css" href="css/animate.min.css"/>

    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">



   <script type="text/javascript">
    function cargaSelect(acceso){
      switch(acceso){

        case "0":$("#acceso option").eq(1).prop("selected",true);break;
               // case 'ACTIVO':$("#tipo option").eq(1).prop("selected",true);break;
                case "1":$("#acceso option").eq(2).prop("selected",true);break;
               
              }

             
      }

       function onHabilitar(){
        if(document.getElementById("btn").value=="Guardar"){
         

   
      
 var formData = new FormData(document.getElementById("formula"));
            //formData.append("dato", "valor");
            //formData.append(f.attr("name"), $(this)[0].files[0]);

                  var nombre=document.getElementById("nombre").value;
           
            var clave=document.getElementById("clave").value;
             var clave1=document.getElementById("clave1").value;
              var acceso=document.getElementById("acceso").value;
            var fotoe=document.getElementById("fotop").value;
          
          
          
            if(nombre=="" || clave==""  || clave1=="" || acceso=="" || fotop==null ){
              mostrarMensaje("Debe Completar Todos Los Campos","error",1500);
            }else{
                if(clave1!=clave){
                    mostrarMensaje("Las claves no Coinciden","error",1000);
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
                        
                         $("#nombre").attr("disabled",true).focus();
                                
                          document.location.href="micuenta.php?mensaje='true'";
                     }else{
                      mostrarMensaje("Ocurrio un Erro Inesperado","error",1500);
                     }
                });

               }
            }


      
       }
       if(document.getElementById("btn").value=="Modificar"){

         $("#nombre").attr("disabled",false).focus();

                                  $("#clave").attr("disabled",false);
                                  $("#clave1").attr("disabled",false);
                                 // $("#acceso").attr("disabled",false);
                            $("#fotop").attr("disabled",false);
        $("#btn").attr("value","Guardar");
       }
       }
   </script>
    
</head>
<body   class="fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include "header.php"; ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
      <?php include "menu.php"; ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="page-titles">
                    <div class="col-md-6 col-8 align-self-center">
              
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                            <li class="breadcrumb-item active">Mi Cuenta</li>
                          
                        </ol>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
              
                     <div class="col-12">
                        <div class="card">
                            <div class="card-block">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                    <form id="formula" method="post" enctype="multipart/form-data">
                                                           
                 <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $idusuario ?>"> 
                 <input type="hidden" name="opcion" id="opcion" value="modificarMiCuenta"> 
                     <label class="form__label" style="top:0%;float: center;font-size: 30px;padding-left: 28%;">Mi Cuenta</label><br> <br> <br>
                     <script type="text/javascript">
     
      </script>
                
                     
              

                    <label class="form__label" style="top:12%;">Nombre</label>
                    <input type="text" name="nombre" class="form__field" disabled="true" style="width: 96%;" value="<?php echo($usuario[1]); ?>" id="nombre"><br><br> 


                       <label class="form__label" style="top:25%;">clave</label>
                                        <input type="password"  class="form__field"  disabled="true" name="clave" id="clave" style="width: 48%;" value="">
                    
                                    
                    <label class="form__label" style="top:25%;">Rep.Calve</label>
                    <input type="password" name="clave1" class="form__field"  disabled="true"  style="width: 48%;padding-left:2px;" value="" id="clave1"><br><br>
                

                    
                    <div class="form-group form-animate-text" style="margin-top:50px !important;">
                    <select name="acceso" id="acceso" class="form-text"    disabled="true"  style="width: 98%;color:#526470;">
                     <option value="SELECCIONE"   >SELECCIONE</option>
                                      <option value="0" <?php if($usuario[4]==0){echo "selected='true'";} ?> >Administrador</option>
                                      <option <?php if($usuario[4]==1){echo "selected='true'";} ?> value="1">Usuario Normal</option>
                                              
                    </select><br>
                    <label style="top:-40px;font-size: 20px;color:#5264AE">Acceso</label>
                    </div>

                  
                    <div class="row">
                         <div class="col-md-6">          
                    <label class="form__label" style="top: -50%;" >Foto  De Perfil</label>
                    <input type="file" name="fotop"  disabled="true"  class="form__field"  style="width: 98%;padding-left:50px;" value="" id="fotop">
                    </div> 
                    <div class="col-md-6" style="top: -35px;">
                    <span ><img height="90px" id="imgEmp" src="data:image/jpg;base64,<?php echo base64_encode($usuario[3]); ?>"></span>
                    </div>
                </div>
                  
         <div class="text-center">
                    <input  type="button"  value="Modificar" id="btn" style="width: 250px;"  class="btn ripple-infinite btn-round btn-primary" onclick="onHabilitar()">
       
                              </div> 
          
       
                      
                                    </form>
                                </div>
                                <div class="col-md-3"></div>


                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
            </div>
     
         
    


  
                    
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                © 2020 ContableSystem 2000
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/plugins/bootstrap/js/tether.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>


        <!-- SweetAlert Plugin Js -->
        <script src="sweetalert/sweetalert2.min.js"></script>

        <script src="js/funciones.js"></script>

    <!-- aqui se encuentran todas las funciones js que hacen posible el funcionamiento de esta pagina-->
  
    <script src="js/jquery.datatables.min.js"></script>
    <script src="js/plugins/jquery.datatables.min.js"></script>
    <script src="js/plugins/datatables.bootstrap.min.js"></script>

    <script type="text/javascript">
      <?php 
      if(isset($_REQUEST["mensaje"])){
        if($_REQUEST["mensaje"]=="true"){?>
          mostrarMensaje("Exito","success",1000);
        <?php
        }
      }

       ?>
       
         $("#fotop").change(function () {
    // Código a ejecutar cuando se detecta un cambio de archivO
    readImage(this);
  });

         function readImage (input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          $('#imgEmp').attr('src', e.target.result); // Renderizamos la imagen
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
    </script>
                    
</body>
</html>