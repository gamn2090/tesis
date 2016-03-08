<?php	  
 //require_once (".../Clases.php");
// include ("../pantalla_retiro.php");


/*===========================================================================================================================
					FUNCION PARA ALMACENAR LOS RETIROS/REINGRESOS REALIZADOS POR LOS ESTUDIANTES
============================================================================================================================*/

function ingresar_solicitud($cedula,$proceso,$fecha,$razon,$periodo,$anio,$especialidad,$nucleo,$estatus,$asignatura,$conn)
{
	if($proceso=='Retiro')
	{	
		$query= "INSERT INTO solicitudes (cedula, nucleo, especialidad, fecha, anio, periodo, t_solicitud, recaudos, estatus, observacion) 
				VALUES ('$cedula', '$nucleo', '$especialidad', '$fecha', '$anio', '$periodo', '$proceso', 'NO', '$estatus', '$razon' )";
	}
	else
	{
		if($proceso=='Reingreso')
		{	
			$query= "INSERT INTO solicitudes (cedula, nucleo, especialidad, fecha, anio, periodo, t_solicitud, recaudos, estatus, observacion) 
					VALUES ('$cedula', '$nucleo', '$especialidad', '$fecha', '$anio', '$periodo', '$proceso', 'NO', '$estatus', 'ninguna' )";
		}
		else
		{
			if($proceso=='Cambio')
			{	
				$query= "INSERT INTO solicitudes (cedula, nucleo, especialidad, fecha, anio, periodo, t_solicitud, recaudos, estatus, observacion) 
						VALUES ('$cedula', '$nucleo', '$especialidad', '$fecha', '$anio', '$periodo', '$proceso', 'NO', '$estatus', '$asignatura' )";
			}	
		}
	}
	$result=$conn->Execute($query);
	if($result==false)
	{$bandera=1;}
	else
	{$bandera=0;}
	return $bandera;	
	$conn->Close();
}
/*===========================================================================================================================
					FUNCION PARA ALMACENAR LOS CAMBIOS DE ESPECIALIDAD REALIZADOS POR LOS ESTUDIANTES
============================================================================================================================*/
function ingresar_CDE($cedula,$razon,$carrera_pedida,$fecha,$conn)
{
		$query="SELECT * FROM est_esp WHERE  (cedula LIKE '%$cedula%')";
		$result=$conn->Execute($query);
		if($result==false)
		{echo "error al insertar: ".$conn->ErrorMsg()."<br>" ;}
		else
		{		
		while (!$result->EOF) 
			{ 
				for ($i=0, $max=$result->FieldCount(); $i < $max; $i++)
				{	
					$carrera_actual=$result->fields[1];
				}			
				$result->MoveNext();							
			}		
		}	
		$query2="SELECT * FROM esp WHERE  (nombre LIKE '%$carrera_pedida%')";
		$result=$conn->Execute($query);
		if($result==false)		
		{echo "error al insertar: ".$conn->ErrorMsg()."<br>" ;}
		else
		{		
		while (!$result->EOF) 
			{ 
				for ($i=0, $max=$result->FieldCount(); $i < $max; $i++)
				{	
					$carrera_pedida=$result->fields[0];
				}			
				$result->MoveNext();							
			}		
		}
	$query3="INSERT INTO solicitud_CDE (cedula, razon, especialidad_esta_estudiando,especialidad_quiere_estudiar, fecha_solicitud) VALUES ('$cedula', '$razon', '$carrera_actual','%$carrera_pedida%','$fecha')";;
	if($conn->Execute($query)==false)
	{$bandera=1;}
	else
	{$bandera=0;}
	return $bandera;
	$conn->Close();
}

/*============================================================================================================================
					FUNCION PARA EL LOGIN DE LOS ESTUDIANTES
============================================================================================================================*/

function loguear($cedula,$contraseña,$conn)
{	//$contraseña=sha1(md5($contraseña));	
	$query="SELECT password FROM login WHERE ((password LIKE '%$contraseña%') AND (cedula LIKE '%$cedula%'))";
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al insertar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{	
		while (!$result->EOF) 
		{ 
			for ($i=0, $max=$result->FieldCount(); $i < $max; $i++)
			{	
				if(($cedula==$result->fields[0]))
				{ 
					$id=2; 
				}
				else
				{
					$id=1;
				}
			}			
			$result->MoveNext();							
		}
		session_start();
		$_SESSION['estudiante_ced']=$cedula;
		if($id==2)
			{ 			
				//echo "<br> Bienvenido! " . $nombre. " " . $apellido['apellido'];
				$cedula=base64_encode($cedula);
				header("location: ../llamadas/seleccion_proceso.php"); 
			}
			else
			{		
					$id=1;
					header("location: ../login_estudiante.php?id=$id");
				
			}
		
	}
	$conn->Close();
		
}
/*============================================================================================================================
					FUNCION PARA EL LOGIN DE LA COORDINACIÓN
============================================================================================================================*/

function loguear_coord($usuario,$contraseña,$conn)
{	$contraseña=sha1(md5($contraseña));
	$query="SELECT * FROM users WHERE ((usuario LIKE '%$usuario%') AND (pass LIKE '%$contraseña%'))";
	$result=$conn->Execute($query);
	if($result==false)
	{
		echo "error al insertar: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{
		while(!$result->EOF) 
		{ 
			for ($i=0, $max=$result->FieldCount(); $i < $max; $i++)
			{	$usuario2=$result->fields[5];
				$nivel=$result->fields[2];
				if($usuario == $result->fields[5])
				{ 
					$id=2; 
					/*aquí hacer lo de la variable de sesion*/
					session_start();
					$_SESSION['nivel']=$nivel;
					$_SESSION['usuario']=$usuario;
					$prueba1="OverNineThousand";
					$prueba1=sha1(md5($prueba1));	
					$_SESSION['bandera']=$prueba1;
								
				}
			}				
			$result->MoveNext();							
		}
		if($id==2)
			{ 							
				header("location: ../coordinacion_principal.php"); 
			}
			else
			{		
				$id=1;
				header("location: ../index.php?id=$id");				
			}
	
	}
	$conn->Close();
}

/*============================================================================================================================
					FUNCION PARA CARGAR Y MOSTRAR LOS DATOS DE LOS ESTUDIANTES AL LOGUEAR
============================================================================================================================*/


function cargar_datos($cedula,$conn)
{	
	$query="SELECT * FROM estudiante WHERE (ced LIKE '%$cedula%')";	
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{
		while (!$result->EOF) 
		{
			for ($i=0, $max=$result->FieldCount(); $i < $max; $i++)
		  	print $result->estudiante[$i].' ';
			$result->MoveNext();
			
 		} 	
	}
	$conn->Close();
}

/*============================================================================================================================
					FUNCION PARA EL LOGIN DE LOS USUARIOS DE LA COORDINACION AL LOGUEAR
============================================================================================================================*/


function cargar_datos_coord($usuario,$conn)
{	
	$query="SELECT * FROM users WHERE (usuario LIKE '%$usuario%')";	
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{
		while (!$result->EOF)
		{
			for ($i=0, $max=$result->FieldCount(); $i < $max; $i++)
			{
				$nombre=$result->fields[3];
				$apellido=$result->fields[4];
				$nivel=$result->fields[2];
				$sexo=$result->fields[6];
			}
				if($sexo=='m' || $sexo=='M'){
				echo "Bienvenido ";}
				else{ echo "Bienvenida ";}
				if($sexo=='m' || $sexo=='M')
				{echo "Licenciado ";} 
				else{echo "Licenciada ";}
				echo $nombre. " " .$apellido;
			
			$result->MoveNext();					
		} 	
	}
	$conn->Close();
}

/*===========================================================================================================================
 FUNCION PARA VISUALIZAR LA BASE DE DATOS HISTORICA  	
 ======================================================================================================================*/
function visualizar_historico($nivel,$conn)
{
			$query="SELECT * FROM decisiones";	
			$result=$conn->Execute($query);		
			if($result==false)
			{
				echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
			}
			else
			{	$j=0;
				while(!$result->EOF) 
				{			
					for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
					{
							$cedula=$result->fields[0];
							$fecha=$result->fields[1];					
							$solicitud=$result->fields[5];
							$razon=$result->fields[2];	
							$resultado=$result->fields[9];
							$link="<a href=\"estudiar_historico.php?id=".$cedula."&soli=".$solicitud."&fecha=".$fecha."\" target='_blank'>Evaluar</a>";							
							$result->MoveNext();											
							break;	
					}
					
					if($nivel==sha1(md5("OverNineThousand")))
					{
						$data[$j]=array("cedula"=>$cedula,
										"solicitud"=> $solicitud,
										"fecha"=>$fecha,
										"razon"=> $razon,
										"resultado"=>$resultado,
										"link"=>$link);
					$j++;
					}
					else
					{
						$data[$j]=array("cedula"=>$cedula,
										"solicitud"=> $solicitud,
										"fecha"=>$fecha,
										"razon"=> $razon,
										"resultado"=>$resultado);
									
					$j++;
					}					
				}
				header('Content-type: application/json');
				return json_encode($data);
			
			}
				$conn->Close();			
}
/*===========================================================================================================================
					FUNCION PARA MOSTRAR LOS PROCESOS EN TABLAS
============================================================================================================================*/

