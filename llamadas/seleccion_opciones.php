<?php
include('../config.php');
include('../procesos/funciones.php');	

$cedula=$_POST['cedula'];
$proceso=$_POST['proceso'];
$fecha=$_POST['fecha'];
$razon=$_POST['razon'];
$bandera=Ingresar_retiro($cedula, $razon, $proceso,$fecha,$conn);
$cedula2=base64_encode($cedula);
header("location: pantalla_retiro.php?cedula=$cedula2&bandera=$bandera");
?>
