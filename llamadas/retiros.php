<?php
include('../config.php');
include('../procesos/funciones.php');
$proceso="Retiro";
session_start();
$nivel=$_SESSION['nivel'];
mostrar_proceso($proceso,$conn,$nivel,$conn2);
?>

	
					
				