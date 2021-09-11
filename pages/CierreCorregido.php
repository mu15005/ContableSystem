<?php   
session_start();
include "config/conexion.php";
$onModifiPeriodo="";
$idp="";

if(isset($_REQUEST["onModifiPeriodo"]) and isset($_REQUEST["idperiodo"])){
  $onModifiPeriodo=$_REQUEST["onModifiPeriodo"];
$idp=$_REQUEST["idperiodo"];
}

if($idp!="" and $onModifiPeriodo=="true"){
   $resultAnio=$conexion->query("UPDATE `periodo` SET `estado`=false");
    if ($resultAnio)
    {
       $resultAnio=$conexion->query("UPDATE `periodo` SET `estado`=true where idperiodo=$idp");
        
    }
}
onCierre();
function onCierre(){

  include "config/conexion.php";
   $resultAnio=$conexion->query("select * from periodo where estado=1");
    if ($resultAnio)
    {
      while ($fila=$resultAnio->fetch_object())
      {
                      $idperiodo=$fila->idperiodo;
                      $anio=$fila->anio;
                      
      }
    }
  $bandera=0;
  $bandera+=validaciones($idperiodo);
  

  if($bandera>0){
    //impresion($cuentasFaltantes[$i],$bandera,$idperiodo);
    echo 3;
  }else{
    
   

    
      cierreModificado($idperiodo,$anio);
    
  }
}

function validaciones($idperiodo){
  include 'config/conexion.php';
    $bandera=0;
$vector=["2106","1103","210202","5101","5102","410101","41010103","4102","1106","410101","6101","5101","4104","4103","4105","43","2107","320101","320202"];
$cuentasFaltantes=array();
  for ($i=0; $i <19 ; $i++) { 
     
    if(getIdCatalogo("$vector[$i]",$idperiodo,$conexion)==-1){
      $cuentasFaltantes[$i]=$vector[$i];
      
      $bandera++;
    }
    
   

    
  }
 
   return $bandera;
}
function getIdCodigo($codigocuenta,$idperiodo,$conexion){

    $consulta="SELECT * FROM catalogo where codigocuenta='".$codigocuenta."' and idperiodo=$idperiodo";
    $result=$conexion->query($consulta);
   
    $idcatalogo=-1;
    if($result){
      while($fila=$result->fetch_object()){
        $idcatalogo=$fila->idcatalogo;
      }
    }
    return $idcatalogo;
}
function getIdCatalogo($codigocuenta,$idperiodo,$conexion){
   
    $consulta="SELECT * FROM catalogo where codigocuenta='".$codigocuenta."' and idperiodo=$idperiodo";
    $result=$conexion->query($consulta);
   
    $idcatalogo=-1;
    if($result){
      while($fila=$result->fetch_object()){
        $idcatalogo=$fila->idcatalogo;
      }
    }
    return $idcatalogo;
  }
  function getNombreCuenta($codigocuenta,$idperiodo){
    include "config/conexion.php";
    $result=$conexion->query("SELECT * FROM catalogo where codigocuenta=$codigocuenta and idperiodo=$idperiodo");
    $idcatalogo=-1;
    if($result){
      while($fila=$result->fetch_object()){
        $idcatalogo=$fila->idcatalogo;
      }
    }
    return $idcatalogo;
  }

  function generaIdPartida($idpd,$conexion){
    
      $result = $conexion->query("SELECT MAx(idpartida) as idpartida FROM partida");
      $idpartida=-1;
      if($result){
        while($fila=$result->fetch_object()){
          $idpartida=$fila->idpartida;
        }
        $idpartida++;
      }

      return $idpartida;
  }
    function generaNumP($idpd,$conexion){
   
      $result = $conexion->query("SELECT MAx(numpartida) as numpartida FROM partida where idperiodo=$idpd");
      $numpartida=-1;
      if($result){
        while($fila=$result->fetch_object()){
          $numpartida=$fila->numpartida;
        }
        $numpartida++;
      }

      return $numpartida;
  }

  function getCuentas($nivelMayorizacion,$inicio,$fin,$idanio){
      //Agarrar las cuentas del catalogo de acuerdo al nivel seleccionaod
                    //si no se selecciona nivel, por defecto sera nivel 1
                    //inicio consulta por nivel
  include "config/conexion.php";
                    $result = $conexion->query("select idcatalogo as id,saldo, nombrecuenta as nombre, codigocuenta as codigo from catalogo where SUBSTRING(codigocuenta,1,1)>=$inicio and SUBSTRING(codigocuenta,1,1)<=$fin and  nivel=$nivelMayorizacion and idperiodo=$idanio order by codigocuenta");
   
            return $result;
}