function mostrar_proceso($proceso,$bandera,$nivel,$conn)
{   if($proceso=="Retiro")
	{		
		if($nivel==$bandera)
		{
			$query="SELECT * FROM solicitudes_ret WHERE (proceso LIKE '$proceso%' AND exp NOT LIKE '-1')";
			$result=$conn->Execute($query);	
		}
		else
		{
			$query="SELECT * FROM solicitudes_ret WHERE (proceso LIKE '$proceso%' AND exp LIKE '-1')";
			$result=$conn->Execute($query);	
		}		
			if($result==false)
			{
				echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
			}
			else
			{		
				$j=0;
				while(!$result->EOF) 
				{	
					for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
					{	
						$proceso=$result->fields[3];						
						$cedula=$result->fields[0];
						$numero_sol=$result->fields[1];
						$razon=$result->fields[2];	
						$cedula2=base64_encode($cedula);
						$numero_sol2=base64_encode($numero_sol);
						$proceso=base64_encode($proceso);
						$link="<a href=\"evaluar.php?proceso=".$proceso."&id=".$cedula2."&numero=".$numero_sol2."\" target='_blank'>Evaluar</a>";						
						$result->MoveNext();											
						break;												
					}
					$data[$j]=array("cedula"=>$cedula,
									"numero"=> $numero_sol,
									"razon"=> $razon,
									"link"=>$link);
					$j++;
				} 
				header('Content-type: application/json');
				return json_encode($data);
			}
	}
	else
	{
		if($proceso=="Cambio")
		{
			if($nivel==$bandera)
			{
				$query="SELECT * FROM solicitudes_cde WHERE (exp NOT LIKE '-1' AND exp NOT LIKE '0')";
				$result1=$conn->Execute($query);	
				if($result1==false)
				{
					echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
				}
				else
				{		
					$demanda=$result1->RowCount();
					?>
					<form id="Evaluar_estudiante" class="col s12" action="../procesos/motor_funciones.php" target="_blank" method="POST">
					    <input type="hidden" id="demanda" name="demanda"  value="<?php echo $demanda; ?>">
   	
					        <div class="row">
	                        	<div class="input-field col s6 offset-s3">
		                            <input id="oferta" name="oferta" type="text" class="validate" placeholder="Ingrese la cantidad de cupos" value="">
		                            <label for="nombre">Cupos disponibles</label>
					        	</div>
					        </div>
					        <div class="row">
					        <div class="input-field col s6 offset-s3">
						        <select class="browser-default" id="carrera" name="carrera">
						        <?php 
									$query2="SELECT * FROM esp";	
									$result=$conn->Execute($query2);
									if($result==false)
									{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
									else
									{	
										?>
										<option value="" disabled selected>Carrera a optar</option>
										<?php	
										while(!$result->EOF) 
											{			
												for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
												{
													$codigo=$result->fields[0];	
													$carrera=$result->fields[1];														
												}	
												?>
						                        <option><?php echo $carrera; ?></option>
						                        <?php					
												$result->MoveNext();
											}
									}
								?>						        
						        </select>
						    </div>
						   	</div>
                            <div class="divider"></div>
		                    <div class="row">                       
		                        <div class="col m12 offset">
		                            <p class="center-align">
		                                <button class="btn btn-large waves-effect waves-light" id="crear" type="submit" value="cambios" name="accion" title="login">Procesar Cambios</button>
		                            </p>
		                        </div>
		                    </div>
					</form>	
					<?php
					}
			}
			else
			{
				$query="SELECT * FROM solicitudes_cde WHERE (exp LIKE '-1')";
				$result=$conn->Execute($query);						
				if($result==false)
				{
					echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
				}
				else
				{				
					$j=0;
					while(!$result->EOF) 
					{			
						for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
						{
							$numero_sol=$result->fields[1];
							$cedula=$result->fields[0];
							$razon=$result->fields[2];	
							$carrera_actual=$result->fields[3];
							$carrera_siguiente=$result->fields[4];
							$cedula2=base64_encode ($cedula);
							$numero_sol2=base64_encode ($numero_sol);
							$link="<a href=\"evaluar.php?id=".$cedula2."&numero=".$numero_sol2."\" target='_blank'>Evaluar</a>";							
							$query3="SELECT * FROM esp WHERE codigo LIKE '%$carrera_actual%'";
							$result=$conn->Execute($query3);
							if($result==false)
							{
								echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
							}
							else
							{	
								while(!$result->EOF) 
								{			
									for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
									{	
										$carrera_actual=$result->fields[1];
									}
									break;
								}
							}	
							$query4="SELECT * FROM esp WHERE codigo LIKE '%$carrera_siguiente%'";
							$result=$conn->Execute($query4);
							if($result==false)
							{
								echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
							}
							else
							{	
								while(!$result->EOF) 
								{			
									for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
									{	
										$carrera_siguiente=$result->fields[1];
									}
									break;
								}
							}		
							$result->MoveNext();											
							break;	
						}
						$data[$j]=array("cedula"=>$cedula,
										"numero"=> $numero_sol,
										"carrera_a"=> $carrera_actual,
										"carrera_s"=> $carrera_siguiente,
										"link"=>$link);
						$j++;
					} 
					header('Content-type: application/json');
					return json_encode($data);				
				}
			}
		}
		else
		{
			if($proceso=="Reingreso")
			{	
				if($nivel==$bandera)
				{
					$query="SELECT * FROM solicitudes_rein WHERE (proceso LIKE '$proceso%' AND exp NOT LIKE '-1')";
					$result=$conn->Execute($query);	
				}
				else
				{
					$query="SELECT * FROM solicitudes_rein WHERE (proceso LIKE '$proceso%' AND exp LIKE '-1')";
					$result=$conn->Execute($query);	
				}		
					if($result==false)
					{
						echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
					}
					else
					{		
						$j=0;
						while(!$result->EOF) 
						{	
							for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
							{	
								$proceso=$result->fields[3];						
								$cedula=$result->fields[0];
								$numero_sol=$result->fields[1];
								$grupo=$result->fields[2];	
								$cedula2=base64_encode($cedula);
								$numero_sol2=base64_encode($numero_sol);
								$proceso=base64_encode($proceso);
								$link="<a href=\"evaluar.php?proceso=".$proceso."&id=".$cedula2."&numero=".$numero_sol2."\" target='_blank'>Evaluar</a>";						
								$result->MoveNext();											
								break;												
							}
							$data[$j]=array("cedula"=>$cedula,
											"numero"=> $numero_sol,
											"grupo"=> $grupo,
											"link"=>$link);
							$j++;
						} 
						header('Content-type: application/json');
						return json_encode($data);
					}
			}
		}
	}
	$conn->Close();
}

/*============================================================================================================================
					FUNCION PARA APROBAR O RECHAZAR CAMBIOS
==============================================================================================================================*/
function ingresar_cambio($demanda,$oferta,$carrera,$conn)
{
		$query="SELECT * FROM esp WHERE (nombre LIKE '%$carrera%')";
		$result=$conn->Execute($query);
		if($result==false)
		{
			echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
		}
		else
		{					
			while(!$result->EOF) 
			{			
				for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
				{
					$codigo=$result->fields[0];
				}
				$result->MoveNext();
			}
		}

	if(($demanda<$oferta) || $demanda==$oferta)
	{
		$id=3;		
		$query2="SELECT * FROM solicitudes_cde WHERE (exp NOT LIKE '-1') AND (especialidad_quiere_estudiar LIKE '%$codigo%')";
		$result=$conn->Execute($query2);	
		if($result==false)
		{
			echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
		}
		else
		{				
			while(!$result->EOF) 
			{			
				for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
				{
					$cedula=$result->fields[0];
					$razon=$result->fields[2];
					$fecha_solicitud=$result->fields[5];
					$exp=$result->fields[6];				
				}
					$query3="SELECT * FROM estudiante WHERE (ced LIKE '%$cedula%')";
					$result=$conn->Execute($query3);
					if($result==false)
					{
						echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
					}
					else
					{				
						while(!$result->EOF) 
						{			
							for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
							{
								$promedio=$result->fields[25];					
								$nombre=$result->fields[3];
							}
							$result->MoveNext();
						}
						if($promedio>5)
						{
							$promedio='Tiene promedio positivo, '.$promedio.'/10';
						}
						else
						{
							$promedio='Tiene promedio negativo, '.$promedio.'/10';
						}
					}
					$anio=obtener_anio($fecha_solicitud);
					$tiempo_sol=tiempo_solicitud_retiro($anio,$fecha_solicitud,$conn);
					if($tiempo_sol==-1)
					{
						$fecha='Ingreso la solicitud en el tiempo estimado';
					}
					else
					{
						$fecha='No ingreso la solicitud en el tiempo estimado, la ingreso '.$tiempo_sol.' dias tarde';
					}
					$solicitud_actual='Cambio';
					$aval='Presentó aval por la razon';


					$solicitudes2=buscar_historico($cedula,$conn,'Cambio');
					if(($solicitudes2==0))
					{
						$solicitudes="No tiene";	
					}
					else
					{
						$solicitudes="Si tiene";	
					}		
					if($nombre!=NULL)
					{
						$algo=1;
					}
					else
					{
						$algo=0;
					}				
					
					if($algo==1)
					{
						$cant_soli1=cantidad_solicitud_historico($cedula,'Cambio',$conn);
						if($cant_soli1==0)
						{
							$cant_soli=0;	
						}
						else
						{
							$cant_soli=$cant_soli1+$cant_soli2;	
						}
						$solicitudes="El estudiante tiene ".$cant_soli." Solicitudes anteriores";
					}
					$medi=0;
					$query4="SELECT * FROM medidas_academicas WHERE cedula LIKE '%$cedula%'";
					$result=$conn->Execute($query4);
					if($result==false)
					{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
						
					}	
					else
					{
						while(!$result->EOF) 
						{			
							$medi=1;
							$result->MoveNext();
						}			
					}
					if($medi==0)
					{
						$medidas="No tiene medidas";
					}
					else
					{
						$medidas="Tiene medidas";
					}
					$decision='Aprobado';
					$acuerdo='Si';
					$observaciones='Cambio a '.$carrera;

					ingresar_historico($exp,$cedula,$fecha_solicitud,$razon,$promedio,$solicitudes,$solicitud_actual,$aval,$fecha,$medidas,$decision,$observaciones,$acuerdo,$conn);
				$result->MoveNext();	
			}
							
		}
		return $id;
	}	
	else
	{
		if($demanda>$oferta)
		{
			
			$query2="SELECT A.* FROM solicitudes_cde A, estudiante B WHERE (A.exp NOT LIKE '-1' AND A.especialidad_quiere_estudiar LIKE '%$codigo%') ORDER BY B.promedio DESC LIMIT $oferta";
			$result=$conn->Execute($query2);	
			if($result==false)
			{
				echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
			}
			else
			{				
				while(!$result->EOF) 
				{			
					for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
					{
						$cedula=$result->fields[0];
						$razon=$result->fields[2];
						$fecha_solicitud=$result->fields[5];
						$exp=$result->fields[6];				
					}
						$query3="SELECT * FROM estudiante WHERE (ced LIKE '%$cedula%')";
						$result=$conn->Execute($query3);
						if($result==false)
						{
							echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
						}
						else
						{				
							while(!$result->EOF) 
							{			
								for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
								{
									$promedio=$result->fields[25];					
									$nombre=$result->fields[3];
								}
								$result->MoveNext();
							}
							if($promedio>5)
							{
								$promedio='Tiene promedio positivo, '.$promedio.'/10';
							}
							else
							{
								$promedio='Tiene promedio negativo, '.$promedio.'/10';
							}
						}
						$anio=obtener_anio($fecha_solicitud);
						$tiempo_sol=tiempo_solicitud_retiro($anio,$fecha_solicitud,$conn);
						if($tiempo_sol==-1)
						{
							$fecha='Ingreso la solicitud en el tiempo estimado';
						}
						else
						{
							$fecha='No ingreso la solicitud en el tiempo estimado, la ingreso '.$tiempo_sol.' dias tarde';
						}
						$solicitud_actual='Cambio';
						$aval='Presentó aval por la razon';


						$solicitudes2=buscar_historico($cedula,$conn,'Cambio');
						if(($solicitudes2==0))
						{
							$solicitudes="No tiene";	
						}
						else
						{
							$solicitudes="Si tiene";	
						}		
						if($nombre!=NULL)
						{
							$algo=1;
						}
						else
						{
							$algo=0;
						}						
						
						if($algo==1)
						{
							$cant_soli1=cantidad_solicitud_historico($cedula,'Cambio',$conn);
							if($cant_soli1==0)
							{
								$cant_soli=0;	
							}
							else
							{
								$cant_soli=$cant_soli1+$cant_soli2;	
							}
							$solicitudes="El estudiante tiene ".$cant_soli." Solicitudes anteriores";
						}
						$medi=0;
						$query4="SELECT * FROM medidas_academicas WHERE cedula LIKE '%$cedula%'";
						$result=$conn->Execute($query4);
						if($result==false)
						{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
							
						}	
						else
						{
							while(!$result->EOF) 
							{			
								$medi=1;
								$result->MoveNext();
							}			
						}
						if($medi==0)
						{
							$medidas="No tiene medidas";
						}
						else
						{
							$medidas="Tiene medidas";
						}
						$decision='Aprobado';
						$acuerdo='Si';
						$observaciones='Cambio a '.$carrera;
					$result->MoveNext();	
				}
				ingresar_historico($exp,$cedula,$fecha_solicitud,$razon,$promedio,$solicitudes,$solicitud_actual,$aval,$fecha,$medidas,$decision,$observaciones,$acuerdo,$conn);

			}
			$query10="SELECT * FROM solicitudes_cde WHERE (exp NOT LIKE '-1') AND (especialidad_quiere_estudiar LIKE '%$codigo%') LIMIT $oferta";
			$result=$conn->Execute($query10);	
			if($result==false)
			{
				echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
			}
			else
			{				
				while(!$result->EOF) 
				{			
					for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
					{
						$cedula=$result->fields[0];
						$razon=$result->fields[2];
						$fecha_solicitud=$result->fields[5];
						$exp=$result->fields[6];				
					}
						$query12="SELECT * FROM estudiante WHERE (ced LIKE '%$cedula%')";
						$result=$conn->Execute($query12);
						if($result==false)
						{
							echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
						}
						else
						{				
							while(!$result->EOF) 
							{			
								for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
								{
									$promedio=$result->fields[25];					
									$nombre=$result->fields[3];
								}
								$result->MoveNext();
							}
							if($promedio>5)
							{
								$promedio='Tiene promedio positivo, '.$promedio.'/10';
							}
							else
							{
								$promedio='Tiene promedio negativo, '.$promedio.'/10';
							}
						}
						$anio=obtener_anio($fecha_solicitud);
						$tiempo_sol=tiempo_solicitud_retiro($anio,$fecha_solicitud,$conn);
						if($tiempo_sol==-1)
						{
							$fecha='Ingreso la solicitud en el tiempo estimado';
						}
						else
						{
							$fecha='No ingreso la solicitud en el tiempo estimado, la ingreso '.$tiempo_sol.' dias tarde';
						}
						$solicitud_actual='Cambio';
						if($exp!='0')
						{ 	
							$aval='Presentó aval por la razon';
						}
						else
						{
							$aval='No presentó aval por la razon';
						}

						$solicitudes2=buscar_historico($cedula,$conn,'Cambio');
						if(($solicitudes2==0))
						{
							$solicitudes="No tiene";	
						}
						else
						{
							$solicitudes="Si tiene";	
						}		
						if($nombre!=NULL)
						{
							$algo=1;
						}
						else
						{
							$algo=0;
						}						
						
						if($algo==1)
						{
							$cant_soli1=cantidad_solicitud_historico($cedula,'Cambio',$conn);
							if($cant_soli1==0)
							{
								$cant_soli=0;	
							}
							else
							{
								$cant_soli=$cant_soli1+$cant_soli2;	
							}
							$solicitudes="El estudiante tiene ".$cant_soli." Solicitudes anteriores";
						}
						$medi=0;
						$query11="SELECT * FROM medidas_academicas WHERE cedula LIKE '%$cedula%'";
						$result=$conn->Execute($query11);
						if($result==false)
						{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
							
						}	
						else
						{
							while(!$result->EOF) 
							{			
								$medi=1;
								$result->MoveNext();
							}			
						}
						if($medi==0)
						{
							$medidas="No tiene medidas";
						}
						else
						{
							$medidas="Tiene medidas";
						}
						$decision='Reprobado';
						$acuerdo='Si';
						$observaciones='Cambio a '.$carrera;
					$result->MoveNext();	
				}	
				ingresar_historico($exp,$cedula,$fecha_solicitud,$razon,$promedio,$solicitudes,$solicitud_actual,$aval,$fecha,$medidas,$decision,$observaciones,$acuerdo,$conn);
	

			}

			return $id;
		}		
	}
$conn->Close();
}
/*============================================================================================================================
					FUNCION PARA EL CALCULO DE LOS PARAMETROS DE LOS TOMADORES DE DECISIONES
============================================================================================================================*/

function cargar_datos_estudiante($proceso,$numero_soli,$cedula,$nivel,$conn)
{	
	if($proceso=='Retiro')
	{
		$query="SELECT * FROM solicitudes_ret WHERE ((cedula LIKE '%$cedula%') AND (numero_soli = $numero_soli))";	
		$result=$conn->Execute($query);
	}
	else
	{
		if($proceso=='Reingreso')
		{
			$query="SELECT * FROM solicitudes_rein WHERE ((cedula LIKE '%$cedula%') AND (numero_soli = $numero_soli))";	
			$result=$conn->Execute($query);
		}
		else
		{
			$query="SELECT * FROM solicitudes_cde WHERE ((cedula LIKE '%$cedula%') AND (numero_soli = $numero_soli))";	
			$result=$conn->Execute($query);
		}
	}
	if($result==false)
	{
		echo "error al recuperar 1: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{
		$fecha=$result->fields[4];
		$razon=$result->fields[2];
		$exp=$result->fields[5];
	}

	//SABER SI TIENE AVAL
	if($exp!='-1' && $exp!="0")
	{$aval="Si";}
	else
	{$aval="No";}

	$solicitudes2=buscar_historico($cedula,$conn,$proceso);
	if(($solicitudes2==0))
	{
		$solicitudes="No tiene";	
	}
	else
	{
		$solicitudes="Si tiene";	
	}		
	
	$query="SELECT * FROM estudiante WHERE (ced LIKE '%$cedula%')";	
	$result=$conn->Execute($query);
	if($result==false)
	{
		echo "error al recuperar 2: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{		
		while (!$result->EOF)
		{
			for ($i=0, $max=$result->FieldCount(); $i < $max; $i++)
			{
					$cedula=$result->fields[1];
					$nombre=$result->fields[3];
					$apellido=$result->fields[2];					
					$email=$result->fields[22];					
					$direccion=$result->fields[11];
					$promedio=$result->fields[25];
					$discapacidad=$result->fields[27];
					$nacionalidad=$result->fields[17];
					if($nacionalidad=='v')
					$nacionalidad='Venezolano';
					else
					$nacionalidad='Extrangero';
			}	  	
						
			$result->MoveNext();
		}
		if($nombre!=NULL)
		{
			$algo=1;
		}
		else
		{
			$algo=0;
		}
	}
	
	if($algo==1)
	{
		$cant_soli1=cantidad_solicitud_historico($cedula,$proceso,$conn);
		if($cant_soli1==0)
		{
			$cant_soli=0;	
		}
		else
		{
			$cant_soli=$cant_soli1+$cant_soli2;	
		}
		if($nivel==sha1(md5("OverNineThousand")))
		{
			mostrar_datos_estudiante_coord($aval,$cedula,$nombre,$apellido,$razon,$promedio,$discapacidad,$nacionalidad,$solicitudes,$proceso,$cant_soli,$fecha);

		}
		else
		{
			mostrar_datos_estudiante_sec($numero_soli,$cedula,$nombre,$apellido,$razon,$promedio,$discapacidad,$nacionalidad,$solicitudes,$proceso,$cant_soli,$fecha);
		}
	}
	else
	{
		echo "Lo sentimos, el estudiante solicitado no existe en la base de datos de control de estudios";	
	}		
}

/*============================================================================================================================
					FUNCION PARA MOSTRAR LOS DATOS DEL ESTUDIANTE PARA VER SI SON CORRECTOS PARA LA SECRETARIA
==============================================================================================================================*/


function mostrar_datos_estudiante_sec($numero_soli,$cedula,$nombre,$apellido,$razon,$promedio,$discapacidad,$nacionalidad,$solicitudes,$proceso,$cant_soli,$fecha)
{
	$anio=obtener_anio($fecha);
?>
        
	 <form id="Evaluar_estudiante" class="col s12" action="guardar.php" method="POST">
	 					<!--                    todos los datos hidden                       -->

                        	<input type="hidden" id="anio" name="anio"  value="<?php echo $anio; ?>">
                        	<input type="hidden" id="numero_soli" name="numero_soli"  value="<?php echo $numero_soli; ?>">
                        	<input type="hidden" id="Nombre" name="Nombre"  value="<?php echo $nombre; ?>">
                   	        <input type="hidden" id="Apellido" name="Apellido"  value="<?php echo $apellido; ?>">
        					<input type="hidden" id="cedula" name="cedula"  value="<?php echo $cedula; ?>">
					        <input type="hidden" id="fecha" name="fecha"  value="<?php echo $fecha; ?>">
					        <input type="hidden" id="razon" name="razon"  value="<?php echo $razon; ?>">
			                <input type="hidden" id="Promedio" name="Promedio" value="<?php echo $promedio; ?>">
        					<input type="hidden" id="discapacidad" name="discapacidad"value="<?php echo $discapacidad; ?>">
        					<input type="hidden" id="nacionalidad" name="nacionalidad" value="<?php echo $nacionalidad; ?>">
					        <input type="hidden" id="solicitudes" name="solicitudes" value="<?php echo $solicitudes; ?>">
					        <input type="hidden" id="cant_soli" name="cant_soli"  value="<?php echo $cant_soli; ?>">
					        <input type="hidden" id="Sol_actual" name="Sol_actual"  value="<?php echo $proceso; ?>">

					    <!--                    todos los datos hidden                       -->

                    <div class="row">
                        <div class="input-field col s6">
                            <input id="Nombre" type="text" disabled class="validate"  value="<?php echo $nombre; ?>">
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="input-field col s6 ">
                        	<input id="apellido"  type="text" class="validate"  disabled value="<?php echo $apellido; ?>">
                            <label for="apellido">Apellido</label>                            
                        </div>
                    </div> 
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="cedula" type="text" class="validate" disabled value="<?php echo $cedula; ?>">
                            <label for="cedula">Cédula</label>
                        </div>   
                        <div class="input-field col s6">             
                          	<input id="Promedio" type="text" class="validate" disabled value="<?php echo $promedio; ?>">
                            <label for="Promedio">Promedio</label>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="fecha"  type="text" class="validate" disabled value="<?php echo $fecha; ?>">
                            <label for="fecha">Fecha de Solicitud</label>
                        </div>
                        <div class="input-field col s6 ">
                            <input id="razon" type="text" class="validate" disabled value="<?php echo $razon; ?>">
                            <label for="razon">Razon</label>
                        </div>
                    </div>                
	                <div class="row">

	                	 <div class="input-field col s6">
						    <select id="Aval" name="aval">
						      <option value="" disabled selected>¿Presentó soportes?</option>
						      <option value="Si">Si</option>
						      <option value="No">No</option>
						    </select>
						 </div>		                
		                <div class="input-field col s6 ">
                            <input id="discapacidad"  type="text" class="validate" disabled value="<?php echo $discapacidad; ?>">
                            <label for="discapacidad">¿Tiene discapacidad?</label>
                        </div>
	                </div>


	                <div class="row">
                        <div class="input-field col s6">
                            <input id="solicitudes"  type="text" class="validate" disabled value="<?php echo $solicitudes; ?>">
                            <label for="solicitudes">Solicitudes anteriores</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="Sol_actual" type="text" class="validate" disabled value="<?php echo $proceso; ?>">
                            <label for="Sol_actual">Solicitud Actual</label>
                        </div>                    
                    </div> 
                    <div class="row">
                     <?php
					if($solicitudes=="Si tiene")
					{
					?>  
                        <div class="input-field col s6 ">
                            <input id="cant_soli" type="text" class="validate" disabled value="<?php echo $cant_soli; ?>">
                            <label for="cant_soli">Cantidad de solicitudes</label>
                        </div>
                    <?php
                	}
                    ?>                    
                    </div> 
                    <div class="divider"></div>
                    <div class="row">                       
                        <div class="col m12 offset">
                            <p class="center-align">
                                <button class="btn btn-large waves-effect waves-light" id="crear" type="submit" value="Guardar" name="accion" title="login">Guardar</button>
                            </p>
                        </div>
                    </div>
        </form> 
<?php

}

/*============================================================================================================================
					FUNCION PARA MOSTRAR LOS DATOS DEL ESTUDIANTE PARA VER SI SON CORRECTOS PARA EL COORDINADOR
==============================================================================================================================*/

function mostrar_datos_estudiante_coord($aval,$cedula,$nombre,$apellido,$razon,$promedio,$discapacidad,$nacionalidad,$solicitudes,$proceso,$cant_soli,$fecha)
{
	$anio=obtener_anio($fecha);
?>
        
	 <form id="Evaluar_estudiante" class="col s12" action="resultado.php" method="POST">
	 					<!--                    todos los datos hidden                       -->

                        	<input type="hidden" id="anio" name="anio"  value="<?php echo $anio; ?>">
                        	<input type="hidden" id="Nombre" name="Nombre"  value="<?php echo $nombre; ?>">
                   	        <input type="hidden" id="Apellido" name="Apellido"  value="<?php echo $apellido; ?>">
        					<input type="hidden" id="cedula" name="cedula"  value="<?php echo $cedula; ?>">
					        <input type="hidden" id="fecha" name="fecha"  value="<?php echo $fecha; ?>">
					        <input type="hidden" id="razon" name="razon"  value="<?php echo $razon; ?>">
					        <input type="hidden" id="aval" name="aval"  value="<?php echo $aval; ?>">
			                <input type="hidden" id="Promedio" name="Promedio" value="<?php echo $promedio; ?>">
        					<input type="hidden" id="discapacidad" name="discapacidad"value="<?php echo $discapacidad; ?>">
        					<input type="hidden" id="nacionalidad" name="nacionalidad" value="<?php echo $nacionalidad; ?>">
					        <input type="hidden" id="solicitudes" name="solicitudes" value="<?php echo $solicitudes; ?>">
					        <input type="hidden" id="cant_soli" name="cant_soli"  value="<?php echo $cant_soli; ?>">
					        <input type="hidden" id="Sol_actual" name="Sol_actual"  value="<?php echo $proceso; ?>">

					    <!--                    todos los datos hidden                       -->

                    <div class="row">
                        <div class="input-field col s6">
                            <input id="Nombre" type="text" disabled class="validate"  value="<?php echo $nombre; ?>">
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="input-field col s6 ">
                        	<input id="apellido"  type="text" class="validate"  disabled value="<?php echo $apellido; ?>">
                            <label for="apellido">Apellido</label>                            
                        </div>
                    </div> 
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="cedula" type="text" class="validate" disabled value="<?php echo $cedula; ?>">
                            <label for="cedula">Cédula</label>
                        </div>   
                        <div class="input-field col s6">             
                          	<input id="Promedio" type="text" class="validate" disabled value="<?php echo $promedio; ?>">
                            <label for="Promedio">Promedio</label>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="fecha"  type="text" class="validate" disabled value="<?php echo $fecha; ?>">
                            <label for="fecha">Fecha de Solicitud</label>
                        </div>
                        <div class="input-field col s6 ">
                            <input id="razon" type="text" class="validate" disabled value="<?php echo $razon; ?>">
                            <label for="razon">Razon</label>
                        </div>
                    </div>                
	                <div class="row">
		                <div class="input-field col s6 ">
                            <input id="discapacidad"  type="text" class="validate" disabled value="<?php echo $discapacidad; ?>">
                            <label for="discapacidad">¿Tiene discapacidad?</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="Sol_actual" type="text" class="validate" disabled value="<?php echo $proceso; ?>">
                            <label for="Sol_actual">Solicitud Actual</label>
                        </div>                    
                    </div> 
                    <div class="row">
                    	<div class="input-field col s6">
                            <input id="solicitudes"  type="text" class="validate" disabled value="<?php echo $solicitudes; ?>">
                            <label for="solicitudes">Solicitudes anteriores</label>
                        </div>
                     <?php
					if($solicitudes=="Si tiene")
					{
					?>  
                        <div class="input-field col s6 ">
                            <input id="cant_soli" type="text" class="validate" disabled value="<?php echo $cant_soli; ?>">
                            <label for="cant_soli">Cantidad de solicitudes</label>
                        </div>
                    <?php
                	}
                    ?>                    
                    </div> 
                    <div class="divider"></div>
                    <div class="row">                       
                        <div class="col m12 offset">
                            <p class="center-align">
                                <button class="btn btn-large waves-effect waves-light" id="crear" type="submit" value="Evaluar" name="accion" title="login">Evaluar</button>
                            </p>
                        </div>
                    </div>
        </form> 
<?php

}

/*============================================================================================================================
					FUNCION PARA SABER SI EL ALUMNO TIENE O NO DOCUMENTOS CONSIGNADOS
==============================================================================================================================*/

function validar_solicitud($numero_soli,$anio,$fecha,$cedula,$razon,$solicitud_actual,$aval,$conn)
{	
	if($solicitud_actual=='Retiro')
	{
		$query="SELECT COUNT (exp) AS total_rt FROM solicitudes_ret WHERE (exp LIKE 'RT-%')";
				$result=$conn->Execute($query);
	}
	else
	{
		if($solicitud_actual=='Reingreso')
		{
			$query="SELECT COUNT (exp) AS total_rt FROM solicitudes_rein WHERE (exp LIKE 'RCC-%')";
			$result=$conn->Execute($query);
		}
		else
		{
			if($solicitud_actual=='Reingreso_tg')
			{
				$query="SELECT COUNT (exp) AS total_rt FROM solicitudes_rein WHERE (exp LIKE 'RTG-%')";
				$result=$conn->Execute($query);
			}
			else
			{
				if($solicitud_actual=='Cambio')
				{
					$query="SELECT COUNT (exp) AS total_rt FROM solicitudes_cde WHERE (exp LIKE 'CE-%')";
					$result=$conn->Execute($query);
				}
			}
		}
	}	
	if($result==false)
	{
		echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{		

		while(!$result->EOF) 
		{	
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{							
				$cont=$result->fields['total_rt'];				
				$result->MoveNext();											
				break;												
			}
		}
	}

	if($solicitud_actual=='Retiro')
	{
		$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'RT-%')";
		$result=$conn->Execute($query);
	}
	else
	{
		if($solicitud_actual=='Reingreso')
		{
			$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'RCC-%')";
			$result=$conn->Execute($query);
		}
		else
		{
			if($solicitud_actual=='Reingreso_tg')
			{
				$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'RTG-%')";
			$result=$conn->Execute($query);
			}
			else
			{
				if($solicitud_actual=='Cambio')
				{
					$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'CE-%')";
			$result=$conn->Execute($query);
				}
			}
		}
	}	
	if($result==false)
	{
		echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{		

		while(!$result->EOF) 
		{	
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{							
				$cont=$result->fields['total_rt'];				
				$result->MoveNext();											
				break;												
			}			
		}
	} 
	$cont=$cont+1;

	$anio=substr($anio, -2);

	switch ($solicitud_actual)
	{
		case 'Retiro':
				if($aval=="Si")
				{
					$periodo=saber_periodo($anio,$fecha,$conn);
					$aval="RT-".$cont.".".$anio.".".$periodo;
					$query2="UPDATE solicitudes_ret SET exp='$aval' WHERE numero_soli= $numero_soli";
					$result=$conn->Execute($query2);
					if($result==false)
					{
						$bandera=0;
					}
					else
					{	
						$bandera=1;
					}
				}
				else
				{
					$aval="0";
					$query2="UPDATE solicitudes_ret SET exp='$aval' WHERE numero_soli= $numero_soli";
					$result=$conn->Execute($query2);
					if($result==false)
					{
						$bandera=0;
					}
					else
					{	
						$bandera=1;
					}
				}
		break;		
		case 'Cambio':
				if($aval=="Si")
				{
					$periodo=saber_periodo($anio,$fecha,$conn);
					$aval="CE-".$cont.".".$anio.".".$periodo;
					$query2="UPDATE solicitudes_cde SET exp='$aval' WHERE numero_soli= $numero_soli";
					$result=$conn->Execute($query2);
					if($result==false)
					{
						$bandera=0;
					}
					else
					{	
						$bandera=1;
					}	
				}
				else
				{
					$aval="0";		
					$query2="UPDATE solicitudes_cde SET exp='$aval' WHERE numero_soli= $numero_soli";
					$result=$conn->Execute($query2);
					if($result==false)
					{
						$bandera=0;
					}
					else
					{	
						$bandera=1;
					}	
				}
		break;

		case 'Reingreso':
				if($aval=="Si")
				{
					$periodo=saber_periodo($anio,$fecha,$conn);
					$aval="RCC-".$cont.".".$anio.".".$periodo;
					$query2="UPDATE solicitudes_rein SET exp='$aval' WHERE numero_soli= $numero_soli";
					$result=$conn->Execute($query2);
					if($result==false)
					{
						$bandera=0;
					}
					else
					{	
						$bandera=1;
					}	
				}
				else
				{
					$aval="0";
					$query2="UPDATE solicitudes_rein SET exp='$aval' WHERE numero_soli= $numero_soli";
					$result=$conn->Execute($query2);
					if($result==false)
					{
						$bandera=0;
					}
					else
					{	
						$bandera=1;
					}	

				}
			break;	
			case 'Reingreso_tg':
				if($aval=="Si")
				{
					$periodo=saber_periodo($anio,$fecha,$conn);
					$aval="RTG-".$cont.".".$anio.".".$periodo;
					$query2="UPDATE solicitudes_rein SET exp='$aval' WHERE numero_soli= $numero_soli";
					$result=$conn->Execute($query2);
					if($result==false)
					{
						$bandera=0;
					}
					else
					{	
						$bandera=1;
					}	
				}
				else
				{
					$aval="0";
					$query2="UPDATE solicitudes_rein SET exp='$aval' WHERE numero_soli= $numero_soli";
					$result=$conn->Execute($query2);
					if($result==false)
					{
						$bandera=0;
					}
					else
					{	
						$bandera=1;
					}	

				}
			break;			
	}
	return $bandera;

}

