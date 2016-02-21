<?php
	
	include('../config.php');

			$query="SELECT COUNT (exp) AS total_rt FROM decisiones WHERE (exp LIKE 'RT-%')";
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
						$cont=$result->fields['total_rt'];				
						$result->MoveNext();											
						break;												
					}
					
					
				}
			} 
			echo $cont;
				
?>