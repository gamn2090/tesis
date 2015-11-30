<?php 
	
 	include('../config.php');
 	include('funciones.php');	
    if(isset($_POST['accion'])){ $accion=$_POST['accion']; 
    switch ($accion){ 		
		case 'Guardar':/*ingresa una nueva solicitud*/	  	
			//var_dump($conn);
		  	if(isset($_POST['cedula'])  
			&& isset($_POST['proceso']) 
			&& isset($_POST['razon'])) {
			$cedula=$_POST['cedula'];
			$proceso=$_POST['proceso'];
			$razon=$_POST['razon'];
			
	  		Ingresar_solicitud($cedula, $razon, $proceso, $conn);
			}		
		break; 		
 		case 'Ingresar':/*insertar nuevas relaciones procesos/razones*/
		//echo "holis";
		//var_dump($conn);
			if(isset($_POST['Proceso'])  
			&& isset($_POST['Razon']) 
			&& isset($_POST['Puntaje'])
			&& isset($_POST['Porcentaje'])) {
			$proceso=$_POST['Proceso'];
			$razon=$_POST['Razon'];
			$puntaje=$_POST['Puntaje'];
			$porcentaje=$_POST['Porcentaje'];			
			/*echo $porcentaje, $puntaje,$razon,$proceso;*/			
 			ingresar_procesos($proceso, $razon, $puntaje, $porcentaje,$conn);
			}			
 		break; 		
 		case 'Entrar':/*login estudiante*/
 		 	if(isset($_POST['cedula'])  
			&& isset($_POST['contraseña']))
			{
				session_start();
				$cedula = $_POST['cedula'];
				$contraseña = $_POST['contraseña'];
			//var_dump($conn2); 						
			loguear($cedula,$contraseña,$conn2);			
			}			
		break;
 		case 'Accesar':/*loguear en la coordinación*/
 		 	if(isset($_POST['usuario'])  
			&& isset($_POST['contraseña']))
			{	
				$usuario = $_POST['usuario'];
				$contraseña = $_POST['contraseña'];
				

			//var_dump($conn); 						
			loguear_coord($usuario,$contraseña,$conn);			
			}			
 		break; 		
 		case 'Evaluar Bachiller': /*evaluar bachiller*/
 		 	mostrar($cedula,$nombre,$apellido,$email,$celular,$direccion,$promedio,$discapacidad,$nacionalidad,$solicitudes2,$proceso);
 		break; 
				
 			
 	}
 }//fin isset[$_post[accion]]

?>