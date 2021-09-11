<?php 
	//este documento php obtiene los registros de las partidas existente
//para ser mostrados mediante una peticion jquery en el documento mostrarLibroD.php
	session_start();
	$opcion="";	
	$opcion=$_REQUEST["opcion"];
	include "config/conexion.php";
	


$result = $conexion->query("select * from periodo where estado=1");

if($result)
{
  while ($fila=$result->fetch_object()) {
    $idperiodo=$fila->idperiodo;
  }
}
$pagina=1;
if(isset($_POST["pagina"])){
  $pagina=$_POST["pagina"];
}


 $busqueda="";
    if(isset($_POST["busqueda"])){

  $busqueda=$_POST["busqueda"];
}

    $result=$conexion->query("SELECT * FROM partida where idperiodo='".$idperiodo."'  and (fecha LIKE '%".$busqueda."%' OR detalle LIKE '%".$busqueda."%') order by numpartida");
    $totalCuentas=($result->num_rows);


    $elementoPP=6;
       $totalPaginas=($totalCuentas/$elementoPP);
    $totalPaginas=ceil($totalPaginas);
    $inicio=($pagina-1)*$elementoPP;
   

     $consultaD="SELECT * FROM partida where idperiodo='".$idperiodo."'  and (fecha LIKE '%".$busqueda."%' OR detalle LIKE '%".$busqueda."%') order by numpartida LIMIT ".$inicio.",".$elementoPP;




