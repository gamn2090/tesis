<?php
	session_start();
	$cedula=$_SESSION['estudiante_ced'];
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>SICEUDO Sucre | Estudiantes</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="keywords" content="siceudo">
<link rel="stylesheet" href="css/main.css">
<link rel="icon" type="image/x-icon" href="imagenes/logo.ico">
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<link href="css/estilos_simplemodal.css" rel="stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" media="all" href="include/jscalendar/calendar-blue.css" title="win2k-cold-1">
<script type="text/javascript" src="include/jquery/jquery.js"></script>
<script type="text/javascript" src="include/jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="include/jquery/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript" src="include/jscalendar/calendar.js"></script>
<script type="text/javascript" src="include/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="include/jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/js/AjaxRequest.js?v=70180"></script>
<script type="text/javascript" src="include/js/funciones.js?v=70180"></script>
<script type="text/javascript" src="include/js/funcionesComunes.js?v=70180"></script>
<script type="text/javascript" src="include/js/simplemodal.js?v=70180"></script>
<script type="text/javascript" src="planificacion/script/planificacion.js?v=70180"></script>
<script type="text/javascript" src="admision/script/inscripcion.js?v=70180"></script>
<script type="text/javascript" src="admision/script/scriptEstudiante.js?v=70180"></script>
<script type="text/javascript" src="admision/script/scriptInscripcionWeb.js?v=70180"></script>
<script type="text/javascript" src="admision/script/scriptInscripcionIntensivos.js?v=70180"></script>
<script type="text/javascript" src="admision/script/scriptPagosWeb.js?v=70180"></script>
<script type="text/javascript" src="reportes/script/reportes.js?v=70180"></script>
<script type="text/javascript" src="administracion/script/usuarios.js?v=70180"></script>
<script type="text/javascript" src="administracion/script/scriptEncuesta.js?v=70180"></script>
<script type="text/javascript" src="solicitudes/script/script_paralelo.js?v=70180"></script>
<script type="text/javascript" src="solicitudes/script/script_excesos.js?v=70180"></script>
<script type="text/javascript" src="solicitudes/script/script_medidas.js?v=70180"></script>
<script type="text/javascript" src="solicitudes/script/script_reclamos.js?v=70180"></script>
<script type="text/javascript" src="solicitudes/script/scriptDirigidos.js?v=70180"></script>
<script type="text/javascript" src="solicitudes/script/scriptCambioEsp.js?v=70180"></script> 
<script type="text/javascript" src="solicitudes/script/scriptTraslado.js?v=70180"></script> 
<script type="text/javascript" src="solicitudes/script/scriptReingPre.js?v=70180"></script> 
<script type="text/javascript" src="consultas/script/scriptConsultaPros.js?v=70180"></script>
<script language="javascript">
	var timer = 0;
	function set_interval() {
		timer = setInterval("auto_logout()",600000);
	}
	function reset_interval() {
		if (timer != 0) {
			clearInterval(timer);
			timer = 0;
			timer = setInterval("auto_logout()",600000);
		}
	}
	function auto_logout() {
		window.location = "logout.php";
	}
</script>
<?php
include ("procesos/funciones.php");
	include ("config.php");
?>
</head>
<body onLoad="set_interval()" onmousemove="reset_interval()" onclick="reset_interval()" onkeypress="reset_interval()" onscroll="reset_interval()">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr class="titulo">
		<td colspan="4" class="tBlanco">
        	<img src="img/logoHeader.png" alt=""></td>
        <td class="tBlanco" align="left">
        <img border="0" src="img/siceudo.png" style="cursor: pointer"></td>
	</tr>
    <tr bgcolor="#005082" class="tBlanco" height="18px">
    	<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;.: Bienvenidos :.</td>
        <td colspan="2">Sistema Integral de Control de Estudios de la Universidad de Oriente</td>
        <td>Miércoles, 07 de Octubre de 2015</td>
    </tr>
	<tr><td colspan="5"><h3></h3></td></tr>
	<tr>
		<td width="10%" valign="top" height="270"> <!-- Columna 1-->
			<h3>Menú Principal</h3>
			<div id="menuP">
	<div id="sidebar">
		<ul class="sidemenu">
			<li><a style="cursor: pointer" href="seleccion_proceso.php">Inicio</a></li>
			<li><a style="cursor: pointer" onClick="cambiar_cuerpo('pantalla_retiro.php', 'cuerpo')">Ingresar Retiro</a></li>
			<li><a style="cursor: pointer" onClick="cambiar_cuerpo('inicio.php', 'cuerpo')">Ingresar Reingreso</a></li>
			<li><a style="cursor: pointer" onClick="cambiar_cuerpo('inicio.php', 'cuerpo')">Ingresar Cambio de especialidad</a></li>
			<!--<li><a style="cursor: pointer" onclick="cambiar_cuerpo('web/administracion.php', 'cuerpo')">Administración</a></li>
			<li><a style="cursor: pointer" onclick="cambiar_cuerpo('web/pagina2.php', 'cuerpo')">Link 2</a></li>
			<li><a style="cursor: pointer" onclick="cambiar_cuerpo('web/pagina3.php', 'cuerpo')">Link 3</a></li>
			<li><a style="cursor: pointer" onclick="cambiar_cuerpo('web/pagina4.php', 'cuerpo')">Link 4</a></li>-->
		</ul>
	</div>
