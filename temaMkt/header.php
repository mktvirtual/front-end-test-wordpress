<!DOCTYPE html>
<html>
	<!-- todas as funcoes bloginfo() sao funcoes do wordpress pra facilitar nossa vida-->
	<head>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>"/>
		<meta charset="<?php bloginfo('charst'); ?>">
		<!--pra design responsivo -->
		<meta name="viewport" content="width=device-width, initial-scale: 1.0">
		<!--icones-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<!--fonte-->
		<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>

		<script type="text/javascript" src="http://localhost:8080/wordpress/wp-content/themes/temaMKT/jquery-1.12.1.js"></script>
		<script type="text/javascript" src="http://localhost:8080/wordpress/wp-content/themes/temaMKT/custom.js"></script>

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
				map.setZoom(13);
 
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

	<!-- cabecalho um com menu e botao buscar-->
		<div class="container-btn">	
			<span class="btn-nav"></span>
			<form class="input-busca"><input type="text" name="btnbuscar" id="btnbuscar" value="Busca" align="center"><span class="icon"><i class="fa fa-search"></i></span></form>
		</div>
	<header class="firstheader">

		<nav class="cabecalho">
			<ul>
				<li><a href="#">Peça seu cartão de cliente</a></li>
				<li><a href="#"><i class="fa fa-barcode"></i> &nbsp;Solicite a 2º via do boleto</a></li>
				<li><a href="#">Encontre uma loja</a></li>
				<li><a href="#">Assine a newsletter</a></li>
				<li class="hidebtnbuscar"><form><input type="text" name="btnbuscar" id="btnbuscar" value="Busca" align="center"><span class="icon"><i class="fa fa-search"></i></span></form></li>
			</ul>
		</nav>

	</header>

<!--  plano de fundo e menu de navegação principal-->
	<div class="container-btnmenu">
		<img src="http://localhost:8080/wordpress/wp-content/uploads/2016/03/logo.png">
		<span class="btn-menu"></span>
	</div>
	<!-- *****************************************************************************************************************************************
	*************************************************************************************************************************************************
	Menu com tela grande-->
	<nav class="main-menu">
		
		<section class="nav-menu">
			<ul>
				<li><a href="#">Promoções</a></li>
				<li><a href="#">Casa</a></li>
				<li><a href="#">Kids</a></li>
				<li><a href="#">Masculino</a></li>
				<li><a href="#">Feminino</a></li>
				<li><a href="#">Campanhas</a></li>
			</ul>
			<a href="#"><img src="http://localhost:8080/wordpress/wp-content/uploads/2016/03/logo.png"></a>
		</section>

	</nav>
<!-- *****************************************************************************************************************************************
	*************************************************************************************************************************************************
	Menu mobile-->

<nav class="main-menumobile">
		
		<section class="nav-menumobile">
			<ul>
				<li><a href="#">Promoções</a></li>
				<li><a href="#">Casa</a></li>
				<li><a href="#">Kids</a></li>
				<li><a href="#">Masculino</a></li>
				<li><a href="#">Feminino</a></li>
				<li><a href="#">Campanhas</a></li>
			</ul>
		</section>

	</nav>

	<div class="nav-img"><img src="http://localhost:8080/wordpress/wp-content/uploads/2016/03/mulher.png"></div>