/*============================================================================================================================
					FUNCION PARA VER LA CANTIDAD DE SOLICITUDES REALIZADAS POR UN ESTUDIANTE EN LA BD DE MI TESIS
=============================================================================================================================*/

function cantidad_solicitud_historico($cedula,$proceso,$conn)
{	$cont=0;
	$query="SELECT * FROM decisiones WHERE ((cedula LIKE '%$cedula%') AND (solicitud_actual LIKE '%$proceso%'))";	
	$result=$conn->Execute($query);
	if($result==false)
	{
		echo "error al recuperar 3: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{
		while(!$result->EOF) 
		{					
			$cont++;
			$result->MoveNext();									
		}
			
	}
	return $cont;
	$conn->Close();
}

/*============================================================================================================================
					FUNCION PARA VER SI TIENE O NO SOLICITUDES EN LA BD DE MI TESIS
============================================================================================================================*/

function buscar_historico($cedula,$conn,$proceso)
{
	
	$query2="SELECT * FROM decisiones WHERE (cedula LIKE '%$cedula%') AND solicitud_actual LIKE '%$proceso%'";	
	$result=$conn->Execute($query2);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{		
				while(!$result->EOF) 
				{			
					for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
					{
						$solicitudes=$result->fields[5];					
						
					}
					if( $solicitudes==$proceso)
						{
							$solicitudes2=1;	
						}
						else
						{
							$solicitudes2=0;	
												
						}
					$result->MoveNext();
				}
				
	}	
	return $solicitudes2;
	$conn->Close();
}