</div>			<br>
		</td>
		<td rowspan="3" width="25px">&nbsp;&nbsp;&nbsp;</td>
		<td rowspan="3" width="750px" height="430" valign="top" id="cuerpo"> <!-- Columna 2-->
			<h3>&nbsp;</h3>
<?php
if(isset($_GET['bandera']) && ($GET_['bandera']==0))
{
?>
<div >		
        Solicitud realizada con éxito <br/>
        <br/>			
</div>
<?php	
}
else
{
	if(isset($_GET['bandera']) && ($GET_['bandera']==1))
	{
	?>
    <div >		
            Imposible procesar esta solicitud<br/>
            <br/>			
    </div>
    <?php	
	}
	else
	{	
		
		$solicitud='Retiro';		
		date_default_timezone_set("America/Caracas" ) ; 
		$tiempo = getdate(time()); 
		$dia = $tiempo['wday']; 
		$dia_mes=$tiempo['mday']; 
		$mes = $tiempo['mon']; 
		$year = $tiempo['year']; 
		$fecha=$dia_mes."-".$mes."-".$year;
		
		mostrar_datos_para_solicitud($solicitud,$cedula,$fecha,$conn);
	}
}
?>

<br>
<p align="center" style="color:#06C; font-size:12px"><strong>Pasos a seguir en el proceso de inscripción</strong></p>
<br>
<table bgcolor="#FAFAFA" style="border: 1px solid #EAEAEA;" align="center" width="100%" border="0" cellpadding="2" cellspacing="2">
	<tbody><tr>
    	<td align="center"><div class="caja1"><strong>(1)</strong><br><br>INICIA TU SESIÓN</div></td>
        <td align="center"><div class="caja3"><strong>(2)</strong><br><br>REGISTRA TU INSCRIPCIÓN</div></td>
        <td align="center"><div class="caja4"><strong>(3)</strong><br><br>IMPRIME TU CONSTANCIA</div></td>
        <td align="center"><div class="caja5"><strong>(4)</strong><br><br>CIERRA TU SESIÓN</div></td>
    </tr>
</tbody></table>
<br><h3>Actualización de Datos</h3>
<marquee width="100%" height="15" direction="left" behavior="scroll" onMouseOver="this.setAttribute('scrollamount', 0, 0);" onMouseOut="this.setAttribute('scrollamount', 1, 0);" truespeed scrolldelay="15" scrollamount="1" loop="infinite" style="height: 15px; width: 100%;">
<font><strong style="color: #F00">ATENCIÓN :</strong> <strong style="color: #036">Horarios <a href="https://drive.google.com/folderview?id=0B48mKGutmyhtTVItVExKd1otUUE&amp;usp=sharing" target="_blank"> 2-2015...! </a></strong></font>
</marquee>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td width="75"><img src="imagenes/information.png" border="0" width="55" height="55"></td>
        <td><p align="justify" style="line-height : 20px;">Para realizar cualquier solicitud, debes tener tus datos actualizados. 
          <strong><!--<a href="http://inscripciones.sucre.udo.edu.ve" target="_blank">--><!--<h2>inscripciones.sucre.udo.edu.ve</h2>--><!--</a>--></strong><br>
		  Puedes hacerlo aqui en la opción<strong> Actualizar Datos</strong>.</p>
		  <!--<p>Fecha de Inscripciones:<strong> Sábado 18 y Domingo 19 de Enero de 2014</strong></p>-->
         <br>
	</td></tr>
