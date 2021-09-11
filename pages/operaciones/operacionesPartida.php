<?php
//Codigo que muestra solo los errores exceptuando los notice.
error_reporting(E_ALL & ~E_NOTICE);
?>
<?php
session_start();
$opcion=$_REQUEST["opcion"];
if ($opcion=="agregar") {
	$idcatalogo=$_GET["id"];
	$codigoCuenta=$_GET["codigo"];
	$montoPartida=$_GET["monto"];
	$accion=$_GET["movimiento"];
	if ($accion=="cargo") {
			$cargo=$montoPartida;
			$abono=null;
	}else {
		$abono=$montoPartida;
		$cargo=null;
	}
	$acumulador=$_SESSION["acumulador"];
	$matriz=$_SESSION["matriz"];
	$acumulador++;
	$matriz[$acumulador][0]=$idcatalogo;
	$matriz[$acumulador][1]=$cargo;
	$matriz[$acumulador][2]=$abono;
	$_SESSION['acumulador']=$acumulador;
	$_SESSION['matriz']=$matriz;
	impresion();
}
if($opcion=="quitar") {
	$indice=$_GET["id"];
	$matriz=$_SESSION['matriz'];
	$acumulador=$_SESSION['acumulador'];
	$acumulador--;
	$_SESSION["acumulador"]=$acumulador;
	unset($matriz[$indice]);//eliminacion de un indice en la matriz
	$_SESSION['matriz']=$matriz;
	impresion();
}
if($opcion=="mostrar") {
	impresion();
}if($opcion=="procesar") {

	$totalcargo=0;
  $totalabono=0;
  $acumulador=$_SESSION['acumulador'];
  $matriz=$_SESSION['matriz'];
  for ($i=1; $i <=$acumulador ; $i++) {
  	if (array_key_exists($i, $matriz)) {
  		$totalcargo=$totalcargo+$matriz[$i][1];
  		$totalabono=$totalabono+$matriz[$i][2];
  	}
  }
  if($totalcargo!=$totalabono)
  {
  	echo 3;
  }else
  {
    guardarPartida();
  }
}
if($opcion=="modificar") {

	$totalcargo=0;
  $totalabono=0;
  $acumulador=$_SESSION['acumulador'];
  $matriz=$_SESSION['matriz'];
  for ($i=1; $i <=$acumulador ; $i++) {
  	if (array_key_exists($i, $matriz)) {
  		$totalcargo=$totalcargo+$matriz[$i][1];
  		$totalabono=$totalabono+$matriz[$i][2];
  	}
  }
  if($totalcargo!=$totalabono)
  {
  	echo 3;
  }else
  {
    modificarPartida();
  }
}if($opcion=="cancelar"){
	unset($_SESSION["acumulador"]);
  unset($_SESSION["matriz"]);
  
  
  echo 1;
}if($opcion=="cargaModifi"){
	unset($_SESSION["acumulador"]);
  unset($_SESSION["matriz"]);
  unset($_SESSION["idp"]);
	include "../config/conexion.php";
	$idpartida=$_REQUEST["idpartida"];
	$acumulador=$_SESSION["acumulador"];
	$matriz=$_SESSION["matriz"];
	$_SESSION["idp"]=$idpartida;
	$acumulador++;
		
	
	

	$consulta="SELECT d.debe as debe,d.haber as haber,c.nombrecuenta as cuenta,c.saldo as saldo,c.idcatalogo as idcatalogo from detallepartida as d
INNER JOIN catalogo as c on d.idcatalogo=c.idcatalogo

where d.idpartida=$idpartida ORDER by debe DESC";
	
	$result=$conexion->query($consulta);

	if($result){
		while ($fila=$result->fetch_object()) {
		
			$matriz[$acumulador][0]=$fila->idcatalogo;
			$matriz[$acumulador][1]=$fila->debe;
			$matriz[$acumulador][2]=$fila->haber;
			$acumulador++;
		}
	}

	
	$_SESSION['acumulador']=$acumulador;
	$_SESSION['matriz']=$matriz;
	impresion();
}if($opcion=="cargaDatosP"){
	impresionModifi();
}