if ($opcion=="mostrar") {?>
<div class="responsive-table">                      
            <table class="table"  id="tablaDatos">
				<tr>
					<td>N° Partida</td>
					<td>Fecha</td>
					<td>Detalle</td>
					<td>Estado</td>
				</tr>
				<?php 
			
				$result=$conexion->query($consultaD);
				if($result){
		while ($fila=$result->fetch_object()) {
			?>
				<tr>
					<td><?php echo $fila->numpartida; ?></td>
					<td><?php echo $fila->fecha; ?></td>
					<td><?php echo $fila->detalle; ?></td>
					<?php  if($fila->estado){
						echo "<td>Activa</td>";

					}else{
						echo "<td>Eliminada</td>";
					}?>
					<td><button type="button" class="btn ripple-infinite btn-round btn-info"   onclick="cargaDetalles('detalle',<?php echo($fila->idpartida); ?>);">Ver Detalles</button>
						
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
                    <a href="#" onclick='paginacion("<?php echo ($pagina-1); ?>");' class="page-link" aria-label="Ant">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                    
                  </li>
                  
                   <li class="page-item  <?php echo $pagina==1 ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='paginacion("<?php echo 1; ?>");'><?php echo 1; ?></a></li>
                   <?php if($pagina>4){ ?>
                    <li class="page-item"><a href="#" class="page-link">...</a></li>

                  <?php } ?>
                
            <?php 

            $ultima=$ultima-1;
            for ($i=$primera; $i < $ultima; $i++) {?>

                  <li class="page-item  <?php echo $pagina==($i+1) ? 'active' : ''; ?>"><a href="#" class="page-link"onclick='paginacion("<?php echo ($i+1); ?>");'><?php echo ($i+1); ?></a></li>


             <?php 
                }?>
                
                <?php if($pagina<($totalPaginas-3)){ ?>
                    <li class="page-item"><a href="#" class="page-link">...</a></li>

                  <?php }
                   if($totalPaginas>1){ ?>
                  <li class="page-item  <?php echo $pagina==$totalPaginas ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='paginacion("<?php echo ($totalPaginas); ?>");'><?php echo $totalPaginas; ?></a></li>
                <?php } ?>
                 <li class="page-item <?php echo $pagina>=$totalPaginas ? 'disabled' : ''; ?>">
                    <a href="#" onclick='paginacion("<?php echo ($pagina+1); ?>");' class="page-link" aria-label="Sig">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                    
                  </li>
                 </ul>
               </nav>
           </div>

		<?php

}if($opcion=="detalle"){
	$idpartida=$_REQUEST["idpartida"];

	//include "config/conexion.php";

		$resultPartida=$conexion->query("SELECT * FROM partida where idpartida=$idpartida");
		if($resultPartida){
			while ($fil=$resultPartida->fetch_object()) {

				$estado=$fil->estado;
				$fecha=$fil->fecha;
				$detalle=$fil->detalle;
				$numpartida=$fil->numpartida;
				$tipo=$fil->tipo;
			}
		}?>

		<label for="num" class="form__label">N° Partida</label>
	<input type="text" id="num" class="form__field" readonly="true" value="<?php echo $numpartida; ?>">

	<label for="fech" class="form__label">Fecha</label>
	<input type="text" id="fech" readonly="true" class="form__field" value="<?php echo $fecha; ?>">

	<label for="est" class="form__label">Estado</label>
	<input type="text" id="est" readonly="true" class="form__field" value="<?php echo $estado==1? 'Activo':'Eliminada'; ?>">
	<br>

	
	
	
	<table class="table table-striped table-bordered" width="100%" cellspacing="0"  id="tablaDatos">
		<tr>
			<td>Cuenta</td>
			<td>Debe</td>
			<td>Haber</td>

		</tr>

		<?php 
		$debe=0;
		$haber=0;
		
		
	$consulta="SELECT d.debe as debe,d.haber as haber,c.nombrecuenta as cuenta,c.saldo as saldo from detallepartida as d
INNER JOIN catalogo as c on d.idcatalogo=c.idcatalogo

where d.idpartida=$idpartida ORDER by debe DESC";


	$result=$conexion->query($consulta);
	if($result){
		while ($fila=$result->fetch_object()) {?>
			
		<tr>
				<td><?php echo $fila->cuenta; ?></td>
				<td><?php echo  number_format($fila->debe,2,".",","); ?></td>
				<td><?php echo  number_format($fila->haber,2,".",","); ?></td>
			</tr>
	<?php 
		$debe+=$fila->debe;
		$haber+=$fila->haber;
		}
	} ?>
	<tr>
		<td>Total</td>
		<td><?php echo  number_format($debe,2,".",","); ?></td>
		<td><?php echo number_format($haber,2,".",","); ?></td>
	</tr>
	</table>
	<br><br>
	<label  class="form__label1">Detalle</label>
	<br>
	<input type="text" id="det" readonly="true" class="form__field1" value="<?php echo $detalle; ?>">
	<br><br>
	<div class="text-center">
		
		 <input  type="button" value="Eliminar Partida" id="btnEliminar" class="btn ripple-infinite btn-round btn-danger"  data-toggle="modal" data-target="#miModalDetalles" <?php if($estado==0){echo "disabled='true'";} ?> <?php if($_SESSION["onModificar"]=="consultar"){ ?>  disabled="true" <?php  } ?> onclick="deletePartida(<?php echo($idpartida); ?>,<?php echo $tipo ?>,<?php echo($numpartida); ?>);">

		 
		 


		
	</div>
	

<?php }if($opcion=="eliminar"){

	
	$idpartida="";
	if(isset($_REQUEST["idpartida"])){
		$idpartida=$_REQUEST["idpartida"];
	}

	
	if($idpartida!=""){
		$consulta="UPDATE `partida` SET `estado`=false WHERE idpartida=".$idpartida;
		if($conexion->query($consulta)==1){
			 $conexion->query("UPDATE `periodo` SET `subestado`=true WHERE idperiodo='".$idperiodo."'");
			  if($_SESSION["onModificar"]=="modificar"){
    
          $consulta="UPDATE `periodo` SET `subestado`=true where idperiodo='".$idperiodo."'";
          $conexion->query($consulta);
         
    
  }
			 echo 1;
    
		}



	}else{
		echo 3;
	}

} ?>









