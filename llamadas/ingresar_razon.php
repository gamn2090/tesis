<?php
include('../config.php');
include('../procesos/funciones.php');
$proceso=$_POST['proceso'];
$puntaje=$_POST['puntaje'];
$ponderacion=$_POST['ponderacion'];
$razon=$_POST['razon'];
$fecha=fecha_hoy();
$funcion=ingresar_razon($proceso,$razon,$puntaje,$ponderacion,$fecha,$conn);
if($funcion==1){
		header("location: ../coordinacion_principal.php?mensaje=$funcion");
	}
	else
	{
		header("location: ../coordinacion_principal.php?mensaje=$funcion");
	}

?>