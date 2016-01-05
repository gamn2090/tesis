<?php	
include "config.php";			
			
			$query2="SELECT * FROM solicitudes WHERE proceso LIKE '%Retiro%'";
			$result2=$conn->Execute($query2);			
			if($result2==false)
			{
				echo "error al recuperar: ".$conn->ErrorMsg()."<br>" ;
			}
			else
			{	
				//$data = array();
			   	$j=0;		 

				while(!$result2->EOF) 
				{	
					for ($i=0, $max=$result2->FieldCount(); $i<$max; $i++)
					{							
						$cedula=$result2->fields[0];
						$numero_sol=$result2->fields[1];
						$razon=$result2->fields[2];	
						$link="<a href=\"evaluar.php?id=".$cedula."&numero=".$numero_sol."\" target='_blank'>Evaluar</a>";						
						$result2->MoveNext();											
						break;												
					}
					$data[$j]=array("cedula"=>$cedula,
									"numero"=> $numero_sol,
									"razon"=> $razon,
									"link"=>$link);
					$j++;
					
				} 
				header('Content-type: application/json');
				echo json_encode($data);
			}
?>