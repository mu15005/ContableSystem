<?php
$var="helicoptero";
$conexion = new mysqli('localhost', 'root', 'root', 'contablesystem');
if ($conexion->connect_errno) {

    echo "error en la conexion a la base de datos";
} else {
    // echo "Conectado";
}
?>