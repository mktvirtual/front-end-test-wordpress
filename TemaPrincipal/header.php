<!DOCTYPE html>
<html>
	<!-- todas as funcoes bloginfo() sao funcoes do wordpress pra facilitar nossa vida-->
	<head>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>"/>
		<meta charset="<?php bloginfo('charst'); ?>">
		<!-- alguma coisa pra design responsivo -->
		<meta name="viewport" content="width=device-width, initial-scale: 1.0">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
		<script type="text/javascript" language="javascript">
 
			var map = null; 
			function chamaMapa()
			{
			 
			 	//DEFINE AS COORDENADAS DA RUA OU AVENIDA
			var latlng = new google.maps.LatLng(-23.9539652, -46.3345953); //DEFINE A LOCALIZAÇÃO EXATA DO MAPA
 
			    var myOptions = {
					zoom: 12,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
 
				//CRIANDO O MAPA
				map = new google.maps.Map( document.getElementById("map_canvas") , myOptions );
 
				//DEFINE AS COORDENADAS DA RUA OU AVENIDA - CENTRALIZAÇÃO DO MAPA
				map.setCenter( new google.maps.LatLng(-23.9539652, -46.3345953) );
 
				//MUDANDO O ZOOM DO MAPA
				map.setZoom(17);
 
				//MUDANDO O TIPO DO MAPA - NESSA FORMA, ESTÁ DEFINIDO O FORMATO MAPA
				map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
 
				//INSERINDO O MARCARDOR
				// ESSE CÓDIGO VAI COLOCAR UM ÍCONE DE MARCAÇÃO NO LOCAL EXATO DA SUA EMPRESA
				var endereco = '7º andar,R. Dr. Carvalho de Mendonça, 238 - Vila Belmiro,Santos - SP,11070-101';
				geocoder = new google.maps.Geocoder();     
				geocoder.geocode({'address':endereco}, function(results, status){
					if( status = google.maps.GeocoderStatus.OK){
						latlng = results[0].geometry.location;
						markerInicio = new google.maps.Marker({position: latlng,map: map});    
						map.setCenter(latlng);
					}
				});
			 	
			}
			 
		</script>

		<title>MKT</title>

	</head>
	<body onload="chamaMapa();">
		<!-- cabecalho-->
		<div class="site-header">
			
			<form>
				<img class="logotopo" src="http://localhost:8080/wordpress/wp-content/uploads/2016/02/m2.jpg">
				<input type="text" name="buscar" placeholder="Busque no site">
				<button>Buscar</button>
			</form>
		</div>

		<!--menu-->
		<div class="container">
			<button class="btn-menu"></button>
			<nav class="menu">
			  
			  <a class="btn-close">x</a>
			  <ul>
			    <li><a href="#">Conheça o Magic</a></li>
			    <li><a href="#">Aprenda a jogar</a></li>
			    <li><a href="#">Friday Night Magic</a></li>
			    <li><a href="#">Sua loja mais próxima</a></li>
			    <li><a href="#">Sobre a história de Magic</a></li>
			  </ul>

			</nav>
			</div>

			<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
		<script>
		//abre o menu
			$(".btn-menu").click(function(){
				$(".menu").show();
			});
			//esconde o menu
			$(".btn-close").click(function(){
				$(".menu").hide();
			});
		</script>

				<!--<?php wp_nav_menu (array('theme_location' => 'main-menu')); ?> -->
