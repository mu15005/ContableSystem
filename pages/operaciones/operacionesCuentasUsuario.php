
               <?php
              session_start();
//Codigo que muestra solo los errores exceptuando los notice.
error_reporting(E_ALL & ~E_NOTICE);
?>
<?php
// este documento se encarga de devolver los campos de las ventanas modales 
// de registro nuvo catalogo y el de detalle de catalogo

include '../config/conexion.php';
$band="";
$band=$_REQUEST["band"];

$opcion="";
$opcion=$_REQUEST["opcion"];
$idusuario="";
if(isset($_REQUEST["idusuario"])){
  $idusuario=$_REQUEST["idusuario"];
}

$idus="";
if(isset($_REQUEST["idus"])){
  $idus=$_REQUEST["idus"];
}



  $nombre="";
  $foto="";
  $acceso="";

  $consulta="SELECT * FROM `usuario` where idusuario=".$idusuario;
  $resultado=$conexion->query($consulta);
  if($resultado){
    while ($fila=$resultado->fetch_object()) {
     $nombre=$fila->nombre;
     $foto=$fila->imagen;
     $acceso=$fila->acceso;
    }
  }


mostrar($idusuario,$nombre,$foto,$acceso,$opcion,$band);


//la funcion mostrar devuelve el contenido de las ventanas modales dependiendo la opcion 
function mostrar($idusuario,$nombre,$foto,$acceso,$opcion,$band){
  include "../config/conexion.php";


   if($band=='guardarNuevo'){
             

                $fotop=addslashes(file_get_contents($_FILES['fotop']['tmp_name']));
                $nombre=$_POST["nombre"];
                $clave=$_POST["clave"];
                $idusuario=$_POST["idusuario"];
                $acceso=$_POST["acceso"];
                $clave=hash("sha256",$clave);
                $consulta1="INSERT INTO `usuario`(`nombre`, `clave`, `imagen`, `acceso`) VALUES ('".$nombre."','".$clave."','".$fotop."','".$acceso."')";





                 if(( $conexion->query($consulta1))==1){
                  echo 1;
                 
                 }else{
                  echo 2;
                 
                 }



             }
            if($band=="guardarModificacion"){ 
                include '../config/conexion.php';

          $fotop=addslashes(file_get_contents($_FILES['fotop']['tmp_name']));
          $nombre=$_POST["nombre"];
          $clave=$_POST["clave"];
          $idusuario=$_POST["idus"];
          $acceso=$_POST["acceso"];
          $clave=hash("sha256",$clave);
          $consulta1="UPDATE `usuario` SET `nombre`='".$nombre."',`clave`='".$clave."',`imagen`='".$fotop."',`acceso`='".$acceso."' WHERE idusuario=".$idusuario;




           echo $conexion->query($consulta1);
           echo $conexion->error;
          

      
}if($band=="eliminar"){
   $idusuario=$_POST["idus"];
          $consulta1="DELETE FROM `usuario` WHERE idusuario='".$idusuario."'";




          echo $conexion->query($consulta1);
          

}

switch ($opcion) {

           
      case 'agregar':
    ?>
             
                                    
                 <input type="hidden" name="band" id="band" value="guardarNuevo"> 

                    <label class="form__label" style="top:0%;">Nombre</label>
                    <input type="text" name="nombre" class="form__field" style="width: 96%;" value="<?php echo($nombre); ?>" id="nombre"><br><br> 
                   
                       <label class="form__label" style="top:15%;">clave</label>
                                        <input type="password"  class="form__field" name="clave" id="clave" style="width: 48%;" value="">
                    
                                    
                    <label class="form__label" style="top:15%;">Rep.Calve</label>
                    <input type="password" name="clave1" class="form__field" style="width: 48%;padding-left:2px;" value="" id="clave1"><br><br>
                

                    
                    <div class="form-group form-animate-text" style="margin-top:50px !important;">
                    <select name="acceso" id="acceso" class="form-text"   style="width: 98%;color:#526470;">
                     <option value="SELECCIONE"   >SELECCIONE</option>
                                      <option value="0" >Administrador</option>
                                      <option value="1">Usuario Normal</option>
                                              
                    </select><br>
                    <label style="top:-40px;font-size: 20px;color:#5264AE">Acceso</label>
                    </div>

                  
                                    
                    <label class="form__label" style="top: 64%;">Foto De Perfil</label>
                    <input type="file" name="fotop" class="form__field" style="width: 98%;padding-left:50px;" value="" id="fotop"><br><br>
                    
                    <div class="form-group text-center">
                        
         
                    <input  type="button"  value="Cerrar"  class="btn ripple-infinite btn-round btn-info"   data-dismiss="modal">
         <input  type="button" value="Guardar" id="guardar"  name="guardar" class="btn ripple-infinite btn-round btn-success"  onclick="onGuardar();">
                                   



    <?php 
      break;
    
      case 'mostrar':
    ?>
      <script type="text/javascript">
        cargaSelect('<?php echo $acceso; ?>');
      </script>
      
                           <input type="hidden" name="idus" id="idus" value="<?php echo $idusuario ?>">


               
                                    
                 <input type="hidden" name="band" id="band" value="mostrar"> 

                    <label class="form__label" style="top:0%;">Nombre</label>
                    <input type="text" name="nombre" class="form__field" disabled="true" style="width: 96%;" value="<?php echo($nombre); ?>" id="nombre"><br><br> 


                       <label class="form__label" style="top:15%;" >clave</label>
                                        <input type="password" disabled="true"  class="form__field" name="clave" id="clave" style="width: 48%;" value="">
                    
                                    
                    <label class="form__label" style="top:15%;">Rep.Calve</label>
                    <input type="password" name="clave1" class="form__field" disabled="true" style="width: 48%;padding-left:2px;" value="" id="clave1"><br><br>
                

                    
                    <div class="form-group form-animate-text" style="margin-top:50px !important;">
                    <select name="acceso" id="acceso" class="form-text"  disabled="true" style="width: 98%;color:#526470;">
                     <option value="SELECCIONE"   >SELECCIONE</option>
                                      <option value="0" >Administrador</option>
                                      <option value="1">Usuario Normal</option>
                                              
                    </select><br>
                    <label style="top:-40px;font-size: 20px;color:#5264AE">Acceso</label>
                    </div>

                  
                                    
                    <label class="form__label" style="top: 64%;">Foto De Perfil</label>
                    <input type="file" name="fotop" class="form__field" disabled="true" style="width: 98%;padding-left:50px;" value="" id="fotop"><br><br>
                    
                    <div class="form-group text-center">
                        
                                        <input  type="button"  value="Cerrar" style="width: 150px;" class="btn ripple-infinite btn-round btn-info"   data-dismiss="modal">
                                   
                                    <button  type="button" id="modifi" name="modifi"onclick="cargaDato('modificar',<?php echo "$idusuario"; ?>,'formD')" class="btn ripple-infinite btn-round btn-success">Modificar</button>   
                                     <button  type="button" id="delete" name="delete" onclick="onDelete()" class="btn ripple-infinite btn-round btn-danger">Eliminar</button>
                                   </div>
                                   


    <?php  
  break;
    
  case 'modificar':

  $idusuario="";
if(isset($_REQUEST["idusuario"])){
  $idusuario=$_REQUEST["idusuario"];
}

    ?>
     <script type="text/javascript">
        cargaSelect('<?php echo $acceso; ?>');
      </script>
                
                     
                          
                 <input type="hidden" name="idus" id="idus" value="<?php echo $idusuario ?>">


                                    
                 <input type="hidden" name="band" id="band" value="guardarModificacion"> 

                    <label class="form__label" style="top:0%;">Nombre</label>
                    <input type="text" name="nombre" class="form__field" style="width: 96%;" value="<?php echo($nombre); ?>" id="nombre"><br><br> 


                       <label class="form__label" style="top:15%;">clave</label>
                                        <input type="password"  class="form__field" name="clave" id="clave" style="width: 48%;" value="">
                    
                                    
                    <label class="form__label" style="top:15%;">Rep.Calve</label>
                    <input type="password" name="clave1" class="form__field" style="width: 48%;padding-left:2px;" value="" id="clave1"><br><br>
                

                    
                    <div class="form-group form-animate-text" style="margin-top:50px !important;">
                    <select name="acceso" id="acceso" class="form-text"   style="width: 98%;color:#526470;">
                     <option value="SELECCIONE"   >SELECCIONE</option>
                                      <option value="0" >Administrador</option>
                                      <option value="1">Usuario Normal</option>
                                              
                    </select><br>
                    <label style="top:-40px;font-size: 20px;color:#5264AE">Acceso</label>
                    </div>

                  
                                    
                    <label class="form__label" style="top: 64%;">Foto De Perfil</label>
                    <input type="file" name="fotop" class="form__field" style="width: 98%;padding-left:50px;" value="" id="fotop"><br><br>
                    
                    <div class="form-group text-center">
                         <input  type="button"  value="Cerrar" style="width: 150px;" class="btn ripple-infinite btn-round btn-info"   data-dismiss="modal">
         
                    <input  type="button"  value="Cerrar"  class="btn ripple-infinite btn-round btn-info"   data-dismiss="modal">
         <input  type="button" value="Guardar" id="guardar"  name="guardar" class="btn ripple-infinite btn-round btn-success"  onclick="onModificar();">
           <button  type="button" id="delete" name="delete" onclick="onDelete()" class="btn ripple-infinite btn-round btn-danger">Eliminar</button>
       </div>
                                   
                                     
<?php  
  break;
  case "impresion" : 

   $pagina=1;
if(isset($_POST["pagina"])){
  $pagina=$_POST["pagina"];
}


 $busqueda="";
    if(isset($_POST["busqueda"])){

  $busqueda=$_POST["busqueda"];
}
  $idUsActual=$_SESSION["usuario"][0];
    $result=$conexion->query("SELECT * FROM usuario where idusuario!=$idUsActual and  (nombre LIKE '%".$busqueda."%' or acceso LIKE '%".$busqueda."%') order by nombre");
   
    $totalCuentas=($result->num_rows);


    $elementoPP=4;
       $totalPaginas=($totalCuentas/$elementoPP);
    $totalPaginas=ceil($totalPaginas);
    $inicio=($pagina-1)*$elementoPP;
   

     $consulta="SELECT * FROM usuario where idusuario!=$idUsActual and (nombre LIKE '%".$busqueda."%' or acceso LIKE '%".$busqueda."%')  order by nombre LIMIT ".$inicio.",".$elementoPP;
    
     ?>




<div class="responsive-table">              
                   
            <table class="table"  id="tablaDatos">
                <thead>
                    <tr >
                        
                        <th>Nombre de Usuario</th>
                        <th>Acceso</th>
                        <th>Foto</th>
                       
                        
                    </tr>
                </thead>
                <tbody id="tbodys">
                  
                     <?php

                   
                     
                        $result = $conexion->query($consulta);

                     

                if ($result) {
                   
                while ($fila = $result->fetch_object()) { ?>
                    

                                <tr>
                                   
                                    <td><?php echo $fila->nombre; ?></td>

                                    <td><?php echo $fila->acceso==0? "Administrador" : "Usuario Normal"; ?></td>
                                    <td><img width="50px;" height="70px;" src="data:image/jpg;base64,<?php echo base64_encode($fila->imagen); ?>"></td>

                                   
                                    <td class="text-center">


                                 

                                            <button type="button" class="btn ripple-infinite btn-round btn-info"  data-toggle="modal" data-target="#miModalDetalles" onclick="cargaDato('mostrar',<?php echo($fila->idusuario) ?>,'formD');">Ver Detalles</button>
                                      
                                       </td>
                                </tr>
                            <?php }
                            } ?>
                               
                        </table>
                   

 <nav aria-label="paginacion">
                <ul class="pagination pagination-sm">
               <?php 
              $primera = ($pagina - 3) > 1 ? $pagina - 3 : 1;
$ultima = ($pagina + 3) < $totalPaginas ? $pagina + 3 : $totalPaginas;



?>

                 
          <li class="page-item 
                  <?php echo ($pagina<=1)? 'disabled' : '' ?>" >
                    <a href="#" onclick='cargaCuentas("<?php echo ($pagina-1); ?>");' class="page-link" aria-label="Ant">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                    
                  </li>
                  
                   <li class="page-item  <?php echo $pagina==1 ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='cargaCuentas("<?php echo 1; ?>");'><?php echo 1; ?></a></li>
                   <?php if($pagina>4){ ?>
                    <li class="page-item"><a href="#" class="page-link">...</a></li>

                  <?php } ?>
                
            <?php 

            $ultima=$ultima-1;
            for ($i=$primera; $i < $ultima; $i++) {?>

                  <li class="page-item  <?php echo $pagina==($i+1) ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='cargaCuentas("<?php echo ($i+1); ?>");'><?php echo ($i+1); ?></a></li>


             <?php 
                }?>
                
                <?php if($pagina<($totalPaginas-3)){ ?>
                    <li class="page-item"><a href="#" class="page-link">...</a></li>

                  <?php } 
                   if($totalPaginas>1){ ?>
                  <li class="page-item  <?php echo $pagina==$totalPaginas ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='cargaCuentas("<?php echo ($totalPaginas); ?>");'><?php echo $totalPaginas; ?></a></li>
                <?php } ?>

                 <li class="page-item <?php echo $pagina>=$totalPaginas ? 'disabled' : ''; ?>">
                    <a href="#" onclick='cargaCuentas("<?php echo ($pagina+1); ?>");' class="page-link" aria-label="Sig">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                    
                  </li>
                 </ul>
               </nav>









 <?php break;
      case "modificaAjuste":



$moneda=$_POST["moneda"];
$nombreempresa=$_POST["nombreempresa"];
$fotoe=addslashes(file_get_contents($_FILES['fotoe']['tmp_name']));
      $idajuste=$_REQUEST["idajuste"];
      $consulta="UPDATE `ajustes` SET `moneda`='".$moneda."',`logo`='".$fotoe."',`nombreempresa`='".$nombreempresa."' WHERE idajuste='".$idajuste."'";

      echo $conexion->query($consulta);

      break;
      case "modificarMiCuenta" :
              include "../config/conexion.php";
                $fotop=addslashes(file_get_contents($_FILES['fotop']['tmp_name']));
                $nombre=$_POST["nombre"];
                $clave=$_POST["clave"];
                $idusuario=$_POST["idusuario"];
                $acceso=$_POST["acceso"];
                $clave=hash("sha256",$clave);
                $consulta="UPDATE `usuario` SET `nombre`='".$nombre."',`clave`='".$clave."',`imagen`='".$fotop."',`acceso`='".$acceso."' WHERE idusuario='".$_SESSION["usuario"][0]."'";
               

                $conexion->query($consulta);
                echo $conexion->error;;

     if($conexion->query($consulta)==1){
    $consulta="SELECT * FROM usuario where idusuario='".$_SESSION["usuario"][0]."'";
                                      $num=0;
                                      $result=$conexion->query($consulta);
                                     echo $conexion->error;
                                      if ($result) {
                                        $usuario=$result->fetch_array();
                                        $_SESSION["usuario"]=$usuario;
                                        //echo $usuario[1];
                                       echo 1;
                                        }
        }else{
          echo 2;
        }



      break;
       }

       

   }
    ?>


