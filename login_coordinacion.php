<?php
session_start();
			$usuario=$_SESSION['usuario'];
			$nivel=$_SESSION['nivel'];	
			$bandera=$_SESSION['bandera'];	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Coordinación Académica</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/font.css">
		<link rel="stylesheet" href="css/para_el_index.css">

   
    <script type="text/javascript" src="jquery/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="jquery/probandini.js"></script>
    
    
<?php
	include ("procesos/funciones.php");
	include ("config.php");
	
	
?>
</head>
<body>

	<header class="header">
		
			<img src="img/logoHeader.png" alt="">
            <!-- aqui irá el saludo a los licenciados -->
            
			
		
	</header>
	
	<div class="centrar">	
		<div id="principal" class="content">		
		<form id="login" action="procesos/motor_funciones.php" method="POST">
		<table align="center">
		        <tr> 
		          <br>          
		          <tr> <td align="right" class="negro">Usuario:  </td> <td> <input id="usuario" name="usuario" title="Ingrese Usuario"> </td></tr>
		          <tr> <td align="right" class="negro">Contraseña:  </td> <td> <input id="contraseña" type="password" name="contraseña"   title="Ingrese contraseña"> </td></tr> <tr>
		           <td> </td>         
		           <?php
		           if(isset ($_GET['id']) && $_GET['id']== 1){
				echo "<tr><td colspan='2' align= 'center'>El login de Usuario o la Clave Insertada Es Incorrecta! </td></tr>";// el '<tr><td es para abrir una fila'
				
				}?>
		           <td colspan="2" align="center"> <input id="login" type="submit" value="Accesar" name="accion" title=" login"></td> </tr>                   
		        
		      </table>
		      <br>
		</form>
		</div>
	</div>
	


</body>
</html>
