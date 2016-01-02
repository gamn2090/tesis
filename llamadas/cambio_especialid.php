<?php
include('../config.php');
include('../procesos/funciones.php');

$proceso="Cambio de Especialidad";
session_start();
$nivel=$_SESSION['nivel'];
$bandera=$_SESSION['bandera'];  
if($_GET['page']!= NULL)
{	
	$page=$_GET['page'];
	$offset=($page-1)*3;
}
else
{
	$offset=0;
}
if($nivel==$bandera)
{
	mostrar_proceso_coord($proceso,$conn,$conn2,$offset);
}
else
{
	mostrar_proceso_sec($proceso,$conn,$conn2,$offset);
}
?>
			