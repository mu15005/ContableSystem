<?php 

//se incluye el archivo operaciones/operacionesEF.php ya que en este se mayorizan los valores de todas las 
//cuentas necesarias para calcular la utilidad la reserva y el impuesto
session_start();
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


  //$UAIR representa el valor de la utilidad antes del impuesto y la reserva legal

 $UAIR=(((($resultventa-$resultRebAndDevVenta)-(((($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra)+$resultInvetIni)-$inventariofinal))-($resultGastoAdministracion+$resultGastoVenta+$resultGastoFinanciero))-$resultOtrosGast)+$resultOtrosIngresos;
     
     $reservaL=$UAIR*0.07;

     $UAIR=$UAIR-$reservaL;

     if ($resultventa>150000) {
      $imp=$UAIR*0.30;
     }else{
      $imp=$UAIR*0.25;
     }
     $Utilidad=$UAIR-$imp;
    

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
              newWindow=window.open('reportes/reporteBalance.php', 'Reporte','width=' + window_width + ',height=' + window_height + ',top=' + window_top + ',left=' + window_left + ',features=' + newfeatures + '');
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
                            <li class="breadcrumb-item active">Balanza General</li>
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
                                   
            <div style="top:-5px !important;float:right;padding-right: 10px;position: relative;">
             <button  type="button" style="width: 274px;"  onclick="abrirVentana();" class="btn btn-warning btn-md">PDF</button>
           </div>
           
            <div  style="width:700px;color: #9575CD;font-size: 24px">Balanza General</div>
            <br> 

                                    <div id="content">
    <table  id="tablaBalance" class="table" width="100%" cellspacing="0">
      
      <?php 
      //variables acumuladoras que sumaran los valosres de sus respectivos grupos
       $acumuladorAC=0.0; //activo corrient
       $acumuladorANC=0.0;//activo no corriente
       $acumuladorPC=0.0;//pasivo corriente
       $acumuladorPNC=0.0;//pasivo no corriente
       $acumuladorP=0.0;//patrimonio

       //este for sirve para reutilizar el codigo de impresion se repite 4 veces el mismo valor de grupos del balance general
      for ($i=0; $i < 6; $i++) { 
        //se le asigna el valor de un indice a cada uno de los grupos para poder saber el momento de acceder a cada grupo
       if($i==0){
        $grupo="Activo Corriente";
        $codigocuenta='11';
       }
       if($i==1){
        $grupo="Activo No Corriente";
        $codigocuenta='12';
       }
       if($i==2){
        $grupo="Pasivo Corriente";
        $codigocuenta='21';
       }
       if($i==3){
        $grupo="Pasivo No Corriente";
        $codigocuenta='22';
       }
        if($i==4){
        $grupo="Patrimonio";
        $codigocuenta='31';
       }
        if($i==5){
        $grupo="Patrimonio";
        $codigocuenta='32';
       }
      
     if($i!=5){
     echo "<td style='background:#C8E6C9;color:green'>$grupo</td>";
      echo "<td style='background:#C8E6C9;color:green'  >Saldo</td>";
    }

       include "config/conexion.php";


      $acumuladorAux=0.0;
                      //codigo para obtener todas las cuentas de mayor
                    $result = $conexion->query("select idcatalogo as id,saldo, nombrecuenta as nombre, codigocuenta as codigo from catalogo  where nivel='3' and SUBSTRING(codigocuenta,1,'2')='".$codigocuenta."' and idperiodo=$anioActivo order by codigocuenta");
                    if ($result) {


                        while ($fila = $result->fetch_object()) {

                          $nombre=$fila->nombre;

                          
                          $codigo=$fila->codigo;
                          //obtener total de caracteres del codigo segun el de la cuenta de seleccionada
                          $loncadena=strlen($codigo);
                          
                          //inicio de la consulta para encontrar las  subcuentas de la cuenta de mayor
                          
                          $resultSubcuenta= $conexion->query("select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1','".$loncadena."') as codigocorto, p.idpartida as npartida, p.detalle as concepto, p.fecha as fecha, l.debe as debe, l.haber as haber FROM catalogo as c,partida as p, detallepartida as l where SUBSTRING(c.codigocuenta,1,'".$loncadena."')='".$codigo."' and p.idpartida=l.idpartida and l.idcatalogo=c.idcatalogo and p.idperiodo='".$anioActivo."'  and p.tipo!=2 ORDER BY p.idpartida ASC");
                         


                         


                          if ($resultSubcuenta) {
                            $codigoSC=$fila->codigo;
                            $saldo=0.0;
                              if($resultSubcuenta->num_rows>0){

                              
                              while ($fila2 = $resultSubcuenta->fetch_object()) {
                                
                                $nombrecuenta=$fila2->nombre;

                                $codigoSC=$fila2->codigo;

                                if ($fila->saldo=="Deudor") {
                                  $saldo=$saldo+($fila2->debe)-($fila2->haber);
                                }else {
                                  $saldo=$saldo-($fila2->debe)+($fila2->haber);
                                }

                              }//fin del while resulSubcuenta
                          }//fin del if num_rows

                         switch($i){//switch para acumular los valores de cada grupo
                           case 0:
                           
                                    if($codigoSC=="1106"){// mostrar el valor de nventario final en lugar del inicial
                                    $saldo=$inventariofinal;
                                    }
                                  
                                    $acumuladorAC=$acumuladorAC+$saldo;
                                break;
                            case 1: $acumuladorANC=$acumuladorANC+$saldo;
                                break;
                             case 2: 
                                 $resultA=$conexion->query("SELECT * FROM partida where tipo=2 and idperiodo=$anioActivo");
                                  $numAux=$resultA->num_rows;
                                if($codigoSC=="2107" and $numAux==0){
                                 $saldo+=$imp;
                                  }
                             $acumuladorPC=$acumuladorPC+$saldo; 
                                 break;
                            case 3: $acumuladorPNC=$acumuladorPNC+$saldo; 
                                break;
                              
                             
                             case 4 or 5 : $acumuladorP=$acumuladorP+$saldo;
                               $resultA=$conexion->query("SELECT * FROM partida where tipo=2 and idperiodo=$anioActivo");
                                  $numAux=$resultA->num_rows;
                             if($codigoSC=="3201" and $numAux==0){
                                    $saldo+=$reservaL;
                                    }
                                     if($codigoSC=="3202" and $numAux==0){
                                    $saldo+=$Utilidad;
                                    }
                             break;
                              }//fin de switch


                              echo "<tr>";
                                    echo "<td>$nombre</td>";
                              echo "<td>$moneda".number_format($saldo,2,'.',',')."</td>";
                                echo "</tr>";
                            
                              
                              $saldo=0.0;
                              
                            
                          }//fin del resultado subCuenta
                        }//fin del while de la primer consulta
                        }//fin del if del result
                       
                      
                     


                       switch($i){//switch para mostrar los totales de cada grupo
                           case 0:
                                   
                                echo "<tr>
                                <td class='text-black'>Total Activo Corriente</td>
                                <td class='text-black'>$moneda".number_format($acumuladorAC,2,'.',',')."</td>

                                </tr>";
                               
                                break;
                            case 1:  echo "<tr>
                                <td class='text-black'>Total Activo No Corriente</td>
                                <td class='text-black'>$moneda".number_format($acumuladorANC,2,'.',',')."</td>

                                </tr>";
                               echo "<tr>
                                      <td class='text-black'>Total Activo</td>
                                      <td class='text-black'>$moneda".number_format(($acumuladorAC+$acumuladorANC),2,".",",")."</td>

                                      </tr>";
                                break;
                             case 2: $numAux=0;
                                  $resultA=$conexion->query("SELECT * FROM partida where tipo=2 and idperiodo=$anioActivo");
                                  $numAux=$resultA->num_rows;
                                   if($numAux==0){
                                    
                             
                            }
                                     echo "<tr>
                                <td class='text-black'>Total Pasivo Corriente</td>
                                <td class='text-black'>$moneda".number_format($acumuladorPC,2,'.',',')."</td>

                                </tr>";


                                   
                                 break;
                            case 3: 
                                   echo "<tr>
                                <td class='text-black'>Total Pasivo No Corriente</td>
                                <td class='text-black'>$moneda".number_format($acumuladorPNC,2,'.',',')."</td>

                                </tr>"; 

                                echo "<tr>
                                      <td class='text-black'>Total Pasivo</td>
                                      <td class='text-black'>$moneda".number_format(($acumuladorPC+$acumuladorPNC),2,".",",")."</td>

                                      </tr>";
                                break;
                             case  5:
                             $numAux=0;
                                  $resultA=$conexion->query("SELECT * FROM partida where idperiodo=$anioActivo and tipo=2");
                                  $numAux=$resultA->num_rows;
                                   if($numAux==0){
                              echo "<tr>";
                              echo "<td>Reserva Legal </td>";
                              
                              echo "<td>$moneda".number_format($reservaL,2,".",",")."</td>";
                              echo "</tr>";
                                          
                             $acumuladorP=$acumuladorP+$reservaL;
                             echo "<tr>";
                             echo "<td>Utilidad Del Ejercicio </td>";
                              
                             echo "<td>$moneda".number_format($Utilidad,2,".",",")."</td>";
                             echo "</tr>";
                              $acumuladorP=$acumuladorP+$Utilidad;
                           }
                                          
                                          
                              echo "<tr>
                                <td class='text-black'>Total Patrimonio</td>
                                <td class='text-black'>$moneda".number_format($acumuladorP,2,'.',',')."</td>

                                </tr>"; 

                                echo "<tr>
                                      <td class='text-black'>Patrimonio + Pasivo</td>
                                      <td class='text-black'>$moneda".number_format(($acumuladorP+$acumuladorPC+$acumuladorPNC),2,".",",")."</td>

                                      </tr>";
                             break;
                              }//fin de switch
                       

              
            }//fin del for
?>

    </table>
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