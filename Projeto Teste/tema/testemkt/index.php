<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link href='https://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
		<link rel="icon" href="img/icon.png">
	</head>
	<body>
		<?php get_header();?>

		<main class="servicos container">
			<!-- cada article abaixo serve para informar um conteudo.-->
			<article class="servico bg-white radius">
				<a href="#"><img src="http://treinarmkt.16mb.com/wp-content/uploads/2016/03/frutas.jpg" alt="Frutas"></a>
			</article>
			<article class="servico bg-white radius">
				<a href="#"><input type="button" value="SAIBA MAIS" id="saiba"></a>
				<a href="#"><img src="http://treinarmkt.16mb.com/wp-content/uploads/2016/03/ruiva.jpg" alt="Ruiva"></a>
			</article>
			<article class="servico bg-white radius">
				<a href="#"><input type="button" value="CONTINUE LENDO" id="saiba"></a>
				<a href="#"><img src="http://treinarmkt.16mb.com/wp-content/uploads/2016/03/bob.jpg" alt="Bob Esponja"></a>
			</article>
			<article class="servico bg-white radius">
				<a href="#"><input type="button" value="SAIBA MAIS" id="saiba"></a>
				<a href="#"><img src="http://treinarmkt.16mb.com/wp-content/uploads/2016/03/moda.jpg" alt="Moda"></a>
			</article>
			<article class="servico bg-white radius">
				<a href="#"><input type="button" value="SAIBA MAIS" id="saiba"></a>
				<a href="#"><img src="http://treinarmkt.16mb.com/wp-content/uploads/2016/03/beleza.jpg" alt="Beleza"></a>
			</article>
		</main>
		<div class="mapa container">
			
		</div>
		<!--NEWSLETTER-->
		<div class="newsletter container">
			<div class="icone">
				<h2>ASSINE A NEWSLETTER DO LOGO</h2>
				<form>
					<input type="email" name="email" placeholder="Seu e-mail">
					<a href="#"><i class="fa fa-check"></i></a>	
				</form>
			</div>
			<!-- REDES SOCIAIS -->
			<div class="social-icons">
				<h2>SIGA LOJAS LOGO NAS REDES SOCIAIS</h2>	
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-youtube-play"></i></a>
				<a href="#"><i class="fa fa-instagram"></i></a>			
			</div>
		</div>	

		<?php get_footer();?>

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