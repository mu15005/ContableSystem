<?php 
session_start();
include "config/conexion.php";

//se obtiene el periodo activo
$result = $conexion->query("SELECT idperiodo as id,anio as anio from periodo where estado=1");
if($result){
  
  while ($filaAnio=$result->fetch_object()) {
   
    $anioActivo=$filaAnio->id;
     
  }
}

  $cadena="";

  $cadena=imprimir($anioActivo);
  //se imprime el texto para que de esta manera se pueda acceder a el desde la vista de catalogo
  echo $cadena;
  
  //la funcion imprimir devuelve el texto del codigo html de todas las categorias y subcategorias
  function imprimir($anioActivo){
include "config/conexion.php";

    $cadenaAux="";
    
    //se obtienen las 6 cuentas principales del catalogo correspondiente al periodo en el que se este trabajando
    $consulta="select idcatalogo as id,saldo, nombrecuenta as nombre, codigocuenta as codigo,nivel as nivel from catalogo where nivel='1' and idperiodo=$anioActivo order by codigocuenta";

    $result=$conexion->query($consulta);
    if($result){
      while ($fila=$result->fetch_object()) {
        

//estructura del codigo html para la impresion de las categorias 
        $cadenaAux=$cadenaAux."<div class='panel-group' id='accordian'><!--category-productsr-->

                                 <div class='panel panel-default '><div class='panel-heading'>
                                        <h4 class='panel-title'>
                                            <a data-toggle='collapse' data-parent='#accordian' href='#".eliminaEspacios($fila->nombre)."'>
                                                <span class='badge pull-left'><i class='fa fa-plus'></i></span>";
                  $cadenaAux=$cadenaAux.$fila->nombre;
                  $cadenaAux=$cadenaAux."</a>
                                <div style='float:right'>
                              <button type='button'  class='btn-flip btn btn-gradient btn-info btn-sm' data-toggle='modal' data-target='#miModalSub' onclick='cargaDatoSubCuenta(".eliminaEspacios($fila->codigo).");'"; 

                             if($_SESSION["onModificar"]=="consultar"){
                            $cadenaAux=$cadenaAux."disabled='true'";
                             }

                              $cadenaAux=$cadenaAux.">Agregar SubCuenta</button>
                              </div>
                              <div style='float:right;padding-right:30px'>
                              <button type='button'  class='btn-flip btn btn-gradient btn-success btn-sm'  data-toggle='modal' data-target='#miModalDetalles' onclick='cargaDato(0,".eliminaEspacios($fila->codigo).",0);'>Ver Detalles</button>
                              </div>
                                        </h4>
                                    </div>
                                    <div id='".eliminaEspacios($fila->nombre)."' class='panel-collapse collapse'>
                                        <div class='panel-body'>
                                            <ul>";
                                            
//se concatena el texto de las subcategorias de cada cuenta
                $cadenaAux=$cadenaAux.subCategorias($fila,$anioActivo);

                                          
                 $cadenaAux=$cadenaAux."</ul>
                                        </div>
                                    </div>
                                </div>
                                <hr style='border-color:darkgray;'>";
                
      
      }
    }

// se retorna el texto completo
    return $cadenaAux;
  }


//metodo recursivo que obtiene todas y cada una de las subcuentas hasta el final de los tiempos
  function subCategorias($fila,$idperiodo){
include "config/conexion.php";


    $codigo=$fila->codigo;
    $nombre=$fila->nombre;
    $nivel=$fila->nivel;
    //se incrementa el nivel para poder acceder a las centas hijas dela cuenta seleccionada 
    $nivel=$nivel+1;
    $cadenaAux="";
    

          $loncadena=strlen($codigo);
          $codigo=eliminaEspacios($codigo);
          $consult="select c.nombrecuenta as nombre, c.codigocuenta as codigo, SUBSTRING(c.codigocuenta,'1',$loncadena) as codigocorto,c.nivel as nivel, idperiodo as id FROM catalogo as c where SUBSTRING(c.codigocuenta,1,$loncadena)='".$codigo."' and nivel=$nivel and c.idperiodo=$idperiodo ORDER BY c.codigocuenta ASC";

         

              $result2=$conexion->query($consult);
              if($result2){
                while ($fila2=$result2->fetch_object()) {
        
        // estructura del codigo html para mostrar las categorias 
              $cadenaAux=$cadenaAux."<hr style='border-color:lightgray;'><li>";
        $cadenaAux=$cadenaAux."<div class='panel-group category-products' id='accordian'><!--category-productsr-->
        <div class='panel panel-default'><div class='panel-heading'>
                                        <h4 class='panel-title'>
                                            <a data-toggle='collapse' data-parent='#accordian' href='#".eliminaEspacios($fila2->nombre)."'>
                                                <span class='badge pull-left'><i class='fa fa-plus'></i></span>";
                  $cadenaAux=$cadenaAux.$fila2->nombre;
                  $mostrar="mostrar";
                  $formD="formD";
                  $cadenaAux=$cadenaAux."</a>
                                <div style='float:right'>
                              <button type='button'  class='btn-flip btn btn-gradient btn-info btn-sm' data-toggle='modal' data-target='#miModalSub' onclick='cargaDatoSubCuenta(".eliminaEspacios($fila2->codigo).");'"; 

                             if($_SESSION["onModificar"]=="consultar"){
                            $cadenaAux=$cadenaAux."disabled='true'";
                             }

                              $cadenaAux=$cadenaAux.">Agregar SubCuenta</button>
                              </div>
                              <div style='float:right;padding-right:30px'>
                              <button type='button'  class='btn-flip btn btn-gradient btn-success btn-sm'  data-toggle='modal' data-target='#miModalDetalles' onclick='cargaDato(0,".eliminaEspacios($fila2->codigo).",0);'>Ver Detalles</button>
                              </div>
                                        </h4>
                                    </div>
                                    <div id='".eliminaEspacios($fila2->nombre)."' class='panel-collapse collapse'>
                                        <div class='panel-body'>
                                            <ul>";
                                            
                  //el metodo se llama asi mismo para poder obtener las subcuentas de esta 
                 $cadenaAux=$cadenaAux.subCategorias($fila2,$idperiodo);
                 $cadenaAux=$cadenaAux."</ul>
                                        </div>
                                    </div>
                                </div>
                                </li>";

  }
      // si no se encuentran subcuentas o ya se obtubieron todas se retorna la cadena de texto
      return $cadenaAux;
        }else{
          return $cadenaAux;
        }
 
}

//funcion que elimina los espacios que pudiesen existir dentro de la cadena que se envia
//esto para garantizar la integridad de los datos y garantizar el correcto fucionamiento del metodo
function eliminaEspacios($cadena){

  $cadena=str_replace(' ','',$cadena);
return $cadena;
}
?>
