<?php
session_start();
      $usuario=$_SESSION['usuario'];
      $nivel=$_SESSION['nivel'];  
      $bandera=$_SESSION['bandera'];  
if($usuario!= NULL)
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Coordinación Académica</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/font.css">

  <?php
  include ("procesos/funciones.php");
  include ("config.php");
  ?>
</head>
<body onload="myFunction()">

  <?php
  if(isset($_GET['mensaje']) && $_GET['mensaje']==1)
  { 
  ?>    
        <script>
            function myFunction() {
                alert("Cuenta creada exitosamente");
            }
        </script>
  <?php
  }
  else
  { 
    if(isset($_GET['mensaje']) && $_GET['mensaje']==0)
    {
    ?>          
          <script>
              function myFunction() {
                  alert("Cuenta no creada");
              }
          </script>      
    <?php
    }
    else
    { 
      if(isset($_GET['mensaje']) && $_GET['mensaje']==2)
      {
      ?>          
            <script>
                function myFunction() {
                    alert("Razon no ingresada");
                }
            </script>      
      <?php
      }
      else
      {
        if(isset($_GET['mensaje']) && $_GET['mensaje']==3)
        {
        ?>          
              <script>
                  function myFunction() {
                      alert("Razón ingresada correctamente");
                  }
              </script>      
        <?php
        }
      }
    }
  }
  ?>
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="coordinacion_principal.php" class="brand-logo"><img src="img/udo.gif" alt=""></a>
      <ul class="right hide-on-med-and-down">
            <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Menu<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
          <ul id='dropdown1' class='dropdown-content'>
            <li><a href="coordinacion_principal.php">Inicio</a></li>
            <li><a href="llamadas/procesos.php">Procesos</a></li>
            <?php
            if($nivel==$bandera)
            {   
            ?>
            <li><a href="llamadas/mantenimiento.php">Mantenimiento</a></li>
            <?php
            }
            ?>
            <li><a href="llamadas/cerrar_sesion.php">Cerrar sesion</a></li>
          </ul>
      </ul>
      <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu">menu</i></a>
    </div>
  </nav>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
       
        <h1 class="header center blue-text text-darken-1">Coordinación Académica</h1>
        <div class="row center">
          <h5 class="header col s12 light white-text text-darken-5">Sistema de Apoyo a la Toma de decisiciones de la Coordinación Académica de la Universidad de Oriente</h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="img/Udo.jpg" alt="Unsplashed background img 1"></div>
  </div>       
  <div class="col s12 m4 offset-m2 l6 offset-l3">                
        <div class="row valign-wrapper">
          <div class="col s12">
          </div>                   
        </div>                
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
      <!--   Icon Section   -->
    <?php
    if($nivel==$bandera)
    {   
    ?>    
      <div class="row">
         

        <div class="col s12 m3">
          <div class="icon-block">
                         
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.4";
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));</script> 
              <div class="fb-page" data-href="https://www.facebook.com/pagina.cacns" data-small-header="false"      data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div></div>                 
            </div>             
        </div> 

        <div class="col s12 m3">
          <div class="icon-block">
            <div class="col s12 m4 offset-m2 l6 offset-l3">                
                  <div class="row valign-wrapper">
                    <div class="col s12">
                       <a href="llamadas/procesos.php"><img src="img/reingreso.png" alt="" class="circle responsive-img"></a> <!-- notice the "circle" class -->
                    </div>                   
                  </div>                
            </div>   
            <h5 class="center">Procesos</h5>

            <p class="light">Visualice y evalue las solicitudes de los procesos de retiro, reingreso y cambio de especialidad que los estudiantes ingresan mediante el portal de siceudo.</p>
          </div>
        </div>           
       

        <div class="col s12 m3">
          <div class="icon-block">
             <div class="col s12 m4 offset-m2 l6 offset-l3">                
                  <div class="row valign-wrapper">
                    <div class="col s12">
                      <a href="llamadas/mantenimiento.php"><img src="img/mant.jpg" alt="" class="circle responsive-img"></a> <!-- notice the "circle" class -->
                    </div>                   
                  </div>                
            </div> 
            <h5 class="center">Mantenimiento</h5>

            <p class="light">Le permite crear una nueva cuenta de usuario, agregar una nueva razón al tomador de decisiones y cambiar los valores de las razones del tomador de decisiones.</p>
          </div>
        </div>

        <div class="col s12 m3">
          <div class="icon-block">
             <a class="twitter-timeline"  href="https://twitter.com/cacns_udo_sucre" data-widget-id="667340026104164352">Tweets by @cacns_udo_sucre</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            
          </div>
        </div> 
      <?php
        }
        else
        {
        ?> 
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
                         
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.4";
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));</script> 
              <div class="fb-page" data-href="https://www.facebook.com/pagina.cacns" data-small-header="false"      data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div></div>                 
            </div>             
        </div> 

        
        <div class="col s12 m4">
          <div class="icon-block">
            <div class="col s12 m6 offset-m6 l6 offset-l3">                
                  <div class="row valign-wrapper">
                    <div class="col s12">
                       <a href="llamadas/procesos.php"><img src="img/reingreso.png" alt="" class="circle responsive-img"></a> <!-- notice the "circle" class -->
                    </div>                   
                  </div>                
            </div>   
            <h5 class="center">Procesos</h5>

            <p class="light">Visualice y evalue las solicitudes de los procesos de retiro, reingreso y cambio de especialidad que los estudiantes ingresan mediante el portal de siceudo.</p>
          </div>
        </div>  

        <div class="col s12 m4">
          <div class="icon-block">
             <a class="twitter-timeline"  href="https://twitter.com/cacns_udo_sucre" data-widget-id="667340026104164352">Tweets by @cacns_udo_sucre</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            
          </div>
        </div>
      </div>
        <?php
        }
        ?>       
      </div>

    </div>
  </div>  

   <div class="slider">
    <ul class="slides">
      <li>
        <img src="img/udosucre.png"> <!-- random image -->
        <div class="caption right-align">
          <h3 class="black-text text-lighten-3">Universidad de Oriente</h3>
          <h5 class="white-text text-lighten-3">Excelencia académica</h5>
        </div>
      </li>
      <li>
        <img src="img/udo_1.jpg"> <!-- random image -->
        <div class="caption left-align">
          <h3>Orgullosos</h3>
          <h5 class="black-text text-lighten-3">Creando nuevos profesionales</h5>
        </div>
      </li>
      <li>
        <img src="img/Udistas.jpg"> <!-- random image -->
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
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>
</html>
<?php
}else
{header("location: index.php");}
?>