function impresion($vector,$bandera,$idperiodo)
{
  $cadena="";
  $cadena=$cadena."<div class='responsive-table'>              
                   
            <table class='table table-bordered'  id='tablaCuentasF'>
                <thead>
                    <tr >
                        
                        <th>codigo</th>
                        <th>Nombre</th>
                       
                        
                    </tr>
                </thead>
                <tbody id='tbodys'>";
                  
                  
                        for ($i=0; $i <$bandera ; $i++) {
                    $cadena=$cadena."<tr>
                      <td>".$vector[$i]."</td>
                      <td>".getNombreCuenta($vector[$i],$idperiodo)."</td>
                    </tr>";

                             } 
                       $cadena=$cadena."</table>
                    </div>  
                    </div>";

                  echo $cadena;
              }


function cierreFinal($idperiodo,$idpPNuevo,$anioNuevo,$conexion){
  $bandera=0;
      
      

  // aqui comienzan el codigo para las partidas de cierre y apertura

    if($idpPNuevo=="none"){
      $resultAnio=$conexion->query("select * from periodo where idperiodo=$idperiodo");
    if ($resultAnio)
    {
      while ($fila=$resultAnio->fetch_object())
      {
                      $anio=$fila->anio;
                      
      }
    }
    $idpPNuevo=$idperiodo+1;
    $anioNuevo=$anio+1;

       $consulta="INSERT INTO `periodo`(`idperiodo`,`anio`, `estado`,`subestado`) VALUES ($idpPNuevo,$anioNuevo,false,false)";

    if(!($conexion->query($consulta))){

      $bandera++;

    }else{
      $bandera+=creaCuentasPeriodo($conexion,$idperiodo,($idperiodo+1));
      # $bandera=$bandera+creaCuentasPeriodo($conexion,$idperiodo,$idpPNuevo);
    }

    }else{
      $anio=$anioNuevo-1;
    }
 
    //se obtiene las cuentas de mayor de activo, pasivo y patrimonio
    $resultCuantas=getCuentas(3,1,3,$idperiodo);


    if($resultCuantas){
  
      $fecha=($anio)."-12-31";
      $fecha1=($anio+1)."-01-01";

      // se eliminan las partidas de cierre y apertura en caso exista
      
      

      //se elimina la partida de apertura de existir
      eliminarPartidaApertura($idpPNuevo,$conexion);

       $numeroPartida=generaNumP($idperiodo,$conexion);
       $idpartida=generaIdPartida($idperiodo,$conexion);


     
      //partida de cierre 
        $consulta1  = "INSERT INTO `partida`(`idpartida`,`numpartida`, `idperiodo`, `fecha`, `detalle`, `estado`, `tipo`) VALUES ($idpartida,$numeroPartida,$idperiodo,'".$fecha."','Partida de cierre',1,2)";
        $resultado1=$conexion->query($consulta1);
    
        //partida de apertura
        $numeroPNuevo=($numeroPartida+1);
        $idpartidaN=($idpartida+1);
        $consulta2  = "INSERT INTO `partida`(`idpartida`,`numpartida`, `idperiodo`, `fecha`, `detalle`, `estado`, `tipo`) VALUES ($idpartidaN,1,$idpPNuevo,'".$fecha1."','Partida de apertura',1,1)";
   $resultado2 = $conexion->query($consulta2);
    
    if ($resultado1==true && $resultado2==true) {
         
                          
                          //inicio de la consulta para encontrar las cuentas que son subcuentas de la cuenta anterior
                         

      while($fila=$resultCuantas->fetch_object()){
        $loncadena=strlen($fila->codigo);
       
         $resultSubcuenta= $conexion->query("select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1','".$loncadena."') as codigocorto, p.idpartida as npartida, p.detalle as concepto, p.fecha as fecha, l.debe as debe, l.haber as haber FROM catalogo as c,partida as p, detallepartida as l where SUBSTRING(c.codigocuenta,1,'".$loncadena."')='".$fila->codigo."' and p.idpartida=l.idpartida and l.idcatalogo=c.idcatalogo and p.idperiodo='".$idperiodo."' ORDER BY p.idpartida ASC");
                          if ($resultSubcuenta) {
                            $saldo=0.0;
                               while ($fila2 = $resultSubcuenta->fetch_object()) {
        
        if ($fila->saldo=="Deudor") {
                                  $saldo=$saldo+($fila2->debe)-($fila2->haber);
                                }else {
                                  $saldo=$saldo-($fila2->debe)+($fila2->haber);
                                }
                            }
                              }
            if($saldo>0){

              $idcat=getIdCatalogo($fila->codigo,$idpPNuevo,$conexion);
              
            if($fila->saldo=="Deudor"){
            //detalle para la partida de cierre
             $consulta1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,$fila->id,0,$saldo)";
             //detalle para la partida de apertura
             $consulta2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartidaN,$idcat,$saldo,0)";
          }else{
            //detalle para la partida de cierre
             $consulta1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,$fila->id,$saldo,0)";
             //detalle para la partida de apertura
            $consulta2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartidaN,$idcat,0,$saldo)";
          }  


            if(!($conexion->query($consulta1)) || !($conexion->query($consulta2))){
            $bandera++;

           }

}
        /*if(substr($fila->codigo,0,1)=="1"){
          //echo "$fila->codigo <br";
          if($fila->saldo=="Deudor"){
            //detalle para la partida de cierre
             $consulta1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,$fila->id,0,$saldo)";
             //detalle para la partida de apertura
              $consulta2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartidaN,$fila->id,$saldo,0)";
          }else{
            //detalle para la partida de cierre
             $consulta1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,$fila->id,$saldo,0)";
             //detalle para la partida de apertura
             $consulta2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartidaN,$fila->id,0,$saldo)";
          }

           
           if(!($conexion->query($consulta1)) || !($conexion->query($consulta2))){
            $bandera++;


           }
        }

        if(substr($fila->codigo,0,1)=="2"){

          if($fila->saldo=="Deudor"){
             $consulta1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,$fila->id,0,$saldo)";
          }else{
             $consulta2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartidaN,$fila->id,$saldo,0)";
          }

           
            if(!($conexion->query($consulta1)) || !($conexion->query($consulta2))){
            $bandera++;

           }
        }

        if(substr($fila->codigo,0,1)=="3"){

          if($fila->saldo=="Deudor"){
             $consulta1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,$fila->id,0,$saldo)";
          }else{
             $consulta2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartidaN,$fila->id,$saldo,0)";
          }

           
            if(!($conexion->query($consulta1)) || !($conexion->query($consulta2))){
            $bandera++;

           }
        }*/
      }

      }else{
        $bandera++;
        
      }

    }
    return $bandera;

}



