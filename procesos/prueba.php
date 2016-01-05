<?php
	
	include('../config.php');

			$query="SELECT * FROM solicitudes WHERE (proceso LIKE '%Retiro%')";
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
						$cedula=$result->fields[0];
						$numero_sol=$result->fields[1];
						$razon=$result->fields[2];	
						$link="<a href=\"/evaluar.php?id=".$cedula."&numero=".$numero_sol."\" target='_blank'>Evaluar</a>";						
						$result->MoveNext();											
						break;												
					}
					$data[$j]=array("cedula"=>$cedula,
									"numero"=> $numero_sol,
									"razon"=> $razon,
									"link"=>$link);
					$j++;
					
				}
			} 
				//header('Content-type: application/json');
				echo json_encode($data);
?>