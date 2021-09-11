<?php
//Codigo que muestra solo los errores exceptuando los notice.
error_reporting(E_ALL & ~E_NOTICE);
?>
<?php
//este documento se encarga de buscar la cuenta mediante el codigo de cuenta
//para devolverlo mediante una peticion jquery en el documento diario.php
$codigo=$_REQUEST["codigo"];
$opcion="";
$opcion=$_REQUEST["opcion"];
include 'config/conexion.php';
$result = $conexion->query("select * from periodo where estado=1");

if($result)
{
  while ($fila=$result->fetch_object()) {
    $anioActivo=$fila->idperiodo;
  }
}

if($opcion=="partida"){
if ($codigo=="") {
  echo '<input type="text" class="form-text" id="cuenta" name="cuenta" value="Vacio." >
  <span class="bar"></span>
  <label>Cuenta</label>';
}else {
  include 'config/conexion.php';

  //la consulta se asegura que la cuenta sea almenos de nivel 3 y del periodo altual
  $result = $conexion->query("select * from catalogo where idperiodo=$anioActivo and nivel>2 and codigocuenta=".$codigo);
  $nombre=$codigo;
  if ($result) {
    while ($fila = $result->fetch_object()) {
      $nombre=$fila->nombrecuenta;
      echo "<input type='text' class='form-text' id='cuenta' name='cuenta' value='".$nombre."' onkeyup='limpiaCodigo();'>
      <span class='bar'></span>
      <label>Cuenta</label>";
      echo "<input type='hidden' class='form-text' id='idCuenta' name='idCuenta' value='".$fila->idcatalogo."' >
      <span class='bar'></span>
      <label>Cuenta</label>";

    }
  }else {
    echo "<input type='text' class='form-text' id='cuenta' name='cuenta' value='error consulta' >
    <span class='bar'></span>
    <label>Cuenta</label>";
    }
  }
}
?>