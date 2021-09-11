<?php 
session_start();

 
    if(!isset( $_SESSION["usuario"])){
        header("location:index.php");
    }

    if(!isset( $_SESSION["onModificar"])){
        header("location:index.php");
    }else if($_SESSION["onModificar"]=="modificar"){
         header("location:verLibroDiario.php");
    }
$inventariofinal=0.0;
include "config/conexion.php";
if (isset($_REQUEST["if"])) {
  $inventariofinal=$_REQUEST["if"];
}
$varHola=0.0;
 
   $numAux=0;
                                  $resultA=$conexion->query("SELECT * FROM partida where tipo=2");
                                  $numAux=$resultA->num_rows;

$detalle='Partidas de ajuste, Apertura Inventario Final';

if($numAux>0){

  $consult="SELECT detallepartida.debe,detallepartida.haber,partida.idpartida
FROM partida INNER JOIN detallepartida ON detallepartida.idpartida = partida.idpartida
WHERE partida.detalle = '".$detalle."' and partida.tipo=3";

  $resultInventario=$conexion->query($consult);
 
  if($resultInventario){
    while ($fil=$resultInventario->fetch_object()) {
     
      $varHola+=$fil->debe;

    }
    $inventariofinal=$varHola;
  }
}


$_SESSION["inventario"]=$inventariofinal;

include "operaciones/operacionesEF.php";

