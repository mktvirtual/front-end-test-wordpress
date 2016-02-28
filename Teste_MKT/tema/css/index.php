<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>testemkt</title>
		<meta name="description" content="teste para a mkt virtual">
		<meta name="keywords" content="teste, mkt virtual, mkt">
		<meta name="robots" content="index, follow">
		<meta name="author" content="Murillo Santos">
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link href='https://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
		<link rel="icon" href="http://treinarmkt.16mb.com/wp-content/uploads/2016/02/icon.png">
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
 		<script type="text/javascript" language="javascript">
 			var mapa = null;

 			function chamaMapa()
 			{
 				//definindo as coordenadas de ruas e localizações.
				var latlng = new google.maps.LatLng(17.585056, -37.836045);
 
			    	var myOptions = {
					zoom: 12,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
 
				//criação do mapa
				map = new google.maps.Map( document.getElementById("map_canvas") , myOptions );
 
				//zoom do mapa
				map.setZoom(2);
 
				//tipo de mapa, estou definindo como visualização de satélite.
				map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
 			}

 		</script>
	</head>
	<body onload="chamaMapa();">
		<header class="cabecalho container">
			<!-- logotipo da terra no cabecalho -->
			<a href="index.html"><h1 class="logo"> Teste mkt </h1> </a>
			<!-- botao que aparece ao se ajustar a uma tela pequena. -->
			<button class="btn-menu"> <i class="fa fa-bars fa-lg"></i> </button>
			<!-- menu que aparece ao clicar no botão -->
			<nav class="menu"> 
				<a class="btn-close"><i class="fa fa-times"></i></a>
				<ul>
					<li><a href="#">Notícias</a></li>
					<li><a href="#">Sobre</a></li>
					<li><a href="#">Objetivo</a></li>
					<li><a href="#">Quem somos?</a></li>
				</ul>
			</nav>
		</header>
		<!-- banner do universo-->
		<div class="banner container">
			<div class="title">
				<h2> O pálido ponto azul </h2>
				<h3> “Considere novamente esse ponto. É aqui. É nosso lar. Somos nós. Nele, todos que você ama, todos que você conhece, todos de quem você já ouviu falar, todo ser humano que já existiu, viveram suas vidas. A totalidade de nossas alegrias e sofrimentos, milhares de religiões, ideologias e doutrinas econômicas, cada caçador e saqueador, cada herói e covarde, cada criador e destruidor da civilização, cada rei e plebeu, cada casal apaixonado, cada mãe e pai, cada crianças esperançosas, inventores e exploradores, cada educador, cada político corrupto, cada “superstar”, cada “lidere supremo”, cada santo e pecador na história da nossa espécie viveu ali, em um grão de poeira suspenso em um raio de sol.” <p>- Carl Sagan</h3>
			</div>
		</div>
		<main class="assuntos container">
			<!-- cada article abaixo serve para informar um conteudo, por exemplo, ondas gravitacionais, etc...-->
			<article class="assunto bg-white radius">
				<a href="#"><img src="http://treinarmkt.16mb.com/wp-content/uploads/2016/02/ondas_gravitacionais.jpg" alt="Ondas gravitacionais"></a>
				<div class="inner">
					<a href="#"> Ondas gravitacionais </a>
					<p>
						Onda gravitacional é a onda que transmite energia por meio de deformações no espaço-tempo, ou seja, por meio do campo gravitacional. A teoria geral da relatividade prediz que massas aceleradas podem causar este fenômeno, que se propaga com a velocidade da luz.
					</p>
				</div>
			</article>
			<article class="assunto bg-white radius">
				<a href="#"><img src="http://treinarmkt.16mb.com/wp-content/uploads/2016/02/nebulosa_olhodegato.jpg" alt="Nebulosa do olho de gato"></a>
				<div class="inner">
					<a href="#"> Nebulosa do olho de gato </a>
					<p>
						NGC 6543 ou Nebulosa do Olho de gato é uma nebulosa planetária na constelação do Dragão. Estruturalmente é uma das nebulosas mais complexas conhecidas tendo-se observado em imagens de alta resolução do Telescópio Espacial Hubble mostrando jorros de material e numerosas estruturas em forma de arco.
					</p>
				</div>
			</article>
			<article class="assunto bg-white radius">
				<a href="#"><img src="http://treinarmkt.16mb.com/wp-content/uploads/2016/02/supernova.jpg" alt="Supernova"></a>
				<div class="inner">
					<a href="#"> Supernova </a>
					<p>
						Supernova é o nome dado aos corpos celestes surgidos após as explosões de estrelas (estimativa) com mais de 10 massas solares, que produzem objetos extremamente brilhantes, os quais declinam até se tornarem invisíveis, passadas algumas semanas ou meses. Em apenas alguns dias o seu brilho pode intensificar-se em 1 bilhão de vezes a partir de seu estado original, tornando a estrela tão brilhante quanto uma galáxia, mas, com o passar do tempo, sua temperatura e brilho diminuem até chegarem a um grau inferior aos primeiros.
					</p>
				</div>
			</article>
		</main>
		<!-- DIV QUE CHAMA O MAPA -->
		<div id="map_canvas" style="width: 100%; height: 400px"></div>
		<!--NEWSLETTER-->
		<div class="newsletter container bg-black">
			<h2> Inscreva-se agora! </h2>
			<h3> Receba novidades e muitas notícias sobre o universo. </h3>
			<form>
				<input class="bg-black radius" type="email" name="email" placeholder="Seu e-mail">
				<button class="bg-white radius"> Cadastrar </button>
			</form>
		</div>
		<!-- RODAPÉ -->
		<footer class="rodape container">
			<div class="social-icons">
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-google"></i></a>
				<a href="#"><i class="fa fa-instagram"></i></a>
				<a href="#"><i class="fa fa-envelope"></i></a>
			</div>
			<p class="copyright">
				Copyright @ Murillo 2016. Todos os direitos reservados.
			</p>
		</footer>
		<!-- JQuery -->
		<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
		<script>
			$(".btn-menu").click(function(){
				$(".menu").show();
			});
			$(".btn-close").click(function(){
				$(".menu").hide();
			});
		</script>
	</body>
</html>