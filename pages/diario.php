<?php include "config/conexion.php";
session_start();
 
    if(!isset( $_SESSION["usuario"])){
        header("location:index.php");
    }

    if(!isset( $_SESSION["onModificar"])){
        header("location:index.php");
    }else if($_SESSION["onModificar"]=="consultar"){
         header("location:verLibroDiario.php");
    }

  $result = $conexion->query("select * from periodo where estado=1");
if($result)
{
  while ($fila=$result->fetch_object()) {
    $anioActivo=$fila->anio;
    $idperiodo=$fila->idperiodo;
  }
}
$numpartida=-1;
$result = $conexion->query("SELECT MAx(numpartida) as idpartida FROM partida where idperiodo=$idperiodo");
      
      if($result){
        while($fila=$result->fetch_object()){
          $numpartida=$fila->idpartida;
        }
        $numpartida++;
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

    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">

    <!-- aqui se encuentran todas las funciones js que hacen posible el funcionamiento de esta pagina-->
    <script src="js/funcionesLibroDiario.js"></script>
  
</head>
<body onload="agregarCuentaPartida('mostrar',0)" class="fix-header card-no-border">
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
                            <li class="breadcrumb-item active">Registro Asientos Contables</li>
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
                                <div class="content">
    <form >
      <input type="hidden" name="bandera" id="bandera">
              <input type="hidden" name="baccion" id="baccion" value="" >
              <div class="col-md-12 top-0 padding-0"> 
                   <div class="panel-heading panel-heading-danger "><h3 style="text-align: center;">Partida # <?php echo $numpartida ?></h3></div>
              </div>
      <div class="row">
      <div class="col-md-5 top-20 padding-10 ">
     
            <div class="form-group form-animate-text" style="margin-top:10px !important;">
                              <input type="text" class="form-text" id="codigo" name="codigo" onkeyup="buscarCuentaCodigo('');" >
                              <span class="bar"></span>
                              <label>Codigo</label>
                            </div>
                            <div class="form-group form-animate-text" style="margin-top:30px !important;" id="inputcuenta">
                              <!-- <input type="text" class="form-text" id="nombreCuenta" name="nombreCuenta"  >
                              <span class="bar"></span>
                              <label>Cuenta</label> -->
                            </div>
              
                              <div class="form-group form-animate-text" style="margin-top:10px !important;">
                              <input type="number" class="form-text" id="monto" name="monto" min="0" >
                              <span class="bar"></span>
                              <label>Monto $</label>
                            </div>



                          

                              <div >

                               <label class="radio-inline" style="color:#5264AE;font-size:15px;padding:10px 20px;"><input type="radio" id="movimiento" name="movimiento" style="width:15px;height:15px"  value="cargo"> Cargo</label>

                            <label class="radio-inline" style="color:#5264AE;font-size:15px;padding:10px 100px;"><input type="radio" id="movimiento" name="movimiento" style="width:15px;height:15px" value="abono"> Abono</label>

                         

                           
                          </div>
                        </br>




       </div>
                

 <div class="col-md-7 top-20 padding-10">
                  <div class="col-md-12">
                  <div class="panel" >
                    <div class="col-md-2">

                    </div>



                   
                    <div class="panel-body" id="tablaPartida">
                      
                    </div>
                </div>
              </div>
              </div>



             





    </div>
    <div class="col-md-12">

                        <button type="button" class="btn-flip btn btn-gradient btn-success" onclick="agregarCuentaPartida('agregar',0)" data-toggle="tooltip" data-placement="bottom" >
                           <div class="side">
                                Agregar <span class="fa"></span>
                              </div>
                           
                          </button>

                          <button type="button" class="btn-flip btn btn-gradient btn-warning"  data-toggle="modal" data-target="#modalForm">
                            <div class="side">
                                Mostrar Cuentas <span class="fa"></span>
                              </div>
                           
                          </button>
                                            
                            <button type="button" class="btn-flip btn btn-gradient btn-primary" data-toggle='modal' data-target='#myModal'>
                              
                                <div class="side">
                                  Procesar Partida<span class="fa"></span>
                                </div>
                               
                             
                             
                            </button>
                        
                         
                            <button type="button" class="btn-flip btn btn-gradient btn-danger" onclick="cancelarPartida();">
                              
                                <div class="side">
                                 Limpiar<span class="fa"></span>
                                </div>
                               
                             
                             
                            </button>

    </div>
    </form>
  </div>

     <!-- ventana para seleccionar la cuenta -->
              <div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                
               
               <h3> Seleccione la cuenta para agregar a la partida actual.</h3>
                  

                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Cerrar</span>
                </button>
                
               
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
               <input type="text" class="form-control" id="busq" placeholder="Busqueda por Nombre..." onkeyup="busquedaCuentas();">
                <p class="statusMsg"></p>
                <div id="tablaCuentas">
                 
     </div>
            </div>
           
        </div>
    </div>
</div>

  <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Datos de la partida # </h4>
      </div>
      <div class="modal-body">
        <div class="form-group form-animate-text" style="margin-top:0px !important;">
          <input type="text" class="form-text" id="conceptoPartida" name="conceptoPartida" >
          <span class="bar"></span>
          <label>Concepto</label>
        </div>
        <div class="form-group form-animate-text" style="margin-top:30px !important;">
          <input type="date" class="form-text" id="fechaPartida" name="fechaPartida" min="<?php echo $anioActivo; ?>-01-01" max="<?php echo $anioActivo; ?>-12-31">
          <span class="bar"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  onclick="procPartida()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>
    </div>

  </div>
</div>

 

<!-- custom -->



    <script src="js/ace-elements.min.js"></script>
    <script src="js/menu.js"></script>
        <script src="js/ace.min.js"></script>

        <!-- SweetAlert Plugin Js -->
        <script src="sweetalert/sweetalert2.min.js"></script>
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
</body>
</html>