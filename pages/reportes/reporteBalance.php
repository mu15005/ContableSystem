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
	    <thd align="center" class="titulotabla">REPORTE DE BALANZA GENERAL PARA EL PERIODO <?php echo $anio; ?> </th>
      
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
      ?>
 <form id="formulario" name="formulario" method="post" action="">
  <div align="left">
    <input type="button" name="boton" id="boton" style="top: -10px" class="btn ripple-infinite btn-round btn-info" value="Imprimir" onclick="ocultar()" />
  </div>
</form>


<?php
encabezado("",$anio);
      
      //variables acumuladoras que sumaran los valosres de sus respectivos grupos
       $acumuladorAC=0.0; //activo corrient
       $acumuladorANC=0.0;//activo no corriente
       $acumuladorPC=0.0;//pasivo corriente
       $acumuladorPNC=0.0;//pasivo no corriente
       $acumuladorP=0.0;//patrimonio

       //este for sirve para reutilizar el codigo de impresion se repite 4 veces el mismo valor de grupos del balance general
      for ($i=0; $i < 6; $i++) { 
        //se le asigna el valor de un indice a cada uno de los grupos para poder saber el momento de acceder a cada grupo
       if($i==0){
        $grupo="Activo Corriente";
        $codigocuenta='11';
       }
       if($i==1){
        $grupo="Activo No Corriente";
        $codigocuenta='12';
       }
       if($i==2){
        $grupo="Pasivo Corriente";
        $codigocuenta='21';
       }
       if($i==3){
        $grupo="Pasivo No Corriente";
        $codigocuenta='22';
       }
        if($i==4){
        $grupo="Patrimonio";
        $codigocuenta='31';
       }
        if($i==5){
        $grupo="Patrimonio";
        $codigocuenta='32';
       }
      
     if($i!=5){
      
    

    
    echo ' <table border="1" class="formatocontenidotabla" cellspacing=0 cellpadding=0 rules="all">';
    echo "<tr>";
     echo "<td style='background:#C8E6C9;color:green' align='left' width='518'>$grupo</td>";
      echo "<td style='background:#C8E6C9;color:green'   align='left' width='150'>Saldo</td>";
      echo "</tr>";
      echo '</table>';
    }

       include "../config/conexion.php";


      $acumuladorAux=0.0;
                      //codigo para obtener todas las cuentas de mayor
                    $result = $conexion->query("select idcatalogo as id,saldo, nombrecuenta as nombre, codigocuenta as codigo from catalogo  where nivel='3' and SUBSTRING(codigocuenta,1,'2')='".$codigocuenta."' and idperiodo=$anioActivo order by codigocuenta");
                    if ($result) {


                        while ($fila = $result->fetch_object()) {

                          $nombre=$fila->nombre;

                          
                          $codigo=$fila->codigo;
                          //obtener total de caracteres del codigo segun el de la cuenta de seleccionada
                          $loncadena=strlen($codigo);
                          
                          //inicio de la consulta para encontrar las  subcuentas de la cuenta de mayor
                          
                          $resultSubcuenta= $conexion->query("select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1','".$loncadena."') as codigocorto, p.idpartida as npartida, p.detalle as concepto, p.fecha as fecha, l.debe as debe, l.haber as haber FROM catalogo as c,partida as p, detallepartida as l where SUBSTRING(c.codigocuenta,1,'".$loncadena."')='".$codigo."' and p.idpartida=l.idpartida and l.idcatalogo=c.idcatalogo and p.idperiodo='".$anioActivo."'  and p.tipo!=2 ORDER BY p.idpartida ASC");
                         


                         


                          if ($resultSubcuenta) {
                            $codigoSC=$fila->codigo;
                            $saldo=0.0;
                              if($resultSubcuenta->num_rows>0){

                              
                              while ($fila2 = $resultSubcuenta->fetch_object()) {
                                
                                $nombrecuenta=$fila2->nombre;

                                $codigoSC=$fila2->codigo;

                                if ($fila->saldo=="Deudor") {
                                  $saldo=$saldo+($fila2->debe)-($fila2->haber);
                                }else {
                                  $saldo=$saldo-($fila2->debe)+($fila2->haber);
                                }

                              }//fin del while resulSubcuenta
                          }//fin del if num_rows

                        switch($i){//switch para acumular los valores de cada grupo
                           case 0:
                           
                                    if($codigoSC=="1106"){// mostrar el valor de nventario final en lugar del inicial
                                    $saldo=$inventariofinal;
                                    }
                                  
                                    $acumuladorAC=$acumuladorAC+$saldo;
                                break;
                            case 1: $acumuladorANC=$acumuladorANC+$saldo;
                                break;
                             case 2: 
                                 $resultA=$conexion->query("SELECT * FROM partida where tipo=2 and idperiodo=$anioActivo");
                                  $numAux=$resultA->num_rows;
                                if($codigoSC=="2107" and $numAux==0){
                                 $saldo+=$imp;
                                  }
                             $acumuladorPC=$acumuladorPC+$saldo; 
                                 break;
                            case 3: $acumuladorPNC=$acumuladorPNC+$saldo; 
                                break;
                              
                             
                             case 4 or 5 : $acumuladorP=$acumuladorP+$saldo;
                               $resultA=$conexion->query("SELECT * FROM partida where tipo=2 and idperiodo=$anioActivo");
                                  $numAux=$resultA->num_rows;
                             if($codigoSC=="3201" and $numAux==0){
                                    $saldo+=$reservaL;
                                    }
                                     if($codigoSC=="3202" and $numAux==0){
                                    $saldo+=$Utilidad;
                                    }
                             break;
                              }//fin de switch

                              
                             echo "<table border='1' class='formatocontenidotabla' cellspacing='5' cellpadding='0' rules='all'>";
                              echo "<tr>";
                                    echo "<td  width='518'>$nombre</td>";
                              echo "<td  width='150'>$moneda".number_format($saldo,2,'.',',')."</td>";
                                echo "</tr>";
                              
                              $saldo=0.0;
                              
                            
                          }//fin del resultado subCuenta

                        }//fin del while de la primer consulta
                        }//fin del if del result
                       
                      
                     


                       switch($i){//switch para mostrar los totales de cada grupo
                           case 0:
                                   
                                echo "<tr>
                                <td width='518' class='text-black'>Total Activo Corriente</td>
                                <td width='150' class='text-black'>$moneda".number_format($acumuladorAC,2,'.',',')."</td>

                                </tr>";
                               
                                break;
                            case 1:  echo "<tr>
                                <td width='518' class='text-black'>Total Activo No Corriente</td>
                                <td width='150' class='text-black'>$moneda".number_format($acumuladorANC,2,'.',',')."</td>

                                </tr>";
                               echo "<tr>
                                      <td width='518' class='text-black'>Total Activo</td>
                                      <td width='150' class='text-black'>$moneda".number_format(($acumuladorAC+$acumuladorANC),2,".",",")."</td>

                                      </tr>";


                                break;
                             case 2: $numAux=0;
                                 /* $resultA=$conexion->query("SELECT * FROM partida where tipo=2");
                                  $numAux=$resultA->num_rows;
                                   if($numAux==0){
                                     echo "<tr>";
                              echo "<tdwidth='518' >Impuesto sobre la Renta </td>";
                              
                              echo "<td width='150' >$moneda".number_format($imp,2,'.',',')."</td>";
                              $acumuladorPC+=$imp;
                              echo "</tr>";
                            }*/
                                     echo "<tr>
                                <td width='518' class='text-black'>Total Pasivo Corriente</td>
                                <td width='150' class='text-black'>$moneda".number_format($acumuladorPC,2,'.',',')."</td>

                                </tr>";


                                   
                                 break;
                            case 3: 
                            echo "<table border='1' class='formatocontenidotabla' cellspacing='5' cellpadding='0' rules='all'>";
                                    echo "<tr>
                                <td width='518' class='text-black'>Total Pasivo No Corriente</td>
                                <td width='150' class='text-black'>$moneda".number_format($acumuladorPNC,2,'.',',')."</td>

                                </tr>";
                                $total=$acumuladorPC+$acumuladorPNC;
                                echo "<tr>
                                      <td width='518' class='text-black'>Total Pasivo</td>
                                      <td width='150' class='text-black'>$moneda".number_format(($total),2,".",",")."</td>

                                      </tr>";

    echo "</table>";
                                break;
                             case  5:
                             $numAux=0;
                                  $resultA=$conexion->query("SELECT * FROM partida where tipo=2");
                                  $numAux=$resultA->num_rows;
                                   if($numAux==0){
                              echo "<tr>";
                              echo "<td width='518' >Reserva Legal </td>";
                              
                              echo "<td width='150'>$moneda".number_format($reservaL,2,".",",")."</td>";
                              echo "</tr>";
                                          
                             $acumuladorP=$acumuladorP+$reservaL;
                             echo "<tr>";
                             echo "<td width='518'>Utilidad Del Ejercicio </td>";
                              
                             echo "<td width='150'>$moneda".number_format($Utilidad,2,".",",")."</td>";
                             echo "</tr>";
                              $acumuladorP=$acumuladorP+$Utilidad;
                           }
                                          
                                          
                              echo "<tr>
                                <td width='518' class='text-black'>Total Patrimonio</td>
                                <td width='150' class='text-black'>$moneda".number_format($acumuladorP,2,'.',',')."</td>

                                </tr>"; 

                                echo "<tr>
                                      <td width='518' class='text-black'>Patrimonio + Pasivo</td>
                                      <td width='150' class='text-black'>$moneda".number_format(($acumuladorP+$acumuladorPC+$acumuladorPNC),2,".",",")."</td>

                                      </tr>";
                             break;

                              }//fin de switch
                       

              
            }//fin del for



    echo "</table>";
?>

</body>

</html>