/*============================================================================================================================
					FUNCION PARA VER LOS DATOS DEL ESTUDIANTE MIENTRAS SOLICITA ALGO
==============================================================================================================================*/

function mostrar_datos_para_solicitud($solicitud,$cedula,$fecha,$conn)
{
	$query2="SELECT * FROM estudiante WHERE ced LIKE '%$cedula%'";
	$result=$conn->Execute($query2);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{	
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$cedula=$result->fields[1];
				$nombre=$result->fields[3];
				$apellido=$result->fields[2];
				$nucleo=$result->fields['nucleo'];					
			
			}								
			$result->MoveNext();
		}
	}
	$query="SELECT especialidad FROM est_esp WHERE ced LIKE '%$cedula%'";
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{	
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$especialidad=$result->fields['especialidad'];					
			}								
			$result->MoveNext();
		}
	}
	$query1="SELECT per, ano FROM periodo WHERE '".$fecha."' BETWEEN f_inicio AND f_final ";
	$result=$conn->Execute($query1);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{	
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$periodo=$result->fields['per'];
				$anio=$result->fields['ano'];					
			}								
			$result->MoveNext();
		}
	}
	$estatus="Recibido";
?>	
	<form class="cbp-mc-form" name="Evaluar_estudiante" id="Evaluar_estudiante" action="motor_funciones.php" method="POST">
        <div class="cbp-mc-column">
         <!-- Inputs hiddens -->
        <input type="hidden" id="periodo" name="periodo" value="<?php echo $periodo ?>">
        <input type="hidden" id="anio" name="anio" value="<?php echo $anio ?>">
		<input type="hidden" id="especialidad" name="especialidad" value="<?php echo $especialidad ?>">
        <input type="hidden" id="nucleo" name="nucleo" value="<?php echo $nucleo ?>">
        <input type="hidden" id="solicitud" name="solicitud" value="<?php echo $solicitud ?>">
        <input type="hidden" id="estatus" name="estatus" value="<?php echo $estatus ?>">        
        <input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha ?>">
        <input type="hidden" id="Nombre" name="Nombre"  value="<?php echo $nombre; ?>">
        <input type="hidden" id="Apellido" name="Apellido"  value="<?php echo $apellido; ?>">
        <input type="hidden" id="cedula" name="cedula"  value="<?php echo $cedula; ?>">
        <!-- Inputs hiddens -->

        <label for="Nombre">Nombre</label>
        <input type="text" id="Nombre"  disabled value="<?php echo $nombre; ?>">
        <label for="Apellido">Apellido</label>
        <input type="text" id="Apellido"  disabled value="<?php echo $apellido; ?>">
        <label for="cedula">Cedula</label>
        <input type="text" id="cedula" disabled value="<?php echo $cedula; ?>">
        <?php if($solicitud=='Retiro'){ ?>
        
        
        <label>Razón</label>
        <select id="razon" name="razon">
        <?php 
			$query="SELECT * FROM razon_proceso WHERE (proceso LIKE '%$solicitud%')";	
			$result=$conn->Execute($query);
			if($result==false)
			{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
			else
			{	
				while(!$result->EOF) 
					{			
						for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
						{
							$razon=$result->fields[1];					
							
						}	
						?>
                        <option><?php echo $razon; ?> </option>
                        <?php					
						$result->MoveNext();
					}
			}
		
		?>
        
        </select>
        <?php }?>
        <?php if($solicitud=='Cambio' ){ ?>

         <label>Asignatura a optar</label>
        <select id="asignatura" name="asignatura">
        <?php 
			$query="SELECT * FROM esp";	
			$result=$conn->Execute($query);
			if($result==false)
			{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
			else
			{	
				while(!$result->EOF) 
					{			
						for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
						{
							$asignatura=$result->fields['nombre'];					
							
						}	
						?>
                        <option><?php echo $asignatura; ?> </option>
                        <?php					
						$result->MoveNext();
					}
			}
		
		?>
        
        </select>  
         <?php }?>     
         <div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" 
        value="Aceptar" /></div>
        

       </div>      
        
</form>	
<?php
$conn->Close();

}
/*============================================================================================================================
					FUNCION PARA CALCULA DIFERENCIA ENTRE DOS FECHAS
==============================================================================================================================*/
function date_diff1($date1, $date2) 
{ 
    $current = $date1; 
    $datetime2 = date_create($date2); 
    $count = 0; 
    while(date_create($current) < $datetime2)
	{ 
        $current = gmdate("Y-m-d", strtotime("+1 day",strtotime($current))); 
        $count++; 
    } 
    return $count; 
} 
/*============================================================================================================================
					FUNCION PARA CALCULAR LA FECHA DE HOY
==============================================================================================================================*/

function fecha_hoy()
{
	date_default_timezone_set("America/Caracas" ) ; 
	$tiempo = getdate(time()); 
	$dia = $tiempo['wday']; 
	$dia_mes=$tiempo['mday']; 
	$mes = $tiempo['mon']; 
	$year = $tiempo['year']; 
	$fecha=$dia_mes."-".$mes."-".$year;
	
return $fecha;
}

/*============================================================================================================================
					FUNCIONES PARA SABER QUE DÍA METIO LA SOLICITUD Y SI ESTA A TIEMPO O NO
==============================================================================================================================*/
function obtener_anio($fecha)
{
	$fecha1=substr($fecha,0,4);
	return $fecha1;

	/*date_default_timezone_set("America/Caracas"); 
	$tiempo = getdate(time());	
	$year = $tiempo['year'];
	$dia = $tiempo['wday']; 
	$dia_mes=$tiempo['mday']; 
	$mes = $tiempo['mon']; 
	$year = $tiempo['year']; 
	return $year;*/
}
/*============================================================================================================================
					FUNCION PARA SABER SI ESTÁ A TIEMPO O NO (RETIRO)
==============================================================================================================================*/
function tiempo_solicitud_retiro($anio,$fecha,$conn)
{
	$query="SELECT * FROM periodo WHERE (ano LIKE '%$anio%')";	
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$fecha_inicio_sem=$result->fields[3];
				$fecha_fin_sem=$result->fields[4];
				if(valida_fecha($fecha_inicio_sem, $fecha_fin_sem, $fecha))
				{
					$fecha_inicio_ret=$result->fields[14];
					$fecha_fin_ret=$result->fields[15];
				}
			}
			$result->MoveNext();
		}
	}	

	if(valida_fecha($fecha_inicio_ret, $fecha_fin_ret, $fecha)) 
	{
		$cant_dias='-1';
	}
	else
	{
		$cant_dias=date_diff1($fecha_fin_ret, $fecha);	
	}
	return $cant_dias;
	$conn->Close();
}
/*============================================================================================================================
					FUNCION PARA SABER SI ESTÁ A TIEMPO O NO (CDE)
==============================================================================================================================*/

