<?php
  session_start();
      $usuario=$_SESSION['usuario'];
      $nivel=$_SESSION['nivel'];  
      $bandera=$_SESSION['bandera'];  
  include ("../procesos/funciones.php");
  include ("../config.php");
  
if($usuario!= NULL)
{
		//echo $_GET['mensaje'];
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>

  <title>Coordinación Académica</title>

  <!-- CSS  -->
  <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/font.css">
</head>
<body onload="myFunction()">

  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="../coordinacion_principal.php" class="brand-logo"><img src="../img/udo.gif" alt=""></a>
      <ul class="right hide-on-med-and-down">
            <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Menu<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
          <ul id='dropdown1' class='dropdown-content'>
            <li><a href="../coordinacion_principal.php">Inicio</a></li>
            <li><a href="procesos.php">Procesos</a></li>
             <?php
            if($nivel==$bandera)
            {   
            ?>
            <li><a href="mantenimiento.php">Mantenimiento</a></li>
            <?php
            }
            ?>
            <li><a href="cerrar_sesion.php">Cerrar sesion</a></li>
          </ul>
      </ul>
      <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu">menu</i></a>
    </div>
  </nav>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 id="nombre" class="header center blue-text text-darken-1">HISTORICO DE DECISIONES</h1>
        <div class="row center">          
        </div>        
        <br><br>
      </div>
    </div>
    <div  class="parallax"><img id="imagen" src="../img/historico.jpg" alt="Unsplashed background img 1"></div>
  </div>
  <div class="col m3 offset-m9">    
        <div class="user_container" id="user"><i class=" icon-user-check"></i>
          <span id="userName">        
            <?php     
              cargar_datos_coord($usuario,$conn);
            ?>
          </spam>
        </div>   
  </div>  
  <br><br>
  <div class="container">
    <div class="section">

   
             
        <div id="main" class="col s12">   
        <?php
			if(isset($_GET['mensaje']) && $_GET['mensaje']>0)
			 {
			  ?>          
					<script>
						function myFunction() {
							alert(<?php echo $_GET['mensaje']; ?> " solicitudes incertadas");
						}
					</script>      
			  <?php
			  }
			  else
			  {
				if(isset($_GET['mensaje']) && $_GET['mensaje']=0)
				{
				?>
					<script>
						function myFunction() {
							alert("no hay nuevas solicitudes");
						}
					</script> 
				  <?php	
				}  
			  }
		?>      		
                <form id="cargar_procesos" class="col s12" action="../procesos/motor_funciones.php" method="POST">
   	
					        
					        <div class="row">
					        <div class="input-field col s6 offset-s3">
						    <select id="proceso" name="proceso">
						      <option value="" disabled selected>Proceso a cargar</option>
						      <option value="Retiro">Retiro académico</option>
						      <option value="Reingreso">Reingreso académico</option>
                              <option value="Cambio">Cambio de especialidad</option>
						    </select>
						    </div>
						   	</div>
                            <div class="divider"></div>
		                    <div class="row">                       
		                        <div class="col m12 offset">
		                            <p class="center-align">
		                                <button class="btn btn-large waves-effect waves-light" id="cargar" type="submit" value="cargar" name="accion" title="login">Cargar Procesos</button>
		                            </p>
		                        </div>
		                    </div>
					</form>	
                
        </div>
     
    </div> 
   </div> 

 <div class="slider">
    <ul class="slides">
      <li>
        <img src="../img/udosucre.png"> <!-- random image -->
        <div class="caption right-align">
          <h3 class="black-text text-lighten-3">Universidad de Oriente</h3>
          <h5 class="white-text text-lighten-3">Excelencia académica</h5>
        </div>
      </li>
      <li>
        <img src="../img/udo_1.jpg"> <!-- random image -->
        <div class="caption left-align">
          <h3>Orgullosos</h3>
          <h5 class="black-text text-lighten-3">Creando nuevos profesionales</h5>
        </div>
      </li>
      <li>
        <img src="../img/Udistas.jpg"> <!-- random image -->
        <div class="caption center-align ">         
          <h3 class="black-text text-lighten-3">UDO por siempre</h3>
        </div>
      </li>
    </ul>
  </div>

  <footer class="page-footer teal">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Company Bio</h5>
          <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Settings</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Connect</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Made by <a class="brown-text text-lighten-3" href="http://materializecss.com">Materialize</a>
      </div>
    </div>
  </footer>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>  
  <script src="../js/materialize.js"></script> 
  <script src="../js/init.js"></script>
  </body>
</html>
<?php
}else
{header("location: ../index.php");}
?>
