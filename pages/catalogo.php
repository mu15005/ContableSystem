<?php 
session_start();
include "config/conexion.php";

    if(!isset( $_SESSION["usuario"])){
        header("location:index.php");
    }


    if(!isset( $_SESSION["usuario"])){
        header("location:index.php");
    }

    if(!isset( $_SESSION["onModificar"])){
        header("location:index.php");
    }else if($_SESSION["onModificar"]=="modificar"){
         header("location:diario.php");
         echo $_SESSION["onModificar"];
    }

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

    <link href="sweetalert/sweetalert2.min.css" rel="stylesheet" />

   
    <link rel="stylesheet" type="text/css" href="css/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/archivo.css"/>

    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">

    <!-- aqui se encuentran todas las funciones js que hacen posible el funcionamiento de esta pagina-->
    <script src="js/funcionesCatalogo.js"></script>

    <script type="text/javascript">
        function abrirVentana() {
              var window_width = 750;
              var window_height = 480;
              var newfeatures= 'scrollbars=no,resizable=no';
              var window_top = (screen.height-window_height)/2;
              var window_left = (screen.width-window_width)/2;
              newWindow=window.open('reportes/reporteCatalogo.php', 'Reporte','width=' + window_width + ',height=' + window_height + ',top=' + window_top + ',left=' + window_left + ',features=' + newfeatures + '');
}
        function configuraLoading(screen){
  $(document).ajaxStart(function(){
    screen.fadeIn();
  }).ajaxStop(function(){
    screen.fadeOut();
  });
}

    </script>
    
</head>
<body  onload="actualizaTabla('mostrar');" class="fix-header card-no-border">
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
                            <li class="breadcrumb-item active">Registro Catalogo de Cuentas</li>
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
           
            <div class="panel-body">
             <div class="col-md-12" style="float: left;padding-left: 73.1%;top: 4px;">
                    
                        <button type="button" style="width: 274px;" data-toggle="modal" class="btn-flip btn btn-gradient btn-primary" onclick="abrirVentana();">PDF</button>
                    </div>
                  </div>
           <div style="top:7px !important;float:right;padding-left: 2px;position: relative;">
             <button  style="width: 150px;" type="button" onclick="verArbol();" class="btn btn-info btn-md" >Ver Arbol de Cuentas</button>
           </div> 
            <div style="top:7px !important;float:right;padding-left: 1.5%;position: relative;">
             <button  type="button" style="width: 120px;" class="btn btn-success btn-md"  type="button" <?php if($_SESSION["onModificar"]=="consultar"){ ?>  disabled="true" <?php  } ?> onclick='cargaDato("agregar","","formC");' data-toggle="modal">Agregar Cuenta</button>
           </div>
             <div style="top:5px;float:left;padding-left:0px !important;" class="col-md-6">
           <input type="text" class="form-control"  onkeyup="busquedaCuentas();" id="busq" placeholder="Busqueda por Codigo y Nombre"> <a class="srh-btn">    
           </div>

            

           
          
            <div style="width:150px">   
                           
              
            </div>
           
        </div> <br> 
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
                            <h4 class="modal-title" id="myModalLabel" >Agregar Registro</h4>
                        </div>
                        <div class="modal-body">
                          
                               <form name="formCuentas" id="formCuentas" action="" method="post">
                               <input type="hidden" name="banderaGuardar" id="banderaGuardar">
                                <div class="panel-body" id="formNuevo">
                                   
                               
                                </div>
                            </form>
                      </div>
                     
                         <div class="text-center" >
        
         <input  type="button"  value="Cerrar"  class="btn ripple-infinite btn-round btn-info"   data-dismiss="modal">
         <input  type="button" value="Guardar" id="guardar"  name="guardar" class="btn ripple-infinite btn-round btn-success"  onclick="onGuardar(0);">
         


        
    </div> <br> 
                    
                           
                    </div>                    
                </div>
            </div>


        </div>    
          
      <div class="modal fade" id="miModalCarga"  role="dialog">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                
               
              <h4 class="modal-title" id="myModalLabel">Seleccionar cuenta</h4>
                  

                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                
                
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div style="top:5px;float:left;" class="col-md-6">
           <input type="text" class="form-control"  onkeyup="busquedaCuentaSelect(1);" id="busq1" value="" placeholder="Busqueda por Codigo y Nombre"> <a class="srh-btn">    
           </div>
              
                               <form name="formDCarga" id="formDCarga" action="" method="post">
                              
                               
                                <div class="panel-body" id="formCarga">
                                   
                        
                                </div>
                            </form>
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
                          
                               <form name="formDCarga2" id="formDCarga2" action="" method="post">
                               
                             
                                <div class="panel-body" id="formSubCuenta">
                            
                                </div>
                            </form>
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
                          
                               <form name="formDet" id="formDet" action="" method="post">
                              
                               <input type="hidden" name="banderaEdit" id="banderaEdit">
                                <div class="panel-body" id="formDetalle">
                           
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
           
           
    

<?php include "notificacionesDeCierre.php"; ?>
  
                    
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