
	 
     <aside class="left-sidebar" >
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav"  >
                     <div align="center" id="loading-screen" style="display: none;">
                <img height="100px"  src="images/subir.gif">

            </div>
                    <ul id="sidebarnav"  >
                        <?php if($_SESSION["onModificar"]!="modificar"){ ?>
                        <li >
                            <a href="inicio.php" class="waves-effect"><i class="fa fa-home m-r-10" aria-hidden="true"></i>Inicio</a>
                        </li>
                        <li >
                            <a href="catalogo.php" class="waves-effect"><i class="fa fa-folder-open m-r-10" aria-hidden="true"></i>Catalogo de Cuentas</a>
                        </li>
                    <?php }else{ ?>
                       
                     <li>
                            <a href="#" class="btn btn-primary btn-md" style="color:white;font-size: 20px;" onclick="onCierre();"><i style="color:white;" class="fa fa-check m-r-10" aria-hidden="true"></i>Guardar Cambios</a>
                        </li>
                    <?php } ?>
                        <li>
                            <a href="table-basic.html" class="waves-effect"><i class="fa fa-table m-r-10" aria-hidden="true"></i>Libro Diario</a>
                            <ul class="submenu">
                        <?php if($_SESSION["onModificar"]=="modificar" || $_SESSION["onModificar"]=="normal"){ ?>
                        <li ><a href="diario.php">Insertar Asientos Contables</a></li>

                        <?php } ?><li><a class="waves-effect" href="verLibroDiario.php">Consultar Asientos Contables</a></li>
              

                    </ul>
                        </li>
                        <?php if($_SESSION["onModificar"]=="consultar" || $_SESSION["onModificar"]=="normal"){ ?>
                         <li >
                            <a href="table-basic.html" class="waves-effect"><i class="fa fa-calculator m-r-10" aria-hidden="true"></i>Estados Financieros</a>
                            <?php 

                            $consulta="SELECT * from periodo where estado=1";
        $result=$conexion->query($consulta);
        if($result){
            while ($fila=$result->fetch_object()) {
                $id=$fila->idperiodo;
            }
        }

                         $numAux=0;

                                  $resultA=$conexion->query("SELECT * FROM partida where tipo=2 and idperiodo='".$id."'");
                                  $numAux=$resultA->num_rows;
                        ?>
                            <ul class="submenu">
                        
                        <li ><a href="mayor.php">Libro Mayor</a></li>
                        <li><a  href="#" class="waves-effect" onclick="pideIF('estado','<?php echo $numAux;?>')">Estado Resultado</a></li>
                        <li><a href="#" class="waves-effect" onclick="pideIF('balance','<?php echo $numAux;?>')">Balance General</a></li>

                    </ul>
                        </li >
                    <?php } ?>
                       <?php if($_SESSION["usuario"][4]==0){
                       ## $usuario=$_SESSION["usuario"];
                        ?>
                            <?php if($_SESSION["onModificar"]!="modificar"){ ?>
                       <li > 
                            <a href="icon-fontawesome.html" class="waves-effect"><i class="fa fa-cog m-r-10" aria-hidden="true"></i>Opciones</a>
                            <ul class="submenu">
                                <?php    
                                include "config/conexion.php";
                                 $resultnumeros=$conexion->query("SELECT * FROM periodo where subestado=1");
                        $num=0;
                        $num=$resultnumeros->num_rows; if($num==0){?>
                       
                        <li><a href="#" onclick="onCierre();">Cierre del Ejercicio</a></li>
                    <?php   }else{ ?>
                        <li><a href="#" onclick="onNoCierre();">Cierre del Ejercicio</a></li>
                    <?php   } ?>
                        <li><a href="periodos.php">Consultar Periodos</a></li>
                        <li><a href="cuentas.php">Cuentas de Usuario</a></li>
                        <li><a href="ajustes.php">Datos de la empresa</a></li>
                        
                    </ul>
                        </li>
                    <?php }
                
                    } ?>
                    
                     <li>
                            <a href="#" onclick="onSalir();"><i class="fa fa-power-off m-r-10" aria-hidden="true"></i>Cerrar Sesion</a>
                        </li>
                    </ul>
                    <br><br>
                    
                        
                        
                       
                
                   
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>

