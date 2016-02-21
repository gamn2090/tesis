<?php
include('../config.php');
include('../procesos/funciones.php');
$proceso="Retiro";
session_start();
$nivel=$_SESSION['nivel'];
$bandera=$_SESSION['bandera']; 
?>
	<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  	
    <!-- <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../css/dataTables.editor.css">   -->
</head>
<body>
  <?php
    if($nivel==$bandera)
    {
      mostrar_proceso('Cambio',$bandera,$nivel,$conn);
    }
    else
    {  
  ?>
      <table id="mytable" class="display" style="text-align:center" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th>cedula</th>
                  <th>numero</th>
                  <th>carrera actual</th>  
                  <th>carrera siguiente</th>  
                  <th>accion</th>               
              </tr>
          </thead>        
          <tfoot>
              <tr>
                  <th>cedula</th>
                  <th>numero</th>
                  <th>carrera actual</th>  
                  <th>carrera siguiente</th>  
                  <th>accion</th>               
              </tr>
          </tfoot>
      </table>
      <script>
     $(document).ready(function(){
          var datatable = $('#mytable').DataTable({
                         "ajax": {
                              "url": "../procesos/motor_funciones.php",
                              "type": "POST",
                              "data" : {
                                      "accion" : "mostrar_proceso_cde",   //nombre que recibe el switch    
                                      }
                         },
                         "language": {
                                       "processing": "No hay solicitudes nuevas",                                     
                                       "loadingRecords": ""
                                    },
                          "sAjaxDataProp": "",
                          "processing": true,
                         // "serverSide": true,
                           columns: 
                           [
                              {data:"cedula"},
                              {data:"numero"},
                              {data:"carrera_a"},
                              {data:"carrera_s"},
                              {data:"link"}                       
                            ]    
                               
                      }); 
      });
      </script>
    <?php
    }
    ?>
<!--<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="../js/materialize.js"></script>
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.tableTools.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.editor.js"></script>
<script src="../js/init.js"></script>-->
</body>
</html>




	
					
				