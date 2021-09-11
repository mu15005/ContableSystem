<?php session_start();

include "../operacionesEF.php";


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
	    <th align="center" class="titulotabla">REPORTE DE ESTADO RESULTADO PARA EL PERIODO <?php echo $anio; ?> </th>
      
	   
	    </tr>
      <tr>
         <th align="center" class="titulotabla">Fecha generaci&oacute;n: <?php echo date("d-m-Y"); ?></th>
      </tr>
	  <tr>
	    <th align="center" class="titulotabla">Nombre del Establecimiento: <?php echo $nombreEmpresa ?></th>
      <th align="center" class="titulotabla"><img height="60px" src="data:image/jpg;base64,<?php echo base64_encode($logo); ?>"></th>
	   
	   </tr>
     <tr>
        <th align="center" class="titulotabla">Hora generado: <?php echo date("H:i:s "); ?></th>
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

$UAIR=(((($resultventa-$resultRebAndDevVenta)-(((($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra)+$resultInvetIni)-$inventariofinal))-($resultGastoAdministracion+$resultGastoVenta+$resultGastoFinanciero))-$resultOtrosGast)+$resultOtrosIngresos;
     
     $reservaL=$UAIR*0.07;

     $UAIR=$UAIR-$reservaL;

     if ($resultventa>150000) {
      $imp=$UAIR*0.30;
     }else{
      $imp=$UAIR*0.25;
     }
     $Utilidad=$UAIR-$imp;
encabezado("",$anio);
      
     ?>
      <table border='1' class='formatocontenidotabla' cellspacing='5' cellpadding='0' rules='all'>
      <thead>
                      <tr>
                        <th  style="width:518px;color: #9575CD;font-size: 24px">Estado Resultado</th>
                      
                        <th style="width:150px;">.</th>
                        <th style="width:150px;">.</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>Ventas</td>
                        <td></td>
                        <td><?php echo $moneda."". number_format($resultventa,2,".",",");?></td>
                      </tr>
                      </tbody>
                        <tbody>
                      <tr>
                        <td>(-) Rebajas y devoluciones sobre ventas</td>
                        <td></td>
                        <td><?php echo $moneda."". number_format($resultRebAndDevVenta,2,".",",");?></td>
                      </tr>
                        </tbody>
                        <tbody>
                      <tr>
                        <td>(=) Ventas netas</td>
                        <td></td>
                        <td><?php echo $moneda."". number_format($resultventa-$resultRebAndDevVenta,2,".",",");?></td>
                      </tr>
                        </tbody>
                      <tbody>
                      <tr>
                        <td>(-) Costo de ventas</td>
                        <td></td>
                        <td><?php echo $moneda."". number_format(((($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra)+$resultInvetIni)-$inventariofinal,2,".",",");?></td>
                      </tr>
                        </tbody>
                        <tbody>
                        <tr>
                          <td>     Compras</td>
                          <td><?php echo $moneda."". number_format($saldoComp,2,".",",");?></td>
                          <td></td>
                        </tr>
                          </tbody>
                          <tbody>
                          <tr>
                            <td>(+)   Gastos Sobre Compras</td>
                            <td><?php echo $moneda."". number_format($resultGastoCompra,2,".",",");?></td>
                            <td></td>
                          </tr>
                            </tbody>
                            <tbody>
                            <tr>
                              <td>(=)  Compras Totaes</td>
                              <td><?php echo $moneda."". number_format($saldoComp+$resultGastoCompra,2,".",",");?></td>
                              <td></td>
                            </tr>
                              </tbody>
                              <tbody>
                              <tr>
                                <td>(-) Rebajas y devoluciones Sobre Compras</td>
                                <td><?php echo $moneda."". number_format($resultRebAndDevCompra,2,".",",");?></td>
                                <td></td>
                              </tr>
                                </tbody>
                                <tbody>
                                <tr>
                                  <td>(=) Compras Netas</td>
                                  <td><?php echo $moneda."". number_format(($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra,2,".",",");?></td>
                                  <td></td>
                                </tr>
                                  </tbody>
                                <tbody>
                                <tr>
                                  <td>(+) Inventario Inicial</td>
                                  <td><?php echo $moneda."". number_format($resultInvetIni,2,".",",");?></td>
                                  <td></td>
                                </tr>
                                  </tbody>
                                  <tbody>
                                  <tr>
                                    <td>(=) Mercaderia Disponible</td>
                                    <td><?php echo $moneda."". number_format((($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra)+$resultInvetIni,2,".",",");?></td>

                                    <td></td>
                                  </tr>
                                    </tbody>
                                    <tbody>
                                    <tr>
                                      <td>(-)   Inventario Final</td>
                                      <td><?php echo $moneda."". number_format($inventariofinal,2,".",",");?></td>

                                      <td></td>
                                    </tr>
                                      </tbody>
                                      <tbody>
                                      <tr>
                                        <td>(=)   Utilidad Bruta</td>
                                        <td></td>
                                        <td><?php echo $moneda."". number_format(($resultventa-$resultRebAndDevVenta)-(((($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra)+$resultInvetIni)-$inventariofinal),2,".",",");?></td>
                                      </tr>
                                        </tbody>
                                      </tbody>
                                      <tbody>
                                      <tr>
                                        <td>(-)   Gastos de Operacion</td>
                                        <td></td>
                                        <td><?php echo $moneda."". number_format($resultGastoAdministracion+$resultGastoVenta+$resultGastoFinanciero,2,".",",");?></td>
                                      </tr>
                                        </tbody>
                                        <tbody>
                                        <tr>
                                          <td> Gastos de Administracion</td>
                                          <td><?php echo $moneda."". number_format($resultGastoAdministracion,2,".",",");?></td>
                                          <td></td>
                                        </tr>
                                          </tbody>
                                          <tbody>
                                          <tr>
                                            <td> (+) Gastos de Venta</td>
                                            <td><?php echo $moneda."". number_format($resultGastoVenta,2,".",",");?></td>
                                            <td></td>
                                          </tr>
                                            </tbody>
                                          </tbody>
                                          <tbody>
                                          <tr>
                                            <td> (+) Gastos de Financieros</td>
                                            <td><?php echo $moneda."". number_format($resultGastoFinanciero,2,".",",");?></td>
                                            <td></td>

                                          </tr>
                                            </tbody>
                                          <tbody>
                                            <tr>
                                              <td> (=)   Utilidad de Operacion</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($UB,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                          <tbody>
                                            <tr>
                                              <td> (-)   Otros gastos</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($resultOtrosGast,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                          <tbody>
                                            <tr>
                                              <td> (+)   Otros Ingresos</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($resultOtrosIngresos,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                          <tbody>
                                            <tr>
                                              <td> (=)   Utilidad Antes de Impuesto Y Reserva</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($UAIR,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                         
                                          <tbody>
                                            <tr>
                                              <td> (-)   Reserva Legal (7%)</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($reservaL,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                         
                                           <tbody>
                                            <tr>
                                              <td> (=)   Utilidad antes de Impuesto sobre la Renta</td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($UAI,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                         
                                          <tbody>
                                            <tr>
                                              <td> (-)   Impuesto sobre la renta <?php if($resultventa>150000){echo "(30%)";}else{echo "(25%)";} ?></td>
                                              <td></td>
                                              <td><?php echo $moneda."". number_format($imp,2,".",",");?></td>
                                            </tr>
                                          </tbody>
                                        
                                          <tbody>
                                            <tr>
                                              <td style="background:#C8E6C9;color:green;" > (=)   Utilidad del Ejercicio</td>
                                              <td style="background:#C8E6C9;color:green;"></td>
                                              <?php if($Utilidad>=0){ ?>
                                              <td style="background:#C8E6C9;color:green;"><?php echo $moneda."". number_format($Utilidad,2,".",",")?></td>
                                            <?php }else{ ?>
                                              <td style="background:#C8E6C9;color:red;"><?php echo $moneda."". number_format($Utilidad,2,".",",")?></td>
                                            <?php } ?>
                                            </tr>
                                          </tbody>

<form id="formulario" name="formulario" method="post" action="">
  <div align="center">
    <input type="button" name="boton" id="boton" style="top: -10px" class="btn ripple-infinite btn-round btn-info" value="Imprimir" onclick="ocultar()" />
  </div>
</form>
    </table>
</body>

</html>
