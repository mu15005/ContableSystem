<?php 

/** esto se pone al principio de los archivos*/
$pagina=1;
if(isset($_POST["pagina"])){
	$pagina=$_POST["pagina"];
}

/** este otro codigo es en caso de que tu tabla tenga un campo de busqueda
 * si no lo tiene simplemente omitelo del query*/
$busqueda="";
    if(isset($_POST["busqueda"])){

  $busqueda=$_POST["busqueda"];
}
/**fin de lo del principio*/


/**esta parte deberas colocarlo en lugar  de la parte donde tu has puesto el query para cargar los datos de la tabla obviamente tendras que cambiar los querys por los tuyos*/

$result=$conexion->query("SELECT * FROM `catalogo` WHERE idperiodo=$idperiodo and nivel>2 and nombrecuenta LIKE '%".$_POST["busqueda"]."%' order by codigocuenta");
    $totalCuentas=($result->num_rows);


    /** aqui coloca el valor de las filas que quieras que se muestren en la tabla*/
    $elementoPP=6;
       $totalPaginas=($totalCuentas/$elementoPP);
    $totalPaginas=ceil($totalPaginas);
    $inicio=($pagina-1)*$elementoPP;
   


     $consulta="SELECT * FROM `catalogo` WHERE idperiodo=$idperiodo and nivel>2 and nombrecuenta LIKE '%".$_POST["busqueda"]."%' order by codigocuenta LIMIT ".$inicio.",".$elementoPP;




 ?>


<html>
	
	<!--toda esta parte reemplazala por los tu nav de paginacion-->

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



</html>