</tbody></table>
<h3>¡Recuerda que tu contraseña es personal!</h3>
<p align="justify" style="line-height : 20px;"><strong><font>¡No compartas tu contraseña! ¡Create un contraseña segura! ¡No coloques como contraseña tu número de cédula! Recuerda que esta contraseña es única para todos los procesos llevados a cabo por DACENS.</font></strong></p>
<br>
<br>
<h3>¿Conoces las Normas de Permanencia?</h3>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td>Entérate cuándo pueden afectarte. Revísalas <a href="descargas/manuales/NormasPermanencia.pdf" target="_blank">aquí</a></td>
	</tr>
	<tr><td height="20"></td></tr><tr>
</tr></tbody></table>
<h3>Lo que debes saber sobre las Normas de Repitencia</h3>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td>Entérate cuándo pueden afectarte. Revísalas <a href="descargas/manuales/NormasRepitencia.pdf" target="_blank">aquí</a></td>
	</tr>
	<tr><td height="20"></td></tr><tr>
</tr></tbody></table>
<h3>Punto de contacto</h3>
<p align="left" style="line-height : 20px;">Cualquier consulta, inquietud, opinión, reclamo, o crítica constructiva, escríbenos al correo:
<span style="font-size:14px; color: #D00;"><strong>dacens@udo.edu.ve</strong></span></p>
<br>		</td>
		<td rowspan="3" width="25px">&nbsp;&nbsp;&nbsp;</td>
		<td width="15%" valign="top" height="270"> <!-- Columna 3-->
			<h3>Calendario Académico</h3>
			<p class="text_content" align="justify" style="line-height : 20px;">
<marquee width="300" height="200" direction="up" behavior="scroll" onMouseOver="this.setAttribute('scrollamount', 0, 0);" onMouseOut="this.setAttribute('scrollamount', 1, 0);" truespeed scrolldelay="50" scrollamount="1" loop="infinite" style="height: 200px; width: 300px;">
<strong><font color="#0066CC">PUBLICACIÓN CITAS DE INSCRIPCIÓN</font><br>LUNES 05 DE OCTUBRE</strong>
<br><br>
<strong><font color="#0066CC">INSCRIPCION REGULARES 2015-2</font><br>MIÉRCOLES 07, JUEVES 08 Y VIERNES 09 DE OCTUBRE</strong>
<br><br>
<strong><font color="#0066CC">INICIO DE ACTIVIDADES DOCENTES</font><br>MARTES 13 DE OCTUBRE</strong>
<br><br>
<strong><font color="#0066CC">FINALIZACIÓN DE ACTIVIDADES DOCENTES</font><br>VIERNES 26 DE FEBRERO 2016</strong>

<!--<BR><BR>
<strong><font color="#0066CC">AJUSTE DE INSCRIPCIÓN</font><BR>DEL 20/01/2014 AL 24/01/2014</strong>-->
<!--<BR><BR>
<strong><font color="#0066CC">RETIRO DE ASIGNATURAS</font><BR>DEL 22/04/2013 AL 31/05/2013</strong>
<BR><BR>
<strong><font color="#0066CC">SOLICITUDES DE CURSOS PARALELO</font><BR>DEL 22/04/2013 AL 03/05/2013</strong>
<BR><BR>
<strong><font color="#0066CC">PERMISOS PARA CARGA DE EXCEPCIÓN</font><BR>DEL 22/04/2013 AL 03/05/2013</strong>
<BR><BR>
<strong><font color="#0066CC">SOLICITUDES DE REINGRESO</font><BR>DEL 22/04/2013 AL 19/07/2013</strong>
<BR><BR>
<strong><font color="#0066CC">SOLICITUDES DE TRASLADO</font><BR>DEL 22/04/2013 AL 19/07/2013</strong>
<BR><BR>
<strong><font color="#0066CC">SOLICITUDES DE CAMBIO DE ESPECIALIDAD</font><BR>DEL 22/04/2013 AL 19/07/2013</strong>
<BR><BR>
<strong><font color="#0066CC">FINALIZACIÓN DE ACTIVIDADES DOCENTES</font><BR>VIERNES 04 DE OCTUBRE DE 2013</strong>
<BR><BR>
<strong><font color="#0066CC">PROCESAMIENTO DE ACTAS</font><BR>DEL 07/10/2013 AL 11/10/2013</strong>
<BR><BR>
<strong><font color="#0066CC">DÍAS FERIADOS</font>
<BR>DÍA DEL TRABAJADOR: 01/05/2013
<BR>BATALLA DE CARABOBO: 24/06/2013 
<BR>DÍA DE LA INDEPENDENCIA: 05/07/2013 
<BR>NATALICIO DE SIMÓN BOLÍVAR: 24/07/2013 
</strong>
-->
</marquee>
</p>			<br>
		</td>
	  </tr><tr>
			<td valign="top" height="210">
				<h3>Iniciar Sesión</h3>
				<div id="identificacion">
	<form id="login" action="procesos/motor_funciones.php" method="POST">
