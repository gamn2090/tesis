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
	<title>ANTECEDENTES DE LA DECISION</title>
	<link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/font.css">
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
        <h1 id="nombre" class="header center blue-text text-darken-1">ANTECEDENTES</h1>
        <div class="row center">          
        </div>        
        <br><br>
      </div>
    </div>
    <div  class="parallax"><img id="imagen" src="../img/Udo.jpg" alt="Unsplashed background img 1"></div>
  </div>   
  <br><br>
	<div class="container">
		<div id="evaluar" class="content">
			<?php
            $razon=$_POST['razon'];   //=     
            $promedio=$_POST['promedio']; //=       
            $solicitudes=$_POST['soli_ant']; //=
            $solicitud_actual=$_POST['solicitud']; //=
            $aval=$_POST['aval']; //=       
            $tiempo_sol=$_POST['fecha'];  //=
            $medidas=$_POST['medidas']; //=
            $observaciones=$_POST['observaciones'];
          ?>
          <table id="mytable" class="display" style="text-align:center" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>cedula</th>
                    <th>solicitud actual</th>
                    <th>fecha de solicitud</th>
                    <th>razon</th>  
                    <th>resultado</th>   
                    <th>Accion</th>            
                </tr>
            </thead>        
            <tfoot>
                <tr>
                    <th>cedula</th>
                    <th>solicitud actual</th>
                    <th>fecha de solicitud</th>
                    <th>razon</th>  
                    <th>resultado</th>   
                    <th>Accion</th>              
                </tr>
            </tfoot>
        </table>  
		
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
  <script>
    
      var razon = "<?php echo $razon ?>";
      var promedio = "<?php echo $promedio ?>";
      var solicitudes = "<?php echo $solicitudes ?>";
      var solicitud_actual = "<?php echo $solicitud_actual ?>";
      var aval = "<?php echo $aval ?>";
      var tiempo_sol = "<?php echo $tiempo_sol ?>";
      var medidas = "<?php echo $medidas ?>";

      $(document).ready(function(){      
          var datatable = $('#mytable').DataTable({                       
                          "ajax": {
                              "url": "../procesos/motor_funciones.php",
                              "type": "POST",
                              "data" : {
                                        "accion" : "mostrar_valores_iguales", //nombre que recibe el switch  
                                        "razon"  : razon,
                                        "promedio" : promedio,
                                        "soli_ant" : solicitudes,
                                        "solicitud" : solicitud_actual,
                                        "aval" : aval,
                                        "fecha" : tiempo_sol,
                                        "medidas" : medidas
                                      }
                                      
                         },
                         "language": {
                                       "processing": "No hay antecedentes que concuerden con esta decisión",
                                       "loadingRecords": " "                                     
                                    },
                          "sAjaxDataProp": "",
                          "processing": true,
                           columns: 
                           [
                              {data:"cedula"},
                              {data:"solicitud"},                            
                              {data:"fecha"},
                              {data:"razon"},
                              {data:"resultado"},
                              {data:"link"}                        
                            ]    
                               
                      }); 
      });
      </script>


  </body>
</html>