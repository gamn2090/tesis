<?php
include('../config.php');
include('../procesos/funciones.php');
$proceso=$_POST['proceso'];
$puntaje=$_POST['puntaje'];
$fecha=$_POST['fecha'];
$razon=$_POST['razon'];
$bandera=actualizar_puntaje($proceso, $razon, $puntaje,$fecha,$conn);
header("location: cambio_valores.php?bandera=$bandera");
?>
