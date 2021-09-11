<?php 

include "../config/conexion.php";

$inventariofinal=$_SESSION["inventario"];

$result = $conexion->query("select * from periodo where estado=1");




if($result)
{
  while ($fila=$result->fetch_object()) {
    $anioActivo=$fila->idperiodo;
  }
}


  
  //caso especial 
  $resultCompra= $conexion->query("select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1','4') as codigocorto, p.idpartida as npartida, p.detalle as concepto, p.fecha as fecha, l.debe as debe, l.haber as haber FROM catalogo as c,partida as p, detallepartida as l where SUBSTRING(c.codigocuenta,'1','6')='410101' and c.codigocuenta!='41010103' and p.idpartida=l.idpartida and l.idcatalogo=c.idcatalogo and p.idperiodo='".$anioActivo."' and p.tipo!=2 and p.tipo!=3 ORDER BY p.idpartida ASC");
   $saldoComp=0.0;
if ($resultCompra) {
    while ($fila = $resultCompra->fetch_object()) {
    
        $saldoComp=$saldoComp+($fila->debe)-($fila->haber);
      
  }
}
$resultventa=0;//5101 ventas
$resultRebAndDevVenta=0;//5102 rebajas sobre venta
$resultRebAndDevCompra=0;//4102 rebajas sobre compra
$resultGastoCompra=0;//41010103 gasto de compra
$resultGastoAdministracion=0;//4103 gasto administracion 
$resultGastoVenta=0;//4104 gasto de venta
$resultGastoFinanciero=0;//4105 gasto financiero 
$resultOtrosGast=0;//43 otros gastos
$resultOtrosIngresos=0;//5105 otros ingresos
$resultInvetIni=0;//1106 inventario 
$resultadoOtrosIngresos2=0;//52 otros ingresos adicionales 

//este for es para reutilizar codigo basicamente se asigna una cuenta a cada ciclo las cuentas seran llamadas deacuerdo a el orden de arriba

for ($i=0; $i <11 ; $i++) { 
 switch($i){
  case 0 :$codigo="5101";break;
  case 1 :$codigo="5102";break;
  case 2 :$codigo="4102";break;
  case 3 :$codigo="41010103";break;
  case 4 :$codigo="4103";break;
  case 5 :$codigo="4104";break;
  case 6 :$codigo="4105";break;
  case 7 :$codigo="43";break;
  case 8 :$codigo="5105";break;
  case 9 :$codigo="1106";break;
  case 10 :$codigo="52";break;
  
 }

 $longCuenta=strlen($codigo);
 $resultAux= $conexion->query("select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1','4') as codigocorto,c.saldo as saldo,p.idpartida as npartida, p.detalle as concepto, p.fecha as fecha, l.debe as debe, l.haber as haber FROM catalogo as c,partida as p, detallepartida as l where SUBSTRING(c.codigocuenta,'1',$longCuenta)=$codigo and p.idpartida=l.idpartida and l.idcatalogo=c.idcatalogo and p.idperiodo='".$anioActivo."' and p.tipo!=2 and p.tipo!=3 ORDER BY p.idpartida ASC");
 $saldoAux=0.0;
if ($resultAux) {
    while ($fila = $resultAux->fetch_object()) {
     if($fila->saldo=="Deudor"){

       $saldoAux=$saldoAux+($fila->debe)-($fila->haber);
       
      
  }else{
     $saldoAux=$saldoAux+($fila->haber)-($fila->debe);
  }
     }
}


switch($i){
  case 0 :$resultventa=$saldoAux;break;
  case 1 :$resultRebAndDevVenta=$saldoAux;break;
  case 2 :$resultRebAndDevCompra=$saldoAux;break;
  case 3 :$resultGastoCompra=$saldoAux;break;
  case 4 :$resultGastoAdministracion=$saldoAux;break;
  case 5 :$resultGastoVenta=$saldoAux;break;
  case 6 :$resultGastoFinanciero=$saldoAux;break;
  case 7 :$resultOtrosGast=$saldoAux;break;
  case 8 :$resultOtrosIngresos=$saldoAux;break;
  case 9 :$resultInvetIni=$saldoAux;break;
  case 10 :$resultadoOtrosIngresos2=$saldoAux;break;

 }
}


$UB=((($resultventa-$resultRebAndDevVenta)-(((($saldoComp+$resultGastoCompra)-$resultRebAndDevCompra)+$resultInvetIni)-$inventariofinal))-($resultGastoAdministracion+$resultGastoVenta+$resultGastoFinanciero));

$UAIR=($UB-$resultOtrosGast)+$resultOtrosIngresos;
     $saldoAux=$UAIR;
     $reservaL=$UAIR*0.07;

     $UAI=$UAIR-$reservaL;

     if ($resultventa>150000) {
      $imp=$UAI*0.30;
     }else{
      $imp=$UAI*0.25;
     }
     $Utilidad=$UAI-$imp;
 ?>