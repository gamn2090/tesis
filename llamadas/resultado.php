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
	<title>Muestra de datos del estudiante</title>
	<link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/font.css">
    <script type="text/javascript" src="../jquery/probandini.js"></script>
    <script type="text/javascript" src="jquery/jquery-2.1.1.js"></script>
 <?php
	include ("../procesos/funciones.php");
	include ("../config.php");
?>
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
          </ul>
      </ul>
      <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu">menu</i></a>
    </div>
  </nav>
  
  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 id="nombre" class="header center blue-text text-darken-1">DECISIONES</h1>
        <div class="row center">          
        </div>        
        <br><br>
      </div>
    </div>
    <div  class="parallax"><img id="imagen" src="../img/decision.jpg" alt="Unsplashed background img 1"></div>
  </div>   
  <br><br>
	<div class="container">
		<div id="evaluar" class="content">
			<?php
        if((isset($_GET['mensaje']) && $_GET['mensaje']==0) || (isset($_GET['mensaje']) && $_GET['mensaje']==3) )
        {
          ?>    
                <script>
                    function myFunction() {
                        alert("Resultado guardado en el historico exitosamente");
                        window.close();
                    }
                </script>
          <?php
        }
        else
        {
          if((isset($_GET['mensaje']) && $_GET['mensaje']==1) || (isset($_GET['mensaje']) && $_GET['mensaje']==4))
          {
            ?>    
                  <script>
                      function myFunction() {
                          alert("Resultado no guardado en el historico exitosamente");
                          window.close();
                      }
                  </script>
            <?php
          }
          else
          {     
            if(isset($_POST['Nombre']))
            { 
              $nombre=$_POST['Nombre'];
              $apellido=$_POST['Apellido'];
              $cedula=$_POST['cedula'];
              $discapacidad=$_POST['discapacidad'];
              $razon=$_POST['razon'];         
              $promedio=$_POST['Promedio'];
              $nacionalidad=$_POST['nacionalidad'];
              $solicitudes=$_POST['solicitudes'];
              $solicitud_actual=$_POST['Sol_actual'];
              $aval=$_POST['aval'];
              $cant_soli=$_POST['cant_soli'];
              $fecha=$_POST['fecha']; 
              $anio=$_POST['anio'];     
            }
            $periodo=tiempo_solicitud_retiro($anio,$fecha,$conn);
            $resultado=DECISION($fecha,$cedula,$razon,$nombre,$apellido,$discapacidad,$promedio,$solicitudes,$solicitud_actual,$aval,$cant_soli,$periodo,$conn);
            
            }
        }
      ?>
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
  <script src="../js/materialize.js"></script>
  <script src="../js/init.js"></script>



  </body>
</html>