function eliminarPartidaApertura($idperiodo,$conexion){

  $consulta="DELETE FROM `partida` WHERE tipo=1 and idperiodo=$idperiodo";
  $result=$conexion->query($consulta);
  if($consulta){
    return 0;
  }else{
    return 1;
  }
}
function eliminarPartidaCierre($idperiodo,$conexion){
  
 
  $result=$conexion->query("DELETE FROM `partida` WHERE  tipo=2 and idperiodo=$idperiodo");
  if($result){
    return 0;
  }else{
    return 1;
  }

}
function eliminarPartidasAjuste($idperiodo,$conexion){
 
 
  $result=$conexion->query("DELETE FROM `partida` WHERE  tipo=3 and idperiodo=$idperiodo");
  if($result){
    return 0;
  }else{
    return 1;
  }

}
function CierreModificado($idperiodo,$anio){
  include "config/conexion.php";
  $con=$conexion;

    
  $conexion->autocommit(false);

 
  $result=$conexion->query("SELECT * FROM `periodo` WHERE anio>$anio order by anio ASC");
  if($result){
    $bandera=0;
    $totalPeriodos=$result->num_rows;

    //si solo se encuentra un periodo se hace un solo cierre
    if($totalPeriodos==0){
        eliminarPartidasAjuste($idperiodo,$conexion);
        eliminarPartidaCierre($idperiodo,$conexion);
        #eliminarPartidaApertura(($idperiodo+1),$con);
     $bandera+= creaPartidasAjuste($idperiodo,$conexion,$anio);
   

      $bandera+=cierreFinal($idperiodo,"none","",$conexion);
      if($bandera==0){
        $conexion->commit();
       
        $_SESSION["onModificar"]="normal";

   
     //header("location:catalogo.php");


        $consulta="SELECT max(idperiodo) as id from `periodo`";
    $result=$conexion->query($consulta);
    if($result){
      while ($fila=$result->fetch_object()) {
        $id=$fila->id;
      }
    }

      $consulta="UPDATE `periodo` SET `estado`=false";
        $result=$conexion->query($consulta);
        if($result){
            $consulta="UPDATE `periodo` SET `estado`=true WHERE idperiodo='".$id."'";
          $result=$conexion->query($consulta);
       
        }
        $conexion->commit();
        echo 1;
      }else{
       $conexion->rollback();
        echo -1;
      }
    }else{

      $result=$conexion->query("SELECT * FROM `periodo` WHERE anio>=$anio order by anio ASC");
      $contador=0;
       $totalPeriodos=$result->num_rows;

       $bandera=0;
       while ($fila=$result->fetch_object()) {
              $anio=$fila->anio;
               if(($contador+1)<$totalPeriodos){
                if(validaciones($fila->idperiodo)==0 /* and validaciones(($fila->idperiodo+1))==0*/){
                  
          eliminarPartidasAjuste($idperiodo,$conexion);
          eliminarPartidaCierre($idperiodo,$conexion);
          eliminarPartidaApertura(($fila->idperiodo+1),$conexion);
      
          $bandera+= creaPartidasAjuste($idperiodo,$conexion,$anio);


          $bandera+=cierreFinal($fila->idperiodo,($fila->idperiodo+1),($fila->anio+1),$conexion);
           
         }else{
         
        $bandera=-1;
        
       }

       }
         $contador++;
       }

       
       if ($bandera==0) {
         $conexion->commit();
         $conexion->query("UPDATE `periodo` SET `subestado`=false WHERE idperiodo='".$idperiodo."'");
         $conexion->commit();


          $_SESSION["onModificar"]="normal";

   
     //header("location:catalogo.php");


        $consulta="SELECT max(idperiodo) as id from `periodo`";
    $result=$conexion->query($consulta);
    if($result){
      while ($fila=$result->fetch_object()) {
        $id=$fila->id;
      }
    }

      $consulta="UPDATE `periodo` SET `estado`=false";
        $result=$conexion->query($consulta);
        if($result){
            $consulta="UPDATE `periodo` SET `estado`=true WHERE idperiodo='".$id."'";
          $result=$conexion->query($consulta);
       
        }
        $conexion->commit();
         
         echo  1;
       }else if($bandera==-1){
       echo 3;
       }else{
         $conexion->rollback();
        echo -1;
       }
    }
    
  }
}
function creaCuentasPeriodo($conexion,$idperiodo,$idpPNuevo){
  $bandera=0;
  $consult="SELECT * FROM `catalogo` WHERE idperiodo='".$idperiodo."'";
  $result=$conexion->query($consult);
  if($result){
    while ($fila=$result->fetch_object()) {
      $consult1="INSERT INTO `catalogo`(`codigocuenta`, `nombrecuenta`, `tipo`, `saldo`, `nivel`,`idperiodo`) VALUES ('".$fila->codigocuenta."','".$fila->nombrecuenta."','".$fila->tipo."','".$fila->saldo."','".$fila->nivel."','".$idpPNuevo."')";
     
    if($conexion->query($consult1)!=1){
      $bandera++;
    }
   
    
    }
  }
return $bandera;
}
function creaPartidasAjuste($idperiodo,$conexion,$anio){
  // se obtienen los saldos de otdas las cuentas necesarias para el proceso
   $inventarioFinal=0;
  if(isset($_REQUEST["if"])){
  $inventarioFinal=$_REQUEST["if"];

  }
  eliminarPartidasAjuste($idperiodo,$conexion);
  $valores=obtieneValoresPA($idperiodo,$inventarioFinal,$conexion);

  // se eliminan las partidas de ajuste
 
  // se crean las partidas de cierre mediante un bucle for y un bucle while


  
 $resultIvaDebito= $conexion->query("select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1','4') as codigocorto, p.idpartida as npartida, p.detalle as concepto, p.fecha as fecha, l.debe as debe, l.haber as haber FROM catalogo as c,partida as p, detallepartida as l where SUBSTRING(c.codigocuenta,1,'4')='2106' and p.idpartida=l.idpartida and l.idcatalogo=c.idcatalogo and p.idperiodo=$idperiodo ORDER BY p.idpartida ASC");



   $saldoIvaDebito=0.0;
if ($resultIvaDebito) {
  
    while ($fila = $resultIvaDebito->fetch_object()) {
    
        $saldoIvaDebito=$saldoIvaDebito+($fila->haber)-($fila->debe);
      
  }
}


$resultIvaCredito= $conexion->query("select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1','4') as codigocorto, p.idpartida as npartida, p.detalle as concepto, p.fecha as fecha, l.debe as debe, l.haber as haber FROM catalogo as c,partida as p, detallepartida as l where SUBSTRING(c.codigocuenta,1,'4')='1103' and p.idpartida=l.idpartida and l.idcatalogo=c.idcatalogo and p.idperiodo=$idperiodo ORDER BY p.idpartida ASC");


   $saldoIvaCredito=0.0;
if ($resultIvaCredito) {
    while ($fila = $resultIvaCredito->fetch_object()) {
    
        $saldoIvaCredito=$saldoIvaCredito+($fila->debe)-($fila->haber);
      
  }
}

$difereciaIvaCredito=$saldoIvaDebito-$saldoIvaCredito;



$bandera=0;

  $fecha=($anio)."-12-31";
  $numeroPartida=generaNumP($idperiodo,$conexion);
  $idpartida=generaIdPartida($idperiodo,$conexion);
  $vectorConceptos=["Partidas de ajuste, Liquidacion de iva debito y iv credito",
            "Partidas de ajuste, Liquidacion de rebajas y deb sobre venta","Partidas de ajuste, Liquidacion de Gastos de Compra","Partidas de ajuste, Liquidacion Rebajas y Devoluciones sobre compra","Partidas de ajuste, Liquidacion de Inventario Inicial","Partidas de ajuste, Apertura Inventario Final","Partidas de ajuste, Liquidacion de Compras","Partidas de ajuste, Liquidacion de Ventas","Para deducir utilidad de operacion","Liquidacion de perdidas y ganancias"];
  for ($i=0; $i <10; $i++) { 

  $consulta  = "INSERT INTO `partida`(`idpartida`,`numpartida`, `idperiodo`, `fecha`, `detalle`, `estado`, `tipo`) VALUES($idpartida,$numeroPartida,$idperiodo,'".$fecha."','".$vectorConceptos[$i]."',true,3)";

  
  
    $resultado = $conexion->query($consulta);

   
    if ($resultado) {
    
      switch ($i) {
        case 0:



         $consult1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('2106',$idperiodo,$conexion)."',$saldoIvaDebito,0)";
            $consult2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('1103',$idperiodo,$conexion)."',0,$saldoIvaCredito)";
             $consult3  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('210202',$idperiodo,$conexion)."',0,$difereciaIvaCredito)";

      

          $result1 = $conexion->query($consult1);
        
          $result2 = $conexion->query($consult2);
          
          $result3 = $conexion->query($consult3);
          
          if (!($result1) || !($result2) || !($result3)) {
            $bandera++;

            
          }
         break;
         case 1:
        
        //acumulacion de ventas
        $valores[0]-=$valores[1];
       
         $consult1  = "INSERT INTO `detallepartida`(`idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('5101',$idperiodo,$conexion)."',$valores[1],0)";
            $consult2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('5102',$idperiodo,$conexion)."',0,$valores[1])";
            

         
      
          $result1 = $conexion->query($consult1);
     
          $result2 = $conexion->query($consult2);
        
          if (!($result1) || !($result2)) {
            $bandera++;

            
          }
         break;
         case 2:

        //acumulacion de compra
        $valores[17]+=$valores[3];
        $codigo2="41010103";
         $consult1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('410101',$idperiodo,$conexion)."',$valores[3],0)";
            $consult2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('41010103',$idperiodo,$conexion)."',0,$valores[3])";
            
        
          $result1 = $conexion->query($consult1);

          $result2 = $conexion->query($consult2);
         
          if (!($result1) || !($result2)) {
            $bandera++;
            
          }
         break;
          case 3:
         
        //disminucion de compra
        $valores[17]-=$valores[2];
         $consult1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('4102',$idperiodo,$conexion)."',$valores[2],0)";
            $consult2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('410101',$idperiodo,$conexion)."',0,$valores[2])";
            
        
          $result1 = $conexion->query($consult1);
          
         
          $result2 = $conexion->query($consult2);
         
          if (!($result1) || !($result2)) {
            $bandera++;

            
          }
         break;
         case 4:
         
        //acumulacion de compra
        $valores[17]+=$valores[9];
        
         $consult1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('410101',$idperiodo,$conexion)."',$valores[9],0)";
            $consult2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('1106',$idperiodo,$conexion)."',0,$valores[9])";
            
        
          $result1 = $conexion->query($consult1);
          $result2 = $conexion->query($consult2);
         
          if (!($result1) || !($result2)) {
            $bandera++;
            
          }
         break;
         case 5:
        
        //disminucion de compra
        $valores[17]-=$inventarioFinal;
         $consult1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('1106',$idperiodo,$conexion)."',$inventarioFinal,0)";
            $consult2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('410101',$idperiodo,$conexion)."',0,$inventarioFinal)";
            
        
          $result1 = $conexion->query($consult1);
          $result2 = $conexion->query($consult2);
         
          if (!($result1) || !($result2)) {
            $bandera++;

            
          }
         break;
         case 6:

        //dismunucion de ventas 
        $valores[0]-= $valores[17];
        
         $consult1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('5101',$idperiodo,$conexion)."', $valores[17],0)";
            $consult2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('410101',$idperiodo,$conexion)."',0, $valores[17])";
            
        
          $result1 = $conexion->query($consult1);
          $result2 = $conexion->query($consult2);
         
          if (!($result1) || !($result2)) {
            $bandera++;
          
          }
         break;
          case 7:
          //falta agregar estas cuentas!!
          $consult1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('5101',$idperiodo,$conexion)."',$valores[0],0)";
            $consult2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('6101',$idperiodo,$conexion)."',0,$valores[0])";
            
        
          $result1 = $conexion->query($consult1);
          $result2 = $conexion->query($consult2);
         
          if (!($result1) || !($result2)) {
            $bandera++;

            
          }
         break;
         case 8:
         //falta agregar estas cuentas!!!
         
        $suma=($valores[5]+$valores[4]+$valores[6]+$valores[7]+$valores[15]+$valores[13])-$valores[8];
          $consult1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('6101',$idperiodo,$conexion)."',$suma,0)";
            $consult2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('4104',$idperiodo,$conexion)."',0,$valores[5])";
            $consult3  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('4103',$idperiodo,$conexion)."',0,$valores[4])";
            $consult4  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('4105',$idperiodo,$conexion)."',0,$valores[6])";
            $consult5  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('43',$idperiodo,$conexion)."',0,$valores[7])";
            $consult6  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('2107',$idperiodo,$conexion)."',0,$valores[15])";
            $consult7  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('320101',$idperiodo,$conexion)."',0,$valores[13])";
             
            
        
          $result1 = $conexion->query($consult1);
         
          $result2 = $conexion->query($consult2);

           $result3 = $conexion->query($consult3);

          $result4= $conexion->query($consult4);

           $result5 = $conexion->query($consult5);

          $result6 = $conexion->query($consult6);

          $result7 = $conexion->query($consult7);

          
          
           
      
         
          if (!($result1) || !($result2) || !($result3) || !($result4) || !($result5) || !($result6) || !($result7) ) {
            $bandera++;
  
          
          }
         break;
          case 9:
          ///falta agregar estas cuentas !!!!
          $consult1  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('6101',$idperiodo,$conexion)."',$valores[16],0)";
            $consult2  = "INSERT INTO `detallepartida`( `idpartida`, `idcatalogo`, `debe`, `haber`) VALUES ($idpartida,'".getIdCatalogo('320202',$idperiodo,$conexion)."',0,$valores[16])";
            
        
          $result1 = $conexion->query($consult1);
          $result2 = $conexion->query($consult2);
         
          if (!($result1) || !($result2)) {
            $bandera++;

          
          }
         break;
      }
  
    
      
      }else{
        $bandera++;


        
      }
       
     $idpartida++;
  $numeroPartida++;
  }

return $bandera;
}