$resultadoAjustes=$conexion->query("SELECT * FROM `ajustes`");
$mon="";
if($resultadoAjustes){
  while ($fila=$resultadoAjustes->fetch_object()) {
  $mon=$fila->moneda;
  }
}
switch ($mon) {
  case '1':
    # code...
  $moneda="$ : ";
    break;
     case '2':
    # code...
     $moneda="€ : ";
    break;

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
  function abrirVentana() {
              var window_width = 750;
              var window_height = 480;
              var newfeatures= 'scrollbars=no,resizable=no';
              var window_top = (screen.height-window_height)/2;
              var window_left = (screen.width-window_width)/2;
              newWindow=window.open('reportes/reporteEstado.php', 'Reporte','width=' + window_width + ',height=' + window_height + ',top=' + window_top + ',left=' + window_left + ',features=' + newfeatures + '');
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
                            <li class="breadcrumb-item active">Estado Resultado</li>
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

                    <div id="content">
   
                <div class="panel-body">
               
                   <div style="top:-5px !important;float:right;padding-right: 0px;position: relative;">
             <button  type="button" style="width: 274px;" onclick="abrirVentana();" class="btn btn-info btn-md">PDF</button>
           </div>
            

                    <div class="responsive-table">
                    <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th  style="width:700px;color: #9575CD;font-size: 24px">Estado Resultado</th>
                      
                        <th style="width:300px;">.</th>
                        <th style="width:300px;">.</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>Ventas</td>
                        <td></td>
                        <td><?php echo $moneda."". number_format($resultventa,2,".",",");?></td>
                      </tr>
                      </tbody>
                        <tbody>
                      <tr>
                        <td>(-) Rebajas y devoluciones sobre ventas</td>
                        <td></td>
                        <td><?php echo $moneda."". number_format($resultRebAndDevVenta,2,".",",");?></td>
                      </tr>
                        </tbody>
                        <tbody>
                      <tr>
                        <td>(=) Ventas netas</td>
                        <td></td>
                        <td><?php echo $moneda."". number_format($resultventa-$resultRebAndDevVenta,2,".",",");?></td>
                      </tr>
                        </tbody>
                      <tbody>
                      <tr>
                        <td>(-) Costo de ventas</td>
                        <td></td>
                        <td><?php echo $moneda."". number_format(((($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra)+$resultInvetIni)-$inventariofinal,2,".",",");?></td>
                      </tr>
                        </tbody>
                        <tbody>
                        <tr>
                          <td>     Compras</td>
                          <td><?php echo $moneda."". number_format($saldoComp,2,".",",");?></td>
                          <td></td>
                        </tr>
                          </tbody>
                          <tbody>
                          <tr>
                            <td>(+)   Gastos Sobre Compras</td>
                            <td><?php echo $moneda."". number_format($resultGastoCompra,2,".",",");?></td>
                            <td></td>
                          </tr>
                            </tbody>
                            <tbody>
                            <tr>
                              <td>(=)  Compras Totaes</td>
                              <td><?php echo $moneda."". number_format($saldoComp+$resultGastoCompra,2,".",",");?></td>
                              <td></td>
                            </tr>
                              </tbody>
                              <tbody>
                              <tr>
                                <td>(-) Rebajas y devoluciones Sobre Compras</td>
                                <td><?php echo $moneda."". number_format($resultRebAndDevCompra,2,".",",");?></td>
                                <td></td>
                              </tr>
                                </tbody>
                                <tbody>
                                <tr>
                                  <td>(=) Compras Netas</td>
                                  <td><?php echo $moneda."". number_format(($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra,2,".",",");?></td>
                                  <td></td>
                                </tr>
                                  </tbody>
                                <tbody>
                                <tr>
                                  <td>(+) Inventario Inicial</td>
                                  <td><?php echo $moneda."". number_format($resultInvetIni,2,".",",");?></td>
                                  <td></td>
                                </tr>
                                  </tbody>
                                  <tbody>
                                  <tr>
                                    <td>(=) Mercaderia Disponible</td>
                                    <td><?php echo $moneda."". number_format((($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra)+$resultInvetIni,2,".",",");?></td>

                                    <td></td>
                                  </tr>
                                    </tbody>
                                    <tbody>
                                    <tr>
                                      <td>(-)   Inventario Final</td>
                                      <td><?php echo $moneda."". number_format($inventariofinal,2,".",",");?></td>

                                      <td></td>
                                    </tr>
                                      </tbody>
                                      <tbody>
                                      <tr>
                                        <td>(=)   Utilidad Bruta</td>
                                        <td></td>
                                        <td><?php echo $moneda."". number_format(($resultventa-$resultRebAndDevVenta)-(((($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra)+$resultInvetIni)-$inventariofinal),2,".",",");?></td>
                                      </tr>
                                        </tbody>
                                      </tbody>
                                      <tbody>
                                      <tr>
                                        <td>(-)   Gastos de Operacion</td>
                                        <td></td>
                                        <td><?php echo $moneda."". number_format($resultGastoAdministracion+$resultGastoVenta+$resultGastoFinanciero,2,".",",");?></td>
                                      </tr>
                                        </tbody>
                                        <tbody>
                                        <tr>
                                          <td> Gastos de Administracion</td>
                                          <td><?php echo $moneda."". number_format($resultGastoAdministracion,2,".",",");?></td>
                                          <td></td>
                                        </tr>
                                          </tbody>
                                          <tbody>
                                          <tr>
                                            <td> (+) Gastos de Venta</td>
                                            <td><?php echo $moneda."". number_format($resultGastoVenta,2,".",",");?></td>
                                            <td></td>
                                          </tr>
                                            </tbody>
                                          </tbody>
                                          <tbody>
                                          <tr>
                                            <td> (+) Gastos de Financieros</td>
                                            <td><?php echo $moneda."". number_format($resultGastoFinanciero,2,".",",");?></td>
                                            <td></td>

                                          </tr>
                                            </tbody>
                                          <tbody>
                                            <tr>
                                              <td> (=)   Utilidad de Operacion</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($UB,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                          <tbody>
                                            <tr>
                                              <td> (-)   Otros gastos</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($resultOtrosGast,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                          <tbody>
                                            <tr>
                                              <td> (+)   Otros Ingresos</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($resultOtrosIngresos,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                          <tbody>
                                            <tr>
                                              <td> (=)   Utilidad Antes de Impuesto Y Reserva</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($UAIR,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                         
                                          <tbody>
                                            <tr>
                                              <td> (-)   Reserva Legal (7%)</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($reservaL,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                         
                                           <tbody>
                                            <tr>
                                              <td> (=)   Utilidad antes de Impuesto sobre la Renta</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($UAI,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                         
                                          <tbody>
                                            <tr>
                                              <td> (-)   Impuesto sobre la renta <?php if($resultventa>150000){echo "(30%)";}else{echo "(25%)";} ?></td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($imp,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                        
                                          <tbody>
                                            <tr>
                                              <td style="background:#C8E6C9;color:green;" > (=)   Utilidad del Ejercicio</td>
                                              <td style="background:#C8E6C9;color:green;"></td>
                                              <?php if($Utilidad>=0){ ?>
                                              <td style="background:#C8E6C9;color:green;"><?php echo $moneda."". number_format($Utilidad,2,".",",")?></td>
                                            <?php }else{ ?>
                                              <td style="background:#C8E6C9;color:red;"><?php echo $moneda."". number_format($Utilidad,2,".",",")?></td>
                                            <?php } ?>
                                            </tr>
                                          </tbody>

                      </table>
                    </div>
                  </div>
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
  $(document).ready(function(){
    $('#tabladat').DataTable();
  });
</script>
                    
</body>
</html>