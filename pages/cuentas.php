<?php 
session_start();


    if(!isset( $_SESSION["usuario"])){
        header("location:index.php");
    }else{
        if($_SESSION["usuario"][4]==1){
             header("location:verLibroDiario.php");
        }
    }

    if(!isset( $_SESSION["onModificar"])){
        header("location:index.php");
    }else if($_SESSION["onModificar"]=="modificar"){
         header("location:verLibroDiario.php");
    }
include "config/conexion.php";
  $result = $conexion->query("select * from periodo where estado=1");
if($result)
{
  while ($fila=$result->fetch_object()) {
    $anioActivo=$fila->anio;
    $idperiodo=$fila->idperiodo;
  }
}

$result=$conexion->query("SELECT * FROM partida where idperiodo=$idperiodo");
$numPartida=($result->num_rows)+1;


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
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
  
 <script src="js/jquery.min.js"></script>
   
    <script src="js/funciones.js"></script>
    
    <script src="js/ace-extra.min.js"></script>

    <link href="sweetalert/sweetalert2.css" rel="stylesheet" />

   
    <link rel="stylesheet" type="text/css" href="css/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/archivo.css"/>

    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">

    <!-- aqui se encuentran todas las funciones js que hacen posible el funcionamiento de esta pagina-->
    <script src="js/funcionesCuentasU.js"></script>

    
    
</head>
<body  onload="actualizaTabla();" class="fix-header card-no-border">
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
                            <li class="breadcrumb-item active">Cuentas De Usuario</li>
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
                    
                     <div class="modal fade" style="overflow-y: scroll;" id="miModalArbol" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
               
              <h4  style="padding-left:300px" id="myModalLabel">Arbol De Cuentas</h4>
                  
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                 
                
               
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
              <div id="formArbol">  
              </div>
            </div>

            <div class="modal-footer">
             
            </div>
           
        </div>
    </div>
</div> 
                   <div id="content">
                   <div class="col-md-11 top-20">
                    <div class="card">
          <div class="container"> 
             <div style="top:5px;float:left;padding-left:0px !important;" class="col-md-6">
           <input type="text" class="form-control"  onkeyup="busquedaCuentas();" id="busq" placeholder="Busqueda por Nombre y Acceso"> <a class="srh-btn">    
           </div>       
             <div style="top:5px !important;float:right;padding-right: 1px;position: relative;">
             <button  type="button"  class="btn btn-success btn-md" onclick="cargaDato('agregar','','formC');" data-toggle="modal"  data-target="#miModalNuevoR">Agregar Cuenta De Usuario</button>
           </div>
          
            <div style="width:150px">   
                           
              
            </div>
           
        </div>  
        <div class="panel-body" id="tablaCuenta">
                    
        </div>
      </div>
  </div>
      </div>
   
  </form>
  
    <div class="container">          
           <div class="modal" id="miModalNuevoR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="z-index: 9999; width: 470px">
                    <div class="modal-content">
                        <div class="modal-header">                            
                            <h4 class="modal-title" id="myModalLabel">Agregar Registro</h4>
                        </div>
                        <div class="modal-body">
                          
                              <form id="formulario" method="post" enctype="multipart/form-data">
                                   <div  class="panel-body" id="formNuevo"> 

                                   </div>
                            </form>
                      </div>
                     
                         <div class="text-center" >
        
      


        
    </div> <br> 
                    
                           
                    </div>                    
                </div>
            </div>


        </div>    
          
     
           
        <div class="container">          
           <div class="modal" id="miModalSub" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-dialog-centered" role="document" style="z-index: 9999; width: 470px">
                    <div class="modal-content">
                        <div class="modal-header">                            
                          <h4 class="modal-title" style="padding-left: 30%;" id="myModalLabel">Crear SubCuenta</h4>
                        </div>
                        <div class="modal-body">
                          
                             
                                <div class="panel-body" id="formSubCuenta">
                            
                                </div>
                           
                      </div>
                    </div>                    
                </div>
            </div>
       </div> 

 <div class="container">          
           <div class="modal" id="miModalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="z-index: 9999; width: 470px">
                    <div class="modal-content">
                        <div class="modal-header">                            
                            <h4 class="modal-title" id="myModalLabel">Detalles De Cuenta</h4>
                        </div>
                       <div class="modal-body">
                          
                              <form id="formula" method="post" enctype="multipart/form-data">
                                   <div  class="panel-body" id="formDetalle"> 

                                   </div>
                            </form>
                      </div>
                    </div>                    
                </div>
            </div>


        </div> 
  <script src="../assets/js/menu.js"></script>

    <script src="../assets/js/ace-elements.min.js"></script>
        <script src="../assets/js/ace.min.js"></script>

        <!-- SweetAlert Plugin Js -->
        <script src="sweetalert/sweetalert2.min.js"></script>
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

     
</body>
</html>