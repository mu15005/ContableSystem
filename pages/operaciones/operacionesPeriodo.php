<?php

include "../config/conexion.php"; 
	$opcion="me la pelas kira";
	$idperiodo="";

	if(isset($_REQUEST["opcion"])){
		$opcion=$_REQUEST["opcion"];
	}
	if(isset($_REQUEST["idperiodo"])){
		$idperiodo=$_REQUEST["idperiodo"];
	}
$consulta="SELECT max(idperiodo) as id from `periodo`";
		$result=$conexion->query($consulta);
		if($result){
			while ($fila=$result->fetch_object()) {
				$id=$fila->id;
			}
		}

		if($idperiodo==$id){
				$consulta="UPDATE `periodo` SET `estado`=false";
				$result=$conexion->query($consulta);
				if($result){
						$consulta="UPDATE `periodo` SET `estado`=true WHERE idperiodo='".$idperiodo."'";
					$result=$conexion->query($consulta);
					if($result){
						session_start();
							$_SESSION["onModificar"]="normal";
							echo 1;
					}else{
							echo 2;
					}
				}else{
					echo 2;
				}

		}else{
			if ($opcion=="consultar") {
					$consulta="UPDATE `periodo` SET `estado`=false";
					$result=$conexion->query($consulta);
					if($result){
						$consulta="UPDATE `periodo` SET `estado`=true WHERE idperiodo='".$idperiodo."'";
						$result=$conexion->query($consulta);
							if($result){
									session_start();
									$_SESSION["onModificar"]="consultar";

						
								echo 1;
							}else{
								echo 2;
							}
					}else{
						echo 2;
					}
	}if($opcion=="modificar"){

			$idperiodo=$_REQUEST["idperiodo"];
					$consulta="UPDATE `periodo` SET `estado`=false";
					$result=$conexion->query($consulta);
					if($result){
						$consulta="UPDATE `periodo` SET `estado`=true WHERE idperiodo='".$idperiodo."'";

						$result=$conexion->query($consulta);
							if($result){
								session_start();
								$_SESSION["onModificar"]="modificar";
								echo 1;
							}else{
								echo 2;
							}
					}else{
						echo 2;
					}
		
	}
			
		}



	
 ?>