$(document).ready(function(){
  $('.parallax').parallax();
  $(".button-collapse").sideNav();
  $('.slider').slider({full_width: true});
  $('ul.tabs').tabs();
  $(".button-collapse").sideNav();
  $('select').material_select();
  carga("historico.php");
  carga2("crear_cuenta.php");	

			
//--------------------------Procesos---------------------------------------------------------				
				
				$("#historico").on('click', function() {
					var url = $(this).attr('data-url');
					carga(url);
					$("#imagen").attr("src","../img/historico.jpg");
					$('#nombre').html('HISTORICO DE DECISIONES');
				})

				$("#retiros").on('click', function() {
					var url = $(this).attr('data-url');
					carga(url);
					$("#imagen").attr("src","../img/retiro.jpg");
					$('#nombre').html('RETIROS ACADÉMICOS');
				})						

				$("#reingresos").on('click', function() {
					var url = $(this).attr('data-url');
					carga(url);
					$("#imagen").attr("src","../img/reingreso.png");
					$('#nombre').html('REINGRESOS ACADÉMICOS');
				})				

				$("#CDE").on('click', function() {
					var url = $(this).attr('data-url');					
					carga(url);
					$("#imagen").attr("src","../img/cambio_especialidad.jpg");
					$('#nombre').html('CAMBIO DE ESPECIALIDAD');
				})
				

//-------------------------Mantenimiento---------------------------------------------------			

				
				$("#crearcuenta").on('click', function() {
					var url = $(this).attr('data-url');
					carga2(url);
					$("#imagen2").attr("src","../img/mant.jpg");
					$('#nombre2').html('CREAR NUEVA CUENTA');
				})

				$("#agregarrazon").on('click', function() {
					var url = $(this).attr('data-url');
					carga2(url);
					$("#imagen2").attr("src","../img/reingreso.png");
					$('#nombre2').html('AGREGAR NUEVA RAZON');
				})

				$("#CVretiro").on('click', function() {
					var url = $(this).attr('data-url');
					carga2(url);
					$("#imagen2").attr("src","../img/Udo.jpg");
					$('#nombre2').html('CAMBIAR VALORES DE DECISIONES DE RETIROS');
				})

				$("#CVcambio").on('click', function() {
					var url = $(this).attr('data-url');
					carga2(url);
					$("#imagen2").attr("src","../img/cambio_especialidad.jpg");
					$('#nombre2').html('CAMBIAR VALORES DE DECISIONES DE CAMBIOS');
				})	

				$("#CVreingreso").on('click', function() {
					var url = $(this).attr('data-url');
					carga2(url);
					$("#imagen2").attr("src","../img/Udo.jpg");
					$('#nombre2').html('CAMBIAR VALORES DE DECISIONES DE REINGRESOS');
				})	

});				

			function carga(pagina,img){				
				$("#principal").load(pagina);	
			};

			function carga2(pagina,img){				
				$("#principal2").load(pagina);
			};
				

		
				