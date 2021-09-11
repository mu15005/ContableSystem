<?php
session_start();
   
    if(!isset( $_SESSION["usuario"])){
        header("location:index.php");
    }

    if(!isset( $_SESSION["onModificar"])){
        header("location:index.php");
    }else if($_SESSION["onModificar"]=="modificar"){
         header("location:verLibroDiario.php");
    }else if($_SESSION["onModificar"]=="consultar"){
         header("location:verLibroDiario.php");
    }

include "config/conexion.php";
$result = $conexion->query("select * from ajustes ");
if($result)
{
  while ($fila=$result->fetch_object()) {
    $moneda=$fila->moneda;
    $idajuste=$fila->idajuste;
    $nombre=$fila->nombreempresa;
    $logo=$fila->logo;
  }
}


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
       function onHabilitar(){
        if(document.getElementById("btn").value=="Guardar"){


   
      
 var formData = new FormData(document.getElementById("formula"));
            //formData.append("dato", "valor");
            //formData.append(f.attr("name"), $(this)[0].files[0]);

                  var nombreempresa=document.getElementById("nombreempresa").value;
           
            var moneda=document.getElementById("moneda").value;
            var fotoe=document.getElementById("fotoe").value;
          
          
          
            if(nombreempresa=="" || moneda=="Seleccione"  || fotoe==null ){
              mostrarMensaje("Debe Completar Todos Los Campos","error",1500);
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
                        document.location.href="ajustes.php?mensaje=1";
                     }else{
                      mostrarMensaje("Ocurrio un Erro Inesperado","error",1500);
                     }
                });

               }
            


      
       }
       if(document.getElementById("btn").value=="Modificar"){

        $("#nombreempresa").attr("disabled",false).focus();

        //$("#nombre").focus();
        $("#moneda").attr("disabled",false);
        $("#fotoe").attr("disabled",false);
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
                            <li class="breadcrumb-item active">Datos Generales</li>
                        
                          
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
                                                           
                 <input type="hidden" name="idajuste" id="idajuste" value="<?php echo $idajuste ?>"> 
                 <input type="hidden" name="opcion" id="opcion" value="modificaAjuste"> 
                     <label class="form__label" style="top:0%;float: center;font-size: 30px;padding-left: 20%;">Ajustes Generales</label><br> <br> <br> <br>  
                    <label class="form__label" style="top:18%;">Nombre De la Empresa</label>
                    <input type="text" name="nombreempresa" disabled="true" class="form__field" style="width: 96%;" value="<?php echo $nombre ?>" id="nombreempresa"><br><br> 
                   
                     
                    
                    <div class="form-group form-animate-text" style="margin-top:50px !important;">
                    <select name="moneda" id="moneda" disabled="true" class="form-text"   style="width: 98%;color:#526470;">
                     <option value="SELECCIONE"   >SELECCIONE</option>
                                     
                                      <option  value="1" <?php  if($moneda==1) echo 'selected="true"'; ?>>Dolares $</option>
                                     <option value="2" <?php if($moneda==2) echo 'selected="true"'; ?>>Euros €</option>
                                              
                    </select><br>
                    <label style="top:-40px;font-size: 20px;color:#5264AE">Acceso</label>
                    </div>

                  
                         <div class="row">
                         <div class="col-md-6">          
                    <label class="form__label" style="top: -50%;" >Logo  De La Empresa</label>
                    <input type="file" name="fotoe"  disabled="true"  class="form__field"  style="width: 98%;padding-left:50px;" value="" id="fotoe">
                    </div> 
                    <div class="col-md-6" style="top: -35px;">
                    <span ><img height="90px" id="imgEmp" src="data:image/jpg;base64,<?php echo base64_encode($logo); ?>"></span>
                    </div>
                </div>
                    
                    
            <div class="text-center">
                    <input  type="button"  value="Modificar" id="btn" style="width: 250px;"  class="btn ripple-infinite btn-round btn-primary" onclick="onHabilitar()">
       
                              </div>     

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

    <?php 
    if(isset($_REQUEST["mensaje"])){
        if($_REQUEST["mensaje"]==1){?>
          <script type="text/javascript">
              mostrarMensaje("Exito","success",1500);
          </script>
        <?php }
    }

 ?>
    <script type="text/javascript">
         $("#fotoe").change(function () {
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
