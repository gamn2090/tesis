			$(document).ready(function){
				carga("retiros.php");		
			
				/*$("#inicio").click(function(event){
					carga("procesos/llamada_face.php");
				});				
				$("#retiros").click(function(){
					carga("retiros.php");					
				});				
				$("#reingresos").click(function(){
				carga("reingreso.php");					
				});				
				$("#CDE").click(function(){
				carga("cambio_especialid.php");					
				});				
				$("#crear_cuenta").click(function(event){
					carga("crear_cuenta.php");
				});				
				$("#CVTDR").click(function(event){
					carga("llamada_retiro.php");
				});
				$("#CVTDRE").click(function(event){
					carga("llamada_reingreso.php");
				});
				$("#CVTDCDE").click(function(event){
					carga("llamada_CDE.php");
				});				
				$("#nuevas_razones").click(function(event){
					carga("nueva_razon.php");
				});*/

				$("#retiros").on('click', function() {

					var url = this.attr('data-url');
					carga(url);

				})
			});			
			function carga(pagina){
				console.log("entre");
				console.log(pagina);
				$("#principal").load(pagina);
				console.log("hecho");				
			};

