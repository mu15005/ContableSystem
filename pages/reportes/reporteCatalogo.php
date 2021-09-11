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
<title>Reporte de Cuentas</title>
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
	    <th align="center" class="titulotabla">REPORTE DE CATALOGO DE CUENTAS PARA EL PERIODO <?php echo $anio; ?> </th><br>
      
	    
	    </tr>
      <tr><th align="center" class="titulotabla">Fecha generaci&oacute;n: <?php echo date("d-m-Y"); ?></th></tr>
	  <tr>
	    <th align="center" class="titulotabla">Nombre del Establecimiento: <?php echo $nombreEmpresa ?></th>
      <th align="center" class="titulotabla"><img height="60px" src="data:image/jpg;base64,<?php echo base64_encode($logo); ?>"></th>
	   
	   </tr>
     <tr>
        <th align="center" class="titulotabla">Hora generado: <?php echo date("H:i:s "); ?></th>
     </tr>
	</table>
	

  <table border="1" class="formatocontenidotabla" cellspacing=0 cellpadding=0 rules="all">
	  <tr>
	    <td width="40"  align="left"><strong>#</strong></td>
	    <td width="250"  align="left"><strong>CODIGO</strong></td>
	    <td width="250"  align="left"><strong>NOMBRE</strong></td>
	    <td width="100"  align="left"><strong>TIPO</strong></td>
	    <td width="80"  align="left"><strong>SALDO</strong></td>
	  </tr>
  </table>

</div>
<?php }

include "../config/conexion.php";


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

if (true) {
    $sql = "select * from catalogo where idperiodo=$idperiodo order by nombrecuenta ";
} else {
    $sql = "select * from empleado where nivel=$mostrar order by $ordenar";
}

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
        echo "<tr style='height:20px;''>";
        echo "<td width='40'  align='left'>" . $contador . "</td>";
        echo "<td width='250'  align='left'>" . $fila->codigocuenta . "</td>";
        echo "<td width='250'  align='left'>" . $fila->nombrecuenta . "</td>";
        echo "<td width='100'  align='left'>" . $fila->tipo . "</td> ";
        echo "<td width='80'  align='left'>" . $fila->saldo . "</td>";
        echo "</tr>";

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
