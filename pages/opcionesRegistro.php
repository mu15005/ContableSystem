<?php 
session_start();
include "config/conexion.php";
$opcion="";
if(isset($_REQUEST["opcion"])){
   $opcion=$_REQUEST["opcion"]; 
}
  
  $totalFilas=0;
  $result=$conexion->query("SELECT * FROM ajustes");
  if($result){
  $totalFilas=$result->num_rows;
}

if($opcion==""){
if($totalFilas==0){
  registro();
}else{
  login();
}
}


if($opcion=="guardar"){
  guardaRegistro();
}if($opcion=="login"){
  $nombre=$_REQUEST["nombre"];
  $clave=$_REQUEST["clave"];
  $clave=hash("sha256",$clave);

  $consulta="SELECT * FROM usuario where nombre='".$nombre."' and clave='".$clave."'";
  $num=0;
  $result=$conexion->query($consulta);
  $num=$result->num_rows;
  if ($num>0) {
    $usuario=$result->fetch_array();
    $_SESSION["usuario"]=$usuario;
    $_SESSION["onModificar"]="normal";

   
     //header("location:catalogo.php");


        $consulta="SELECT max(idperiodo) as id from `periodo`";
    $result=$conexion->query($consulta);
    if($result){
      while ($fila=$result->fetch_object()) {
        $id=$fila->id;
      }
    }

      $consulta="UPDATE `periodo` SET `estado`=false";
        $result=$conexion->query($consulta);
        if($result){
            $consulta="UPDATE `periodo` SET `estado`=true WHERE idperiodo='".$id."'";
          $result=$conexion->query($consulta);
       
        }

    echo 1;
  }
}if($opcion=="salir"){
  session_destroy();
 echo 1;
}
function guardaRegistro(){
  include "config/conexion.php";
  $conexion->autocommit(false);

$fotop=addslashes(file_get_contents($_FILES['fotop']['tmp_name']));
$nombre=$_POST["nombre"];
$clave=$_POST["clave"];
$moneda=$_POST["moneda"];
$nombreempresa=$_POST["nombreempresa"];
$fotoe=addslashes(file_get_contents($_FILES['fotoe']['tmp_name']));
$clave=hash("sha256",$clave);
$anio=$_REQUEST["anio"];

$consulta1="INSERT INTO `usuario`(`nombre`, `clave`, `imagen`, `acceso`) VALUES ('".$nombre."','".$clave."','".$fotop."',0)";



 $consulta2="INSERT INTO `ajustes`(`moneda`, `logo`, `nombreempresa`) VALUES ('".$moneda."','".$fotoe."','".$nombreempresa."')";

 $consulta3="INSERT INTO `periodo`(`anio`, `estado`, `subestado`) VALUES ('".$anio."',true,false)";



echo $conexion->error;
 if(($conexion->query($consulta1))==1 &&  ($conexion->query($consulta2))==1 || ($conexion->query($consulta3))==1){



 
  $conexion->commit();

  $consulta="SELECT * FROM usuario where nombre='".$nombre."' and clave='".$clave."'";
  $num=0;
  $result=$conexion->query($consulta);
  $num=$result->num_rows;
  if ($num>0) {
    $usuario=$result->fetch_array();
    $_SESSION["usuario"]=$usuario;
    $_SESSION["onModificar"]="normal";

   
     //header("location:catalogo.php");


        $consulta="SELECT max(idperiodo) as id from `periodo`";
    $result=$conexion->query($consulta);
    if($result){
      while ($fila=$result->fetch_object()) {
        $id=$fila->id;
      }
    }

      $consulta="UPDATE `periodo` SET `estado`=false";
        $result=$conexion->query($consulta);
        if($result){
            $consulta="UPDATE `periodo` SET `estado`=true WHERE idperiodo='".$id."'";
          $result=$conexion->query($consulta);
       
        }

    echo 1;
  }
 }else{
  echo 2;
  $conexion->rollback();
 }

}
function registro(){
 ?>

  

          
  
        <!--<div class="image"></div>-->
        
             <div class="row">
                <input type="hidden" name="opcion" id="opcion" value="guardar">
      <div class="col-md-6 top-20 padding-10 ">
        <h5 style="padding-left: 10%;">Datos de Usuario</h5><br>
          
              
                            <div class="wrap-input100 validate-input" data-validate = "Ingrese Nombre De Usuario">
                               <i style="padding-left: 10%;top: 30px;position: relative;" class="fa fa-user m-r-10" ></i>
            <input class="input100" type="text" name="nombre" id="nombre" placeholder="Nombre De Usuario">
            
          </div>
                           <div class="wrap-input100 validate-input"  data-validate="Ingrese una clave">
                             <i style="padding-left: 10%;top: 30px;position: relative;" class="fa fa-lock m-r-10" ></i>
            <input class="input100" type="password" id="clave" name="clave" placeholder="Contraseña">
            
          </div>

                           <div class="wrap-input100 validate-input" data-validate="Ingrese Una Clave">
                             <i style="padding-left: 10%;top: 30px;position: relative;" class="fa fa-lock m-r-10" ></i>
            <input class="input100" type="password" id="clave1" name="clave1" placeholder="Repita Contraseña">
            
          </div>
<div class="wrap-input100 validate-input" data-validate="Enter password">
   <i style="padding-left: 10%;top: 30px;position: relative;" class="fa fa-photo m-r-10" ></i>
            <input class="input100" type="file" id="fotop" name="fotop" placeholder="Ingrese Foto">
           
          </div>
                
            
      </div>
      <div class="col-md-6 top-20 padding-10 ">
        <h5 style="padding-left: 10%;">Ajustes Principales</h5><br>

         <div style="padding-left: 50px;" class="wrap-input100 validate-input" data-validate="Ingrese Formato Moneda">
           <i style="padding-left: 0%;top: 25px;position: relative;" class="fa fa-money m-r-10" ></i>
            <label class="input100" style="padding-left: 20px;">Moneda</label>
            <select name="moneda" style="width: 75%;padding-left: 40px;top:5%;" class="input100" id="moneda">
                      <option value="SELECCIONE">SELECCIONE</option>
                      <option value="1">Dolares $</option>
                      <option value="2">Euros €</option>
                    </select>
                    
                   </div>

                    

                   <div class="wrap-input100 validate-input" data-validate="Ingrese una clave">
                     <i style="padding-left: 10%;top: 30px;position: relative;" class="fa fa-users m-r-10" ></i>
            <input class="input100" type="text" id="nombreempresa" name="nombreempresa" placeholder="Nombre Empresa">
            
          </div>

                            <div class="wrap-input100 validate-input" data-validate="Enter password">
                               <i style="padding-left: 10%;top: 30px;position: relative;" class="fa fa-photo m-r-10" ></i>
            <input class="input100" type="file" id="fotoe" name="fotoe" placeholder="Ingrese Foto">
           
          </div>
                

                             <div class="wrap-input100 validate-input" data-validate="Ingrese una clave">
                               <i style="padding-left: 10%;top: 30px;position: relative;" class="fa fa-calendar m-r-10" ></i>
            <input class="input100" type="text" id="anio" name="anio" placeholder="Año Primer Periodo">
            <span class="focus-input100" data-placeholder="&#xe836;"></span>
          </div>

      </div>
  </div>
    <div class="form-group text-center">
                    <input  type="button" value="Guardar" id="guardar"  name="guardar" class="btn ripple-infinite btn-round btn-success"  onclick="onGuardar();">
                </div>

<?php }function login(){ ?>

	

          <div class="wrap-input100 validate-input" data-validate = "Enter username">
             <i style="padding-left: 10%;top: 30px;position: relative;" class="fa fa-user m-r-10" ></i>
            <input class="input100" type="text" name="nombre" id="nombre" placeholder="Nombre De Usuario">
           
          </div>

          <div class="wrap-input100 validate-input" data-validate="Enter password">
            <i style="padding-left: 10%;top: 30px;position: relative;" class="fa fa-lock m-r-10" ></i>
            <input class="input100" type="password" id="clave" name="clave" placeholder="Contraseña">
            
          </div>

          <div class="container-login100-form-btn m-t-32">
            <button type="button" class="btn btn-success btn-lg" onclick="onLogin();" style="width: 250px;">
              Ingresar
            </button>
          </div>

       

    <?php }

 ?>