<?php 
session_start();
include "../config/conexion.php";
$result = $conexion->query("select * from periodo where estado=1");
if($result)
{
  while ($fila=$result->fetch_object()) {
    $idanio=$fila->idperiodo;
  }
}
$ini="";
$nivelMayorizacion="";
$fin="";
if(isset($_REQUEST["inicio"])){
$nivelMayorizacion=$_REQUEST["nivelMayorizacion"];
$ini=$_REQUEST["inicio"];
$fin=$_REQUEST["fin"];
}
if($ini!="" && $fin!="" && $nivelMayorizacion!=""){
  $_SESSION["nivel"]=$nivelMayorizacion;
   $_SESSION["fn"]=$fin;
    $_SESSION["in"]=$ini;
}




mostrar($nivelMayorizacion,$ini,$fin,$idanio);

function mostrar($nivelMayorizacion,$ini,$fin,$idanio){

include "../config/conexion.php";
$resultadoAjustes=$conexion->query("SELECT * FROM `ajustes`");
$mon="";
if($resultadoAjustes){
  while ($fila=$resultadoAjustes->fetch_object()) {
  $mon=$fila->moneda;
  }
}
switch ($mon) {
  case '1':
    # code...
  $moneda="$ : ";
    break;
     case '2':
    # code...
     $moneda="€ : ";
    break;

}
 $busqueda="";
    if(isset($_POST["busqueda"])){

  $busqueda=$_POST["busqueda"];
}
$pagina=1;
if(isset($_POST["pagina"])){
  $pagina=$_POST["pagina"];
}
$nivelMayorizacion=$_SESSION["nivel"];
$ini=$_SESSION["in"];
$fin=$_SESSION["fn"];

    $consult="select idcatalogo as id,saldo, nombrecuenta as nombre, codigocuenta as codigo from catalogo where SUBSTRING(codigocuenta,1,1)>=$ini and SUBSTRING(codigocuenta,1,1)<=$fin and  nivel=$nivelMayorizacion and idperiodo=$idanio order by codigocuenta";
  
    $result=$conexion->query($consult);
    $totalCuentas=($result->num_rows);


    $elementoPP=1;
       $totalPaginas=($totalCuentas/$elementoPP);
    $totalPaginas=ceil($totalPaginas);
    $inicio=($pagina-1)*$elementoPP;

     $consulta="SELECT idcatalogo as id,saldo, nombrecuenta as nombre, codigocuenta as codigo from catalogo where SUBSTRING(codigocuenta,1,1)>=$ini and SUBSTRING(codigocuenta,1,1)<=$fin and  nivel=$nivelMayorizacion and idperiodo=$idanio order by codigocuenta LIMIT ".$inicio.",".$elementoPP;

     



 ?>

  
	<div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                <div class="panel">
                
                  <div class="panel-body" id="tablaMayor">
                    
                </div>
              </div>
            </div>
            </div>

 <div >

                    <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                      <div>
                      
                      <h4 >Grupo del  <?php echo $ini; ?> Al <?php echo $fin; ?> Nivel <?php echo $nivelMayorizacion; ?></h4>
                      <input type="hidden" name="anioActivo" id="anioActivo" value="<?php echo $anioActivo; ?>">
                      <input type="hidden" name="nivel" id="nivel" value="<?php echo $nivelMayorizacion; ?>">
                          
                        
                      </div>
                        <button type="button" style="width: 200px;" data-toggle="modal" class="btn-flip btn btn-gradient btn-primary" data-target="#modalPersonalizado">Perzonalizadar</button>
                    </div>
                  </div>
              </div>
              <div style="top:5px !important;float:left;padding-left: 1.5%;position: relative;">
             <button  type="button" style="width: 200px;" onclick="abrirVentana();" class="btn btn-success btn-md" >PDF</button>
           </div>
          
                    <nav style="float: right;" aria-label="paginacion">
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

                  <li class="page-item  <?php echo $pagina==($i+1) ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='paginacion("<?php echo ($i+1); ?>");'><?php echo ($i+1); ?></a></li>


             <?php 
                }?>
                
                <?php if($pagina<($totalPaginas-3)){ ?>
                    <li class="page-item"><a href="#" class="page-link">...</a></li>

                  <?php }
                   if($totalPaginas>1){ ?>
                  <li class="page-item  <?php echo $pagina==$totalPaginas ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='paginacion("<?php echo $totalPaginas; ?>");'><?php echo $totalPaginas; ?></a></li>
                <?php } ?>
                 <li class="page-item <?php echo $pagina>=$totalPaginas ? 'disabled' : ''; ?>">
                    <a href="#" onclick='paginacion("<?php echo ($pagina+1); ?>");' class="page-link" aria-label="Sig">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                    
                  </li>
                 </ul>
               </nav>

                    <table  class="table table-bordered">
                    <thead>
                      <tr>
                      <th style="width:73px;" >Fecha</th>
                        <th>Concepto</th>
                        <th style="width:73px;" >N° P</th>
                        <th>Debe</th>
                        <th>Haber</th>
                        <th >Saldo</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                
                  
                  $result=$conexion->query($consulta);
						 if ($result) {
                        while ($fila = $result->fetch_object()) {

                          $nombre=$fila->nombre;

                          $id=$fila->id;
                          $codigo=$fila->codigo;
                          //obtener total de caracteres del codigo segun el nivelcuenta
                          $loncadena=strlen($codigo);
                          
                          //inicio de la consulta para encontrar las cuentas que son subcuentas de la cuenta anterior
                          $consulta="select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1','".$loncadena."') as codigocorto, p.idpartida as npartida, p.detalle as concepto, p.fecha as fecha, l.debe as debe, l.haber as haber FROM catalogo as c,partida as p, detallepartida as l where SUBSTRING(c.codigocuenta,1,'".$loncadena."')='".$codigo."' and p.idpartida=l.idpartida and l.idcatalogo=c.idcatalogo and p.idperiodo='".$idanio."' ORDER BY p.idpartida ASC";
                      
                          
                          $resultSubcuenta= $conexion->query($consulta);
                          if ($resultSubcuenta) {
                              if (($resultSubcuenta->num_rows)<1) {

                            }else {
                              echo "<tr><b><strong><td class='text-info'  colspan='6' align='center'>".$nombre."</td></strong></b></tr>";
                              echo "<tr><b><td class='success  text-primary' colspan='6' align='center'></td></b></tr>";
                              $saldo=0.0;
                              while ($fila2 = $resultSubcuenta->fetch_object()) {
                                echo "<tr>";
                                echo "<td>".$fila2->fecha."</td>";
                                echo "<td>".$fila2->concepto."</td>";
                                echo "<td>".$fila2->npartida."</td>";
                                echo "<td class='info'>".number_format($fila2->debe,2,".",",")."</td>";
                                echo "<td class='danger'>".number_format($fila2->haber,2,".",",")."</td>";

                                if ($fila->saldo=="Deudor") {
                                  $saldo=$saldo+($fila2->debe)-($fila2->haber);
                                }else {
                                  $saldo=$saldo-($fila2->debe)+($fila2->haber);
                                }
                                $saldoAux=$saldo;
                                if($saldoAux<=-1){
                                  $saldoAux*=-1;
                                echo "<td class='warning text-info'>".$moneda." ".number_format($saldoAux,2,".",",")."</td>";
                                echo "</tr>";
                              }else{
                                echo "<td class='warning text-success'>".$moneda." ". number_format($saldoAux,2,".",",")."</td>";
                                echo "</tr>";
                              }
                              }
                              $saldo=0;
                            }
                          }else {
                            //echo "<script type'text/javascript'>mostrarMensaje('Error','error',2000);</script>";
                          }
                        }//cierre while consulta 1
                      }//cierre result consulta 1
                    //fin consulta por nivel
                     ?>
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

                  <li class="page-item  <?php echo $pagina==($i+1) ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='paginacion("<?php echo ($i+1); ?>");'><?php echo ($i+1); ?></a></li>


             <?php 
                }?>
                
                <?php if($pagina<($totalPaginas-3)){ ?>
                    <li class="page-item"><a href="#" class="page-link">...</a></li>

                  <?php }
                   if($totalPaginas>1){ ?>
                  <li class="page-item  <?php echo $pagina==$totalPaginas ? 'active' : ''; ?>"><a href="#" class="page-link" onclick='paginacion("<?php echo $totalPaginas; ?>");'><?php echo $totalPaginas; ?></a></li>
                <?php } ?>
                 <li class="page-item <?php echo $pagina>=$totalPaginas ? 'disabled' : ''; ?>">
                    <a href="#" onclick='paginacion("<?php echo ($pagina+1); ?>");' class="page-link" aria-label="Sig">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                    
                  </li>
                 </ul>
               </nav>
                    </div>

 <?php } ?>