function tiempo_solicitud_cde($anio,$fecha,$conn)
{
	$query="SELECT * FROM periodo WHERE (ano LIKE '%$anio%')";	
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$fecha_inicio_sem=$result->fields[3];
				$fecha_fin_sem=$result->fields[4];
				if(valida_fecha($fecha_inicio_sem, $fecha_fin_sem, $fecha))
				{
					$fecha_inicio_cde=$result->fields[12];
					$fecha_fin_cde=$result->fields[13];
				}
			}
			$result->MoveNext();
		}
	}	

	if(valida_fecha($fecha_inicio_cde, $fecha_fin_cde, $fecha)) 
	{
		$cant_dias='-1';
	}
	else
	{
		$cant_dias=date_diff1($fecha_fin_cde, $fecha);	
	}
	return $cant_dias;
	$conn->Close();
}
/*============================================================================================================================
					FUNCION PARA SABER SI ESTÁ A TIEMPO O NO (REINGRESO)
==============================================================================================================================*/

function tiempo_solicitud_reingreso($anio,$fecha,$conn)
{
	$query="SELECT * FROM periodo WHERE (ano LIKE '%$anio%')";	
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$fecha_inicio_sem=$result->fields[3];
				$fecha_fin_sem=$result->fields[4];
				if(valida_fecha($fecha_inicio_sem, $fecha_fin_sem, $fecha))
				{
					$fecha_inicio_ret=$result->fields[14];
					$fecha_fin_ret=$result->fields[15];
				}
			}
			$result->MoveNext();
		}
	}	

	if(valida_fecha($fecha_inicio_ret, $fecha_fin_ret, $fecha)) 
	{
		$cant_dias='-1';
	}
	else
	{
		$cant_dias=date_diff1($fecha_fin_ret, $fecha);	
	}
	return $cant_dias;
	$conn->Close();
}
/*============================================================================================================================
					FUNCION PARA SABER el periodo en el que se hace la solicitud
==============================================================================================================================*/

