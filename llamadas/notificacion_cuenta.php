<?php
include('../config.php');
include('../procesos/funciones.php');
$cedula=$_POST['cedula'];
$nombre=$_POST['Nombre'];
$apellido=$_POST['Apellido'];
$sexo=$_POST['sexo'];
$usuario=$_POST['usuario'];
$contraseña=$_POST['contraseña'];
$privilegios=$_POST['privilegios'];
$funcion=crear_cuenta($cedula,$nombre,$apellido,$sexo,$usuario,$contraseña,$privilegios,$conn);
if($funcion==1){
		header("location: ../coordinacion_principal.php?mensaje=$funcion");
	}
	else
	{
		header("location: ../coordinacion_principal.php?&mensaje=$funcion");
	}

?>
