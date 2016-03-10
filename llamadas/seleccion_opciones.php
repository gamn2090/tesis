<?php
include('../config.php');
include('../procesos/funciones.php');	

				$cedula=$_POST['cedula'];
				$proceso=$_POST['solicitud'];
				$fecha=$_POST['fecha'];
				$razon=$_POST['razon'];
				$periodo=$_POST['periodo'];
				$anio=$_POST['anio'];
				$especialidad=$_POST['especialidad'];
				$nucleo=$_POST['nucleo'];
				$estatus=$_POST['estatus'];
				$asignatura=substr($_POST['asignatura'],0,6);
			    $bandera=ingresar_solicitud($cedula,$proceso,$fecha,$razon,$periodo,$anio,$especialidad,$nucleo,$estatus,$asignatura,$conn);
			    $cedula2=base64_encode($cedula);
				header("location: pantalla_retiro.php?cedula=$cedula2&bandera=$bandera");
/*$cedula=$_POST['cedula'];
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
		
}*/
?>
