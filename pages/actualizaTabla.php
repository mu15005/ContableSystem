
<?php
//este documento php obtiene los registros del catalogo existente
//para ser mostrados mediante una peticion jquery en el documento catalogo.php
$opcion="";
if(isset($_REQUEST["opcion"])){
$opcion=$_REQUEST["opcion"];
}

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



//esta funcion sirve tanto para mostrar las cuentas en la tabla principal
//como para mostrarlas en la tabla de seleccion para un reemplazo
if($opcion=="mostrar"){
  mostrar($idperiodo,$pagina,$opcion);
}else if($opcion=="mostrarOnDelete"){
  mostrarCuentaSeleccionada($idperiodo,$pagina,$opcion);
}
function mostrar($idperiodo,$pagina,$opcion){
  include "config/conexion.php";

 $busqueda="";
    if(isset($_POST["busqueda"])){

  $busqueda=$_POST["busqueda"];
}

    $result=$conexion->query("SELECT * FROM catalogo where idperiodo=$idperiodo  and (nombrecuenta LIKE '%".$busqueda."%' OR codigocuenta LIKE '%".$busqueda."%')  order by codigocuenta");
    $totalCuentas=($result->num_rows);


    $elementoPP=6;
       $totalPaginas=($totalCuentas/$elementoPP);
    $totalPaginas=ceil($totalPaginas);
    $inicio=($pagina-1)*$elementoPP;


     $consulta="SELECT * FROM `catalogo` WHERE idperiodo=$idperiodo  and (nombrecuenta LIKE '%".$busqueda."%' OR codigocuenta LIKE '%".$busqueda."%') order by codigocuenta LIMIT ".$inicio.",".$elementoPP;




?>
	<div class="responsive-table">

            <table class="table"  id="tablaDatos">
                <thead>
                    <tr >

                        <th>codigo</th>
                        <th>codigo</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Saldo</th>

                    </tr>
                </thead>
                <tbody id="tbodys">

                     <?php



                        $result = $conexion->query($consulta);



                if ($result) {

                while ($fila = $result->fetch_object()) { ?>


                                <tr>
                                   <td><?php echo $fila->idcatalogo; ?></td>
                                    <td class="text-center"><?php echo $fila->codigocuenta; ?></td>
                                    <td><?php echo $fila->nombrecuenta; ?></td>
                                    <td><?php echo $fila->tipo; ?></td>
                                    <td><?php echo $fila->saldo; ?></td>


                                    <td class="text-center">




                                            <button type="button" class="btn ripple-infinite btn-round btn-info"  data-toggle="modal" data-target="#miModalDetalles" onclick="cargaDato('mostrar',<?php echo($fila->codigocuenta) ?>,'formD');">Ver Detalles</button>

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

            <?php
            }//fin de funcion


function mostrarCuentaSeleccionada($idperiodo,$pagina,$opcion){
  include "config/conexion.php";



    $codigo="";
                    if(isset($_REQUEST["codigo"])){
                      $codigo=$_REQUEST["codigo"];
                    }






     $result = $conexion->query("SELECT * from catalogo WHERE codigocuenta='".$codigo."' and idperiodo=$idperiodo");
                        $saldo="";
                        $id="";
                        if($result){
                            while ($fila=$result->fetch_object()) {
                                $id=$fila->idcatalogo;
                                $saldo=$fila->saldo;
                                $tipo=$fila->tipo;
                            }
                          }
$busqueda="";
    if(isset($_POST["busqueda"])){
      $busqueda=$_POST["busqueda"];
    }


 $result=$conexion->query("SELECT * FROM `catalogo` WHERE saldo='".$saldo."' and tipo='".$tipo."' and codigocuenta!='".$codigo."' and idperiodo=$idperiodo and nombrecuenta LIKE '%".$busqueda."%'  order by codigocuenta");
    $totalCuentas=($result->num_rows);

    $elementoPP=6;
       $totalPaginas=($totalCuentas/$elementoPP);
    $totalPaginas=ceil($totalPaginas);
    $inicio=($pagina-1)*$elementoPP;




?>
  <div class="responsive-table">

            <table class="table"  id="tablaDatos">
                <thead>
                    <tr >

                        <th>codigo</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Saldo</th>

                    </tr>
                </thead>
                <tbody id="tbodys">

                     <?php


                     $result=$conexion->query("SELECT * FROM `catalogo` WHERE saldo='".$saldo."' and tipo='".$tipo."' and codigocuenta!='".$codigo."' and idperiodo=$idperiodo and nombrecuenta LIKE '%".$busqueda."%'  order by codigocuenta LIMIT ".$inicio.",".$elementoPP);

                if ($result) {

                while ($fila = $result->fetch_object()) { ?>


                                <tr>
                                    <td class="text-center"><?php echo $fila->codigocuenta; ?></td>
                                    <td><?php echo $fila->nombrecuenta; ?></td>
                                    <td><?php echo $fila->tipo; ?></td>
                                    <td><?php echo $fila->saldo; ?></td>


                                    <td class="text-center">



                                        <button type="button" class="btn ripple-infinite btn-round btn-info"  data-toggle="modal" data-target="#miModalCargar" onclick="onReemplazar(<?php echo ($id); ?>,<?php echo($fila->idcatalogo); ?>);">Seleccionar</button>

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
                    <a href="#" onclick='cargaCuentaSelect("<?php echo ($pagina-1); ?>","<?php echo $codigo; ?>");' class="page-link" aria-label="Ant">
                      <span aria-hidden="true">&laquo;</span>
                    </a>

                  </li>

                   <li class="page-item  <?php echo $pagina==1 ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='cargaCuentaSelect("<?php echo 1; ?>","<?php echo $codigo; ?>");'><?php echo 1; ?></a></li>
                   <?php if($pagina>4){ ?>
                    <li class="page-item"><a href="#" class="page-link">...</a></li>

                  <?php } ?>

            <?php

            $ultima=$ultima-1;
            for ($i=$primera; $i < $ultima; $i++) {?>

                  <li class="page-item  <?php echo $pagina==($i+1) ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='cargaCuentaSelect("<?php echo ($i+1); ?>","<?php echo $codigo; ?>");'><?php echo ($i+1); ?></a></li>


             <?php
                }?>

                <?php if($pagina<($totalPaginas-3)){ ?>
                    <li class="page-item"><a href="#" class="page-link">...</a></li>

                  <?php }
                   if($totalPaginas>1){ ?>
                  <li class="page-item  <?php echo $pagina==$totalPaginas ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='cargaCuentaSelect("<?php echo $totalPaginas; ?>","<?php echo $codigo; ?>");'><?php echo $totalPaginas; ?></a></li>
                <?php } ?>
                 <li class="page-item <?php echo $pagina>=$totalPaginas ? 'disabled' : ''; ?>">
                    <a href="#" onclick='cargaCuentaSelect("<?php echo ($pagina+1); ?>","<?php echo $codigo; ?>");' class="page-link" aria-label="Sig">
                      <span aria-hidden="true">&raquo;</span>
                    </a>

                  </li>
                 </ul>
               </nav>
                    </div>
                    </div>







<?php }?>
