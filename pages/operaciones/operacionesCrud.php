<?php 

	$opcion=$_REQUEST["opcion"];
	include "../config/conexion.php";
	$result = $conexion->query("select * from periodo where estado=1");

if($result)
{
  while ($fila=$result->fetch_object()) {
    $anioActivo=$fila->idperiodo;
  }
}

	if($opcion=="guardar"){
		include "../config/conexion.php";
$codigocuenta=$_REQUEST["codigo"];
            $nombrecuenta=$_REQUEST["nombre"];
            $tipo=$_REQUEST["tipo"];
            $saldo=$_REQUEST["saldo"];
            $nivel=$_REQUEST["nivel"];
            $codigocuenta=eliminaEspacios($codigocuenta);
            
             $consulta="SELECT * FROM `catalogo` WHERE codigocuenta=$codigocuenta and idperiodo=$anioActivo";
            
            $resultado = $conexion->query($consulta);
            $total=mysqli_num_rows($resultado);

            if($total>0){

                  echo 3;



            }else{
              /* 
               $consulta="INSERT INTO `catalogo`(`codigocuenta`, `nombrecuenta`, `tipo`, `saldo`, `nivel`) VALUES ('".$codigocuenta."','".$nombrecuenta."','".$tipo."','".$saldo."','".$nivel."')";*/

               

               try{
             $consulta="INSERT INTO `catalogo`(`codigocuenta`, `nombrecuenta`, `tipo`, `saldo`, `nivel`,`idperiodo`) VALUES ($codigocuenta,$nombrecuenta,$tipo,$saldo,$nivel,$anioActivo)";

            
             echo($conexion->query($consulta));
             
             
         }catch(Exception $e){
         	$conexion->rollback();
         	echo -1;
         }

            
            }
	}if($opcion=="edit"){
		include "../config/conexion.php";
		 $codigocuenta=$_REQUEST["codigo"];
            $nombrecuenta=$_REQUEST["nombre"];
            $tipo=$_REQUEST["tipo"];
            $saldo=$_REQUEST["saldo"];
            $nivel=$_REQUEST["nivel"];

           
		

            

            # $consulta="SELECT * FROM `catalogo` WHERE codigocuenta!=$codigocuenta AND nombrecuenta=$nombrecuenta";
           # $resultado = $conexion->query($consulta);
           #$total=$resultado->num_rows;
           
            #if($total >0){

	           #       echo 3;



           # }else{
                 
               
                $consulta="UPDATE `catalogo` SET `nombrecuenta`=$nombrecuenta WHERE codigocuenta=$codigocuenta and idperiodo=$anioActivo";
            

           	echo ($conexion->query($consulta));
           # }


        
	}
	if($opcion=="eliminar"){
		include "../config/conexion.php";
					$cuentaNueva="";
			$cuentaAntigua="";
			$codigocuenta="";


			if(isset($_REQUEST["cuentaNueva"]) && isset($_REQUEST["cuentaAntigua"])){

				$cuentaNueva=$_REQUEST["cuentaNueva"];
			$cuentaAntigua=$_REQUEST["cuentaAntigua"];
			}
			if(isset($_REQUEST["codigo"])){
			 $codigocuenta=$_REQUEST["codigo"];
			}

		




			if($codigocuenta!=""){
				include "../config/conexion.php";

				//se obtienen los datos de la cuenta para posteriormente obtener las subcuentas
				$resultCuenta=$conexion->query("SELECT * FROM catalogo where codigocuenta=$codigocuenta and idperiodo=$anioActivo");
				if($resultCuenta){
					while ($fila=$resultCuenta->fetch_object()) {
						$nivel=$fila->nivel;
						$codigo=$fila->codigocuenta;
					}
				}
				$nivel=$nivel+1;
				$longCuenta=strlen($codigo);
				//esta consulta obtiene las subcuentas 
				$consultaHijas="select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1',$longCuenta) as codigocorto,c.nivel as nivel, idperiodo as id FROM catalogo as c where SUBSTRING(c.codigocuenta,1,$longCuenta)=$codigocuenta and nivel=$nivel and c.idperiodo=1 ORDER BY c.codigocuenta ASC";


				$resultHijas=$conexion->query($consultaHijas);
				//si se encuentran subcuentas se mostrara un mensaje de lo contrario se procede al proceso de eliminacion 
				if($resultHijas->num_rows>0){

					echo 4;
				}else{
				$consulta="SELECT partida.idpartida from partida INNER JOIN detallepartida  on detallepartida.idpartida=partida.idpartida INNER JOIN catalogo on catalogo.idcatalogo=detallepartida.idcatalogo
						where catalogo.codigocuenta=$codigocuenta and catalogo.idperiodo=$anioActivo";
						
						$resultado=$conexion->query($consulta);
						
						 $total=$resultado->num_rows;
						           
						 if($total >0){
							echo (3);
						}else{
							eliminar($codigocuenta,$anioActivo);
						}
			  }
     
			}


				##Este codigo reemplaza la cuenta que se dese eliminar con la cuenta nueva
				##sustituyendo todas laspartidas en las que aparesca por l a nueva cuenta
				 	if($cuentaNueva!="" && $cuentaAntigua!=""){
				 		
				 		include "../config/conexion.php";
				 		
				 		
				 		$consulta="UPDATE detallepartida SET idcatalogo=$cuentaNueva WHERE  idcatalogo=$cuentaAntigua";
				 		
				 		
				 		$resultado=$conexion->query($consulta);

				 		if($resultado){
				 			 $consulta="DELETE FROM catalogo WHERE idcatalogo =$cuentaAntigua";
				   	       echo ($conexion->query($consulta));
				 		}
				 		/*echo $resultado=$conexion->query($consulta);

				 		echo "$resultado";
				 		if($resultado){
				 			eliminar($cuentaAntigua);
				 		}else{
				 			echo "errorazo";
				 		}*/
				 	}
}
	
function eliminar($codigo,$anioActivo){
				 		include "../config/conexion.php";
				 		
				   	       $consulta="DELETE FROM catalogo WHERE codigocuenta =$codigo and idperiodo=$anioActivo";
				   	      
				   	       echo ($conexion->query($consulta));
				 	}


				 	function eliminaEspacios($cadena){

	$cadena=str_replace(' ','',$cadena);
return $cadena;
}


 ?>
