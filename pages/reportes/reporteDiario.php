<?php session_start();



function dameFecha($fecha, $xdias = 0)
{
    list($year, $mon, $day) = explode('-', $fecha);
    return date('d-m-Y', mktime(0, 0, 0, $mon, $day + $xdias, $year));
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reporte de Libro Mayor</title>
<style type="text/css">
.formatocontenidotabla {
	font-family: Courier, Courier, monospace;
	font-size: 13px;
}
</style>
        <style type="text/css">
        .titulotabla {
	font-family: Helvetica, Arial, sans-serif;
	font-size: 15px;
}
        </style>
<style type="text/css">
    @media all {
   div.saltopagina{
      display: none;
   }
}

@media print{
   div.saltopagina{
      display:block;
      page-break-before:always;
   }
}
</style>
<script type="text/javascript">
function ocultar(){
	document.formulario.boton.style.visibility="hidden";
	print();
	document.formulario.boton.style.visibility="visible";
}
 </script>
  <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php function encabezado($ordenar,$anio)
{
  include "../config/conexion.php";

$resultadoAjustes=$conexion->query("SELECT * FROM `ajustes`");
$mon="";
$result=$conexion->query("SELECT * FROM ajustes");
  if($result){
    while ($fil=$result->fetch_object()) {
      $nombreEmpresa=$fil->nombreempresa;
      $logo=$fil->logo;
    }
  }
  
    ?>
<div id="reporte">
  <table  border="0">
	  <tr>
	    <thd align="center" class="titulotabla">REPORTE DE CUENTAS T PARA EL PERIODO <?php echo $anio; ?> </th>
      
	    <th align="center" class="titulotabla">Fecha generaci&oacute;n: <?php echo date("d-m-Y"); ?></th>
	    </tr>
	  <tr>
	    <th align="center" class="titulotabla">Nombre del Establecimiento: <?php echo $nombreEmpresa ?></th><br>
      <th align="center" class="titulotabla"><img height="60px" src="data:image/jpg;base64,<?php echo base64_encode($logo); ?>"></th><br>
	   
	   </tr>
     <tr>
        <th align="center" class="titulotabla">Hora generado: <?php echo date("H:i:s "); ?></th>
     </tr>
	</table>
	<br>

  <table border="1" class="formatocontenidotabla" cellspacing=0 cellpadding=0 rules="all">
	  <tr>
	    
	    <td width="418"  align="left"><strong>CUENTA</strong></td>
	    <td width="94"  align="left"><strong>DEBE</strong></td>
      <td width="97"  align="left"><strong>HABER</strong></td>
	    
	    
	  </tr>
  </table>

</div>
<?php }

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

  $resultado=$conexion->query("SELECT * FROM periodo where estado=1");
  if($resultado){
    while ($fil=$resultado->fetch_object()) {
      $anio=$fil->anio;
      $idperiodo=$fil->idperiodo;
    }
  }
$contador    = 0;
$numPagina   = 0;
$numeroFilas = 40; //Cuantas filas por pagina
$bandera     = false;
 $ini="";
$nivelMayorizacion="";
$fin="";

  $sql="SELECT * FROM partida where idperiodo=$idperiodo";


$result = $conexion->query($sql);
if ($result) {

    //obtener el numero de filas retornadas por la consulta
    $cuantasPaginas = mysqli_num_rows($result);

    //$flor           = explode(".", $cuantasPaginas);
    //$cuantasPaginas = $flor[0];
    //echo "aaaaaaaaaaaaa" . $cuantasPaginas;
 ?>
 <form id="formulario" name="formulario" method="post" action="">
  <div align="left">
    <input type="button" name="boton" id="boton" style="top: -10px" class="btn ripple-infinite btn-round btn-info" value="Imprimir" onclick="ocultar()" />
  </div>
</form>


<?php
    while ($fila = $result->fetch_object()) {
        if ($contador % $numeroFilas == 0) {
            encabezado("",$anio);
            echo "<table border='1' class='formatocontenidotabla' cellspacing='5' cellpadding='0' rules='all'>";
        }
        $contador++;
      

                         
                          //obtener total de caracteres del codigo segun el nivelcuenta
                         
                          
                          //inicio de la consulta para encontrar las cuentas que son subcuentas de la cuenta anterior
                        
    
                          $consulta="SELECT d.debe as debe,d.haber as haber,c.nombrecuenta as cuenta,c.saldo as saldo from detallepartida as d
                              INNER JOIN catalogo as c on d.idcatalogo=c.idcatalogo

                          where d.idpartida=$fila->idpartida ORDER by debe DESC";
                      
                          
                          $resultSubcuenta= $conexion->query($consulta);
                          if ($resultSubcuenta) {
                              if (($resultSubcuenta->num_rows)<1) {

                            }else {
                              echo "<tr><b><strong><td class='text-info'  colspan='6' align='left'>N° ".$fila->numpartida." -Fecha- ".$fila->fecha." -Detalle- ".$fila->detalle."</td></strong></b></tr>";
                              echo "<tr><b><td class='success  text-primary' colspan='6' align='center'></td></b></tr>";
                             
                              $saldo=0.0;
                                $debe=0;
                          $haber=0;
                              while ($fila2 = $resultSubcuenta->fetch_object()) {
                           echo "<tr>";
                          echo "<td>".$fila2->cuenta."</td>";
                                
                           echo "<td class='info'>".number_format($fila2->debe,2,".",",")."</td>";
                          echo "<td class='info'>".number_format($fila2->haber,2,".",",")."</td>";
                            echo "</tr>";
                                $debe+=$fila2->debe;
                                 $haber+=$fila2->haber;
                                
                              }
                              echo "<tr>";
                              echo "<td></td>";
                              echo "<td class='info'>".number_format($debe,2,".",",")."</td>";
                                echo "<td class='info'>".number_format($haber,2,".",",")."</td>";
                                echo "</tr>";
                            }
                          }

        $bandera = false;
        if ($contador % $numeroFilas == 0) {
            $numPagina++;
            echo "</table>";
            echo "<br>";
            echo "<div  align='right' class='formatocontenidotabla'>" . $numPagina . " de " . ceil($cuantasPaginas / $numeroFilas) . "</div>";
            if ($numPagina != ceil($cuantasPaginas / $numeroFilas)) {
                echo "<div class='saltopagina'></div>";
            }

            $bandera = true;
        }
    }
}

if (!$bandera) {

    echo "</table>";
    echo "<br>";
    echo "<div  align='right' class='formatocontenidotabla'>" . ($numPagina + 1) . " de " . ceil($cuantasPaginas / $numeroFilas) . "</div>";
}
?>

</body>

</html>