function saber_periodo($anio,$fecha,$conn)
{
	$query="SELECT * FROM periodo WHERE (ano LIKE '%$anio%')";	
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$fecha_inicio_sem=$result->fields[3];
				$fecha_fin_sem=$result->fields[4];
				if(valida_fecha($fecha_inicio_sem, $fecha_fin_sem, $fecha))
				{
					$periodo=$result->fields[1];
				}
			}
			$result->MoveNext();
		}
	}
	return $periodo;
	$conn->Close();
}
/*============================================================================================================================
					FUNCION DE COMPARACION DE FECHA
==============================================================================================================================*/
function valida_fecha($inicio, $fin, $validar) 
{ 
    if(strtotime($validar)>=strtotime($inicio) && strtotime($validar)<=strtotime($fin)) 
		return true; 
    else 
		return false; 
} 
/*============================================================================================================================
					FUNCION PARA TOMAR LA DECISION
==============================================================================================================================*/
function DECISION($fecha,$cedula,$razon,$nombre,$apellido,$discapacidad,$promedio,$solicitudes,$solicitud_actual,$aval,$cant_soli,$periodo,$conn)
{		
	$query="SELECT * FROM razon_proceso WHERE (proceso LIKE '%$solicitud_actual%') AND (razon LIKE '%$razon%')";
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
		
	}	
	else
	{
		$fecha_solicitud=$fecha;
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$puntaje=$result->fields[2];
				$porcentaje=$result->fields[3]/100;
			}
			$result->MoveNext();
		}		
		$aprobado_temp=0;
		$reprobado_temp=0;
		
		//Aquí comienza la fiesta xD CONDICIONALES
		//aval
		if($aval=='Si')
		{
			$aprobado_temp=$aprobado_temp+($puntaje*$porcentaje);
			$razon_aval="Presentó aval por la razon";	
		}
		else
		{
			$reprobado_temp=$reprobado_temp+($puntaje*$porcentaje);
			$razon_aval="No pesentó aval por la razon";
		}
		//tiempo de solicitud
		if($periodo==-1)
		{
			$tiempo_soli="Ingresó el retiro en el periodo estipulado";
			$aprobado_temp=$aprobado_temp+($puntaje*$porcentaje);
		}
		else
		{
			$tiempo_soli="No ingresó el retiro en el periodo estipulado, lo ingresó ".$periodo." días tarde";
			$reprobado_temp=$reprobado_temp+($puntaje*$porcentaje);
			
		}
		//normas de repitencia
		
		$medidas=0;
		$query2="SELECT * FROM medidas_academicas WHERE cedula LIKE '%$cedula%'";
		$result=$conn->Execute($query2);
		if($result==false)
		{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
			
		}	
		else
		{
			while(!$result->EOF) 
			{			
				$medidas=1;
				$result->MoveNext();
			}			
		}
		if($medidas==0)
		{
			$medidas_resul="No tiene medidas";
			$aprobado_temp=$aprobado_temp+($puntaje*$porcentaje);
		}
		else
		{
			$medidas_resul="Tiene medidas";
			$reprobado_temp=$reprobado_temp+($puntaje*$porcentaje);	
		}
	
		//Retiros Anteriores
		if($cant_soli>0 && $cant_soli==1)
		{	
			//se le da el beneficio de la duda
			$aprobado_temp=$aprobado_temp+(($puntaje/2)*$porcentaje);
			$solicitudes_anteriores="Tiene 1 solicitud anterior, se le da el beneficio de la duda";
		}
		else
		{
			if($cant_soli>1)
			{
				//esta evadiendo responsabilidad y se le castiga por eso
				$reprobado_temp=$reprobado_temp+($puntaje*$porcentaje);	
				$solicitudes_anteriores="Tiene ".$cant_soli." solicitudes anteriores, se considera evasion de responsabilidad";
			}
			else
			{
				$aprobado_temp=$aprobado_temp+($puntaje*$porcentaje);
				$solicitudes_anteriores="No tiene solicitudes anteriores";	
			}
		}
		
	}
	//Prosecucion académica
	if($promedio>5 || $promedio==5)
	{
		$aprobado_temp=$aprobado_temp+($puntaje*$porcentaje);
		$pros_aca="Tiene promedio positivo, ".$promedio."/10";
	}
	else
	{
		$reprobado_temp=$reprobado_temp+($puntaje*$porcentaje);
		$pros_aca="Tiene promedio negativo, ".$promedio."/10";
	}
	
	if($aprobado_temp>$reprobado_temp)
	{
		$decision="Aprobada";	
	}
	else
	{
		if($aprobado_temp<$reprobado_temp)
		{
			$decision="Reprobada";
		}	
		else
		{
			if($aprobado_temp==$reprobado_temp)
			{
				$decision="Indefinida";
			}	
		}
	}

	$query3="SELECT * FROM solicitudes_ret WHERE (cedula LIKE '%$cedula%' AND fecha_solicitud = '%$fecha_solicitud%')";
		$result=$conn->Execute($query3);
		if($result==false)
		{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
			
		}	
		else
		{
			while(!$result->EOF) 
			{
				for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
				{
					$exp=$result->fields[5];
				}
				$result->MoveNext();
			}
		}

	mostrar_decision($exp,$fecha_solicitud,$cedula,$pros_aca,$razon,$solicitud_actual,$decision,$solicitudes_anteriores,$medidas_resul,$tiempo_soli,$razon_aval,$conn);
	$conn->Close();
}
/*============================================================================================================================																																								                                            
FUNCION PARA MOSTRAR LAS DECISIONES 	
======================================================================================================================*/

function mostrar_decision($exp,$fecha_solicitud,$cedula,$pros_aca,$razon,$solicitud_actual,$decision,$solicitudes_anteriores,$medidas_resul,$tiempo_soli,$razon_aval,$conn)
{
	$query2="SELECT * FROM estudiante WHERE ced LIKE '%$cedula%'";
	$result=$conn->Execute($query2);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{	
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$cedula=$result->fields[1];
				$nombre=$result->fields[3];
				$apellido=$result->fields[2];				
			
			}								
			$result->MoveNext();
		}
	}
	
?>		
	<form class="col s12" id="decision" action="../procesos/motor_funciones.php" method="POST">
           	        <input type="hidden" id="fecha_solicitud" name="fecha_solicitud" value="<?php echo $fecha_solicitud; ?>">
        			<input type="hidden" id="nombre" name="nombre"  value="<?php echo $nombre; ?>">
					<input type="hidden" id="exp" name="exp"  value="<?php echo $exp; ?>">
			        <input type="hidden" id="cedula" name="cedula"  value="<?php echo $cedula; ?>">
			        <input type="hidden" id="solicitud" name="solicitud" value="<?php echo $solicitud_actual ?>">
			        <input type="hidden" id="razon" name="razon" value="<?php echo $razon ?>">
			        <input type="hidden" id="fecha" name="fecha" value="<?php echo $tiempo_soli ?>">
			        <input type="hidden" id="soli_ant" name="soli_ant"  value="<?php echo $solicitudes_anteriores; ?>">
			        <input type="hidden" id="promedio" name="promedio"  value="<?php echo $pros_aca; ?>">
			        <input type="hidden" id="medidas" name="medidas"  value="<?php echo $medidas_resul; ?>">
			        <input type="hidden" id="aval" name="aval" value="<?php echo $razon_aval ?>"> 
			        <input type="hidden" id="decision" name="decision" value="<?php echo $decision ?>">

                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $nombre." ".$apellido ; ?>">
                            <label>El estudiante: </label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input disabled type="text" class="validate" value="<?php echo $cedula?>">
                            <label >Portador de la cedula: </label>
                        </div>
                     </div>
                     <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $solicitud_actual ?>">
                            <label >Quien ha solicitado un: </label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $razon ?>">
                            <label>A razon de: </label>
                        </div>
                     </div>
                     <div class="row">
                        <div class="input-field col s12 m6">
                            <input  type="text" class="validate" disabled value="<?php echo $tiempo_soli ?>">                            
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $solicitudes_anteriores; ?>">                            
                        </div>
                     </div>
                     <div class="row">
                        <div class="input-field col s12 m6">
                            <input disabled type="text" class="validate" value="<?php echo $pros_aca; ?>">                            
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $medidas_resul; ?>">                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $razon_aval ?>">
                            <label>Y </label>
                        </div>
                        <div class="input-field col s12 m6 ">
                            <input disabled type="text" class="validate" value="<?php echo $decision ?>">
                            <label >Por lo tanto, mediante la aplicación del maximo valor esperado, su solicitud esta: </label>
                        </div>
                    </div>
                    <div class="row">
                         <?php
							If($decision=="Aprobada" || $decision=="Reprobada")
							{
							?>  							        
							    <div class="input-field col s12 m6">             
		                          <select class="browser-default" id="acuerdo" name="acuerdo">
		                            <option value="" disabled selected>¿Está de acuerdo con la decisión?</option>
		                            <option value="Si">Si</option>
		                            <option value="No">No</option>                            
		                          </select>
		                		</div>
							<?php
							}
							else
							{
									If($decision=='Indefinida')
									{
							?>   
								<div class="input-field col s12 m6"> 
							        <select class="browser-default" id="decision" name="decision">
							        <option value="" disabled selected>Ya que el sistema no pudo decidir, tome la decision usted </option>>
							        <option value="Aprobado">Aprobado</option>
							        <option value="Reprobado">Reprobado</option>
							        </select> 
							    </div>

							<?php
							}
							}
							?> 
                    
				        <div class="input-field col s12 m6 ">
				          <textarea id="observaciones" name="observaciones" class="materialize-textarea"></textarea>
				          <label for="observaciones">Observaciones</label>
				        </div>
				      </div>
                   </div>    
                    <div class="divider"></div>
                    <div class="row">                       
                        <div class="col m12">
                            <p class="center-align">
                                <button class="btn btn-large waves-effect waves-light" id="crear" type="submit" value="ingresar_historico" name="accion" title="login">DECISION</button>
                            </p>
                        </div>
                        
                    </div>
        </form> 
	
		<form class="col s12" id="decision" action="../llamadas/antecedentes.php" method="POST" target="_blank">
           	        <input type="hidden" id="fecha_solicitud" name="fecha_solicitud" value="<?php echo $fecha_solicitud; ?>">
        			<input type="hidden" id="nombre" name="nombre"  value="<?php echo $nombre; ?>">
					<input type="hidden" id="exp" name="exp"  value="<?php echo $exp; ?>">
			        <input type="hidden" id="cedula" name="cedula"  value="<?php echo $cedula; ?>">
			        <input type="hidden" id="solicitud" name="solicitud" value="<?php echo $solicitud_actual ?>">
			        <input type="hidden" id="razon" name="razon" value="<?php echo $razon ?>">
			        <input type="hidden" id="fecha" name="fecha" value="<?php echo $tiempo_soli ?>">
			        <input type="hidden" id="soli_ant" name="soli_ant"  value="<?php echo $solicitudes_anteriores; ?>">
			        <input type="hidden" id="promedio" name="promedio"  value="<?php echo $pros_aca; ?>">
			        <input type="hidden" id="medidas" name="medidas"  value="<?php echo $medidas_resul; ?>">
			        <input type="hidden" id="aval" name="aval" value="<?php echo $razon_aval ?>"> 
			        <input type="hidden" id="decision" name="decision" value="<?php echo $decision ?>">
			        <div class="row">
				     	<div class="col m12">
	                            <p class="center-align">
	                                <button class="btn btn-large waves-effect waves-light" id="crear" type="submit" value="mostrar_valores_iguales" name="accion"  title="login">ANTECEDENTES</button>
	                            </p>
	                    </div>
	                </div>
        </form> 
