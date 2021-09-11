<?php
session_start();

 
    if(!isset( $_SESSION["usuario"])){
        header("location:index.php");
    }

    if(!isset( $_SESSION["onModificar"])){
        header("location:index.php");
    }else if($_SESSION["onModificar"]=="consultar"){
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


    <link href="sweetalert/sweetalert2.css" rel="stylesheet" />

   
    <link rel="stylesheet" type="text/css" href="css/animate.min.css"/>

    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">


   
    <script type="text/javascript">
    
       function abrirVentana() {
              var window_width = 750;
              var window_height = 480;
              var newfeatures= 'scrollbars=no,resizable=no';
              var window_top = (screen.height-window_height)/2;
              var window_left = (screen.width-window_width)/2;
              newWindow=window.open('reportes/reporteMayor.php', 'Reporte','width=' + window_width + ',height=' + window_height + ',top=' + window_top + ',left=' + window_left + ',features=' + newfeatures + '');
}
    function enviar(nivel,ini,fn,opcion)
        {
          if(opcion!=""){

            nivel=document.getElementById('nivelMayor').value;
            ini=document.getElementById("selectInicio").value;
            fn=document.getElementById("selectFin").value;

         
          if(nivel==="Seleccione" || ini==="Seleccione" || fn==="Seleccione"){
            mostrarMensaje("Debe Completar todos los campos","error",1000);
          }else{
            if(ini>fn){
              mostrarMensaje("El fin No pude ser menor que el inicio","error",1000);
            }else{
               $.post("operaciones/operacionesMayor.php",{nivelMayorizacion:nivel,inicio:ini,fin:fn},function(data){
                $("#content").html(data);
                $("#modalPersonalizado").modal("hide");
            });
            }
          }
          }else{
          
           $.post("operaciones/operacionesMayor.php",{nivelMayorizacion:nivel,inicio:ini,fin:fn},function(data){
                $("#content").html(data);
            });
         }
        }


function paginacion(str){
 
 
            $.post("operaciones/operacionesMayor.php",{busqueda:"",pagina:str,opcion:"mostrar"},function(data){
                $("#content").html(data);
            });

        
      }

  </script>
    
</head>
<body   onload="enviar(3,1,6,'');" class="fix-header card-no-border">
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
                            <li class="breadcrumb-item active">Libro Mayor</li>
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
                   </div>
                </div>

                        </div>
                    </div>
                  </div>

      
  
          </div>
           
             <div class="modal" id="modalPersonalizado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="z-index: 9999; width: 470px">
                    <div class="modal-content">
                        <div class="modal-header">                            
                            <h4 class="modal-title" id="myModalLabel">Personalizar</h4>
                        </div>
                        <div class="modal-body">

                           <div class="form-group form-animate-text" style="margin-top:10px !important;">
                               <select  class="form-text" name="nivelMayor" id="nivelMayor">

                            
                          <option value="Seleccione">Seleccione</option>
                          <?php
                          include "config/conexion.php";
                          $result = $conexion->query("select nivel from catalogo group by nivel order by nivel ASC");
                          if ($result) {
                              while ($fila = $result->fetch_object()) {
                                echo "<option value='".$fila->nivel."'>".$fila->nivel."</option>";
                              }
                            }
                           ?>
                        </select>
                              <label>Nivel De Mayorizacion</label><br>
                             
                            </div>
                           
                            <div class="form-group form-animate-text" style="padding-left:15px !important;">
                             <div class="row">
                               <div class="col-md-6">

                                  <select class="form-text" name="selectInicio" id="selectInicio">
                         
                          <option value="Seleccione">Seleccione</option>
                         <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                           <option value="6">6</option>
                        </select>
                              <label>Inicio</label>
                               </div>
                               <div class="col-md-6">
                                 <select class="form-text" name="selectFin" id="selectFin">
                          <option value="Seleccione">Seleccione</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>

                        </select>
                         <label>Fin</label>
                               </div>
                             </div>
                            </div>
                         
                        
                         <div class="text-center">
                            <button type="button" class="btn ripple-infinite btn-round btn-info"  onclick="enviar(0,0,0,'hailSatan')">Aceptar</button> 
                             <button type="button" class="btn ripple-infinite btn-round btn-warning" data-dismiss="modal">Cancelar</button>  
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