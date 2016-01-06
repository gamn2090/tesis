<?php
include('../config.php');
include('../procesos/funciones.php');
?>				
<body>

        <form class="col s12" id="crear cuenta" action="../procesos/motor_funciones.php" method="POST">
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="Nombre" name="Nombre" type="text" class="validate">
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="input-field col s6 ">
                            <input id="usuario" name="usuario" type="text" class="validate">
                            <label for="usuario">Usuario</label>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="Apellido" name="Apellido" type="text" class="validate">
                            <label for="apellido">Apellido</label>
                        </div>
                        <div class="input-field col s6 ">
                            <input id="contraseña" name="contraseña" type="password" class="validate">
                            <label for="contraseña">Contraseña</label>
                        </div>
                    </div>
                <div class="row">
                        <div class="input-field col s6">
                            <input id="cedula" name="cedula" type="text" class="validate">
                            <label for="cedula">Cédula</label>
                        </div>                        

                        <div class="input-field col s6">             
                          <select class="browser-default" name="sexo" id="sexo" >
                            <option value="" disabled selected>Elija su sexo</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>                            
                          </select>
                        </div>
                </div>
                <div class="row">
                <div class="input-field col s6">             
                          <select class="browser-default" name="privilegios" id="privilegios" >
                            <option value="" disabled selected>Elija el nivel</option>
                            <option value="1">Máximo</option>
                            <option value="2">Mínimo</option>                            
                          </select>
                </div>
                </div>
                    <div class="divider"></div>
                    <div class="row">                       
                        <div class="col m12 offset">
                            <p class="center-align">
                                <button class="btn btn-large waves-effect waves-light" id="crear" type="submit" value="crear_cuenta" name="accion" title="login">Crear</button>
                            </p>
                        </div>
                    </div>
        </form>  
</body>
</html>