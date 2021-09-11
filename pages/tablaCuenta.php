<?php
//Codigo que muestra solo los errores exceptuando los notice.
error_reporting(E_ALL & ~E_NOTICE);
?>
<?php
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

 

mostrar($idperiodo,$pagina);
function mostrar($idperiodo,$pagina){
  include "config/conexion.php";
	



$busqueda="";
    if(isset($_POST["busqueda"])){

  $busqueda=$_POST["busqueda"];
}

    $result=$conexion->query("SELECT * FROM `catalogo` WHERE idperiodo=$idperiodo and nivel>2 and nombrecuenta LIKE '%".$_POST["busqueda"]."%' order by codigocuenta");
    $totalCuentas=($result->num_rows);


    $elementoPP=6;
       $totalPaginas=($totalCuentas/$elementoPP);
    $totalPaginas=ceil($totalPaginas);
    $inicio=($pagina-1)*$elementoPP;
   

     $consulta="SELECT * FROM `catalogo` WHERE idperiodo=$idperiodo and nivel>2 and nombrecuenta LIKE '%".$_POST["busqueda"]."%' order by codigocuenta LIMIT ".$inicio.",".$elementoPP;




	?>
	 <table id="datatables-example" class="table" >
                  <thead>
                    <tr>
                      <th></th>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Saldo</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php 

                   
                    
           
                     $result = $conexion->query($consulta);
                  
					if ($result) {
					while ($fila = $result->fetch_object()) { ?>
						<tr>
							<td>
								<div class='col-md-2' style='margin-top:1px'>
								<button type='button' class='btn btn-info btn-md' data-dismiss='modal' data-toggle='tooltip' data-placement='left' title='Envio de datos al formulario.' onclick='llenarDatos("<?php echo $fila->codigocuenta ; ?>","<?php echo $fila->idcatalogo; ?>")'>
								<div>
									<span>Enviar</span>
									</div>
									</button>
									</div>
									</td>

									<td><?php echo  $fila->codigocuenta; ?></td>
									<td><?php echo $fila->nombrecuenta; ?> </td>
									<td><?php echo $fila->saldo;?></td>

									</tr>

				<?php } 
      }?>

                 </tbody>
          
            
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

                  <li class="page-item  <?php echo $pagina==($i+1) ? 'active' : ''; ?>"><a href="#" class="page-link"onclick='cargaCuentas("<?php echo ($i+1); ?>");'><?php echo ($i+1); ?></a></li>


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
         
<?php
}?>
     