//NOTA SUPER IMPORTANTE DEBO METER TRANSACCIONES EN ESTE PROCESO PARA GARANTIZAR
// LA INTEGRIDAD DE LOS DATOS
function guardarPartida()
{
         
          include "../config/conexion.php";
          $conexion->autocommit(false);
          


  //OBTENER EL AÑO QUE SE ESTA TRABAJANDO
  $resultAnio=$conexion->query("select * from periodo where estado=1");
    if ($resultAnio)
    {
      while ($fila=$resultAnio->fetch_object())
      {
                      $idperiodo=$fila->idperiodo;
                      
      }
    }
  $concepto=$_REQUEST['concepto'];
  $fecha=$_REQUEST['fecha'];
  $acumulador=$_SESSION['acumulador'];
  $matriz=$_SESSION['matriz'];
  //codigo para obtener el numero de la partida.
 $result = $conexion->query("SELECT MAx(numpartida) as idpartida FROM partida where idperiodo=$idperiodo");
      $numeroPartida=-1;
      if($result){
        while($fila=$result->fetch_object()){
          $numeroPartida=$fila->idpartida;
        }
        $numeroPartida++;
      }
      $result = $conexion->query("SELECT MAx(idpartida) as idpartida FROM partida");
      $idpartida=-1;
      if($result){
        while($fila=$result->fetch_object()){
          $idpartida=$fila->idpartida;
        }
        $idpartida++;
      }
    //verificamos que haya un debe y haber
  $bandera=0;
  if(!empty($matriz))
  {
  	

    //codigo para guardar en la tabla partida
    $consulta  = "INSERT INTO `partida`(`idpartida`,`numpartida`, `idperiodo`, `fecha`, `detalle`, `estado`, `tipo`) VALUES ($idpartida,$numeroPartida,$idperiodo,$fecha,$concepto,1,0)";
    $resultado = $conexion->query($consulta);

    if ($resultado) {
    	$cont=0;
       for ($i=1; $i <=$acumulador ; $i++) {
    if (array_key_exists($i, $matriz)) {//verifica si existe el indice en la matriz antes de imprimir
      //codigo para libro diario
          $debe=0.0;
          $haber=0.0;

          $idcatalogo=$matriz[$i][0];
          
          $debe+=$matriz[$i][1];
          $haber+=$matriz[$i][2];
          $consulta  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,$idcatalogo,$debe,$haber)";
        
          $resultado = $conexion->query($consulta);
          if ($resultado) {
             $cont++;
          }else{
          	$bandera++;
          }
    }
  }
 

  if($cont==$acumulador){
  	echo 1;
  	 unset($_SESSION["acumulador"]);
  unset($_SESSION["matriz"]);
  }else{

  	echo -1;
  }
 

      } else {
      	$bandera++;
        echo -1;
    }

    if($bandera==0){
    	$conexion->commit();
      if($_SESSION["onModificar"]=="modificar"){
    
          $consulta="UPDATE `periodo` SET `subestado`=true where idperiodo='".$idperiodo."'";
        $conexion->query($consulta);
         $conexion->commit();
    
  }


    }else{
    	$conexion->rollback();
    }
  }
  
}
function modificarPartida()
{
          include "../config/conexion.php";
          $conexion->autocommit(false);
  
  
  $concepto=$_REQUEST['concepto'];
  $fecha=$_REQUEST['fecha'];
  $acumulador=$_SESSION['acumulador'];
  $matriz=$_SESSION['matriz'];
 $idpartida=$_SESSION["idp"];
    //verificamos que haya un debe y haber
  $bandera=0;
  if(!empty($matriz))
  {
  	//

    //codigo para guardar en la tabla partida
    $consulta  = "DELETE FROM `detallepartida` WHERE idpartida=".$idpartida;
    $resultado = $conexion->query($consulta);
    

    if ($resultado) {
    	$cont=1;
       for ($i=1; $i <=$acumulador ; $i++) {
    if (array_key_exists($i, $matriz)) {//verifica si existe el indice en la matriz antes de imprimir
      //codigo para libro diario
          $debe=0.0;
          $haber=0.0;

          $idcatalogo=$matriz[$i][0];
          
          $debe+=$matriz[$i][1];
          $haber+=$matriz[$i][2];
          $consulta  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,$idcatalogo,$debe,$haber)";
        
          $resultado = $conexion->query($consulta);
          
          if ($resultado) {
             $cont++;
          }else{
          	$bandera++;
          }
    }
  }
  
  if($cont==$acumulador){
  	echo 1;
  	 unset($_SESSION["acumulador"]);
  unset($_SESSION["matriz"]);
  }else{

  	echo -1;
  }
 

      } else {
      	$bandera++;
        echo -1;
    }

    if($bandera==0){
    	$conexion->commit();
       if($_SESSION["onModificar"]=="modificar"){
    
          $consulta="UPDATE `periodo` SET `subestado`=true where idperiodo='".$idperiodo."'";
          $result=$conexion->query($consulta);
         $conexion->commit();
    
  }
    }else{
    	$conexion->rollback();
    }
  }
  
}
function impresion()
{
?>


	<div class="responsive-table">
	<table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
	<thead>
		<tr>
		<th>Codigo</th>
			<th>Concepto</th>
			<th>Debe</th>
			<th>Haber</th>
			<th>Modificar</th>
		</tr>
		<?php
		$acumulador=$_SESSION['acumulador'];
		$matriz=$_SESSION['matriz'];
	for ($i=1; $i <=$acumulador ; $i++) {
		if (array_key_exists($i, $matriz)) {//verifica si existe elk indice en la matriz antes de imprimir
		 ?>
	</thead>
	<tbody>
		<tr>
			<?php
					include "../config/conexion.php";
          
					$idcatalogo=$matriz[$i][0];
					$result=$conexion->query("select * from catalogo where idcatalogo=".$idcatalogo." order by tipo");
					if ($result) {
	 		while ($fila=$result->fetch_object()) {
	 			$codigo=$fila->codigocuenta;
	 			$nombrecuenta=$fila->nombrecuenta;
	 		}
	 	}
			 ?>
			<td><?php echo $codigo; ?></td>
			<td><?php echo $nombrecuenta; ?></td>
			<td><?php echo $matriz[$i][1]; ?></td>
			<td><?php echo $matriz[$i][2]; ?></td>
			<td>
				<div class='col-md-2' style='margin-top:1px'>
					<button type="button"class='btn  btn-warning' onclick="agregarCuentaPartida('quitar','<?php echo $i ?>')">
						<div>
						<span>Quitar</span>
						</div>
					</button>
				</div>
			</td>
		</tr>
		<?php
	}
	}
	?>
	</tbody>
		</table>
	</div>
	<?php }
	function impresionModifi(){
		 include "../config/conexion.php";


  //OBTENER EL AÑO QUE SE ESTA TRABAJANDO
  $resultAnio=$conexion->query("select * from periodo where estado=1");
    if ($resultAnio)
    {
      while ($fila=$resultAnio->fetch_object())
      {
                     
                      $anioActivo=$fila->anio;
                      
      }
    }

		 $idpartida=$_REQUEST["idpartida"];
    $resultPartida=$conexion->query("SELECT * FROM partida where idpartida=$idpartida");
    if($resultPartida){
      while ($fil=$resultPartida->fetch_object()) {

      
        $fecha=$fil->fecha;
        $detalle=$fil->detalle;
        $numpartida=$fil->numpartida;
        
      }
    }?>

    
  	<div class="form-group form-animate-text"  style="margin-top:0px !important;">
          <input type="text" class="form-text" id="conceptoPartida" value="<?php echo $detalle; ?>" name="conceptoPartida" >
          <span class="bar"></span>
          <label>Concepto</label>
        </div>
        <div class="form-group form-animate-text" style="margin-top:30px !important;">
          <input type="date" class="form-text" value="<?php echo $fecha ?>" id="fechaPartida" name="fechaPartida" min="<?php echo $anioActivo; ?>-01-01" max="<?php echo $anioActivo; ?>-12-31">
          <span class="bar"></span>
        </div>
	

<?php } ?>

	

	


