<?php
	include ("../procesos/funciones.php");
	include ("../config.php");

											
					$cedula=$_POST['cedula'];					
					$razon=$_POST['razon'];					
					$promedio=$_POST['promedio'];					
					$solicitudes=$_POST['soli_ant'];
					$solicitud_actual=$_POST['solicitud'];
					$aval=$_POST['aval'];					
					$fecha=$_POST['fecha'];	
					$medidas=$_POST['medidas'];	
					$decision=$_POST['decision'];
					$decision2=$_POST['decision2'];
					$fecha_solicitud=$_POST['fecha_solicitud'];	
					$acuerdo=$_POST['acuerdo'];
					$observaciones=$_POST['observaciones'];	
				
				
				if($decision=="Indefinida")
				{
				$mensaje=ingresar_historico($cedula,$fecha_solicitud,$razon,$promedio,$solicitudes,$solicitud_actual,$aval,$fecha,$medidas,$decision2,$observaciones,$acuerdo,$conn);
				}
				else
				{					
					$mensaje=ingresar_historico($cedula,$fecha_solicitud,$razon,$promedio,$solicitudes,$solicitud_actual,$aval,$fecha,$medidas,$decision,$observaciones,$acuerdo,$conn);
				}
				
				header("location: resultado.php?mensaje=$mensaje");
				
				
?>