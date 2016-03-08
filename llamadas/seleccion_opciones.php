<?php
include('../config.php');
include('../procesos/funciones.php');	

$cedula=$_POST['cedula'];
$proceso=$_POST['proceso'];
$fecha=$_POST['fecha'];
$razon=$_POST['razon'];
if($proceso=='Reingreso' || $proceso=='Retiro')
{
	ingresar_solicitud($cedula,$proceso,$fecha,$razon,$periodo,$anio,$especialidad,$nucleo,$estatus,$asignatura,$conn);
	$cedula2=base64_encode($cedula);
	header("location: pantalla_retiro.php?cedula=$cedula2&bandera=$bandera");
}
else
{
		
}
?>
