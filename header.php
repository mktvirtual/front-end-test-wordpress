<!DOCTYPE html>
<html>
<head>
	<title>Logo</title>
	<meta charset="utf-8" />
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<?php do_action( 'wp_enqueue_styles_and_scripts' ); ?>
	<?php wp_head(); ?>
	<script>
</script>
</head>
<body>
	<header>
		<div id="top-bar" class="orange">
			<ul id="top-menu" class="ul-horizontal-menu central text-right">
				<li><a href="#">Peça seu Cartão de Cliente</li></a>
				<li><a href="#"><span class="barcode-white-icon"></span>Solicite a 2ª via do boleto</li></a>
				<li><a href="#">Encontre uma loja</li></a>
				<li><a href="#">Assine a newsletter</li></a>
				<li class="input-wrapper"><input type="text" placeholder="Busca" /><input type="submit" /></li>
			</ul>
		</div>
		<div class="menu">
			<div class="central">
				<img src="<?php echo get_template_directory_uri() ?>/img/logo.png" alt="Lojas Logo" />
				<div class="menu-right text-right col">
					<ul class="ul-horizontal-menu" id="main-menu">
						<li>CAMPANHAS</li>
						<li>MASCULINO</li>
						<li>FEMININO</li>
						<li>KIDS</li>
						<li>CASA</li>
						<li>PROMOÇÕES</li>
					</ul>
				</div>
			</div>
		</div>
	</header>