<?php
$conn->Close();
}

/*============================================================================================================================	
                                FUNCION PARA CREAR UNA CUENTA NUEVA   	
======================================================================================================================*/
function crear_cuenta($cedula,$nombre,$apellido,$sexo,$usuario,$contraseña,$privilegios,$conn)
{	
	$privilegios2=$privilegios;
	if($privilegios2==1)
	{
		$privilegios="OverNineThousand";
		$privilegios=sha1(md5($privilegios));	
	}
	else
	{
		$privilegios="Normal";
		$privilegios=sha1(md5($privilegios));
	}
	$contraseña=sha1(md5($contraseña));
	$query="INSERT INTO users (cedula, pass, nivel_priv, nombre, apellido, usuario, sexo) VALUES ('$cedula', '$contraseña', '$privilegios', '$nombre', '$apellido', '$usuario', '$sexo')";	
	$result=$conn->Execute($query);
	if($result==false)
	{
		$bandera="0";
	}	
	else
	{
		$bandera="1";	
	}
	return($bandera);
	$conn->Close();
}
/*============================================================================================================================
FUNCION PARA INGRESAR NUEVAS RAZONES   	
======================================================================================================================*/
function ingresar_razon($proceso,$razon,$puntaje,$porcentaje,$fecha,$conn)
{
	$query="INSERT INTO razon_proceso (proceso, razon, puntaje, fecha) VALUES ('$proceso', '$razon', '$puntaje', '$fecha')";	
	$result=$conn->Execute($query);
	if($result==false)
	{
		$bandera="2";
	}	
	else
	{
		$bandera="3";	
	}
	return($bandera);
	$conn->Close();
}

/*============================================================================================================================	
FUNCION PARA MOSTRAR LOS PUNTAJES DE LAS RAZONES   	
======================================================================================================================*/
function mostrar_puntaje($proceso,$conn)
{//$proceso="Retiro";
	if($proceso=="Cambio de Especialidad")
	{$proceso="Cambio";}
	$query="SELECT * FROM razon_proceso WHERE proceso LIKE '%$proceso%'";	
	$result=$conn->Execute($query);
	if($result==false)
	{
		echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{		
		$j=0;
		while(!$result->EOF) 
		{	
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{	
				$proceso=$result->fields['proceso'];						
				$razon=$result->fields['razon'];
				$puntaje=$result->fields['puntaje'];							
				$puntaje2=base64_encode($puntaje);
				$razon2=base64_encode($razon);
				$proceso2=base64_encode($proceso);
				$link="<a href=\"cambio_valores.php?proceso=".$proceso2."&razon=".$razon2."&puntaje=".$puntaje2."\" target='_blank'>Evaluar</a>";						
				$result->MoveNext();											
				break;												
			}
			$data[$j]=array("proceso"=>$proceso,
							"razon"=> $razon,
							"puntaje"=> $puntaje,
							"opcion"=>$link);
			$j++;
		} 
		header('Content-type: application/json');
		return json_encode($data);
	}
	$conn->Close();
}
/*============================================================================================================================	
								FUNCION PARA CAMBIAR LOS PUNTAJES DE LAS RAZONES 1 	
======================================================================================================================*/
function cambiar_valor_TDD($proceso,$razon,$puntaje,$conn)
{	
	if($proceso=="Cambio de especialidad")
	{$proceso="Cambio";}
	$query="SELECT * FROM razon_proceso WHERE proceso LIKE '%$proceso%' AND razon LIKE '%$razon%'";
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{	
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$proceso2=$result->fields[0];
				$razon=$result->fields[1];
				$puntaje=$result->fields[2];				
			
			}								
			$result->MoveNext();
		}
	}
	$fecha=fecha_hoy();
?>	

<form class="col s12" id="cambiar_valor_TDD" action="../procesos/motor_funciones.php" method="POST">
           	        <input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha ?>">
	       			<input type="hidden" id="proceso" name="proceso" value="<?php echo $proceso ?>">
	       			<input type="hidden" id="razon" name="razon" value="<?php echo $razon ?>">
                    <div class="row">
                        <div class="input-field col s12 m6 offset-m3">
                            <input id="proceso" type="text" disabled class="validate" value="<?php echo $proceso ?>">
                            <label for="proceso">Proceso</label>
                        </div>
                        <div class="input-field col s12 m6 offset-m3">
                            <input id="usuario" disabled type="text" class="validate" value="<?php echo $razon ?>">
                            <label for="usuario">Razón</label>
                        </div>
                         <div class="input-field col s12 m6 offset-m3">
                            <select class="browser-default" id="puntaje" name="puntaje">
                              <option value="" disabled selected>Elija el Puntaje</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>                              
                            </select>
                         </div>       
                    </div>                
                    <div class="divider"></div>
                    <div class="row">                       
                        <div class="col m12 offset">
                            <p class="center-align">
                                <button class="btn btn-large waves-effect waves-light" id="crear" type="submit" value="actualizar_puntaje" name="accion" title="login">Actualizar</button>
                            </p>
                        </div>
                    </div>
        </form>  

<?php
$conn->Close();
}
/*============================================================================================================================	
FUNCION PARA CAMBIAR LOS PUNTAJES DE LAS RAZONES 2  	
======================================================================================================================*/
function actualizar_puntaje($proceso,$razon,$puntaje,$fecha,$conn)
{
	$query="UPDATE razon_proceso SET proceso='$proceso', razon='$razon', puntaje='$puntaje', fecha='$fecha' WHERE ((proceso LIKE '%$proceso%') AND (razon LIKE '%$razon%'))";
	$result=$conn->Execute($query);
	if($result==false)
	{
		$bandera=0;}
	else
	{	
		$bandera=1;
	}
	return $bandera;
	$conn->Close();
}
/*============================================================================================================================
 FUNCION PARA INGRESAR EN LA BASE DE DATOS HISTORICA  	
 ======================================================================================================================*/

function ingresar_historico($exp,$cedula,$fecha_solicitud,$razon,$promedio,$solicitudes,$solicitud_actual,$aval,$fecha,$medidas,$decision,$observaciones,$acuerdo,$conn)
{	$anio=obtener_anio($fecha_solicitud);
	if($acuerdo=='No')
	{
		if($decision=="Aprobado")
		{
			$decision="Reprobado";	
		}
		else
		{
			$decision="Aprobado";
		}
	}	
	if($exp=='0')
	{
		if($solicitud_actual=='Retiro')
		{
			$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'RT-%')";
			$result=$conn->Execute($query);
		}
		else
		{
			if($solicitud_actual=='Reingreso')
			{
				$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'RCC-%')";
				$result=$conn->Execute($query);
			}
			else
			{
				if($solicitud_actual=='Reingreso_tg')
				{
					$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'RTG-%')";
					$result=$conn->Execute($query);
				}
				else
				{
					if($solicitud_actual=='Cambio')
					{
						$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'CE-%')";
						$result=$conn->Execute($query);
					}
				}
			}
		}	
		if($result==false)
		{
			echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
		}
		else
		{		

			while(!$result->EOF) 
			{	
				for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
				{							
					$cont=$result->fields['total_rt'];				
					$result->MoveNext();											
					break;												
				}
				
				
			}
		} 
		if($solicitud_actual=='Retiro')
		{
			$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'RT-%')";
			$result=$conn->Execute($query);
		}
		else
		{
			if($solicitud_actual=='Reingreso')
			{
				$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'RCC-%')";
				$result=$conn->Execute($query);
			}
			else
			{
				if($solicitud_actual=='Reingreso_tg')
				{
					$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'RTG-%')";
					$result=$conn->Execute($query);
				}
				else
				{
					if($solicitud_actual=='Cambio')
					{
						$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'CE-%')";
						$result=$conn->Execute($query);
					}
				}
			}
		}	
		if($result==false)
		{
			echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
		}
		else
		{		

			while(!$result->EOF) 
			{	
				for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
				{							
					$cont=$result->fields['total_rt'];				
					$result->MoveNext();											
					break;												
				}				
				
			}
		} 
		$cont=$cont+1;
		$anio=substr($anio, -2);
		switch ($solicitud_actual)
		{
			case 'Retiro':					
						$periodo=saber_periodo($anio,$fecha,$conn);
						$aval1="RT-".$cont.".".$anio.".".$periodo;
						$query2="UPDATE solicitudes_ret SET exp='$aval1' WHERE numero_soli= $numero_soli";
						$result=$conn->Execute($query2);
						if($result==false)
						{
							$bandera=0;
						}
						else
						{	
							$bandera=1;
						}					
			break;		
			case 'Cambio':
						$periodo=saber_periodo($anio,$fecha,$conn);
						$aval1="CE-".$cont.".".$anio.".".$periodo;
						$query2="UPDATE solicitudes_cde SET exp='$aval1' WHERE numero_soli= $numero_soli";
						$result=$conn->Execute($query2);
						if($result==false)
						{
							$bandera=0;
						}
						else
						{	
							$bandera=1;
						}	
					
			break;
			case 'Reingreso':
						$periodo=saber_periodo($anio,$fecha,$conn);
						$aval1="RCC-".$cont.".".$anio.".".$periodo;
						$query2="UPDATE solicitudes_rein SET exp='$aval1' WHERE numero_soli= $numero_soli";
						$result=$conn->Execute($query2);
						if($result==false)
						{
							$bandera=0;
						}
						else
						{	
							$bandera=1;
						}	
					
			break;	
				case 'Reingreso_tg':
						$periodo=saber_periodo($anio,$fecha,$conn);
						$aval1="RTG-".$cont.".".$anio.".".$periodo;
						$query2="UPDATE solicitudes_rein SET exp='$aval1' WHERE numero_soli= $numero_soli";
						$result=$conn->Execute($query2);
						if($result==false)
						{
							$bandera=0;
						}
						else
						{	
							$bandera=1;
						}						
				break;	

		}
	}
	else
	{
		$aval1=$exp;
	}	
	$query= "INSERT INTO decisiones (cedula, fecha_solicitud, razon, promedio, solicitudes, solicitud_actual, aval, medidas, tiempo_sol, decision, observaciones, acuerdo, exp) VALUES ('$cedula', '$fecha_solicitud', '$razon', '$promedio', '$solicitudes', '$solicitud_actual', '$aval', '$medidas', '$fecha', '$decision', '$observaciones', '$acuerdo', '$aval1')"; 
	if($conn->Execute($query)==false)
	{
		$bandera=1;
		echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{
		$bandera=0;
		if($solicitud_actual =='Retiro')
		{
			$query2= "DELETE FROM solicitudes_ret WHERE proceso LIKE '%$solicitud_actual%' AND fecha_solicitud='%$fecha_solicitud%' AND cedula LIKE '%$cedula%' AND exp LIKE '%$exp%'"; 
			if($conn->Execute($query2)==false)
			{
				echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
			}
		}
		else
		{
			if(($solicitud_actual =='Reingreso')||($solicitud_actual =='Reingreso_tg'))
			{
				$query2= "DELETE FROM solicitudes_ret WHERE proceso LIKE '%$solicitud_actual%' AND fecha_solicitud='%$fecha_solicitud%' AND cedula LIKE '%$cedula%' AND exp LIKE '%$exp%'"; 
				if($conn->Execute($query2)==false)
				{
					echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
				}
			}
			else
			{
				$query2= "DELETE FROM solicitudes_cde WHERE fecha_solicitud='%$fecha_solicitud%' AND cedula LIKE '%$cedula%' AND exp LIKE '%$exp%'"; 
				if($conn->Execute($query2)==false)
				{
					echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
				}
			}
		}
	}
	
	
return $bandera;
$conn->Close();
}
/*===========================================================================================================================
 FUNCION PARA CERRAR LA SESSION
 ======================================================================================================================*/
