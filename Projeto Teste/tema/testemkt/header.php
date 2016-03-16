<html>
	<head>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>
		<title><?php wp_title('TesteMkt'); ?></title>
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>"/>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
	</head>
	<body>
		<header class="cabecalho">
			<div class="cabecalho">
				<!-- botao que aparece ao se ajustar a uma tela pequena. -->
				<button class="btn-menu"><i class="fa fa-bars fa-lg"></i></button>
				<i class="fa fa-search" id="buscar"></i><input type="buscar" id="buscar-input"name="buscar" placeholder="Buscar">
				<a href="#">Assine a newsletter</a>
				<a href="#">Encontre uma loja</a>
				<a href="#"><i class="fa fa-barcode" id="boleto"></i>&nbsp;Solicite a 2° via do boleto</a>
				<a href="#">Peça seu cartão de cliente</a>
			</div>
		</header>
		<!-- banner da modelo-->
		<div class="banner container">
			<header>
			<!-- logotipo -->
			<a href="index.html"><h1 class="logo"> Teste mkt </h1></a>
			<!-- menu que aparece ao clicar no botão -->
			<nav class="menu">
				<a class="btn-close" id="btn-close"><i class="fa fa-times"></i></a>
				<ul>
					<li><a href="#">CAMPANHAS</a></li>
					<li><a href="#">FEMININO</a></li>
					<li><a href="#">MASCULINO</a></li>
					<li><a href="#">KIDS</a></li>
					<li><a href="#">CASA</a></li>
					<li><a href="#">PROMOÇÕES</a></li>
					<li id="assine"><a href="#">ASSINE A NEWSLETTER</a></li>
					<li id="loja"><a href="#">ENCONTRE UMA LOJA</a></li>
					<li id="boleto2"><a href="#"><i class="fa fa-barcode" id="boleto"></i>&nbsp;SOLICITE A 2º VIA DO BOLETO</a></li>
					<li id="cartao"><a href="#">PEÇA SEU CARTÃO DE CLIENTE</a></li>	
				</ul>		
			</nav>
		</header>
		</div>
	</body>
</html>