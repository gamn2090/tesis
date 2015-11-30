<?php
include('../config.php');
include('../procesos/funciones.php');
?>				
<body>

        <form id="login" class="col s12" id="ingresar razon" action="ingresar_razon.php" method="POST">
                    <div class="row">
                        <div class="input-field col s6">             
                          <select class="browser-default" id="proceso" name="proceso">
                            <option value="" disabled selected>Elija el proceso</option>
                            <option value="Retiro">Retiro</option>
                            <option value="Reingreso">Reingreso</option> 
                            <option value="Cambio">Cambio de Especialidad</option>                           
                          </select>
                        </div>
                        <div class="input-field col s6">
                            <input id="razon" name="razon" type="text" class="validate">
                            <label for="razon">Razón</label>
                        </div>   
                        
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="puntaje" name="puntaje" type="text" class="validate">
                            <label for="puntaje">Puntaje</label>
                        </div>
                        <div class="input-field col s6 ">
                            <input id="ponderacion" name="ponderacion" type="text" class="validate">
                            <label for="ponderacion">Ponderación</label>
                        </div>
                    </div>   
                    <div class="divider"></div>
                    <div class="row">                       
                        <div class="col m12 offset">
                            <p class="center-align">
                                <button class="btn btn-large waves-effect waves-light" id="razon" type="submit" value="Ingresa Razón" name="accion" title="login">Ingresar</button>
                            </p>
                        </div>
                    </div> 
        </form> 

</body>
</html>