function craCatalogo($conexion,$idperiodo,$idperiodonuevo){
  $bandera=0;
  $consulta="SELECT * FROM catalogo where idperiodo='".$idperiodo."'";
  $resultC=$conexion->query($consulta);
  if($resultC){
    while ($fila=$resultC->fetch_object()) {
      $consulta="INSERT INTO `catalogo`(`codigocuenta`, `nombrecuenta`, `tipo`, `saldo`, `nivel`, `r`, `idperiodo`) VALUES ('".$fila->codigocuenta."','".$fila->nombrecuenta."','".$fila->tipo."','".$fila->saldo."','".$fila->nivel."','".$fila->r."','".$idperiodonuevo."'";
        $bandera=$bandera+$conexion->query($consulta);
      
    }
  }else{
    $bandera++;
  }
  return $bandera;
}

function obtieneValoresPA($idperiodo,$inventariofinal,$conexion){
    //caso especial 
  
  $consultaEsp="select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1','4') as codigocorto, p.idpartida as npartida, p.detalle as concepto, p.fecha as fecha, l.debe as debe, l.haber as haber FROM catalogo as c,partida as p, detallepartida as l where SUBSTRING(c.codigocuenta,'1','6')='410101' and c.codigocuenta!='41010103' and p.idpartida=l.idpartida and l.idcatalogo=c.idcatalogo and p.idperiodo='".$idperiodo."' ORDER BY p.idpartida ASC";
  
  $resultCompra= $conexion->query($consultaEsp);
   $saldoComp=0.0;
if ($resultCompra) {
    while ($fila = $resultCompra->fetch_object()) {
    
        $saldoComp=$saldoComp+($fila->debe)-($fila->haber);
      
  }
}

$resultventa=0;//5101
$resultRebAndDevVenta=0;//5102
$resultRebAndDevCompra=0;//4102
$resultGastoCompra=0;//41010103
$resultGastoAdministracion=0;//4103
$resultGastoVenta=0;//4104
$resultGastoFinanciero=0;//4105
$resultOtrosGast=0;//43
$resultOtrosIngresos=0;//5105
$resultInvetIni=0;//1106
$resultadoOtrosIngresos2=0;//52

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
 $resultAux= $conexion->query("select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1','4') as codigocorto,c.saldo as saldo,p.idpartida as npartida, p.detalle as concepto, p.fecha as fecha, l.debe as debe, l.haber as haber FROM catalogo as c,partida as p, detallepartida as l where SUBSTRING(c.codigocuenta,'1',$longCuenta)=$codigo and p.idpartida=l.idpartida and l.idcatalogo=c.idcatalogo and p.idperiodo='".$idperiodo."' ORDER BY p.idpartida ASC");
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


     /* 0 :$resultventa
   1 :$resultRebAndDevVenta
   2 :$resultRebAndDevCompra
   3 :$resultGastoCompra
   4 :$resultGastoAdministracion
   5 :$resultGastoVenta
   6 :$resultGastoFinanciero
   7 :$resultOtrosGast
   8 :$resultOtrosIngreso
   9 :$resultInvetIni
   10 :$resultadoOtrosIngresos2
   11 :UtilidadBruta
   12 :Utilidad antes de Impuesto y reserva
   13 : reserva L
   14 : Utilidad antes de impuesto
   15 :impuesto
   16 :utilidad
   17 :saldo comp*/

    $valores=[$resultventa,$resultRebAndDevVenta,$resultRebAndDevCompra,$resultGastoCompra,$resultGastoAdministracion,$resultGastoVenta,$resultGastoFinanciero,$resultOtrosGast,$resultOtrosIngresos,$resultInvetIni,$resultadoOtrosIngresos2,$UB,$UAIR,$reservaL,$UAI,$imp,$Utilidad,$saldoComp
    ];
    return $valores;
}
  ?>

     