function cerrar_sesion()
{
	session_start();
	session_destroy();
	header("location: ../index.php"); 

}

/*===========================================================================================================================
 FUNCION PARA VISUALIZAR ANTIGUAS DECISIONES	
 ======================================================================================================================*/

function estudiar_decision($fecha,$cedula,$solicitud,$conn)
{

	$query2="SELECT * FROM estudiante WHERE ced LIKE '%$cedula%'";
	$result=$conn->Execute($query2);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{	
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$nombre=$result->fields[3];
				$apellido=$result->fields[2];				
			
			}								
			$result->MoveNext();
		}
	}

	$query="SELECT * FROM decisiones WHERE (cedula LIKE '%$cedula%' AND fecha_solicitud LIKE '%$fecha%' AND solicitud_actual LIKE '%$solicitud%')";
	$result=$conn->Execute($query);
	if($result==false)
	{echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;}
	else
	{	
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$tiempo_soli=$result->fields[8];
				$solicitud_actual=$result->fields[5];
				$razon=$result->fields[2];
				$solicitudes_anteriores=$result->fields[4];	
				$pros_aca=$result->fields[3];
				$medidas_resul=$result->fields[7];		
				$aval=$result->fields[6];
				$decision=$result->fields[9];
				$observaciones=$result->fields[10];
				$acuerdo=$result->fields[11];
			}								
			$result->MoveNext();
		}
	}
	
?>		
		<form class="col s12" id="decision" method="POST">           	        
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $nombre." ".$apellido ; ?>">
                            <label>El estudiante: </label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input disabled type="text" class="validate" value="<?php echo $cedula?>">
                            <label >Portador de la cedula: </label>
                        </div>
                    </div>
                   	<div class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $solicitud_actual ?>">
                            <label >Quien ha solicitado un: </label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $razon ?>">
                            <label>A razon de: </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input  type="text" class="validate" disabled value="<?php echo $tiempo_soli ?>">                            
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $solicitudes_anteriores; ?>">                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input disabled type="text" class="validate" value="<?php echo $pros_aca; ?>">                            
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $medidas_resul; ?>">                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" class="validate" disabled value="<?php echo $aval ?>">
                            <label>Y </label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input disabled type="text" class="validate" value="<?php echo $decision ?>">
                            <label >Por lo tanto, mediante la aplicación del maximo valor esperado, su solicitud esta: </label>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input disabled type="text" class="validate" value="<?php echo $acuerdo ?>">
                            <label >¿El coordinador estuvo de acuerdo?: </label>
                        </div>                                             
                        <div class="input-field col s12 m6">
				          <textarea id="observaciones" disabled name="observaciones" class="materialize-textarea"><?php echo $observaciones ?></textarea>
				          <label for="observaciones">Observaciones</label>
				        </div>
				    </div>  
				    <div class="col m12 offset">
                            <p class="center-align">
                                <button class="btn btn-large waves-effect waves-light" id="cerrar" onClick="myFunction()" >Aceptar</button>
                            </p>
                    </div>                                    
        </form> 
		<script>
            function myFunction() {
                window.close();
            }
        </script>
<?php
$conn->Close();
}

/*===================================================================================================================================================
														FUNCION para mostrar solicitudes distintas
=====================================================================================================================================================*/
function visualizar_antecedentes($razon,$promedio,$solicitudes,$solicitud_actual,$aval,$tiempo_sol,$medidas,$conn)
{	

			$tiempo_sol=substr($tiempo_sol,0,20);
			$solicitudes=substr($solicitudes,32);
			$query="SELECT * FROM decisiones WHERE (tiempo_sol LIKE '$tiempo_sol%' AND aval LIKE '%$aval%' AND razon LIKE '%$razon%' AND solicitudes LIKE '%$solicitudes' AND medidas LIKE '%$medidas%' AND solicitud_actual LIKE '%$solicitud_actual%' AND promedio LIKE '%$promedio%')";	
			$result=$conn->Execute($query);		
			if($result==false)
			{
				echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
			}
			else
			{	$j=0;
				while(!$result->EOF) 
				{			
					for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
					{
							$cedula=$result->fields[0];
							$fecha=$result->fields[1];					
							$solicitud=$result->fields[5];
							$razon=$result->fields[2];	
							$resultado=$result->fields[9];
							$link="<a href=\"estudiar_historico.php?id=".$cedula."&soli=".$solicitud."&fecha=".$fecha."\" target='_blank'>Evaluar</a>";							
							$result->MoveNext();											
							break;	
					}					
					$data[$j]=array("cedula"=>$cedula,
									"solicitud"=> $solicitud,
									"fecha"=>$fecha,
									"razon"=> $razon,
									"resultado"=>$resultado,
									"link"=>$link);
					$j++;									
				}
				header('Content-type: application/json');
				return json_encode($data);
			
			}
				$conn->Close();			
}
/*=================================================================================================================================
								CALCULAR GRUPO
===================================================================================================================================*/
function evaluar_reingreso($cedula, $razon, $fecha, $conn)
{
	$query="SELECT COUNT(*) cont FROM notas WHERE ((per = '1') OR (per = '2')) AND cedula = '".$cedula."' ";
	$result = $conn->Execute($query);
	if($result==false)
	{
		echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{
		while(!$result->EOF) 
		{			
			for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
			{
				$cont=$result->fields[0];
				$result->MoveNext();											
				break;	
			}
		}
	}
	$query2="SELECT SUM(to_number(substr((A.asignatura),7,1),'9')) credito, B.credito_titulo total_credito from notas as A, esp as B 
	WHERE (A.nota > '4' AND 
	A.cedula = '".$cedula."' AND 
	A.especialidad = B.codigo) GROUP BY B.credito_titulo";
	$result2 = $conn->Execute($query2);
	if($result2==false)
	{
		echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{
		while(!$result2->EOF) 
		{			
			for ($i=0, $max=$result2->FieldCount(); $i<$max; $i++)
			{
				$creditos_apro=$result2->fields[0];
				$result2->MoveNext();											
				break;	
			}
		}
	}
	
}
/*=================================================================================================================================
					SABER QUE ESTUDIA UN ESTUDIANTE
==================================================================================================================================*/

function buscar_carrera($cedula,$conn)
{
	$query="SELECT especialidad FROM est_esp where cedula='".$cedula."'";
	$result=$conn->Execute($query);
	if($result==false)
	{
		echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{	
		return $result;
	}
}

/*===================================================================================================================================
								FUNCION PARA LA CARGA DE SOLICITUDES DE LA TABLA SOLICITUD A LAS DE LA TESIS
===================================================================================================================================*/
function cargar_solicitudes($proceso,$conn)
{
	switch($proceso){
	case 'retiro':
		$query="SELECT solicitudes.* FROM solicitudes, solicitudes_ret
			WHERE (solicitudes.fecha <> solicitudes_ret.fecha_solicitud AND  
			solicitudes.cedula = solicitudes_ret.cedula AND 
			solicitudes.estatus = 'aprobado') OR
			(solicitudes.fecha <> solicitudes_ret.fecha_solicitud AND  
			solicitudes.cedula <> solicitudes_ret.cedula AND 
			solicitudes.estatus = 'aprobado') ";
	break;
	case 'reingreso':
		$query="SELECT solicitudes.* FROM solicitudes, solicitudes_rein
			WHERE (solicitudes.fecha <> solicitudes_rein.fecha_solicitud AND  
			solicitudes.cedula = solicitudes_rein.cedula AND 
			solicitudes.estatus = 'aprobado') OR
			(solicitudes.fecha <> solicitudes_rein.fecha_solicitud AND  
			solicitudes.cedula <> solicitudes_rein.cedula AND 
			solicitudes.estatus = 'aprobado')";
	break;
	case 'cambio':
		$query="SELECT solicitudes.* FROM solicitudes, solicitudes_cde
			WHERE (solicitudes.fecha <> solicitudes_cde.fecha_solicitud AND  
			solicitudes.cedula = solicitudes_cde.cedula AND 
			solicitudes.estatus = 'aprobado') OR
			(solicitudes.fecha <> solicitudes_cde.fecha_solicitud AND  
			solicitudes.cedula <> solicitudes_cde.cedula AND 
			solicitudes.estatus = 'aprobado')";			
	break;
	}
	$result  = $conn->Execute($query);
	if($result==false)
	{
		echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
	}
	else
	{	
		if($proceso=='Retiro')
		{
			while(!$result->EOF) 
				{			
					for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
					{				
						$cedula=$result->fields['cedula'];
						$razon=$result->fields['observacion'];
						$fecha_sol=$result->fields['fecha'];
						$exp='-1';
						$proceso='Retiro';
						$result->MoveNext();											
						break;	
					}
				}	
		}
		if($proceso=='Reingreso')
		{							
				while(!$result->EOF) 
				{			
					for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
					{		
						$cedula=$result->fields['cedula'];
						$fecha_sol=$result->fields['fecha'];
						$cedula='-1';
						$proceso='Reingreso';
						$result->MoveNext();											
						break;	
					}
				}
		}			
		if($proceso=='Cambio')
		{
				while(!$result->EOF) 
				{			
					for ($i=0, $max=$result->FieldCount(); $i<$max; $i++)
					{
						$cedula=$result->fields['cedula'];
						$carrera_pedi=$result->fields['observacion'];
						$fecha_sol=$result->fields['fecha'];
						$exp='-1';
						$result->MoveNext();											
						break;	
					}						
				}
				$carrera_act=buscar_carrera($cedula,$conn);		
		}		
	}
	$conn->Close();

}

?>
