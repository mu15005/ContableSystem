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
    <script type="text/javascript">
        function onModifica($idp){
             swal.fire({
                title: "Alterar Periodos anteriores podria acarrear problemas legales",
                text:"¿Desea Continuar?",
                type:"warning",
                showCancelButton: true,
                cancelButtonText:"No",
                confirmButtonText:"Si",
               


            }).then((result)=>{
              if(result.value){
                     $.post("operaciones/operacionesPeriodo.php",{opcion:"modificar",idperiodo:idp},function(data){
                     if(data==1){
                  
                         document.location.href="diario.php";
                     }else{

                     }
                        });
                    
              }
            })

        }
        function onGuardaCambios(idp){
                    swal({
              title: "Inventario Final",
        input: "text",
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        inputValidator: nombre => {
            // Si el valor es válido, debes regresar undefined. Si no, una cadena
            if (!nombre || isNaN(nombre)) {
                return "Por Favor Ingresar Un Monto Valido";
            } else {
                return undefined;
            }
        }


            })
    .then(resultado => {
        if (resultado.value) {
            let nombre = resultado.value;
            $.post("CierreCorregido.php",{if:nombre,onModifiPeriodo:"true",idperiodo:idp},function(data){
             
               if(data==1){
                mostrarMensaje("Exito","success",1000);
               }else{
                mostrarMensaje("Ocurrio un Error inesperado","error",1000);
               }
            });
        }
    });
        }
        function onConsulta(idp){
           
             $.post("operaciones/operacionesPeriodo.php",{opcion:"consultar",idperiodo:idp},function(data){
                   

                <?php if(isset($_SESSION['onModificar'])) {?>
                   
                     
                        <?php } ?>



                     if(data=="1"){
                       
                      
                        document.location.href="verLibroDiario.php";

                     }else{
                        
                        
                     }
                        });
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
                            <li class="breadcrumb-item active"></li>
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
                             <div class="text-center"><h2>Bienvenido</h2></div>
                                <div class="panel-body" id="tablaCuenta">
                    <?php 


                     $consulta="SELECT * FROM periodo order by anio";
                    
                     ?>

                        <div class="row">
                            <div class="col-md-1">
                                
                            </div>
                            <div class="col-md-10">
                                
                            <div class="responsive-table">              
                                         
            <table class="table"  id="tablaDatos">
                <thead>
                    <tr >
                        
                        <th>Num</th>
                        <th>Año</th>
                        <th>Estado</th>
                       
                        
                    </tr>
                </thead>
                <tbody id="tbodys">
                  
                     <?php

                        $resultnumeros=$conexion->query("SELECT * FROM periodo where subestado=1");
                        $num=0;
                        $resultmax=$conexion->query("SELECT max(idperiodo) as maxi from periodo");
                        $max=0;
                        if($resultmax){
                            while ($fil=$resultmax->fetch_object()) {
                                $max=$fil->maxi;
                            }
                        }
                        $num=$resultnumeros->num_rows;                
                        $result = $conexion->query($consulta);

                     

                if ($result) {
                   
                while ($fila = $result->fetch_object()) { ?>
                    

                                <tr>
                                   
                                    <td><?php echo $fila->idperiodo; ?></td>
                                    <td><?php echo $fila->anio; ?></td>
                                    <td><?php echo $fila->estado==0? "Anterior" : "Actual"; ?></td>
                                    

                                   
                                    <td class="text-center">


                                 
                                            
                                            <button type="button" class="btn ripple-infinite btn-round btn-primary"   onclick="onConsulta(<?php echo $fila->idperiodo ?>);">Consultar</button>
                                          
                                            
                                               

                                       </td>
                                </tr>
                            <?php 
                            } 
                        }?>
                               </tbody>
                        </table>
                                </div>
                            </div>
                            <div class="col-md-1">
                                
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
    <script src="../assets/js/menu.js"></script>

    <script src="../assets/js/ace-elements.min.js"></script>
        <script src="../assets/js/ace.min.js"></script>

        <!-- SweetAlert Plugin Js -->
        <script src="sweetalert/sweetalert2.min.js"></script>

     
</body>
</html>
