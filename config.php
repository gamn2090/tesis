<?php
	include('adodb5/adodb.inc.php');
	$conn = ADONewConnection('postgres'); 
	$conn->PConnect('host=localhost port=5432 dbname=Tesis user=postgres password=gamn2090');
if (!$conn) {
echo "Error en la conexion.\n";
}
$conn2 = ADONewConnection('postgres'); 
	$conn2->PConnect('host=localhost port=5432 dbname=Control_de_estudios user=postgres password=gamn2090');
if (!$conn2) {
echo "Error en la conexion.\n";
}
?>