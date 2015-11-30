<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<form id="Procesos" action="procesos/motor_funciones.php" method="POST">
<table align="center">
        <tr> 
          <br>          
          <tr> <td align="right" class="negro">Proceso:  </td> <td> <input onKeyPress="return validar(event)" id="Proceso" name="Proceso" title="Ingrese Proceso"> </td></tr>
          <tr> <td align="right" class="negro">Razon:  </td> <td> <input onKeyPress="return validar(event)" id="Razon" name="Razon" title="Ingrese Razon"> </td></tr>
          <tr> <td align="right" class="negro">Puntaje:  </td> <td> <input id="Puntaje" name="Puntaje" class="campo_large"   title="Ingrese Puntaje"> </td></tr>
          <tr> <td align="right" class="negro">Porcentaje:</td> <td> <input id="Porcentaje" name="Porcentaje" class="campo_large"  title="Ingrese Porcentaje"></td> </tr>
          <tr> <td></td><td> <input id="Ingresar_procesos" type="submit" value="Ingresar" name="accion" title=" ingresar procesos" onClick="ingresar_procesos();"></td> </tr>   
                 </tr>   
      </table>
      <br>
</form>
</body>
</html>