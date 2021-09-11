<?php
//Codigo que muestra solo los errores exceptuando los notice.
error_reporting(E_ALL & ~E_NOTICE);
?>
<?php
session_start();
// este documento se encarga de devolver los campos de las ventanas modales 
// de registro nuvo catalogo y el de detalle de catalogo
include 'config/conexion.php';
$opcion="";
$opcion=$_REQUEST["opcion"];
$codigo=$_REQUEST["codigo"];

$result = $conexion->query("select * from periodo where estado=1");

if($result)
{
  while ($fila=$result->fetch_object()) {
    $anioActivo=$fila->idperiodo;
  }
}

	


if($codigo!="") {
  
  $result = $conexion->query("select * from catalogo where idperiodo=$anioActivo and codigocuenta=".$codigo);
	$nombre="";
	$nivel="";
	$saldo="";
	$tipo="";

  if ($result) {
    while ($fila = $result->fetch_object()) {
      $nombre=$fila->nombrecuenta;
     $nivel=$fila->nivel;
     $tipo=$fila->tipo;
     $saldo=$fila->saldo;


    }
    

  }

}

mostrar($codigo,$nivel,$nombre,$tipo,$saldo,$opcion);


//la funcion mostrar devuelve el contenido de las ventanas modales dependiendo la opcion 
function mostrar($codigo,$nivel,$nombre,$tipo,$saldo,$opcion){


switch ($opcion) {
  
			case 'agregar':
		?>




                          
                                        <label class="form__label">Codigo</label>
                                        <input type="text"  class="form__field" name="codigo" id="codigo" style="width: 70%;" value="<?php echo($codigo); ?>" onkeyup="generaNivel('padre')">
                                         
                                     


       
                    
                                    
                    <label class="form__label">Nivel</label>
                    <input type="text" name="nivel" class="form__field"  disabled="true" style="width: 25%;padding-left:50px;" value="<?php echo($nivel); ?>" id="nivel"><br><br>
                
                    <label class="form__label" style="top:18%;">Nombre</label>
                    <input type="text" name="nombre" class="form__field" style="width: 94%;" value="<?php echo($nombre); ?>" id="nombre"><br><br> 
                    
                    
                    <div class="form-group form-animate-text" style="margin-top:50px !important;">
                    <select name="tipo" id="tipo" class="form-text"  disabled="true" style="width: 98%;color:#526470;">
                     <option value="SELECCIONE"   >SELECCIONE</option>
                                      <option value="ACTIVO" >ACTIVO</option>
                                      <option value="PASIVO">PASIVO</option>
                                      <option value="PATRIMONIO Y RESERVAS">PATRIMONIO Y RESERVAS</option>
                                      <option value="CUENTAS DE RESULTADO DEUDOR">CUENTAS DE RESULTADO DEUDOR </option>
                                     
                                      <option value="CUENTAS DE RESULTADO ACREEDOR" >CUENTAS DE RESULTADO ACREEDOR</option>
                                      <option value="CUENTAS LIQUIDADORAS" >CUENTAS LIQUIDADORAS</option>

                                      
                    </select><br>
                    <label style="top:-40px;font-size: 20px;color:#5264AE">Tipo</label>
                    </div>

                    <div class="form-group form-animate-text" style="margin-top:50px !important;"> 
                    
                    <select name="saldo" class="form-text" id="saldo" style="width: 50%;color:#5264AE">
                      <option value="SELECCIONE">SELECCIONE</option>
                      <option value="Deudor">Deudor</option>
                      <option value="Acreedor">Acreedor</option>
                     </select>
                    <label style="top:-40px;font-size:20px;color:#5264AE">Saldo</label>
                      </div>
                   


		<?php 
			break;
		
			case 'mostrar':
		?>
      <script type="text/javascript">
        cargaSelect('<?php echo $tipo; ?>','<?php  echo $saldo;?>');
      </script>
			
                                        <label class="form__label">Codigo</label>
                                        <input type="text"  class="form__field" name="codigo" id="codigo" disabled="true" style="width: 70%;" value="<?php echo($codigo); ?>" onkeyup="generaNivel('padre')">
                                         
                                     


       
                    
                                    
                    <label class="form__label">Nivel</label>
                    <input type="text" name="nivel" class="form__field"  disabled="true" style="width: 25%;padding-left:50px;" value="<?php echo($nivel); ?>" id="nivel"><br><br>
                
                    <label class="form__label" style="top:15%;">Nombre</label>
                    <input type="text" name="nombre" class="form__field" style="width: 94%;" disabled="true" value="<?php echo($nombre); ?>" id="nombre"><br><br> 
                    
                    
                    <div class="form-group form-animate-text" style="margin-top:50px !important;">
                    <select name="tipo" id="tipo" class="form-text"  disabled="true" style="width: 98%;color:#526470;">
                     <option value="SELECCIONE"   >SELECCIONE</option>
                                      <option value="ACTIVO" >ACTIVO</option>
                                      <option value="PASIVO">PASIVO</option>
                                      <option value="PATRIMONIO Y RESERVAS">PATRIMONIO Y RESERVAS</option>
                                      <option value="CUENTAS DE RESULTADO DEUDOR">CUENTAS DE RESULTADO DEUDOR </option>
                                     
                                      <option value="CUENTAS DE RESULTADO ACREEDOR" >CUENTAS DE RESULTADO ACREEDOR</option>
                                      <option value="CUENTAS LIQUIDADORAS" >CUENTAS LIQUIDADORAS</option>

                                      
                    </select><br>
                    <label style="top:-40px;font-size: 20px;color:#5264AE">Tipo</label>
                    </div>
                   <div class="form-group form-animate-text" style="margin-top:50px !important;"> 
                    
                    <select name="saldo" class="form-text" id="saldo" disabled="true" style="width: 50%;color:#5264AE">
                      <option value="SELECCIONE">SELECCIONE</option>
                      <option value="Deudor">Deudor</option>
                      <option value="Acreedor">Acreedor</option>
                     </select>
                    <label style="top:-40px;font-size:20px;color:#5264AE">Saldo</label>
                      </div>
                   
                    

                    
                      <div class="text-center">
                                    <button type="button" class="btn ripple-infinite btn-round btn-info" data-dismiss="modal">Cerrar</button>      
                                   
                                    <button  type="button" id="modifi"  <?php if($_SESSION["onModificar"]=="consultar"){ ?>  disabled="true" <?php  } ?> name="modifi"onclick="cargaDato('modificar',<?php echo "$codigo"; ?>,'formD')" class="btn ripple-infinite btn-round btn-success">Modificar</button>   
                                     <button  type="button" id="delete"  <?php if($_SESSION["onModificar"]=="consultar"){ ?>  disabled="true" <?php  } ?> name="delete" onclick="onDelete(<?php echo "$codigo"; ?>)" class="btn ripple-infinite btn-round btn-danger">Eliminar</button>
                                   </div>



		<?php  
	break;
		
	case 'modificar':
		?>
     <script type="text/javascript">
        cargaSelect('<?php echo $tipo; ?>','<?php  echo $saldo;?>');
      </script>
						     <label class="form__label">Codigo</label>
                                        <input type="text"  class="form__field" name="codigo" id="codigo" disabled="true" style="width: 70%;" value="<?php echo($codigo); ?>" onkeyup="generaNivel('padre')">
                                         
                                     


       
                    
                                    
                    <label class="form__label">Nivel</label>
                    <input type="text" name="nivel" class="form__field"  disabled="true" style="width: 25%;padding-left:50px;" value="<?php echo($nivel); ?>" id="nivel"><br><br>
                
                    <label class="form__label" style="top:15%;">Nombre</label>
                    <input type="text" name="nombre" class="form__field" style="width: 94%;"  value="<?php echo($nombre); ?>" id="nombre"><br><br> 
                    
                    
                    <div class="form-group form-animate-text" style="margin-top:50px !important;">
                    <select name="tipo" id="tipo" class="form-text"  disabled="true" style="width: 98%;color:#526470;">
                     <option value="SELECCIONE"   >SELECCIONE</option>
                                      <option value="ACTIVO" >ACTIVO</option>
                                      <option value="PASIVO">PASIVO</option>
                                      <option value="PATRIMONIO Y RESERVAS">PATRIMONIO Y RESERVAS</option>
                                      <option value="CUENTAS DE RESULTADO DEUDOR">CUENTAS DE RESULTADO DEUDOR </option>
                                     
                                      <option value="CUENTAS DE RESULTADO ACREEDOR" >CUENTAS DE RESULTADO ACREEDOR</option>
                                      <option value="CUENTAS LIQUIDADORAS" >CUENTAS LIQUIDADORAS</option>

                                      
                    </select><br>
                    <label style="top:-40px;font-size: 20px;color:#5264AE">Tipo</label>
                    </div>
                   <div class="form-group form-animate-text" style="margin-top:50px !important;"> 
                    
                    <select name="saldo" class="form-text" id="saldo" disabled="true" style="width: 50%;color:#5264AE">
                      <option value="SELECCIONE">SELECCIONE</option>
                      <option value="Deudor">Deudor</option>
                      <option value="Acreedor">Acreedor</option>
                     </select>
                    <label style="top:-40px;font-size:20px;color:#5264AE">Saldo</label>
                      </div>
                   
                    

                    

                    <div class="text-center">
                                    <button type="button" class="btn ripple-infinite btn-round btn-info" data-dismiss="modal">Cerrar</button>                            
                                   
                                    <button type="button" id="guardar" class="btn ripple-infinite btn-round btn-success" name="guardar"  <?php if($_SESSION["onModificar"]=="consultar"){ ?>  disabled="true" <?php  } ?> onclick="onEditar()">Actualizar Datos</button>
                                </div><br> 
<?php  
	break;

  case 'subcuenta':
	



?>

            <div class="form__label" style="font-size: 19px !important;"><label>Datos CuentaPadre</label></div><br>
 
                    <?php 
                    include "config/conexion.php";
                    $consulta="SELECT * FROM catalogo where codigocuenta=$codigo";
                    $result=$conexion->query($consulta);
                    $tipo="";
                    $saldo="";
                    if($result){
                      while($fila=$result->fetch_object()){
                        $tipo=$fila->tipo;
                        $saldo=$fila->saldo;
                        $nivelp=$fila->nivel;
                      }
                    }
                     ?>
                     <script type="text/javascript">
        cargaSelect('<?php echo $tipo; ?>','<?php  echo $saldo;?>');
      </script>
     <label class="form__label" style="top: 5%;">Codigo</label>
                                        <input type="text"  class="form__field" name="codigo" id="codigo" disabled="true" style="width: 70%;" value="<?php echo($codigo); ?>" onkeyup="generaNivel('padre')">

                                        <label class="form__label" style="top: 5%">Nivel</label>
                    <input type="text" name="nivelaux" id="nivelaux" class="form__field"  disabled="true" style="width: 25%;padding-left:50px;" value="<?php echo($nivel); ?>" >
                                       
                    
                     <div class="form-group form-animate-text" style="margin-top:50px !important;">
                    <select name="tipo" id="tipo" class="form-text"  disabled="true" style="width: 98%;color:#526470;">
                     <option value="SELECCIONE"   >SELECCIONE</option>
                                      <option value="ACTIVO" >ACTIVO</option>
                                      <option value="PASIVO">PASIVO</option>
                                      <option value="PATRIMONIO Y RESERVAS">PATRIMONIO Y RESERVAS</option>
                                      <option value="CUENTAS DE RESULTADO DEUDOR">CUENTAS DE RESULTADO DEUDOR </option>
                                     
                                      <option value="CUENTAS DE RESULTADO ACREEDOR" >CUENTAS DE RESULTADO ACREEDOR</option>
                                      <option value="CUENTAS LIQUIDADORAS" >CUENTAS LIQUIDADORAS</option>

                                      
                    </select>
                    <label style="top:-40px;font-size: 20px;color:#5264AE">Tipo</label>
                    </div>
                   <label class="form__label" style="top: 34%;font-size: 19px!important;float: center !important;">Datos SubCuenta</label>
                     <label class="form__label" style="top: 39%;">Correlativo subCuenta</label>
                                        <input type="text"  class="form__field" name="subcodigo" id="subcodigo" style="width: 70%;" value=""  onkeyup="generaNivel('hija')">
                    <label class="form__label"  style="top: 39%">Nivel</label>
                    <input type="text" name="nivel" class="form__field"  disabled="true" style="width: 25%;" value="" id="nivel">

                    
                    <label style="padding-left: 2px !important;">Nombre</label>
                    <input type="text" name="nombr" class="form__field" style="width: 99%;"  id="nombr">
                    
                    
<div class="form-group form-animate-text" style="margin-top:50px !important;"> 
                    
                    <select name="saldo" class="form-text" id="saldo"  style="width: 50%;color:#5264AE">
                      <option value="SELECCIONE">SELECCIONE</option>
                      <option value="Deudor">Deudor</option>
                      <option value="Acreedor">Acreedor</option>
                     </select>
                    <label style="top:-40px;font-size:20px;color:#5264AE">Saldo</label>
                      </div>

                    <div class="text-center">
                                    <button type="button" class="btn ripple-infinite btn-round btn-info" data-dismiss="modal">Cerrar</button>                            
                                    <button  type="button" id="guardar" name="guardar" class="btn ripple-infinite btn-round btn-success" onclick="onPreparaSubCuenta();">Guardar</button>

                                </div>



           <?php
            break;
           }
   }
   function agre(){


    ?>




  <?php } ?>