<table align="center">
        <tr> 
          <br>          
          <tr> <td align="right" class="negro">Cédula:  </td> <td> <input id="cedula" name="cedula" title="Ingrese Cedula"> </td></tr>
          <tr> <td align="right" class="negro">Contraseña:  </td> <td> <input id="contraseña" type="password" name="contraseña"   title="Ingrese contraseña"> </td></tr> <tr>
           <td></td>
           <?php
           if(isset ($_GET['id']) && $_GET['id']== 1){
		echo "<tr><td colspan='2' align= 'center'>El login de Usuario o la Clave Insertada Es Incorrecta! </td></tr>";// el '<tr><td es para abrir una fila'
		
		}?>
            <td colspan="2" align="center"> <input id="login" type="submit" value="Entrar" name="accion" title=" login"></td> </tr>                   
        
      </table>
      <br>
</form>
    <br>
	<div align="center"><a onClick="enviarClave()" style="cursor:pointer">¿Olvidó su contraseña?</a></div>
</div>			                 			</td>
			<td valign="top" style="line-height: 20px;">
				<h3>Descargas</h3>
				<div id="descargas">
»&nbsp;<a href="https://docs.google.com/a/udo.edu.ve/open?id=0B38OwCJVpDCRRHplbFcwTEZ3LTQ" target="_blank">Planilla para Ajustar Lista de  Clases</a><br>
»&nbsp;<a href="https://drive.google.com/file/d/0B7B3X0luJx7RTG1xRHlaV2p5OFU/view?usp=sharing" target="_blank">Solicitud de Grado</a><br>
»&nbsp;<a href="https://drive.google.com/file/d/0B7B3X0luJx7RTDFoTUFZSnJjV1k/view?usp=sharing" target="_blank">Solvencia Administrativa</a><br>
»&nbsp;<a href="http://estudiantes.sucre.udo.edu.ve/descargas/manuales/constancia_de_Ingreso_traslado.docx" target="_blank">Constancia Registro Traslado</a><br>
»&nbsp;<a href="http://estudiantes.sucre.udo.edu.ve/descargas/manuales/constancia_de_Ingreso_Reingreso_Egresados.docx" target="_blank">Constancia Registro R. Egresado</a><br>
»&nbsp;<a onClick="cambiar_cuerpo('descargas/horarios.php', 'descargas')" style="cursor: pointer;">Horarios 2-2015 </a><br>
»&nbsp;<a onClick="cambiar_cuerpo('descargas/gacetas.php', 'descargas')" style="cursor: pointer;">Gacetas</a><br>
»&nbsp;<a onClick="cambiar_cuerpo('descargas/manuales.php', 'descargas')" style="cursor: pointer;">Manuales</a><br>
 <br>
Para un mejor funcionamiento Descarga
<a href="https://download.mozilla.org/?product=firefox-stub&amp;os=win&amp;lang=es-ES" target="_blank"><img src="img/mozillaWeb.jpg" border="0" style="cursor:pointer"></a>
</div>

				<br>
			</td>
		</tr>
		<tr>
			<td></td>
			<td valign="top" style="line-height: 20px;">
				<h3>Enlaces de Interés</h3>
				»&nbsp;<a href="http://www.udo.edu.ve" target="_blank">Universidad de Oriente (UDO)</a><br>
»&nbsp;<a href="http://www.mppeuct.gob.ve/" target="_blank">Ministerio de Educación Superior (MES)</a><br>
»&nbsp;<a href="http://www.opsu.gob.ve" target="_blank">Oficina de Planif. del Sector Universitario (OPSU)</a><br>
<br><br><br><br>				<br>
			</td>
		</tr>
	<tr><td colspan="5" height="2px" bgcolor="#666666"></td></tr>
	<tr valign="bottom">
		<td colspan="5" bgcolor="#005082" class="tBlanco">
			<div id="footer">
				<p>©2015 | Universidad de Oriente :: Venezuela<br>
				Rectorado :: Coordinación General de Control de Estudios
				</p>
			</div>
		</td>
	</tr>
</tbody></table>

</body></html>